=== Plugin Name ===
Contributors: Bob Matsuoka
Donate link:
Tags: shortcodes, menu, show menu
Requires at least: 3.1
Tested up to: 3.2
Stable tag: 1.0

Provides a [show-menu] shortcode for displaying a menu within a post or page.

== Description ==

Provides a [show-menu] <a href="http://codex.wordpress.org/Shortcode_API" target="_blank">shortcodes</a> for  displaying a menu within a post or page.  The shortcode accepts most parameters that you can pass to the <a href="http://codex.wordpress.org/Template_Tags/wp_nav_menu" target="_blank">wp_nav_menu()</a> function.  For example, to show a menu add [show-menu menu="Main-menu"] in the page body.


= Usage =

*Show a menu*

`[show-menu menu="Main Menu"]`

= Please Note =

The default values are the same as for the [`wp_nav_menu()`](http://codex.wordpress.org/Template_Tags/wp_nav_menu). 'theme-location' and 'walker' are not supported as they can not be used within the shortcode.

== Changelog ==

= 1.0 =

* First release.

== Installation ==

1. Download and unzip the most recent version of this plugin
2. Upload the show-menu-shortcode folder to /path-to-wordpress/wp-content/plugins/
3. Login to your WP Admin panel, click Plugins, and activate "Show Menu Shortcode"