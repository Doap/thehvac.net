<?php /*
Swift template for YARPP
Author: Satish Gandham
*/
GLOBAL $swift_options;
?>

<?php if ($related_query->have_posts()):?>
<div id="related-posts" class="clearfix">
	<?php if( isset($swift_options['yarpp_title']) && $swift_options['yarpp_title'] != '' ){?>
	<p class="h4">
		<?php echo $swift_options['yarpp_title'] ?>
	</p>
	<?php } ?>
	<ol>
		<?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
		<li class="clearfix"><?php the_post_thumbnail( array(48,48), array( 'class' => 'rp-thumb') ); ?><a
			href="<?php the_permalink() ?>" rel="bookmark" class=""><?php the_title(); ?>
		</a> <br /> <?php swift_posted_on(); ?>
		</li>
		<?php endwhile; ?>
	</ol>
</div>
<?php else: ?>
<p>
	<?php _e( 'No related posts.', 'swift' ); ?>
</p>
<?php endif; ?>
