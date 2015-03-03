<?php
/**
 * Swift design options initialization
 *
 * We define our theme design options array here.
 */
GLOBAL $swift_image_repeat, $swift_font_stack, $swift_font_unit, $swift_font_style, $swift_font_weight;
GLOBAL $swift_text_transform, $swift_design_options_init, $swift_options_init,$swift_design_options;

$swift_image_repeat 	= array( 'repeat' => 'repeat', 'no-repeat' => 'no-repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y' );

$swift_font_stack = array(
		array('inherit', ''),
		array('Arial, "Helvetica Neue", Helvetica, sans-serif', '{ p, t }' ),
		array('Baskerville, "Times New Roman", Times, serif', '{ p }' ),
		array('Baskerville, Times, "Times New Roman", serif', '{ t }' ),
		array('Cambria, Georgia, Times, "Times New Roman", serif', '{ p, t }' ),
		array('"Century Gothic", "Apple Gothic", sans-serif', '{ p, t }' ),
		array('Consolas, "Lucida Console", Monaco, monospace', '{ p, t }' ),
		array('"Copperplate Light", "Copperplate Gothic Light", serif', '{ p, t }' ),
		array('"Courier New", Courier, monospace', '{ p, t }' ),
		array('"Franklin Gothic Medium", "Arial Narrow Bold", Arial, sans-serif', '{ p, t }' ),
		array('Futura, "Century Gothic", AppleGothic, sans-serif', '{ p, t }' ),
		array('Garamond, "Hoefler Text", Times New Roman, Times, serif', '{ p }' ),
		array('Garamond, "Hoefler Text", Palatino, "Palatino Linotype", serif', '{ t }' ),
		array('Geneva, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", Verdana, sans-serif', '{ p }' ),
		array('Geneva, Verdana, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif', '{ t }' ),
		array('Georgia, Palatino," Palatino Linotype", Times, "Times New Roman", serif', '{ p }' ),
		array('Georgia, Times, "Times New Roman", serif', '{ t }' ),
		array('"Gill Sans", Calibri, "Trebuchet MS", sans-serif', '{ p }' ),
		array('"Gill Sans", "Trebuchet MS", Calibri, sans-serif', '{ t }' ),
		array('"Helvetica Neue", Arial, Helvetica, sans-serif', '{ p }' ),
		array('Helvetica, "Helvetica Neue", Arial, sans-serif', '{ t }' ),
		array('Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif', '{ p, t }' ),
		array('"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif', '{ p, t }' ),
		array('Palatino, "Palatino Linotype", Georgia, Times, "Times New Roman", serif', '{ p }' ),
		array('Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif', '{ t }' ),
		array('Tahoma, Geneva, Verdana', '{ p }' ),
		array('Tahoma, Verdana, Geneva', '{ t }' ),
		array('Times, "Times New Roman", Georgia, serif', '{ p, t }' ),
		array('"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande","Lucida Sans", Arial, sans-serif', '{ p }' ),
		array('"Trebuchet MS", Tahoma, Arial, sans-serif', '{ t }' ),
		array('Verdana, Geneva, Tahoma, sans-serif', '{ p }' ),
		array('Verdana, Tahoma, Geneva, sans-serif', '{ t }' )
);
if (isset ($swift_design_options['fontstack1']) || isset ($swift_design_options['fontstack2']))
	array_unshift($swift_font_stack, array ($swift_design_options['fontstack1'],''), array ($swift_design_options['fontstack2'],''));
if(isset($swift_design_options['swift_gfonts']) && is_array($swift_design_options['swift_gfonts'])){
	foreach($swift_design_options['swift_gfonts'] as $font){
		if( $font[1] && $font[2] ){
			array_unshift($swift_font_stack,array($font[0],'{ For blogname and tagname only }'));
		}else{
			if( $font[1] )
				array_unshift($swift_font_stack,array($font[0],'{ For blogname only }'));
			if( $font[2] )
				array_unshift($swift_font_stack,array($font[0],'{ For tagname only }'));
		}
		if( !$font[1] && !$font[2] ){
			array_unshift($swift_font_stack,array($font[0],'{ Entire font }'));
		}
	}
}


$swift_font_unit 		= array( 'px' => 'px', 'em' => 'em' );
$swift_font_style 		= array( 'normal' => 'Normal', 'italic' => 'italic', 'oblique' => 'oblique' );
$swift_font_weight 		= array ( 'normal' => 'normal', 'bold' => 'bold', 'bolder' => 'bolder', 'lighter' => 'lighter' );
$swift_text_transform	= array( 'none' => 'none', 'capitalize' =>'capitalize', 'lowercase'=> 'lowercase' , 'uppercase' => 'uppercase' );

$swift_design_options_init[] = array( 'name' => __( 'tag', 'swift' ),
		'id' => 'which',
		'default' => 'design_options',
		'type' => 'hidden',
		'datatype' => 'none');

$swift_design_options_init[] = array( 'name' => __( 'Layout options', 'swift' ),
		'id' => 'layout-options',
		'type' => 'heading',
		'datatype' => 'none');

$swift_design_options_init[] = array(  'name' => __( 'Enable mobile layout', 'swift' ),
		'desc' => __( 'Enable responsive layout for mobiles and tablets', 'swift' ),
		'id' => 'enable_responsive',
		'type' => 'checkbox',
		'default' => true,
		'datatype' => 'bool' );

$swift_design_options_init[] = array( 'name' => __('Layout width', 'swift' ),
		'desc' => __('Swift default layout width is 956px and is optimized for widths in 960 &plusmn; 20px range. However, you are free to use any width. Enter the site width above without units.', 'swift' ),
		'id' => 'wrapper_width',
		'default' => '956',
		'type' => 'text',
		'datatype' => 'float');

$swift_design_options_init[] = array( 'name' => __('Input widths', 'swift' ),
		'desc' => __('', 'swift' ),
		'id' => 'swift_set_widths',
		'type' => 'function',
		'datatype' => 'none');

$swift_design_options_init[] = array( 'name' => __('Content width', 'swift' ),
		'desc' => __('Swift default layout width is 956px and is optimized for widths in 960 &plusmn; 20px range. However, you are free to use any width. Enter the site width above without units.', 'swift' ),
		'id' => 'content_width',
		'default' => '61.9',
		'type' => 'hidden',
		'datatype' => 'float');

