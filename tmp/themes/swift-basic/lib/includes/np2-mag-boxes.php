<?php
GLOBAL $swift_options;
$cat_list = $swift_options['np2_mag_cats'];
$count = 0;
GLOBAL $swift_exclude_post_ids;
foreach($cat_list as $category){

	$post_count = 0;

	?>
<div class="threecol-one">
	<div class="div-content np2mag">
		<p class="section-title">
			<a href="<?php echo get_category_link($category )?>"
				title="<?php printf( __( 'View more posts from %s', 'swift' ), get_cat_name($category) ); ?>"><?php echo get_cat_name($category) ?>
			</a>
		</p>
		<div class="clear"></div>
		<?php
		$r = new WP_Query(array('posts_per_page' => 6,'cat' =>$category, 'no_found_rows' => true,'post__not_in'=>$swift_exclude_post_ids, 'post_status' => 'publish', 'ignore_sticky_posts' => true,));
		if ($r->have_posts()) :
		while ($r->have_posts()) : $r->the_post();
		$swift_exclude_post_ids[] = get_the_ID();
		if( $post_count++ == 0):
		?>
		<div id="post-<?php the_ID(); ?>"
		<?php post_class('np-blog-posts clearfix'); ?>>
			<?php
			the_post_thumbnail(array(284,100),array('class'	=> 'np-blog-thumb alignleft',
			'title'	=> trim(strip_tags( get_the_title()))
			)
			);
			?>
			<h3 class="post-title">
				<a href="<?php the_permalink() ?>" rel="bookmark"
					title="<?php printf( esc_attr__( 'Permalink to %s', 'swift' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title();?>
				</a>
			</h3>
			<?php 		the_excerpt() ?>
		</div>

		<div class="clear"></div>
		<ul>
			<?php     	 continue;	endif;?>
			<li class="clearfix"><?php
			the_post_thumbnail(array(24,24),array('class'	=> 'np-blog-thumb alignleft',
			'title'	=> trim(strip_tags( get_the_title()))
			)
			);
			?><a href="<?php the_permalink() ?>" rel="bookmark"
				title="<?php printf( esc_attr__( 'Permalink to %s', 'swift' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title();?>
			</a></li>
			<?php endwhile;endif;?>
			<?php wp_reset_query(); ?>
		</ul>
	</div>
</div>
<?php $count++;
}?>