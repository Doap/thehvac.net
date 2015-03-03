/* add arrow to the drop down */
function Mx_nav(){
    jQuery(".nav li ul").prev().addClass('add-arrow')
    jQuery(".nav li ul li ul").prev().removeClass('add-arrow').addClass('add-arrow-right')
/*
	jQuery(".nav ul").css({display: "none"}); // Opera Fix
	jQuery(".nav li").hover(function(){
         jQuery(this).find('ul:first').css({visibility: "visible",display: "none"}).show(200);

           },function(){
                jQuery(this).find('ul:first').css({visibility: "hidden"});
    });*/
}   
jQuery(window).load(function(){                   
	    Mx_nav();
	});