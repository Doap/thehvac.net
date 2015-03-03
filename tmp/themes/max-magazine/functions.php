<?php
/**
 * Max Magazine Theme functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * @file      functions.php
 * @package   max-magazine
 * @author    Sami Ch.
 * @link 	  http://gazpo.com
 */


/**
 * Tell WordPress to run max_magazine_setup() when the 'after_setup_theme' hook is run.
 */
 
add_action( 'after_setup_theme', 'max_magazine_setup' );
 
if ( ! function_exists( 'max_magazine_setup' ) ):
 
function max_magazine_setup() {
	
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	if ( ! isset( $content_width ) )
		$content_width = 600;
	
	/**
	 * This theme styles the visual editor with editor-style.css to match the theme style.
	 */
	add_editor_style();
	
	/**
	 * Load up our theme options page and related code.
	 */
	require ( get_template_directory() . '/settings/theme-options.php' );
	
	/**
	 * Load our theme widgets
	 */
	require( get_template_directory() . '/widgets/widget_subscriber_counter.php' );
	require( get_template_directory() . '/widgets/widget_facebook.php' );
	require( get_template_directory() . '/widgets/widget_twitter.php' );
	require( get_template_directory() . '/widgets/widget_social_links.php' );
	require( get_template_directory() . '/widgets/widget_ad125.php' );
	
	/** 
	 * Add default posts and comments RSS feed links to <head>.
	 */
	add_theme_support( 'automatic-feed-links' );
	
	/**
	 * This theme uses wp_nav_menu() in one location.	
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'max-magazine' ),
	) );
	
	/**
	 * Add support for custom backgrounds.
	 */
	$default_background_color = 'f7f8f9';
	add_theme_support( 'custom-background', array(
		// Let WordPress know what our default background color is.
		// This is dependent on our current color scheme.
		'default-color' => $default_background_color,
	) );
	
	/**
	 * This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	 */
	if ( function_exists( 'add_theme_support' ) ) { 
		add_theme_support( 'post-thumbnails' );
	}
	
	/**
	 * Add custom image size for slider and featured category thumbnails.	
	 */
	add_image_size( 'small-thumb', 70, 40, true );
	
	/**
	 * Add custom image size for featured category posts.	
	 */
	add_image_size( 'feat-thumb', 300, 170, true );		//featured post thumbnail
	
	/**
	 * Add custom image size for carousel posts.	
	 */
	add_image_size( 'carousel-thumb', 190, 130, true );		//featured post thumbnail
	
	/**
	 * Add custom image size for slider posts.	
	 */
	add_image_size( 'slider-image', 630, 300, true );		//featured post thumbnail
	
}
endif; // max_magazine_setup


/**
 * Set the custom excerpt length to return first 30 words.
 */
function max_magazine_custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'max_magazine_custom_excerpt_length', 999 );

/**
 * Set the format for the more in excerpt, return ... instead of [...]
 */ 
function max_magazine_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'max_magazine_excerpt_more');

	
/**
 * Register our sidebars and widgetized areas.
 *
 */
if ( function_exists('register_sidebar') ) {
			
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'max-magazine' ),
		'id' => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Area', 'max-magazine' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional widget area for your site footer', 'max-magazine' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	) );	
}

/**
 * Function for the custom template for comments and pingbacks.
 *
 */
 
if ( ! function_exists( 'max_magazine_comments' ) ) {

	function max_magazine_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
		?>
			<li class="pingback">
				<span class="title" ><?php _e('Pingback:', 'max-magazine') ?></span> <?php comment_author_link(); ?>
			<?php
			
			break;
		
			default :
		?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>" class="comment">
					<div class="comment-meta">
			
						<div class="comment-author vcard">
							<?php
								$avatar_size = 39;
								if ( '0' != $comment->comment_parent )
									$avatar_size = 39;

								echo get_avatar( $comment, $avatar_size );

								/* translators: 1: comment author, 2: date and time */
								printf(  '%1$s <span class="date-and-time">%2$s</span>',
									sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
									sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
										esc_url( get_comment_link( $comment->comment_ID ) ),
										get_comment_time( 'c' ),
										/* translators: 1: date, 2: time */
										sprintf( __( '%1$s at %2$s', 'max-magazine' ), get_comment_date(), get_comment_time() )
									)
								);
							?>					
						</div><!-- /comment-author /vcard -->

						<?php if ( $comment->comment_approved == '0' ) : ?>
							<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'max-magazine' ); ?></em>
							<br />
						<?php endif; ?>

					</div>

					<div class="comment-content"><?php comment_text(); ?></div>

					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'max-magazine' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div><!-- ./reply -->
				</div><!-- /comment -->
			<?php
			break;
		endswitch;
	}
}


/**
 * Pagination for archive, taxonomy, category, tag and search results pages
 *
 * @global $wp_query http://codex.wordpress.org/Class_Reference/WP_Query
 * @return Prints the HTML for the pagination if a template is $paged
 */
function max_magazine_pagination() {
	global $wp_query;
 
	$big = 999999999; // This needs to be an unlikely integer
 
	// For more options and info view the docs for paginate_links()
	// http://codex.wordpress.org/Function_Reference/paginate_links
	$paginate_links = paginate_links( array(
		'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'mid_size' => 5
	) );
 
	// Display the pagination if more than one page is found
	if ( $paginate_links ) {
		echo '<div class="pagination">';
		echo $paginate_links;
		echo '</div><!--// end .pagination -->';
	}
}

/**
 * A safe way of adding JavaScripts to a WordPress generated page.
 */
    
if (!is_admin()){
    add_action('wp_enqueue_scripts', 'max_magazine_js');
	add_action('wp_print_styles', 'max_magazine_styles_loader');
}

if (!function_exists('max_magazine_js')) {

    function max_magazine_js() {
		wp_enqueue_script('superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery')); 			
		wp_enqueue_script('jq_easing', get_template_directory_uri() . '/js/jquery.easing_1.3.js', array('jquery')); 
		wp_enqueue_script('lofslider', get_template_directory_uri() . '/js/lofslider.js', array('jquery')); 
		wp_enqueue_script('jcarousellite', get_template_directory_uri() . '/js/jcarousellite_1.0.1.min.js', array('jquery'));   
		wp_enqueue_script('masonry', get_template_directory_uri() . '/js/jquery.masonry.min.js', array('jquery')); 
		wp_enqueue_script('mobilemenu', get_template_directory_uri() . '/js/jquery.mobilemenu.js', array('jquery'));  			
		wp_enqueue_script('max_magazine_custom', get_template_directory_uri() . '/js/custom.js', array('jquery')); 
    }
	
}
	
if (!function_exists('max_magazine_styles_loader')) {
    function max_magazine_styles_loader() {
		wp_enqueue_style( 'style', get_stylesheet_uri() );
		wp_enqueue_style( 'google_fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:700,400,600' );			
    }
}

function max_magazine_menu_fallback() { ?>
		<ul class="menu">
			<?php
				wp_list_pages(array(
					'number' => 5,
					'exclude' => '',
					'title_li' => '',
					'sort_column' => 'post_title',
					'sort_order' => 'ASC',
				));
			?>  
		</ul>
    <?php
}
?>