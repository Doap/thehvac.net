<?php
/**
 * This file contains all the callback functions for AJAX actions carried out
 * in the backend (admin)
 */

add_action('wp_ajax_swift_ajax_uploader_action', 'swift_ajax_uploader_callback');

function swift_ajax_uploader_callback() {
	global $wpdb; // this is how you get access to the database

	if($_POST['type']){
		$save_type = $_POST['type'];
	}else $save_type = null;

	//Uploads
	if( $save_type == 'upload' ) {
		$clickedID = $_POST['data']; // Acts as the name

		$arr_file_type = wp_check_filetype( basename( $_FILES[$clickedID]['name']));
		$uploaded_file_type = $arr_file_type['type'];
		// Set an array containing a list of acceptable formats
		$allowed_file_types = array( 'image/jpg','image/jpeg','image/gif','image/png', 'image/x-icon' );
		if( in_array( $uploaded_file_type, $allowed_file_types ) ) {

			$filename = $_FILES[$clickedID];
			$filename['name'] = preg_replace( '/[^a-zA-Z0-9._\-]/', '', $filename['name'] );
			$override['test_form'] = false;
			$override['action'] = 'wp_handle_upload';
			$uploaded_file = wp_handle_upload( $filename, $override );
			$upload_tracking[] = $clickedID;

			$name = 'Swift- ' .addslashes( $filename['name'] );

			$attachment = array(
					'post_mime_type' => $uploaded_file_type,
					'post_title' => $name,
					'post_content' => '',
					'post_status' => 'inherit'
			);

			$attach_id = wp_insert_attachment( $attachment, $uploaded_file['file'] );
			$attach_data = wp_generate_attachment_metadata( $attach_id, $uploaded_file['file'] );
			wp_update_attachment_metadata( $attach_id,  $attach_data );
		} else {
			$uploaded_file['error'] = 'Unsupported file type!';
		}
		if( !empty( $uploaded_file['error'] ) ) {
			echo 'Upload Error: ' . $uploaded_file['error'];
		} else {
			echo $uploaded_file['url']; // Is the Response
		}
	}
	elseif( $save_type == 'image_reset' ){
		$id = $_POST['data']; // Acts as the name
	}
	die();
}


add_action('wp_ajax_font_scroll', 'font_scroll_callback');

function font_scroll_callback() {
	global $wpdb; // this is how you get access to the database

	$font_number = intval( $_POST['font_number'] );
	if(!($json = get_transient('swift_fonts_json'))){
		//	$json = wp_remote_retrieve_body(wp_remote_get('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDVKxwBB7u0r7p1jNtveJ-GA2EHvbGB6h4'));
		set_transient('swift_fonts_json',$json,40800);
	}

	//var_dump($json);
	$fonts = json_decode($json, true);
	$fonts = $fonts['items'];
	$count = count($fonts);
	//var_dump($fonts);
	$step = 6;
	for($i=$font_number;$i<$font_number+$step;$i++){

		echo '<li style="font-family:'.$fonts[$i]['family'].'" data="'.$fonts[$i]['family'].'">'.$fonts[$i]['family'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{'.$_POST['sample'].'}</li>';

	}


	die(); // this is required to return a proper result
}