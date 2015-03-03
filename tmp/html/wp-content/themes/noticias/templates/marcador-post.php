<?php
responsive_entry_before(); 
echo '<div id="su-post-' . $related_post . '" style="position:relative;">';
responsive_entry_top(); 
$theexcerpt = $post_relacionado->post_excerpt;
$words = str_word_count($theexcerpt, 2);
$dots = '...';
if ($words > $limit)
{
	$theexcerpt = implode(' ', array_slice(explode(' ', $theexcerpt), 0, 30)) . $dots;
}

$theexcerpt = '<div class="category-excerpt" style="padding:4px;text-align:justify;">' . $theexcerpt . '</div>' . PHP_EOL;
$thepermalink = get_the_permalink($related_post);
echo do_shortcode('<a href="' . $thepermalink . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title($related_post)).'[/doap_heading][/doap_animate]</a>');
echo addCatForComments('Deportes', 'deportes') . writeComments('black',$related_post);
?>
<div class="post-entry">
<?php 
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
