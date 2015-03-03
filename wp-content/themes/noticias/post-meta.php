<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post Meta-Data Template-Part File
 *
 * @file           post-meta.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/post-meta.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
$autor_meta = get_post_meta( get_the_ID(), 'autor', true );
/*
$intro_meta = get_post_meta( get_the_ID(), 'intro', true );
if ($intro_meta)
{
        $lines = explode("\n", $intro_meta);
        foreach ($lines as $line)
        {
                $intro .= '<li>' . $line . '</li>';
        }
        $intro = '<ul class="intro">' . $intro . '</ul>';
}
else
{
        $intro = '';
}
*/
if ($autor_meta)
{
	$autor = '<p class="autor">Por: ' . $autor_meta . '</p>';	
}
else
{
$autor ='';
}
?>
<?php
$category = get_the_category();
if ($category[0]->cat_ID == 26704)
{
	$themaincat = $category[1]->cat_ID;
	$single_cat_title = $category[1]->cat_name;
}
else
{
	$themaincat = $category[0]->cat_ID;
	$single_cat_title = $category[0]->cat_name;
}
//$themaincat = $category[0]->cat_ID;
//$single_cat_title = $category[0]->cat_name;

//echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'/"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="twodots"></div></a>[/doap_heading]');

?>


<?php if( is_single() ): ?>
<div id=mobilespacer style="width:100%;height:30px;"></div>
	<div class="antetitulo"><?php echo get_post_meta( get_the_ID(), 'antetitulo', true ); ?></div>

<?php //echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'/"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="twodots"></div></a>[/doap_heading]'); ?>

<?php echo '<div class="single-title">'.get_the_title($ID).'</div>'; ?>

	<?php //echo $intro; ?>
	<?php //echo $autor; ?>
<?php else: ?>

<?php endif; ?>

<div class="post-meta">
<?php $autor_1_value = get_post_meta( get_the_ID(), 'autor', true ); if( ! empty( $autor_1_value ) ) { echo '<span style="position:relative;float:left;margin:10px 0;">Por: '.$autor_1_value.'</span>'; } ?>
	<?php //responsive_pro_posted_on(); ?> 
	<div style="max-width:200px;position:relative;float:right;">
<div style="position:relative;float:right;font-size:.8em;font-family:Arial;"><a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( '0 <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-0.gif" style="max-width:100%;border:0px solid #fff;" alt="">', 'su' ), __( '1 <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-1.gif" style="max-width:100%;border:0px solid #fff;" alt="">', 'su' ), __( '% <img class="thumbnail" src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/05/bubble-2.gif" style="max-width:100%;border:0px solid #fff;" alt="">', 'su' ) ); ?></a></div>



<?php 
	//responsive_pro_posted_by();
	//responsive_pro_comments_link();
	?>
	</div>
</div><!-- end of .post-meta -->
