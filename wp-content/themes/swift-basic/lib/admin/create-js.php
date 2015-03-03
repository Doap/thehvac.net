<?php
function swift_generate_js(){
	GLOBAL $wp_filesystem;
	GLOBAL $swift_options;
	GLOBAL $swift_design_options;

	$js = '';

	if( 1 || swift_is_pagetemplate_active( 'news-paper-template.php' ) || isset( $swift_options['slider_enable'] ) && $swift_options['slider_enable'] ){
		$filename = THEME_DIR . '/js/jquery.flexslider-min.js';
		$js .= $wp_filesystem->get_contents( $filename ) ;

		$js .= "/* Activating slider */ \n";
		$js .= "jQuery(window).load(function() {
				jQuery('.flexslider').flexslider({slideshowSpeed:".$swift_options['slider_speed'].",animationDuration: 600});
	});";
	}

	if( !(isset( $swift_design_options['enable_fixed_height_mag'] ) && $swift_design_options['enable_fixed_height_mag']) ){
		$filename = THEME_DIR . '/js/jquery.masonry.min.js';
		$js .= $wp_filesystem->get_contents( $filename ) ;
	}

	if( isset($swift_design_options['dropdown_animation_enable']) && $swift_design_options['dropdown_animation_enable'] ){
		$filename = THEME_DIR . '/js/dropdown-animation.js';
		//$js .= $wp_filesystem->get_contents( $filename ) ;

	}
	$filename = THEME_DIR .'/js/swift-scripts.js';
	$js .= $wp_filesystem->get_contents( $filename ) ;

	return $js;

}
?>