<div style="height:430px;margin-bottom:10px;">
<?php
$args = array( 'posts_per_page' => 2, 'offset'=> 1, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => '21' );
$myposts = get_posts( $args );
foreach ( $myposts as $post )
{
        setup_postdata( $post );
        $title = the_title_attribute('echo=0');
        $post_url = get_permalink($post->ID);
        echo '<div class="tcp-product-list tcpf" style="border: 1px solid #ccc;margin-bottom:10px;width:300px;float:left;margin-left:4px;margin-right:4px;">';
        echo '<div class="shawn">';
        $feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' );
        $feat_image = $feat_image_array[0];
        //echo '<div style="position:relative;max-width:300px;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
        echo '<div style="position:relative;max-width:300px;margin-top:0px;margin-bottom:0px;">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '"></a>' . PHP_EOL;
        echo '</div>';
        //echo '<div class="destacados-titles"><h4 class="entry-title"><a href="' . $post_url . '">'. $title . '</a></h5></div>' . PHP_EOL;
        echo '<div class="destacados-titles" style="padding:4px;"><h4 class="tcpf"><a href="' . $post_url . '">'. $title . '</a></h5></div>' . PHP_EOL;
        echo '<div class="destacados-excerpt" style="padding:4px;">' . PHP_EOL;
        remove_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
        $theexcerpt = get_the_excerpt();
        add_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );
        $words = str_word_count($theexcerpt, 2);
        $pos = array_keys($words);
        if (!array_key_exists('50', $pos))
        {
                $exp_pos = count($pos) - 1;
        }
        else
        {
                $exp_pos = 50;
        }
        $theexcerpt = '<p>' . substr($theexcerpt, 0, $pos[$exp_pos]) . '</p>' . PHP_EOL;
        echo $theexcerpt;
        echo get_the_term_list( $post->ID, 'post_tag', 'Etiquetas: ', ', ', '' );
        echo '</div>' . PHP_EOL;
        //echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        wp_reset_postdata();
}
?>
</div>
