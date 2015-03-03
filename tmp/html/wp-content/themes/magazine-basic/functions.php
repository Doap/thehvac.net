<?php
$bavotasan_theme_data = wp_get_theme();
define( 'MB_THEME_URL', get_template_directory_uri() );
define( 'MB_THEME_TEMPLATE', get_template_directory() );
define( 'BAVOTASAN_THEME_NAME', $bavotasan_theme_data->Name );
define( 'BAVOTASAN_PRO_UPGRADE_NAME', 'Magazine Premium' );

/**
 * Includes
 *
 * @since 3.0.0
 */
require( MB_THEME_TEMPLATE . '/library/theme-options.php' ); // Functions for theme options page
require( MB_THEME_TEMPLATE . '/library/preview-pro.php' ); // Functions for preview pro page

/**
 * Prepare the content width
 *
 * @since 3.0.3
 */
$array_width = array( '' => 1200, 'w960' => 960, 'w640' => 640, 'w320' => 320, 'wfull' => 1200 );
$array_content = array( 'c2' => .17, 'c3' => .25, 'c4' => .34, 'c5' => .42, 'c6' => .5, 'c7' => .58, 'c8' => .66, 'c9' => .75, 'c10' => .83, 'c12' => 1 );
$bavotasan_main_content =  $array_content[mb_theme_options('primary')] * $array_width[mb_theme_options('width')] - 40;

if ( ! isset( $content_width ) )
	$content_width = $bavotasan_main_content;

add_action( 'after_setup_theme', 'mb_setup' );
if ( ! function_exists( 'mb_setup' ) ) :
/**
 * Initial setup for Magazine Basic theme
 *
 * This function is attached to the 'after_setup_theme' action hook.
 *
 * @uses	load_theme_textdomain()
 * @uses	get_locale()
 * @uses	add_theme_support()
 * @uses	add_editor_style()
 * @uses	register_default_headers()
 *
 * @since 3.0.0
 */
function mb_setup() {
	load_theme_textdomain( 'magazine-basic', MB_THEME_TEMPLATE . '/library/languages' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menu( 'primary', __( 'Primary Menu', 'magazine-basic' ) );
	register_nav_menu( 'secondary', __( 'Secondary Menu', 'magazine-basic' ) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'video', 'audio', 'quote', 'link', 'status', 'aside' ) );

	// This theme uses Featured Images (also known as post thumbnails) for archive pages
	add_theme_support( 'post-thumbnails' );
	add_image_size( '1_column', mb_theme_options( '1_image_width' ), 999, false );
	add_image_size( '2_column', mb_theme_options( '2_image_width' ), 999, false );
	add_image_size( '3_column', mb_theme_options( '3_image_width' ), 999, false );

	// Add a filter to mb_header_image_width and mb_header_image_height to change the width and height of your custom header.
	add_theme_support( 'custom-header', array(
		'random-default' => true,
		'default-text-color' => '333',
		'flex-width' => true,
		'flex-height' => true,
		'width' => apply_filters( 'mb_header_image_width', 1200 ),
		'height' => apply_filters( 'mb_header_image_height', 288 ),
		'admin-head-callback' => 'mb_admin_header_style',
		'admin-preview-callback' => 'mb_admin_header_image'
	) );

	add_theme_support( 'custom-background', array(
		'default-image' => MB_THEME_URL . '/library/images/solid.png',
	) );
}
endif; // mb_setup

add_action( 'wp_head', 'mb_styles' );
/**
 * Add a style block to the theme for the current link color.
 *
 * This function is attached to the 'wp_head' action hook.
 *
 * @since 3.0.0
 */
