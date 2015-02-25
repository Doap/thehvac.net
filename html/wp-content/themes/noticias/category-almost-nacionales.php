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
<?php if (current_user_can( 'manage_options' ))  { } else { include('/var/www/html/lpmu/wp-content/themes/noticias' . '/page-wing-ads.php'); } ?>
<?php
include('/var/www/html/lpmu/wp-content/themes/noticias' . '/banner-ad-widget.php');  
include('/var/www/html/lpmu/wp-content/themes/noticias' . '/banner-ad-widget-270x90.php');  

echo '<div id="content-archive" style="margin-top:4px;margin-right:4px;" class="' . implode( ' ', responsive_get_content_classes() ) . '">';


$category = get_the_category(); 
$themaincat = $category[0]->cat_ID;
$single_cat_title = $category[0]->cat_name;
$max_width = 'max-width:100%;';
//echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'/"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="twodots"></div></a>[/doap_heading]'); 
echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'/"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); 

//echo do_shortcode('[doap_slider source="category: '.$themaincat.'" limit="4" width="640" height="360" link="post" mousewheel="no" pages="no" class="deportes-slider"]');
wp_reset_query();
$args = array(
	'cat__in' => $themaincat,
	'posts_per_page' => 1,
	'meta_key' => '_thumbnail_id',
//	'tag_id' => 24124
	'post__in'  => get_option( 'sticky_posts' ),
	'ignore_sticky_posts' => 1
);
$story_count = 0;
$the_query = new WP_Query( $args );
if( $the_query->have_posts() ) 
{
while ( $the_query->have_posts() )
{
	$the_query->the_post();
	$posted_time = get_the_time('h:i A');
	$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
	//	echo '<div style="float:left;margin:0px 5px 5px 65px;text-align: right;> <a href="' . get_comments_link() . '" class="su-post-comments-link">' . comments_number( __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubbles1.png" style="max-width:100%;border:0px solid #fff;" alt=""> % Comentarios', 'su' ) ) . '</a></div></div></a></div></div>';
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
//echo PHP_EOL . 'img_width = ' . $img_width  . PHP_EOL;
//echo PHP_EOL . 'img_height = ' . $img_height  . PHP_EOL;
/*		if ($story_count)
		{
			$pix_class = 'cat-dest-mini';
			$pix_size = 'caricatura-home';
			$pix_width = '210px;';
			$pix_img_width = '210px;';
			$story_pre = '<div style="clear:both;">';
			if ($pix_orient == 'horizontal')
			{
			$feat_post[]=$post->ID;
			}
			echo 'my_post id = ';
			echo $post->ID;
			echo 'story count ' .$story_count . '     my_post id = ' . $post->ID;
		}
		else
		{
*/
//			echo 'story count ' .$story_count . '     post id = ' . $post->ID;
			$feat_post[] = $post->ID;
			if ($img_height > $img_width)
			{
				$pix_class = 'catpic-vert';
				$pix_size = 'responsive-450';
				$pix_width = '420px;position:relative;float:left;';
				$pix_img_width = '450px;';
				$story_pre = '<div class="su-column su-column-size-2-3" style="width:420px;margin: 0px 0px 0px 0px;position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
			}
			else
			{
				$pix_orient = 'horizontal';
				$pix_class = 'catpic-hori';
				$pix_size = 'Video-Poster-640x360';
				$pix_width = '100%;';
				$pix_img_width = '657px;';
				$story_pre = '<div style="clear:both;">';
			}
		}
//echo PHP_EOL . 'pix_size = ' . $pix_size . PHP_EOL;
//echo PHP_EOL . 'pix_width = ' . $pix_width . PHP_EOL;
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $pix_size );
		$post_url = get_permalink($post->ID);
//$sec_story_title = '<a href="' . $post_url . '" title="Haz clic aqui para leer el nota completo."><div class="su-heading su-heading-style-modern-1-blue su-heading-align-left fp-title-bar" style="font-size:20px;margin-bottom:0px;"><div class="su-heading-inner" style="display:inline;">' . ucfirst(get_the_title()) . '</div></div></a>';
		$feat_image = $feat_image_array[0];
		//$sec_story_img = '<div class="' . $pix_class . '" style="float:left;border: 1px solid #ccc;max-width:' . $pix_width . '">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:' . $pix_img_width . '"></a>' . PHP_EOL . '</div>';
//		$sec_story_img = '<div style="position:relative;float:left;"><a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:' . $pix_img_width . 'border: 1px solid #ccc;margin-right:5px;margin-bottom:2px;"></a></div>' . PHP_EOL;
	}
	remove_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
	$theexcerpt = get_the_excerpt();
	add_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
	$words = str_word_count($theexcerpt, 2);
	if ($words > 30)
	{
		$theexcerpt = implode(' ', array_slice(explode(' ', $theexcerpt), 0, 30)) . '...';
	}
	$theexcerpt = '<div class="category-excerpt" style="padding:4px;">' . $theexcerpt . '</div>' . PHP_EOL;
