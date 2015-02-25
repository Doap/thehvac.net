<?php
/**
 * Display Functions
 *
 * This file contains the functions that generate the HTML for all public facing views.
 * Some of these functions use core WordPress hooks/actions and the ones defined in
 * the theme.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * @package 	Swift
 * @author 		Satish Gandham <satish@swiftthemes.com>
 * @copyright	Copyright (c) 2011, Satish Gandham
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 		6.0
 * @alter 		6.0.9
 *
 */
/**
 * Generate page title
 *
 * Function for handling what the browser/search engine title should be. Attempts to handle every
 * possible situation WordPress throws at it for the best optimization.
 *
 * @since 6.0.0
 * @global $wp_query
 */
function swift_document_title() {
	global $wp_query;

	/* Set up some default variables. */
	$doctitle = '';
	$separator = ':';

	/* If viewing the front page and posts page of the site. */
	if (is_front_page() && is_home())
		$doctitle = get_bloginfo('name') . $separator . ' ' . get_bloginfo('description');

	/* If viewing the posts page or a singular post. */
	elseif (is_home() || is_singular()) {
		$post_id = $wp_query->get_queried_object_id();

		$doctitle = get_post_meta($post_id, 'Title', true);

		if (empty ($doctitle) && is_front_page())
			$doctitle = get_bloginfo('name') . $separator . ' ' . get_bloginfo('description');

		elseif (empty ($doctitle)) $doctitle = get_post_field('post_title', $post_id);
	}

	/* If viewing any type of archive page. */
	elseif (is_archive()) {

		/* If viewing a taxonomy term archive. */
		if (is_category() || is_tag() || is_tax()) {

			if (function_exists('single_term_title')) {
				$doctitle = single_term_title('', false);
			} else { // 3.0 compat
				$term = $wp_query->get_queried_object();
				$doctitle = $term->name;
			}
		}

		/* If viewing a post type archive. */
		elseif (function_exists('is_post_type_archive') && is_post_type_archive()) {
			$post_type = get_post_type_object(get_query_var('post_type'));
			$doctitle = $post_type->labels->name;
		}

		/* If viewing an author/user archive. */
		elseif (is_author()) $doctitle = get_the_author_meta('display_name', get_query_var('author'));

		/* If viewing a date-/time-based archive. */
		elseif (is_date()) {
			if (get_query_var('minute') && get_query_var('hour'))
				$doctitle = sprintf(__('Archive for %s', 'swift'),
						/* translators: See http://codex.wordpress.org/Formatting_Date_and_Time */
						get_the_time(_x('g:i a', 'date and time', 'swift')));

			elseif (get_query_var('minute')) $doctitle = sprintf(__('Archive for minute %s', 'swift'),
					/* translators: See http://codex.wordpress.org/Formatting_Date_and_Time */
					get_the_time(_x('i', 'date and time', 'swift')));

			elseif (get_query_var('hour')) $doctitle = sprintf(__('Archive for %s', 'swift'),
					/* translators: See http://codex.wordpress.org/Formatting_Date_and_Time */
					get_the_time(_x('g a', 'date and time', 'swift')));

			elseif (is_day()) $doctitle = sprintf(__('Archive for %s', 'swift'),
					/* translators: See http://codex.wordpress.org/Formatting_Date_and_Time */
					get_the_time(_x('F jS, Y', 'date and time', 'swift')));

			elseif (get_query_var('w'))
			/* translators: %1$s = week number; %2$s = year. */
			$doctitle = sprintf(__('Archive for week %1$s of %2$s', 'swift'),
					/* translators: See http://codex.wordpress.org/Formatting_Date_and_Time */
					get_the_time(_x('W', 'date and time', 'swift')),
					/* translators: See http://codex.wordpress.org/Formatting_Date_and_Time */
					get_the_time(_x('Y', 'date and time', 'swift')));

			elseif (is_month()) $doctitle = sprintf(__('Archive for %s', 'swift'), single_month_title(' ', false));

			elseif (is_year()) $doctitle = sprintf(__('Archive for %s', 'swift'),
					/* translators: See http://codex.wordpress.org/Formatting_Date_and_Time */
					get_the_time(_x('Y', 'date and time', 'swift')));
		}
	}

	/* If viewing a search results page. */
	elseif (is_search()) $doctitle = sprintf(__('Search results for &quot;%s&quot;', 'swift'), esc_attr(get_search_query()));

	/* If viewing a 404 not found page. */
	elseif (is_404()) $doctitle = __('404 Not Found', 'swift');

	/* If the current page is a paged page. */
	if ((($page = $wp_query->get('paged')) || ($page = $wp_query->get('page'))) && $page > 1)
		$doctitle = sprintf(__('%1$s Page %2$s', 'swift'), $doctitle . $separator, number_format_i18n($page));

	/* Apply the wp_title filters so we're compatible with plugins. */
	echo apply_filters('wp_title', $doctitle, $separator, '');
}

