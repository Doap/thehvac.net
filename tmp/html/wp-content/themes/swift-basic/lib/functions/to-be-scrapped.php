<?php
/*
 * Prevents wordpress from stripping rel tags
*
* Should be removed once this is moved to the WordPress core
*/
function swift_allow_rel() {
	global $allowedtags;
	$allowedtags['a']['rel'] = array ();
}
add_action( 'wp_loaded', 'swift_allow_rel' );

function swift_add_google_profile( $contactmethods ) {
	// Add Google Profiles
	$contactmethods['google_profile'] = __( 'Google+ Profile URL', 'swift' );
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'swift_add_google_profile', 10, 1);

?>