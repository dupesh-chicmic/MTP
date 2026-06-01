jQuery(function($){
$(document).ready(function() {
 
    $(function(){
  	$('#advanced_iframe').on('load', function(){

            sendHeight1();
          });
  
	//$('#advanced_iframe').load(function(){
    //  $(this).contents().find("body").on('click', function(event) { sendHeight(); });
    //});
        $('#advanced_iframe_2').on('load', function(){
			sendHeight2();
		});
  
  //$('#advanced_iframe_2').load(function(){
  //    $(this).contents().find("body").on('click', function(event) { sendHeight2(); });
  //  });
	
	//var iframeMobile = document.getElementById("advanced_iframe_2");
  //  iframeMobile.contentWindow.document.addEventListener('mouseup', //sendHeight2(), false);
   	
    });
});
});//jquery


function sendHeight(){
 
 jQuery(function($){
//alert( $('#advanced_iframe_2').contents().height());
   $('#advanced_iframe').height($('#advanced_iframe').contents().height());
   $('#advanced_iframe_2').height($('#advanced_iframe_2').contents().height());
   });//jquery
}

function sendHeight1(){
 jQuery(function($){
   $('#advanced_iframe').height($('#advanced_iframe').contents().height());
   });//jquery
}

function sendHeight2(){
 jQuery(function($){
   $('#advanced_iframe_2').height($('#advanced_iframe_2').contents().height());
   });//jquery
}

function setHeight(height){
 
 jQuery(function($){
//alert('set:'+height);
   $('#advanced_iframe').height(height);
   $('#advanced_iframe_2').height(height);
   });//jquery
}

function sendHeight3(){
  // alert($('#advanced_iframe_2').contents().height());
jQuery(function($){
   $('#advanced_iframe').height($('#advanced_iframe').contents().height());
  $('#advanced_iframe_2').height($('#advanced_iframe_2').contents().height());
  });//jquery
}




(function($) {

  $.fn.menumaker = function(options) {
      
      var cssmenu = $(this), settings = $.extend({
        title: "Menu",
        format: "dropdown",
        sticky: false
      }, options);

      return this.each(function() {
        cssmenu.prepend('<div id="menu-button">' + settings.title + '</div>');
        $(this).find("#menu-button").on('click', function(){
          $(this).toggleClass('menu-opened');
          var mainmenu = $(this).next('ul');
          if (mainmenu.hasClass('open')) { 
            mainmenu.hide().removeClass('open');
          }
          else {
            mainmenu.show().addClass('open');
            if (settings.format === "dropdown") {
              mainmenu.find('ul').show();
            }
          }
        });

        cssmenu.find('li ul').parent().addClass('has-sub');

        multiTg = function() {
          cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
          cssmenu.find('.submenu-button').on('click', function() {
            $(this).toggleClass('submenu-opened');
            if ($(this).siblings('ul').hasClass('open')) {
              $(this).siblings('ul').removeClass('open').hide();
            }
            else {
              $(this).siblings('ul').addClass('open').show();
            }
          });
        };

        if (settings.format === 'multitoggle') multiTg();
        else cssmenu.addClass('dropdown');

        if (settings.sticky === true) cssmenu.css('position', 'fixed');

        resizeFix = function() {
          if ($( window ).width() > 768) {
            cssmenu.find('ul').show();
          }

          if ($(window).width() <= 768) {
            cssmenu.find('ul').hide().removeClass('open');
          }
        };
        resizeFix();
        return $(window).on('resize', resizeFix);

      });
  };
})(jQuery);

(function($){
$(document).ready(function(){

$("#cssmenu").menumaker({
   title: "Menu",
   format: "multitoggle"
});

});
})(jQuery);