$swift_design_options_init[] = array( 'name' => __('Sidebar one width', 'swift' ),
		'desc' => __('Swift default layout width is 956px and is optimized for widths in 960 &plusmn; 20px range. However, you are free to use any width. Enter the site width above without units.', 'swift' ),
		'id' => 'sb1_width',
		'default' => '23.3',
		'type' => 'hidden',
		'datatype' => 'float');




$swift_design_options_init[] = array( 'name' => __( 'Backgrounds usage', 'swift' ),
		'id' => 'layout-explanation',
		'type' => 'explain',
		'desc' => '<ul>
		<li>'.sprintf( __( 'The fluid layout will fill the entire screen. While it looks good on small screens, it makes it difficult to read posts on large monitors because users have to move not only their eyes but also their heads; in addition, %ssliders and magazine layout don\'t work%s with the fluid layout. Select this option only if you know what you are doing.', 'swift' ), '<strong>', '</strong>').'</li>
		<li>'.__( 'The fixed layout is centered with empty spaces on both sides.', 'swift' ).'</li>
		<li>'.__( 'The hybrid layout is a mix of the fixed and fluid ones. The header and footer are both fluid with centered contents, while the actual post and sidebar contents area has empty spaces on both side as in the fixed layout.', 'swift' ).'</li>
		</ul>',
		'datatype' => 'none' );

$swift_design_options_init[] = array( 'name' => __( 'Layout type', 'swift' ),
		'desc' => __( 'Pick a layout type.', 'swift' ),
		'id' => 'layout',
		'default' => 'fixed',
		'type' => 'radio',
		'options' => array( 'fluid' => 'fluid', 'fixed' => 'fixed'),
		'datatype' => 'predefined' );

$swift_design_options_init[] = array( 'name' => __( 'Navigation style', 'swift' ),
		'desc' => __( 'Select a navigation style.', 'swift' ),
		'id' => 'nav_style',
		'default' => 'solid',
		'type' => 'radio',
		'options' => array( 'bordered' => 'bordered', 'solid' => 'solid' ),
		'datatype' => 'predefined' );

