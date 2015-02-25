 
 
 
 /*jQuery use for main slider use on home page.*/
 jQuery(window).load(function(){
    
      
       jQuery('#slider').flexslider({
        animation: "slide",
        controlNav: true,
        animationLoop: true,
        slideshow: true,
        sync: "#carousel",
        start: function(slider){
          jQuery('body').removeClass('loading');
        }
      });
    });



	
/*jQuery for products thumbnail slider use on home page.*/
	 jQuery(window).load(function(){
       jQuery('.flexslider').flexslider({
        animation: "slide",
        animationLoop: true,
		slideshow:true,
        itemWidth: 233,
		itemMargin: 0,
		scroll: 1,
		min: 2,
		max: 5,
        start: function(slider){
           jQuery('body').removeClass('loading');
        }
      });
    }); 