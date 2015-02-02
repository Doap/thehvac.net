<?php

add_action( 'after_setup_theme', 'swift_constants', 1 );
add_action( 'after_setup_theme', 'swift_setup', 2 );
add_action( 'after_setup_theme', 'swift_fucntions', 3 );
add_action( 'widgets_init', 'swift_widgets_init' );


function swift_constants() {

	/* Sets the path to the parent theme directory. */
	define( 'THEME_DIR', get_template_directory() );

	/* Sets the path to the parent theme directory URI. */
	define( 'THEME_URI', get_template_directory_uri() );

	/* Sets the path to the child theme directory. */
	define( 'CHILD_THEME_DIR', get_stylesheet_directory() );

	/* Sets the path to the child theme directory URI. */
	define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

	/* Sets the path to the core framework directory. */
	define( 'SWIFT_DIR', trailingslashit( THEME_DIR ) . basename( dirname( __FILE__ ) ) );

	/* Sets the path to the core framework directory URI. */
	define( 'SWIFT_URI', trailingslashit( THEME_URI ) . basename( dirname( __FILE__ ) ) );

	/* Sets the path to the core framework admin directory. */
	define( 'SWIFT_ADMIN', trailingslashit( SWIFT_DIR ) . 'admin' );

	/* Sets the path to the core framework functions directory. */
	define( 'SWIFT_FUNCTIONS', trailingslashit( SWIFT_DIR ) . 'functions' );

	/* Sets the path to the core framework functions directory. */
	define( 'SWIFT_INCLUDES', trailingslashit( SWIFT_DIR ) . 'includes' );

	/* Sets the path to the setup functions directory. */
	define( 'SWIFT_SETUP', trailingslashit( SWIFT_DIR ) . 'setup' );

	/*Sets the path to plugins directory */
	define( 'SWIFT_PLUGINS', trailingslashit( SWIFT_DIR ) . 'plugins' );


	/* Sets the path to the core framework images directory URI. */
	define( 'SWIFT_IMAGES', trailingslashit( SWIFT_URI ) . 'images' );

	/* Sets the path to the core framework CSS directory URI. */
	define( 'SWIFT_CSS', trailingslashit( SWIFT_URI ) . 'css' );

	/* Sets the path to the core framework JavaScript directory URI. */
	define( 'SWIFT_JS', trailingslashit( SWIFT_URI ) . 'js' );
}

/**
 * Loads the core framework files.  These files are needed before loading anything else in the
 * framework because they have required functions for use.
 *
 * @since 6.1.0
 */
function swift_fucntions() {

	/* Load the core framework functions. */
	require_once( trailingslashit( SWIFT_FUNCTIONS ) . 'core.php' );
	require_once( trailingslashit( SWIFT_FUNCTIONS ) . 'context.php' );
	require_once ( trailingslashit( SWIFT_FUNCTIONS ) . 'hooks-filters.php' );
	require_once ( trailingslashit( SWIFT_FUNCTIONS ) . 'body-classes.php' );

	/* Register sidebars and widgets. */
	require_once( trailingslashit( SWIFT_SETUP ) . 'sidebars-widgets.php' );
	require_once( trailingslashit( SWIFT_SETUP ) . 'widgets.php' );

	/* Load the display related functions. */
	require_once( trailingslashit( SWIFT_FUNCTIONS ) . 'display.php' );
	require_once( trailingslashit( SWIFT_FUNCTIONS ) . 'change-wordpress-defaults.php' );
	require_once( trailingslashit( SWIFT_FUNCTIONS ) . 'misc.php' );

	/* Admin setup */
	require_once ( trailingslashit( SWIFT_ADMIN ) . 'admin-setup.php' );
	require_once ( trailingslashit( SWIFT_ADMIN ) . 'ajax-admin-callbacks.php' ); //Reqired for image upload
	require_once ( trailingslashit( SWIFT_ADMIN ) . 'swift-options-input.php' );
	require_once ( trailingslashit( SWIFT_ADMIN ) . 'swift-design-options-input.php' );
	require_once ( trailingslashit( SWIFT_ADMIN ) . 'design-options-display-functions.php' );
	require_once ( trailingslashit( SWIFT_ADMIN ) . 'swift-options-init.php' );
	require_once ( trailingslashit( SWIFT_ADMIN ) . 'swift-design-options-init.php' );
	//require_once ( trailingslashit( SWIFT_ADMIN ) . 'import_export_form.php' );
	require_once ( trailingslashit( SWIFT_ADMIN ) . 'write-files.php' );
	require_once ( trailingslashit( SWIFT_ADMIN ) . 'create-styles.php' );
	require_once ( trailingslashit( SWIFT_ADMIN ) . 'create-js.php' );

	require_once ( trailingslashit( SWIFT_ADMIN ) . 'font-defaults.php' );
	require_once ( trailingslashit( SWIFT_ADMIN ) . 'admin-functions.php' );
	require_once ( trailingslashit( SWIFT_ADMIN ) . 'swift-color-schemes-page.php' );


	/* Plugins */
	require_once ( trailingslashit( SWIFT_PLUGINS ) . 'dynamic-thumbnails.php' );
	require_once ( trailingslashit( SWIFT_PLUGINS ) . 'wp-pagenavi.php' );
	if(!class_exists('SubToMeWidget')){
		require_once ( trailingslashit( SWIFT_PLUGINS ) . 'subtome.php' );
	}//require_once ( trailingslashit( SWIFT_PLUGINS ) . 'shortcode-ninja/shortcode-ninja.php' );
	//require_once ( trailingslashit( SWIFT_PLUGINS ) . 'shortcode-ninja/admin-shortcodes.php' );

	require_once ( trailingslashit( SWIFT_FUNCTIONS ) . 'modified-core-functions.php' );
	require_once ( trailingslashit( SWIFT_FUNCTIONS ) . 'meta-boxes.php' );
	require_once ( trailingslashit( SWIFT_FUNCTIONS ) . 'np2-functions.php' );
	require_once ( trailingslashit( SWIFT_FUNCTIONS ) . 'to-be-scrapped.php' );
}

