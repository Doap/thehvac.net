<ul class="su-posts su-posts-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>
<li id="su-post-<?php the_ID(); ?>" class="su-post"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> (<a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( '0 comments', 'su' ), __( '1 comment', 'su' ), __( '%n comments', 'su' ) ); ?></a>)
</li>
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
</ul>
