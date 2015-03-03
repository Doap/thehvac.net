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
googletag.defineSlot('/11648707/Magazine-La-Prensa-300x154', [300, 154], 'div-gpt-ad-1405637254332-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-2-300x120', [300, 120], 'div-gpt-ad-1403222233029-1').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-3-300x120', [300, 120], 'div-gpt-ad-1403222233029-2').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-4-300x120', [300, 120], 'div-gpt-ad-1403222233029-3').addService(googletag.pubads());
googletag.defineSlot('/11648707/Portada-boton-5-300x120', [300, 120], 'div-gpt-ad-1403222233029-4').addService(googletag.pubads());
/* marcador slots */
googletag.defineSlot('/11648707/Marcador-Portada-529x70', [529, 70], 'div-gpt-ad-1403883993058-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Marcador-Superior-Portada-280x34', [280, 34], 'div-gpt-ad-1404234613796-0').addService(googletag.pubads());
googletag.defineSlot('/11648707/Marcador-Inferior-Portada-280x34', [280, 34], 'div-gpt-ad-1404234613796-1').addService(googletag.pubads());
/* magazine slot */
googletag.defineSlot('/11648707/Inicio-731x137-Autopromocion', [731, 137], 'div-gpt-ad-1407164809343-0').addService(googletag.pubads());
googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>
<?php
global  $wpdb; $user_id = get_current_user_id(); $qry = "SELECT identifier, websiteurl, email FROM `wp_2_wslusersprofiles` WHERE user_id = '$user_id' && provider = 'Google' && identifier IS NOT NULL && websiteurl = 'http://doap.com'"; $avalidgoogleid = $wpdb->get_results( $qry ); foreach ( $avalidgoogleid as $avalidgoogleid ) { $gid = $avalidgoogleid ->identifier; $uemail  = $avalidgoogleid ->email; $websiteurl = $avalidgoogleid ->websiteurl; }
?>
<?php
if ($gid > 10000000 )  {
        include(STYLESHEETPATH . '/page-wing-ads-loggedin.php');
        include(STYLESHEETPATH . '/top-loggedin.php');
} else {
        include(STYLESHEETPATH . '/page-wing-ads.php');
        include(STYLESHEETPATH . '/banner-ad-widget-home-728x90.php');
        include(STYLESHEETPATH . '/banner-ad-widget-home-270x90.php');
}

?>

