var Carousel = (function ($) {

	var settings = {
			container: $( ".carousel" ),
			slides: $(".carousel_list_item"),
			descriptions: $(".carousel_list_item_desc"),
			links: $(".carousel_list_item_link"),
			activeClass: "carousel_list_item-active",
            width:$(".carousel_list_item").width(),
	    	height:$(".carousel_list_item").height(),
	    	aspectRatio: 2.083333,
	    	medmq: window.matchMedia( "(max-width: 47.5em)" ),
	    	transition: 5000,
	    	currentSlide: 0
		},
		publicSettings = {}

//****** PUBLIC METHODS *********************************************** //
	
	publicSettings.init = function(){

		var anim = setInterval(animation, settings.transition);

		if(!settings.medmq.matches){
			centreText(settings.height);
			centerLinks(settings.width);
			resizeContainer(settings.aspectRatio);
		}
		else{
			resizeContainer(settings.aspectRatio);
			resizeImage(true);
		}

		$(window).resize(function(){
			if(!settings.medmq.matches){
				resizeImage(false);
				resizeContainer(settings.aspectRatio);
				linkWrap(settings.medmq, settings.slides);
				centreText(settings.slides.height());
				centerLinks(settings.slides.width());

				settings.container.hover( 
					function(){
						clearInterval(animation);
					}, 
					function(){
						animation = setInterval(animation, settings.transition);
					}
				);

			}
			else{
				resizeImage(true);
				resizeContainer(settings.aspectRatio);
				linkWrap(settings.medmq, settings.slides);
				addImage();
			}
		});

		//Allows user to click on left arrow to go back a slide

		$(".carousel_controls-left").bind("click", leftSlide);
		$(".carousel_controls-right").bind("click", rightSlide);
		if (Modernizr.touch) {   
    		//console.log('Touch Screen');  
		}
	};


//****** PRIVATE METHODS ********************************************** //

	//Centres a slides description in relation to the slide and then displays it.
	function centreText(height) {
		settings.descriptions.each(function(){
			var newHeight = (height - $( this ).height()) / 2;
			$( this ).css( "top", newHeight ).show();
		});
	};
	//Centres the links associated with each slide that has one and then displays it.
	function centerLinks(width){
		settings.links.each(function(){
				var newWidth = (width - $( this ).outerWidth()) / 2;
				if(!settings.medmq.matches){
					$( this ).css("left", newWidth).show();
				}else{
					$( this ).hide();
				}
		});
	}

	/* 
		Adds css class to next slide and removes from previous in order to display the next slide.
	   	A counter is also incremented each time to keep track of the current slide and when it reaches
	   	the end of slides it resets the counter and makes the first slide active again. 
	   	This animation is used when the full website is being viewed.
	*/
	function animation(){
		var nextSlide = settings.currentSlide + 1;
		if(!settings.medmq.matches){
			//console.log("big");
			if(settings.currentSlide < settings.slides.length - 1){	
				settings.slides.eq(nextSlide).addClass(settings.activeClass);
				settings.slides.eq(settings.currentSlide).removeClass(settings.activeClass);
				settings.currentSlide++;
			}
			else{
				settings.currentSlide = 0;
				settings.slides.eq(settings.currentSlide).addClass(settings.activeClass);
				settings.slides.last().removeClass(settings.activeClass);
			}
			//console.log(settings.currentSlide);
		}
		else{
			//console.log("small");
		}
	};


	//Resizes the carousel container's height in proportion to its width
	function resizeContainer(val){
		var resizedWidth = settings.container.width();
		var resizedHeight = resizedWidth / val;
		settings.container.height(resizedHeight);
	};

	function resizeImage(val){
			if(val){
				var resizedWidth = settings.container.width();
				$(".carousel_list_item img").each(function(){
					$(this).width(resizedWidth);
				});
			}
			else{
				$(".carousel_list_item img").each(function(){
					$(this).css("width", "");
				});
			}
	}

	function addImage(){
		var newImage = settings.slides[0];
		console.log(settings.slides);
		settings.slides.append(newImage);
	}

	function removeImage(){}


	//Slides with a link are wrapped in that link if the viewport is below 47.5em.
	function linkWrap(mq, slides){
		var slideLinks =  slides.find('a');

		if(mq.matches){
			slideLinks.each(function(){
				var link = $(this).attr("href");
				if(!$(this).parent().parent().is("a")){
						$(this).parent().wrap('<a href="'+link+'"></a>');
				}
			});
		}
		else{
			slideLinks.each(function(){
				if($(this).parent().parent().is("a")){
					$(this).parent().unwrap();
				}
			});
		}
	};

	function leftSlide(){
		if(settings.currentSlide !== 0){
			$(".carousel_controls-left").unbind("click");
			settings.slides.eq(settings.currentSlide).removeClass("carousel_list_item-active");
			settings.slides.eq(settings.currentSlide).prev().addClass("carousel_list_item-active");
			settings.currentSlide--;
		}
		else{
			settings.slides.eq(settings.currentSlide).removeClass("carousel_list_item-active");
			settings.currentSlide = settings.slides.length - 1;
			settings.slides.eq(settings.currentSlide).addClass("carousel_list_item-active");
		}
		$(".carousel_controls-left").bind("click", leftSlide);
	}

	function rightSlide(){
		if(settings.currentSlide !== settings.slides.length - 1 ){
			$(".carousel_controls-right").unbind("click");
			settings.slides.eq(settings.currentSlide).removeClass("carousel_list_item-active");
			settings.slides.eq(settings.currentSlide).next().addClass("carousel_list_item-active");
			settings.currentSlide++;
		}
		else{
			settings.slides.eq(settings.currentSlide).removeClass("carousel_list_item-active");
			settings.currentSlide = 0;
			settings.slides.eq(settings.currentSlide).addClass("carousel_list_item-active");
		}
		$(".carousel_controls-right").bind("click", rightSlide);
	}

	return publicSettings;

})(jQuery);




