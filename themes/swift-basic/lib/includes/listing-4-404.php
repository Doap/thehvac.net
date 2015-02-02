
<div class="fourcol-one">
	<div class="div-content">
		<big><em><?php _e('Categories','swift')?> </em> </big>
		<fieldset>
			<?php wp_dropdown_categories('show_option_none='. __( 'Select category' , 'swift' ) ); ?>
			<script type="text/javascript"><!--
   					var dropdown = document.getElementById("cat");
					function onCatChange() {
						if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
							location.href = "<?php echo home_url();?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
						}
   					}
   					dropdown.onchange = onCatChange;
					-->
				</script>
		</fieldset>
	</div>
</div>

<div class="fourcol-one">
	<div class="div-content">
		<big><em><?php _e('Monthly archives','swift')?> </em> </big>
		<fieldset>
			<select name=\
				"archive-dropdown\" onChange='document.location.href=this.options[this.selectedIndex].value;'>
				<option value=\"\">
					<?php echo esc_attr(__('Select Month','swift')); ?>
				</option>
				<?php wp_get_archives('type=monthly&format=option&show_post_count=1'); ?>
			</select>
		</fieldset>
	</div>
</div>

<div class="fourcol-two">
	<div class="div-content">
		<?php get_search_form(); ?>
	</div>
</div>

<div class="clear"></div>
<br />
<div class="threecol-one">
	<div class="div-content">
		<big><em><?php _e('Popular posts','swift')?> </em> </big><br /> <br />
		<?php
		$r = new WP_Query(array('posts_per_page' =>12, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'orderby' => 'comment_count', 'order' => 'DESC'));
		if ($r->have_posts()) :
		?>
		<ol>
			<?php  while ($r->have_posts()) : $r->the_post(); ?>
			<li class="clearfix"><?php  the_post_thumbnail( array(36,36), array('class' => 'alignleft thumb' ));?>

				<a href="<?php the_permalink() ?>"
				title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?>
			</a>
				<p class="meta date">
					<a href="<?php echo esc_url( get_permalink() )?>"
						title="<?php echo esc_attr( get_the_time() )?>" rel="bookmark"><time
							class="entry-date"
							datetime="<?php echo esc_attr( get_the_date( 'c' ) )?>"
							pubdate="pubdate">
							<?php echo esc_html( get_the_date() )?>
						</time> </a>
				</p>
			</li>
			<?php endwhile; ?>
		</ol>
		<?php 	endif;?>
		<?php wp_reset_query(); ?>
	</div>
</div>

<div class="threecol-one">
	<div class="div-content">
		<big><em><?php _e('Random posts','swift')?> </em> </big><br /> <br />

		<?php
		$r = new WP_Query(array('posts_per_page' => 12, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'orderby' => 'rand'));
		if ($r->have_posts()) :
		?>
		<ol>
			<?php  while ($r->have_posts()) : $r->the_post(); ?>
			<li class="clearfix"><?php  the_post_thumbnail( array(36,36), array('class' => 'alignleft thumb' ));?>

				<a href="<?php the_permalink() ?>"
				title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?>
			</a>
				<p class="meta date">
					<a href="<?php echo esc_url( get_permalink() )?>"
						title="<?php echo esc_attr( get_the_time() )?>" rel="bookmark"><time
							class="entry-date"
							datetime="<?php echo esc_attr( get_the_date( 'c' ) )?>"
							pubdate="pubdate">
							<?php echo esc_html( get_the_date() )?>
						</time> </a>
				</p>
			</li>
			<?php endwhile; ?>
		</ol>
		<?php 	endif;?>
		<?php wp_reset_query(); ?>
	</div>
</div>

<div class="threecol-one">
	<div class="div-content">
		<big><em><?php _e('Recent posts','swift')?> </em> </big><br /> <br />

		<ol>
			<?php query_posts('showposts=12'); ?>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<li class="clearfix"><?php  the_post_thumbnail( array(36,36), array('class' => 'alignleft thumb' ));?>

				<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?>
			</a>
				<p class="meta date">
					<a href="<?php echo esc_url( get_permalink() )?>"
						title="<?php echo esc_attr( get_the_time() )?>" rel="bookmark"><time
							class="entry-date"
							datetime="<?php echo esc_attr( get_the_date( 'c' ) )?>"
							pubdate="pubdate">
							<?php echo esc_html( get_the_date() )?>
						</time> </a>
				</p>
			</li>

			<?php endwhile; endif; ?>
		</ol>
	</div>
</div>

<div class="clear"></div>

<br />
<big><em><?php _e('Tag cloud','swift')?> </em> </big>
<br />
<br />
<div class="widget">
	<?php wp_tag_cloud('smallest=10&largest=32'); ?>
</div>
