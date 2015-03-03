<div style="width:100%;border:0px solid #ffffff;" class="su-posts su-posts-list-loop">
<?php
// Posts are found
$postcount=0;
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$postcount++;
		$posts->the_post();
		global $post;
?>

<div  style="-webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px;border:1px solid #ccc; margin-right:5px;position:relative;float:left;min-height:236px;width:290px;margin-bottom:10px;margin-right:20px;" id="su-post-<?php the_ID(); ?>" <?php post_class(); ?> class="su-post">

<div style="width:90%;position:relative;float:left;margin-left:3px;margin-right:3px;">
<?php $thelink = get_the_permalink(); 
      $thetitle = get_the_title();
      $thetime = "<div style=color:#369;padding-left:3px;padding-right:3px;padding-top:1px;padding-bottom:1px;background-color:#fff;position:relative;float:right;font-family:Arial;> ".get_the_date()." ".get_the_time('g:i a')."</div>";
      $thecleantitle = get_the_title();
      
	//$theexcerpt = get_the_excerpt();
	//$theexcerpt = $thetime." <p>".$thetitle."</p>".htmlentities(strip_tags(get_the_excerpt()), ENT_QUOTES, 'UTF-8');
?>

<a href="<?php the_permalink(); ?>">
<?php echo "<div style=padding-left:0px;margin-left:5px;padding-right:0px;width:280px;>";
//responsive_pro_featured_image();
the_post_thumbnail( array(300,300) );
echo "</div>"; ?>
</a>



	<div id="post-sub-box" style="width:100%;padding-left:10px;padding-right:10px;">
		<a href="<?php the_permalink(); ?>">
			<?php echo do_shortcode(''. $thetitle .''); ?>
       				<div class="su-post-meta" style="font-size:.8em;position:relative;float:left;">
				</div>
		</a>
	</div>



<?php
        echo '<div class="destacados-excerpt" style="padding:0px;">' . PHP_EOL;
        remove_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
        $theexcerpt = get_the_excerpt();
        add_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
        $words = str_word_count($theexcerpt, 2);
        $pos = array_keys($words);
        if (!array_key_exists('20', $pos))
        {
                $exp_pos = count($pos) - 1;
        }
        else
        {
                $exp_pos = 20;
        }
        $theexcerpt = '<p style="">' . substr($theexcerpt, 0, $pos[$exp_pos]) . '...</p>' . PHP_EOL;
        
?>

<?php
//	echo $theexcerpt;
?>

<?php
        //echo get_the_term_list( $post->ID, 'post_tag', 'Etiquetas: ', ', ', '' );
        echo '</div>' . PHP_EOL;
?>

</div>
</div>
<?php if (($postcount % 3 == 0) || ($postcount == 6)) { echo '<div style=clear:both></div>'; } ?>
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