/*var mobile = (function(Carousel){

	Carousel.mobile = function(){
		alert("MOBILE");
	}

	return Carousel;

})(Carousel || {});*/

//myFunction();

//if (window.matchMedia( "(min-width: 47.5em)" ).matches){
	Carousel.init();
//}
var global = (function(){

})();


var Helper = (function(){

  // Shim for requestAnimationFrame from Paul Irishpaul ir
  // http://www.paulirish.com/2011/requestanimationframe-for-smart-animating/
  window.requestAnimFrame = (function(){
    return  window.requestAnimationFrame  ||
            window.webkitRequestAnimationFrame    ||
            window.mozRequestAnimationFrame       ||
            function( callback ){
              window.setTimeout(callback, 1000 / 60);
            };
  })();

  function toggleClass(element, cls){
    if( document.documentElement.classList ){
      element.classList.toggle(cls);
    }
    else{
      var rx = new RegExp(cls,'');
      if(rx.test(element.className)){
        element.className = element.className.replace(rx,'');
      }
      else{
        element.className += " "+cls;
      }
    }
  }

  function addClass(element,cls){
    if( document.documentElement.classList ){
      if( !element.classList.contains(cls) ){
        element.classList.add(cls);
      }
    }
    else{
      var rx = new RegExp(cls,'');
      if( !rx.test(element.className) ){
        element.className += " "+cls;
      }
    }
  }

  function removeClass(element,cls){
    if( document.documentElement.classList ){
      if( element.classList.contains(cls) ){
        element.classList.remove(cls);
      }
    }
    else{
      var rx = new RegExp(cls,'');
      if(rx.test(element.className)){
        element.className -= cls;
      }
    }
  }

  function modSVG(){
    if (!Modernizr.svg) {
        var imgs = document.getElementsByTagName('img');
        var endsWithDotSvg = /.*\.svg$/
        var i = 0;
        var l = imgs.length;
        for(; i != l; ++i) {
            if(imgs[i].src.match(endsWithDotSvg)) {
                imgs[i].src = imgs[i].src.slice(0, -3) + 'png';
            }
        }
    }
  }

  return {
    toggleClass: toggleClass,
    addClass: addClass,
    removeClass: removeClass,
    modSVG: modSVG
  };

})();

Helper.modSVG();


var Touch = (function(){
  
  var list = document.querySelectorAll('.nav_main_list, .carousel');

  function enableTouch(){
      Helper.addClass(list, "touch");
  }

  return{
    enable: enableTouch
  }

})();