$swift_design_options_init[] = array(  'name' => __( 'Remove borders from the above bordered navigation.', 'swift' ),
		'desc' => __( 'Check this box to remove the borders', 'swift' ),
		'id' => 'bordered_nav_border_remove',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool' );


$swift_design_options_init[] = array(  'name' => __( 'Animate dropdowns', 'swift' ),
		'desc' => __( 'Check this box to enable animation for dropdown menus', 'swift' ),
		'id' => 'dropdown_animation_enable',
		'type' => 'checkbox',
		'default' => true,
		'datatype' => 'bool' );

$swift_design_options_init[] = array( 'name' => __( 'Sidebar position', 'swift' ),
		'desc' => __( 'Select the sidebar position here, if you want only one sidebar don\'t add widgets to the narrow sidebars.', 'swift' ),
		'id' => 'sb_position',
		'default' => 'right',
		'type' => 'radio',
		'options' => array( 'right' => 'right', 'left' => 'left' ),
		'datatype' => 'predefined' );

$swift_design_options_init[] = array( 'name' => __( 'Blog layout', 'swift' ),
		'desc' => __('Select the layout type for blog and archives page.', 'swift'),
		'id' => 'blog_or_mag',
		'default' => 'blog',
		'type' => 'radio',
		'options' => array( 'magazine'=>'magazine', 'blog' => 'blog'),
		'datatype' => 'predefined');

$swift_design_options_init[] = array( 'name' => __( 'Archives layout', 'swift' ),
		'desc' => __('Select the layout type for blog and archives page.', 'swift'),
		'id' => 'blog_or_mag_archives',
		'default' => 'blog',
		'type' => 'radio',
		'options' => array( 'magazine'=>'magazine', 'blog' => 'blog'),
		'datatype' => 'predefined');

$swift_design_options_init[] = array(  'name' => __( 'Show different number of posts on archives', 'swift' ),
		'desc' => __( 'Checking this to enable custom setting for the number of posts on archive pages', 'swift' ),
		'id' => 'archive_post_count_enable',
		'type' => 'checkbox',
		'default' => false,
		'datatype' => 'bool' );

$swift_design_options_init[] = array( 'name' => __( 'Number of posts for archives', 'swift' ),
		'desc' => __('If you want to show a different number of posts on the archives compared to the index, you can do that here', 'swift'),
		'id' => 'archive_post_count',
		'default' => '16',
		'type' => 'select',
		'options' => array( 1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15, 16=>16, 17=>17, 18=>18, 19=>19, 20=>20,21=>21,22=>22,23=>23,24=>24,25=>25,
				26=>26,27=>27,28=>28,29=>29,30=>30,35=>35,40=>40,50=>50,75=>75,100=>100),
		'datatype' => 'predefined');


$swift_design_options_init[] = array( 'name' => __( 'Number of columns for magazine layout with sidebar', 'swift' ),
		'desc' => __('If you selected the magazine layout in the above option, you can set the number of columns here.', 'swift'),
		'id' => 'cn_ws',
		'default' => '2',
		'type' => 'radio',
		'options' => array( 2 => 2, 3 => 3 ),
		'datatype' => 'predefined');


$swift_design_options_init[] = array(  'name' => __( 'Display excerpts in magazine layout', 'swift' ),
		'desc' => __( 'Check this box if you want to show excerpts in magazine layout.', 'swift' ),
		'id' => 'mag_excerpts_enable',
		'type' => 'checkbox',
		'default' => true,
		'datatype' => 'bool' );

$swift_design_options_init[] = array(  'name' => __( 'Disable masonry and set all magazine boxes to the same height', 'swift' ),
		'desc' => __( 'Checking this box will make all the magazine boxes even, and the thumbnails will be cropped.', 'swift' ),
		'id' => 'enable_fixed_height_mag',
		'type' => 'checkbox',
		'default' => true,
		'datatype' => 'bool' );


$swift_design_options_init[] = array( 'name' => __( 'Height of magazine box content', 'swift' ),
		'desc' => __( 'Enter the maximum height of magazine box content. (Enter the value without units.)', 'swift' ),
		'id' => 'mag_content_height',
		'default' => '300',
		'type' => 'text',
		'datatype'=>'int');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing general-settings
/*
$swift_design_options_init[] = array( 'name' => __( 'Background images', 'swift' ),
		'id' => 'background-images',
		'type' => 'heading',
		'datatype' => 'none');

$swift_design_options_init[] = array( 'name' => __( 'Backgrounds usage', 'swift' ),
		'id' => 'backgrounds-explanation',
		'type' => 'explain',
		'desc' => sprintf( __( 'You can set the backgrounds of various layout elements here. To set the position of the background, enter the top and left values along with units. %sExample: 100px or 20%%%s.', 'swift' ), '<strong>', '</strong>'),
		'datatype' => 'none' );


$swift_design_options_init[] = array( 'name' => __( 'Body background', 'swift' ),
		'desc' => __( 'Enter the URL of the image to be used as the body background.', 'swift' ),
		'id' => 'body_bg_image',
		'default' => '',
		'type' => 'upload',
		'datatype'=>'background');

$swift_design_options_init[] = array( 'name' => __( 'Wrapper background', 'swift' ),
		'desc' => __( 'Enter the URL of the image to be used as the wrapper background.', 'swift' ).'<br />'.
		__( 'Wrapper is the div that holds the header, content, sidebars and footer.', 'swift' ).'<br />'.
		__( 'If you are using hybrid or fluid layout, wrapper will be same as body.', 'swift' ),
		'id' => 'wrapper_bg_image',
		'default' => '',
		'type' => 'upload',
		'datatype'=>'background');

$swift_design_options_init[] = array( 'name' => __( 'Main background', 'swift' ),
		'desc' => __( 'Enter the URL of the image to be used as the content background ( background for the div that holds posts and the sidebar ).', 'swift' ),
		'id' => 'main_bg_image',
		'default' => '',
		'type' => 'upload',
		'datatype'=>'background');

$swift_design_options_init[] = array( 'name' => __( 'Header background', 'swift' ),
		'desc' => __( 'Enter the URL of the image to be used as the header background.', 'swift' ),
		'id' => 'header_bg_image',
		'default' => '',
		'type' => 'upload',
		'datatype'=>'background');


$swift_design_options_init[] = array( 'name' => __('Header height', 'swift' ),
		'desc' => __('If your header background is not completely visible, set the header height equal to the height of background image (Enter the value without units)', 'swift' ),
		'id' => 'header-height',
		'default' => '',
		'type' => 'text',
		'datatype' => 'int');


$swift_design_options_init[] = array( 'name' => __( 'Sidebar background', 'swift' ),
		'desc' => __( 'Enter the URL of the image to be used as the sidebar background.', 'swift' ),
		'id' => 'sidebar_bg_image',
		'default' => '',
		'type' => 'upload',
		'datatype'=>'background');

$swift_design_options_init[] = array( 'name' => __( 'Footer background', 'swift' ),
		'desc' => __( 'Enter the URL of the image to be used as the footer background.', 'swift' ),
		'id' => 'footer_bg_image',
		'default' => '',
		'type' => 'upload',
		'datatype'=>'background');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing general-settings
*/
$swift_design_options_init[] = array( 'name' => __( 'Color options', 'swift' ),
		'id' => 'color-options',
		'type' => 'heading',
		'datatype' => 'none');

$swift_design_options_init[] = 'color_options_start';

$swift_design_options_init[] = array( 'name' => __( 'Enable custom colors for mobile layout', 'swift' ).' <a href="#" id="expand" class="alignright button">[+] expand all</a>',
		'id' => 'enable_custom_colors_mobile',
		'desc' => __('Check this box to enable custom colors for responsive layout', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __( 'Responsive colors', 'swift' ),
		'id' => 'responsive-colors',
		'desc' => '',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Nav background', 'swift' ),
		'desc' => '',
		'id' => 'mo_nav_bg',
		'default' => '000',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Nav menu icon bg', 'swift' ),
		'desc' => '',
		'id' => 'mo_nav_icon_bg',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Nav link color', 'swift' ),
		'desc' => '',
		'id' => 'mo_nav_a',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Mobile colors


$swift_design_options_init[] = array( 'name' => __( 'Enable custom colors', 'swift' ),
		'id' => 'enable_custom_colors',
		'desc' => __('Check this box to enable custom colors', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __( 'Layout & default colours', 'swift' ),
		'id' => 'default_colors',
		'desc' => '',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Body background', 'swift' ),
		'desc' => '',
		'id' => 'body_bg',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Wrapper background', 'swift' ),
		'desc' => '',
		'id' => 'wrapper_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Content + Sidebar bg', 'swift' ),
		'desc' => '',
		'id' => 'main_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Sidebar background', 'swift' ),
		'desc' => '',
		'id' => 'sb_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Footer background', 'swift' ),
		'desc' => '',
		'id' => 'fo_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('AD above header background', 'swift' ),
		'desc' => '',
		'id' => 'above_header_ad_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('AD below header background', 'swift' ),
		'desc' => '',
		'id' => 'nav_ad_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'name' => __('Footer AD background', 'swift' ),
		'desc' => '',
		'id' => 'fo_ad_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Copyright background', 'swift' ),
		'desc' => '',
		'id' => 'copy_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Text color', 'swift' ),
		'desc' => '',
		'id' => 'body',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link color', 'swift' ),
		'desc' => '',
		'id' => 'body_a',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link hover color', 'swift' ),
		'desc' => '',
		'id' => 'body_a_h',
		'default' => 'F00',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Default colors


$swift_design_options_init[] = array( 'name' => __( 'Header colours', 'swift' ),
		'id' => 'header_colors',
		'desc' => '',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Header background', 'swift' ),
		'desc' => '',
		'id' => 'header_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Blog name color', 'swift' ),
		'desc' => '',
		'id' => 'blog_name',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Tag line color', 'swift' ),
		'desc' => '',
		'id' => 'blog_tagline',
		'default' => 'CCC',
		'type' => 'color',
		'datatype' => 'color');



$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Navigation colors


