
define(['yo', 'yo/messenger'], function(yo, messenger){

    var
        $ = jQuery,// assume that jq is already loaded. It is loaded
        _addItemUrl    = siteBaseUrl+'index.php?option=com_yoshop&format=json&task=cart.addProduct',
        _removeItemUrl = siteBaseUrl+'index.php?option=com_yoshop&format=json&task=cart.removeProduct',
    module = function(options)
    {
        var $this = this

        if (options) {
            options.domNode && ($this.domNode = $(options.domNode))
            options.products && ($this.products = $(options.products))
            options.data && ($this.data = $(options.data))
        }

        if (options.products) {

        }
        $('body').on('click',
            '[data-cart-action="add"],[data-cart-action="remove"]', function(ev){
                ev.preventDefault()
                $this.productEventHandler(this)
        })

        $this.messenger = new messenger();
    }

    /**
     * Cart's own methods
     */
    jQuery.extend(module.prototype, {

        domNode:   null,
        data:      null,
        messenger: null,

    /** @var DOMElement this */
        productEventHandler: function(control)
        {
            var $this = this,
                control = $(control),
                action  = control.attr('data-cart-action'),
                id      = control.attr('data-id')

            //$this.messenger.show('Ждем', 'info')
            action == 'add'?
                $this.addToCart(id, 1, function(res){

                    if (!res || !res.status) {
                        $this.messenger.show('Не удалось добавить товар в корзину', 'error')
                        return
                    }
                    control.parents('.item').addClass('in-cart')
                    //control.attr('data-cart-action', 'remove')
                    $this.messenger.show(';-)', 'success')
                }):

                $this.removeFromCart(id, 1, function(res){

                    if (!res || !res.status) {
                        $this.messenger.show('Не удалось удалить товар из корзины', 'error')
                        return
                    }
                    control.parents('.item').removeClass('in-cart')
                    //control.attr('data-cart-action', 'add')
                    $this.messenger.show(';-)', 'success')
                })
        },

        addToCart: function(id, count, callback)
        {
            var $this = this,
                onComplete = function(res) {
                    if (res && res.status) {
                        $this.data = res.data;
                        $this.render();
                    }
                    callback && callback(res);
                }

            $.ajax({
                url: _addItemUrl,
                type: 'post',
                data: {id: id, count: count},
                dataType: 'json',
                success: onComplete,
                error: onComplete
            })
        },

        removeFromCart: function(id, count, callback)
        {
            var $this = this,
                onComplete = function(res) {
                    if (res && res.status) {
                        $this.data = res.data;
                        $this.render();
                    }
                    callback && callback(res);
                }
            $.ajax({
                url: _removeItemUrl,
                type: 'post',
                data: {id: id, count: count},
                dataType: 'json',
                success: onComplete,
                error: onComplete
            })
        },

        /**
         * We need just to find cart items count
         * and up it. Simplest case.
         */
        render: function()
        {
            var $this = this

            /** update items count */
            $this.domNode.html($this.data.count)

            /** update controls state */
            $($this.products).each(function(){
                var item = $(this),
                    id = item.attr('data-id')
                $this.isProductInCart(id)? item.addClass('in-cart') : item.removeClass('in-cart')
            })

        },

        isProductInCart: function(pid)
        {
            var is = false
            $(this.data.products).each(function(){
                if (this.id == pid) is=true
            })
            return is
        }
    })

    return module
});
