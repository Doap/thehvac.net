<?php

/**
 *
 * Adds the stylesheet for Swift admin pages
 */
function swift_admin_stylesheet() {
	wp_enqueue_style('swift-admin-stylesheet', get_template_directory_uri() . '/lib/admin/css/style.css');
	wp_enqueue_style('swift-admin-bootstrap', get_template_directory_uri() . '/lib/admin/css/bootstrap.min.css');

}

/**
 * Add JS scripts to Swift admin pages
 */
function swift_admin_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('cookie', get_template_directory_uri() . '/lib/admin/js/jquery.cookie.js', array (
		'jquery',
		'jquery-ui-core',
		'jquery-ui-tabs',
		'file-uploader',
		'jsColor'
	));
	wp_enqueue_script('admin-scripts', get_template_directory_uri() . '/lib/admin/js/scripts.js', array (
		'jquery',
		'cookie',
		'jquery-ui-core',
		'jquery-ui-tabs',
		'file-uploader',
		'jsColor'
	));
	wp_enqueue_script('file-uploader', get_template_directory_uri() . '/lib/admin/js/fileuploader.js', array (
		'jquery'
	));
	wp_enqueue_script('scroll', get_template_directory_uri() . '/lib/admin/js/scroll.jquery.js', array (
		'jquery'
	));
	wp_enqueue_script('jsColor', get_template_directory_uri() . '/lib/admin/js/jscolor/jscolor.js', array (
		'jquery'
	));
	
}

/**
 * Gravatar JS
 */
function swift_gravatar_loading() {
	wp_enqueue_script('gravatarLoading', get_template_directory_uri() . '/lib/admin/js/gravatar-delayed-loading.js');
}

// Add the options pages
add_action('admin_menu', 'swift_add_admin_pages');

function swift_add_admin_pages(){
	$icon_url = get_template_directory_uri() .'/lib/admin/images/favicon.ico';
	$swift_options_page = add_theme_page( __( 'Swift Options', 'swift' ), __( 'Swift Options', 'swift' ), 'edit_theme_options', 'swift-options', 'swift_options_page', $icon_url, 62 );
	$swift_design_options_page = add_theme_page( __( 'Swift Design Options', 'swift' ), __( 'Swift Design Options', 'swift' ), 'edit_theme_options', 'swift-design-options', 'swift_design_options_page' );
	$swift_help = add_theme_page( __( 'Help', 'swift' ), __( 'Swift Help', 'swift' ), 'edit_theme_options', 'swift-help', 'swift_help' );
	$swift_color_schemes_page = add_theme_page( __( 'Color Schemes', 'swift' ), __( 'Color Schemes', 'swift' ), 'edit_theme_options', 'swift-color-schemes', 'swift_color_schemes_page' );
	
	add_action( "admin_print_styles-$swift_options_page", 'swift_admin_stylesheet' );
	add_action( "admin_print_scripts-$swift_options_page", 'swift_admin_scripts' );
	
	add_action( "admin_print_styles-$swift_design_options_page", 'swift_admin_stylesheet', 1 );
	add_action( "admin_print_scripts-$swift_design_options_page", 'swift_admin_scripts', 2 );
	add_action( "admin_print_scripts-$swift_color_schemes_page", 'swift_admin_scripts', 2 );
	
	add_action( "admin_print_styles-$swift_help", 'swift_admin_stylesheet' );
	add_action( "admin_print_styles-$swift_color_schemes_page", 'swift_admin_stylesheet' );
	
		
	}

add_action('admin_init', 'swift_options_init');

function swift_options_init() {
	register_setting('swift_options', 'swift_options', 'swift_validate_options');
	register_setting('swift_design_options', 'swift_design_options', 'swift_validate_options');

	add_settings_section('swift-options', NULL, 'swift_admin_header', 'swift-options');
	add_settings_section('swift-design-options', NULL, 'swift_admin_header', 'swift-design-options');

	add_settings_field('', '', 'swift_options_input', 'swift-options', 'swift-options');
	add_settings_field('', '', 'swift_design_options_input', 'swift-design-options', 'swift-design-options');
}

function swift_options_page() {
	$msg = swift_write_file();
	if ($msg && $msg === TRUE)
		return;
	elseif ($msg) echo '<div id="message" style="width:94%;" class="message updated"><p>' . $msg . '</p></div>';
?>
	<div class="swift-wrap clearfix">
  <?php include(SWIFT_ADMIN.'/swift-basic-header.php')?>		

	<form action="options.php" method="post">
	<?php settings_fields( 'swift_options' )?>
	<?php do_settings_sections( 'swift-options' )?>
	<div id="swift-options-buttons" class="clearfix">
	<input name="swift_options[reset]" type="submit" onClick="return confirmation()" value="<?php _e( 'Reset options', 'swift'); ?>" class="button-secondary alignleft" />
	<input name="swift_options[save]" type="submit" value="<?php _e( 'Save options', 'swift' ); ?>" class="button-primary alignright" />
	</div>
	</form>
	</div>
	<?php

}