function mb_styles() {
	$text_color = get_header_textcolor();
	$styles = ( 'blank' == $text_color ) ? 'position:absolute !important;clip:rect(1px 1px 1px 1px);clip:rect(1px, 1px, 1px, 1px)' : 'color:#' . $text_color . ' !important';
	?>
<style>
#site-title a,#site-description{<?php echo $styles; ?>}
#page{background-color:<?php echo mb_theme_options( 'page_background' ); ?>}
.entry-meta a,.entry-content a,.widget a{color:<?php echo mb_theme_options( 'link_color' ); ?>}
</style>
	<?php
}

if ( ! function_exists( 'mb_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in mb_setup().
 *
 * @since 3.0.0
 */
function mb_admin_header_style() {
	$text_color = get_header_textcolor();
	$styles = ( 'blank' == $text_color ) ? 'display:none' : 'color:#' . $text_color . ' !important';
	?>
<style>
.appearance_page_custom-header #headimg {
	border: none;
	}

#site-title {
	margin: 0;
	font-family: Georgia, sans-serif;
	font-size: 50px;
	line-height: 1.2;
	}

#site-description {
	font-family: Arial, sans-serif;
	margin: 0 0 30px;
	font-size: 20px;
	line-height: 1.2;
	font-weight: normal;
	padding: 0;
	}

#headimg img {
	max-width: 1200px;
	height: auto;
	width: 100%;
	}

#site-title,#site-description{<?php echo $styles; ?>}
</style>
	<?php
}
endif; // mb_admin_header_style

if ( ! function_exists( 'mb_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in mb_setup().
 *
 * @uses	bloginfo()
 * @uses	get_header_image()
 *
 * @since 3.0.0
 */
function mb_admin_header_image() {
	?>
	<div id="headimg">
		<h1 id="site-title"><?php bloginfo( 'name' ); ?></h1>
		<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
		<?php if ( $header_image = get_header_image() ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
	<?php
}
endif; // mb_admin_header_image

add_action( 'admin_bar_menu', 'bavotasan_admin_bar_menu', 999 );
/**
 * Add menu item to toolbar
 *
 * This function is attached to the 'admin_bar_menu' action hook.
 *
 * @param	array $wp_admin_bar
 *
 * @since 2.0.4
 */
function bavotasan_admin_bar_menu( $wp_admin_bar ) {
    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() ) {
    	$wp_admin_bar->add_node( array( 'id' => 'bavotasan_toolbar', 'title' => BAVOTASAN_THEME_NAME, 'href' => admin_url( 'customize.php' ) ) );
    	$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'documentation_faqs', 'title' => __( 'Documentation & FAQs', 'magazine-basic' ), 'href' => 'https://themes.bavotasan.com/documentation', 'meta' => array( 'target' => '_blank' ) ) );
	}
}

add_action( 'pre_get_posts', 'mb_home_query' );
if ( ! function_exists( 'mb_home_query' ) ) :
/**
 * Remove sticky posts from home page query
 *
 * This function is attached to the 'pre_get_posts' action hook.
 *
 * @param	array $query
 *
 * @since 3.0.0
 */
function mb_home_query( $query = '' ) {
	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() )
		return;

	$query->set( 'post__not_in', (array) get_option( 'sticky_posts' ) );
	$query->set( 'posts_per_page', (int) mb_theme_options( 'number' ) );
}
endif;

add_action( 'wp_enqueue_scripts', 'mb_add_js' );
if ( ! function_exists( 'mb_add_js' ) ) :
/**
 * Load all JavaScript to header
 *
 * This function is attached to the 'wp_enqueue_scripts' action hook.
 *
 * @uses	is_admin()
 * @uses	is_singular()
 * @uses	get_option()
 * @uses	wp_enqueue_script()
 * @uses	MB_THEME_URL
 *
 * @since 3.0.0
 */
function mb_add_js() {
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_enqueue_script( 'harvey', MB_THEME_URL .'/library/js/harvey.min.js', '', '', true );
	wp_enqueue_script( 'theme_js', MB_THEME_URL .'/library/js/theme.js', array( 'jquery' ), '', true );

	wp_enqueue_style( 'google_fonts', '//fonts.googleapis.com/css?family=Cantata+One|Lato:300,700' );
	wp_enqueue_style( 'theme_stylesheet', get_stylesheet_uri() );
}
endif; // mb_add_js

