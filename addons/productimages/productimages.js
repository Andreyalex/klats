/**
 * Created with JetBrains PhpStorm.
 * User: Bee
 * Date: 13.10.13
 * Time: 18:04
 * To change this template use File | Settings | File Templates.
 */

jQuery(function(){

  window.productimagesFormElement = (function($){

    var _view = null,
        _data = null,
        _uploadControl = null,
        _basePath = '/',
        _itemTemplate =
            '<li class="item {item.class}" data-id="{item.id}"><img src="{item.path}"><span class="remove">X</span><span class="main">T</span></li>',
        _productId = null;

    var module = {

        init: function(options)
        {
            _view          = $(options.view);

            _uploadControl = $(options.uploadControl);

            _data          = options.data || [];

            _basePath      = options.basePath;

            _productId     = $('[name="id"]').val();

            //_data = $(options.formElement);

            _uploadControl.click(function(){
                $('[name="task"]') && $('[name="task"]').attr('value', 'product.addMedia');
                $('[name="option"]') && $('[name="option"]').attr('value', 'com_yoshop');
            })

            _uploadControl.fileupload({
                url: '/index.php?option=com_yoshop&format=json',
                dataType: 'json',
                singleFileUploads: false,
                done: function (e, data)
                {
                    module.unblockUI();

                    var res = data.result;

                    if (!res.status) {
                        var message = res.messages || 'An error occured. Please try agail later'
                        module.showMessages(message, 'error');
                        return;
                    }

                    module.addItems(res.data);
                    module.showMessages('Image uploaded successfully', 'message')
                },
                error: function(err) {

                    module.unblockUI();
                    module.showMessages('An error occured please try again later.', 'error')

                    var
                      msg = err.statusText,
                      data = {
                        responseText: err.responseText,
                        httpCode: err.status
                      }
                    yo.log(msg, 'error', data);

                }
            });

            _uploadControl.bind('fileuploadsend', function(){
                module.blockUI();
            })

            _view.find('.pane-images').sortable({
                'stop': module.saveOrder
            });

            _view.find('.pane-images').disableSelection();

            module.render();
        },

        addItems: function(data) {
            module.setData(
                $.merge(module.getData(), data || [])
            );

            module.render();
        },

        deleteItem: function(id)
        {
            $.ajax({
                type: 'POST',
                url: '/index.php?option=com_yoshop',
                dataType: 'json',
                data: {
                    'task': 'product.deleteMedia',
                    'format': 'json',
                    'id': id
                },
                success: function(res)
                {
                    module.unblockUI();

                    if (!res.status) {
                        var message = res.messages || 'An error occured. Please try agail later'
                        module.showMessages(message, 'error');
                        return;
                    }

                    var data    = module.getData(),
                        newData = [],
                        ids     = [];

                    // get ids
                    $.each(res.data, function(idx, item){
                        ids.push(item.id);
                    })

                    $.each(data, function(idx, item){
                        if ($.inArray(item.id, ids) == -1)
                            newData.push(item);
                    })

                    module.setData(newData);
                    module.render();
                    module.unblockUI();
                }
            });

            module.blockUI();
        },

        titleItem: function(id)
        {
            $.ajax({
                type: 'POST',
                url: '/index.php?option=com_yoshop',
                dataType: 'json',
                data: {
                    'task': 'product.titleMedia',
                    'format': 'json',
                    'id': id
                },
                success: function(res)
                {
                    module.unblockUI();

                    if (!res.status) {
                        var message = res.messages || 'An error occured. Please try agail later'
                        module.showMessages(message, 'error');
                        return;
                    }

                    var
                        localData = module.getData(),
                        data = res.data[0];

                    $.each(localData, function(idx, item){
                        if (item.id == data.id) {
                            localData[idx]['is_title'] = 1;
                        } else {
                            localData[idx]['is_title'] = 0;
                        }
                    })

                    module.setData(localData);
                    module.render();
                    module.unblockUI();
                }
            });

            module.blockUI();
        },

        render: function()
        {
            var
                data = module.getData(),
                html = '';

            $.each(data, function(idx, item){

                var reps = {
                    'item.id':  item['id'],
                    'item.path': _basePath + item['path_prev'],
                    'item.class': (item['is_title']==1 ? ' title' : '')
                };

                html += "\n" + _itemTemplate.replace(/{([^}]+)}/g, function(found, key){
                    return (typeof reps[key] != 'undefined')? reps[key] : found;
                });
            });

            _view.find('.pane-images').html(html);

            _view.find('.remove').on('click', function(){
                module.deleteItem($(this).parent().attr('data-id'));
            })
            _view.find('.main').on('click', function(){
                module.titleItem($(this).parent().attr('data-id'));
            })
        },

        getData: function()
        {
            return _data;
            //var val = _data.attr('value').replace('%22', '"');
            //return $.parseJSON(val) || [];
        },

        setData: function(data)
        {
            _data = data;
            //_data.attr('value', $.toJSON(data).replace('"', '%22') || '[]');
        },

        blockUI: function(messages){
            messages || (messages = ['Подождите...']);
            _view.find('.pane-block > div').html(messages.join("<br/>"));
            _view.addClass('blocked');
            yo.trigger('start.process');
        },

        unblockUI: function(){
            _view.removeClass('blocked');
            yo.trigger('done.process');
        },

        showMessages: function(message, type){
            (typeof message !== 'string') && (message = message.join(', '))
            yo.trigger(type+'.notify', message);
        },

        saveOrder: function() {

            var ids = []
            _view.find('.pane-images .item').each(function(idx, item){
                ids.push($(item).data('id'));
            });

            $.ajax({
                type: 'POST',
                url: '/index.php?option=com_yoshop',
                dataType: 'json',
                data: {
                    'task': 'product.saveOrderMedia',
                    'format': 'json',
                    'ids': ids,
                    'id': _productId
                },
                success: function(res)
                {
                    yo.trigger('done.process');

                    if (!res.status) {
                        var message = res.messages || 'An error occured. Please try agail later'
                        module.showMessages(message, 'error');
                        return;
                    }
                }
            });

            yo.trigger('start.process');
        }
    }

    return module;

  })(jQuery);
})
