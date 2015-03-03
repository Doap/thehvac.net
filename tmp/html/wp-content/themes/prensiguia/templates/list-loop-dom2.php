<div class="su-posts su-posts-teaser-loop">
<div style="clear:both;"></div>
<?php
		// Posts are found
if ( $posts->have_posts() )
{
	while ( $posts->have_posts() ) 
	{
		$posts->the_post();
		global $post;
		$post_url = get_permalink($post->ID);
		$title = the_title_attribute('echo=0');
		echo '<div style="line-height:1.8em;"><div style="position:relative;float:left;margin-right:10px"><img class="thumbnail" height="12" width="16" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/06/arrow-right.png" style="max-width:100%" alt=""></div><div style="position:relative;" class="su-post-title"><a href="' . $post_url . '"style="font-family:Arial;font-size:.875em;">' . $title . '</a></div></div>';
	}
}
		// Posts not found
?>
</div>
