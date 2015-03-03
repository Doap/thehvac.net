<?php
/**
 * @package DevOps_and_Platforms
 * @version 1.0
 */
/*
Plugin Name: DevOps and Platforms Partners Floatie
Plugin URI: http://wordpress.org/extend/plugins/devops_and_platforms/
Description: DevOps and Platforms is a modern web hosting platform that allows you to easily launch websites into the cloud.  Your pages will automatically be served from <cite>2</cite> datacenters.  For more information about doap.com or help with setting up your free site, drop a line to <a href="mailto:info@doap.com">info@doap.com</a>

Author: David Menache
Version: 1.1
Author URI: http://doap.com/
*/

function hello_dolly_get_lyric() {
	/** These are the lyrics to Hello Dolly */
	$lyrics = "Check out our partners at: <a href=http://www.doap.com>www.doap.com</a>
Check out our partners at: <a href=http://www.laprensa.com.ni>LaPrensa</a>
Check out our partners at: <a href=http://www.hoy.com.ni>Diario Hoy!</a>
Check out our partners at: <a href=http://laprensatv.com.ni>La Prensa TV!</a>
Check out our partners at: <a href=http://www.thehvac.net>www.thehvac.net</a>
Check out our partners at: <a href=http://www.airandplumbing.com>airandplumbing.com</a>
Check out our partners at: <a href=http://www.convectek.com>convectek.com</a>
Check out our partners at: <a href=http://caricatura.doap.com>caricatura.doap.com</a>
Check out our partners at: <a href=http://www.bodegamarina.com>www.bodegamarina.com</a>";

	// Here we split it into lines
	$lyrics = explode( "\n", $lyrics );

	// And then randomly choose a line
	return wptexturize( $lyrics[ mt_rand( 0, count( $lyrics ) - 1 ) ] );
}

// This just echoes the chosen line, we'll position it later
function hello_dolly() {
	$chosen = hello_dolly_get_lyric();
	echo "<p id='dolly'>$chosen</p>";
}

// Now we set that function up to execute when the admin_notices action is called
add_action( 'admin_notices', 'hello_dolly' );

// We need some CSS to position the paragraph
function dolly_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

	echo "
	<style type='text/css'>
	#dolly {
		float: $x;
		padding-$x: 15px;
		padding-top: 5px;		
		margin: 0;
		font-size: 11px;
	}
	</style>
	";
}

add_action( 'admin_head', 'dolly_css' );

?>
