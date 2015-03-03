
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>

<?php $edicion = get_the_title(); ?>
<?php $portadalink = get_the_permalink(); ?>
<?php $edicion = '<div style="position:relative;float:left;font-family:StagBook;font-size:1.4em;line-height:1.2em;padding:2px;">Edición No.<br>&nbsp;'.str_replace("Edicion", "", $edicion).'</div>';
echo $edicion;
 ?>
<div style="position:relative;padding-top:4px;padding-right:6px;text-align:right;line-height:1.5em;font-size:1em;">
<a style="color:#fff;" href=<?php echo $portadalink; ?>>Portada</a><br>
<a style="color:#fff;" href=http://noticias.laprensa.com.ni/suplemento/nosotras/moda-nosotras>Moda</a><br>
</div>
<div style="position:relative;float:right;padding-right:6px;text-align:right;line-height:1.5em;font-size:1em;">
<a style="color:#fff;" href=http://noticias.laprensa.com.ni/suplemento/nosotras/editorial-nosotras>Editorial</a><br>
<a style="color:#fff;" href=http://noticias.laprensa.com.ni/tag/belleza>Belleza</a><br>
<a style="color:#fff;" href=http://noticias.laprensa.com.ni/suplemento/nosotras/sal-y-pimienta-nosotras>Sal y Pimienta</a><br>
<a style="color:#fff;" href=http://noticias.laprensa.com.ni/tag/charla>Charla</a><br>
<a style="color:#fff;" href=http://noticias.laprensa.com.ni/suplemento/nosotras/sexualidad-nosotras>Sexualidad</a><br>
<a style="color:#fff;" href=http://noticias.laprensa.com.ni/suplemento/nosotras/consulte-la-ginecologa>Consulte la ginecologa</a><br>
<a style="color:#fff;" href=http://noticias.laprensa.com.ni/suplemento/nosotras/salud-nosotras>Salud</a><br>
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


