<?php /*
Plugin Name:  swift Breadcrumbs
Plugin URI:   http://swift.com/wordpress/breadcrumbs/
Description:  Outputs a fully customizable breadcrumb path.
Version:      0.8.5
Author:       Joost de Valk
Author URI:   http://swift.com/

Copyright (C) 2008-2010, Joost de Valk
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
Neither the name of Joost de Valk or swift nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.*/


function swift_breadcrumb($prefix = '', $suffix = '', $display = true) {
	global $wp_query, $post;
		
	// Load some defaults
	$opt 						= array();
	$opt['home'] 				= "Home";
	$opt['blog'] 				= "Blog";
	$opt['sep'] 				= "/";
	$opt['prefix']				= "";
	$opt['boldlast'] 			= false;
	$opt['nofollowhome'] 		= false;
	$opt['singleparent'] 		= 0;
	$opt['singlecatprefix']		= true;
	$opt['archiveprefix'] 		= "Archives for";
	$opt['searchprefix'] 		= "Search for";


	if (!function_exists('swift_get_category_parents')) {
		// Copied and adapted from WP source
		function swift_get_category_parents($id, $link = FALSE, $separator = '/', $nicename = FALSE){
			$chain = '';
			$parent = &get_category($id);
			if ( is_wp_error( $parent ) )
			   return $parent;

			if ( $nicename )
			   $name = $parent->slug;
			else
			   $name = $parent->cat_name;

			if ( $parent->parent && ($parent->parent != $parent->term_id) )
			   $chain .= get_category_parents($parent->parent, true, $separator, $nicename);
			
			$chain .= $name;
			   
			return $chain;
		}
	}
	
	$nofollow = ' ';
	if ($opt['nofollowhome']) {
		$nofollow = ' rel="nofollow" ';
	}
	
	$on_front = get_option('show_on_front');
	
	if ($on_front == "page") {
		$homelink = '<a'.$nofollow.'href="'.get_permalink(get_option('page_on_front')).'" id="swift-breadcrumbs-home">'.$opt['home'].'</a>';
		$bloglink = $homelink.' '.$opt['sep'].' <a href="'.get_permalink(get_option('page_for_posts')).'">'.$opt['blog'].'</a>';
	} else {
		$homelink = '<a'.$nofollow.'href="'.get_bloginfo('url').'" id="swift-breadcrumbs-home">'.$opt['home'].'</a>';
		$bloglink = $homelink;
	}
		
	if ( ($on_front == "page" && is_front_page()) || ($on_front == "posts" && is_home()) ) {
		$output = $opt['home'];
	} elseif ( $on_front == "page" && is_home() ) {
		$output = $homelink.' '.$opt['sep'].' '.$opt['blog'];
	} elseif ( !is_page() ) {
		$output = $bloglink.' '.$opt['sep'].' ';
		if ( ( is_single() || is_category() || is_tag() || is_date() || is_author() ) && $opt['singleparent'] != false) {
			$output .= '<a href="'.get_permalink($opt['singleparent']).'">'.get_the_title($opt['singleparent']).'</a> '.$opt['sep'].' ';
		} 
		if (is_single() && $opt['singlecatprefix']) {
			$cats = get_the_category();
			$cat = $cats[0];
			if ( is_object($cat) ) {
				if ($cat->parent != 0) {
					$output .= get_category_parents($cat->term_id, true, " ".$opt['sep']." ");
				} else {
					$output .= '<a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a> '.$opt['sep'].' '; 
				}
			}
		}
		if ( is_category() ) {
			$cat = intval( get_query_var('cat') );
			$output .= swift_get_category_parents($cat, false, " ".$opt['sep']." ");
		} elseif ( is_tag() ) {
			$output .= $opt['archiveprefix']." ".single_cat_title('',false);
		} elseif ( is_date() ) { 
			$output .= $opt['archiveprefix']." ".single_month_title(' ',false);
		} elseif ( is_author() ) { 
			$user = get_userdatabylogin($wp_query->query_vars['author_name']);
			$output .= $opt['archiveprefix']." ".$user->display_name;
		} elseif ( is_search() ) {
			$output .= $opt['searchprefix'].' "'.stripslashes(strip_tags(get_search_query())).'"';
		} else if ( is_tax() ) {
			$taxonomy 	= get_taxonomy ( get_query_var('taxonomy') );
			$term 		= get_query_var('term');
			$output .= $taxonomy->label .': '. $term ;
		} else {
			$output .= get_the_title();
		}
	} else {
		$post = $wp_query->get_queried_object();

		// If this is a top level Page, it's simple to output the breadcrumb
		if ( 0 == $post->post_parent ) {
			$output = $homelink." ".$opt['sep']." ".get_the_title();
		} else {
			if (isset($post->ancestors)) {
				if (is_array($post->ancestors))
					$ancestors = array_values($post->ancestors);
				else 
					$ancestors = array($post->ancestors);				
			} else {
				$ancestors = array($post->post_parent);
			}

			// Reverse the order so it's oldest to newest
			$ancestors = array_reverse($ancestors);

			// Add the current Page to the ancestors list (as we need it's title too)
			$ancestors[] = $post->ID;

			$links = array();			
			foreach ( $ancestors as $ancestor ) {
				$tmp  = array();
				$tmp['title'] 	= strip_tags( get_the_title( $ancestor ) );
				$tmp['url'] 	= get_permalink($ancestor);
				$tmp['cur'] = false;
				if ($ancestor == $post->ID) {
					$tmp['cur'] = true;
				}
				$links[] = $tmp;
			}

			$output = $homelink;
			foreach ( $links as $link ) {
				$output .= ' '.$opt['sep'].' ';
				if (!$link['cur']) {
					$output .= '<a href="'.$link['url'].'">'.$link['title'].'</a>';
				} else {
					$output .= $link['title'];
				}
			}
		}
	}
	if ($opt['prefix'] != "") {
		$output = $opt['prefix']." ".$output;
	}
	if ($display) {
		echo '<div id="breadcrumbs">'.$output.'</div>';
	} else {
		return $prefix.$output.$suffix;
	}
}

function swift_add_breadcrumbs(){
	if( !is_home() && !is_front_page() )
	add_action('swift_before_content','swift_breadcrumb',10,1);
}

add_action( 'wp_head', 'swift_add_breadcrumbs')
?>
