<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Archive Template
 *
 *
 * @file           archive.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.1
 * @filesource     wp-content/themes/responsive/archive.php
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28archive.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>


<script type='text/javascript'>
googletag.cmd.push(function() {
    
/* departamentales slots */
googletag.defineSlot('/11648707/Departamentales-Left-160x600px', [160, 600], 'div-gpt-ad-1403214408507-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Departamentales-Right-160x600px', [160, 600], 'div-gpt-ad-1403214408507-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Departamentales-Top-728x90px', [728, 90], 'div-gpt-ad-1403214408507-6').addService(googletag.pubads());
googletag.defineSlot('/11648707/Departamentales-Top-270x90', [270, 90], 'div-gpt-ad-1403214408507-4').addService(googletag.pubads());
googletag.defineSlot('/11648707/Departamentales-Top-300x250px', [300, 250], 'div-gpt-ad-1403214408507-5').addService(googletag.pubads());
googletag.defineSlot('/11648707/Departamentales-Sidebar-300x250px', [300, 250], 'div-gpt-ad-1403214408507-3').addService(googletag.pubads());
googletag.defineSlot('/11648707/Departamentales-bottom-728x90px', [728, 90], 'div-gpt-ad-1403214408507-0').addService(googletag.pubads());

googletag.pubads().enableSingleRequest();
googletag.enableServices(); 
});      
</script>

<?php
global  $wpdb; $user_id = get_current_user_id(); $qry = "SELECT identifier, websiteurl, email FROM `wp_2_wslusersprofiles` WHERE user_id = '$user_id' && provider = 'Google' && identifier IS NOT NULL && websiteurl = 'http://doap.com'"; $avalidgoogleid = $wpdb->get_results( $qry ); foreach ( $avalidgoogleid as $avalidgoogleid ) { $gid = $avalidgoogleid ->identifier; $uemail  = $avalidgoogleid ->email; $websiteurl = $avalidgoogleid ->websiteurl; }
?>

<?php 
if ($gid > 10000000 )  { 
        include(STYLESHEETPATH . '/page-wing-ads-loggedin.php');
        include(STYLESHEETPATH . '/backpages-top-loggedin.php');
} else {  
        include(STYLESHEETPATH . '/page-wing-ads-departamentales.php');
        include(STYLESHEETPATH . '/banner-ad-widget-departamentales-728x90.php');
        include(STYLESHEETPATH . '/banner-ad-widget-departamentales-270x90.php');
}            

?>

<?php responsive_wrapper(); // before wrapper container hook ?>
        <div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>

<?php

echo '<div id="content-archive" class="' . implode( ' ', responsive_get_content_classes() ) . '">';


$max_posts = 9;
$right_col_start = 5;
$right_col_pix = 1;
//$category = get_the_category(); 
$themaincat = 26;
$single_cat_title = 'Departamentales'; 
$max_width = 'max-width:100%;';
echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'/"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); 

