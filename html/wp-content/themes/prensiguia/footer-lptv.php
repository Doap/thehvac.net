<?php

// Exit if accessed directly

if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Footer Template
 *
 *
 * @file           footer.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.2
 * @filesource     wp-content/themes/responsive/footer.php
 * @link           http://codex.wordpress.org/Theme_Development#Footer_.28footer.php.29
 * @since          available since Release 1.0
 */

/* 
 * Globalize Theme options
 */
global $responsive_options;
$responsive_options = responsive_get_options();
?>
<?php responsive_wrapper_bottom(); // after wrapper content hook ?>
</div><!-- end of #wrapper -->
<?php responsive_wrapper_end(); // after wrapper hook ?>
</div><!-- end of #container -->
<?php responsive_container_end(); // after container hook ?>

<div id="footer" class="clearfix">
	<?php //responsive_footer_top(); ?>

	<div id="footer-wrapper" style="border:0px solid #fff;">

			<div class="grid col-300" style="border:0px solid #aaa;">
			<div style="width:220px;border:0px solid #eee;font-size:1.4em;">
<p><b>@2014 LA PRENSA TV </b><br>
El Canal de los nicaraguenses <br>
Grupo Editorial LA PRENSA<br>
Todos los derechos reservados</p>
</div>
				<?php //get_sidebar( 'lptv-footer' ); ?>
			</div>

			<div class="grid col-300" id="lptvfootertagcloud" style="border:0px solid #aaa;">
				<h4 id="lptvfootertagcloudtitle">ETIQUETAS</h4>
				<div><?php wp_tag_cloud('number=8&smallest=10&largest=10;'); ?></div>
				<?php //echo news_get_social_icons() ?>
			</div>

			<div class="grid col-220 fit" style="border:0px solid #fff;max-height:100px;">
				<?php //echo news_get_social_icons() ?>
				<?php get_sidebar( 'lptv-footer' ); ?>
			</div>
			
<?php //echo do_shortcode('[loggedout]<a href=/login/>[wordpress_social_login]</a>[/loggedout]'); ?>
<?php //echo do_shortcode('[loggedin]<a href=/login/>[logout]</a>[/loggedin]'); ?>

	</div>
	<?php responsive_footer_bottom(); ?>
</div>
<!-- end #footer -->
<?php //responsive_footer_after(); ?>

<?php wp_footer(); ?>
<?php include(STYLESHEETPATH . '/server-info.php'); ?>

<style>
#footer {
	max-width: 100%;
	background: url(/wp-content/uploads/sites/2/2014/06/footerlptv.svg);
}

#footer-wrapper {
	margin: 0 auto;
	max-width: 960px;
}
</style>
</body>

</html>