function swift_design_options_page() {
	$msg = swift_write_file();
	if ($msg && $msg === TRUE)
		return;
	elseif ($msg) echo '<div id="message" class="message updated"><p>' . $msg . '</p></div>';
?>
	<div class="swift-wrap clearfix">
	<?php include(SWIFT_ADMIN.'/swift-basic-header.php')?>		
	<form action="options.php" method="post">
	<?php settings_fields( 'swift_design_options' )?>
	<?php do_settings_sections( 'swift-design-options' )?>
	<div id="swift-options-buttons" class="clearfix">
	<input name="swift_design_options[reset]" type="submit" onClick="return confirmation()" value="<?php _e( 'Reset options', 'swift'); ?>" class="button-secondary alignleft" />
	<input name="swift_design_options[save]" type="submit" value="<?php _e( 'Save changes', 'swift' ); ?>" class="button-primary alignright" />
	</div>
	</form>
	</div>
	<?php

}

function swift_import_export_page() {
	if (isset ($_POST))
		swift_import_options($_POST);

	//if ( swift_write_file(TRUE) ) return;
	$msg = swift_write_file(TRUE);
	if ($msg && $msg === TRUE)
		return;
?>
	<div class="swift-wrap clearfix">
  	<?php include(SWIFT_ADMIN.'/swift-basic-header.php')?>		

	<form action="" method="post">
	<?php swift_import_export_form()?>
	<div id="swift-options-buttons" class="clearfix">
	<input name="swift_import_export" type="submit" value="<?php _e( 'Save changes', 'swift' ); ?>" class="button-primary alignright" />
	</div>
	</form>
	</div>
	<?php

}

function swift_help() {
	include (SWIFT_ADMIN . '/swift-help.php');
}
function swift_admin_header() {
return NULL;

}

