<?php
$left_300_story = $even;
$left_300_id = ($even == $left_300_story) ? 'dom-left' : 'mini-post';
$max_width = ($even == $left_300_story) ? 'width:340px;' : 'width:210px;';
//echo '<div style="position:absolute;display:block;bottom:0px;left:0px;height:30px;width:100%;max-width:100%;color:#fff;background:rgba(0, 0, 0, 0.5);border-radius:0;opacity:1;font-size:11pt;"><div><div style="position:absolute;width:60px;margin:0px 5px 5px 0px;padding:5px;color:#fff;"> ' . $posted_time . '</div>';
$theexcerpt = ($even == $left_300_story) ? get_doap_excerpt(92, 1, 1) : get_doap_excerpt(232,1,1);
$font_size = ($even == $left_300_story) ? 'font-size:13pt;' : 'font-size:14px;';
$excerpt_font_size = ($even == $left_300_story) ? 'font-size:11pt;' : 'font-size:13px;line-height:1.2;';
$title_height = ($even == $left_300_story) ? 'height:30px;line-height:1.5;' : 'height:20px;line-height:1;';
$bottom_height = ($even == $left_300_story) ? 'height:50px;line-height:1.2;' : 'height:35px;line-height:1;';
$font_color= ($even == $left_300_story) ? 'color:#000;' : 'color:#000;';
$margin_right = ($even == $mini_post) ? 'padding-right:0px;' : 'padding-right:10px;';
$padding_left = ($even == $left_300_story) ? 'padding-left:8px;padding-right:0px;' : 'padding-left:0px;padding-bottom:10px;';
$background = ($even == $left_300_story) ? 'background:rgba(333, 333, 333, 0.5);' : 'background:rgba(3, 3, 3, 0.75);';
$excerpt_align= ($even == $left_300_story) ? 'text-align:left;' : 'text-align:justify;';
$title = the_title_attribute('echo=0');
$post_url = get_permalink($post->ID);
$top_text = ($even == $left_300_story) ? '<div class="title-overlay" style="z-index:10;position:absolute;left:9px;top:1px;' . $font_color . $background . 'border-radius:0;opacity:1;font-family:Arial;' . $font_size . 'text-align:center;padding:2px 10px 2px 10px;' . $title_height . '">' . $title . '</div>' : '' ;
$bottom_text = ($even == $left_300_story) ? $title : $title;
echo '<div class="mobile-clear"></div>';
//echo '<div id="' . $left_300_id  . '" style="' . $max_width . 'position:relative;float:left;' . $margin_right . $padding_left . '">';
echo '<div id="' . $left_300_id  . '">';
//echo '<div class="tcp-product-list tcpf" style="' .$max_width . 'min-height:250px;">';
echo '<div class="tcp-product-list tcpf">';
//echo $top_text . PHP_EOL;
$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' );
$feat_image = $feat_image_array[0];
echo '<div class="img-div" style="position:relative;margin-top:0px;margin-bottom:10px;border: 1px solid #ccc;">' . PHP_EOL;
echo '<a href="' . $post_url . '"><img src="' . $feat_image . '">';
echo '<div class="excerpt-overlay" style="margin: 0px;position:absolute;display:block;bottom:0px;left:0px;width:100%;' . $bottom_height . $background . 'color:#000;border-radius:0;opacity:1;font-family:Arial;text-align:left;">';
echo '<div class="excerpt-overlay-text" style="font-family:Arial;text-align:left;margin:4px;' . $excerpt_font_size . $bottom_height . 'padding: 2px 4px 2px 4px;">' . $bottom_text . '</div></div></a>' . PHP_EOL;
echo '</div>';
//echo '<div class="mas-en-titles"><p><a href="' . $post_url . '">'. $title . '</a></p></div>' . PHP_EOL;
if ($even <> $left_300_story)
{
echo '<div style="margin:4px;' . $excerpt_align . $excerpt_font_size . '">' . $theexcerpt . '</div>';
}
echo '</div>' . PHP_EOL;
echo '</div>' . PHP_EOL;
//echo '<div style="height:20px;clear:both;"></div>';
?>
