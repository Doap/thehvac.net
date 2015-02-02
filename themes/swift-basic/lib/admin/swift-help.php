<div class="swift-wrap clearfix">
	<?php
Swift_admin_header();
?>

	<style>
.ui-tabs .ui-tabs-nav,div.wrap {
	background: none
}

div.swift-wrap {
	font: sans-serif 12px/2em !important;
	background: none
}

#Swift-help {
	padding: 60px 60px 100px !important;
	line-height: 1.625em !important;
}

#Swift-help h1 {
	font-size: 2em;
	padding: .75em 0 .5em;
	color: #2c749f
}

#Swift-help p {
	margin-bottom: 1em;
	line-height: 1.625em !important
}

#Swift-help ol {
	margin: 0 0 1em 3em;
	line-height: 1.625em
}

#Swift-help ol li {
	margin: .5em 0
}

#Swift-help em {
	font-style: italic
}

#Swift-help strong {
	font-style: bold
}

#Swift-help abbr {
	border-bottom: 1px dashed #2c749f;
}
</style>
	<div id="Swift-help">
		<div
			style="padding: 20px 20px 10px; font-size: 14px; line-height: 1.8em; margin-bottom: 40px;"
			class="clearfix alert alert-info">
			<p class="alignleft">
				<?php printf ( __( 'Thank you for choosing Swift. One of our goals while building this new version of Swift was to make the options as intuitive and easy to use as possible, and we think we did a decent job. However, after working for several days on the same theme, one loses the perspective of a typical user and things might not be as straightforward and intuitive as we thought. If you are having trouble figuring out what a particular option does, if the option description is misleading, or if you can&#8217;t find something, please post about it in the %sforums%s and we will get back to you ASAP. You can login to the forums with the same username and password used on the shop.', 'swift' ), '<a href="http://swiftthemes.com/forums/">', '</a>'); ?>
			</p>
			<div class="alignright" style="text-align: right; margin-top: -10px">
				<em><?php _e( 'Lets make Swift the best WordPress theme', 'swift' ); ?><br>
					<strong style="font-size: 24px">&ndash; <a
						style="text-decoration: none" href="http://SatishGandham.Com">Satish
							Gandham</a>
				</strong>
				</em>
			</div>
		</div>
		<h1>
			<?php _e( 'Don&#8217;t panic', 'swift' ); ?>
		</h1>
		<p>
			<?php printf( __( 'Should anything go wrong, even in a worst case scenario simply delete your latest Swift theme update and activate your previous theme. Your blog will be reset back to the state prior to the Swift update. %sSwift never deletes your posts, messes with your database, or otherwise makes changes to your underlying system%s.', 'swift' ), '<strong>', '</strong>' ); ?>
		</p>

		<h1>
			<?php _e( 'Have enough content to play with', 'swift' ); ?>
		</h1>
		<p>
			<?php printf( __( 'Don&#8217;t start customizing Swift on a fresh install,  have at least 10 posts (15 recommended) before customizing the theme. If you are trying Swift on a local server or a test site, you can %sdownload test data%s and import it to your test site.', 'swift' ), '<a title="'.__( 'Download WordPress test data', 'swift' ).'" href="http://codex.wordpress.org/Theme_Unit_Test">', '</a>' ); ?>
		</p>

		<h1>
			<?php _e( 'Investigate all the options', 'swift' ); ?>
		</h1>
		<p>
			<?php _e( 'Please go through all the options once to make the best use of Swift. Everything you need is included and thoughtfully organized, and we included inline documentation wherever necessary. If you can&#8217;t find something, or if you found it after lots of searching, please drop us an e-mail. We will make sure that others won&#8217;t have such problems in future.', 'swift' ); ?>
		</p>

		<h1>
			<?php _e( 'After theme install&hellip;', 'swift' ); ?>
		</h1>
		<p>
			<?php _e( 'After you install the theme:', 'swift' ); ?>
		</p>
		<ol>
			<li><?php printf( __( 'Swift has %d menu locations: %s. Set them up at %s.', 'swift' ), 3, __( 'Above logo, Below logo and Footer links', 'swift' ), '<em><a href="nav-menus.php">'.__( 'Appearance', 'default' ).' &rarr; '.__( 'Menus', 'default' ).'</a></em>' ); ?>
			</li>
			<li><?php printf( __( 'Use the "%s" option in your posts for thumbnails to appear. If you are coming from a theme which doesn&#8217;t use featured images, install the %s plugin and generate post thumbnails. Installing the plugin is not enough, you have to go to %s and click %s.', 'swift' ), __( 'Set featured image', 'default' ), '<a href="http://wordpress.org/extend/plugins/auto-post-thumbnail/">Auto Post Thumbnail</a>', '<em><a href="options-general.php?page=generate-post-thumbnails">'.__( 'Settings', 'default' ).' &rarr; Auto Post Thumbnails</a></em>', '<strong>Generate Thumbnails</strong>' ); ?>
			</li>
		</ol>

		<h1>
			<?php _e( 'After theme update&hellip;', 'swift' ); ?>
		</h1>
		<p>
			<?php printf( __( 'After you update the theme, please go to %1$s page and %2$shit the \'%3$s\' button%4$s. This generates new CSS and JS files required for the current version.', 'swift' ), '<em><a href="admin.php?page=swift-options">'.__( 'Swift Options', 'swift' ).'</a></em>', '<strong>', __( 'Save changes', 'swift' ), '</strong>' ); ?>
		</p>
		<p>
			<?php printf( __( 'Go to %s and reassign your menus to the correct theme location.', 'swift' ), '<em><a href="nav-menus.php">'.__( 'Appearance', 'default' ).' &rarr; '.__( 'Menus', 'default' ).'</a></em>' ); ?>
		</p>

		<h1>
			<?php _e( 'Disable caching and minify plugins', 'swift' ); ?>
		</h1>
		<p>
			<?php _e( 'For a smooth customization, disable caching and minify plugins while you are customizing the theme. We advice you to disable caching for logged in users.', 'swift' ); ?>
		</p>
		<p>
			<?php _e( 'Sometimes the browser cache is not cleared even after a hard refresh. If your changes are not reflected on the site, clear the browser cache manually and check again.', 'swift' ); ?>
		</p>
		<p>
			<strong><?php _e( 'Reload the site for the changes made in design options to be reflected.', 'swift' ); ?>
			</strong>
		</p>

		<h1>
			<?php _e( 'Debugging', 'swift' ); ?>
		</h1>
		<p>
			<?php _e( 'If something doesn&#8217;t work the way it should, please don&#8217;t blame the theme straight away. Follow the steps below to help track down the cause of your problem.', 'swift' ); ?>
		</p>
		<ol>
			<li><?php _e( 'Deactivate all plugins and check if that solves the problem. Remember, WordPress has an option to bulk deactivate all plugins.', 'swift' ); ?>
			</li>
			<li><?php printf( __( '%sSwitch to the default Twenty Eleven theme%s and see if the problem persists.', 'swift' ), '<a href="themes.php">', '</a>'); ?>
			</li>
		</ol>
		<p>
			<?php printf( __( 'If you are still having problems it might be something to do with the Swift theme, or with something else entirely. Please go to the %sSwift forums%s and do a search for possible solutions already found and provided by other users or by the Swift support staff. Next, post your problem on the %sSwift support forum%s. Remember, a clear and concise subject line and explanation assists the Swift tech support to help you ASAP. Further, it may catch the attention of other Swift users who have experienced and resolved the same challenge as you. Our Forums are a community!', 'swift' ), '<a href="http://swiftthemes.com/forums/">', '</a>', '<a href="http://swiftthemes.com/forums/forumdisplay.php?3-Support">', '</a>' ); ?>
		</p>

		<h1>
			<?php _e( 'Some useful features in Swift', 'swift' ); ?>
		</h1>
		<p>
			<?php _e( 'There are some awesome features in Swift, which are easy to miss. Here is list of them:', 'swift' ); ?>
		</p>
		<ol>
			<li><?php printf( __( 'Swift has %s handy widgets. Go to %s to find them.', 'swift' ), '<strong>6</strong>', '<em><a href="widgets.php">'.__( 'Appearance', 'default' ).' &rarr; '.__( 'Widgets', 'default' ).'</a></em>' ); ?>
			</li>
			<li><?php printf( __( 'When you are editing a post in the visual editor, there is an %s icon. Click it to use Swift\'s built in shortcodes.', 'swift' ), '<span style="color:#2c749f;">&#8220;S&#8221;</span>' ); ?>
			</li>
			<li><?php printf( __( 'There are %s menu locations in Swift: %s. Go to %s to set them.', 'swift' ), '<strong>3</strong>', __( 'Above logo, Below logo and Footer links', 'swift' ), '<em><a href="nav-menus.php">'.__( 'Appearance', 'default' ).' &rarr; '.__( 'Menus', 'default' ).'</a></em>' ); ?>
			</li>
			<li><?php printf( __( 'There are %s page templates included in Swift. They come in handy while using WordPress as a %sCMS%s.', 'swift' ), '<strong>6</strong>', '<abbr title="'.__( 'Content Management System', 'swift' ).'">', '</abbr>' ); ?>
			</li>
			<li><?php printf( __( 'You can configure what goes above and below the post title in single posts/pages: %s.', 'swift' ), '<em><a href="admin.php?page=swift-options#post-meta">'.__( 'Swift Options', 'swift' ).' &rarr; '.__( 'Single post options', 'swift' ).'</a></em>' ); ?>
			</li>
			<li><?php printf( __( 'Swift includes support for %sGoogle Authorship Markup%s. Go to %s and update your %s.', 'swift' ), '<a href="http://support.google.com/webmasters/bin/answer.py?answer=1408986">', '</a>', '<em><a href="profile.php">'.__( 'Users', 'default' ).' &rarr; '.__( 'Your Profile', 'default' ).'</a></em>', '<em>'.__( 'Google+ Profile URL', 'swift').'</em>' ); ?>
			</li>
			<li><?php printf( __( 'Social share buttons are included in Swift. Use them instead of a plugin and reduce the page and server load: %s.', 'swift' ), '<em><a href="admin.php?page=swift-options#social-media">'.__( 'Swift Options', 'swift' ).' &rarr; '.__( 'Social media', 'swift' ).'</a></em>' ); ?>
			</li>
		</ol>

		<h1>
			<?php _e( 'Recommended plugins', 'swift' ); ?>
		</h1>
		<p>
			<?php printf( __( 'We recommend the use of the following plugins for best results in terms of speed and %sSEO%s:', 'swift' ), '<abbr title="'.__( 'Search Engine Optimization', 'swift' ).'">', '</abbr>' ); ?>
		</p>
		<ol>
			<li><?php printf( __( '%s for %sSEO%s purposes and breadcrumbs functionality.', 'swift' ), '<a href="http://wordpress.org/extend/plugins/wordpress-seo/">WordPress SEO by Yoast</a>', '<abbr title="'.__( 'Search Engine Optimization', 'swift' ).'">', '</abbr>' ); ?>
			</li>
			<li><?php printf( __( '%s for caching, including full support for %s, %s, %s and other %sCDNs%s.', 'swift' ), '<a href="http://wordpress.org/extend/plugins/w3-total-cache/">W3 Total Cache</a>', '<a href="https://www.cloudflare.com/">CloudFlare</a>', '<a href="http://aws.amazon.com/cloudfront/">Amazon CloudFront</a>', '<a href="http://www.maxcdn.com/">Max CDN</a>', '<abbr title="'.__( 'Content Delivery Networks', 'swift' ).'">', '</abbr>' ); ?>
			</li>
			<li><?php printf( __( '%s for related posts functionality.', 'swift' ), '<a href="http://wordpress.org/extend/plugins/yet-another-related-posts-plugin/">Yet Another Related Posts Plugin (YARPP)</a>' ); ?>
			</li>
			<li><?php printf( __( '%s for a long list of additional sharing buttons (or if you don\'t want to use Swift\'s built in ones).', 'swift' ), '<a href="http://wordpress.org/extend/plugins/addthis/">AddThis</a>' ); ?>
			</li>
		</ol>
		<p>
			<?php printf( __( '%sNote%s: If you are using %s, go to %s, uncheck \'%s\' and check \'%s\'.', 'swift' ), '<strong>', '</strong>', 'YARPP', '<em><a href="options-general.php?page=yarpp">'.__( 'Settings', 'default' ).' &rarr; '.__( 'Related Posts (YARPP)' , 'yarpp' ).'</a></em>', __( 'Automatically display related posts?', 'yarpp'), __( 'Display using a custom template file', 'yarpp' ) ); ?>
		</p>

		<h1>
			<?php _e( 'Plugins to avoid', 'swift' ); ?>
		</h1>
		<ol>
			<li><?php printf( __( '%sPage navigation%s. This functionality is included in Swift by default.', 'swift' ), '<strong>', '</strong>' ); ?>
			</li>
			<li><?php printf( __( '%sBreadcrumbs%s. Swift has built-in support for %s\'s breadcrumbs. If you have it installed, simply enable the breadcrumbs functionality in %s.', 'swift' ), '<strong>', '</strong>', '<a href="http://wordpress.org/extend/plugins/wordpress-seo/">WordPress SEO by Yoast</a>', '<em><a href="admin.php?page=wpseo_internal-links">'.__( 'SEO', 'wordpress-seo' ).' &rarr; '.__( 'Internal Links', 'wordpress-seo' ).'</a></em>' ); ?>
			</li>
			<li><?php printf( __( '%sShortcodes%s. Swift has a full set of shortcodes. Click the %s icon in the visual editor to use them.', 'swift' ), '<strong>', '</strong>', '<span style="color:#2c749f;">&#8220;S&#8221;</span>' ); ?>
			</li>
			<li><?php printf( __( '%sAd managers%s. Swift has a very well implemented ad management system with all the features you actually need. Go to %s and configure it.', 'swift' ), '<strong>', '</strong>', '<em><a href="admin.php?page=swift-options#ad-management">'.__( 'Swift Options', 'swift' ).' &rarr; '.__( 'AD management', 'swift' ).'</a></em>'); ?>
			</li>
			<li><?php printf( __( '%sPopular/Random Posts%s. Swift provides these and many other widgets. Go to %s to find them.', 'swift' ), '<strong>', '</strong>', '<em><a href="widgets.php">'.__( 'Appearance', 'default' ).' &rarr; '.__( 'Widgets', 'default' ).'</a></em>' ); ?>
			</li>
		</ol>

		<h1>
			<?php _e( 'To get 90+ page speed score&hellip;', 'swift' ); ?>
		</h1>
		<p>
			<?php _e( 'Finally, to get a 90+ page speed score and better rankings, follow the optimization tips on this page:', 'swift' ); ?>
			</br> <a
				href="http://swiftthemes.com/2011/05/tutorials/how-to-get-90-google-page-speed-with-swiftpremium/"><?php _e( 'How to get 90+ google page speed with SwiftPremium', 'swift' ); ?>
			</a>
		</p>
		<br /> <br />
		<p style="text-align: center">
			<?php printf( __( 'If you find the optimization guide complicated, I can do the optimization for you for %s:', 'swift' ), '$49' ); ?>
		</p>
		<form method="post" action="https://www.paypal.com/cgi-bin/webscr"
			style="width: 180px;" class="aligncenter">
			<input type="hidden" value="_s-xclick" name="cmd" /> <input
				type="hidden" value="SAVR6MABLJSBY" name="hosted_button_id" /> <input
				type="image"
				alt="<?php esc_attr_e( 'PayPal - The safer, easier way to pay online.', 'swift' ); ?>"
				src="https://www.paypalobjects.com/en_GB/i/btn/btn_buynowCC_LG.gif"
				name="submit" /> <img width="1" height="1" border="0" alt=""
				src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" />
		</form>
		<p style="text-align: center">
			<?php printf( __( 'Your payment will be refunded if you don\'t get a %s90+ page speed score%s!', 'swift' ), '<a href="https://developers.google.com/speed/pagespeed/insights">', '</a>' ); ?>
		</p>
		<p style="text-align: right; margin: 50px 0 0 0">
			<em><?php _e( 'The thing about perfection is, it\'s constantly evolving!', 'swift' ); ?>
			</em>
		</p>

	</div>
	<!-- /Content -->
</div>