add_action( 'widgets_init', 'mb_widgets_init' );
if ( ! function_exists( 'mb_widgets_init' ) ) :
/**
 * Creating the two sidebars
 *
 * This function is attached to the 'widgets_init' action hook.
 *
 * @uses	register_sidebar()
 *
 * @since 3.0.0
 */
function mb_widgets_init() {
	// include the widgets
	include( MB_THEME_TEMPLATE . '/library/widgets/widget_feature.php' );

	register_sidebar( array(
		'name' => __( 'First Sidebar', 'magazine-basic' ),
		'id' => 'sidebar',
		'description' => __( 'This is the first sidebar area. All defaults widgets work great here.', 'magazine-basic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Second Sidebar', 'magazine-basic' ),
		'id' => 'second-sidebar',
		'description' => __( 'This is the second sidebar area. All defaults widgets work great here. You must select one of the "2 sidebar" layout options in order to view this area on the front end.', 'magazine-basic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Header Area', 'magazine-basic' ),
		'id' => 'header-area',
		'description' => __( 'Widgetized area in the header to the right of the site name. Great place for a search box or a banner ad.', 'magazine-basic' ),
		'before_widget' => '<aside id="%1$s" class="header-widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="header-widget-title">',
		'after_title' => '</h3>',
	) );
}
endif; // mb_widgets_init

if ( ! function_exists( 'mb_pagination' ) ) :
/**
 * Add pagination
 *
 * @uses	paginate_links()
 * @uses	add_query_arg()
 *
 * @since 3.0.0
 */
function mb_pagination() {
	global $wp_query;

	$current = max( 1, get_query_var('paged') );
	$big = 999999999; // need an unlikely integer

	$pagination_return = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => $current,
		'total' => $wp_query->max_num_pages,
		'next_text' => '&raquo;',
		'prev_text' => '&laquo;'
	) );

	if ( ! empty( $pagination_return ) ) {
		echo '<div id="pagination">';
		echo '<div class="total-pages">';
		printf( __( 'Page %1$s of %2$s', 'magazine-basic' ), $current, $wp_query->max_num_pages );
		echo '</div>';
		echo $pagination_return;
		echo '</div>';
	}
}
endif; // mb_pagination

add_filter( 'wp_title', 'mb_filter_wp_title', 10, 2 );
if ( ! function_exists( 'mb_filter_wp_title' ) ) :
/**
 * Filters the page title appropriately depending on the current page
 *
 * @uses	get_bloginfo()
 * @uses	is_home()
 * @uses	is_front_page()
 *
 * @since 3.0.0
 */
function mb_filter_wp_title( $title, $sep ) {
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
		$title = "$title $sep " . sprintf( __( 'Page %s', 'magazine-basic' ), max( $paged, $page ) );

	return $title;
}
endif; // mb_filter_wp_title

if ( ! function_exists( 'mb_comment' ) ) :
/**
 * Callback function for comments
 *
 * Referenced via wp_list_comments() in comments.php.
 *
 * @uses	get_avatar()
 * @uses	get_comment_author_link()
 * @uses	get_comment_date()
 * @uses	get_comment_time()
 * @uses	edit_comment_link()
 * @uses	comment_text()
 * @uses	comments_open()
 * @uses	comment_reply_link()
 *
 * @since 3.0.0
 */
