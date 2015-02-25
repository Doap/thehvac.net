<?php 

// get the "author" role object
$role = get_role( 'author' );
// add "organize_gallery" to this role object
$role->add_cap( 'unfiltered_html' );
// get the "editor" role object
$role = get_role( 'editor' );
// add "organize_gallery" to this role object
$role->add_cap( 'unfiltered_html' );

// THUMBNAILS TO ADMIN POST VIEW
add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
function posts_columns($defaults){
    $defaults['doap_post_thumbs'] = __('Thumbs');
    return $defaults;
}
function posts_custom_columns($column_name, $id){
	if($column_name === 'doap_post_thumbs'){
        echo the_post_thumbnail( array(100,60) );
    }
}

function template_change( $template ){
    if( is_single() && in_category('lptv') ){
        $templates = array("single-lptv.php");
    } elseif( is_single() && in_category('lptv2') ){
        $templates = array("single-lptv2.php");
    } elseif( is_single() && in_category('lptv3') ){
        $templates = array("single-lptv3.php");
    }
    else
    {
	$templates = array("single.php");
    }
    $template = locate_template( $templates );
    return $template;
}
add_filter( 'single_template', 'template_change' ); //'template_include'/'single_template'

if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('toplptv'),
        'id'            => 'sidebar-toplptv',
        'description'   => 'Sidebar for showing ad and section list on the template category-toplptv.php',
        'before_widget' => '<div id="lptv-wrapper"><div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('cartelera-del-cine'),
        'id'            => 'sidebar-cartelera-del-cine',
        'description'   => 'Sidebar for showing ad and section list on the template category-cartelera-del-cine.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('lptv-footer'),
        'id'            => 'sidebar-lptv-footer',
        'description'   => 'Sidebar for showing ad and section list on the template category-lptv-footer.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Index'),
        'id'            => 'sidebar-index',
        'description'   => 'Sidebar for showing ad and section list on the template category-index.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Internacionales'),
        'id'            => 'sidebar-internacionales',
        'description'   => 'Sidebar for showing ad and section list on the template category-internacionales.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Espectaculo'),
        'id'            => 'sidebar-espectaculo',
        'description'   => 'Sidebar for showing ad and section list on the template category-espectaculo.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Vida'),
        'id'            => 'sidebar-vida',
        'description'   => 'Sidebar for showing ad and section list on the template category-vida.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Politica'),
        'id'            => 'sidebar-politica',
        'description'   => 'Sidebar for showing ad and section list on the template category-politica.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Opinion'),
        'id'            => 'sidebar-opinion',
        'description'   => 'Sidebar for showing ad and section list on the template category-opinion.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Caricaturas'),
        'id'            => 'sidebar-caricaturas',
        'description'   => 'Sidebar for showing ad and section list on the template category-caricaturas.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Single'),
        'id'            => 'sidebar-single',
        'description'   => 'Sidebar for showing ad and section list on the template single.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('La Prensa Domingo'),
        'id'            => 'sidebar-la-prensa-domingo',
        'description'   => 'Sidebar for showing ad and section list on the template category-la-prensa-domingo.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Suplemento'),
        'id'            => 'sidebar-suplemento',
        'description'   => 'Sidebar for showing ad and section list on the template category-suplemento.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Ciencia'),
        'id'            => 'sidebar-ciencia',
        'description'   => 'Sidebar for showing ad and section list on the template category-ciencia.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Tecnologia'),
        'id'            => 'sidebar-tecnologia',
        'description'   => 'Sidebar for showing ad and section list on the template category-tecnologia.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Departamentales'),
        'id'            => 'sidebar-departamentales',
        'description'   => 'Sidebar for showing ad and section list on the template category-departamentales.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('PrensaClub'),
        'id'            => 'sidebar-prensaclub',
        'description'   => 'Sidebar for showing ad and section list on the template category-prensaclub.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Nacionales'),
        'id'            => 'sidebar-nacionales',
        'description'   => 'Sidebar for showing ad and section list on the template category-nacionales.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Salud'),
        'id'            => 'sidebar-salud',
        'description'   => 'Sidebar for showing ad and section list on the template category-salud.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Cultura'),
        'id'            => 'sidebar-cultura',
        'description'   => 'Sidebar for showing ad and section list on the template category-cultura.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Deportes'),
        'id'            => 'sidebar-deportes',
        'description'   => 'Sidebar for showing ad and section list on the template category-deportes.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Contactanos'),
        'id'            => 'sidebar-contactanos',
        'description'   => 'Sidebar for showing ad and section list on the template category-contactanos.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Economia'),
        'id'            => 'sidebar-economia',
        'description'   => 'Sidebar for showing ad and section list on the template category-economia.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Empresariales'),
        'id'            => 'sidebar-empresariales',
        'description'   => 'Sidebar for showing ad and section list on the template category-empresariales.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Aqui Entre Nos'),
        'id'            => 'sidebar-aqui-entre-nos',
        'description'   => 'Sidebar for showing ad and section list on the template category-aqui-entre-nos.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
