<?php
if ( ! function_exists( 'mb_theme_options' ) ) :
/**
 * Set up the default theme options
 *
 * @param	string $name  The option name
 *
 * @since 3.0.0
 */
function mb_theme_options( $name ) {
	$default_theme_options = array(
		'width' => '',
		'layout' => '5',
		'primary' => 'c6',
		'secondary' => 'c3',
		'tagline' => 'on',
		'link_color' => '#3D97C2',
		'excerpt_content' => 'excerpt',
		'page_background' => '#ffffff',
		'grid' => '3',
		'number' => '6',
		'index_categories' => 'on',
		'display_categories' => 'on',
		'index_date' => 'on',
		'display_date' => 'on',
		'index_author' => 'on',
		'display_author' => 'on',
		'index_comment_count' => 'on',
		'display_comment_count' => 'on',
		'logo' => '',
		'1_image_width' => '560',
		'2_image_width' => '260',
		'3_image_width' => '160',
		'header_alignment' => 'fl',
	);

	$options = get_option( 'mb_theme_options', $default_theme_options );

	return $options[$name];
}
endif;

add_action( 'customize_register', 'mb_customize_register' );
/**
 * Adds theme options to the Customizer screen
 *
 * This function is attached to the 'customize_register' action hook.
 *
 * @param	class $wp_customize
 *
 * @since 3.0.0
 */
