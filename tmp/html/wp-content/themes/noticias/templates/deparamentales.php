<?php

$args = array( 'posts_per_page' => 2, 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'cat' => 26, 'ignore_sticky_posts' => 1 );
add_filter('posts_clauses', 'filterEdiciones');
$departamentales_posts = new WP_Query( $args );
if ($departamentales_posts->have_posts())
{ 
	$departamentales_section .= do_shortcode('
[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/departamentales"><div class="title-left">DEPARTAMENTALES</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading][/doap_animate]'); 

	//$departamentales_section .= '<div id="dept-block" style="border:0px solid #000;background-color:#eae8dd;margin:0px;padding:5px;min-height:217px;">';
	$departamentales_section .= '<div id="dept-block">';
	$dep_count=0;
	while( $departamentales_posts->have_posts())
	{	
		$dep_count++;
		$dep_float = ($dep_count == 2) ? 'right' : 'left';
		$departamentales_posts->the_post();
		$title = the_title_attribute('echo=0');
		$post_url = get_permalink($post->ID);
		$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' ); 
		$feat_image = $feat_image_array[0];
		//$departamentales_section .= '<div id="dept-story-' . $dep_count . '" style="position:relative;float:' . $dep_float . ';width:49%;">';
		$departamentales_section .= '<div id="dept-story-' . $dep_count . '">';
		$departamentales_section .= '<div class="tcp-product-list tcpf" style="width:' . $feat_image_array['1'] . 'px;">';
		//$departamentales_section .= '<div style="position:relative;float:left;width:' . $feat_image_array['1'] . 'px;margin-right:10px;padding-left:4px;">';
		//$departamentales_section .= '<div class="tcp-product-list tcpf" style="width:' . $feat_image_array['1'] . 'px;margin-bottom:10px;min-height:300px;">';
		$departamentales_section .= '<div style="position:relative;width:' . $feat_image_array['1'] . 'px;margin-top:0px;margin-bottom:0px;border: 1px solid #666;">' . PHP_EOL . '<a href="' . $post_url . '"><img width="' . $feat_image_array['1'] . '" height="' . $feat_image_array['2'] . '" src="' . $feat_image . '"></a>' . PHP_EOL;
		$departamentales_section .= '</div>';
		$departamentales_section .= '<div class="dept-titles"><center><b><a href="' . $post_url . '">'. $title . '</a></b></center></div>' . PHP_EOL;
		$departamentales_section .= '</div>' . PHP_EOL;
		$departamentales_section .= '</div>' . PHP_EOL;
		$departamentales_section .= '<div class="mobile-clear"></div>' . PHP_EOL;
	}
	$departamentales_section .= '</div>' . PHP_EOL;
}
//wp_reset_query();
?>
