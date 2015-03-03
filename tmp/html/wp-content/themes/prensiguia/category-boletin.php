<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Archive Template
 *
 *
 * @file           archive.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.1
 * @filesource     wp-content/themes/responsive/archive.php
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28archive.php.29
 * @since          available since Release 1.0
 */

get_header('boletin');
/*
 ?>
<head><link rel="stylesheet" type="text/css" href="http://laprensa11.doap.us/wp-content/cache/minify/000002/12b6a/default.include.ac69c6.css" media="all">
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Boletin | La Prensa Noticias</title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="http://noticias.laprensa.com.ni/xmlrpc.php"><meta property="og:image" content="http://laprensa19.doap.us/wp-content/uploads/sites/2/2014/04/photo_1652fb43504f870a1c56a38baf61c26391f02cb8-300x207.jpg">
<link rel="alternate" type="application/rss+xml" title="La Prensa Noticias » Feed" href="http://noticias.laprensa.com.ni/feed">
<link rel="alternate" type="application/rss+xml" title="La Prensa Noticias » RSS de los comentarios" href="http://noticias.laprensa.com.ni/comments/feed">
<link rel="shortcut icon" href="http://www.laprensa.com.ni/favicon.ico" type="image/x-icon">
<link rel="alternate" type="application/rss+xml" title="La Prensa Noticias » Boletin RSS de la categoría" href="http://noticias.laprensa.com.ni/boletin/feed">
<link rel="stylesheet" id="jquery-style-css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css" type="text/css" media="all">
<link rel="stylesheet" id="YoutubeFeeder_styles-css" href="http://laprensa11.doap.us/wp-content/plugins/youtube-feeder/css/style.css" type="text/css" media="all">
<link rel="stylesheet" id="responsive-child-style-css" href="http://noticias.laprensa.com.ni/wp-content/themes/noticias/style.css" type="text/css" media="all">
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://noticias.laprensa.com.ni/xmlrpc.php?rsd">
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://laprensa19.doap.us/wp-includes/wlwmanifest.xml">
<meta name="generator" content="WordPress 3.9.1">
</head>
<style>
 .button { background:#05A1F5 ! important; }
</style>
<div id="header">
	<div id="logo-social">
		<div id="logo">
			<a href="http://noticias.laprensa.com.ni/"><img src="http://laprensa15.doap.us/wp-content/uploads/sites/2/2014/06/cropped-laprensa6.png" width="280" height="58" alt="La Prensa Noticias"></a>
		</div>
		<div id="top-social-icons">
			<a href="http://noticias.laprensa.com.ni/lptv"><img class="lptv-thumbnail" src="http://laprensa15.doap.us/wp-content/uploads/sites/2/2014/06/hetlptv1.svg" style="position:relative;margin-right:6px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;" alt=""></a><a href="https://www.facebook.com/laprensanicaragua?ref=hl"><img class="fb-thumbnail" src="http://laprensa18.doap.us/wp-content/uploads/sites/2/2014/06/hefacebook.svg" style="width:30px;height:30px;margin-right:2px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;" alt=""> </a><a href="https://twitter.com/laprensa"> <img class="twitter-thumbnail" src="http://laprensa18.doap.us/wp-content/uploads/sites/2/2014/06/hetwitter.svg" style="width:30px;height:30px;margin-right:2px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;" alt=""> </a><a href="https://www.youtube.com/user/laprensanicaragua1"><img class="g-thumbnail" src="http://laprensa16.doap.us/wp-content/uploads/sites/2/2014/06/hetyoutube.svg" style="width:30px;height:30px;margin-right:4px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;" alt=""></a><a href="http://noticias.laprensa.com.ni/wp-login.php?action=wordpress_social_authenticate&amp;provider=Google&amp;redirect_to=http%3A%2F%2Fnoticias.laprensa.com.ni%2Flogin"><img class="g-thumbnail" src="http://laprensa16.doap.us/wp-content/uploads/sites/2/2014/06/hetgoogle%2B.svg" style="width:30px;height:30px;margin-right:4px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;" alt=""></a><a href="https://www.linkedin.com/company/la-prensa-nicaragua?trk=biz-companies-cym"><img class="g-thumbnail" src="http://laprensa16.doap.us/wp-content/uploads/sites/2/2014/06/hetlinkedin.svg" style="width:30px;height:30px;margin-right:2px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;" alt=""></a>
		</div>
	</div>
</div>

<?php 
*/
responsive_wrapper(); // before wrapper container hook ?>
        <div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>


<?php //echo '<div id="content-archive" style="margin-top:4px;" class="' . implode( ' ', responsive_get_content_classes() ) . '">';
echo '<div id="content-archive" style="margin-top:4px;" class="grid-960">';