var Navigation = ( function() {

  var settings = {
    nav_open: document.querySelector('.nav_main_btn-menu'),
    nav_close: document.querySelector('.nav_main_btn-close'),
    nav_list: document.querySelector('.nav_main_container'),
    openClass: "nav_main-open"
  }

  //****** PUBLIC METHODS ********************************************** //

  function publicInit(){
    settings.nav_open.addEventListener("touchstart", function(event){
      event.preventDefault();
      console.log("open");
      window.requestAnimFrame(onAnimFrame);
      document.body.style.overflowY = "hidden";
    });

    settings.nav_close.addEventListener("touchstart", function(event){
      event.preventDefault();
      console.log("close");
      window.requestAnimFrame(onAnimFrame);
      document.body.style.overflowY = "auto";
    });
  }


  //****** PRIVATE METHODS ********************************************** //


  function onAnimFrame(){
    Helper.toggleClass(settings.nav_list, settings.openClass);
  }

  function enableTouch(){
    Helper.addClass(settings.nav_list, "touch");
  }

  function runTouch(){

    var pointerDownName = 'MSPointerDown';
    var pointerUpName = 'MSPointerUp';
    var pointerMoveName = 'MSPointerMove';

    if(window.PointerEvent) {
      pointerDownName = 'pointerdown';
      pointerUpName = 'pointerup';
      pointerMoveName = 'pointermove';
    }
    
    // Simple way to check if some form of pointerevents is enabled or not
    window.PointerEventsSupport = false;
    if(window.PointerEvent || window.navigator.msPointerEnabled) {
      window.PointerEventsSupport = true;
    }

    if (window.PointerEventsSupport) {
      // Add Pointer Event Listener
      settings.nav_open.addEventListener(pointerDownName, handleGestureStart, true);
    } else {
      // Add Touch Listener
      settings.nav_open.addEventListener('touchstart', handleGestureStart, true);
    
      // Add Mouse Listener
      settings.nav_open.addEventListener('mousedown', handleGestureStart, true);
    }

     /*function getGesturePointFromEvent(evt) {
        var point = {};

        if(evt.targetTouches) {
          // Prefer Touch Events
          point.x = evt.targetTouches[0].clientX;
          point.y = evt.targetTouches[0].clientY;
        } else {
          // Either Mouse event or Pointer Event
          point.x = evt.clientX;
          point.y = evt.clientY;
        }

        return point;
      }*/

    // Handle the start of gestures
    var handleGestureStart = function(evt) {
      evt.preventDefault();

      if(evt.touches && evt.touches.length > 1) {
        return;
      }

      console.log("blah");


      /*Add the move and end listeners
      if (window.PointerEventsSupport) {
        // Pointer events are supported.
        document.addEventListener(pointerMoveName, this.handleGestureMove, true);
        document.addEventListener(pointerUpName, this.handleGestureEnd, true);
      } else {
        // Add Touch Listeners
        document.addEventListener('touchmove', this.handleGestureMove, true);
        document.addEventListener('touchend', this.handleGestureEnd, true);
        document.addEventListener('touchcancel', this.handleGestureEnd, true);
    
        // Add Mouse Listeners
        document.addEventListener('mousemove', this.handleGestureMove, true);
        document.addEventListener('mouseup', this.handleGestureEnd, true);
      }
    
      initialTouchPos = getGesturePointFromEvent(evt);
      console.log(getGesturePointFromEvent(evt));
      settings.nav_list.style.transition = 'initial';
    }.bind(this);

    this.handleGestureMove = function(evt){
      console.log("brap");
    }.bind(this);


    // Handle end gestures
    this.handleGestureEnd = function(evt) {
      evt.preventDefault();

      if(evt.touches && evt.touches.length > 0) {
        return;
      }

      isAnimating = false;
    
      // Remove Event Listeners
      if (window.PointerEventsSupport) {
        // Remove Pointer Event Listeners
        document.removeEventListener(pointerMoveName, this.handleGestureMove, true);
        document.removeEventListener(pointerUpName, this.handleGestureEnd, true);
      } else {
        // Remove Touch Listeners
        document.removeEventListener('touchmove', this.handleGestureMove, true);
        document.removeEventListener('touchend', this.handleGestureEnd, true);
        document.removeEventListener('touchcancel', this.handleGestureEnd, true);
    
        // Remove Mouse Listeners
        document.removeEventListener('mousemove', this.handleGestureMove, true);
        document.removeEventListener('mouseup', this.handleGestureEnd, true);
      }
    
      updateSwipeRestPosition();*/
    };
  }

  return {
    init: publicInit,
    enableTouch: enableTouch,
    runTouch: runTouch
  };

}());



Navigation.init();


//if(Modernizr.touch){
  //Navigation.enableTouch();
  Navigation.runTouch();
//}
// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// Place any jQuery/helper plugins in here.

var Touch = ( function() {

  var pointerDownName = 'MSPointerDown';
      var pointerUpName = 'MSPointerUp';
      var pointerMoveName = 'MSPointerMove';

      if(window.PointerEvent) {
        pointerDownName = 'pointerdown';
        pointerUpName = 'pointerup';
        pointerMoveName = 'pointermove';
      }
      
      // Simple way to check if some form of pointerevents is enabled or not
      window.PointerEventsSupport = false;
      if(window.PointerEvent || window.navigator.msPointerEnabled) {
        window.PointerEventsSupport = true;
      }

  //---------------------------------------------------------------------------

  //  PUBLIC METHODS

  //---------------------------------------------------------------------------

  function Start(evt){
    evt.preventDefault();

    if(evt.touches && evt.touches.length > 1) {
      return;
    }

    startingPos = getGesturePointFromEvent(evt);
    //console.log("start: " + startingPoint.x);

    // Add the move and end listeners
    if (window.PointerEventsSupport) {
      // Pointer events are supported.
      document.addEventListener(pointerMoveName, move, true);
      document.addEventListener(pointerUpName, end, true);
    } else {
      // Add Touch Listeners
      document.addEventListener('touchmove', move, true);
      document.addEventListener('touchend', end, true);
      //document.addEventListener('touchcancel', cancel, true);

      // Add Mouse Listeners
      document.addEventListener('mousemove', move, true);
      document.addEventListener('mouseup', end, true);
    }

  }; // END START METHOD


  return {
  };

}());
