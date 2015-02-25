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
global $swift_count,$swift_options,$swift_design_options,$swift_post_count;
if( $swift_design_options['blog_or_mag_archives'] == 'blog' ){
	$layout = 'display/blog';
	$content_id = 'blog-wrapper';
}elseif ( $swift_design_options['blog_or_mag_archives'] == 'list'){
	$layout = 'display/list';
	$content_id = 'blog-wrapper';
}
else{
	$layout = 'display/mag';
	$content_id = 'mas-wrapper';
}

$swift_post_count = 0;
?>
<div id="content" role="main">
	<div class="div-content clearfix">

		<?php swift_before_content() ?>
		<div id="author-info" class="clearfix" style="margin-top: 20px">
			<div class="archive-title">
				Archives for&nbsp;
				<h1>
					<?php single_cat_title(); ?>
				</h1>
			</div>
			<?php echo category_description()?>
		</div>
	</div>
	<div id="<?php echo $content_id?>" class="div-content clearfix">

		<?php if ( have_posts() ) : ?>
		<?php if($swift_design_options['blog_or_mag_archives']=='list')
		echo '<ul class="post-listing">'?>
		<?php /* Start the Loop */ ?>
		<?php
		while ( have_posts() ) : the_post();
		get_template_part( $layout, get_post_format() );
		endwhile;
		?>
		<?php if($swift_design_options['blog_or_mag_archives']=='list') echo '</ul>'?>

		<?php else: ?>

		<article id="post-0" class="post no-results not-found">
			<header class="entry-header">
				<h1 class="entry-title">
					<?php _e( 'Nothing Found', 'swift' ); ?>
				</h1>
			</header>
			<!-- .entry-header -->

			<div class="entry-content">
				<p>
					<?php _e( 'Apologies, but no results were found for the requested category. Perhaps searching will help find a related post.', 'swift' ); ?>
				</p>
				<?php get_search_form(); ?>
			</div>
			<!-- .entry-content -->
		</article>
		<!-- #post-0 -->

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
if( $swift_design_options['blog_or_mag_archives'] == 'magazine-full' )
echo '</div>';
else
get_sidebar();
?>
<?php get_footer(); ?>