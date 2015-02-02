<?php
echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/suplemento"><div class="title-left">SUPLEMENTOS</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading][/doap_animate]');
echo '<div class="suplementos box">';
echo '<div class="supl-cat">';
$args = array( 'posts_per_page' => 1, 'offset'=> 0, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => '63770' );
$myposts = get_posts( $args );
foreach ( $myposts as $my_post )
{	
	setup_postdata( $my_post );
	$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($my_post->ID), 'responsive-150' ); 
	$feat_image = $feat_image_array[0];
	echo '<div class="supl-img">' . PHP_EOL . '<a href="http://noticias.laprensa.com.ni/suplemento/nosotras"><img src="' . $feat_image . '"></a>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
}
wp_reset_postdata();
$args = array( 'posts_per_page' => 4, 'offset'=> 1, 'orderby'=> 'post_date', 'order'=> 'DESC', 'post_status' => 'publish', 'category' => '25763' );
$myposts = get_posts( $args );
echo '<div class="supl-cat-title-box">';
echo '<div style="height:4px;"></div>';
foreach ( $myposts as $my_post )
{	
	setup_postdata( $my_post );
	$title = get_the_title($my_post->ID);
	$post_url = get_permalink($my_post->ID);
	echo '<div class="supl-titles"><a href="' . $post_url . '"> > '. $title . '</a></div>' . PHP_EOL;
}
wp_reset_postdata();
?>
</div>
</div>
<div class="supl-cat">
<?php
$args = array( 'posts_per_page' => 1, 'offset'=> 0, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => '63779' );
$myposts = get_posts( $args );
foreach ( $myposts as $my_post )
{	
	setup_postdata( $my_post );
	$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($my_post->ID), 'responsive-150' ); 
	$feat_image = $feat_image_array[0];
	echo '<div class="supl-img">' . PHP_EOL . '<a href="http://noticias.laprensa.com.ni/suplemento/aqui-entre-nos"><img src="' . $feat_image . '"></a>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
}
wp_reset_postdata();
$args = array( 'posts_per_page' => 4, 'offset'=> 1, 'orderby'=> 'post_date', 'order'=> 'DESC', 'post_status' => 'publish', 'category' => '924' );
$myposts = get_posts( $args );
echo '<div class="supl-cat-title-box">';
echo '<div style="height:4px;"></div>';
foreach ( $myposts as $my_post )
{	
	setup_postdata( $my_post );
	$title = get_the_title($my_post->ID);
	$post_url = get_permalink($my_post->ID);
	echo '<div class="supl-titles"><a href="' . $post_url . '"> > '. $title . '</a></div>' . PHP_EOL;
}
wp_reset_postdata();
?>
</div>
</div>
<div class="supl-clear"></div>
<div class="supl-cat">
<?php
$args = array( 'posts_per_page' => 1, 'offset'=> 0, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => '63778' );
$myposts = get_posts( $args );
foreach ( $myposts as $my_post )
{	
	setup_postdata( $my_post );
	$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($my_post->ID), 'responsive-150' ); 
	$feat_image = $feat_image_array[0];
	echo '<div class="supl-img">' . PHP_EOL . '<a href="http://noticias.laprensa.com.ni/suplemento/domingo"><img src="' . $feat_image . '"></a>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
}
wp_reset_postdata();
$args = array( 'posts_per_page' => 4, 'offset'=> 1, 'orderby'=> 'post_date', 'order'=> 'DESC', 'post_status' => 'publish', 'category' => '35632' );
$myposts = get_posts( $args );
echo '<div class="supl-cat-title-box">';
echo '<div style="height:4px;"></div>';
foreach ( $myposts as $my_post )
{	
	setup_postdata( $my_post );
	$title = get_the_title($my_post->ID);
	$post_url = get_permalink($my_post->ID);
	echo '<div class="supl-titles"><a href="' . $post_url . '"> > '. $title . '</a></div>' . PHP_EOL;
}
wp_reset_postdata();
?>
</div>
</div>
<div class="supl-cat">
<?php
$args = array( 'posts_per_page' => 1, 'offset'=> 0, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => '64505' );
$myposts = get_posts( $args );
foreach ( $myposts as $my_post )
{	
	setup_postdata( $my_post );
	$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($my_post->ID), 'responsive-150' ); 
	$feat_image = $feat_image_array[0];
	echo '<div class="supl-img">' . PHP_EOL . '<a href="http://noticias.laprensa.com.ni/suplemento/domingo"><img src="' . $feat_image . '"></a>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
}
wp_reset_postdata();
$args = array( 'posts_per_page' => 4, 'offset'=> 1, 'orderby'=> 'post_date', 'order'=> 'DESC', 'post_status' => 'publish', 'category' => '63968' );
$myposts = get_posts( $args );
echo '<div class="supl-cat-title-box">';
echo '<div style="height:4px;"></div>';
foreach ( $myposts as $my_post )
{	
	setup_postdata( $my_post );
	$title = get_the_title($my_post->ID);
	$post_url = get_permalink($my_post->ID);
	echo '<div class="supl-titles"><a href="' . $post_url . '"> > '. $title . '</a></div>' . PHP_EOL;
}
wp_reset_postdata();
?>
</div>
</div>
</div>
<div class="supl-clear"></div>