$swift_design_options_init[] = array( 'name' => __( 'Bordered nav menu{above logo}', 'swift' ),
		'id' => 'b_nav_above_logo',
		'desc' => '',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');


$swift_design_options_init[] = array( 'name' => __('Navigation background', 'swift' ),
		'desc' => '',
		'id' => 'nav_a_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Thick border color', 'swift' ),
		'desc' => '',
		'id' => 'nav_a_thick_border',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Thin border color', 'swift' ),
		'desc' => '',
		'id' => 'nav_a_thin_border',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link color', 'swift' ),
		'desc' => '',
		'id' => 'nav_a_menu_a',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link background', 'swift' ),
		'desc' => '',
		'id' => 'nav_a_menu_a_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link separator ( On hover )', 'swift' ),
		'desc' => '',
		'id' => 'nav_a_menu_a_sep',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link hover color', 'swift' ),
		'desc' => '',
		'id' => 'nav_a_menu_a_h',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link hover background', 'swift' ),
		'desc' => '',
		'id' => 'nav_a_menu_a_h_bg',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');



$swift_design_options_init[] = array( 'name' => __('Dropdown links color', 'swift' ),
		'desc' => '',
		'id' => 'nav_a_menu_dropdown_a',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');




$swift_design_options_init[] = array( 'name' => __('Dropdown links bg', 'swift' ),
		'desc' => '',
		'id' => 'nav_a_menu_dropdown_a_bg',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Dropdown links hover color', 'swift' ),
		'desc' => '',
		'id' => 'nav_a_menu_dropdown_a_h',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Menu dropdown links hover bg', 'swift' ),
		'desc' => '',
		'id' => 'nav_a_menu_dropdown_a_h_bg',
		'default' => 'CCC',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Bordered nav above logo colors


$swift_design_options_init[] = array( 'name' => __( 'Bordered nav menu{Below logo}', 'swift' ),
		'id' => 'b_nav_below_logo',
		'desc' => '',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');


$swift_design_options_init[] = array( 'name' => __('Navigation background', 'swift' ),
		'desc' => '',
		'id' => 'nav_b_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Thick border color', 'swift' ),
		'desc' => '',
		'id' => 'nav_b_thick_border',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Thin border color', 'swift' ),
		'desc' => '',
		'id' => 'nav_b_thin_border',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link color', 'swift' ),
		'desc' => '',
		'id' => 'nav_b_menu_a',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link background', 'swift' ),
		'desc' => '',
		'id' => 'nav_b_menu_a_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link separator ( On hover )', 'swift' ),
		'desc' => '',
		'id' => 'nav_b_menu_a_sep',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link hover color', 'swift' ),
		'desc' => '',
		'id' => 'nav_b_menu_a_h',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link hover background', 'swift' ),
		'desc' => '',
		'id' => 'nav_b_menu_a_h_bg',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'name' => __('Dropdown links color', 'swift' ),
		'desc' => '',
		'id' => 'nav_b_menu_dropdown_a',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'name' => __('Dropdown links hover color', 'swift' ),
		'desc' => '',
		'id' => 'nav_b_menu_dropdown_a_h',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Dropdown links bg', 'swift' ),
		'desc' => '',
		'id' => 'nav_b_menu_dropdown_a_bg',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Menu dropdown links hover bg', 'swift' ),
		'desc' => '',
		'id' => 'nav_b_menu_dropdown_a_h_bg',
		'default' => 'CCC',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Bordered nav colors below logo


$swift_design_options_init[] = array( 'name' => __( 'Solid nav menu {above logo}', 'swift' ),
		'id' => 's_nav_above_logo',
		'desc' => '',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');


$swift_design_options_init[] = array( 'name' => __('Navigation background', 'swift' ),
		'desc' => '',
		'id' => 'nav1_a_bg',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link color', 'swift' ),
		'desc' => '',
		'id' => 'nav1_a_menu_a',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link background', 'swift' ),
		'desc' => '',
		'id' => 'nav1_a_menu_a_bg',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link hover color', 'swift' ),
		'desc' => '',
		'id' => 'nav1_a_menu_a_h',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'name' => __('Link hover background', 'swift' ),
		'desc' => '',
		'id' => 'nav1_a_menu_a_h_bg',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

/*
 $swift_design_options_init[] = array( 'name' => __('Dropdown links color', 'swift' ),
 		'desc' => '',
 		'id' => 'nav1_a_menu_dropdown_a',
 		'default' => 'FFF',
 		'type' => 'color',
 		'datatype' => 'color');


$swift_design_options_init[] = array( 'name' => __('Dropdown links bg', 'swift' ),
		'desc' => '',
		'id' => 'nav1_a_menu_dropdown_a_bg',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');
*/
$swift_design_options_init[] = array( 'name' => __('Dropdown links hover color', 'swift' ),
		'desc' => '',
		'id' => 'nav1_a_menu_dropdown_a_h',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Dropdown links hover bg', 'swift' ),
		'desc' => '',
		'id' => 'nav1_a_menu_dropdown_a_h_bg',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Solid nav colors above logo



$swift_design_options_init[] = array( 'name' => __( 'Solid nav menu {below logo}', 'swift' ),
		'id' => 's_nav_below_logo',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');



$swift_design_options_init[] = array( 'name' => __('Navigation background', 'swift' ),
		'desc' => '',
		'id' => 'nav1_b_bg',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link color', 'swift' ),
		'desc' => '',
		'id' => 'nav1_b_menu_a',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link background', 'swift' ),
		'desc' => '',
		'id' => 'nav1_b_menu_a_bg',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link hover color', 'swift' ),
		'desc' => '',
		'id' => 'nav1_b_menu_a_h',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'name' => __('Link hover background', 'swift' ),
		'desc' => '',
		'id' => 'nav1_b_menu_a_h_bg',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

/*
 $swift_design_options_init[] = array( 'name' => __('Dropdown links color', 'swift' ),
 		'desc' => '',
 		'id' => 'nav1_b_menu_dropdown_a',
 		'default' => 'FFF',
 		'type' => 'color',
 		'datatype' => 'color');


$swift_design_options_init[] = array( 'name' => __('Dropdown links bg', 'swift' ),
		'desc' => '',
		'id' => 'nav1_b_menu_dropdown_a_bg',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');
*/
$swift_design_options_init[] = array( 'name' => __('Dropdown links hover color', 'swift' ),
		'desc' => '',
		'id' => 'nav1_b_menu_dropdown_a_h',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Dropdown links hover bg', 'swift' ),
		'desc' => '',
		'id' => 'nav1_b_menu_dropdown_a_h_bg',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Solid nav below logo colors


$swift_design_options_init[] = array( 'name' => __( 'Post colors', 'swift' ),
		'id' => 'post_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Post title', 'swift' ),
		'desc' => '',
		'id' => 'post_title',
		'default' => '000',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'name' => __('Post meta', 'swift' ),
		'desc' => '',
		'id' => 'post_meta',
		'default' => 'CCC',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Tags bakground', 'swift' ),
		'desc' => '',
		'id' => 'post_tag_bg',
		'default' => '000',
		'type' => 'color',
		'datatype' => 'color');
$swift_design_options_init[] = array( 'name' => __('Tags hover bakground', 'swift' ),
		'desc' => '',
		'id' => 'post_tag_bg_h',
		'default' => 'F00',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Tags color', 'swift' ),
		'desc' => '',
		'id' => 'post_tag',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Blockquote border', 'swift' ),
		'desc' => '',
		'id' => 'post_blockquote_border',
		'default' => 'F00',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Image caption bg', 'swift' ),
		'desc' => '',
		'id' => 'img_caption_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Image caption border', 'swift' ),
		'desc' => '',
		'id' => 'img_caption_border',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Post  colors


$swift_design_options_init[] = array( 'name' => __( 'News paper colors', 'swift' ),
		'id' => 'newspaper_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');


$swift_design_options_init[] = array( 'name' => __('Section title background', 'swift' ),
		'desc' => '',
		'id' => 'np_section_title_bg',
		'default' => 'CCC',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Section title color', 'swift' ),
		'desc' => '',
		'id' => 'np_section_title',
		'default' => 'F00',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Popular posts bg', 'swift' ),
		'desc' => '',
		'id' => 'np_popular_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // News paper colors



$swift_design_options_init[] = array( 'name' => __( 'Sidebar widget colors', 'swift' ),
		'id' => 'sidebar_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Background', 'swift' ),
		'desc' => '',
		'id' => 'sb_w_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Border', 'swift' ),
		'desc' => '',
		'id' => 'sb_w_border',
		'default' => 'DDD',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Title background', 'swift' ),
		'desc' => '',
		'id' => 'sb_w_title_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Title bottom border', 'swift' ),
		'desc' => '',
		'id' => 'sb_w_title_border',
		'default' => 'DDD',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Title text color', 'swift' ),
		'desc' => '',
		'id' => 'sb_w_title',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Text color', 'swift' ),
		'desc' => '',
		'id' => 'sb_w',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link color', 'swift' ),
		'desc' => '',
		'id' => 'sb_w_a',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link hover color', 'swift' ),
		'desc' => '',
		'id' => 'sb_w_a_h',
		'default' => 'F00',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('List border/separator color', 'swift' ),
		'desc' => '',
		'id' => 'sb_w_li_border',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('List hover background', 'swift' ),
		'desc' => '',
		'id' => 'sb_w_li_hover_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Widget thumbnail bg', 'swift' ),
		'desc' => '',
		'id' => 'sb_w_thumb_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Widget thumbnail border', 'swift' ),
		'desc' => '',
		'id' => 'sb_w_thumb_border',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Date color', 'swift' ),
		'desc' => '',
		'id' => 'sb_date',
		'default' => 'CCC',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Sidebar colors

$swift_design_options_init[] = array( 'name' => __( 'Footer widget colors', 'swift' ),
		'id' => 'footer_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Background', 'swift' ),
		'desc' => '',
		'id' => 'fo_w_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'name' => __('Border', 'swift' ),
		'desc' => '',
		'id' => 'fo_w_border',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Title background', 'swift' ),
		'desc' => '',
		'id' => 'fo_w_title_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Title bottom border', 'swift' ),
		'desc' => '',
		'id' => 'fo_w_title_border',
		'default' => 'DDD',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Title text color', 'swift' ),
		'desc' => '',
		'id' => 'fo_w_title',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Text color', 'swift' ),
		'desc' => '',
		'id' => 'fo_w',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link color', 'swift' ),
		'desc' => '',
		'id' => 'fo_w_a',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link hover color', 'swift' ),
		'desc' => '',
		'id' => 'fo_w_a_h',
		'default' => 'F00',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('List border/separator color', 'swift' ),
		'desc' => '',
		'id' => 'fo_w_li_border',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('List hover background', 'swift' ),
		'desc' => '',
		'id' => 'fo_w_li_hover_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Widget thumbnail bg', 'swift' ),
		'desc' => '',
		'id' => 'fo_w_thumb_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Widget thumbnail border', 'swift' ),
		'desc' => '',
		'id' => 'fo_w_thumb_border',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Date color', 'swift' ),
		'desc' => '',
		'id' => 'fo_date',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Footer colors



$swift_design_options_init[] = array( 'name' => __( 'Comments colors', 'swift' ),
		'id' => 'comemnt_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Comments background color', 'swift' ),
		'desc' => '',
		'id' => 'comment_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Comments shadow color', 'swift' ),
		'desc' => '',
		'id' => 'comment_shadow',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Comments border color', 'swift' ),
		'desc' => '',
		'id' => 'comment_border',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Comments text color', 'swift' ),
		'desc' => '',
		'id' => 'comment',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link color', 'swift' ),
		'desc' => '',
		'id' => 'comment_a',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link hover color', 'swift' ),
		'desc' => '',
		'id' => 'comment_a_h',
		'default' => 'F00',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Author comment highlighter', 'swift' ),
		'desc' => '',
		'id' => 'author_comment_bg',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');