if ( ! function_exists( 'swift_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
*
* Note that this function is hooked into the after_setup_theme hook, which runs
* before the init hook. The init hook is too late for some features, such as indicating
* support post thumbnails.
*
* To override swift_setup() in a child theme, add your own swift_setup to your child theme's
* functions.php file.
*
* @uses load_theme_textdomain() For translation/localization support.
* @uses add_editor_style() To style the visual editor.
* @uses add_theme_support() To add support for post thumbnails, automatic feed links, and Post Formats.
* @uses register_nav_menus() To add support for navigation menus.
* @uses add_custom_background() To add support for a custom background.
* @uses add_custom_image_header() To add support for a custom header.
* @uses register_default_headers() To register the default custom header images provided with the theme.
* @uses set_post_thumbnail_size() To set a custom post thumbnail size.
*
* @since Swift 6.0
*/
function swift_setup() {

	/* Make Swift available for translation.
	 * Translations can be added to the /languages/ directory.
	* If you're building a theme based on Twenty Eleven, use a find and replace
	* to change 'swift' to the name of your theme in all the template files.
	*/
	load_theme_textdomain( 'swift', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();



	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'above-logo', __( 'Navigation menu above logo', 'swift' ) );
	register_nav_menu( 'below-logo', __( 'Navigation menu below logo', 'swift' ) );
	register_nav_menu( 'footer-links', __( 'Navigation links in footer', 'swift' ) );

	// Add support for a variety of post formats
	//add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );
	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images

	add_theme_support( 'post-thumbnails' );

	/**
	 * Loads the theme custom CSS file and the CSS needed for responsive layout.
	 * Responsive layout CSS is loaded only on mobiles
	*/
	function swift_add_custom_styles(){

		GLOBAL $swift_design_options;
		$upload_dir = wp_upload_dir();
		$upload_dir['baseurl'].'/swift-magic/custom-styles.css';
		wp_enqueue_style( 'swift_custom_styles', $upload_dir['baseurl'].'/swift-magic/custom-styles.css' );
		if( isset( $swift_design_options['enable_responsive']) && $swift_design_options['enable_responsive'] )
			wp_enqueue_style( 'swift_responsive_layout', get_template_directory_uri().'/css/responsive.css', array('swift_custom_styles') );
	}
	add_action( 'wp_print_styles', 'swift_add_custom_styles', 1);

	// Load the required javaScript files
	function swift_add_scripts(){
		wp_enqueue_script('jquery');
		$upload_dir = wp_upload_dir();
		wp_enqueue_script( 'swift_js', $upload_dir[ 'baseurl' ].'/swift-magic/swift-js.js', array('jquery','jquery-ui-tabs'), '', FALSE );
		wp_enqueue_script( 'jquery_tooltip', get_template_directory_uri().'/js/jquery.ui.tooltip.min.js', array('jquery','jquery-ui-position'), '', FALSE );
	}
	add_action('wp_enqueue_scripts', 'swift_add_scripts', 1 );
}

endif; // swift_setup