//	$sec_story_excerpt = $theexcerpt;
/*	if ($story_count == 0)
	{
*/
		echo $story_pre;
		echo do_shortcode('<a href="' . $post_url . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="25" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title()).'[/doap_heading][/doap_animate]</a>');
		echo '<div class="' . $pix_class . '" style="position:relative;float:left;border: 1px solid #ccc;max-width:' . $pix_width . '">' . PHP_EOL;
		echo '<a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:' . $pix_img_width . '">' . PHP_EOL;
		echo '<div style="position:absolute;display:block;bottom:0px;left:0px;height:30px;width:100%;max-width:100%;color:#fff;background:rgba(0, 0, 0, 0.5);border-radius:0;opacity:1;font-size:11pt;"><div><div style="position:absolute;width:60px;margin:0px 5px 5px 0px;padding:5px;color:#fff;"> ' . $posted_time . '</div>';
		echo '<div style="float:right;margin:0px 5px 5px 65px;text-align:right;padding:5px;color:#fff;">';
		echo $write_comments;
		//echo ' <a href="' . get_comments_link() . '" class="su-post-comments-link">' . comments_number( __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubbles1.png" style="max-width:100%;border:0px solid #fff;" alt=""> % Comentarios', 'su' ) ) . '</a>';
		echo '</div></div></a></div></div>';
		//echo '<div class="' . $pix_class . '" style="border: 1px solid #ccc;max-width:' . $pix_width . '">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:' . $pix_img_width . '">' . PHP_EOL . '<span style="opacity:.75;position:absolute;width:100%;margin-bottom:0px;padding-left:15px;padding-top:5px;height:30px;z-index:10;font-size:1.125em;font-weight:700;line-height:1.0em;"> posted at ' . $posted_time . '</h5></span></a></div>';
//echo '<div style="opacity:.75;background-color: #333;position:absolute;top:-30px;width:100%;margin-bottom:0px;padding-left:15px;padding-top:5px;height:30px;z-index:10;font-size:1.125em;font-weight:700;line-height:1.0em;"> posted at ' . $posted_time . '</h5></div>';
		//echo $sec_story_img;
		echo $theexcerpt;
/*
	}
$story_count++;
*/
}

else
{
	echo '<div> No hay notas en esta categoria </div>'; 
}
echo '</div>';
echo 'story count = ' . $story_count . PHP_EOL;
wp_reset_query();
//$query = new WP_Query( array( 'post__not_in' => get_option( 'sticky_posts' ) ) );
global $wp_query;
$args = array_merge( $wp_query->query_vars, array( 'post__not_in' => array(get_option( 'sticky_posts' ), $feat_post ) ) );
var_dump($query);
query_posts( $args );

var_dump($query);
echo '<div class="su-column su-column-size-1-3 category economia" style="width:229px;position:relative;float:right;margin:0 0 0 0;">';
$even = 0; ?> 
	<?php if( have_posts() ) : ?>

		<?php get_template_part( 'deportes-loop-header' ); ?>

		<?php while( have_posts() ) : the_post(); ?>
<?php
$even++;
$float='left';
echo '<div style="clear:both;"></div>';
if ($even == 6 )
{
//		echo '<div style="width:50%;position:relative;float:left;">';
//include('/var/www/html/lpmu/wp-content/themes/noticias' . '/ad-300x250-category-page-center.php');
	echo '</div>';
//	echo '<div class="su-column su-column-size-2-3" style="position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
echo '<div class="su-column su-column-size-2-3" style="width:420px;margin: 0px 0px 0px 0px;position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
	$even++;
$max_width = 'width:420px;';
		$float='right';
if ($pix_orient == 'horizontal')
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
echo '<div style="height:40px;clear:both;"></div>';
//echo '<div style="height:200px;background:#ccc">A different format goes here</div><div style="height:40px;clear:both;"></div>';
echo '<div class="cat-sec-dest" style="width:100%;">' . $sec_story_img . $sec_story_title;
?>
 <a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubbles1.png" style="max-width:100%;border:0px solid #fff;" alt=""> % Comentarios', 'su' ) ); ?></a>
<?php
$theexcerpt = get_doap_excerpt($post->ID,30); 
$sec_story_excerpt = '<div class="category-excerpt" style="padding:4px;">' . $theexcerpt . '</div>' . PHP_EOL;

echo $sec_story_excerpt . '</div>';
echo '<div style="height:40px;clear:both;"></div>';
}
		echo '<div style="margin:50px auto 50px auto;width:300px;position:relative;">';
include('/var/www/html/lpmu/wp-content/themes/noticias' . '/ad-300x250-category-page-center.php');
	echo '</div>';
}
if ($even == 3)
{
//		echo '<div style="width:100%;position:relative;float:left;">';
//	include('/var/www/html/lpmu/wp-content/themes/noticias' . '/ad-468x60-category-page.php');	
//		echo '</div>';
}
 
