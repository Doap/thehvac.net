<?php
/**
 * This file contains all the filters and hooks used in the theme
 *
 * @package Swift
 * @since 6.0
 *
 */

/*hooks*/

function swift_before_html(){
	do_atomic( 'swift_before_html' );
}

function swift_after_html(){
	do_atomic( 'swift_after_html' );
}

function  swift_before_header(){
	do_atomic( 'swift_before_header' );
}

function swift_header(){
	do_atomic( 'swift_header' );
}

function  swift_after_header(){
	do_atomic( 'swift_after_header' );
}

function  swift_before_branding(){
	do_atomic( 'swift_before_branding' );
}

function  swift_after_branding(){
	do_atomic( 'swift_after_branding' );
}

function  swift_before_main(){
	do_atomic( 'swift_before_main' );
}

function  swift_after_main(){
	do_atomic( 'swift_after_main' );
}

function  swift_before_content(){
	do_atomic( 'swift_before_content' );
}

function  swift_after_content(){
	do_atomic( 'swift_after_content' );
}
function swift_before_footer(){
	do_atomic('swift_before_footer');
}
function swift_after_footer(){
	do_atomic('swift_after_footer');
}