function swift_validate_options($input) {
	GLOBAL $swift_image_repeat, $swift_font_stack, $swift_font_unit, $swift_font_style, $swift_font_weight;
	GLOBAL $swift_text_transform, $swift_design_options_init, $swift_options_init, $swift_font_defaults, $swift_design_options;

	if (isset ($swift_design_opt['fontstack1']) || isset ($swift_design_opt['fontstack2']))
		array_unshift($swift_font_stack, array (
			$swift_design_opt['fontstack1'],
			''
		), array (
			$swift_design_opt['fontstack2'],
			''
		));

	if ($input['which'] == 'design_options') {
		$options = apply_filters('swift_design_options_init', $swift_design_options_init);
	}
	elseif ($input['which'] == 'options') {
		$options = apply_filters('swift_options_init', $swift_options_init);
	} else {
		return $input;
	}
	$sanitized_options = array ();

	if (isset ($input['reset'])) {
		foreach ($options as $option) {
			if ($option['datatype'] != 'none' && $option['datatype'] != 'font') {
				$sanitized_options[$option['id']] = $option['default'];
			}
			elseif ($option['datatype'] == 'font') {
				$sanitized_options[$option['id'] . '_enable'] = $swift_font_defaults[$option['id'] . '_enable'];
				$sanitized_options[$option['id'] . '_family'] = $swift_font_defaults[$option['id'] . '_family'];
				$sanitized_options[$option['id'] . '_size'] = $swift_font_defaults[$option['id'] . '_size'];
				$sanitized_options[$option['id'] . '_size_unit'] = $swift_font_defaults[$option['id'] . '_size_unit'];
				$sanitized_options[$option['id'] . '_lh'] = $swift_font_defaults[$option['id'] . '_lh'];
				$sanitized_options[$option['id'] . '_lh_unit'] = $swift_font_defaults[$option['id'] . '_lh_unit'];
				$sanitized_options[$option['id'] . '_weight'] = $swift_font_defaults[$option['id'] . '_weight'];
				$sanitized_options[$option['id'] . '_transform'] = $swift_font_defaults[$option['id'] . '_transform'];
				$sanitized_options[$option['id'] . '_style'] = $swift_font_defaults[$option['id'] . '_style'];
			}
		}

		if (is_array(get_option('SwiftOptions'))) {
			$temp_options = get_option('SwiftOptions');
		}
		if ($input['which'] == 'options') {
			$temp_options['site_options'] = $sanitized_options;
		}
		elseif ($input['which'] == 'design_options') {
			$temp_options['design_options'] = $sanitized_options;
		}
		update_option('SwiftOptions', $temp_options);
		return NULL;
	}
	foreach ($options as $option) {
		switch ($option['datatype']) {

			case 'none' :
			case 'hidden' :
				break;

			case 'predefined' :
				$keys = array_keys($option['options']);
				if (isset ($input[$option['id']]) && in_array($input[$option['id']], $keys)) {
					$sanitized_options[$option['id']] = $input[$option['id']];
				} else {
					$sanitized_options[$option['id']] = $option['default'];
				}
				break;
			case 'int' :
				$sanitized_options[$option['id']] = absint($input[$option['id']]);

				break;

			case 'uri' :
				$sanitized_options[$option['id']] = esc_url($input[$option['id']]);

				break;

			case 'text' :
				$sanitized_options[$option['id']] = ($input[$option['id']]);

				break;

			case 'javascript' :
				$sanitized_options[$option['id']] = force_balance_tags($input[$option['id']]);

				break;

			case 'sortable_array' :
				$temp2 = array(-6,-5,-4,-3,-2,-1);
				if(in_array((int)$input[$option['id']],$temp2)){
					$sanitized_options[$option['id']] = (int)$input[$option['id']];
					break;
				}
				$temp = array ();
				$temp = split(',', $input[$option['id']]);
				$sanitized_options[$option['id']] = $temp;
			
				break;

			case 'sortable' :
				$i = 0;
				$temp = $temp2 = array ();
				$temp = split(',', $input[$option['id']]);
				foreach ($temp as $value) {
					if (!in_array($value, $option['options']) && $value != '') {
						$temp2[$i++] = "text";
						$temp2[$i++] = $value;
					} else {
						$temp2[$i++] = $value;
					}
				}

				$sanitized_options[$option['id']] = $temp2;

				$temp2 = $temp = NULL;
				break;
			
			case 'google_fonts':
				$temp = array();
				if(isset($input[$option['id']]) && is_array($input[$option['id']])){
					foreach($input[$option['id']] as $font){
						$temp2 = explode(',',$font);
						$temp2[1] = ($temp2[1] === 'true') || ($temp2[1] === '1') ? true: false;
						$temp2[2] = ($temp2[2] === 'true') || ($temp2[2] === '1') ? true: false;
						$temp[] = $temp2;
					}
				}else{
					$temp = FALSE;
				}				
				$sanitized_options[$option['id']] = $temp;
			
			break;

			case 'font' :
				$id = $option['id'];
				if (isset ($swift_design_options['fontstack1']) || isset ($swift_design_options['fontstack2']))
					array_unshift($swift_font_stack, array (
						$swift_design_options['fontstack1'],
						''
					), array (
						$swift_design_options['fontstack2'],
						''
					));

				if (isset ($input[$option['id'] . '_enable']))
					$sanitized_options[$option['id'] . '_enable'] = (bool) ($input[$option['id'] . '_enable']);
				else
					$sanitized_options[$option['id'] . '_enable'] = FALSE;
				/*
				$keys = array_keys( $font_stack );
				if( in_array( $input[ $option['id'].'_family' ], $keys ) )
					$sanitized_options[ $option['id'].'_family' ] = $input[ $option['id'].'_family'];
				else
					$sanitized_options[ $option['id'].'_family' ] = '';
				*/
				foreach ($swift_font_stack as $font) {
					if ($input[$option['id'] . '_family'] == $font[0]) {
						$sanitized_options[$option['id'] . '_family'] = $font[0];
						BREAK;
					} else {
						$sanitized_options[$option['id'] . '_family'] = '';
					}

				}

				$keys = array_keys($swift_font_unit);
				if (in_array($input[$option['id'] . '_size_unit'], $keys))
					$sanitized_options[$option['id'] . '_size_unit'] = $input[$option['id'] . '_size_unit'];
				else
					$sanitized_options[$option['id']] = '';

				if (in_array($input[$option['id'] . '_lh_unit'], $keys))
					$sanitized_options[$option['id'] . '_lh_unit'] = $input[$option['id'] . '_lh_unit'];
				else
					$sanitized_options[$option['id']] = '';

				$keys = array_keys($swift_font_style);
				if (in_array($input[$option['id'] . '_style'], $keys))
					$sanitized_options[$option['id'] . '_style'] = $input[$option['id'] . '_style'];
				else
					$sanitized_options[$option['id']] = '';

				$keys = array_keys($swift_font_weight);
				if (in_array($input[$option['id'] . '_weight'], $keys))
					$sanitized_options[$option['id'] . '_weight'] = $input[$option['id'] . '_weight'];
				else
					$sanitized_options[$option['id']] = '';

				$keys = array_keys($swift_text_transform);
				if (in_array($input[$option['id'] . '_transform'], $keys))
					$sanitized_options[$option['id'] . '_transform'] = $input[$option['id'] . '_transform'];
				else
					$sanitized_options[$option['id']] = '';

				$sanitized_options[$option['id'] . '_size'] = (float) ($input[$option['id'] . '_size']);

				$sanitized_options[$option['id'] . '_lh'] = (float) ($input[$option['id'] . '_lh']);

				break;

			case 'background' :
				$id = $option['id'];
				$sanitized_options[$id] = esc_url($input[$id]);
				$sanitized_options[$id . '_p_t'] = esc_attr($input[$id . '_p_t']);
				$sanitized_options[$id . '_p_l'] = esc_attr($input[$id . '_p_l']);
				$keys = array_keys($swift_image_repeat);
				if (in_array($input[$option['id'] . '_repeat'], $keys))
					$sanitized_options[$option['id'] . '_repeat'] = $input[$option['id'] . '_repeat'];
				else
					$sanitized_options[$option['id']] = '';

				break;

			case 'bool' :
				if (isset ($input[$option['id']]))
					$sanitized_options[$option['id']] = (bool) ($input[$option['id']]);
				else
					$sanitized_options[$option['id']] = FALSE;

				break;

			default :
				if (isset ($input[$option['id']]))
					$sanitized_options[$option['id']] = $input[$option['id']];

				break;

		}
	}
	if (is_array(get_option('SwiftOptions'))) {
		$temp_options = get_option('SwiftOptions');
	} else {
		$temp_options = array ();
	}
	if ($input['which'] == 'options') {
		$temp_options['site_options'] = $sanitized_options;
	}
	elseif ($input['which'] == 'design_options') {
		$temp_options['design_options'] = $sanitized_options;
	}
	update_option('SwiftOptions', $temp_options);
	return NULL;
}

