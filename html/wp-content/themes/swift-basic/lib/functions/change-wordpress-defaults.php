<?php
/**
 * This file contains filters and code that changes some of the WordPress default
 * behaviour
 */

// Remove default gallery styling
add_filter('gallery_style', create_function('$a', 'return preg_replace("%<style type=\'text/css\'>(.*?)</style>%s", "", $a);'));

// TinyMCE (WordPress post editor) removes blank div tags, which are necessary to add
// <div class="clear"></div>, this little piece of code stops TinyMCE from doing that.
add_filter('tiny_mce_before_init', create_function( '$a',
'$a["extended_valid_elements"] = "div[*]"; return $a;') );

// Removes autoformatting from excerpts
remove_filter('the_excerpt', 'wpautop');
