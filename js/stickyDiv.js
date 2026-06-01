$(document).ready(function() {  
var stickyNavTop = $("#headItems").offset().top;  
  
var stickyNav = function(){  
var scrollTop = $(window).scrollTop();  
       
if (scrollTop > stickyNavTop) {   
    $("#headItems").addClass("sticky");  
} else {  
    $("#headItems").removeClass("sticky");   
}  
};  
  
stickyNav();  
  
$(window).scroll(function() {  
    stickyNav();  
});  
});