<?php
function swift_get_posts_by_taxonomy ( $args = null ) {
	global $wp_query;

	$posts = array();

	/* Parse arguments, and declare individual variables for each. */

	$defaults = array(
			'limit' => 5,
			'post_type' => 'any',
			'taxonomies' => 'post_tag, category',
			'specific_terms' => '',
			'relationship' => 'OR',
			'order' => 'DESC',
			'orderby' => 'date',
			'operator' => 'IN',
			'exclude' => ''
	);

	$args = wp_parse_args( $args, $defaults );

	extract( $args, EXTR_SKIP );

	// Make sure the order value is safe.
	if ( ! in_array( $order, array( 'ASC', 'DESC' ) ) ) {
		$order = $defaults['order'];
	}

	// Make sure the orderby value is safe.
	if ( ! in_array( $orderby, array( 'none', 'id', 'author', 'title', 'date', 'modified', 'parent', 'rand', 'comment_count', 'menu_order' ) ) ) {
		$orderby = $defaults['orderby'];
	}

	// Make sure the operator value is safe.
	if ( ! in_array( $operator, array( 'IN', 'NOT IN', 'AND' ) ) ) {
		$orderby = $defaults['operator'];
	}

	// Convert our post types to an array.
	if ( ! is_array( $post_type ) ) {
		$post_type = explode( ',', $post_type );
	}

	// Convert our taxonomies to an array.
	if ( ! is_array( $taxonomies ) ) {
		$taxonomies = explode( ',', $taxonomies );
	}

	// Convert exclude to an array.
	if ( ! is_array( $exclude ) && ( $exclude != '' ) ) {
		$exclude = explode( ',', $exclude );
	}

	if ( ! count( (array)$taxonomies ) ) {
		return;
	}

	// Clean up our taxonomies for use in the query.
	if ( count( $taxonomies ) ) {
		foreach ( $taxonomies as $k => $v ) {
			$taxonomies[$k] = trim( $v );
		}
	}

	// Determine which terms we're going to relate to this entry.
	$related_terms = array();

	foreach ( $taxonomies as $t ) {
		$terms = get_terms( $t, 'orderby=id&hide_empty=1' );

		if ( ! empty( $terms ) ) {
			foreach ( $terms as $k => $v ) {
				$related_terms[$t][$v->term_id] = $v->slug;
			}
		}
	}

	// If specific terms are available, use those.
	if ( ! is_array( $specific_terms ) ) {
		$specific_terms = explode( ',', $specific_terms );
	}

	if ( count( $specific_terms ) ) {
		foreach ( $specific_terms as $k => $v ) {
			$specific_terms[$k] = trim( $v );
		}
	}

	// Look for posts with the same terms.

	// Setup query arguments.
	$query_args = array();

	if ( $post_type ) {
		$query_args['post_type'] = $post_type;
	}

	if ( $limit ) {
		$query_args['posts_per_page'] = $limit;
		// $query_args['nopaging'] = true;
	}

	// Setup specific posts to exclude.
	if ( count( $exclude ) > 0 ) {
		$query_args['post__not_in'] = $exclude;
	}

	$query_args['order'] = $order;
	$query_args['orderby'] = $orderby;

	$query_args['tax_query'] = array();

	// Setup for multiple taxonomies.

	if ( count( $related_terms ) > 1 ) {
		$query_args['tax_query']['relation'] = $args['relationship'];
	}

	// Add the taxonomies to the query arguments.

	foreach ( (array)$related_terms as $k => $v ) {
		$terms_for_search = array_values( $v );

		if ( count( $specific_terms ) ) {
			$specific_terms_by_tax = array();

			foreach ( $specific_terms as $i => $j ) {
				if ( in_array( $j, array_values( $v ) ) ) {
					$specific_terms_by_tax[] = $j;
				}
			}

			if ( count( $specific_terms_by_tax ) ) {
				$terms_for_search = $specific_terms_by_tax;
			}
		}

		$query_args['tax_query'][] = array(
				'taxonomy' => $k,
				'field' => 'slug',
				'terms' => $terms_for_search,
				'operator' => $operator
		);
	}

	if ( empty( $query_args['tax_query'] ) ) {
		return;
	}

	$query_saved = $wp_query;

	$query = new WP_Query( $query_args );

	if ( $query->have_posts() ) {
		while( $query->have_posts() ) {
			$query->the_post();

			$posts[] = $query->post;
		}
	}

	$query = $query_saved;

	wp_reset_query();

	return $posts;

} // End swift_get_posts_by_taxonomy()
?>