/**
 * Add read more link to excerpts
 * @param $more
 * @notes removed the filter as this was adding continue reading to the slider
 */
function custom_excerpt_more($more) {
	GLOBAL $swift_options, $swift_design_options;
	if ($swift_design_options['blog_or_mag'] != 'blog')
		return '[&hellip;]';
	else
		return ' <a href="' . get_permalink() . '" class="btn small continue-reading alignright"><span>' . $swift_options['continue_reading_button_text'] . '</span></a>';
}
//add_filter( 'excerpt_more', 'custom_excerpt_more' );

/**
 * Generate post meta.
 *
 * Prints the post meta information based on the options set in theme options page.
 * Called around post titles on home page and single pages.
 *
 * @param 	array	$meta 		post meta order set in options page.
 * @param 	string	$classes	html classes for the post meta wrapper.
 *
 */
function swift_meta_generator($meta, $classes) {
	$data = '<div class="entry-meta ' . $classes . '">';
	$size = count($meta);
	for ($i = 0; $i < $size; $i++) {
		switch ($meta[$i]) {
			case 'text' :
				if((current_time('timestamp',1)-get_the_date('U')) <86400 )
					$meta[$i+1] = preg_replace('(on)', '', $meta[$i+1]);
				$data .= $meta[$i +1];
				$i++;
				break;

			case 'author' :
				$data .= '<span class="author"><a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" rel="author">' . esc_attr(get_the_author()) . '</a></span> ';
				break;

			case 'date' :
				if((current_time('timestamp',1)-get_the_date('U')) <86400 )
					$date = human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago';
				else
					$date = get_the_date();

				$data .= '<span class="date"><a href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_time()) . '" rel="bookmark">';
				$data .= '<time class="entry-date" datetime="' . esc_attr(get_the_date('c')) . '" pubdate="pubdate">' . esc_html($date) . '</time></a></span> ';
				break;

			case 'categories' :
				$data .= get_the_category_list(', ');
				break;

			case 'tags' :
				$data .= get_the_tag_list(' ',', ',' ');
				break;
		}
	}
	echo $data . '</div>';
}

if (!function_exists('swift_posted_on'))
	:
	/**
	 * Print post published date
*
* Prints HTML with meta information for the current post-date/time and author.
* Create your own swift_posted_on to override in a child theme
*
* @since Swift 6.0
*/
function swift_posted_on() {
	?>
<span class="entry-meta posted-on"> <span class="sep"><?php _e( 'Posted on', 'swift' ); ?>
</span> <a href="<?php echo esc_url( get_permalink() ); ?>"
	title="<?php echo esc_attr( get_the_time() ); ?>" rel="bookmark"><time
			class="entry-date"
			datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"
			pubdate="pubdate">
			<?php echo esc_html( get_the_date() ) ?>
		</time> </a> <span class="by-author"> <span class="sep"><?php echo ' '._x( 'by', 'date BY name', 'swift' ).' '; ?>
	</span> <span class="author vcard"> <a class="url fn n"
			href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"
			title="<?php printf( esc_attr__( 'View all posts by %s', 'swift' ), get_the_author() ); ?>"
			rel="author"><?php echo esc_html( get_the_author() ) ?> </a>
	</span>
</span>
</span>
<?php


}
endif;