if ( function_exists ('register_sidebar')){
    register_sidebar( array(
        'name'          => __('Nosotras'),
        'id'            => 'sidebar-nosotras',
        'description'   => 'Sidebar for showing ad and section list on the template category-nosotras.php',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>' ));
}
//
	function checkgid() {
   		global  $wpdb;
  		$user_id = get_current_user_id();
  		$qry = "SELECT identifier, websiteurl, email FROM `wp_2_wslusersprofiles` WHERE user_id = '$user_id' && provider = 'Google' && identifier IS NOT NULL && websiteurl = 'http://doap.com'";
  		$avalidgoogleid = $wpdb->get_results( $qry );

			foreach ( $avalidgoogleid as $avalidgoogleid )
				{
        				$gid = $avalidgoogleid ->identifier;
        				$uemail  = $avalidgoogleid ->email;
        				$websiteurl = $avalidgoogleid ->websiteurl;
        		if ($gid < 10000000) {
                        		echo "not a google account";
                		} else {
                        		//echo "<span style=position:relative;top:40px;left:400px;z-index:10000;> ".$gid."</span>"; 
                        		//echo "<span style=position:relative;top:40px;left:400px;z-index:10000;> ".$uemail."</span>"; 
                        		//echo "<span style=position:relative;top:40px;left:400px;z-index:10000;> ".$websiteurl."</span>"; 
                        		$isdoap = $gid;
    					return $isdoap;
                		}
			}

	}
//jquery datepicker stuff
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
// Display featured image if toggle is on.
if( !function_exists( 'responsive_pro_featured_image' ) ) {
    function responsive_pro_featured_image() {
global $wpdb, $post;
        // Get value of post byline tags toggle option from theme option for different pages
        if( is_single() ) {
            $show_image = responsive_pro_get_option( 'single_featured_images' );
		$post_categories = wp_get_post_categories($post->ID);
		if (in_array(3680, $post_categories)) $is_portada_impresa = 1;
//var_dump($post);
//var_dump($post_categories);
//echo "is portada impresa = $is_portada_impresa";
//echo 'post id = ' . $post->ID;
        }
        elseif( is_archive() ) {
            $show_image = responsive_pro_get_option( 'archive_featured_images' );
        }
        else {
            $show_image = responsive_pro_get_option( 'blog_featured_images' );
        }

        if( $show_image && has_post_thumbnail() ) {
		$image_info = wp_get_attachment_metadata( get_post_thumbnail_id($post->ID) );
//var_dump($image_info);
		$img_width = ($image_info['width'] < 400) ? $image_info['width'] : $image_info['width'];
		$cap_bottom = ($image_info['width'] < 400) ? '10px' : 0;
		$img_height = ($image_info['width'] < 400) ? $image_info['height'] : $image_info['height'];
		$padding_right_bottom = ($img_width < 400) ? 'margin-bottom:0;margin-right:10px;padding-right:10px;padding-bottom:10px;' : '';
//echo '<div id=image-and-caption" style="position:relative;float:left;max-width:' . $img_width . 'px;' . $padding_right_bottom . 'min-height:' . $img_height . 'px;">';
echo '<div id=image-and-caption" style="position:relative;float:left;max-width:100%;' . $padding_right_bottom . '">';

//echo '<div class="featured-image" style="max-width:' . $img_width . 'px;' . $padding_right_bottom . 'min-height:' . $img_height . 'px;">';
echo '<div class="featured-image" style="max-width:' . $img_width . 'px;' . $padding_right_bottom . '">';
if ($is_portada_impresa)
{
the_post_thumbnail( 'responsive-900', array( 'class' => 'alignleft' ) ); 
}
else
{
the_post_thumbnail( 'large', array( 'class' => 'alignleft' ) ); 
}
if( !empty( get_post( get_post_thumbnail_id() )->post_excerpt ) ) { 
echo '<div style="position:absolute;bottom:' . $cap_bottom . ';left:0;width:100%;max-width:' . $img_width . 'px;height:50px;background: rgba(0, 0, 0, 0.5);"><div style="font-family:Arial;font-size:.9em;padding:4px;color:#fff;text-align:left;">' . get_post( get_post_thumbnail_id() )->post_excerpt . '</div></div>';
    }
echo '</div></div>';
		echo '<div class="mobile-spacer"></div>';
		if (isset($img_width) && $img_width > 399) echo '<div style="clear:both;"></div>';
        }
    }
}

function wpbeginner_numeric_posts_nav() {

    if( is_singular() )
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /**	Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /**	Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="navigation"><ul>' . "\n";

    /**	Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

    /**	Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }

    /**	Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /**	Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /**	Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link() );

    echo '</ul></div>' . "\n";

}


function news_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Top Bar Widget', 'responsive' ),
        'description'   => __( 'Area 13 - top bar', 'responsive' ),
        'id'            => 'top-bar-widget',
        'class'            => 'top-bar-widget-container',
        'before_title'  => '',
        'after_title'   => '',
        'before_widget' => '<div id="%1$s" class="top-bar-widget %2$s"><div class="widget-wrapper">',
        'after_widget'  => '</div></div>'
    ) );
}

function news_get_social_icons() {

    $responsive_options = responsive_get_options();

    $sites = array (
        'twitter'     => __( 'Twitter', 'responsive' ),
        'facebook'    => __( 'Facebook', 'responsive' ),
        'linkedin'    => __( 'LinkedIn', 'responsive' ),
        'youtube'     => __( 'YouTube', 'responsive' ),
        'stumbleupon' => __( 'StumbleUpon', 'responsive' ),
        'rss'         => __( 'RSS Feed', 'responsive' ),
        'googleplus'  => __( 'Google+', 'responsive' ),
        'instagram'   => __( 'Instagram', 'responsive' ),
        'pinterest'   => __( 'Pinterest', 'responsive' ),
        'yelp'        => __( 'Yelp!', 'responsive' ),
        'vimeo'       => __( 'Vimeo', 'responsive' ),
        'foursquare'  => __( 'foursquare', 'responsive' ),
    );

    $html = '<ul class="social-icons">';
    foreach( $sites as $key => $value ) {
        if ( !empty( $responsive_options[$key . '_uid'] ) ) {
            $html .= '<li class="' . esc_attr( $key ) . '-icon"><a href="' . $responsive_options[$key . '_uid'] . '">' . '<img src="' . responsive_child_uri( '/core/icons/' . esc_attr( $key ) . '-icon.png' ) . '" alt="' . esc_html( $value ) . '">' . '</a></li>';
        }
    }
    $html .= '</ul><!-- .social-icons -->';

    return $html;

}

add_filter( 'wp_get_attachment_link', 'sant_prettyadd');

function sant_prettyadd ($content) {
    $content = preg_replace("/<a/","<a rel=\"prettyPhoto[slides]\"",$content,1);
//    $content = preg_replace("/<dl(.*)>(.*)<dt(.*)>(.*)<a href=\"(.*)\"><img (.*)><\/a>(.*)<\/dt>(.*)<dd(.*)>(.*)<\/dd>(.*)<\/dl>/","<dl$1><dt$3><a href=\"$5\" title=\"$10\"><img $6 rel=\"prettyPhoto[slides]\"/><\/a><\/dt><dd$9>$10<\/dd><\/dl>",$content,1);
    return $content;
}

function news_theme_setup () {
    add_action( 'wp_enqueue_scripts', 'news_get_social_icons', 1000 );
}
/*
function slider( $atts = null, $content = null ) {
    $return = '';
    $atts = shortcode_atts( array(
        'source'     => 'none',
        'limit'      => 20,
        'gallery'    => null, // Dep. 4.3.2
        'link'       => 'none',
        'target'     => 'self',
        'width'      => 600,
        'height'     => 300,
        'responsive' => 'yes',
        'title'      => 'yes',
        'centered'   => 'yes',
        'arrows'     => 'yes',
        'pages'      => 'yes',
        'mousewheel' => 'yes',
        'autoplay'   => 3000,
        'speed'      => 600,
        'class'      => ''
    ), $atts, 'slider' );
    // Get slides
    $slides = (array) Su_Tools::get_slides( $atts );
    // Loop slides
    if ( count( $slides ) ) {
        // Prepare unique ID
        $id = uniqid( 'su_slider_' );
        // Links target
        $target = ( $atts['target'] === 'yes' || $atts['target'] === 'blank' ) ? ' target="_blank"' : '';
        // Centered class
        $centered = ( $atts['centered'] === 'yes' ) ? ' su-slider-centered' : '';
        // Wheel control
        $mousewheel = ( $atts['mousewheel'] === 'yes' ) ? 'true' : 'false';
        // Prepare width and height
        $size = ( $atts['responsive'] === 'yes' ) ? 'width:100%' : 'width:' . intval( $atts['width'] ) . 'px;height:' . intval( $atts['height'] ) . 'px';
        // Add lightbox class
        if ( $atts['link'] === 'lightbox' ) $atts['class'] .= ' su-lightbox-gallery';
        // Open slider
        $return .= '<div id="' . $id . '" class="su-slider' . $centered . ' su-slider-pages-' . $atts['pages'] . ' su-slider-responsive-' . $atts['responsive'] . su_ecssc( $atts ) . '" style="' . $size . '" data-autoplay="' . $atts['autoplay'] . '" data-speed="' . $atts['speed'] . '" data-mousewheel="' . $mousewheel . '"><div class="su-slider-slides">';
        // Create slides
        foreach ( $slides as $slide ) {
            // Crop the image
            $image = su_image_resize( $slide['image'], $atts['width'], $atts['height'] );
            // Prepare slide title
            $title = ( $atts['title'] === 'yes' && $slide['title'] ) ? '<span class="su-slider-slide-title">' . stripslashes( $slide['title'] ) . '</span>' : '';
            $description = ( $atts['title'] === 'yes' && $slide['description'] ) ? '<span class="su-slider-slide-description">' . stripslashes( $slide['description'] ).  '</span>' : '';
            // Open slide
            $return .= '<div class="su-slider-slide">';
            // Slide content with link
            if ( $slide['link'] ) $return .= '<a href="' . $slide['link'] . '"' . $target . '><img src="' . $image['url'] . '" alt="' . esc_attr( $slide['title'] ) . '" />' . $title . $description. '</a>';
            // Slide content without link
            else $return .= '<a><img src="' . $image['url'] . '" alt="' . esc_attr( $slide['title'] ) . '" />' . $title . '</a>';
            // Close slide
            $return .= '</div>';
        }
        // Close slides
        $return .= '</div>';
        // Open nav section
        $return .= '<div class="su-slider-nav">';
        // Append direction nav
        if ( $atts['arrows'] === 'yes'
        ) $return .= '<div class="su-slider-direction"><span class="su-slider-prev"></span><span class="su-slider-next"></span></div>';
        // Append pagination nav
        $return .= '<div class="su-slider-pagination"></div>';
        // Close nav section
        $return .= '</div>';
        // Close slider
        $return .= '</div>';
        // Add lightbox assets
        if ( $atts['link'] === 'lightbox' ) {
            su_query_asset( 'css', 'magnific-popup' );
            su_query_asset( 'js', 'magnific-popup' );
        }
        su_query_asset( 'css', 'su-galleries-shortcodes' );
        su_query_asset( 'js', 'jquery' );
        su_query_asset( 'js', 'swiper' );
        su_query_asset( 'js', 'su-galleries-shortcodes' );
    }
    // Slides not found
    else $return = '<p class="su-error">Slider: ' . __( 'images not found', 'su' ) . '</p>';
    return $return;
}
*/
add_action( 'after_setup_theme', 'news_theme_setup' );

add_action( 'widgets_init', 'news_widgets_init' );

add_image_size( 'center-top-300x300', 300, 300, array( 'center', 'top' ) );
add_image_size( 'center-top-300x300', 240, 160, array( 'center', 'top' ) );
add_image_size( 'center-top-100x100', 100, 100, array( 'center', 'top' ) );
//add_image_size('Video-Poster-640x360', 640, 360, true);
add_image_size('Video-Poster-640x360', 640, 360, array( 'center', 'top' ) );
add_image_size('lptv-carousel-100x60', 100, 60, array( 'center', 'top' ) );
add_image_size('lptv-slider-300x172', 300, 172, array( 'center', 'top' ) );
add_image_size('caricatura-home', 260, 190, true);

add_filter( 'su/data/shortcodes', 'register_my_custom_shortcode' );

/**
 * Filter to modify original shortcodes data and add custom shortcodes
 *
 * @param array   $shortcodes Original plugin shortcodes
 * @return array Modified array
 */
function register_my_custom_shortcode( $shortcodes ) {
    // Add new shortcode
    $shortcodes['heading2'] = array(
        // Shortcode name
        'name' => __( 'Heading 2', 'textdomain' ),
        // Shortcode type. Can be 'wrap' or 'single'
        // Example: [b]this is wrapped[/b], [this_is_single]
        'type' => 'wrap',
        // Shortcode group.
        // Can be 'content', 'box', 'media' or 'other'.
        // Groups can be mixed, for example 'content box'
        'group' => 'content',
        // List of shortcode params (attributes)
        'atts' => array(
            // Style attribute
            'style' => array(
                // Attribute type.
                // Can be 'select', 'color', 'bool' or 'text'
                'type' => 'select',
                // Available values
                'values' => array(
                    'default' => __( 'Default', 'textdomain' ),
                    'small' => __( 'Small', 'textdomain' )
                ),
                // Default value
                'default' => 'default',
                // Attribute name
                'name' => __( 'Style', 'textdomain' ),
                // Attribute description
                'desc' => __( 'Heading 2 style', 'textdomain' )
            )
        ),
        // Default content for generator (for wrap-type shortcodes)
        'content' => __( 'Heading 2 text', 'textdomain' ),
        // Shortcode description for cheatsheet and generator
        'desc' => __( 'Styled heading 2', 'textdomain' ),
        // Custom icon (font-awesome)
        'icon' => 'plus',
        // Name of custom shortcode function
        'function' => 'su_heading2_shortcode'
    );
    // Return modified data
    return $shortcodes;
}
add_action('init', 'cptui_register_my_cpt_infografia');
function cptui_register_my_cpt_infografia() {
register_post_type('infografia', array(
'label' => 'Infografias',
'description' => 'Infografias',
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'capability_type' => 'post',
'map_meta_cap' => true,
'hierarchical' => false,
'rewrite' => array('slug' => 'infografia', 'with_front' => true),
'query_var' => false,
'supports' => array('title','excerpt','custom-fields','thumbnail','author','page-attributes','post-formats'),
'labels' => array (
  'name' => 'Infografias',
  'singular_name' => 'Infografia',
  'menu_name' => 'Infografias',
  'add_new' => 'Add Infografia',
  'add_new_item' => 'Add New Infografia',
  'edit' => 'Edit',
  'edit_item' => 'Edit Infografia',
  'new_item' => 'New Infografia',
  'view' => 'View Infografia',
  'view_item' => 'View Infografia',
  'search_items' => 'Search Infografias',
  'not_found' => 'No Infografias Found',
  'not_found_in_trash' => 'No Infografias Found in Trash',
  'parent' => 'Parent Infografia',
)
) ); }
function get_doap_excerpt($limit, $dots=NULL, $chars=NULL) {
        remove_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
	remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
        remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
	remove_filter( 'excerpt_more', 'responsive_auto_excerpt_more' );
	remove_filter( 'excerpt_length', 'responsive_excerpt_length' );
        $theexcerpt = get_the_excerpt();
//        add_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
        $numwords = str_word_count($theexcerpt, 0);
        $words = str_word_count($theexcerpt, 2);
	if ($chars)
	{
		$theexcerpt = get_doap_limit_chars($theexcerpt,$limit,$dots);
	}
	else
	{
        	if ($numwords > $limit)
        	{
			if ($dots && strlen($theexcerpt) > 0)
			{
			$dots = '...';
			}
        	        $theexcerpt = implode(' ', array_slice(explode(' ', $theexcerpt), 0, $limit)) . $dots;
        	}
	}
	return $theexcerpt;
}
function get_doap_limit_chars($string, $limit, $dots=NULL) {
        $words = str_word_count($string, 2);
	if ($dots && strlen($string) > 0)
	{
		$dots = '...';
	}
	if (strlen($string) > $limit)
	{
		$wc_start = array_keys($words);
		foreach ($wc_start as $wc_pos)
		{
			$word_end = $wc_pos - 1;
			if ($word_end <= $limit)
			{
				$string_end = $word_end;
			}
		}
		$string = substr($string,0,$string_end) . $dots;
	}
	return $string;

}
//add_filter('posts_clauses', 'filterEdiciones');
add_filter('wp', 'removeQueryFilter');

function removeQueryFilter() {
  remove_filter('posts_clauses', 'filterEdiciones');
}

function alter_query($query)
{
//function filterEdiciones($clauses, $wp_query) {
//if ( is_admin() || !$query->is_main_query() || is_single() || $query->post_type <> 'post' )
//if ( is_admin() || $query->is_main_query() || is_single() || $query->post_type <> 'post' )
if ( is_admin() || is_single() || $query->post_type <> 'post' )
{
	remove_filter('posts_clauses', 'filterEdiciones');
	return;
}
//if ($query->is_main_query() && $query->post_type == 'post')
//if (!$query->is_main_query() && $query->post_type == 'post')
//if (!$query->in_the_loop && $query->post_type == 'post')
else
{
add_filter('posts_clauses', 'filterEdiciones');
	return;
}
}
//add_action('pre_get_posts', 'alter_query');

function alter_query_edicion($query)
{
add_filter('posts_clauses', 'filterEdiciones');
return;
}

function filterEdiciones($clauses) {
global $wpdb, $query;
$clauses['join'] .=<<<SQL
 JOIN {$wpdb->postmeta} AS edicion_meta ON edicion_meta.post_id = {$wpdb->posts}.ID AND edicion_meta.meta_key = 'edicion' JOIN {$wpdb->postmeta} AS peso_meta ON peso_meta.post_id = {$wpdb->posts}.ID AND peso_meta.meta_key = 'peso'
SQL;

  $clauses['orderby'] = " edicion_meta.meta_value DESC";
  $clauses['orderby'] .= ", abs(peso_meta.meta_value) DESC";
  $clauses['orderby'] .= ", {$wpdb->posts}.post_date DESC";
  return $clauses;
}

function filterBreves($clauses) {
global $wpdb, $query;
$clauses['join'] .=<<<SQL
 INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id) 
SQL;

  $clauses['where'] .= "  AND ( ({$wpdb->postmeta}.meta_key = 'breves' AND CAST({$wpdb->postmeta}.meta_value AS SIGNED) = '1') )";
  return $clauses;
}

add_filter('wp', 'removeBrevesFilter');

function removeBrevesFilter() {
  remove_filter('posts_clauses', 'filterBreves');
}

function filterDestacados($clauses) {
global $wpdb, $query;
$clauses['join'] .=<<<SQL
 INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id) 
SQL;

  $clauses['where'] .= "  AND ( ({$wpdb->postmeta}.meta_key = 'destacado' AND CAST({$wpdb->postmeta}.meta_value AS SIGNED) = '1') )";
  return $clauses;
}

add_filter('wp', 'removeDestacadosFilter');

function removeDestacadosFilter() {
  remove_filter('posts_clauses', 'filterDestacados');
}

function filterNoBreves($clauses) {
global $wpdb, $query;
/*$clauses['join'] .=<<<SQL
 LEFT JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id AND {$wpdb->postmeta}.meta_key = 'breves') INNER JOIN {$wpdb->postmeta} AS mt1 ON ({$wpdb->posts}.ID = mt1.post_id)
SQL;
*/
$clauses['join'] .=<<<SQL
 LEFT JOIN {$wpdb->postmeta} AS shawn ON ({$wpdb->posts}.ID = shawn.post_id AND shawn.meta_key = 'breves') 
 INNER JOIN {$wpdb->postmeta} AS destnobreves ON ({$wpdb->posts}.ID = destnobreves.post_id) 
SQL;
  $clauses['where'] .= " AND (shawn.post_id IS NULL OR (shawn.meta_key = 'breves' AND CAST(shawn.meta_value AS SIGNED) = '0')) ";
  $clauses['where'] .= " AND ( (destnobreves.meta_key = 'destacado' AND CAST(destnobreves.meta_value AS SIGNED) = '0') )";
  return $clauses;
}

add_filter('wp', 'removeNoBrevesFilter');

function removeNoBrevesFilter() {
  remove_filter('posts_clauses', 'filterNoBreves');
}

add_action('init', 'cptui_register_my_cpt_marcador');
function cptui_register_my_cpt_marcador() {
register_post_type('marcador', array(
'label' => 'Marcadores',
'description' => 'Resultados de paritidos',
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'capability_type' => 'post',
'map_meta_cap' => true,
'hierarchical' => false,
'rewrite' => array('slug' => 'marcador', 'with_front' => true),
'query_var' => false,
//'has_archive' => true,
'menu_position' => '6',
'supports' => array('title','excerpt','custom-fields','thumbnail','author','page-attributes','post-formats'),
'taxonomies' => array('equipos'),
'labels' => array (
  'name' => 'Marcadores',
  'singular_name' => 'Marcador',
  'menu_name' => 'Marcadores',
  'add_new' => 'Add Marcador',
  'add_new_item' => 'Add New Marcador',
  'edit' => 'Edit',
  'edit_item' => 'Edit Marcador',
  'new_item' => 'New Marcador',
  'view' => 'View Marcador',
  'view_item' => 'View Marcador',
  'search_items' => 'Search Marcadores',
  'not_found' => 'No Marcadores Found',
  'not_found_in_trash' => 'No Marcadores Found in Trash',
  'parent' => 'Parent Marcador',
)
) ); }
add_action('init', 'cptui_register_my_cpt_logo');
function cptui_register_my_cpt_logo() {
register_post_type('logo', array(
'label' => 'Logos',
'description' => 'Logo de equipo',
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'capability_type' => 'post',
'map_meta_cap' => true,
'hierarchical' => false,
'rewrite' => array('slug' => 'logo', 'with_front' => true),
'query_var' => false,
'exclude_from_search' => true,
'menu_position' => '9',
'supports' => array('title','excerpt','custom-fields','thumbnail','author','post-formats'),
'taxonomies' => array('equipos'),
'labels' => array (
  'name' => 'Logos',
  'singular_name' => 'Logo',
  'menu_name' => 'Logos',
  'add_new' => 'Add Logo',
  'add_new_item' => 'Add New Logo',
  'edit' => 'Edit',
  'edit_item' => 'Edit Logo',
  'new_item' => 'New Logo',
  'view' => 'View Logo',
  'view_item' => 'View Logo',
  'search_items' => 'Search Logos',
  'not_found' => 'No Logos Found',
  'not_found_in_trash' => 'No Logos Found in Trash',
  'parent' => 'Parent Logo',
)
) ); }
add_action('init', 'cptui_register_my_taxes_equipos');
function cptui_register_my_taxes_equipos() {
register_taxonomy( 'equipos',array (
  0 => 'logo',
  1 => 'marcador',
),
array( 'hierarchical' => false,
	'label' => 'Equipos',
	'show_ui' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => 'marcador-equipos' ),
	'show_admin_column' => false,
	'labels' => array (
  'search_items' => 'equipo',
  'popular_items' => '',
  'all_items' => '',
  'parent_item' => '',
  'parent_item_colon' => '',
  'edit_item' => '',
  'update_item' => '',
  'add_new_item' => '',
  'new_item_name' => '',
  'separate_items_with_commas' => '',
  'add_or_remove_items' => '',
  'choose_from_most_used' => '',
)
) ); 
}
add_action('init', 'cptui_register_my_taxes_deportes');
function cptui_register_my_taxes_deportes() {
register_taxonomy( 'deportes',array (
  0 => 'logo',
),
array( 'hierarchical' => false,
	'label' => 'Deportes',
	'show_ui' => true,
	'query_var' => false,
	'rewrite' => array( 'slug' => 'marcador-deportes' ),
	'show_admin_column' => false,
	'labels' => array (
  'search_items' => 'deporte',
  'popular_items' => '',
  'all_items' => '',
  'parent_item' => '',
  'parent_item_colon' => '',
  'edit_item' => '',
  'update_item' => '',
  'add_new_item' => '',
  'new_item_name' => '',
  'separate_items_with_commas' => '',
  'add_or_remove_items' => '',
  'choose_from_most_used' => '',
)
) ); 
}
add_action('init', 'cptui_register_my_taxes_ligas');
function cptui_register_my_taxes_ligas() {
register_taxonomy( 'ligas',array (
  0 => 'logo',
),
array( 'hierarchical' => false,
	'label' => 'Ligas',
	'show_ui' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => 'equipo-liga' ),
	'show_admin_column' => false,
	'labels' => array (
  'search_items' => 'liga',
  'popular_items' => '',
  'all_items' => '',
  'parent_item' => '',
  'parent_item_colon' => '',
  'edit_item' => '',
  'update_item' => '',
  'add_new_item' => '',
  'new_item_name' => '',
  'separate_items_with_commas' => '',
  'add_or_remove_items' => '',
  'choose_from_most_used' => '',
)
) ); 
}
function writeComments($color = 'black',$the_post_id='') {
	$num_comments = get_comments_number($the_post_id); // get_comments_number returns only a numeric value
	if ( comments_open($the_post_id) ) {
		if ( $num_comments == 0 ) {
			if ($color == 'white')
			{
				$comments = __(' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/comentarionulo.svg" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios');
			}
			else
			{
				$comments = __(' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios');
			}
		} elseif ( $num_comments > 1 ) {
			if ($color == 'white')
			{
				$comments = __(' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/comentariodoble.svg" style="max-width:100%;border:0px solid #fff;" alt=""> ' . $num_comments . ' Comentarios');
			}
			else
			{
				$comments = __(' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-2.gif" style="max-width:100%;border:0px solid #fff;" alt=""> ' . $num_comments . ' Comentarios');
			}
		} else {
			if ($color == 'white')
			{
			$comments = __(' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/comentario.svg" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario');
			}
			else
			{
				$comments = __(' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario');
			}
		}
		if ($color == 'white')
		{
			$write_comments = '<a class="comments-url" style="color:#fff;" href="' . get_comments_link($the_post_id) .'">'. $comments.'</a>';
		}
		else
		{
			$write_comments = '<a class="comments-url" style="color:#000;" href="' . get_comments_link($the_post_id) .'">'. $comments.'</a>';
		}
	} else {
	$write_comments =  __('Comentarios no han sido habilitados para esta nota.');
	}
	if ($show_cat_in_comments && $single_cat_title)
	{
		$write_comments = $single_cat_title . '  |  ' . $write_comments;
	}
//	echo 'single cat title = ' . $single_cat_title . '           show = ' . $show_cat_in_comments;
	return $write_comments;
}
function addCatForComments($single_cat_title, $single_cat_slug) {
	if ($single_cat_title && $single_cat_slug)
	{
		$cat_url = '/' . $single_cat_slug; 
		$cat_text = '<a class="cat-url" href="' . $cat_url . '">' . $single_cat_title . '  |  ';
		return $cat_text;
	}
	else return;
}
/*
add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
	//add_submenu_page( 'tools.php', 'Importar Suplementos', 'Importar Suplementos', 'edit_others_posts', 'import-supl-template.php', 'my_custom_submenu_page_callback' ); 
	add_submenu_page( 'tools.php', 'Importar Suplementos', 'Importar Suplementos', 'edit_others_posts', 'import-supl-template.php', 'my_custom_submenu_page_callback' ); 
}

function my_custom_submenu_page_callback() {
	
	echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
		echo '<h2>Importar Suplementos</h2>';
	echo '</div>';
	include('import-supl-template.php');

}
*/
function importar_supl_display() {
    //echo '<a href="noticias.laprensa.com.ni/importar-suplementos" target="_blank">Importar Suplementos<a>';
    echo '<h1>Importar desde Almidon</h1>';
    echo '<a href="/importar-secciones" target="_blank"><h3>Importar Secciones</h3><a>';
    echo '<a href="/importar-suplementos" target="_blank"><h3>Importar Suplementos</h3><a>';
}
function importar_supl_page() {
    if (function_exists('add_submenu_page') )
        add_submenu_page('tools.php', 'Importar desde Almidon', 'Importar desde Almidon', 'edit_others_posts', 'importar-desde-almidon', 'importar_supl_display');
}
add_action('admin_menu', 'importar_supl_page');

/** include advertising zones */
require_once('core/includes/functions-advertising-sidebar.php');


/** second set of nav buttons **/
function numeric_posts_nav() {

    if( is_singular() )
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="navigation-box"><ul>' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link() );

    echo '</ul></div>' . "\n";

}

//juans <P> tag filter fix
add_filter( 'tiny_mce_before_init', 'fb_tinymce', 9 );
function fb_tinymce( $init ) {
    $init['wpautop'] = FALSE;
    $init['remove_linebreaks'] = FALSE;
    $init['apply_source_formatting'] = TRUE;
    $init['extended_valid_elements'] .= ',p';
    return $init;
}