if ( $paged < 2 )
{
	//wp_reset_query();
	//$args = array( 'meta_query' => array( 'relation' => 'OR', array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ), array( 'key' => 'breves', 'value' => false, 'type' => 'BOOLEAN' ) ), 'post__not_in' => $feat_post );
	$args = array(
		'cat' => $themaincat,
		'posts_per_page' => 1,
		'meta_key' => '_thumbnail_id',
		'meta_query' => array(
			array(
			 'key' => 'destacado',
			 'value' => true,
			 'type' => 'BOOLEAN'
			     )
        	),
	//	'tag_id' => 24124
	//	'post__in'  => get_option( 'sticky_posts' ),
		'ignore_sticky_posts' => 1
	);
	$story_count = 0;
	$the_query = new WP_Query( $args );
	if( !$the_query->have_posts() ) 
	{
	//wp_reset_query();
	$args = array(
		'cat' => $themaincat,
		'posts_per_page' => 1,
		'meta_key' => '_thumbnail_id',
	//	'tag_id' => 24124
	//	'post__in'  => get_option( 'sticky_posts' ),
		'ignore_sticky_posts' => 1
	);
	$story_count = 0;
	add_filter('posts_clauses', 'filterEdiciones');
	$the_query = new WP_Query( $args );
	//removeQueryFilter();
	}
	if( $the_query->have_posts() ) 
	{
		while ( $the_query->have_posts() )
		{
			$the_query->the_post();
			$posted_time = get_the_time('h:i A');
			$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
			if ( comments_open() ) {
				if ( $num_comments == 0 ) {
					$comments = __(' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/comentarionulo.svg" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios');
				} elseif ( $num_comments > 1 ) {
					$comments = $num_comments . __(' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/comentario.svg" style="max-width:100%;border:0px solid #fff;" alt=""> ' . $num_comments . ' Comentarios');
				} else {
					$comments = __(' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/comentariodoble.svg" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario');
				}
				$write_comments = '<a style="color:#fff;" href="' . get_comments_link() .'">'. $comments.'</a>';
				} else {
				$write_comments =  __('Comments are off for this post.');
			}
			if ( has_post_thumbnail() )
			{
				$image_info = wp_get_attachment_metadata( get_post_thumbnail_id($post->ID) );
				$img_width = $image_info['width'];
				$img_height = $image_info['height'];
				$feat_post[] = $post->ID;
				if ($img_height > $img_width)
				{
					$right_col_start = 4;
					$right_col_pix = 1;
					$max_posts = 9;
					$pix_class = 'catpic-vert';
					$pix_size = 'responsive-450';
					$pix_width = '420px;position:relative;float:left;';
					$pix_img_width = '450px;';
					$story_pre = '<div class="su-column su-column-size-2-3"><div class="su-column-inner su-clearfix"></div>';
					$story_post = '';
				}
				else
				{
					$right_col_start = 3;
					$right_col_pix = 0;
					$max_posts = 6;
					$pix_orient = 'horizontal';
					$pix_class = 'catpic-hori';
					$pix_size = 'Video-Poster-640x360';
					$pix_width = '100%;';
					$pix_img_width = '667px;';
					$story_pre = '<div style="clear:both;">';
					$story_post = '</div><div class="su-column su-column-size-2-3"><div class="su-column-inner su-clearfix"></div>';
				}
			}
			include(STYLESHEETPATH . '/templates/cat-feat-img-extract.php');
		}
	}
	else
	{
		$story_pre = '<div class="su-column su-column-size-2-3"><div class="su-column-inner su-clearfix"></div>';
		echo '<div> No hay notas en esta categoria </div>'; 
		echo $story_pre;
		$max_posts = 9;
	}
}
wp_reset_query();
global $wp_query;
$args = array_merge( $wp_query->query_vars, array( 'cat' => $themaincat, 'meta_query' => array( 'relation' => 'OR', array( 'key' => 'breves', 'compare' => 'NOT EXISTS' ), array( 'key' => 'breves', 'value' => 0, 'type' => 'NUMERIC' ) ), 'post__not_in' => $feat_post ) );
add_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );
$even = 0; 
if( $the_query->have_posts() ) 
{
//		get_template_part( 'deportes-loop-header' ); 
//echo 'max posts = ' . $max_posts;
	while( $the_query->have_posts() && $even < $max_posts )
	{ 
		$the_query->the_post();
		$even++;
		$float='left';
		echo '<div style="clear:both;"></div>';
		if ($paged > 1 && $even == 1)
		{
			$story_pre = '<div class="su-column su-column-size-2-3"><div class="su-column-inner su-clearfix"></div>';
			echo $story_pre;
		}
		if ($paged < 2)
		{
			if ($even < $right_col_start)
			{
				$max_width = 'width:420px;';
			}
			//		$float='right';

			if ($pix_orient != 'horizontal' && $even == 1)
			{
				echo '<div style="margin:50px auto 50px auto;width:300px;position:relative;">'; 
				if ($gid > 10000000)
				{
					include(STYLESHEETPATH . '/middle-300x250-loggedin.php');
				}
				else
				{
					include(STYLESHEETPATH . '/ad-300x250-center-departamentales.php');
					echo "";
				} 
				echo '</div>';
			}
		}

		if ($even == $right_col_start)
		{
			echo '</div>';
			echo '<div class="su-column su-column-size-1-3">';
		$max_width = 'width:100%;';
		}
 
		echo '<div style="clear:both;"></div>';
		if ($even == 1 && $pix_orient == 'horizontal' && $paged < 2)
		{
			$pix_class = 'cat-dest-mini';
			$pix_size = 'caricatura-home';
			$pix_width = '210px;';
			$pix_img_width = '210px;';

			$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
			$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $pix_size );
			$feat_image = $feat_image_array[0];
			$post_url = get_permalink($post->ID);
			$sec_story_img = '<div style="position:relative;float:left;"><a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:' . $pix_img_width . 'border: 1px solid #ccc;margin-right:5px;margin-bottom:2px;"></a></div>' . PHP_EOL;
			$sec_story_title = '<a href="' . $post_url . '" title="Haz clic aqui para leer el nota completo."><div class="su-heading su-heading-style-modern-1-blue su-heading-align-left fp-title-bar" style="font-size:20px;margin-bottom:0px;"><div class="su-heading-inner" style="display:inline;">' . ucfirst(get_the_title()) . '</div></div></a>';
			echo '<div style="height:10px;clear:both;"></div>';
			echo '<div class="cat-sec-dest" style="width:100%;">' . $sec_story_img . $sec_story_title;
?>
 <a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubbles1.png" style="max-width:100%;border:0px solid #fff;" alt=""> % Comentarios', 'su' ) ); ?></a>
<?php
			$theexcerpt = get_doap_excerpt(30,1); 
			$sec_story_excerpt = '<div class="category-excerpt" style="padding:4px;text-align:justify;">' . $theexcerpt . '</div>' . PHP_EOL;

			echo $sec_story_excerpt . '</div>';
			echo '<div style="clear:both;"></div>';
			echo '<div style="background-color:#eee;margin:50px auto 50px auto;width:300px;position:relative;">';
			if ($gid > 10000000)  { include(STYLESHEETPATH . '/middle-300x250-loggedin.php'); } else { include(STYLESHEETPATH . '/ad-300x250-center-departamentales.php'); echo ""; } 
			echo '</div>';
		}
		else
		{
		responsive_entry_before(); 
		echo '<div id="su-post-' . get_the_ID() . '" style="position:relative;">';
		responsive_entry_top(); 
		$theexcerpt = get_doap_excerpt(30,1);
		$theexcerpt = '<div class="category-excerpt" style="padding:4px;text-align:justify;">' . $theexcerpt . '</div>' . PHP_EOL;
		$thepermalink = get_the_permalink();
		echo do_shortcode('<a href="' . $thepermalink . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title()).'[/doap_heading][/doap_animate]</a>');
?>

 <a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubbles1.png" style="max-width:100%;border:0px solid #fff;" alt=""> % Comentarios', 'su' ) ); ?></a>

				<div class="post-entry">
<?php
		$gmt_timestamp = get_post_time('U', true); 
		if (!$right_col_pix && $even >= $right_col_start)
		{
			$show_img = 0;	
		}
		else
		{
			$show_img = 1;	
		}
		if ( has_post_thumbnail() && $show_img )
		{
			$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
			$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-300' );
			$post_url = get_permalink($post->ID);
			$feat_image = $feat_image_array[0];
			echo '<div style="border: 1px solid #ccc;' . $max_width .'">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"style="width:100%"></a>' . PHP_EOL;
			echo '</div>';
		}
		echo $theexcerpt;
		wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) );
?>
				</div>
				<!-- end of .post-entry -->
<?php
			//get_template_part( 'post-data' );
			responsive_entry_bottom();
?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
<?php
			responsive_entry_after();
		}
	}		
		//get_template_part( 'loop-nav' );
}
else 
{
	get_template_part( 'loop-no-posts' );
}
?>
</div><!-- end of 2-3 column -->
<div style="clear:both;"></div>
<?php
if ( $paged < 2 )
{
	include('templates/mas-en.php');
}
	wp_reset_postdata();
//echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
?>
</div><!-- end of #content-archive -->
<?php get_sidebar('departamentales'); ?> 

<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>

<?php if ($gid > 10000000)  { include(STYLESHEETPATH . '/bottom-ads-loggedin.php'); } else { include(STYLESHEETPATH . '/banner-ad-widget-departamentales-bottom-728x90.php'); echo ""; } ?>

<?php get_footer(); ?>