if (!function_exists('swift_filed_under'))
	:
	/**
	 * Print post categories
*
* Prints HTML for the cureent post categories.
* Create your own swift_filed_under to override in a child theme
*
*/
function swift_filed_under() {
?>
<span class="single-entry-meta filed-under"><?php _e( 'Filed under', 'swift' )?>
	<span class="uppercase"><?php the_category( ', ' )?> </span> </span>
<?php


}
endif;

if (!function_exists('swift_tagged_with'))
	:
	/**
	 * Print post tags
*
* Prints HTML for the current post tags.
* Create your own swift_tagged_with to override in a child theme
*/
function swift_tagged_with() {
?>
<span class="single-entry-meta tagged-with"><?php _e( 'Tagged with', 'swift' )?>
	<span class="uppercase"><h6>
			<?php the_tags('', ', ', ' '); ?>
		</h6> </span> </span>
<?php


}
endif;

add_action('wp_head', 'swift_header_scripts');
/**
 * Inserts the header scripts added in swift options in <head> tag
*/
function swift_header_scripts() {
	GLOBAL $swift_options;
	if (isset ($swift_options['header_scripts']) && $swift_options['header_scripts'])
		echo stripslashes($swift_options['header_scripts']);
}

add_action('wp_footer', 'swift_footer_scripts');
/**
 * Inserts the footer scripts added in swift options before </body> tag
*/
function swift_footer_scripts() {
	GLOBAL $swift_options;
	if (isset ($swift_options['footer_scripts']) && $swift_options['footer_scripts'])
		echo stripslashes($swift_options['footer_scripts']);
}

add_action('swift_before_header', 'swift_before_header_ad', 8);
/**
 * Inserts the ad above header
*/
function swift_before_header_ad() {
	GLOBAL $swift_options, $swift_is_mobile;
	if ($swift_is_mobile->isMobile() && !$swift_is_mobile->isTablet())
		return;

	if (isset ($swift_options['above_header_ad_enable']) && $swift_options['above_header_ad_enable'] && isset ($swift_options['above_header_ad']) && $swift_options['above_header_ad'] != '') {
?>
<div id="above-header-ad-container">
	<div class="div-content hybrid">
		<?php echo stripslashes( $swift_options['above_header_ad'] )?>
	</div>
</div>
<?php


	}
}

/**
 * Hooking fucntions to swift_after_header_open
 */

add_action('swift_header', 'swift_nav_above_logo', 8);

/**
 *
 * Inserts the navigation above logo
*/
function swift_nav_above_logo() {
	GLOBAL $swift_options;

	if (has_nav_menu('above-logo'))
		:
		?>
<div id="above-logo-container">
	<nav id="above-logo" class="hybrid navigation clearfix"
		role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'above-logo', 'container' => false, 'menu_class' => 'nav clearfix', 'items_wrap' => '<ul class="%2$s">%3$s', ) ); ?>
		</ul>
		<?php if( isset( $swift_options['rss_links_enable'] ) && $swift_options['rss_links_enable'] == true ) get_template_part( 'lib/includes/rss-links' );?>

	</nav>
</div>
<?php
endif;
}

add_action('swift_header', 'swift_branding', 15);
/**
 *
 * Generates the header content ( content between the two navigation menus )
*/
function swift_branding() {
	GLOBAL $swift_options;
	?>
<div id="branding-container">
	<div id="branding" class="clearfix hybrid">
		<div class="div-content clearfix">
			<?php swift_before_branding() ?>

			<?php


		if (isset ($swift_options['logo']) && $swift_options['logo'] != '') {
			if (is_front_page() || is_home()) {
	?>
				<h1 id="logo-wrapper">
					<a href="<?php echo home_url(); ?>"
						title="<?php bloginfo( 'description' ); ?>"><img
						src="<?php echo $swift_options['logo']?>"
						alt="<?php bloginfo( 'name' ); ?>" id="logo" /> </a>
				</h1>
				<?php


			} else {
	?>
				<h2 id="logo-wrapper">
					<a href="<?php echo home_url(); ?>"
						title="<?php bloginfo( 'description' ); ?>"><img
						src="<?php echo $swift_options['logo']?>"
						alt="<?php bloginfo( 'name' ); ?>" id="logo" /> </a>
				</h2>
				<?php


			}
}
	elseif (is_front_page() || is_home()) {
?>
			<hgroup class="alignleft">
				<h1 id="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
						title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo( 'name' ); ?>
					</a>
				</h1>
				<h2 id="site-description">
					<?php bloginfo( 'description' ); ?>
				</h2>
			</hgroup>
			<?php


	} else {
?>
			<hgroup class="alignleft">
				<h3 id="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
						title="<?php bloginfo( 'name'); ?>" rel="home"><?php bloginfo( 'name' ); ?>
					</a>
				</h3>
				<h4 id="site-description">
					<?php bloginfo( 'description' ); ?>
				</h4>
			</hgroup>
			<?php
	}
	?>
<?php swift_after_branding()?>
		</div>
	</div>
	<!-- /branding -->
</div>
<div class="clear"></div>
<?php


}

