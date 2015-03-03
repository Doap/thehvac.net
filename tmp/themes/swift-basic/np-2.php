<?php
/*
 Template Name: News Paper 2
*/

get_header();
GLOBAL $swift_options?>
<div id="content" class="full-width" role="main">
	<div id="np2" class="div-content">
		<!-- This is our play ground -->
		<div class="sixcol-one">
			<div class="div-content alpha">
				<?php dynamic_sidebar('np2-sb') ?>
			</div>
		</div>
		<div class="sixcol-five">
			<div class="div-content omega">
				<div class="fivecol-three">
					<div class="div-content alpha">
						<?php 		get_template_part( 'lib/includes/np2-slider');?>
					</div>
				</div>
				<!-- /fivecol-three -->

				<div class="fivecol-two">
					<div class="div-content omega">
						<?php

						if( $posts = swift_np2_which($swift_options['np2_mosaic_slider_adjacent'],TRUE,9,array(115,115))){
    	swift_posts_mosaic($posts);
    }
    ?>
					</div>
				</div>
				<!-- /fivecol-two -->

				<div class="clear"></div>

				<div class="np2-ad clearfix">
					<?php
					if(isset($swift_options['np2_below_slider_ad_enable']) && $swift_options['np2_below_slider_ad_enable'] && $swift_options['np2_below_slider_ad'] != '')
						echo stripslashes($swift_options['np2_below_slider_ad'] )
						?>
				</div>

				<div class="threecol-one">
					<div class="div-content alpha">
						<p class="section-title">
							<?php _e('Recent comments','swift') ?>
						</p>
						<ul class="recent-comments">
							<?php
							global $wpdb;
							$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT 8");
							//$comments = get_comments();
							if ( $comments ) : foreach ( (array) $comments as $comment) :
							$author=wp_kses($comment->comment_author,'','');
							$content=wp_kses($comment->comment_content,'','');
							echo  '<li class="clearfix">'.get_avatar($comment,$size = '32') . sprintf( _x( '%1$s on %2$s', 'author ON title', 'swift' ), $author, '<a href="'. get_comment_link($comment->comment_ID) . '"  title="'.$content.'">' . get_the_title($comment->comment_post_ID) . '</a>' ) . '<br />
				   <span class="meta"><time class="entry-date" datetime="'.esc_attr( get_comment_date() ).'" >'.esc_html( get_comment_date() ).'</time></span></li>';
			endforeach; endif;?>
						</ul>
					</div>
				</div>
				<!-- /threecol-one -->

				<div class="threecol-two">
					<div class="div-content omega">
						<p class="section-title">
							<?php _e('Recent posts','swift') ?>
						</p>
						<ul class="post-listing">
							<?php
							$args = array('posts_per_page' => 4, 'no_found_rows' => true, 'ignore_sticky_posts' => true,'post_status' => 'publish');

							$r = new WP_Query($args);
							if ($r->have_posts()) :while ($r->have_posts()) : $r->the_post();
							?>
							<li><?php  the_post_thumbnail( array(100, 100), array('class' => 'alignleft thumb np-recent' ));?>
								<h4 class="post-title">
									<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?>
									</a>
								</h4> <?php the_excerpt() ?>
								<div class="clear"></div>
							</li>
							<?php endwhile;endif;?>
						</ul>
					</div>
				</div>
				<!-- /threecol-two -->

				<div class="clear"></div>
				<?php
				if( $posts = swift_np2_which($swift_options['np2_fs_1'],TRUE,10,array(89,89))){
    	swift_posts_mosaic($posts);
    }
    ?>
				<div class="clear"></div>

				<div class="np2-ad clearfix">
					<?php
					if(isset($swift_options['np2_above_fs2_ad_enable']) && $swift_options['np2_above_fs2_ad_enable'] && $swift_options['np2_above_fs2_ad'] != '')
						echo stripslashes($swift_options['np2_above_fs2_ad'] )
						?>
				</div>
				<div>

					<div style="margin: 0 -10px;">
						<?php 		get_template_part( 'lib/includes/np2-mag-boxes');?>
					</div>

				</div>
			</div>
			<!-- sixcol-five -->
			<!-- Play ends here -->
		</div>
		<!-- #content -->
	</div>
	<!-- #primary -->


</div>
<!-- left -->
</div>
<!-- main -->
<?php //get_sidebar(); ?>
<?php get_footer(); ?>