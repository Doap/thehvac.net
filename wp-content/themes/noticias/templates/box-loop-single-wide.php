<div style="width:100%;min-height:150px;border-bottom:r3r21px solid #000;" class="su-posts su-posts-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>

<div id="su-post-<?php the_ID(); ?>" class="su-post">

<div style="width:100%;position:relative;float:left;max-height:100px;">
<?php $thelink = get_the_permalink(); 
      $thetitle = get_the_title();
      $thetime = "<div style=color:#369;padding-left:3px;padding-right:3px;padding-top:1px;padding-bottom:1px;background-color:#fff;position:relative;float:right;font-family:Arial;> ".get_the_date()." ".get_the_time('g:i a')."</div>";
      $thecleantitle = get_the_title();
      $theexcerpt = $thetime." <p>".$thetitle."</p>".htmlentities(strip_tags(get_the_excerpt()), ENT_QUOTES, 'UTF-8');
?>
<div style="max-width:100%;">
<a href="<?php the_permalink(); ?>">
	<?php echo do_shortcode('<h4>'. $thetitle .'</h4>'); ?>
        <div class="su-post-meta" style="font-size:.8em;position:relative;float:left;">

<?php
$categories = get_the_category();
$separator = ' ';
$output = '';
if($categories){
	foreach($categories as $category) {
		$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
	}
echo trim($output, $separator);
}
?>

<?php _e( ' ', 'su' ); ?> <?php //the_time( get_option( 'date_format' ) ); ?>  <a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( ' | <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios', 'su' ), __( '| <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario', 'su' ), __( '| <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubbles1.png" style="max-width:100%;border:0px solid #fff;" alt=""> % Comentarios', 'su' ) ); ?></a></div>


</a></div>


<?php
        echo '<div class="destacados-excerpt" style="padding:4px;">' . PHP_EOL;
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
