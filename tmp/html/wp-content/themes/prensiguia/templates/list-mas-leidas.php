<?php 
date_default_timezone_set('America/Managua'); 
//echo do_shortcode('<div id="tiendatitle">[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="15" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/tienda">Noticias Más leídas</a>[/doap_heading][/doap_animate]</div> '); ?>

<ul class="su-posts su-posts-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>

<li id="su-post-<?php the_ID(); ?>" class="su-post">

<div style="width:100%;">
<div style="position:relative;float:right;font-size:.8em;font-family:Arial;">(<a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( '0 <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt="">', 'su' ), __( '1 <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt="">', 'su' ), __( '% <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-2.gif" style="max-width:100%;border:0px solid #fff;" alt="">', 'su' ) ); ?></a>)</div>
<?php $thelink = get_the_permalink(); 
      $thetitle = get_the_title();
      $thetime = "<div style=color:#369;padding-left:3px;padding-right:3px;background-color:#fff;position:relative;float:right;font-family:Arial;> ".get_the_date()." ".get_the_time('g:i a')."</div>";
      $thecleantitle = get_the_title();
      $theexcerpt = $thetime." <h5>".$thetitle."</h5>".htmlentities(strip_tags(get_the_excerpt()), ENT_QUOTES, 'UTF-8');
?>
<div style="max-width:330px;">
<a href="<?php the_permalink(); ?>">
	<?php echo do_shortcode('[doap_tooltip style="tipsy" position="north" shadow="yes" rounded="yes" size="3" content="'. $theexcerpt .'" class="todays-news"]'. $thetitle .'[/doap_tooltip]'); ?>
</a></div></div>

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
