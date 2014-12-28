;(function(){

  var message = function($, yo){

    var _tpl =
      '<div data-id="{instanceId}">'+
        '<textarea class="form-control" data-role="message"></textarea>'+
        '<button class="btn btn-success" data-role="submit"></button>'+
      '</div>',


    module = function(options)
    {
        var $this = this

        $this.options = options
        $this.options.instanceId || ($this.instanceId = Math.random().toString())


      $this.dom = {
          node: $(yo.render(_tpl, $this.options)),
          message: $(_tpl).find('[data-role="message"]'),
          submit: $(_tpl).find('[data-role="submit"]')
        }

        options.container && $(options.container).html($this.dom.node)

        $this.dom.submit.on('click', function(ev){
          $this.send()
        })

        $this.dom.message.on('change', function(ev){
          $this.options.canSend = $this.validate();
          $this.options.canSend? $this.dom.submit.enable() : $this.dom.submit.disable()
        })
    }

    $.extend(module.prototype, {

        dom: {},
        instanceId: null,

        send: function() {

          if (!this.options.canSend) return

          var request = this.options.params
          request.message = this.dom.message.value
          yo.request(this.options.url, request)
        },

        validate: function() {
          return this.dom.message.value.trim() != '';
        }
    })

    return module
  }

  if (window['define']) {
    define(['jquery', 'yo'], message);
  } else {
    window.yo.widget.messenger = message;
  }

})()