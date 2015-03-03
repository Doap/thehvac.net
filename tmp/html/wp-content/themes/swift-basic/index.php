<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Swift
 * @subpackage Template
 */
get_header();
GLOBAL $swift_options,$swift_design_options,$swift_slider_posts_ids,$swift_post_count;
if( $swift_design_options['blog_or_mag'] == 'blog' ){
	$layout = 'display/blog';
	$content_id = 'blog-wrapper';
}elseif($swift_design_options['blog_or_mag'] == 'list'){
	$layout = 'display/list';
	$content_id = 'blog-wrapper';
}
else{
	$layout = 'display/mag';
	$content_id = 'mas-wrapper';
}
if( is_home() && $paged < 2 && isset( $swift_options['slider_enable'] ) && $swift_options['slider_enable'] && $swift_options['slider_style'] == 'full-width' )
	get_template_part( 'lib/includes/full-width-slider');

$swift_post_count = 0;
?>
<div id="content" role="main">
	<div class="div-content">
		<?php swift_before_content() ?>

		<?php
		if(  is_home() && $paged < 2 && isset( $swift_options['slider_enable'] ) && $swift_options['slider_enable'] && $swift_options['slider_style'] == 'content-width' ){

		get_template_part( 'lib/includes/content-width-slider');

		if( $swift_design_options['blog_or_mag'] == 'magazine-full' ){
?>
		<div id="about-us" class="alignleft">
			<div class="div-content">
				<aside class="widget widget_text">
					<div class="textwidget">
						<?php echo stripslashes( $swift_options['about_us'] );?>
					</div>
				</aside>
			</div>
		</div>
		<?php 	}
	}
	?>
	</div>
	<div class="clear"></div>

	<div id="<?php echo $content_id?>" class="div-content clearfix">
		<?php
		if(isset($swift_slider_posts_ids) && $swift_options['skip_posts'] )
			query_posts( array( 'post__not_in' => $swift_slider_posts_ids, 'paged' => $paged ) );

		if ( have_posts() ) :
		if($swift_design_options['blog_or_mag']=='list')
			echo '<ul class="post-listing">';

		/* Start the Loop */
		while ( have_posts() ) : the_post();
		get_template_part( $layout, 'blog-'.get_post_format() );
		endwhile;

		if($swift_design_options['blog_or_mag']=='list'):
		echo '</ul>';
		endif;

		else:
		?>

		<article id="post-0" class="post no-results not-found clearfix">
			<header class="entry-header">
				<h1 class="entry-title">
					<?php _e( 'Nothing Found', 'swift' ); ?>
				</h1>
			</header>
			<!-- .entry-header -->

			<div class="entry-content">
				<p>
					<?php _e( 'Apologies, but there are no posts in the current context. Perhaps searching will help find a related post.', 'swift' ); ?>
				</p>
				<?php get_search_form(); ?>
			</div>
			<!-- .entry-content -->
		</article>
		<!-- #post-0 -->
		<div class="clear"></div>
		<?php endif; ?>

		<?php swift_after_content() ?>
		<div class="clear"></div>
	</div>
	<!-- /.div-content -->

	<div class="div-content">
		<?php	if(function_exists('swift_pagenavi')) swift_pagenavi(); ?>
	</div>
</div>
<!-- #content -->
<?php
if( $swift_design_options['blog_or_mag'] == 'magazine-full' )
	echo '</div>';
else
get_sidebar();

get_footer();
?>