function mb_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	switch ( $comment->comment_type ) :
		case '' :
		?>
		<li <?php comment_class(); ?>>
			<div id="comment-<?php comment_ID(); ?>" class="comment-body">
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 60 ); ?>
				</div>
				<div class="comment-content">
					<div class="comment-author">
						<?php echo get_comment_author_link() . ' '; ?>
					</div>
					<div class="comment-meta">
						<?php
						printf( __( '%1$s at %2$s', 'magazine-basic' ), get_comment_date(), get_comment_time() );
						edit_comment_link( __( '(edit)', 'magazine-basic' ), '  ', '' );
						?>
					</div>
					<div class="comment-text">
						<?php if ( '0' == $comment->comment_approved ) { echo '<em>' . __( 'Your comment is awaiting moderation.', 'magazine-basic' ) . '</em>'; } ?>
						<?php comment_text() ?>
					</div>
					<?php if ( $args['max_depth'] != $depth && comments_open() && 'pingback' != $comment->comment_type ) { ?>
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php
			break;

		case 'pingback'  :
		case 'trackback' :
		?>
		<li id="comment-<?php comment_ID(); ?>" class="pingback">
			<div class="comment-body">
				<?php _e( 'Pingback:', 'magazine-basic' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(edit)', 'magazine-basic' ), ' ' ); ?>
			</div>
			<?php
			break;
	endswitch;
}
endif; // mb_comment

add_filter( 'comment_form_default_fields', 'mb_html5_fields' );
if ( ! function_exists( 'mb_html5_fields' ) ) :
/**
 * Adds HTML5 fields to comment form
 *
 * This function is attached to the 'comment_form_default_fields' filter hook.
 *
 * @param	array $fields
 *
 * @return	Modified comment form fields
 *
 * @since 3.0.0
 */
function mb_html5_fields( $fields ) {
	$fields['author'] = '<p class="comment-form-author"><input id="author" name="author" type="text" required size="30" placeholder="' . __( 'Name', 'magazine-basic' ) . ' *" aria-required="true" /></p>';
	$fields['email'] = '<p class="comment-form-email"><input id="email" name="email" type="email" required size="30" placeholder="' . __( 'Email', 'magazine-basic' ) . ' *" aria-required="true" /></p>';
	$fields['url'] = '<p class="comment-form-url"><input id="url" name="url" type="url" size="30" placeholder="' . __( 'Website', 'magazine-basic' ) . '" /></p>';

	return $fields;
}
endif; // mb_html5_fields

add_filter( 'get_search_form', 'mb_html5_search_form' );
if ( ! function_exists( 'mb_html5_search_form' ) ) :
/**
 * Update default WordPress search form to HTML5 search form
 *
 * This function is attached to the 'get_search_form' filter hook.
 *
 * @param	$form
 *
 * @return	Modified search form
 *
 * @since 3.0.0
 */
function mb_html5_search_form( $form ) {
    return '<form role="search" method="get" id="searchform" class="slide" action="' . home_url( '/' ) . '" >
    <label class="assistive-text" for="site-search">' . __('Search for:', 'magazine-basic') . '</label>
    <input type="search" placeholder="' . __( 'Search&hellip;', 'magazine-basic' ) . '" value="' . get_search_query() . '" name="s" id="site-search" />
    </form>';
}
endif; // mb_html5_search_form

add_filter( 'excerpt_more', 'mb_excerpt' );
if ( ! function_exists( 'mb_excerpt' ) ) :
/**
 * Adds a read more link to all excerpts
 *
 * This function is attached to the 'excerpt_more' filter hook.
 *
 * @param	int $more
 *
 * @return	Custom excerpt ending
 *
 * @since 3.0.0
 */
function mb_excerpt( $more ) {
	return '&hellip;';
}
endif; // mb_excerpt

add_filter( 'wp_trim_excerpt', 'mb_excerpt_more' );
if ( ! function_exists( 'mb_excerpt_more' ) ) :
/**
 * Adds a read more link to all excerpts
 *
 * This function is attached to the 'wp_trim_excerpt' filter hook.
 *
 * @param	string $text
 *
 * @return	Custom read more link
 *
 * @since 3.0.0
 */
function mb_excerpt_more( $text ) {
	return $text . '<p class="more-link-p"><a class="more-link" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read more &rarr;', 'magazine-basic' ) . '</a></p>';
}
endif; // mb_excerpt_more

