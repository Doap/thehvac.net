<div class="su-posts su-posts-teaser-loop" style="border:0px solid #fff;width:100%;margin-top:20px;">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				$feat_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'center-top-300x300' );
        			$feat_image = $feat_image_array[0];
        			$title = the_title_attribute('echo=0');
        			$post_url = get_permalink($post->ID);
				?>
		<div id="su-post-<?php the_ID(); ?>" class="su-post" style="border: 1px solid #ccc;margin-bottom:10px;width:300px;float:left;margin-left:4px;margin-right:4px;">
			<?php if ( has_post_thumbnail() ) : ?>
				<div style="position:relative;max-width:300px;margin-top:0px;margin-bottom:0px;align:left;">
					<a class="doap-post-thumbnail" href="<?php the_permalink(); ?>"><?php  echo '<img src="' . $feat_image . '">'; ?></a>
				</div>
			<?php endif; ?>


 <?php
       echo do_shortcode('<div class="destacados-titles" style="padding:4px;max-width:90%;margin-top:4px;"><span class="tcpf"><a href="' . $post_url . '"><div style="position: relative; top: -10px;">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="15" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/deportes">'.$title.'</a>[/doap_heading][/doap_animate]</div></a></span></div>' . PHP_EOL);
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
?>

<div style="position:relative;float:right;font-size:.8em;font-family:Arial;">(<a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( '0 <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt="">', 'su' ), __( '1 <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt="">', 'su' ), __( '% <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-2.gif" style="max-width:100%;border:0px solid #fff;" alt="">', 'su' ) ); ?></a>)</div>


<?php
        echo get_the_term_list( $post->ID, 'post_tag', 'Etiquetas: ', ', ', '' );
        echo '</div>' . PHP_EOL;
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
