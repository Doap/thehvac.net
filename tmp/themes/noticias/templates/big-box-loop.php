<?php date_default_timezone_set('America/Managua'); //echo do_shortcode('<div id="tiendatitle">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="25" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/tienda">Internacionales</a>[/doap_heading][/doap_animate]</div> '); ?>

<div style="width:100%;height:440px;border:1px solid #f8c111;" class="su-posts su-posts-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>

<div style="width:48%;position:relative;float:left;margin:2px;border:1px solid #909090;height:430px;" id="su-post-<?php the_ID(); ?>" class="su-post">

<div style="width:100%;position:relative;float:left;border:1px solid #606060;margin:0px;height:425px;">
<div style="position:relative;float:right;font-size:.8em;font-family:Arial;padding-top:1px;padding-right:5px;">(<a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( '0 <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt="">', 'su' ), __( '1 <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt="">', 'su' ), __( '% <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-2.gif" style="max-width:100%;border:0px solid #fff;" alt="">', 'su' ) ); ?></a>)</div>
<?php $thelink = get_the_permalink(); 
      $thetitle = get_the_title();
      $thetime = "<div style=color:#369;padding-left:3px;padding-right:3px;padding-top:1px;padding-bottom:1px;background-color:#fff;position:relative;float:right;font-family:Arial;> ".get_the_date()." ".get_the_time('g:i a')."</div>";
      $thecleantitle = get_the_title();
      $theexcerpt = $thetime." <h4>".$thetitle."</h4>".htmlentities(strip_tags(get_the_excerpt()), ENT_QUOTES, 'UTF-8');
?>
<div style="max-width:90%;min-height:40px;font-size:1.3em;">
<a href="<?php the_permalink(); ?>">
	<?php echo do_shortcode('[doap_tooltip style="tipsy" position="north" shadow="yes" rounded="yes" size="5" content="'. $theexcerpt .'" class="todays-news"]<div style=size:1.5em;padding-left:2px;padding-top:2px;>'. $thetitle .'</div>[/doap_tooltip]'); ?>
</a></div>


<?php echo "<div style=width:100%;max-height:280px;float:left;padding-left:2px;padding-right:2px;>";
//responsive_pro_featured_image();
the_post_thumbnail( array(300,300) );
echo "</div>"; ?>

<?php
        echo '<div class="destacados-excerpt" style="padding:4px;">' . PHP_EOL;
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
        echo get_the_term_list( $post->ID, 'post_tag', 'Etiquetas: ', ', ', '' );
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
