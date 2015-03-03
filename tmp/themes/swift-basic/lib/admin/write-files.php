<?php
function swift_write_file( $force = FALSE ){
	if( !($force) )
	if( !isset($_GET['settings-updated']) && !isset($_GET['_wpnonce']) ) return false;

	$url = wp_nonce_url( 'admin.php?page='.$_GET['page'] );

	if (false === ( $creds = request_filesystem_credentials($url, '', false,false, null ) ) ) {
		// if we get here, then we don't have credentials yet,
		// but have just produced a form for the user to fill in,
		// so stop processing for now

		return true; // stop the normal page form from displaying
	}

	// now we have some credentials, try to get the wp_filesystem running
	if ( ! WP_Filesystem($creds) ) {
		// our credentials were no good, ask the user for them again
		request_filesystem_credentials($url, '', true, false, $_POST);
		return true;
	}

	$upload_dir = wp_upload_dir();

	GLOBAL $wp_filesystem;

	$msg ='';
	if( !is_dir(trailingslashit($upload_dir['basedir']).'swift-magic') ){
		if ( ! $wp_filesystem->mkdir( trailingslashit($upload_dir['basedir']).'swift-magic' ) ) {
			$msg .= "<li>Error creating directory <strong>swift-magic</strong> at".trailingslashit($upload_dir['basedir']).'</li>';
			$error = 1;
		}else{
			$msg .="<li>Created <strong>swift-magic</strong> at".trailingslashit($upload_dir['basedir']).'</li>';
		}
	}

	$filename = trailingslashit($upload_dir['basedir']).'swift-magic/custom-styles.css';
	if ( ! $wp_filesystem->put_contents( $filename, swift_generate_stylesheet(), FS_CHMOD_FILE ) ) {
		$msg .= '<li>Error creating file '.$filename.'</li>';
		$error = 1;
	}else{
		$msg .= '<li>Wrote to file '.$filename.'</li>';
	}
	$filename = trailingslashit($upload_dir['basedir']).'swift-magic/swift-js.js';

	if ( ! $wp_filesystem->put_contents( $filename, swift_generate_js(), FS_CHMOD_FILE ) ) {
		$msg .= '<li>Error creating file '.$filename.'</li>';
		$error = 1;
	}else{
		$msg .= '<li>Wrote to file '.$filename.'</li>';
	}

	if ( function_exists( 'w3tc_minify_flush' ) ) {
		//w3tc_pgcache_flush();
		w3tc_minify_flush();
		$msg .= __( 'W3 Total Cache Minify Cache flushed', 'swift' );
	} else if ( function_exists( 'wp_cache_clear_cache' ) ) {
		wp_cache_clear_cache();
		$msg .= __( 'WP Super Cache flushed', 'swift' );
	}
	if (isset($error) && $error){
		$buttons = 'Please download the below files and upload theme to'.trailingslashit($upload_dir['basedir']).'swift-magic';
		$buttons .=	'<form action="" method="post">
				<input type="submit" class="button" value="'.__( 'Download custom-styles.css', 'swift' ).'" name="download_css">
						</form>';
		$buttons .=	'<form action="" method="post">
				<input type="submit" class="button" value="'.__( 'Download swift-js.js', 'swift' ).'" name="download_js">
						</form>';
		$msg = $msg.$buttons;
	}
	return $msg;
}
?>