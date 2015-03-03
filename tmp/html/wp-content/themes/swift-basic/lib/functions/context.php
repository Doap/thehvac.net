<?php
function swift_get_context() {
	global $wp_query, $swift_context;

	/* If $swift_context has been set, don't run through the conditionals again. Just return the variable. */
	if ( isset( $swift_context ) )
		return $swift_context;

	$swift_context = array();

	/* Front page of the site. */
	if ( is_front_page() )
		$swift_context[] = 'home';

	/* Blog page. */
	if ( is_home() ) {
		$swift_context[] = 'blog';
	}

	/* Singular views. */
	elseif ( is_singular() ) {
		$swift_context[] = 'singular';
		$swift_context[] = "singular-{$wp_query->post->post_type}";
		$swift_context[] = "singular-{$wp_query->post->post_type}-{$wp_query->post->ID}";
	}

	/* Archive views. */
	elseif ( is_archive() ) {
		$swift_context[] = 'archive';

		/* Taxonomy archives. */
		if ( is_tax() || is_category() || is_tag() ) {
			$term = $wp_query->get_queried_object();
			$swift_context[] = 'taxonomy';
			$swift_context[] = "taxonomy-{$term->taxonomy}";
			$swift_context[] = "taxonomy-{$term->taxonomy}-" . sanitize_html_class( $term->slug, $term->term_id );
		}

		/* Post type archives. */
		elseif ( function_exists( 'is_post_type_archive' ) && is_post_type_archive() ) {
			$post_type = get_post_type_object( get_query_var( 'post_type' ) );
			$swift_context[] = "archive-{$post_type->name}";
		}

		/* User/author archives. */
		elseif ( is_author() ) {
			$swift_context[] = 'user';
			$swift_context[] = 'user-' . sanitize_html_class( get_the_author_meta( 'user_nicename', get_query_var( 'author' ) ), $wp_query->get_queried_object_id() );
		}

		/* Time/Date archives. */
		else {
			if ( is_date() ) {
				$swift_context[] = 'date';
				if ( is_year() )
					$swift_context[] = 'year';
				if ( is_month() )
					$swift_context[] = 'month';
				if ( get_query_var( 'w' ) )
					$swift_context[] = 'week';
				if ( is_day() )
					$swift_context[] = 'day';
			}
			if ( is_time() ) {
				$swift_context[] = 'time';
				if ( get_query_var( 'hour' ) )
					$swift_context[] = 'hour';
				if ( get_query_var( 'minute' ) )
					$swift_context[] = 'minute';
			}
		}
	}

	/* Search results. */
	elseif ( is_search() ) {
		$swift_context[] = 'search';
	}

	/* Error 404 pages. */
	elseif ( is_404() ) {
		$swift_context[] = 'error-404';
	}
	return array_map( 'esc_attr', $swift_context );
}
?>