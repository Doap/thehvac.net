<ul>
<?php
// Posts are found

if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {


		$posts->the_post();
		global $post;
		$thetitle = get_the_title();
		$thetitle = substr($thetitle,0,190);
		$thetitle = substr($thetitle,0,75); 
		$thedate = get_the_time( get_option( 'date_format' ) ); 
		$thetime = get_the_time( get_option( 'time_format' ) );
?>
<li>	
		<a style="font-family:Tahoma;font-size:.8em;" title="<?php echo $thetitle. ' ::' .$thedate. ' : ' .$thetime; ?>" class="su-post-thumbnail" href="<?php the_permalink(); ?>">
			<?php echo $thetitle. ' <span class="titlejazz"><a title="'.$thedate.'"><span class="timejazz">' . $thetime .'</span></a></span>'; ?>
		</a>
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
<style>
.timejazz { font-size:.8em; }
.titlejazz { font-size:.8em;font-color:#000; }
a { text-decoration:none; }
/* unvisited link */
a:link {
    color: #106d12;
}

/* visited link */
a:visited {
    color: #000;
}

/* mouse over link */
a:hover {
    color: #000000;
}

/* selected link */
a:active {
    color: #106d12;
}


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

<style>
a:-webkit-any-link {
text-decoration: none;
}
</style>
