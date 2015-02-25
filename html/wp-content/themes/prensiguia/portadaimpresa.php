<?php
echo '<div id=portada-impresa-home-section>';
echo '<div id=portada-impresa-home-section-inner>';
echo '<a href="http://noticias.laprensa.com.ni/category/portada-impresa">';
echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/category/noticias/portada-impresa"><div class="title-left">PORTADA IMPRESA</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading][/doap_animate]');
echo '</a>';
//echo do_shortcode('<div style=margin-bottom:20px;height:218px;width:250px;>[doap_custom_gallery source="category: 3680" limit="1" link="post" width="250" height="218" title="always" class="gallery-of-portadas"]</div>');
$args = array( 'post_type' => 'post', 'posts_per_page' => 1, 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'cat' => 3680, 'ignore_sticky_posts' => 1 );
wp_reset_query();
$port_query = new WP_Query( $args );
//var_dump($port_query);
if( $port_query->have_posts() ) 
{
//echo 'max posts = ' . $max_posts;
	echo '<div style="margin-bottom:20px;height:245px;width:270px;">';
	while( $port_query->have_posts() )
	{ 
		$port_query->the_post();
//	$title = the_title_attribute('echo=0');
		$theexcerpt = get_doap_excerpt(50,0);
		$post_url = get_permalink();
		echo '<div style="position:relative;float:left;width:270px;margin-right:10px;padding-left:4px;">';
		echo '<div class="tcp-product-list tcpf" style="width:270px;margin-bottom:10px;min-height:180px;">';
		$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'center-top-300x300' ); 
		$feat_image = $feat_image_array[0];
		echo '<div style="position:relative;width:270px;;margin-top:0px;margin-bottom:0px;border: 1px solid #ccc;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '" width="300"></a>' . PHP_EOL;
		echo '</div>';
	//echo '<div class="mas-en-titles"><p><a href="' . $post_url . '">'. $title . '</a></p></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '<div style="font-family:Arial;font-size:14px;color:#333;text-align:center;">' . $theexcerpt . '</div>';
		echo '<a href="/productos"><div style="font-family:Arial;font-size:18px;color:#333;text-align:center;">SUSCRIBASE AHORA</div></a>';
		echo '</div>' . PHP_EOL;
	}
echo '</div>' . PHP_EOL;
}
echo '</div>' . PHP_EOL;
echo '</div>' . PHP_EOL;
echo '<div style="clear:both;"></div>' . PHP_EOL;
?>