add_filter( 'the_content_more_link', 'mb_content_more_link', 10, 2 );
if ( ! function_exists( 'mb_content_more_link' ) ) :
/**
 * Customize read more link for content
 *
 * This function is attached to the 'the_content_more_link' filter hook.
 *
 * @param	string $link
 * @param	string $text
 *
 * @return	Custom read more link
 *
 * @since 3.0.0
 */
function mb_content_more_link( $link, $text ) {
	return '<p class="more-link-p"><a class="more-link" href="' . get_permalink( get_the_ID() ) . '">' . $text . '</a></p>';
}
endif; // mb_content_more_link

add_filter( 'excerpt_length', 'mb_excerpt_length', 999 );
if ( ! function_exists( 'mb_excerpt_length' ) ) :
/**
 * Custom excerpt length
 *
 * This function is attached to the 'excerpt_length' filter hook.
 *
 * @param	int $length
 *
 * @return	Custom excerpt length
 *
 * @since 3.0.0
 */
function mb_excerpt_length( $length ) {
	return 40;
}
endif; // mb_excerpt_length

/*
 * Remove default gallery styles
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Create the required attributes for the #primary container
 *
 * @since 3.0.0
 */
function mb_primary_attr() {
	$layout = mb_theme_options( 'layout' );
	$column = mb_theme_options( 'primary' );
	$class = ( 6 == $layout ) ? $column . ' centered' : $column;
	$style = ( 1 == $layout || 3 == $layout ) ? ' style="float: right;"' : '';

	echo 'class="' . $class . '"' . $style;
}

/**
 * Create the required classes for the #secondary sidebar container
 *
 * @since 3.0.0
 */
function mb_sidebar_class() {
	$layout = mb_theme_options( 'layout' );
	if ( 1 == $layout || 2 == $layout || 6 == $layout ) {
		$end = ( 2 == $layout ) ? ' end' : '';
		$class = str_replace( 'c', '', mb_theme_options( 'primary' ) );
		$class = 'c' . ( 12 - $class ) . $end;
	} else {
		$class = mb_theme_options( 'secondary' );
	}

	echo 'class="' . $class . '"';
}

/**
 * Create the required classes for the #tertiary sidebar container
 *
 * @since 3.0.0
 */
function mb_second_sidebar_class() {
	$layout = mb_theme_options( 'layout' );
	$end = ( 4 == $layout || 5 == $layout ) ? ' end' : '';
	$primary = str_replace( 'c', '', mb_theme_options( 'primary' ) );
	$secondary = str_replace( 'c', '', mb_theme_options( 'secondary' ) );
	$class = 'c' . ( 12 - $primary - $secondary ) . $end;

	echo 'class="' . $class . '"';
}

/**
 * Set up the article class according to layout selection
 *
 * @since 3.0.0
 */
function mb_article_class() {
	global $mb_content_area;

	$class = ( 'sidebar' == $mb_content_area ) ? 'c12 widget-post' : '';
	if ( is_home() && empty( $class ) ) {
		global $wp_query;
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var('paged') : 1;
		$grid = mb_theme_options( 'grid' );
		$count = $wp_query->current_post;
		$class = 'c12';
		if ( 'sidebar' != $mb_content_area ) {
			$class = ( ( 2 == $grid || 3 == $grid ) && ( 0 < $count || 1 < $paged ) ) ? 'two-col c6' : $class;
			$class = ( ( 3 == $grid && ( 2 < $count || 1 < $paged ) ) || ( 4 == $grid && ( 0 < $count || 1 < $paged ) ) ) ? 'three-col c4' : $class;
		}
	}

	return $class;
}

/**
 * Add class to sub-menu parent items
 *
 * @author Kirk Wight <http://kwight.ca/adding-a-sub-menu-indicator-to-parent-menu-items/>
 * @since 3.0.3
 */
