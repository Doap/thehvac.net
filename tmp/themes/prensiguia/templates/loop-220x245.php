<div class="su-posts su-posts-default-loop">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>

				<div id="su-post-<?php the_ID(); ?>" class="su-post" style="max-height:320px;">

<?php
$img_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
$image = su_image_resize( $img_url, 227, 150 );
$feat_image = $image['url'];
//$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
//$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'responsive-300' );
$post_url = get_permalink($post->ID);
//$feat_image = $feat_image_array[0];
echo '<div style="border: 1px solid #ccc;margin-left:5px;margin-top:10px;' . $max_width .'">' . PHP_EOL . '<a href="' . $post_url . '"><img src="' . $feat_image . '" height="150" width="227"></a>' . PHP_EOL;
echo '</div>';
?>

					<div style="width:100%;font-family:StagBook;font-size:1.3em;color:#DD579A;"><a style="color:#DD579A;" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
						<?php //the_excerpt(); 
        $theexcerpt = get_doap_excerpt(300,1,1);
/*
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
                $exp_pos = 22;
        }
*/
        $theexcerpt = '<p style="line-height:1.2em;text-align:justify;margin-top:.5em;font-family:StagBook;">' . $theexcerpt  . '</p>' . PHP_EOL;
        echo $theexcerpt;

						?>
				</div>

				<?php
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . __( 'Posts not found', 'su' ) . '</h4>';
		}
	?>
</div>
