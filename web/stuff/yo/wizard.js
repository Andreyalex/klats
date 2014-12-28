/**
 * Created with JetBrains PhpStorm.
 * User: Bee
 * Date: 15.11.13
 * Time: 2:47
 * To change this template use File | Settings | File Templates.
 */
define(['jquery', 'yo'], function($, yo){

    /**
     * Form constructor
     * @param options
     */

    var
        _step = 1, _domNode

    module = function(options)
    {
        var $this = this;

        if(options) {
            options.step && (_step = options.step)
            options.domNode && (_domNode = options.domNode)
        }

        $(_domNode).on('click', '.next', function(){
            $this.next();
        })

        $(_domNode).on('click', '.prev', function(){
            $this.prev();
        })

        //$(_domNode).find('[class*="step"]').css('display', 'none');
        //$this.showStep(_step);
    }

    $.extend(module.prototype, {

        next: function()
        {
            var $this = this
            $this.hideStep(_step)
            _step++
            setTimeout(function(){ $this.showStep(_step) }, 500)
        },

        prev: function()
        {
            var $this = this
            $this.hideStep(_step)
            _step--
            setTimeout(function(){ $this.showStep(_step) }, 500)
        },

        hideStep: function(step)
        {
            $(_domNode).find('.step'+step).fadeOut();
        },

        showStep: function(step)
        {
            $(_domNode).find('.step'+step).fadeIn();
        }
    })

    return module
})
