<?php 
 

 if ( ! isset( $content_width ) ) $content_width = 900;
  
  define('WEBRITI_TEMPLATE_DIR',get_template_directory());
  define('WEBRITI_THEME_FUNCTIONS_PATH',WEBRITI_TEMPLATE_DIR.'/functions');
  //the  for author.php 
  if ( ! function_exists( 'spa_content_nav' ) ) :
  /**
   * Displays navigation to next/previous pages when applicable.
   *
   * @since Spasalon 1.0
   */
  function spa_content_nav( $html_id ) {
  	global $wp_query;
  
  	$html_id = esc_attr( $html_id );
  
  	if ( $wp_query->max_num_pages > 1 ) : ?>
<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
  <h3 class="assistive-text"><?php _e( 'Post navigation', 'sis_spa' ); ?></h3>
  <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'sis_spa' ) ); ?></div>
  <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'sis_spa' ) ); ?></div>
</nav>
<!-- #<?php echo $html_id; ?> .navigation -->
<?php endif;
  }
  endif;
  
  
  //wp_title
  function spa_wp_title( $title, $sep ) {
  	global $paged, $page;
  
  	if ( is_feed() )
  		return $title;
  
  	// Add the site name.
  	$title .= get_bloginfo( 'name' );
  
  	// Add the site description for the home/front page.
  	$site_description = get_bloginfo( 'description', 'display' );
  	if ( $site_description && ( is_home() || is_front_page() ) )
  		$title = "$title $sep $site_description";
  
  	// Add a page number if necessary.
  	if ( $paged >= 2 || $page >= 2 )
  		$title = "$title $sep " . sprintf( __( 'Page %s', 'sis_spa' ), max( $paged, $page ) );
  
  	return $title;
  }
  add_filter( 'wp_title', 'spa_wp_title', 10, 2 );
  // including theme setup file
  include('theme_setup.php'); 
  
  //option-panel Scripts and CSS	
  require_once('option_pannel/option_pannel.php' );
  require_once ( WEBRITI_THEME_FUNCTIONS_PATH . '/Excerpt/excerpt_length.php' );// code for limit the length of excerpt
  require_once ( WEBRITI_THEME_FUNCTIONS_PATH . '/Pagination/webriti_pagination.php' );
  require_once ( WEBRITI_THEME_FUNCTIONS_PATH . '/resize_image/resize_image.php' );
  require_once ( WEBRITI_THEME_FUNCTIONS_PATH . '/Menu_Walker/default_menu_walker.php' );//default menu 
  require_once ( WEBRITI_THEME_FUNCTIONS_PATH . '/Menu_Walker/spasalon_nav_walker.php' );//custom menu
  require_once ( WEBRITI_THEME_FUNCTIONS_PATH . '/meta/metabox.php' );//MetaBox
  require_once ( WEBRITI_THEME_FUNCTIONS_PATH . '/comment/comment.php' );//COmmentbox
  require_once ( WEBRITI_THEME_FUNCTIONS_PATH . '/woo/woocommerce.php' );//woocommerce
  
  function spa_widgets_init() {
  /*sidebar*/
  register_sidebar( array(
  		'name' => __( ' Sidebar', 'sis_spa' ),
  		'id' => 'sidebar-primary',
  		'description' => __( 'The primary widget area', 'sis_spa' ),
  		'before_widget' => '<div class="widget">',
  		'after_widget' => '</div>',
  		'before_title' => ' <div id="widget-title" class="span12"><h4 class="spa-widget-title">',
  		'after_title' => '</h4></div>',
  	) );  
  	}	                     
  add_action( 'widgets_init', 'spa_widgets_init' );
  
  add_theme_support('woocommerce');
  //enqueue scripts
  add_action('wp_enqueue_scripts','spa_enqueue_script'); 
  function spa_enqueue_script() {
           require_once('option_pannel/custom_style.php');
  	
  	wp_enqueue_style('sis_spa_custom-responsive', get_template_directory_uri().'/css/custom-responsive.css');
  	wp_enqueue_style('sis_spa_bootstrap', get_template_directory_uri().'/css/bootstrap.css');
  	wp_enqueue_style('sis_spa_bootstrap-responsive', get_template_directory_uri().'/css/bootstrap-responsive.css');
  	wp_enqueue_style('sis_spa_docs', get_template_directory_uri().'/css/docs.css');
  	wp_enqueue_style('sis_spa_flexslider', get_template_directory_uri().'/css/flexslider.css'); 
  	wp_enqueue_style('sis_spa_flexsliderdemo', get_template_directory_uri().'/css/flexslider-demo.css');  
  	wp_enqueue_style('sis_spa_font', get_template_directory_uri().'/css/font/font.css'); //enqueue color css
  	wp_enqueue_style('sis_spa_color',get_template_directory_uri().'/css/skins/default.css');
  
  	// wp_enqueue_script('jquery');
  	if ( is_singular() ) wp_enqueue_script( "comment-reply" ); 	// them e check plugin 	
  	wp_enqueue_script('sis_spa_menu', get_template_directory_uri().'/js/menu/menu.js',array('jquery'));
  	wp_enqueue_script('sis_spa-boot-menus', get_template_directory_uri().'/js/menu/bootstrap.min.js'); 
	if(is_front_page()){
  	wp_enqueue_script('sis_spa_flexmain', get_template_directory_uri().'/js/flex/jquery.flexslider.js');
  	wp_enqueue_script('sis_spa_flexslider-setting', get_template_directory_uri().'/js/flex/flexslider-setting.js'); 
    }
  }
  ?>