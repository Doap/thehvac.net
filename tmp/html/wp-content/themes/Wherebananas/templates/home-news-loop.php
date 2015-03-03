<ul class="su-posts su-posts-list-loop">
<?php
// Posts are found

if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {


		$posts->the_post();
		global $post;
?>
                                <div id="su-post-<?php the_ID(); ?>" class="su-post">
                                        <?php if ( has_post_thumbnail() ) : ?>

<div id="homewrap">
	<div style="position:relative;float:left;width:20px;height:20px;left:-15px;">
		<a class="su-post-thumbnail" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft' ) ); ?>
		</a>
	</div>
	<div style="position:relative;top:11px;left:-5px;margin-left:0px;padding-left:0px;margin-right:0px;margin-left:0px;">
		<a title="Titulo: <?php $thetitle = get_the_title(); $thetitle = substr($thetitle,0,190); echo $thetitle; ?>" class="su-post-thumbnail" href="<?php the_permalink(); ?>">
			<?php $thetitle = substr($thetitle,0,75); $thedate = get_the_time( get_option( 'date_format' ) ); $thetime = get_the_time( get_option( 'time_format' ) ); echo $thetitle. ' <span style=font-size:.8em;font-color:#000;><a title="'.$thedate.'"><span style="font-size:.7em;">' . $thetime .'</span></a></span>'; ?>
		</a>
	</div>
</div>
                                        <?php endif; ?>
                                </div>
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
<style>


/* Smartphones (portrait and landscape) ----------- */
@media only screen 
and (min-device-width : 320px) 
and (max-device-width : 480px) {
/* Styles */
#homewrap { position:relative;align:left;height:40px;line-height:.8em;width:100%;color:#000; }
}

/* Smartphones (landscape) ----------- */
@media only screen 
and (min-width : 321px) {
/* Styles */
#homewrap { position:relative;align:left;height:20px;line-height:.8em;width:100%;color:#000; }
}

/* Smartphones (portrait) ----------- */
@media only screen 
and (max-width : 320px) {
/* Styles */
#homewrap { position:relative;align:left;height:40px;line-height:.8em;width:100%;color:#000; }
}

/* iPads (portrait and landscape) ----------- */
@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) {
/* Styles */
#homewrap { position:relative;align:left;height:20px;line-height:.8em;width:100%;color:#000; }
}

/* iPads (landscape) ----------- */
@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) 
and (orientation : landscape) {
/* Styles */
#homewrap { position:relative;align:left;height:20px;line-height:.8em;width:100%;color:#000; }
}

/* iPads (portrait) ----------- */
@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) 
and (orientation : portrait) {
/* Styles */
#homewrap { position:relative;align:left;height:20px;line-height:.8em;width:100%;color:#000; }
}

/* Desktops and laptops ----------- */
@media only screen 
and (min-width : 1224px) {
/* Styles */
#homewrap { position:relative;align:left;height:20px;line-height:.8em;width:100%;color:#000; }
}

/* Large screens ----------- */
@media only screen 
and (min-width : 1824px) {
/* Styles */
#homewrap { position:relative;align:left;height:20px;line-height:.8em;width:100%;color:#000; }
}


/* extra rule for smaller than 700 ----------- */
@media only screen 
and (max-width : 700px) {
/* Styles */
#homewrap { position:relative;align:left;height:40px;line-height:.8em;width:100%;color:#000; }
}

</style>
