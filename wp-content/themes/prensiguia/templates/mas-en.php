<?php
//$args = array( 'posts_per_page' => 4, 'offset'=> 11, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => $themaincat, 'ignore_sticky_posts' => 1 );
//$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => 4, 'offset'=> $max_posts, 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'cat' => $themaincat, 'meta_query' => array( 'relation' => 'OR', array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ), array( 'key' => 'breves', 'value' => 0, 'type' => 'NUMERIC' ) ), 'post__not_in' => $feat_post ) );
//$args = array( 'posts_per_page' => 4, 'offset'=> $max_posts, 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'cat' => $themaincat, 'meta_query' => array( 'relation' => 'OR', array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ), array( 'key' => 'breves', 'value' => 0, 'type' => 'NUMERIC' ) ), 'post__not_in' => $feat_post );
$args = array( 'posts_per_page' => 4, 'offset'=> $max_posts, 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'cat' => $themaincat, 'post__not_in' => $feat_post );
add_filter('posts_clauses', 'filterEdiciones');
add_filter('posts_clauses', 'filterNoBreves');
$the_query = new WP_Query( $args );
if( $the_query->have_posts() )
{
echo '<div class="destacados-section">';
echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.str_replace(" ","-",strtolower(remove_accents($single_cat_title))).'/page/2"><div class="title-left">MÁS EN ' . mb_strtoupper($single_cat_title) . '</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); 
	while($the_query->have_posts())
	{
		$the_query->the_post();

		$title = the_title_attribute('echo=0');
		$post_url = get_permalink($post->ID);
		echo '<div style="position:relative;float:left;width:150px;margin-right:10px;padding-left:4px;">';
		echo '<div class="tcp-product-list tcpf" style="width:150px;margin-bottom:10px;">';
		$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' ); 
		$feat_image = $feat_image_array[0];
		echo '<div style="position:relative;width:150px;margin-top:0px;margin-bottom:0px;border: 1px solid #ccc;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:150;"></a>' . PHP_EOL;
		echo '</div>';
		echo '<div class="mas-en-titles"><p><a href="' . $post_url . '">'. $title . '</a></p></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
	}
	echo '</div>' . PHP_EOL;
	echo '<div style="clear:both;"></div>' . PHP_EOL;
}
//var_dump($the_query);
?>