add_action('swift_header', 'swift_nav_below_logo', 20);
/**
 *
 * Inserts the navigation below logo
*/
function swift_nav_below_logo() {
	GLOBAL $swift_options;
	if (has_nav_menu('below-logo'))
		:
		?>
<div id="below-logo-container">
	<nav id="below-logo" class="hybrid navigation clearfix"
		role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'below-logo', 'container' => false, 'menu_class' => 'nav clearfix', 'items_wrap' => '<ul class="%2$s">%3$s', ) ); ?>
		</ul>
		<?php if( isset( $swift_options['nav_search_enable'] ) && $swift_options['nav_search_enable'] == true) 	get_template_part( 'searchform-nav' );?>
	</nav>
</div>
<?php
endif;
}

add_action('swift_after_branding', 'swift_header_ad', 12);
/**
 *
 * Inserts the ad in header
*/
function swift_header_ad() {
	GLOBAL $swift_options, $swift_is_mobile;

	// If the user is on mobile, dont display header ad
	if ($swift_is_mobile->isMobile() && !$swift_is_mobile->isTablet())
		return;

	if (isset ($swift_options['header_ad_enable']) && $swift_options['header_ad_enable'] && isset ($swift_options['header_ad']) && $swift_options['header_ad'] != '') {
?>
<div id="header-ad" class="alignright">
	<?php echo stripslashes( $swift_options['header_ad'] )?>
</div>
<?php


	}
}

add_action('swift_after_header', 'swift_nav_ad', 12);
function swift_nav_ad() {
	GLOBAL $swift_is_mobile, $swift_options;
	if ($swift_is_mobile->isMobile() && !$swift_is_mobile->isTablet()) {
		$swift_options['nav_ad'] = $swift_options['ads_for_mobile'];
	}
	if (isset ($swift_options['nav_ad_enable']) && $swift_options['nav_ad_enable'] && isset ($swift_options['nav_ad']) && $swift_options['nav_ad'] != '')
		:
		?>
<div id="nav-ad-container">
	<div class="hybrid">
		<div class="div-content">
			<?php echo stripslashes( $swift_options['nav_ad'] )?>
		</div>
	</div>
</div>
<?php
endif;
}
add_action('swift_before_footer', 'swift_footer_ad');
function swift_footer_ad() {
	GLOBAL $swift_options;
	if (isset ($swift_options['footer_ad_enable']) && $swift_options['footer_ad_enable'] && isset ($swift_options['footer_ad']) && $swift_options['footer_ad'] != '')
		:
		?>
<div id="footer-ad-container">
	<div id="footer-ad" class="hybrid">
		<div class="div-content clearfix">
			<?php 	echo stripslashes( $swift_options['footer_ad'] )?>
		</div>
	</div>
</div>
<?php
endif;
}
add_filter('the_content', 'swift_single_ads', 16);
/**
 *
 * Inserts the ads in post content
 * @param unknown_type $content
*/
function swift_single_ads($content) {
	global $wp_query;
	$swift_post_meta = get_post_meta($wp_query->post->ID, '_swift_post_meta', true);
	if (!is_single() || is_attachment() || (isset ($swift_post_meta['disable_ads']) && $swift_post_meta['disable_ads']))
		return $content;

	GLOBAL $swift_options, $swift_is_mobile;

	// If the visitor is on mobile, we change the ad code
	if ($swift_is_mobile->isMobile() && !$swift_is_mobile->isTablet()) {
		$swift_options['before_content_ad'] = $swift_options['after_content_ad'] = $swift_options['ads_for_mobile'];
		$swift_options['between_content_ad_enable'] = '';
	}

	if ((isset ($swift_options['between_content_ad_enable']) && $swift_options['between_content_ad_enable'] && isset ($swift_options['between_content_ad']) && $swift_options['between_content_ad'] != '') || (isset ($swift_options['after_first_p_ad_enable']) && $swift_options['after_first_p_ad_enable'] && isset ($swift_options['after_first_p_ad']) && $swift_options['after_first_p_ad'] != '')) {

		$temp = explode('</p>', $content);
		$add_after = (int) (count($temp) / 2);
		$content = NULL;

		for ($i = 0; $i < count($temp); $i++) {
			$content .= $temp[$i] . '</p>';
			if (($i +1 == $add_after) && (isset ($swift_options['between_content_ad_enable']) && $swift_options['between_content_ad_enable'] && isset ($swift_options['between_content_ad']) && $swift_options['between_content_ad'] != '')) {
				$content .= stripslashes($swift_options['between_content_ad']);
			}
			if (($i == 1) && (isset ($swift_options['after_first_p_ad_enable']) && $swift_options['after_first_p_ad_enable'] && isset ($swift_options['after_first_p_ad']) && $swift_options['after_first_p_ad'] != '')) {
				$content .= stripslashes($swift_options['after_first_p_ad']);
			}
		}

	}

	if (isset ($swift_options['before_content_ad_enable']) && $swift_options['before_content_ad_enable'] && isset ($swift_options['before_content_ad']) && $swift_options['before_content_ad'] != '') {
		$content = stripslashes($swift_options['before_content_ad']) . $content;
	}

	if (isset ($swift_options['after_content_ad_enable']) && $swift_options['after_content_ad_enable'] && isset ($swift_options['after_content_ad']) && $swift_options['after_content_ad'] != '') {
		$content = $content . stripslashes($swift_options['after_content_ad']);
	}
	return $content;
}

