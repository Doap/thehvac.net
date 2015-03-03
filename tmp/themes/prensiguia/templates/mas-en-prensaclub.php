<?php
//$args = array( 'posts_per_page' => 4, 'offset'=> 11, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => $themaincat, 'ignore_sticky_posts' => 1 );
//$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => 4, 'offset'=> $max_posts, 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'cat' => $themaincat, 'meta_query' => array( 'relation' => 'OR', array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ), array( 'key' => 'breves', 'value' => 0, 'type' => 'NUMERIC' ) ), 'post__not_in' => $feat_post ) );
//$args = array( 'posts_per_page' => 4, 'offset'=> $max_posts, 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'cat' => $themaincat, 'meta_query' => array( 'relation' => 'OR', array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ), array( 'key' => 'breves', 'value' => 0, 'type' => 'NUMERIC' ) ), 'post__not_in' => $feat_post );
//require_once (WP_PLUGIN_DIR . '/shortcodes-ultimate/inc/core/tools.php');
$args = array( 'posts_per_page' => 3, 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'cat' => 64839 );
add_filter('posts_clauses', 'filterEdiciones');
//add_filter('posts_clauses', 'filterNoBreves');
$the_query = new WP_Query( $args );
if( $the_query->have_posts() )
{
echo '<div class="destacados-section">';
echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/prensaclub-promociones"><div class="title-left">MÁS PROMOCIONES EN PRENSA CLUB</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); 
echo '<div style="height:4px;clear:both;"></div>';
	while($the_query->have_posts())
	{
		$the_query->the_post();
$mas_en_count++;
$marg_right = ($mas_en_count == 3) ? 'margin-right:0;' : 'margin-right:25px;';
		$title = the_title_attribute('echo=0');
		$post_url = get_permalink($post->ID);
		echo '<div style="position:relative;float:left;width:194px;' . $marg_right . 'padding-left:4px;">';
		echo '<div class="tcp-product-list tcpf" style="width:194px;margin-bottom:10px;">';
		$img_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
		$image = su_image_resize( $img_url, 194, 150 );
		$feat_image = $image['url'];
//		$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'caricatura-home' ); 
//		$feat_image = $feat_image_array[0];
		echo '<div style="position:relative;width:194px;margin-top:0px;margin-bottom:0px;border: 1px solid #ccc;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '" width="194" height="150"></a>' . PHP_EOL;
		echo '</div>';
		//echo '<div class="mas-en-titles"><p><a href="' . $post_url . '">'. $title . '</a></p></div>' . PHP_EOL;
        	echo '<a href="' . $post_url . '"><div class="mas-en-prensaclub" style="font-family:Arial;font-size:.9em;color:#333;margin:10px 10px 0 0;text-align: justify;">' . PHP_EOL;
		$theexcerpt = get_doap_excerpt(295,1,1);
        	echo $theexcerpt;
        	echo '</div></a>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '<div class="mobile-clear"></div>' . PHP_EOL;
	}
	echo '</div>' . PHP_EOL;
	echo '<div style="clear:both;"></div>' . PHP_EOL;
}
//var_dump($the_query);
?>
