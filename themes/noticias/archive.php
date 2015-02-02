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
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1
 * @filesource     wp-content/themes/responsive/archive.php
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28archive.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>

<?php include(STYLESHEETPATH . '/home-adblock.php'); ?>

<?php responsive_wrapper(); // before wrapper container hook ?>
        <div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>

<?php

//$orderdate = $_GET['fecha'];

 $monthnum = get_query_var('monthnum'); 
 $day_of_month = get_query_var('day'); 
 $_year = get_query_var('year'); 

//$orderdate = explode('-', $orderdate);

//$archive_month = $orderdate[0];
$archive_month = $monthnum;
//$archive_day   = $orderdate[1];
$archive_day   = $day_of_month;;
//$archive_year  = $orderdate[2];
$archive_year  = $_year;

//$archive_year  = get_the_time('Y'); echo $archive_year;
//$archive_month = get_the_time('m'); echo $archive_month;
//$archive_day   = get_the_time('d'); echo $archive_day;
?>
<div id="content-archive" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">


<div style="position:relative;float:right;margin-right:10px;top:-20px;width:50%">

<?php //echo get_day_link( $year, $month, $day ); ?> 


<form method="get" action="<?php echo home_url( '/' ); ?>">
   Dia: <select name="day" title="dia">
    <?php foreach( range(31,1) as $day_of_month ) : ?>
<?php if (isset($archive_day) && $archive_day == $day_of_month) { ?>
        <option selected><?php echo $day_of_month; ?></option>
<?php } else { ?>
        <option><?php echo $day_of_month; ?></option>
<?php } ?>
    <?php endforeach; ?>
    </select>
    Mes:<select name="monthnum" title="mes">
    <?php foreach( range(1,12) as $month_of_year ) : ?>

<?php if (isset($archive_month) && $archive_month == $month_of_year) { ?>
        <option selected><?php echo $month_of_year; ?></option>
<?php } else { ?>
        <option><?php echo $month_of_year; ?></option>
<?php } ?>



    <?php endforeach; ?>
    </select>
    Ano:<select name="year" title="ano">
    <?php foreach( range(2014,2000) as $_year ) : ?>


<?php if (isset($archive_year) && $archive_year == $_year) { ?>
        <option selected><?php echo $_year; ?></option>

<?php } else { ?>
        <option><?php echo $_year; ?></option>

<?php } ?>


    <?php endforeach; ?>
    </select>
    <input type="submit" id="searchsubmit" value="Ir" />
</form>
</div>


<div style="width:100%;height:2px;"></div>
        <?php if( have_posts() ) : ?>

                <?php get_template_part( 'loop-header' ); ?>

                <?php while( have_posts() ) : the_post(); ?>

                        <?php responsive_entry_before(); ?>
                        <div style="width:100%;" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <?php responsive_entry_top(); ?>

                                <?php get_template_part( 'post-meta' ); ?>

                                <div class="post-entry">
                                        <?php
//                                      if(
if ( has_post_thumbnail() ) {

//the_post_thumbnail();
$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-150' );
$post_url = get_permalink($post->ID);
$feat_image = $feat_image_array[0];
echo '<div style="max-width:150px;float:left;padding-left:10px;padding-right:10px;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
echo '</div>';
}
 responsive_pro_get_option( 'search_post_excerpts' );
                                                add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
                                                add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
                                                the_excerpt();
                                                remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
                                                remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
                                        wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
                                </div>
                                <!-- end of .post-entry -->

                                <?php get_template_part( 'post-data' ); ?>

                                <?php responsive_entry_bottom(); ?>
                        </div><!-- end of #post-<?php the_ID(); ?> -->
                        <div><?php echo get_the_term_list( $post->ID, 'category', 'Categoría: ', ', ', '' ); ?></div>
                        <div><?php echo get_the_term_list( $post->ID, 'post_tag', 'Etiquetas: ', ', ', '' ); ?></div>
                        <?php responsive_entry_after(); ?>

                <?php
                endwhile;

echo '<div style="position:relative;float:left;">'; wpbeginner_numeric_posts_nav(); echo '</div>';
//              get_template_part( 'loop-nav' );

        else :

                get_template_part( 'loop-no-posts' );

        endif;
        ?>





</div><!-- end of #content-archive -->

<?php get_sidebar(); ?>
<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>
<div class="home-728x90" style="margin-left:135px;">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-6970273280466483";
/* nica-728x90banner */
google_ad_slot = "4717436669";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>

<?php get_footer(); ?>