/*
 $swift_design_options_init[] = array( 'name' => __('Reply buttom background', 'swift' ),
 		'desc' => '',
 		'id' => 'comment_reply_bg',
 		'default' => '444',
 		'type' => 'color',
 		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Reply buttom hover bg', 'swift' ),
		'desc' => '',
		'id' => 'comment_reply_h_bg',
		'default' => '000',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Reply buttom text color', 'swift' ),
		'desc' => '',
		'id' => 'comment_reply',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');
*/
$swift_design_options_init[] = array( 'name' => __('Comment form background', 'swift' ),
		'desc' => '',
		'id' => 'comment_form_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Comment form input fields bg', 'swift' ),
		'desc' => '',
		'id' => 'comment_form_field_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Comment form fields border', 'swift' ),
		'desc' => '',
		'id' => 'comment_form_field_border',
		'default' => 'DDD',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Sidebar colors



$swift_design_options_init[] = array( 'name' => __( 'Copyright colors', 'swift' ),
		'id' => 'copyright_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Top border color', 'swift' ),
		'desc' => '',
		'id' => 'copyright_border',
		'default' => 'DDD',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Text color', 'swift' ),
		'desc' => '',
		'id' => 'copyright',
		'default' => 'CCC',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link color', 'swift' ),
		'desc' => '',
		'id' => 'copyright_a',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link hover color', 'swift' ),
		'desc' => '',
		'id' => 'copyright_a_h',
		'default' => 'F00',
		'type' => 'color',
		'datatype' => 'color');



