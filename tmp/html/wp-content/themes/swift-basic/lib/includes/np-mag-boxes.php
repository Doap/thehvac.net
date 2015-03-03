<?php
GLOBAL $swift_options;
$cat_list = $swift_options['np_mag_cats'];
$count = 0;
foreach($cat_list as $category){

	$post_count = 0;
	if( $count % 2 == 0 )
		$class = 'alpha';
	else
		$class = 'omega';
	?>
<div class="twocol-one np-mags">
	<div class="div-content <?php echo $class ?>">
		<p class="np-section-title">
			<a href="<?php echo get_category_link($category )?>"
				title="<?php printf( __( 'View more posts from %s', 'swift' ), get_cat_name($category) ); ?>"><?php echo get_cat_name($category) ?>
			</a>
		</p>
		<div class="clear"></div>
		<?php
		$r = new WP_Query(array('posts_per_page' => 4,'cat' =>$category, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true,));
		if ($r->have_posts()) :
		while ($r->have_posts()) : $r->the_post();

		if( $post_count++ == 0):
		?>
		<div id="post-<?php the_ID(); ?>"
		<?php post_class('np-blog-posts clearfix'); ?>>
			<?php
			the_post_thumbnail(array(100,100),array('class'	=> 'np-blog-thumb alignleft',
			'title'	=> trim(strip_tags( get_the_title()))
			)
			);
			?>
			<h3 class="post-title">
				<a href="<?php the_permalink() ?>" rel="bookmark"
					title="<?php printf( esc_attr__( 'Permalink to %s', 'swift' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title();?>
				</a>
			</h3>
			<?php
					echo substr(get_the_excerpt(),0,180); ?>
			<a href="<?php the_permalink() ?>" class="read-more btn small"><?php _e( 'Full Story &raquo;', 'swift' ); ?>
			</a>
		</div>

		<div class="clear"></div>
		<ul>
			<?php     	 continue;	endif;?>
			<li><strong><a href="<?php the_permalink() ?>" rel="bookmark"
					title="<?php printf( esc_attr__( 'Permalink to %s', 'swift' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title();?>
				</a> </strong></li>
			<?php endwhile;endif;?>
			<?php wp_reset_query(); ?>
		</ul>
	</div>
</div>
<?php $count++;}?>