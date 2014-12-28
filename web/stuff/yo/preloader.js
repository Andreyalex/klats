;(function(){

  var cb = function($, yo){

    var preloader = function(options)
    {
        this.domNode = $('<div class="preloader hidden"></div>')
        $('body').append(this.domNode)
    }

    /**
     * Preloader's own props and methods
     */
    $.extend(preloader.prototype, {

        domNode: null,

        messageId: null,

        show: function()
        {
            var $this = this,
                messageId = Math.random(10000, 99999)

            $this.domNode.removeClass('hidden')
            setTimeout(function(){
                $this.domNode.addClass('visible')
            },10)

            $this.messageId = messageId;
            setTimeout(function(){
                if ($this.messageId != messageId) return
                $this.hide()
            },60000)
        },

        hide: function(){
            var $this = this
            $this.domNode.removeClass('visible')
            setTimeout(function(){
                $this.domNode.addClass('hidden')
            },500)
        },

      /**
       * var p = new preloader, p.initDefaultBehavior()
       */
      initDefaultBehavior: function() {

        var preloader = this

        yo.on('start.process', function(){
          preloader.show();
        })
        yo.on('done.process', function(){
          preloader.hide();
        })
      }
    })

    return preloader
  }

  if (window['define']) {
    define(['jquery', 'yo'], cb);
  } else {
    window.yo.widget.preloader = cb;
  }

})()