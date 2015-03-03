<?php echo do_shortcode('[doap_spacer id=aftersidebar size="100"]'); ?>
<?php //echo do_shortcode('[doap_spacer height=260]'); ?>
<?php echo "<div style=z-index:0;position:relative;top:0;border:1px solid #cccccc;>"; ?>
<div style="position:absolute;top:-90px;height:90px;width:728px;left:138px;"><?php include('/var/www/html/lpmu/wp-content/themes/noticias' . '/banner-midpage-index.php'); ?></div>
<div style="padding-left:0px;padding-top:5px;padding-bottom:5px;position:relative;left:0px;top:0px;" class="desacados_bar">
<div id="destacados">
<?php echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/destacados">Destacados</a>[/doap_heading][/doap_animate]'); ?>
<div style="position:relative;float:left;height:330px;width:240px;margin-right:10px;">
<a href="/economia/"><h5 style="background-color:#4c4c4c;color:#fff;position:relative;top:25px;left:1px;width:100px;margin-bottom:0px;padding-left:15px;padding-top:5px;height:20px;z-index:10;font-family:Arial,Helvetica,sans-serif;font-size:1.125em;font-weight:700;line-height:1.0em;">Activos</h5></a>
<?php
$args = array( 'posts_per_page' => 1, 'offset'=> 1, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => '31,2293' );
// echo do_shortcode(' [tcp_list id="posts_destacados_activos"] ');
$myposts = get_posts( $args );
foreach ( $myposts as $post )
{
        setup_postdata( $post );
        $title = the_title_attribute('echo=0');
        $post_url = get_permalink($post->ID);
        echo '<div class="tcp-product-list tcpf" style="border: 1px solid #ccc;margin-bottom:10px;">';
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
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        wp_reset_postdata();
}
?>
<div style="position:relative;float:left;height:330px;width:240px;margin-right:10px;">
<a href="/ambitos/"><h5 style="background-color:#4c4c4c;color:#fff;position:relative;top:25px;left:1px;width:100px;margin-bottom:0px;padding-left:15px;padding-top:5px;height:20px;z-index:10;">Ambitos</h5></a>
<?php
$args = array( 'posts_per_page' => 1, 'offset'=> 1, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => '3518' );
// echo do_shortcode(' [tcp_list id="posts_destacados_activos"] ');
$myposts = get_posts( $args );
foreach ( $myposts as $post )
{
        setup_postdata( $post );
        $title = the_title_attribute('echo=0');
        $post_url = get_permalink($post->ID);
        echo '<div class="tcp-product-list tcpf" style="border: 1px solid #ccc;margin-bottom:10px;">';
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
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        wp_reset_postdata();
}
?>
<div style="position:relative;float:left;height:330px;width:240px;margin-right:10px;">
<a href="/politica/"><h5 style="background-color:#4c4c4c;color:#fff;position:relative;top:25px;left:1px;width:100px;margin-bottom:0px;padding-left:15px;padding-top:5px;height:20px;z-index:10;">Poderes</h5></a>
<?php
$args = array( 'posts_per_page' => 1, 'offset'=> 1, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => '27,3519' );
// echo do_shortcode(' [tcp_list id="posts_destacados_activos"] ');
$myposts = get_posts( $args );
foreach ( $myposts as $post )
{
        setup_postdata( $post );
        $title = the_title_attribute('echo=0');
        $post_url = get_permalink($post->ID);
        echo '<div class="tcp-product-list tcpf" style="border: 1px solid #ccc;margin-bottom:10px;">';
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
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        wp_reset_postdata();
}
?>
<div id="destacados-deportes" style="position:relative;float:left;height:330px;width:240px;">
<a href="/category/noticias/deportes/"><h5 style="background-color:#4c4c4c;color:#fff;position:relative;top:25px;left:1px;width:100px;margin-bottom:0px;padding-left:15px;padding-top:5px;height:20px;z-index:10;">Deportes</h5></a>
<?php
$args = array( 'posts_per_page' => 1, 'offset'=> 1, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => '17' );
// echo do_shortcode(' [tcp_list id="posts_destacados_activos"] ');
$myposts = get_posts( $args );
foreach ( $myposts as $post )
{
        setup_postdata( $post );
        $title = the_title_attribute('echo=0');
        $post_url = get_permalink($post->ID);
        echo '<div class="tcp-product-list tcpf" style="border: 1px solid #ccc;margin-bottom:10px;">';
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
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        wp_reset_postdata();
}
?>
<div id="destacados-deportes" style="position:relative;float:left;height:330px;width:240px;">
<a href="/category/noticias/deportes/"><h5 style="background-color:#4c4c4c;color:#fff;position:relative;top:25px;left:1px;width:100px;margin-bottom:0px;padding-left:15px;padding-top:5px;height:20px;z-index:10;">Deportes</h5></a>
<?php
$args = array( 'posts_per_page' => 1, 'offset'=> 1, 'orderby'=> 'post_date', 'order'=> 'DESC', 'meta_key'=> '_thumbnail_id', 'post_status' => 'publish', 'category' => '17' );
// echo do_shortcode(' [tcp_list id="posts_destacados_activos"] ');
$myposts = get_posts( $args );
foreach ( $myposts as $post )
{
        setup_postdata( $post );
        $title = the_title_attribute('echo=0');
        $post_url = get_permalink($post->ID);
        echo '<div class="tcp-product-list tcpf" style="border: 1px solid #ccc;margin-bottom:10px;">';
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
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        wp_reset_postdata();
}
?>
</div>
<?php //echo do_shortcode('[doap_spacer size="20"]'); ?>
</div>
<?php //echo do_shortcode('[doap_spacer size="20"]'); ?>
<div style="position:absolute;top:0px;width:728px;height:90px;left:138px;"><?php //include('/var/www/html/lpmu/wp-content/themes/noticias' . '/banner-midpage-index.php'); ?></div>
</div>
<?php echo do_shortcode('[doap_spacer size="20"]'); ?>

