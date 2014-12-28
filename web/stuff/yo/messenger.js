;(function(){

  var messenger = function($, yo){

    var _tpl =
    '<div class="alert alert-block {status}" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>{content}</div>',


    module = function(options)
    {
        var $this = this

        $this.domNode = $('<div class="messenger"></div>'),
        $('body').append($this.domNode)

        options && options.text && options.status && $this.show(options.text, options.status)
    }

    /**
     * Cart's own props and methods
     */
    $.extend(module.prototype, {

        domNode: null,

        messageId: null,

        show: function(text, status)
        {
            if (!text) return;

            text.join && (text = text.join(' '))

            var $this = this,
                className = (status=='error'? 'danger' : 'success'),
                compiled  = yo.render(_tpl, {content: text, status: 'alert-'+className}),
                messageId = Math.random(10000, 99999)

            setTimeout(function(){

                $this.domNode.html(compiled)
                $this.domNode.removeClass('hidden')
                setTimeout(function(){
                    $this.domNode.addClass('visible')
                },10)

                $this.messageId = messageId
                setTimeout(function(){
                    if ($this.messageId != messageId) return
                    $this.hide()
                },4000)
                
            }, 500);
        },

        hide: function(){
            var $this = this
            $this.domNode.removeClass('visible')
            setTimeout(function(){
                $this.domNode.addClass('hidden')
            },500)
        },

      /**
       * var m = new messenger, m.initDefaultBehavior()
       */
      initDefaultBehavior: function() {

        var messenger = this
        yo.on('message.notify', function(ev){
          messenger.show(ev.params.text, 'message');
        })

        yo.on('error.notify', function(ev){
          messenger.show(ev.params.text, 'error');
        })
      }
    })

    return module
  }

  if (window['define']) {
    define(['jquery', 'yo'], messenger);
  } else {
    window.yo.widget.messenger = messenger;
  }

})()