add_filter('post_thumbnail_html', 'swift_post_image_html', 10, 5);
/**
 *
 * Wraps the thumbnail images in <a> tag, returns the default image in case ni thumbnail is set.
 *
 * @param $html
 * @param $post_id
 * @param $post_thumbnail_id
 * @param $size
 * @param $attr
*/
function swift_post_image_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
	global $swift_options;
	global $_wp_additional_image_sizes;
	if ($html != '') {
		$html = '<a href="' . get_permalink($post_id) . '" title="' . esc_attr(strip_tags(apply_filters('the_title', get_post_field('post_title', $post_id), $post_id))) . '">' . $html . '</a>';
		return $html;
	}
	elseif (isset ($swift_options['default_thumb']) && $swift_options['default_thumb'] != "") {
		$html = '<a href="' . get_permalink($post_id) . '" title="' . esc_attr(strip_tags(apply_filters('the_title', get_post_field('post_title', $post_id), $post_id))) . '">
					<img src="' . $swift_options['default_thumb'] . '" class="' . $attr['class'] . '" width="' . $size[0] . '" height="' . ($size[1]) . '" /></a>';
		return $html;

	}
}

/**
 * code taken from http://wordpress.stackexchange.com/questions/13044/how-can-i-add-title-attributes-to-next-and-previous-post-link-functions/21987#21987
 */

add_filter('next_post_link', 'swift_add_title_to_next_post_link');

/**
 * Adds title attribute to next post link
 * @param $link
*/
function swift_add_title_to_next_post_link($link) {
	global $post;
	$next_post = get_next_post();
	if (!empty ($next_post))
		: $title = $next_post->post_title;
	$link = str_replace("rel=", " title='" . $title . "' rel", $link);
	endif;
	return $link;
}

add_filter('previous_post_link', 'swift_add_title_to_previous_post_link');
/**
 *
 * Adds title attribute to previous post link
 * @param unknown_type $link
*/
function swift_add_title_to_previous_post_link($link) {
	global $post;
	$previous_post = get_previous_post();
	if (!empty ($previous_post))
		: $title = $previous_post->post_title;
	$link = str_replace("rel=", " title='" . $title . "' rel", $link);
	endif;
	return $link;
}
?>