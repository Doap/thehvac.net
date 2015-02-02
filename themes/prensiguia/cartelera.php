<?php
echo do_shortcode('<div>[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/cartelera-de-cine"><div class="title-left">CARTELERA DE CINE</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading][/doap_animate]');
echo '<div style="height:4px;clear:both;"></div><div class="cart-home-box">';
$args = array( 'post_type' => 'post', 'posts_per_page' => 3, 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'cat' => 23782, 'ignore_sticky_posts' => 1 );
$myposts = get_posts( $args );
foreach ( $myposts as $post )
{	
	setup_postdata( $post );
	$title = the_title_attribute('echo=0');
	$post_url = get_permalink($post->ID);
	echo '<div style="position:relative;float:left;width:200px;margin-right:10px;padding-left:4px;">';
	echo '<div class="tcp-product-list tcpf" style="width:200px;margin-bottom:10px;min-height:298px;">';
	$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-200' ); 
	$feat_image = $feat_image_array[0];
	echo '<div style="position:relative;width:200px;margin-top:0px;margin-bottom:0px;border: 1px solid #ccc;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '" width="200" height="298"></a>' . PHP_EOL;
	echo '</div>';
	//echo '<div class="mas-en-titles"><p><a href="' . $post_url . '">'. $title . '</a></p></div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
}
	echo '</div>' . PHP_EOL;
	wp_reset_postdata();

	echo '</div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;

 ?>