$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Copyright colors


$swift_design_options_init[] = array( 'name' => __( 'Posts nav and related posts', 'swift' ),
		'id' => 'related_posts_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Post navigation background', 'swift' ),
		'desc' => '',
		'id' => 'post_nav_bg',
		'default' => 'DDD',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Post navigation link bg', 'swift' ),
		'desc' => '',
		'id' => 'post_nav_a_bg',
		'default' => 'DDD',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Post navigation link hover bg', 'swift' ),
		'desc' => '',
		'id' => 'post_nav_a_hover_bg',
		'default' => 'F00',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Post navigation link', 'swift' ),
		'desc' => '',
		'id' => 'post_nav_a',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Related posts background', 'swift' ),
		'desc' => '',
		'id' => 'rp_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __( 'Post title color', 'swift' ),
		'desc' => '',
		'id' => 'rp_a',
		'default' => '000',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Related posts meta', 'swift' ),
		'desc' => '',
		'id' => 'rp_meta',
		'default' => 'CCC',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Thumbnail background', 'swift' ),
		'desc' => '',
		'id' => 'rp_thumb_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Thumbnail border', 'swift' ),
		'desc' => '',
		'id' => 'rp_thumb_border',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Related posts

$swift_design_options_init[] = array( 'name' => __( 'Author BIO', 'swift' ),
		'id' => 'author_bio_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Background', 'swift' ),
		'desc' => '',
		'id' => 'ab_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Border', 'swift' ),
		'desc' => '',
		'id' => 'ab_border',
		'default' => 'DDD',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'name' => __('Text color', 'swift' ),
		'desc' => '',
		'id' => 'ab',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'name' => __('Link color', 'swift' ),
		'desc' => '',
		'id' => 'ab_a',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Link hover color', 'swift' ),
		'desc' => '',
		'id' => 'ab_a_hover',
		'default' => 'F00',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Avatar backgroud', 'swift' ),
		'desc' => '',
		'id' => 'ab_avatar_bg',
		'default' => 'DDD',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Author

$swift_design_options_init[] = array( 'name' => __( 'Magazine Box', 'swift' ),
		'id' => 'mag_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Background', 'swift' ),
		'desc' => '',
		'id' => 'mag1_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Border', 'swift' ),
		'desc' => '',
		'id' => 'mag1_border',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Thumbnail background', 'swift' ),
		'desc' => '',
		'id' => 'mag1_thumb_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Mag box footer bg', 'swift' ),
		'desc' => '',
		'id' => 'mag1_footer_bg',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');
