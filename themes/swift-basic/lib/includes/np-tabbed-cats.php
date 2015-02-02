<div id="np-tabs"
	class="shortcode-tabs clearfix default ui-tabs ui-widget ui-widget-content ui-corner-all">
	<ul
		class="tab_titles ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
		<?php
		GLOBAL $swift_options;

		$cat_list = $swift_options['np_tabbed_cats'];
		foreach($cat_list as $category):
		?>
		<li
			class="nav-tab ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a
			href="#tab-<?php $category?>"><?php echo get_cat_name($category) ?>
		</a></li>
		<?php endforeach;?>
	</ul>
	<?php
	$count = 0;
	foreach($cat_list as $category):


	?>
	<div id="tabs-<?php echo $category?>"
		class="tab ui-tabs-panel ui-widget-content ui-corner-bottom">
		<?php
		$r = new WP_Query(array('posts_per_page' => 4, 'cat' =>$category, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'order' => 'DESC'));
		if ($r->have_posts()) :

		?>
		<?php  while ($r->have_posts()) : $r->the_post();
		if($count%4 == 0)
			$class = '';
		elseif($count%4 == 3)
		$class = '';
		else
			$class = '';
		?>
		<div class="fourcol-one">
			<div class="div-content <?php echo $class;?>">
				<?php  the_post_thumbnail( array(213,131), array('class' => 'aligncenter thumb' ));?>
				<a href="<?php the_permalink() ?>"
					title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?>
				</a> <br /> <span class="meta"><a
					href="<?php echo esc_url( get_permalink() )?>"
					title="<?php echo esc_attr( get_the_time() )?>" rel="bookmark"><time
							class="entry-date"
							datetime="<?php echo esc_attr( get_the_date( 'c' ) )?>"
							pubdate="pubdate">
							<?php echo esc_html( get_the_date() )?>
						</time>
				</a>
				</span>
				<div class="clear"></div>
			</div>
		</div>
		<?php $count++;endwhile; ?>
		<div class="clear"></div>

		<?php endif;?>
		<?php wp_reset_query(); ?>

	</div>
	<?php endforeach;?>
	<div class="fix"></div>
	<!--/.fix-->

</div>
<!--/.tabs-->