function mb_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'mb_theme_options[tagline]', array(
		'default' => mb_theme_options( 'tagline' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_tagline', array(
		'label' => __( 'Display Tagline', 'magazine-basic' ),
		'section' => 'title_tagline',
		'settings' => 'mb_theme_options[tagline]',
		'type' => 'checkbox',
	) );

	$wp_customize->add_setting( 'mb_theme_options[logo]', array(
		'default' => mb_theme_options( 'logo' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
		'label'   => __( 'Site Logo', 'magazine-basic' ),
		'section' => 'title_tagline',
		'settings'   => 'mb_theme_options[logo]',
	) ) );

	$wp_customize->add_setting( 'mb_theme_options[header_alignment]', array(
		'default' => mb_theme_options( 'header_alignment' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_header_alignment', array(
		'label' => __( 'Header Alignment', 'magazine-basic' ),
		'section' => 'title_tagline',
		'settings' => 'mb_theme_options[header_alignment]',
		'type' => 'select',
		'choices' => array(
			'fl' => __( 'Left', 'magazine-basic' ),
			'fr' => __( 'Right', 'magazine-basic' ),
			'center' => __( 'Center', 'magazine-basic' ),
		),
	) );

	$wp_customize->add_section( 'mb_layout', array(
		'title' => __( 'Layout', 'magazine-basic' ),
		'priority' => 35,
	) );

	$choices = array(
		'c2' => '17%',
		'c3' => '25%',
		'c4' => '34%',
		'c5' => '42%',
		'c6' => '50%',
		'c7' => '58%',
		'c8' => '66%',
		'c9' => '75%',
		'c10' => '83%',
		'c12' => '100%',
	);

	$wp_customize->add_setting( 'mb_theme_options[primary]', array(
		'default' => mb_theme_options( 'primary' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_primary_column', array(
		'label' => __( 'Main Content Width', 'magazine-basic' ),
		'section' => 'mb_layout',
		'settings' => 'mb_theme_options[primary]',
		'type' => 'select',
		'choices' => $choices,
	) );

	$wp_customize->add_setting( 'mb_theme_options[width]', array(
		'default' => mb_theme_options( 'width' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_width', array(
		'label' => __( 'Site Width', 'magazine-basic' ),
		'section' => 'mb_layout',
		'settings' => 'mb_theme_options[width]',
		'type' => 'select',
		'choices' => array(
			'' => '1200px',
			'w960' => '960px',
		),
	) );

	$wp_customize->add_setting( 'mb_theme_options[layout]', array(
		'default' => mb_theme_options( 'layout' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_site_layout', array(
		'label' => __( 'Site Layout', 'magazine-basic' ),
		'section' => 'mb_layout',
		'settings' => 'mb_theme_options[layout]',
		'type' => 'radio',
		'choices' => array(
			'1' => __( '1 Sidebar - Left', 'magazine-basic' ),
			'2' => __( '1 sidebar - Right', 'magazine-basic' ),
			'3' => __( '2 sidebars - Left', 'magazine-basic' ),
			'4' => __( '2 sidebars - Right', 'magazine-basic' ),
			'5' => __( '2 sidebars - Separate', 'magazine-basic' ),
			'6' => __( 'No Sidebars', 'magazine-basic' ),
		),
	) );

	$wp_customize->add_setting( 'mb_theme_options[secondary]', array(
		'default' => mb_theme_options( 'secondary' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_secondary_column', array(
		'label' => __( 'First Sidebar Width', 'magazine-basic' ),
		'section' => 'mb_layout',
		'settings' => 'mb_theme_options[secondary]',
		'type' => 'select',
		'choices' => $choices,
	) );

	$wp_customize->add_setting( 'mb_theme_options[display_categories]', array(
		'default' => mb_theme_options( 'display_categories' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_display_categories', array(
		'label' => __( 'Display Categories on inner pages', 'magazine-basic' ),
		'section' => 'mb_layout',
		'settings' => 'mb_theme_options[display_categories]',
		'type' => 'checkbox',
	) );

	$wp_customize->add_setting( 'mb_theme_options[display_author]', array(
		'default' => mb_theme_options( 'display_author' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_display_author', array(
		'label' => __( 'Display Author on inner pages', 'magazine-basic' ),
		'section' => 'mb_layout',
		'settings' => 'mb_theme_options[display_author]',
		'type' => 'checkbox',
	) );

	$wp_customize->add_setting( 'mb_theme_options[display_date]', array(
		'default' => mb_theme_options( 'display_date' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_display_date', array(
		'label' => __( 'Display Date on inner pages', 'magazine-basic' ),
		'section' => 'mb_layout',
		'settings' => 'mb_theme_options[display_date]',
		'type' => 'checkbox',
	) );

	$wp_customize->add_setting( 'mb_theme_options[display_comment_count]', array(
		'default' => mb_theme_options( 'display_comment_count' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_display_comment_count', array(
		'label' => __( 'Display Comment Count on inner pages', 'magazine-basic' ),
		'section' => 'mb_layout',
		'settings' => 'mb_theme_options[display_comment_count]',
		'type' => 'checkbox',
	) );

	$wp_customize->add_section( 'mb_front_page', array(
		'title' => __( 'Front Page', 'magazine-basic' ),
		'priority' => 40,
	) );

	$wp_customize->add_setting( 'mb_theme_options[excerpt_content]', array(
		'default' => mb_theme_options( 'excerpt_content' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_front_page_excerpt_content', array(
		'label' => __( 'Post Content Display', 'magazine-basic' ),
		'section' => 'mb_front_page',
		'settings' => 'mb_theme_options[excerpt_content]',
		'type' => 'radio',
		'choices' => array(
			'excerpt' => __( 'Teaser Excerpt', 'magazine-basic' ),
			'content' => __( 'Full Content', 'magazine-basic' ),
		),
		'priority' => 25,
	) );

	$wp_customize->add_setting( 'mb_theme_options[grid]', array(
		'default' => mb_theme_options( 'grid' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_front_page_grid', array(
		'label' => __( 'Grid Layout', 'magazine-basic' ),
		'section' => 'mb_front_page',
		'settings' => 'mb_theme_options[grid]',
		'type' => 'radio',
		'choices' => array(
			'1' => __( 'Single', 'magazine-basic' ),
			'2' => __( 'Single - Two Columns', 'magazine-basic' ),
			'3' => __( 'Single - Two Columns - Three Columns', 'magazine-basic' ),
			'4' => __( 'Single - Three Columns', 'magazine-basic' ),
		),
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'mb_theme_options[number]', array(
		'default' => mb_theme_options( 'number' ),
		'type' => 'option',
		'sanitize_callback' => 'mb_sanitize_int',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_front_page_number', array(
		'label' => __( 'Number of Posts', 'magazine-basic' ),
		'section' => 'mb_front_page',
		'settings' => 'mb_theme_options[number]',
		'priority' => 35,
	) );

	$wp_customize->add_setting( 'mb_theme_options[index_categories]', array(
		'default' => mb_theme_options( 'index_categories' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_front_page_categories', array(
		'label' => __( 'Display Categories', 'magazine-basic' ),
		'section' => 'mb_front_page',
		'settings' => 'mb_theme_options[index_categories]',
		'type' => 'checkbox',
		'priority' => 40,
	) );

	$wp_customize->add_setting( 'mb_theme_options[index_author]', array(
		'default' => mb_theme_options( 'index_author' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_front_page_author', array(
		'label' => __( 'Display Author', 'magazine-basic' ),
		'section' => 'mb_front_page',
		'settings' => 'mb_theme_options[index_author]',
		'type' => 'checkbox',
		'priority' => 45,
	) );

	$wp_customize->add_setting( 'mb_theme_options[index_date]', array(
		'default' => mb_theme_options( 'index_date' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_front_page_date', array(
		'label' => __( 'Display Date', 'magazine-basic' ),
		'section' => 'mb_front_page',
		'settings' => 'mb_theme_options[index_date]',
		'type' => 'checkbox',
		'priority' => 50,
	) );

	$wp_customize->add_setting( 'mb_theme_options[index_comment_count]', array(
		'default' => mb_theme_options( 'index_comment_count' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'mb_front_page_comment_count', array(
		'label' => __( 'Display Comment Count', 'magazine-basic' ),
		'section' => 'mb_front_page',
		'settings' => 'mb_theme_options[index_comment_count]',
		'type' => 'checkbox',
		'priority' => 55,
	) );

	$wp_customize->add_setting( 'mb_theme_options[1_image_width]', array(
		'default' => mb_theme_options( '1_image_width' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'mb_sanitize_int',
	) );

	$wp_customize->add_control( 'mb_front_page_1_image_width', array(
		'label' => __( '1 Column Image Width (pixels)', 'magazine-basic' ),
		'section' => 'mb_front_page',
		'settings' => 'mb_theme_options[1_image_width]',
		'priority' => 60,
	) );

	$wp_customize->add_setting( 'mb_theme_options[2_image_width]', array(
		'default' => mb_theme_options( '2_image_width' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'mb_sanitize_int',
	) );

	$wp_customize->add_control( 'mb_front_page_2_image_width', array(
		'label' => __( '2 Column Image Width (pixels)', 'magazine-basic' ),
		'section' => 'mb_front_page',
		'settings' => 'mb_theme_options[2_image_width]',
		'priority' => 70,
	) );

	$wp_customize->add_setting( 'mb_theme_options[3_image_width]', array(
		'default' => mb_theme_options( '3_image_width' ),
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'mb_sanitize_int',
	) );

	$wp_customize->add_control( 'mb_front_page_3_image_width', array(
		'label' => __( '3 Column Image Width (pixels)', 'magazine-basic' ),
		'section' => 'mb_front_page',
		'settings' => 'mb_theme_options[3_image_width]',
		'priority' => 80,
	) );

	$wp_customize->add_setting( 'mb_theme_options[page_background]', array(
		'default' => mb_theme_options( 'page_background' ),
		'type' => 'option',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'page_background', array(
		'label' => __( 'Page Background', 'magazine-basic' ),
		'section' => 'colors',
		'settings' => 'mb_theme_options[page_background]',
	) ) );

	$wp_customize->add_setting( 'mb_theme_options[link_color]', array(
		'default' => mb_theme_options( 'link_color' ),
		'type' => 'option',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label' => __( 'Link Color', 'magazine-basic' ),
		'section' => 'colors',
		'settings' => 'mb_theme_options[link_color]',
	) ) );
}

add_action( 'customize_controls_print_footer_scripts', 'mb_customize_sidebar' );
function mb_customize_sidebar() {
	?>
<script>
( function( $ ){
	var start_value = $( 'input[name="_customize-radio-mb_site_layout"]:checked' ).val();
	show_controls( start_value );
	$( 'input[name="_customize-radio-mb_site_layout"]' ).change(function() {
		var value = $( 'input[name="_customize-radio-mb_site_layout"]:checked' ).val();
		show_controls( value );
	});
	function show_controls( value ) {
		if ( 1 == value || 2 == value || 6 == value )
			$( '#customize-control-mb_secondary_column' ).hide();
		else
			$( '#customize-control-mb_secondary_column' ).show();
	}
} )( jQuery );
</script>
	<?php
}

/**
 * Sanitize integers
 *
 * @since 3.0.0
 */
function mb_sanitize_int( $int ) {
	if ( '' === $int )
		return '';

	return (int) $int;
}

add_action( 'admin_bar_menu', 'mb_add_admin_bar_menu_item', 1 );
/**
 * Add a 'Theme Options' menu item to the admin bar
 *
 * This function is attached to the 'admin_bar_menu' action hook.
 *
 * @since 3.0.0
 */
function mb_add_admin_bar_menu_item( $wp_admin_bar ) {
    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() )
    	$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'customize_theme', 'title' => __( 'Theme Options', 'magazine-basic' ), 'href' => admin_url( 'customize.php' ) ) );
}

add_action( 'admin_head', 'custom_menu_css' );
function custom_menu_css() {
    ?>
<style type="text/css">
	#wp-admin-bar-theme_previews .ab-item { height: auto !important; }
    #admin-bar-premium-themes { float: left; }
    #admin-bar-premium-themes p { color: #000 !important; }
    #admin-bar-premium-themes p.top-p { margin-top: 10px !important; }
    #admin-bar-premium-themes p, #admin-bar-premium-themes a { text-shadow: none !important; }
    #admin-bar-premium-themes a { padding: 0 !important; margin-bottom: 10px !important; display: inline-block !important; }
    #admin-bar-premium-themes img { margin: 5px; border: 1px solid #ccc; }
</style>
    <?php
}

add_action ( 'admin_menu', 'mb_add_link_admin' );
/**
 * Add a 'Theme Options' menu item to the Appearance panel
 *
 * This function is attached to the 'admin_menu' action hook.
 *
 * @since 3.0.0
 */
function mb_add_link_admin() {
	add_theme_page( 'Customize', 'Theme Options', 'edit_theme_options', 'customize.php' );
}