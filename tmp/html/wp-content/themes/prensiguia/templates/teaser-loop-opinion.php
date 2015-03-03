<div style="width:100%;border:0px solid #ffffff;" class="su-posts su-posts-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>

<div id="su-post-<?php the_ID(); ?>" class="su-post op-post" style="width:33%;position:relative;float:left;border:1px solid #369;min-height:420px;">

<div style="width:90%;position:relative;float:left;margin-left:3px;margin-right:3px;">
<?php $thelink = get_the_permalink(); 
      $thetitle = get_the_title();
      $thetime = "<div style=color:#369;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:1px;background-color:#fff;position:relative;float:right;font-family:Arial;> ".get_the_date()." ".get_the_time('g:i a')."</div>";
      $thecleantitle = get_the_title();
      $theexcerpt = $thetime." <p>".$thetitle."</p>".htmlentities(strip_tags(get_the_excerpt()), ENT_QUOTES, 'UTF-8');
?>
<div id="post-sub-box" style="max-width:98%;">

<?php
$categories = get_the_category();
$separator = ' ';
$output = '';
if($categories){
	foreach($categories as $category) {
		$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
	}
//echo trim($output, $separator);
}
?>

<?php _e( ' ', 'su' ); ?> <?php //the_time( get_option( 'date_format' ) ); ?>  

</div>


</a></div>

<?php echo '<a href="'.get_the_permalink().'">'; ?>
<?php echo do_shortcode('[doap_spacer size=3]<div style="width:100%;background-color:#369;margin-top:0px;min-height:50px;color:#fff;border:2px solid #fff;margin:0px;top:-4px;left:-2px;position:relative;"><center><span style=position:relative;top:10px;font-weight:900;font-size:1.2em;>'. $thetitle .'</span></center></div>'); ?>
<?php echo '</a>'; ?>

<?php 
echo "<div style=padding-left:2px;padding-right:2px;max-height:230px;max-width:60%;display:block;margin:auto;overflow:hidden;>"; 

echo '<a href="'.get_the_permalink().'">';
//responsive_pro_featured_image();
the_post_thumbnail( array(300,300) );
echo '</a>';
echo "</div>"; ?>

<a href="<?php the_permalink(); ?>">
<div class="su-post-meta" style="font-size:1em;position:relative;float:left;margin:0px;padding-left:3px;padding-right:3px;">
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
        $theexcerpt = '<p style="font-size:1em;text-align:justify;">' . substr($theexcerpt, 0, $pos[$exp_pos]) . '</p>' . PHP_EOL;
	echo $theexcerpt;
        //echo get_the_term_list( $post->ID, 'post_tag', 'Etiquetas: ', ', ', '' );
        echo '</div>' . PHP_EOL;
?>
</div>

<div style="width:100%;height:10px;background-color:#369;position:absolute;bottom:0px;left:0px;margin:0px;padding:0px;"></div>
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
