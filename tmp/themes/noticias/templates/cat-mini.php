<?php
$pix_class = 'cat-dest-mini';
$pix_size = 'caricatura-home';
$pix_width = '210px;';
$pix_img_width = '210px;';

$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $pix_size );
$feat_image = $feat_image_array[0];
$post_url = get_permalink($post->ID);
$sec_story_img = '<div style="position:relative;float:left;"><a href="' . $post_url . '"><img src="' . $feat_image . '" style="width:' . $pix_img_width . 'border: 1px solid #ccc;margin:4px 8px 2px 0px;"></a></div><div class="mobile-clear"></div>' . PHP_EOL;
$sec_story_title = '<a href="' . $post_url . '" title="Haz clic aqui para leer el nota completo."><div class="su-heading su-heading-style-modern-1-blue su-heading-align-left fp-title-bar" style="font-size:20px;"><div class="su-heading-inner" style="display:inline;">' . ucfirst(get_the_title()) . '</div></div></a>';
//echo '<div style="height:10px;clear:both;"></div>';
echo '<div class="cat-sec-dest" style="width:100%;">' . $sec_story_img . $sec_story_title;
echo writeComments('black', $post->ID);
/*
 <a href="<?php comments_link(); ?>" class="su-post-comments-link comments-url"><?php comments_number( __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 0 Comentarios', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt=""> 1 Comentario', 'su' ), __( ' <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubbles1.png" style="max-width:100%;border:0px solid #fff;" alt=""> % Comentarios', 'su' ) ); ?></a>
*/
$theexcerpt = get_doap_excerpt($extract_chars,1,1); 
echo '<div class="category-excerpt" style="padding:4px;text-align:justify;">' . $theexcerpt . '</div>' . PHP_EOL;
echo '</div>';
echo '<div style="clear:both;"></div>';
?>
