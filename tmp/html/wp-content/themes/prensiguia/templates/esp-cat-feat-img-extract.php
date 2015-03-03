<?php
$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $pix_size );
$post_url = get_permalink($post->ID);
$feat_image = $feat_image_array[0];
$title = ucfirst(get_the_title());
$theexcerpt = get_doap_excerpt(290,1,1);
//$theexcerpt = '<div class="category-excerpt" style="max-width:' . $pix_img_width . 'padding:4px;">' . $theexcerpt . '</div>' . PHP_EOL;
echo $story_pre;
//echo do_shortcode('<a href="' . $post_url . '" title="Haz clic aqui para leer el nota completo.">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="25" align="left" margin="0" class="fp-title-bar"]'.$title.'[/doap_heading][/doap_animate]</a>');
//echo '<div style="height:10px;"></div>';
echo '<div class="' . $pix_class . '" style="position:relative;float:left;border: 1px solid #ccc;max-width:' . $pix_width . '">' . PHP_EOL;
echo '<a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:' . $pix_img_width . '">' . PHP_EOL;
echo '<div id="esp-cat-dest-img-bot" style="position:absolute;bottom:10px;right:10px;width:257px;height:138px;background:rgba(0, 0, 0, 0.5);border-radius:0;opacity:1;"><div style="margin:10px;"><div style="font-family:Open Sans;font-size:1.4em;font-weight:100;line-height:1.2em;color:#fff;"> ' . $title . '</div>';
//echo '<div id="cat-dest-img-bot" style="position:absolute;display:block;bottom:0px;left:0px;height:30px;width:100%;max-width:100%;color:#fff;background:rgba(0, 0, 0, 0.5);border-radius:0;opacity:1;font-size:11pt;"><div><div style="position:absolute;width:60px;margin:0px 5px 5px 0px;padding:5px;color:#fff;"> ' . $posted_time . '</div>';
echo '<div style="font-family:Arial;font-size:.875em;line-height:1.3em;color:#fff;">';
echo $theexcerpt;
//echo $write_comments;
echo '</div></div></a></div></div><div style="clear:both;"></div>';
echo $story_post;
?>
