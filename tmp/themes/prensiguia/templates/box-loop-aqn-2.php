<?php echo do_shortcode('[doap_spacer size="10"]'); ?>
<div style="width:100%;max-height:294px;max-width:350px;" class="su-posts su-posts-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>

<div id="su-post-<?php the_ID(); ?>" class="su-post" style="width:100%;position:relative;float:left;margin:0px;">

<div style="border:0px solid #000;margin-top:0px;width:381px;position:relative;float:left;margin-left:1px;margin-right:1px;">
<?php $thelink = get_the_permalink(); 
      $thetitle = get_the_title();
      $thetime = "<div style=color:#369;padding-left:3px;padding-right:3px;padding-top:1px;padding-bottom:1px;background-color:#fff;position:relative;float:right;font-family:Arial;> ".get_the_date()." ".get_the_time('g:i a')."</div>";
      $thecleantitle = get_the_title();
      $theexcerpt = $thetime." <p style=font-family:StagSansBook>".$thetitle."</p>".htmlentities(strip_tags(get_the_excerpt()), ENT_QUOTES, 'UTF-8');
?>
<div id="post-sub-box">
	<?php //echo do_shortcode('<h5>'. $thetitle .'</h5>'); ?>
        <div style="background-color:#eee;height:292px;width:192px;padding-top:0px;margin:0px;font-size:.8em;position:relative;float:left;">
	<?php    //responsive_pro_featured_image();
//		 $x = the_post_thumbnail( array(290,178) );  echo $x;


$img_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
$image = su_image_resize( $img_url, 192, 292 );
$feat_image = $image['url'];
//$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
//$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-300' );
$post_url = get_permalink($post->ID);
//$feat_image = $feat_image_array[0];
echo '<div style="border: 1px solid #ccc;height:292px;' . $max_width .'">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"style="height:292px;width:100%;left:2px;position:relative;"></a>' . PHP_EOL;
echo '</div>';



	?>
	</div>

	<?php //echo "<div style=padding-left:0px;padding-right:0px;height:290px;width:200px;border:1px solid #909090;>"; 
	//the_post_thumbnail( array(250,150) ); 
	//echo "</div>"; ?>

</div>


	


	<div class="nosotras-second-pink-box">
	<div style="margin:5px;">
	<?php    echo '<div style="font-size:1.2em;line-height:1.2em;font-weight:400;font-family:StagBook;">'. $thetitle .'</div>'; 
   //echo '<div class="destacados-excerpt" style="padding-left:4px;padding-right:4px;position:relative;top:-10px;margin:0px;width:195px;height:290px;">' . PHP_EOL;
	$theexcerpt = get_doap_excerpt(300,1,1);
/*
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
*/
        $theexcerpt = '<p style="margin-top:.5em;text-align:justify;font-size:1em;line-height:1.2em;font-family:StagBook;">' . $theexcerpt . '</p>' . PHP_EOL; 
?>

<?php
        echo $theexcerpt;
        //echo get_the_term_list( $post->ID, 'post_tag', 'Etiquetas: ', ', ', '' );
        echo '</div></div>' . PHP_EOL;
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
