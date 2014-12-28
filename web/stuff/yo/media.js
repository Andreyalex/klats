
define(['yo', 'yo/messenger'], function(yo, messenger){

    var $ = jQuery; // assume that jq is already loaded. It is loaded
    /**
     * Cart constructor
     * @param options
     */
    var module = function(options)
    {
        var $this = this;

        $('body').append(this.tpl);

        options.domNode && (this.domNode = $(options.domNode))

        $('body').on('click', '.media-entity', function(ev){
            ev.preventDefault()
            $this.show(this)
        });

        $('body').on('click', '#modal-fullscreen .close', function(ev){
            ev.preventDefault()
            $this.close()
        });
    }


    /**
     * Cart's own props and methods
     */
    $.extend(module.prototype, {

        domNode: null,

        tpl: '<div id="modal-fullscreen"><div class="background"></div><div class="content"></div><div class="close">X</div></div>',

        show: function(control)
        {
            var $this = this;
            var src = $(control).attr('href')+'?tmpl=modal'
            $.get(src, function(html){
                $($this.domNode).find('.content').html(html)
            })

            $($this.domNode).css('display', 'block')
            setTimeout(function(){
                $($this.domNode).addClass('visible')
                $('body').css('overflow', 'hidden')
            },10)
        },

        close: function()
        {
            var $this = this;
            $($this.domNode).removeClass('visible')
            setTimeout(function(){
                $($this.domNode).css('display', 'none')
                $($this.domNode).find('.content').html('')
            }, 1000);

            $('body').css('overflow', 'auto')
        }
    })

    return module
})