<?php get_header(); ?>


<?php
if (2 == 2)
{
//      echo '<div style="width:100%;height:40px;background-color:#ccc;"> MARCADOR COMES NEXT </div>';
        echo '<div style="clear:both;"></div>';
        $marcador_key = 'activo_en_portada';
        $args = array(
        'post_type' => 'marcador',
        'post_status' => 'publish',
//      'meta_key' => 'activo_en_deportes',
//      'meta_value' => 1,
        'meta_query' => array(
                array(
                'key' => $marcador_key,
                'value' => 1,
                'compare' => '='
                     )
        ),
        'posts_per_page' => 1
//      'tag_id' => 24124
//      'post__in'  => get_option( 'sticky_posts' ),
//      'ignore_sticky_posts' => 1
);
//$story_count = 0;
//wp_reset_query();
//echo ' IS FRONT PAGES? = ' . is_front_page();
$marc_query = new WP_Query( $args );
if( $marc_query->have_posts() )
{
        echo '<div style="padding:4px;">';
        //include(STYLESHEETPATH . '/marcador.php');
        include(STYLESHEETPATH . '/marcadorhome.php');
        echo '</div>';
}
        echo '<div style="clear:both;"></div>';
        echo '<div id="story-2" style="margin:10px 0px 10px 0px;width:100%;clear:initial;">';
        echo '<div style="margin:0px 4px 0px 4px;width:300px;position:relative;float:left;">'; 
?>

<?php //get_sidebar(); ?>
<?php get_footer(''); ?>