/**
 *
 * Things to do when the theme is first installed
 */
if (is_admin() && isset ($_GET['activated'])) {

	require_once get_template_directory() . '/lib/load-core.php';
	swift_fucntions();
	if (!get_option('SwiftOptions')) {

		GLOBAL $swift_options_init;
		foreach ($swift_options_init as $option) {
			if ($option['datatype'] != 'none')
				$sanitized_options[$option['id']] = $option['default'];
		}
		//update_option('swift_options',$sanitized_options);
		$temp['site_options'] = $sanitized_options;

		GLOBAL $swift_design_options_init;
		foreach ($swift_design_options_init as $option) {
			if ($option['datatype'] != 'none') {
				$sanitized_options[$option['id']] = $option['default'];
			}
			elseif ($option['datatype'] == 'font') {
				$sanitized_options[$option['id'] . '_enable'] = $font_defaults[$option['id'] . '_enable'];
				$sanitized_options[$option['id'] . '_family'] = $font_defaults[$option['id'] . '_family'];
				$sanitized_options[$option['id'] . '_size'] = $font_defaults[$option['id'] . '_size'];
				$sanitized_options[$option['id'] . '_size_unit'] = $font_defaults[$option['id'] . '_size_unit'];
				$sanitized_options[$option['id'] . '_lh'] = $font_defaults[$option['id'] . '_lh'];
				$sanitized_options[$option['id'] . '_lh_unit'] = $font_defaults[$option['id'] . '_lh_unit'];
				$sanitized_options[$option['id'] . '_weight'] = $font_defaults[$option['id'] . '_weight'];
				$sanitized_options[$option['id'] . '_transform'] = $font_defaults[$option['id'] . '_transform'];
				$sanitized_options[$option['id'] . '_style'] = $font_defaults[$option['id'] . '_style'];
			}
		}
		//update_option('swift_design_options',$sanitized_options);
		$temp['design_options'] = $sanitized_options;
		update_option('SwiftOptions', $temp);
	}

	header('Location: ' . admin_url() . 'admin.php?page=swift-help');
}

function download_css_js() {
	if (($creds = request_filesystem_credentials('', '', false, false, null))) {
		if (!WP_Filesystem($creds)) {
			// our credentials were no good, ask the user for them again
			return;

		}
	}

	if (isset ($_POST['download_css'])) {

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=custom-styles.css");
		header("Content-Type: application/octet-stream; ");
		header("Content-Transfer-Encoding: binary");

		echo swift_generate_stylesheet();
	}

	if (isset ($_POST['download_js'])) {
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=swift-scripts.js");
		header("Content-Type: application/octet-stream; ");
		header("Content-Transfer-Encoding: binary");

		echo swift_generate_js();
	}
}
?>