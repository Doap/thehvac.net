<?php
add_filter('body_class', 'swift_mag_class', 10, 2);
function swift_mag_class($classes) {
	global $swift_design_options;
	if ($swift_design_options['blog_or_mag'] == 'magazine-full' && !is_single()) {
		$classes[] = 'mag-full';
	}
	return $classes;
}