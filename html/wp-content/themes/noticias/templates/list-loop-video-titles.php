<div style="z-index:10000;position:relative;top:13px;width:100%;height:50px;left:2.5px;">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>

<div style="margin-right:2px;font-size:.85em;line-height:1em;width:93px;height:40px;position:relative;float:left;border-right:4px solid #fff;border-left:4px solid #fff;border-bottom:4px solid #fff;background-color:#fff;" id="su-post-<?php the_ID(); ?>" class="su-post"><a href="<?php the_permalink(); ?>"><?php $thetitle= get_the_title(); echo substr($thetitle ,0,40); ?></a></div>
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
</div>
