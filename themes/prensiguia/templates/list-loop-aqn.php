<p class="su-posts su-posts-list-loop" style="margin-left:5px;position:relative;top:-15px;">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>

<span style="margin-left:5px;padding-left:0px;font-size:.80em;line-height:.7em;" id="su-post-<?php the_ID(); ?>" class="su-post"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span><br>


<?php
	}
}
// Posts not found
else {
?>
<li><?php _e( 'Posts not found', 'su' ) ?></li>
<?php
}
?>
</p>
