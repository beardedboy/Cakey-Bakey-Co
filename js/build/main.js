var global = (function(){
    Modernizr.addTest('data', function () {
      var elem = document.createElement('div');
      return !!elem.dataset;
  });
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


$( document ).on( 'click', '.plus, .minus', function() {

    // Get values
    var $qty    = $( this ).closest( '.single_product_info_option_quantity' ).find( '.qty' ),
      currentVal  = parseFloat( $qty.val() ),
      max     = parseFloat( $qty.attr( 'max' ) ),
      min     = parseFloat( $qty.attr( 'min' ) ),
      step    = $qty.attr( 'step' );

    // Format values
    if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
    if ( max === '' || max === 'NaN' ) max = '';
    if ( min === '' || min === 'NaN' ) min = 0;
    if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

    // Change the value
    if ( $( this ).is( '.plus' ) ) {

      if ( max && ( max == currentVal || currentVal > max ) ) {
        $qty.val( max );
      } else {
        $qty.val( currentVal + parseFloat( step ) );
      }

    } else {

      if ( min && ( min == currentVal || currentVal < min ) ) {
        $qty.val( min );
      } else if ( currentVal > 0 ) {
        $qty.val( currentVal - parseFloat( step ) );
      }

    }

    // Trigger change event
    $qty.trigger( 'change' );
});


var dropdowns = document.querySelectorAll('.single_product_info_desc_container-dropdown');


for(var i = 0; i < dropdowns.length; i++){
  dropdowns[i].addEventListener("click", containerChange, true);
}
  

function containerChange(){
  var title = this.querySelector('.single_product_info_desc_title');
  var content = this.querySelector('.single_product_info_desc_content');
  
  Helper.toggleClass(content, 'visuallyhidden');
  if(Modernizr.data){
    if(title.dataset.iconafter == 'g'){
      title.dataset.iconafter = 'B';
    }
    else{
      title.dataset.iconafter = 'g';
    }
  }
  else{
    var attr = title.getAttribute('data-iconafter');

    if(attr == 'g'){
      title.setAttribute('data-iconafter', 'B');
    } 
    else{
      title.setAttribute('data-iconafter', 'g');
    }
  }

};


$('.attachment-shop_thumbnail').on('click', function(){
        var photo_fullsize =  $(this).attr('src').replace('-90x90','');
        jQuery('.woocommerce-main-image').attr('src', photo_fullsize);
        return false;
    });