$swift_design_options_init[] = array( 'name' => __('Mag box footer text', 'swift' ),
		'desc' => '',
		'id' => 'mag1_footer',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Magazine box

$swift_design_options_init[] = array( 'name' => __( 'Generic elements', 'swift' ),
		'id' => 'generic_element_colors',
		'desc' => '',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');



$swift_design_options_init[] = array( 'name' => __('Button background', 'swift' ),
		'desc' => '',
		'id' => 'button_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Button gradient start color', 'swift' ),
		'desc' => '',
		'id' => 'button_gradient_start',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Button gradient stop color', 'swift' ),
		'desc' => '',
		'id' => 'button_gradient_stop',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Button border color', 'swift' ),
		'desc' => '',
		'id' => 'button_border',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Button bottom border color', 'swift' ),
		'desc' => '',
		'id' => 'button_bottom_border',
		'default' => 'DDD',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Button text color', 'swift' ),
		'desc' => '',
		'id' => 'button_text',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'hr',
		'datatype' => 'none' );

$swift_design_options_init[] = array( 'name' => __('Border color dark', 'swift' ),
		'desc' => '',
		'id' => 'generic_border_dark',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Border color light', 'swift' ),
		'desc' => '',
		'id' => 'generic_border_light',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Generic options

$swift_design_options_init[] = array( 'name' => __( 'Subscribe widget', 'swift' ),
		'id' => 'subscribe_widget_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');


$swift_design_options_init[] = array( 'name' => __('Widget bg', 'swift' ),
		'desc' => '',
		'id' => 'sub_widget_bg',
		'default' => 'D7E4EF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Ribbon bg', 'swift' ),
		'desc' => '',
		'id' => 'sub_widget_ribbon_bg',
		'default' => 'BDD7F2',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Text color', 'swift' ),
		'desc' => '',
		'id' => 'sub_widget',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Chicklet bg', 'swift' ),
		'desc' => '',
		'id' => 'chicklet_bg',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Chicklet text color', 'swift' ),
		'desc' => '',
		'id' => 'chicklet',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // RSS Subscribe box

$swift_design_options_init[] = array( 'name' => __( 'Slider colors', 'swift' ),
		'id' => 'slider_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Slider bg', 'swift' ),
		'desc' => '',
		'id' => 'slider_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Slider border', 'swift' ),
		'desc' => '',
		'id' => 'slider_border',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');
$swift_design_options_init[] = array( 'name' => __('Slide caption bg', 'swift' ),
		'desc' => '',
		'id' => 'slide_caption_bg',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Slide caption color', 'swift' ),
		'desc' => '',
		'id' => 'slide_caption',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Slider colors

$swift_design_options_init[] = array( 'name' => __( 'Tabs widget', 'swift' ),
		'id' => 'tabs_widget_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');


$swift_design_options_init[] = array( 'name' => __('Tabs border', 'swift' ),
		'desc' => '',
		'id' => 'tabs_border',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Tabs background', 'swift' ),
		'desc' => '',
		'id' => 'tabs_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Tabs title color', 'swift' ),
		'desc' => '',
		'id' => 'tabs_title',
		'default' => 'CCC',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Tabs text color', 'swift' ),
		'desc' => '',
		'id' => 'tabs',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Tabs link color', 'swift' ),
		'desc' => '',
		'id' => 'tabs_a',
		'default' => '005FA1',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Tabs link hover', 'swift' ),
		'desc' => '',
		'id' => 'tabs_a_h',
		'default' => 'F00',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // tabs widget


$swift_design_options_init[] = array( 'name' => __( 'Table colors', 'swift' ),
		'id' => 'table_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Table border', 'swift' ),
		'desc' => '',
		'id' => 't_border',
		'default' => 'DDD',
		'type' => 'color',
		'datatype' => 'color');
$swift_design_options_init[] = array( 'name' => __('Table head bg', 'swift' ),
		'desc' => '',
		'id' => 't_head_bg',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Table head text', 'swift' ),
		'desc' => '',
		'id' => 't_head',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Odd row bg', 'swift' ),
		'desc' => '',
		'id' => 't_odd_row_bg',
		'default' => 'FFF',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Even row bg', 'swift' ),
		'desc' => '',
		'id' => 't_even_row_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');
$swift_design_options_init[] = array( 'name' => __('Table text', 'swift' ),
		'desc' => '',
		'id' => 't_text',
		'default' => '333',
		'type' => 'color',
		'datatype' => 'color');


$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Table colors


$swift_design_options_init[] = array( 'name' => __( 'Blog thumbnail colors', 'swift' ),
		'id' => 'blog_thumb_colors',
		'default' => TRUE,
		'type' => 'sub-heading',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Blog thumb bg', 'swift' ),
		'desc' => '',
		'id' => 'blog_thumb_bg',
		'default' => 'F6F6F6',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'name' => __('Blog thumb border', 'swift' ),
		'desc' => '',
		'id' => 'blog_thumb_border',
		'default' => 'EEE',
		'type' => 'color',
		'datatype' => 'color');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Misc colors

$swift_design_options_init[] = 'color_options_end';

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing color options

/*
$swift_design_options_init[] = array( 'name' => __( 'Font options', 'swift' ),
		'id' => 'font-options',
		'type' => 'heading',
		'datatype' => 'none');


$swift_design_options_init[] = array( 'name' => __( 'Text alignment', 'swift' ),
		'desc' => __('Select the text alignment', 'swift'),
		'id' => 'body_text_align',
		'default' => 'left',
		'type' => 'radio',
		'options' => array( 'left'=>'left', 'justify' => 'justify', 'center' => 'center', 'right' => 'right' ),
		'datatype' => 'predefined');

$swift_design_options_init[] = array( 'type' => 'clear',
		'datatype' => 'none');

$swift_design_options_init[] = array( 'type' => 'function',
		'id' => 'swift_gfonts',
		'datatype' => 'google_fonts');

$swift_design_options_init[] = array( 'type' => 'clear',
		'datatype' => 'none');

$swift_design_options_init[] = 'font_options_start';

$swift_design_options_init[] = array( 'name' => __('Custom font stack 1', 'swift' ),
		'desc' => __('Enter your font stack here, this will be appeneded to the font selection menu below. You should save the changes first for them to appear.', 'swift' ),
		'id' => 'fontstack1',
		'default' => '',
		'type' => 'text',
		'datatype' => 'text');

$swift_design_options_init[] = array( 'name' => __('Custom font stack 2', 'swift' ),
		'desc' => __('Enter your font stack here, this will be appeneded to the font selection menu below. You should save the changes first for them to appear.', 'swift' ),
		'id' => 'fontstack2',
		'default' => '',
		'type' => 'text',
		'datatype' => 'text');


$swift_design_options_init[] = array( 'type' => 'clear',
		'datatype' => 'none');

$swift_design_options_init[] = array( 'name' => __( 'Fonts usage', 'swift' ),
		'id' => 'fonts-explanation',
		'type' => 'explain',
		'desc' => sprintf( __( '%s{p}, {t}, {p,t}%s at the end of font stack indicate that the stack is optimized for %sparagraphs, titles/headings and both%s respectively.', 'swift' ), '<strong>', '</strong>', '<strong>', '</strong>' ),
		'datatype' => 'none' );

$swift_design_options_init[] = array( 'name' => __( 'Body', 'swift' ),
		'id' => 'body_font',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');

$swift_design_options_init[] = array( 'name' => __( 'Blog name', 'swift' ),
		'id' => 'blog_name_font',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');

$swift_design_options_init[] = array( 'name' => __( 'Blog tagline', 'swift' ),
		'id' => 'blog_tagline_font',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');

$swift_design_options_init[] = array( 'name' => __( 'Navigation font {above logo}', 'swift' ),
		'id' => 'nav_a_font',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');


$swift_design_options_init[] = array( 'name' => __( 'Navigation font {below logo}', 'swift' ),
		'id' => 'nav_b_font',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');

$swift_design_options_init[] = array( 'name' => __( 'Homepage post title ( Blog )', 'swift' ),
		'id' => 'home_post_title',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');

$swift_design_options_init[] = array( 'name' => __( 'Homepage post title ( Magazine )', 'swift' ),
		'id' => 'home_post_title_mag',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');

$swift_design_options_init[] = array( 'name' => __( 'Single page post title', 'swift' ),
		'id' => 'single_post_title',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');

$swift_design_options_init[] = array( 'name' => __( 'h1,h2...h6 tags used in posts', 'swift' ),
		'id' => 'heading_tags',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');

$swift_design_options_init[] = array( 'name' => __( 'Post meta', 'swift' ),
		'id' => 'post_meta_font',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');

$swift_design_options_init[] = array( 'name' => __( 'Sidebar widget title', 'swift' ),
		'id' => 'sidebar_title_font',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');

$swift_design_options_init[] = array( 'name' => __( 'Sidebar widget content', 'swift' ),
		'id' => 'sidebar_widget_font',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');

$swift_design_options_init[] = array( 'name' => __( 'Footer widget title', 'swift' ),
		'id' => 'footer_title_font',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');

$swift_design_options_init[] = array( 'name' => __( 'Footer widget content', 'swift' ),
		'id' => 'footer_widget_font',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');

$swift_design_options_init[] = array( 'name' => __( 'Copyright div', 'swift' ),
		'id' => 'copyright_font',
		'type' => 'font',
		'default' => '',
		'datatype' => 'font');


$swift_design_options_init[] = 'font_options_end';

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing color options
*/
$swift_design_options_init[] = array( 'name' => __( 'Rounded corners', 'swift' ),
		'id' => 'rounded-corners',
		'type' => 'heading',
		'datatype' => 'none');


$swift_design_options_init[] = array( 'name' => __( 'Use rounded corners for solid navigation', 'swift' ),
		'id' => 'solid_nav_rounded',
		'desc' => __('You should disable rounded corners when your header and body background are different.', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __( 'Use rounded corners for magazine boxes', 'swift' ),
		'id' => 'mag1_rounded',
		'desc' => __('Check this box to enable rounded corners for magazine boxes.', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __( 'Use rounded corners for sidebar widgets', 'swift' ),
		'id' => 'sb_widget_rounded',
		'desc' => __('Check this box to enable rounded corners for sidebar widgets.', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __( 'Use rounded corners for footer widgets', 'swift' ),
		'id' => 'footer_widget_rounded',
		'desc' => __('Check this box to enable rounded corners for footer widgets.', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __( 'Use rounded corners for comments', 'swift' ),
		'id' => 'comment_rounded',
		'desc' => __('Check this box to enable rounded corners for comments.', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');


$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing color options

$swift_design_options_init[] = array( 'name' => __( 'User CSS', 'swift' ),
		'id' => 'user-css',
		'type' => 'heading',
		'datatype' => 'none');


$swift_design_options_init[] = array( 'name' => __( 'Enable custom CSS', 'swift' ),
		'id' => 'enable_user_css',
		'desc' => __('Check this box to enable CSS', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('User CSS', 'swift' ),
		'desc' => __('Enter your Custom CSS code here.', 'swift' ),
		'id' => 'user_css',
		'default' => '',
		'type' => 'textarea',
		'datatype' => 'js');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing User CSS



$swift_design_options_init[] = array( 'name' => __( 'Plugin compatibility', 'swift' ),
		'id' => 'plugin-compatibility',
		'type' => 'heading',
		'datatype' => 'none');


$swift_design_options_init[] = array( 'name' => __( 'Disable form styling form the theme', 'swift' ),
		'id' => 'disable_form_styling',
		'desc' => __('Check this if there are any issues with the contact form plugins you are using', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __('Disable table styling form the theme', 'swift' ),
		'desc' => __('Check this box if you are using any plugin that uses tables to display content and if its styling isn\'t the way it\'s supposed to be.' , 'swift' ),
		'id' => 'disable_table_styling',
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing Plugin compatability



$swift_design_options_init[] = array( 'name' => __( 'Thumbnail sizes', 'swift' ),
		'id' => 'thumbnail-sizes',
		'type' => 'heading',
		'datatype' => 'none');


$swift_design_options_init[] = array( 'name' => __('Blog thumb width', 'swift' ),
		'desc' => __('Enter the width of the blog thumbnail (Enter the value without units)', 'swift' ),
		'id' => 'blog_thumb_width',
		'default' => '',
		'type' => 'text',
		'datatype' => 'int');

$swift_design_options_init[] = array( 'name' => __('Blog thumb height', 'swift' ),
		'desc' => __('Enter the height of the blog thumbnail (Enter the value without units)', 'swift' ),
		'id' => 'blog_thumb_height',
		'default' => '',
		'type' => 'text',
		'datatype' => 'int');

$swift_design_options_init[] = array( 'name' => __('Content width slider height', 'swift' ),
		'desc' => __('Enter the height of content width slider image without units', 'swift' ),
		'id' => 'content_slider_height',
		'default' => '',
		'type' => 'text',
		'datatype' => 'int');

$swift_design_options_init[] = array( 'name' => __('Full width slider height', 'swift' ),
		'desc' => __('Enter the height of full width slider image without units', 'swift' ),
		'id' => 'full_slider_height',
		'default' => '',
		'type' => 'text',
		'datatype' => 'int');
$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing Thumbnail sizes


$swift_design_options_init[] = array( 'name' => __( 'Sticky elements', 'swift' ),
		'id' => 'sticky-elements',
		'type' => 'heading',
		'datatype' => 'none');

$swift_design_options_init[] = array( 'name' => __( 'Sticky navigation', 'swift' ),
		'id' => 'sticky_nav',
		'desc' => __('Check this box to stick the navigation menu below logo to the top of the browser window when scrolled', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __( 'Stick below navigation ad', 'swift' ),
		'id' => 'sticky_nav_ad',
		'desc' => __('Check this box to stick the ad below navigation to the top of the browser window when scrolled', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __( 'Use sticky sidebar', 'swift' ),
		'id' => 'sticky_sb',
		'desc' => __('Check this box to stick the widgets not in non sticky sidebar to the top', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');


$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Closing Plugin compatability



$swift_design_options_init[] = array( 'name' => __( 'Advanced', 'swift' ),
		'id' => 'advanced',
		'type' => 'heading',
		'datatype' => 'none');

$swift_design_options_init[] = array( 'name' => __( 'Disable Shortcode CSS', 'swift' ),
		'id' => 'disable_shortcode_css',
		'desc' => __('If you don\'t plan to use shrotcodes, disabling it will save 40+ Kilobytes', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'name' => __( 'Disable Info Box Icons', 'swift' ),
		'id' => 'disable_infobox_icons',
		'desc' => __('If you don\'t plan to use the info box with icons, disabling it will save 40+ Kilobytes', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');


$swift_design_options_init[] = array( 'name' => __( 'Disable feedback template', 'swift' ),
		'id' => 'disable_feedback_template',
		'desc' => __('If you are not using feedback template, disabling it will save you 3KB', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');


$swift_design_options_init[] = array( 'name' => __( 'Disable mosaic feedback template', 'swift' ),
		'id' => 'disable_feedback_mosaic_template',
		'desc' => __('If you are not using feedback template, disabling it will save you 5KB', 'swift' ),
		'default' => FALSE,
		'type' => 'checkbox',
		'datatype' => 'bool');

$swift_design_options_init[] = array( 'type' => 'close',
		'datatype' => 'none' ); // Advanced

?>