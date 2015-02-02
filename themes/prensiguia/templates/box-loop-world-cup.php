<div style="width:100%;border:0px solid #ffffff;" class="su-posts su-posts-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
    while ( $posts->have_posts() ) {
        $posts->the_post();
        global $post;
?>
<div id="su-post-<?php the_ID(); ?>" class="su-post" style="width:100%;position:relative;float:left;">
<div style="width:100%;position:relative;float:left">
<?php $thelink = get_the_permalink(); 
$thetitle = get_the_title();
$thecleantitle = get_the_title();
$theexcerpt = "<p>".$thetitle."</p>".htmlentities(strip_tags(get_the_excerpt()), ENT_QUOTES, 'UTF-8');
?>
    <div id="post-sub-box">
    <h5><a href="<?php the_permalink(); ?>"> <?php echo $thetitle ; ?></a> </h5>

    <div style=padding-left:0px;padding-right:0px;">
    <?php the_post_thumbnail( array(240,160) ); ?>
    </div>

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
    $exp_pos = 50;
}
$theexcerpt = '<p>' . substr($theexcerpt, 0, $pos[$exp_pos]) . '</p>' . PHP_EOL;
echo $theexcerpt;
//echo get_the_term_list( $post->ID, 'post_tag', 'Etiquetas: ', ', ', '' );
echo PHP_EOL;
?>
</div>
</div>
</div>
<?php
    }
?>
</div>
<?php
}
// Posts not found
else {
?>
<div><?php _e( 'Posts not found', 'su' ) ?></div>
<?php
}
?>
</div>
