<?php
  if(is_admin()){
  add_action('admin_menu', 'spa_admin_menu_pannel');
  function spa_admin_menu_pannel() {	
  	
  	$page=add_theme_page( __('spa','sis_spa') , __('Option Panel','sis_spa') , 'edit_theme_options', 'spa', 'spasalon_spa_option_panal_function' );	
  	$page2=add_theme_page( __('webriti_themes','sis_spa'), __('Webriti Themes','sis_spa'), 'edit_theme_options', 'webriti_themes', 'webriti_themes_function' );	
  	add_action('admin_print_styles-'.$page, 'spasalon_admin_enqueue_script');
  	add_action('admin_print_styles-'.$page2, 'webriti_theme_admin_enqueue_script');
  	
  	}
  	//Theme pages 
  	function spasalon_spa_option_panal_function()
  	{
  		require_once ( get_template_directory() . '/option_pannel/css/tooltip_css.php' );
  		wp_enqueue_script('spa-optionpanal-jquery',get_template_directory_uri().'/option_pannel/js/spa-optionpanal-jquery.js',array('farbtastic'));
  		require_once('spa_options_pannel.php');		
  		
  	}
  	
  	function webriti_themes_function ()
  	{	
  		require_once('webriti_theme.php');
  	}
  	//Theme pages css and js
  	function webriti_theme_admin_enqueue_script()
  	{ 	
  		
  		wp_enqueue_style('responsive',get_template_directory_uri().'/css/bootstrap-responsive.css'); 
  		wp_enqueue_style('bootstrap',get_template_directory_uri().'/option_pannel/css/webriti_theme.css'); 
  		
  	}
  	
  	function spasalon_admin_enqueue_script()
  	{
  		wp_enqueue_script( 'dashboard');
  		wp_enqueue_style( 'sis_spa-wpb_option_pannel', get_template_directory_uri() . '/option_pannel/css/spa_option_pannel.css' );
  		wp_enqueue_script( 'sis_spa-wpb_option_pannel', get_template_directory_uri() . '/option_pannel/js/spa_option_pannel.js');
  		wp_enqueue_script('sis_spa-my-upload',get_template_directory_uri().'/option_pannel/js/media-upload-script.js',array('media-upload','thickbox'));
  		
  		// color 	
  		wp_enqueue_style('thickbox');
  		wp_enqueue_style('sis_spa-farbtasticss',get_template_directory_uri().'/option_pannel/css/farbtasticss.css');
  		wp_enqueue_style('spa-bootstrap',get_template_directory_uri().'/option_pannel/css/assets/css/spa-bootstrap.css');
  		//wp_enqueue_script('my-color-picker-script', get_template_directory_uri().'/option_pannel/js/my-color-picker-script.js', array( 'wp-color-picker' ), false, true );
		
  	}	
  } 
  ?>