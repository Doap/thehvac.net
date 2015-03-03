<?php date_default_timezone_set('America/Managua'); //echo do_shortcode('<div id="tiendatitle">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="25" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/tienda">Internacionales</a>[/doap_heading][/doap_animate]</div> '); ?>

<div style="width:90%;height:490px;border:0px solid #ffffff;" class="su-posts su-posts-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>

<div id="su-post-<?php the_ID(); ?>" class="su-post">

<div style="width:90%;position:relative;float:left;">
<?php $thelink = get_the_permalink(); 
      $thetitle = get_the_title();
      $thetime = "<div style=color:#369;padding-left:3px;padding-right:3px;padding-top:1px;padding-bottom:1px;background-color:#fff;position:relative;font-family:Arial;> ".get_the_date()." ".get_the_time('g:i a')."</div>";
      $thecleantitle = get_the_title();
      $theexcerpt = $thetime." <h3>".$thetitle."</h3>".htmlentities(strip_tags(get_the_excerpt()), ENT_QUOTES, 'UTF-8');
?>
<div style="width:100%;padding-left:10px;">
<a href="<?php the_permalink(); ?>">
	<?php echo "<h5>".$thetitle."</h5>";  ?>
</a></div>


<?php echo "<div style=position:relative;left:10px;width:100%; width:100%;margin-left:5px;padding-right:0px;line-height:.8em;>";
responsive_pro_featured_image();
//the_post_thumbnail( array(300,300) );
//the_post_thumbnail( array(300,300) );
echo "</div>"; ?>

<?php
        echo '<div class="destacados-excerpt" style="width:280px;padding:10px;text-align: justify;">' . PHP_EOL;
        remove_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
        $theexcerpt = get_the_excerpt();
        add_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
        $words = str_word_count($theexcerpt, 2);
        $pos = array_keys($words);
        if (!array_key_exists('50', $pos))
        {
                $exp_pos = count($pos) - 1;
        }
        else
        {
                $exp_pos = 50;
        }
        $theexcerpt = '<p>' . substr($theexcerpt, 0, $pos[$exp_pos]) . '</p>' . PHP_EOL;
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
