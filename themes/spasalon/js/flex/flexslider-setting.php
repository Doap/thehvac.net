 <?php require_once('../../../../../wp-load.php');
$current_options=get_option('spa_theme_options');
//print_r($current_options);
$animation=$current_options['slide_effect_main']; // possible values 'flex' or 'slide'
$animation_speed_main=$current_options['animation_speed_main'];
$auto_slide=$current_options['auto_slide_interval_main'];
?>
 
 

 jQuery(window).load(function(){
    
      
       jQuery('#slider').flexslider({
        animation: "<?php echo $animation; ?>",
        controlNav: true,
        animationLoop: true,
        slideshow: true,
		
		  	animationSpeed:"<?php echo $animation_speed_main; ?>",
		slideshowSpeed:"<?php echo $auto_slide; ?>",
        sync: "#carousel",
        start: function(slider){
          jQuery('body').removeClass('loading');
        }
      });
    });



	

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