$max_posts = 10;
//$category = get_the_category(); 
$themaincat = 26704;
$single_cat_title = 'Boletin'; 
$single_cat_url = strtolower(str_replace(' ', '-', $single_cat_title)); 
$sub_cat_title = 'BOLETIN';
$max_width = 'max-width:100%;';
$extract_chars = 300;
//echo do_shortcode('[doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.strtolower($single_cat_title).'/"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="twodots"></div></a>[/doap_heading]'); 
echo do_shortcode('[doap_animate type="fadeIn"][doap_heading style="modern-1-blue" size="20" align="left" margin="0" class="fp-title-bar"]<a href="http://noticias.laprensa.com.ni/'.$single_cat_url.'"><div class="title-left">'.mb_strtoupper($single_cat_title).'</div><div class="line-container"><div class="line"></div></div></a>[/doap_heading][/doap_animate]');

if ( $paged < 2 )
{
global $wp_query;
$args = array_merge( $wp_query->query_vars, array( 'cat' => $themaincat) );
add_filter('posts_clauses', 'filterEdiciones');
$the_query = new WP_Query( $args );

$even = 0; 
	if( $the_query->have_posts() ) 
	{
		//get_template_part( 'deportes-loop-header' ); 
		while( $the_query->have_posts() && $even < $max_posts )
		{ 
			$the_query->the_post();

//var_dump($query);
$even++;
//$float='left';
echo '<div style="clear:both;"></div>';
if ($paged > 1 && $even == 1)
{
	$story_pre = '<div class="su-column su-column-size-2-3" style="width:420px;margin: 0px 0px 0px 0px;position:relative;float:left;"><div class="su-column-inner su-clearfix"></div>';
	echo $story_pre;
}
//var_dump($the_query);
//echo do_shortcode('[doap_slider source="category: '.$themaincat.'" limit="1"  autoplay="0" arrows="no" width="640" height="360" link="post" mousewheel="no" pages="no" class="deportes-slider"]');
if ($even == 6)
{
?>
<div style="width:100%">
<div class="publicidad"  style='color:white; font-size:20px; background:white; width:640px; height:125px; padding:0; font-family:"Times New Roman",Times,serif; margin:10px auto; '>
<!-- AdSpeed.com Serving Code 7.9.5 for [Zone] boletin 640x120 -->
<a href="http://g.adspeed.net/ad.php?do=clk&zid=57345&wd=640&ht=120&pair=asemail" target="_top"><img style="border:0px;" src="http://g.adspeed.net/ad.php?do=img&zid=57345&wd=640&ht=120&pair=asemail" alt="i" width="640" height="120"/></a><!-- 
AdSpeed.com End -->
</div></div>
<?php
}
include(STYLESHEETPATH . '/templates/cat-mini.php');
echo '<hr>';
		}
	}
}
?>

<div style="clear:both;"></div>
<div style="width:100%">
<div class="publicidad" style="display:block; color:white; font-size:20px; background:white; width:640px; height:125px; padding:0; font-family:Serif; margin:10px auto !important; ">


<!-- AdSpeed.com Serving Code 7.9.5 for [Zone] boletin_2 640x120 --><a href="http://g.adspeed.net/ad.php?do=clk&zid=57391&wd=640&ht=120&pair=asemail" 

target="_top"><img style="border:0px;" src="http://g.adspeed.net/ad.php?do=img&zid=57391&wd=640&ht=120&pair=asemail" alt="i" width="640" height="120"/></a><!-- 

AdSpeed.com End -->
                           
</div></div>
<div style="clear:both;"></div>
</div><!-- end of #content-archive -->
<div id="footer" class="clearfix">
	<div id="footer-wrapper">
		<div id="footer-widget" class="grid col-940">
			<div id="footer_widget" class="grid col-940">
				<div id="text-2" class="colophon-widget widget-wrapper widget_text">
					<div class="textwidget"><div class="lp-sprite-v8logofooter2-1x" style="margin-top:10px;"></div><br>
EDITORIAL LA PRENSA, S.A. <br>
Km. 4½ Carretera Norte, Managua, Nicaragua<br>
Apartado Postal #192<br>
PBX (505) 2255-6767<br>
FAX (505) 2255-6780 ext. 5369<br>
Información: info@laprensa.com.ni
					</div>
				</div>
			</div>
		<div class="grid col-300 copyright">
			© 2014<a href="http://noticias.laprensa.com.ni/" title="La Prensa Noticias">
				La Prensa Noticias			</a>
		</div>
		<!-- end of .copyright -->

		<div class="grid col-300 fit powered">
			<a href="http://doap.com/" title="Responsive Theme hosted by Doap.com">
				La Prensa</a>
			Funciona con <a href="http://doap.com/" title=" doap.com">
				DevOps and Platforms</a>
		</div>
		<!-- end .powered -->

		</div>
	<!-- end #footer-wrapper -->
	</div>
</body>
</html>

<?php //my_pagination(); ?>
<?php //get_sidebar('cartelera-del-cine'); ?>
<?php //echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>


<?php //echo do_shortcode('[xyz-ips snippet="promociones-video-widget"]'); ?>
<?php //get_footer(); ?>
