<?php date_default_timezone_set('America/Managua'); //echo do_shortcode('<div id="tiendatitle">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="25" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/tienda">Internacionales</a>[/doap_heading][/doap_animate]</div> '); ?>

<div class="opinion-posts">
<?php
//<div style="width:270px;height:490px;border:0px solid #ffffff;" class="su-posts su-posts-list-loop">
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>

<div id="su-post-<?php the_ID(); ?>" class="su-post">

<div style="width:270px;position:relative;float:left;">
<?php $thelink = get_the_permalink(); 
      $thetitle = get_the_title();
      $thetime = "<div style=color:#333;padding-left:3px;padding-right:3px;padding-top:1px;padding-bottom:1px;background-color:#fff;position:relative;float:right;font-family:Arial;> ".get_the_date()." ".get_the_time('g:i a')."</div>";
      $thecleantitle = get_the_title();
      $theexcerpt = $thetime." <h3>".$thetitle."</h3>".htmlentities(strip_tags(get_the_excerpt()), ENT_QUOTES, 'UTF-8');
?>
<div style="width:100%;margin-right:10px;">
<a href="<?php the_permalink(); ?>" style="font-family:Arial;font-weight:700;font-size:18px;color:#333;">
	<?php echo $thetitle;  ?>
</a></div>


<?php echo "<div style=position:relative;align:auto 0 0; width:270px;float:left;margin-left:5px;margin-right:10px;line-height:.8em;border:1px solid #333;>";
//responsive_pro_featured_image();
//the_post_thumbnail( array(300,300) );
the_post_thumbnail( array(300,300) );
echo "</div>"; ?>

<?php
        echo '<div class="opinion-excerpt" style="font-family:Arial;font-size:.9em;color:#333;width:270px;margin-right:10px;text-align: justify;">' . PHP_EOL;
        //remove_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
        //add_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
        //$theexcerpt = '<p>' . substr($theexcerpt, 0, $pos[$exp_pos]) . '</p>' . PHP_EOL;
	$theexcerpt = get_doap_excerpt(240,1,1);
        echo $theexcerpt;
       //echo get_the_term_list( $post->ID, 'post_tag', 'Etiquetas: ', ', ', '' );
        echo '</div>' . PHP_EOL;
?>

</div>

</div>
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
</div>