class Bavotasan_Page_Navigation_Walker extends Walker_Nav_Menu {
    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( !empty( $children_elements[ $element->$id_field ] ) )
            $element->classes[] = 'sub-menu-parent';

        Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}

add_filter( 'wp_nav_menu_args', 'bavotasan_nav_menu_args' );
/**
 * Set our new walker only if a menu is assigned and a child theme hasn't modified it to one level deep
 *
 * This function is attached to the 'wp_nav_menu_args' filter hook.
 *
 * @author Kirk Wight <http://kwight.ca/adding-a-sub-menu-indicator-to-parent-menu-items/>
 * @since 3.0.3
 */
function bavotasan_nav_menu_args( $args ) {
    if ( 1 !== $args[ 'depth' ] && has_nav_menu( 'primary' ) )
        $args[ 'walker' ] = new Bavotasan_Page_Navigation_Walker;

    return $args;
}

add_filter( 'body_class','bavotasan_custom_body_class' );
/**
 * Add left sidebar class to body if first sidebar is on the left
 *
 * This function is attached to the 'body_class' filter hook.
 *
 * @since 3.0.3
 */
function bavotasan_custom_body_class( $classes ) {
	$arr = array( 1, 3, 5 );
	if ( in_array( mb_theme_options('layout'), $arr ) )
		$classes[] = 'left-sidebar';

	return $classes;
}

add_action( 'admin_enqueue_scripts', 'bavotasan_adminbar_enqueue' );
/**
 * Enqueue admin bar scripts if there's an admin bar active.
 *
 * This function is attached to the 'admin_enqueue_scripts' action hook.
 *
 * @since 3.0.4
 */
function bavotasan_adminbar_enqueue() {
	wp_enqueue_script( 'bavotasan_admin_bar_js', MB_THEME_URL . '/library/js/bootstrap.js', array( 'jquery' ), '', true );
	wp_enqueue_style( 'bavotasan_admin_bar', MB_THEME_URL . '/library/css/admin-bar.css' );
}

add_action( 'in_admin_header', 'bavotasan_adminbar', 1 );
/**
 * Display the admin bar
 *
 * This function is attached to the 'in_admin_header' action hook.
 *
 * @since 3.0.4
 */
function bavotasan_adminbar() {
	if ( get_option( 'bavotasan_hide_adminbar' ) )
		return;

	?>
	<div id="bavotasan-admin-bar" class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<p><i class="icon-leaf"></i> <?php printf ( __( 'Thanks for choosing %s. Hope you enjoy using it! %s If you want to see some of the advanced options available in %s, %shere\'s a little preview%s.', 'magazine-basic' ), '<em>' . BAVOTASAN_THEME_NAME . '</em>', '<img src="' . home_url( '/wp-includes/images/smilies/icon_smile.gif' ) . '" alt="" />', '<em>' . BAVOTASAN_PRO_UPGRADE_NAME . '</em>', '<a href="' . admin_url( 'themes.php?page=bavotasan_preview_pro' ) . '" class="alert-link">', '</a>' ); ?></p>
	</div>
	<?php
}

add_action( 'wp_ajax_bavotasan_hide_adminbar', 'bavotasan_hide_adminbar' );
/**
 * Set option when admin bar is dismissed
 *
 * This function is attached to the 'wp_ajax_bavotasan_hide_adminbar' action hook.
 *
 * @since 3.0.4
 */
function bavotasan_hide_adminbar() {
	if ( update_option( 'bavotasan_hide_adminbar', true ) )
        die( '1' );
    else
        die( '0' );
}

add_action( 'after_switch_theme', 'bavotasan_theme_activated', 10, 2 );
/**
 * Reset the Bavotasan admin bar option
 *
 * This function is attached to the 'after_switch_theme' action hook.
 *
 * @since 3.0.4
 */
function bavotasan_theme_activated() {
	delete_option( 'bavotasan_hide_adminbar' );
}