<div style="width:100%;height:200px;"></div>
<style>
#davestable table, #davestable tr td {
    border: none;padding:0px;margin:0px;
}
</style>
<?php echo do_shortcode('[doap_spacer size="140"]'); ?>
<?php echo do_shortcode('[doap_row][doap_column size="2/3" class="suplementos-home-bottom"][doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/planeta">Suplementos</a>[/doap_heading][/doap_animate]<img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/Screen-Shot-2014-04-19-at-11.50.05-AM.jpg" alt="Screen-Shot-2014-04-19-at-11.50.05-AM" width="707" height="270" class="alignnone size-full wp-image-372331" /><br><div id=magazine-ad><a href=http://magazine.laprensa.com.ni><iframe src=http://noticias.laprensa.com.ni/los-cuatro/magazine.html frameborder=0 scrolling=no height=137 width=728></iframe></a></div>[/doap_column][doap_column size="1/3" class="suplementos-home-bottom"]<table id="davestable" border="0" style="border:0px solid #fff;"><tr><td colspan="3" style="width:100%;min-width:200px;"><a href="http://noticias.laprensa.com.ni/category/portada-impresa">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/planeta">Portada Impresa</a>[/doap_heading][/doap_animate]</a></td></tr><tr><td width="20%"></td><td style="min-width:200px;">[doap_custom_gallery source="category: 3680" limit="1" link="post" width="290" height="460" title="always" class="gallery-of-portadas"]</td><td width="20%"></td></tr></table><br><a style="position:relative;top:-35px;" href="http://noticias.laprensa.com.ni/2014">[xyz-ips snippet="ediciones-anteriores"][/doap_column][/doap_row]'); ?>

<?php echo do_shortcode('[doap_row][doap_column size="2/3" class="cartelera-row-of-images"][doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/planeta">Cartelera de cine</a>[/doap_heading][/doap_animate]<br><div style="max-width:600px;width:100%;height:300px;background-color:#369:">[doap_custom_gallery source="category: 23782" limit="1" link="post" width="600" height="280" title="never" class="cartelera-images-3up"]</div>[/doap_column][doap_column size="1/3" class="bottom-corner-ad"]<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Hoy Sidebar Boxes -->
<ins class="adsbygoogle"
     style="display:inline-block;width:250px;height:250px"
     data-ad-client="ca-pub-6970273280466483"
     data-ad-slot="9387035065"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>[/doap_column][/doap_row]'); ?>
