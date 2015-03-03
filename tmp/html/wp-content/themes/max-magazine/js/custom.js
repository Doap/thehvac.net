jQuery(document).ready(function(){


	/*= main menu
	------------------------*/
    function init_nav(){
      		
		jQuery('#nav .menu').mobileMenu({
			defaultText: 'Navigate to...',
			className: 'select-menu',
			subMenuDash: '&nbsp;&nbsp;&nbsp;&ndash;'
		});
	
		jQuery("#nav ul.menu").superfish({
			delay:         140,
			animation:   {opacity:'show',height:'show'},
			speed:       'normal',
			autoArrows:  true,  
			dropShadows: false  
		}); 

    }
    init_nav();
		
	
	jQuery(".carousel-posts").jCarouselLite({
       		btnNext: ".next",
			btnPrev: ".prev",
			visible: 3,
			auto: 5000 
   	});	
	
	jQuery('#sidebar').masonry({
		itemSelector: '.widget'
	});
	
	
	jQuery('#featured-categories .category:odd').addClass("right-side").after('<div class="clear"></div>');

	/*= slider settings
	------------------------*/
	var buttons = { previous:jQuery('#slider .button-previous'),
						next:jQuery('#slider .button-next') };			
		 jQuery('#slider').lofJSidernews( {  interval : 4000,												
										easing			: 'easeInOutExpo',
										duration		: 1200,
										auto		 	: true,
										maxItemDisplay  : 4,
										navPosition     : 'horizontal',
										navigatorHeight : 32,
										navigatorWidth  : 80,
										mainWidth		: 630,
										buttons			: buttons 
									} );	
		
		
});

