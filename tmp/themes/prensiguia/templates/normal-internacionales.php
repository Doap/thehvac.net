<?php
responsive_entry_before(); 
echo '<div id="su-post-' . get_the_ID() . '" ' . $float_class . ' style="position:relative;max-' . $max_width . '">';
//echo '<div id="su-post-' . get_the_ID() . '" style="position:relative;">';
responsive_entry_top(); 
$theexcerpt = get_doap_excerpt(300,1,1);
$theexcerpt = '<div class="category-excerpt" style="padding:4px;text-align:justify;">' . $theexcerpt . '</div>' . PHP_EOL;
$thepermalink = get_the_permalink();
//echo do_shortcode('<a href="' . $thepermalink . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title()).'[/doap_heading][/doap_animate]</a>');
echo '<a href="' . $thepermalink . '" title="Haz clic aqui para leer el nota completo."><div class="su-heading su-heading-style-modern-1-blue su-heading-align-left fp-title-bar" style="font-size:20px;"><div class="su-heading-inner" style="display:inline;">' . ucfirst(get_the_title()) . '</div></div></a>';
if ($show_comments)
{
	if ($show_cat_in_comments)
	{
		echo addCatForComments($single_cat_title, $single_cat_slug) . writeComments('black', $post->ID);
	}
	else echo writeComments('black', $post->ID);
}
?>
<div class="post-entry">
<?php 
$gmt_timestamp = get_post_time('U', true); 
if ( has_post_thumbnail() && $show_img )
{
$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-300' );
$post_url = get_permalink($post->ID);
$feat_image = $feat_image_array[0];
echo '<div style="margin-top:10px;border: 1px solid #ccc;' . $max_width .'">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"style="width:100%"></a>' . PHP_EOL;
echo '</div>';
}
 ?> 
<?php
echo $theexcerpt;
					wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) );
					?>
				</div>
				<!-- end of .post-entry -->

				<?php //get_template_part( 'post-data' ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
