/**
 * Created with JetBrains PhpStorm.
 * User: Bee
 * Date: 13.10.13
 * Time: 18:04
 * To change this template use File | Settings | File Templates.
 */

;(function(){

  yo.widget.images = function() {}

  jQuery.merge(yo.widget.images.prototype, {

    api:{},
    entityId: null,
    view: null,
    items: null,
    uploadControl: null,
    itemTemplate:
      '<li class="item {item.class}" data-id="{item.id}">'+
        '<img src="{item.path}"><span class="remove">X</span>'+
        '</li>',

    init: function(options)
    {
      var $this = this;

      this.view          = $(options.view);
      this.uploadControl = $(options.uploadControl);
      this.items          = options.items || [];
      this.entityId      = options.entityId;
      this.api           = options.api;


      this.uploadControl.fileupload({
        url: this.api.add,
        dataType: 'json',
        singleFileUploads: false,
        done: function (e, data)
        {
          $this.unblockUI();

          var res = data.result;

          if (!res.status) {
            var message = res.messages || 'An error occured. Please try agail later'
            $this.showMessages(message, 'error');
            return;
          }

          $this.addItems(res.data);
          $this.showMessages('Image uploaded successfully', 'message')
        },
        error: function(err) {

          $this.unblockUI();
          $this.showMessages('An error occured please try again later.', 'error')

          var
            msg = err.statusText,
            data = {
              responseText: err.responseText,
              httpCode: err.status
            }
          yo.log(msg, 'error', data);

        }
      });

      this.uploadControl.bind('fileuploadsend', function(){
        $this.blockUI();
      })

      this.view.find('.pane-images').sortable({
        'stop': $this.saveOrder
      });

      this.view.find('.pane-images').disableSelection();

      this.render();
    },

    addItems: function(items) {
      this.setItems(
        $.merge(this.getItems(), items || [])
      );

      this.render();
    },

    deleteItem: function(id)
    {
      var $this = this;

      $.ajax({
        type: 'POST',
        url: this.api.delete,
        dataType: 'json',
        data: {
          'task': 'product.deleteMedia',
          'format': 'json',
          'id': id
        },
        success: function(res)
        {
          $this.unblockUI();

          if (!res.status) {
            var message = res.messages || 'An error occured. Please try agail later'
            $this.showMessages(message, 'error');
            return;
          }

          var items    = $this.getItems(),
            newItems = [],
            ids      = [];

          // get ids
          $.each(res.data, function(idx, item){
            ids.push(item.id);
          })

          $.each(items, function(idx, item){
            if ($.inArray(item.id, ids) == -1)
              newItems.push(item);
          })

          $this.setItems(newItems);
          $this.render();
          $this.unblockUI();
        }
      });

      $this.blockUI();
    },

    titleItem: function(id)
    {
      var $this = this;

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
          $this.unblockUI();

          if (!res.status) {
            var message = res.messages || 'An error occured. Please try agail later'
            $this.showMessages(message, 'error');
            return;
          }

          var
            localItems = $this.getItems(),
            data = res.data[0];

          $.each(localItems, function(idx, item){
            if (item.id == data.id) {
              localItems[idx]['is_title'] = 1;
            } else {
              localItems[idx]['is_title'] = 0;
            }
          })

          $this.setItems(localItems);
          $this.render();
          $this.unblockUI();
        }
      });

      this.blockUI();
    },

    render: function()
    {
      var
        items = this.getItems(),
        html = '',
        $this = this;

      $.each(items, function(idx, item){

        var reps = {
          'item.id':  item['id'],
          'item.path': item['path_prev'],
          'item.class': (item['is_title']==1 ? ' title' : '')
        };

        html += "\n" + this.itemTemplate.replace(/{([^}]+)}/g, function(found, key){
          return (typeof reps[key] != 'undefined')? reps[key] : found;
        });
      });

      this.view.find('.pane-images').html(html);

      this.view.find('.remove').on('click', function(){
        $this.deleteItem($(this).parent().attr('data-id'));
      })
      this.view.find('.main').on('click', function(){
        $this.titleItem($(this).parent().attr('data-id'));
      })
    },

    getItems: function()
    {
      return this.items;
    },

    setItems: function(items)
    {
      this.items = items;
    },

    blockUI: function(messages){
      messages || (messages = ['Подождите...']);
      this.view.find('.pane-block > div').html(messages.join("<br/>"));
      this.view.addClass('blocked');
      yo.trigger('start.process');
    },

    unblockUI: function(){
      this.view.removeClass('blocked');
      yo.trigger('done.process');
    },

    showMessages: function(message, type){
      (typeof message !== 'string') && (message = message.join(', '))
      yo.trigger(type+'.notify', message);
    },

    saveOrder: function() {

      var ids = [], $this = this
      this.view.find('.pane-images .item').each(function(idx, item){
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
          'id': this.entityId
        },
        success: function(res)
        {
          yo.trigger('done.process');

          if (!res.status) {
            var message = res.messages || 'An error occured. Please try agail later'
            $this.showMessages(message, 'error');
            return;
          }
        }
      });

      yo.trigger('start.process');
    }
  })
})()
