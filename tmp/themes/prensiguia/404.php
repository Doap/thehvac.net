<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Error 404 Template
 *
 *
 * @file           404.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/404.php
 * @link           http://codex.wordpress.org/Creating_an_Error_404_Page
 * @since          available since Release 1.0
 */
?>
<?php get_header(); ?>
<script type='text/javascript'>
googletag.cmd.push(function() {
    
/* home slots */
googletag.defineSlot('/11648707/Portada-Bottom-300x250px', [300, 250], 'div-gpt-ad-1403198971774-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Top-728x90', [728, 90], 'div-gpt-ad-1403199951031-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Top-270x90', [270, 90], 'div-gpt-ad-1403223429448-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Top-300x250px', [300, 250], 'div-gpt-ad-1403198971774-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Bottom-728x90', [728, 90], 'div-gpt-ad-1403199951031-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Left-160x600', [160, 600], 'div-gpt-ad-1403200779714-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Right-160x600', [160, 600], 'div-gpt-ad-1403200779714-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-Middle-728x90', [728, 90], 'div-gpt-ad-1403199951031-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/120x600-Top', [120, 600], 'div-gpt-ad-1403371468819-0').addService(googletag.pubads());

/* botones 1-5 sidebar slots */
googletag.defineSlot('/11648707/Portada-boton-1-300x120', [300, 120], 'div-gpt-ad-1403222233029-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-2-300x120', [300, 120], 'div-gpt-ad-1403222233029-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-3-300x120', [300, 120], 'div-gpt-ad-1403222233029-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-4-300x120', [300, 120], 'div-gpt-ad-1403222233029-3').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-5-300x120', [300, 120], 'div-gpt-ad-1403222233029-4').addService(googletag.pubads());

googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>

<?php global  $wpdb; $user_id = get_current_user_id(); $qry = "SELECT identifier, websiteurl, email FROM `wp_2_wslusersprofiles` WHERE user_id = '$user_id' && provider = 'Google' && identifier IS NOT NULL && websiteurl = 'http://doap.com'"; $avalidgoogleid = $wpdb->get_results( $qry ); foreach ( $avalidgoogleid as $avalidgoogleid ) { $gid = $avalidgoogleid ->identifier; $uemail  = $avalidgoogleid ->email; $websiteurl = $avalidgoogleid ->websiteurl; }
 ?>

<?php
if ($gid > 10000000 )  {
        include(STYLESHEETPATH . '/page-wing-ads-loggedin.php');
        include(STYLESHEETPATH . '/backpages-top-loggedin.php');
} else {
        include(STYLESHEETPATH . '/page-wing-ads.php');
        include(STYLESHEETPATH . '/banner-ad-widget-728x90.php');
        include(STYLESHEETPATH . '/banner-ad-widget-270x90.php');
}

responsive_wrapper(); // before wrapper container hook 
echo '<div id="wrapper" class="clearfix">';
responsive_wrapper_top(); // before wrapper content hook 
responsive_in_wrapper(); // wrapper hook 
?>

<div style="clear:both;"></div>

<div id="content-full" class="grid col-940">
<center>
<div width="100%" class="aligncenter">404
<?php
 $monthnum = get_query_var('monthnum');
 $day_of_month = get_query_var('day');
 $_year = get_query_var('year');

$looked_for = $day_of_month.'-'.$monthnum.'-'.$_year;
if (isset($_GET['day'])) {
echo '<h2>¿Ha buscado una fecha en el futuro? </h2><P>'.$looked_for.'</p><p>Utilice el selector de fecha a continuación para volver a intentarlo.</p><hr>';
} else {
echo '<h2>¿Ha buscado algo no encontramos.</h2>'; ?>
<div style="width:70%;background-color:#fff;position:relative;float:left;padding-left:20px;padding-right:20px;;margin:0px;height:50px;"> <?php get_search_form(); ?> </div>

<?php echo do_shortcode('[doap_spacer size="10"]
<div style=max-width:500px;text-align:left;font-size:1.4em;>[doap_tabs class="my-custom-tabs"]
[doap_tab title="Ultima Hora"]
[doap_box title="Ultima Hora" style="soft" box_color="#fff" title_color="#000" radius="0" class="archivo-aside"]

[doap_posts template="templates/list-loop.php" posts_per_page="12" tax_term="17,3132" tax_operator="0" author="1,102,108,113,114,116,117,103,111,118,112,110,107,115,120,106,104,105,119,109" offset="5" order="desc" orderby="date" post_parent=" "]

[/doap_box]
[/doap_tab]

[doap_tab title="Mas Leidas"]

[doap_box title="Mas Leidas" style="soft" box_color="#fff" title_color="#000" radius="0" class="archivo-aside"]
[doap_posts template="templates/list-loop.php" posts_per_page="12" tax_term="17,3132" tax_operator="0" author="1,102,108,113,114,116,117,103,111,118,112,110,107,115,120,106,104,105,119,109" offset="5" order="desc" orderby="comment_count" post_parent=" "]
[/doap_box]
[/doap_tab]
[/doap_tabs]</div>'); ?>


<?php }
//echo '<div style="height:100px;width:100%;"></div>';

//$orderdate = explode('-', $orderdate);

//$archive_month = $orderdate[0];
$archive_month = $monthnum;
//$archive_day   = $orderdate[1];
$archive_day   = $day_of_month;;
//$archive_year  = $orderdate[2];
$archive_year  = $_year;
?>

<div class="linkstrips">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 468x15centerofpage -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:15px"
     data-ad-client="ca-pub-6970273280466483"
     data-ad-slot="6581025868"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

	<?php responsive_entry_before(); ?>
	<div id="post-0" class="error404">
		<?php responsive_entry_top(); ?>

		<div class="post-entry">
<div style="position:relative;float:left;margin-right:20px;top:-20px;width:100%">

<?php //echo get_day_link( $year, $month, $day ); ?>
<hr>
<h5>Ediciones Anteriores</h5>

<form method="get" action="<?php echo home_url( '/' ); ?>">
   Dia: <select name="day" title="dia">
    <?php foreach( range(31,1) as $day_of_month ) : ?>
<?php if (isset($archive_day) && $archive_day == $day_of_month) { ?>
        <option selected><?php echo $day_of_month; ?></option>
<?php } else { ?>
        <option><?php echo $day_of_month; ?></option>
<?php } ?>
    <?php endforeach; ?>
    </select>
    Mes:<select name="monthnum" title="mes">
    <?php foreach( range(1,12) as $month_of_year ) : ?>

<?php if (isset($archive_month) && $archive_month == $month_of_year) { ?>
        <option selected><?php echo $month_of_year; ?></option>
<?php } else { ?>
        <option><?php echo $month_of_year; ?></option>
<?php } ?>



    <?php endforeach; ?>
    </select>
    Ano:<select name="year" title="ano">
    <?php foreach( range(2014,2000) as $_year ) : ?>


<?php if (isset($archive_year) && $archive_year == $_year) { ?>
        <option selected><?php echo $_year; ?></option>

<?php } else { ?>
        <option><?php echo $_year; ?></option>

<?php } ?>


    <?php endforeach; ?>
    </select>
    <input type="submit" id="searchsubmit" value="Ir" />
</form>
</div>

</center></div>
			<?php //get_template_part( 'loop-no-posts' ); ?>

		</div>
		<!-- end of .post-entry -->

		<?php responsive_entry_bottom(); ?>
	</div>
	<!-- end of #post-0 -->
	<?php responsive_entry_after(); ?>

</div><!-- end of #content-full -->
<?php echo do_shortcode('[doap_divider text="Volver a la parte superior de la página"]'); ?>
<?php //echo do_shortcode('[xyz-ips snippet="promociones-video-widget"]'); ?>
<?php get_footer(); ?>
