<?php date_default_timezone_set('America/Managua'); //echo do_shortcode('<div id="tiendatitle">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="25" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/tienda">Internacionales</a>[/doap_heading][/doap_animate]</div> '); ?>

<?php
//<div style="width:270px;height:490px;border:0px solid #ffffff;" class="su-posts su-posts-list-loop">
// Posts are found
if( $the_query->have_posts() )
{
	while ( $the_query->have_posts() )
	{
        	$the_query->the_post();

		$title = get_doap_limit_chars(the_title_attribute('echo=0'),43,1);
	        //$thetitle = get_the_title();
		$post_url = get_permalink($post->ID);
$lf_rt_borders = ($middle_post == 1) ? 'border-left: 2px solid #fff;' : '';
?>
<div id="su-post-<?php the_ID(); ?>" class="su-post cat-op">
<div class="cat-op-title" style="width:100%;background-color:#006699;min-height:50px;text-align:center;<?php echo $lf_rt_borders; ?>margin-right:10px;">
<a href="<?php echo $post_url; ?>" style="font-family:StagBook;color:#fff;"><?php echo $title; ?></a></div>
<div style="width:100%;border-right:1px solid #ccc;border-left: 1px solid #ccc;">
<div class="cat-op-story-inner" style="margin:0 auto;">
<?php //$thelink = get_the_permalink(); 
//      $thetime = "<div style=color:#333;padding-left:3px;padding-right:3px;padding-top:1px;padding-bottom:1px;background-color:#fff;position:relative;float:right;font-family:Arial;> ".get_the_date()." ".get_the_time('g:i a')."</div>";
//      $thecleantitle = get_the_title();
//      $theexcerpt = $thetime." <h3>".$thetitle."</h3>".htmlentities(strip_tags(get_the_excerpt()), ENT_QUOTES, 'UTF-8');
?>
<?php echo "<div style=position:relative;padding:10px 0;width:270px;float:left;margin-left:5px;margin-right:10px;line-height:.8em;border:1px solid #333;>";
//responsive_pro_featured_image();
//the_post_thumbnail( array(300,300) );
if ( has_post_thumbnail() ) {
	$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' );
	$feat_image = $feat_image_array[0];
	echo '<a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
}
else
{
	echo '<a href="' . $post_url . '"><div style="width:240px;height:160px;"></div></a>';
}
//the_post_thumbnail( array(300,300) );
echo "</div>"; ?>

<?php
        echo '<div class="opinion-excerpt" style="font-family:Arial;font-size:.9em;color:#333;margin-right:10px;text-align: justify;">' . PHP_EOL;
	$theexcerpt = get_doap_excerpt(240,1,1);
        echo $theexcerpt;
        echo '</div>' . PHP_EOL;
?>

</div>
<div id="cat-op-bottom"></div>
</div>
</div>
<div class="mobile-clear"></div>
<div class="clear-540"></div>
<div class="clear-767"></div>
<?php
	}
}
// Posts not found
else {
?>
<div><?php _e( 'Posts not found', 'su' ) ?></div>
<?php
}
?>