echo '<div style="clear:both;"></div>';
responsive_entry_before(); 
echo '<div id="su-post-' . get_the_ID() . '" style="position:relative;">';
responsive_entry_top(); 
//get_template_part( 'category-meta' ); 
//	echo '<div class="destacados-excerpt" style="padding:4px;">' . PHP_EOL;
	remove_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
	$theexcerpt = get_the_excerpt();
	add_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
	$words = str_word_count($theexcerpt, 2);
	if ($words > 30)
	{
		$theexcerpt = implode(' ', array_slice(explode(' ', $theexcerpt), 0, 30)) . '...';
	}
	$theexcerpt = '<div class="category-excerpt" style="padding:4px;">' . $theexcerpt . '</div>' . PHP_EOL;
$thepermalink = get_the_permalink();
echo do_shortcode('<a href="' . $thepermalink . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]'.ucfirst(get_the_title()).'[/doap_heading][/doap_animate]</a>');
?>

 <a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubbles1.png" style="max-width:100%;border:0px solid #fff;" alt=""> % Comentarios', 'su' ) ); ?></a>

<?php /* <div style="position:relative;float:left;padding-left:0px;padding-top:5px;padding-bottom:3px;"><?php _e( 'Publicado ', 'su' ); ?>: <?php the_time( get_option( 'date_format' ) ); ?></div> */ ?>
				<div class="post-entry">
<?php $gmt_timestamp = get_post_time('U', true); 
//$cat = str_replace(single_tag_title('Categoría: '), "Categoría", ""); 
if ( has_post_thumbnail() ) {
$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-300' );
$post_url = get_permalink($post->ID);
$feat_image = $feat_image_array[0];
echo '<div style="border: 1px solid #ccc;' . $max_width .'">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"style="width:100%"></a>' . PHP_EOL;
echo '</div>';

} else { ?>
<?php $current_category = single_cat_title("", false); ?>
<div style="width:100%;height:200px;margin-left:auto;margin-right:auto;"><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/04/laprensanota-<?php echo strtolower($current_category); ?>.jpg" draggable="false"> </div><div style="clear:both;"></div><?php } ?> 
					<?php
	echo $theexcerpt;
					wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) );
					?>
				</div>
				<!-- end of .post-entry -->




				<?php //get_template_part( 'post-data' ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>
		<?php
		endwhile;

		//get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>
</div><!-- end of 2-3 column -->
<?php
echo '<div style="clear:both;"></div>';
//echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/destacados">DESTACADOS<div class="2dots" style="width:100%;background: url("/2dots.png") repeat;"></div></a>[/doap_heading][/doap_animate]'); ?>
<div class="destacados-section">
<?php echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/destacados"><div class="title-left">MÁS EN ' . mb_strtoupper($single_cat_title) . '</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading]'); ?>

<?php
$args = array( 'posts_per_page' => 4, 'offset'=> 11, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => $themaincat, 'ignore_sticky_posts' => 1 );
$myposts = get_posts( $args );
foreach ( $myposts as $post )
{	
	setup_postdata( $post );
	$title = the_title_attribute('echo=0');
	$post_url = get_permalink($post->ID);
	echo '<div style="position:relative;float:left;width:150px;margin-right:10px;padding-left:4px;">';
	echo '<div class="tcp-product-list tcpf" style="width:150px;margin-bottom:10px;min-height:300px;">';
	$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' ); 
	$feat_image = $feat_image_array[0];
	echo '<div style="position:relative;width:150px;margin-top:0px;margin-bottom:0px;border: 1px solid #ccc;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:150;"></a>' . PHP_EOL;
	echo '</div>';
//echo '<a href="/category/noticias/economia/"><h5 style="background-color:#4c4c4c;color:#fff;position:absolute;top:-17px;width:100px;margin-bottom:0px;padding-left:15px;padding-top:5px;height:20px;z-index:10;font-family:Arial,Helvetica,sans-serif;font-size:1.125em;font-weight:700;line-height:1.0em;">Activos</h5></a>';
	echo '<div class="mas-en-titles"><p><a href="' . $post_url . '">'. $title . '</a></p></div>' . PHP_EOL;
//	echo '<div class="destacados-excerpt" style="padding:4px;">' . PHP_EOL;
//	remove_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
//	$theexcerpt = get_the_excerpt();
//	add_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
//	$words = str_word_count($theexcerpt, 2);
//	if ($words > 30)
//	{
//		$theexcerpt = implode(' ', array_slice(explode(' ', $theexcerpt), 0, 30)) . '...';
//	}
//	$theexcerpt = '<p>' . $theexcerpt . '</p>' . PHP_EOL;
//	echo $theexcerpt;
//	echo get_the_term_list( $post->ID, 'post_tag', 'Etiquetas: ', ', ', '' );
	echo '</div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
}
	echo '</div>' . PHP_EOL;
	wp_reset_postdata();
                echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
?>
</div><!-- end of #content-archive -->
<?php get_sidebar('nacionales'); ?> 
<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>
<?php //echo do_shortcode('[xyz-ips snippet="promociones-video-widget"]'); ?>
<?php get_footer(); ?>
