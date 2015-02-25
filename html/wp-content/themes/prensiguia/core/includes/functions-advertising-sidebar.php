<?php
/**
 * Advertising widget areas.
 */
function responsive_advertising_widgets_init() {

    register_sidebar( array(
        'name'          => __( 'Top Advertising Area', 'responsive' ),
        'description'   => __( 'Ads Area Top - sidebar-ads-top.php - Displays the top adverts', 'responsive' ),
        'id'            => 'ads-top',
        'before_title'  => '',
        'after_title'   => '',
        'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
        'after_widget'  => '</div>'
    ) );
    register_sidebar( array(
        'name'          => __( 'Fixed Left Advertising Area', 'responsive' ),
        'description'   => __( 'Ads Area Left - sidebar-ads-left.php - Displays the left adverts', 'responsive' ),
        'id'            => 'ads-left',
        'before_title'  => '',
        'after_title'   => '',
        'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
        'after_widget'  => '</div>'
    ) );
    register_sidebar( array(
        'name'          => __( 'Fixed Right Advertising Area', 'responsive' ),
        'description'   => __( 'Ads Area Right - sidebar-ads-right.php - Displays the right adverts', 'responsive' ),
        'id'            => 'ads-right',
        'before_title'  => '',
        'after_title'   => '',
        'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
        'after_widget'  => '</div>'
    ) );
    register_sidebar( array(
        'name'          => __( 'Bottom Advertising Area', 'responsive' ),
        'description'   => __( 'Ads Area Bottom- sidebar-ads-bottom.php - Displays the top adverts', 'responsive' ),
        'id'            => 'ads-bottom',
        'before_title'  => '',
        'after_title'   => '',
        'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
        'after_widget'  => '</div>'
    ) );
    register_sidebar( array(
        'name'          => __( 'Inside Advertising Area', 'responsive' ),
        'description'   => __( 'Ads Area Inside- sidebar-ads-inside.php - Displays the inside lists', 'responsive' ),
        'id'            => 'ads-inside',
        'before_title'  => '',
        'after_title'   => '',
        'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
        'after_widget'  => '</div>'
    ) );
    register_sidebar( array(
        'name'          => __( 'Front Page Between Sections 1 Advertising Area', 'responsive' ),
        'description'   => __( 'Ads Area Between Section 1 - sidebar-ads-frontpage-section-1.php - Displays Between Section Adverts', 'responsive' ),
        'id'            => 'ads-frontpage-section-1',
        'before_title'  => '',
        'after_title'   => '',
        'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
        'after_widget'  => '</div>'
    ) );
    register_sidebar( array(
        'name'          => __( 'Front Page Between Sections 2 Advertising Area', 'responsive' ),
        'description'   => __( 'Ads Area Between Section 2 - sidebar-ads-frontpage-section-2.php - Displays Between Section Adverts', 'responsive' ),
        'id'            => 'ads-frontpage-section-2',
        'before_title'  => '',
        'after_title'   => '',
        'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
        'after_widget'  => '</div>'
    ) );
    register_sidebar( array(
        'name'          => __( 'Front Page Between Sections 3 Advertising Area', 'responsive' ),
        'description'   => __( 'Ads Area Between Section 3 - sidebar-ads-frontpage-section-3.php - Displays Between Section Adverts', 'responsive' ),
        'id'            => 'ads-frontpage-section-3',
        'before_title'  => '',
        'after_title'   => '',
        'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
        'after_widget'  => '</div>'
    ) );
}
add_action( 'widgets_init', 'responsive_advertising_widgets_init' );
?>
