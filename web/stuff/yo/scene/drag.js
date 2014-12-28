;(function($){
    
    // Drag should be singleton...

    yo.drag = new function(node, options)
    {
        var _this = this;
        
        this.state = null;
        this.dragElement = null;
        this.offsetX = null;
        this.offsetY = null;

        this._dragstart = function(ev) 
        {
            if (_this.isInDrag()) return;
            if (!ev) ev = {};
            if (ev.preventDefault) ev.preventDefault();
            
            
            _this.state = 'dragstart';
            _this.dragElement = $(this);
            
//            var offset = $(this).offset();
//            _this.offsetX = ev.pageX - $(this).offset()
            
    //            ev.currentTarget = this;
    //            ev.delegateTarget = this;
            ev.type = 'dragstart';
            $(this).trigger(ev);
        }

        this._dragmove = function(ev) 
        {
            if (!_this.isInDrag()) return;
            if (ev.preventDefault) ev.preventDefault();

            if (!ev) ev = {};

            _this.state = 'dragmove';


            var h = _this.dragElement.height();
            var w = _this.dragElement.width();
            var cur = _this.getCoords(ev);    


            $(_this.dragElement).offset({
                top: cur.top - h/2, 
                left: cur.left - w/2
            });

    //            ev.currentTarget = this;
    //            ev.delegateTarget = this;
            ev.type = 'dragmove';
            $(this).trigger(ev);
        }

        this._dragend = function(ev) 
        {
            if (!_this.isInDrag()) return;
            if (ev.preventDefault) ev.preventDefault();

            if (!ev) ev = {};

            _this.state = 'dragstop';
            _this.dragElement = null;

    //            ev.currentTarget = this;
    //            ev.delegateTarget = this;
            ev.type = 'dragstop';
            //$(this).trigger(ev);
        }

        this.isInDrag = function() {
            return _this.dragElement && (_this.state == 'dragstart' || _this.state == 'dragmove');
        }

        this.getCoords = function (e) {
            var coors = {};
            if (e.touches && e.touches.length) { 
                coors.left = e.touches[0].pageX;
                coors.top = e.touches[0].pageY;
            } else {
                if (e.originalEvent.touches && e.originalEvent.touches.length) { 
                    coors.left = e.originalEvent.touches[0].pageX;
                    coors.top = e.originalEvent.touches[0].pageY;
                } else {
                    coors.left = e.pageX;
                    coors.top = e.pageY;
                }    
            }
            return coors;
        }

        this.start = function(node, ev) {
            _this._dragstart.call(node, ev);
        }

        this.destroy = function(node)
        {
            $(node).off('mousedown touchstart', _this.dragstart);
            $(node).off('mousemove touchmove', _this.dragmove);
            $(node).off('mouseup touchend', _this.dragend);
        }

        this.create = function(node, options) {
            /* Init */
            if (!options) options = {}

            $(node).bind('mousedown touchstart', _this._dragstart);
            $(node).bind('mouseup touchend', _this._dragend);

            if (options.dragstart) $(node).bind('mousedown touchstart', options.dragstart);
            if (options.dragmove) $(node).bind('mousemove touchmove', options.dragmove);
            if (options.dragend) $(node).bind('mouseup touchend', options.dragend);
        }    

        $(document).on('mousemove touchmove', this._dragmove);
    }


    return yo.drag;
    
})(jQuery)


