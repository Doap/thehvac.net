<ul style="list-style: none; margin-left: 0; padding-left: 1em; text-indent: -1em;" class="su-posts su-posts-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>

<li id="su-post-<?php the_ID(); ?>" class="su-post"><img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/Screen-Shot-2014-06-19-at-4.57.23-PM.png" style="max-width:15px;height:10px;" alt="">
<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>


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
