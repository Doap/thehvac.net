<?php
$swift_promote = array();
$swift_promote[] = '<div id="buy"><h3>You Are Using Swift Basic</h3>
		<strong>Swift Basic</strong> is the free version of <strong>Swift</strong>.<br />
		Get the <strong>Pro Version</strong> for just 57$ and gain access to
		pro features like <strong>Custom Fonts, Shortcodes, Sticky Navigation
		+ Sidebar</strong> &hellip;<br /> <a
		href="http://swiftthemes.com/why-swift-premium/"
		class="btn btn-primary btn-large">
		<h3>Explore Premium &rarr;</h3>
		</a></div>';
$swift_promote[] = '<div id="support"><h3>Like Swift? Please Help it Reach More People :)</h3>
		<ul>
		<li>Give it a five star rating on <a href="http://wordpress.org/support/view/theme-reviews/swift-basic">WordPress.Org</a></li>
		<li><a href="http://twitter.com/home/?status='.urlencode('I\'m using the fastest loading WordPress theme Swift on my blog '.home_url().'. Get your copy now http://bit.ly/107Fb5i').'" target="_blank">Tweet it</a> and let your twit pals know about the theme you love</li>
				<li><a title=""
     href="http://www.facebook.com/sharer.php?u='.urlencode('http://bit.ly/107Fb5i').'
" target="_blank">
<img
	src="your/path/to/facebook-icon.png" alt="Share on Facebook" />
</a>
</li>
<li><a href="'.get_admin_url().'/post-new.php">Write a blogpost</a>
	about how you like the theme and how it helped your blog</li>
<li>Add the <a href="'.get_admin_url().'/widgets.php">affiliate widget</a>
	to your sidebar and make money promoting your favourite theme
</li>
</ul></div>
' ;
$swift_promote[] = 'Swift was born in August 2009, it has been a major part of my life since then. Developing and supporting Swift is a personal decision I made and I enjoy it. <strong>If my decision helped you in anyway, consider a donation :)</strong> <div id="donate">
	<img
		src="'.get_template_directory_uri().'/lib/admin/images/coffee.png"
		width="110" class="alignleft">
	<div id="donate-form" class="alignright">
		<h4>
			Support <strong>Swift Basic</strong> development
		</h4>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input name="cmd" value="_xclick" type="hidden"> <input
				name="business" value="satish_g2009@yahoo.co.in" type="hidden"> <input
				name="item_name" value="Donation for SwiftBasic Theme"
				type="hidden"> <input name="currency_code" value="USD"
				type="hidden"> <input name="return"
				value="http://swiftthemes.com/thank-you" type="hidden">
			<div class="alignleft">
				<input name="amount" value="15.00" size="5" type="text"><b>$</b>
			</div>
			<input name="submit" value="Buy Satish a Coffee" type="submit"
				class="donate btn btn-success  alignright">
		</form>
	</div>
</div>';

$swift_promote[] = '<div class="subcon"><h3 class="subtome">Want more people to follow your blog?</h3><br>
		The <strong class="subtome">SubToMe</strong> widget offers a simple <strong>"Follow"</strong> button that lets your readers pick what tool
they want to use to follow your blog. It\'s <strong>completely open</strong> and <strong>decentralized</strong> and included with
Swift Theme.<br><br>
<span style="font-size:14px;line-height:26px">Make sure you enable the <strong class="subtome">SubToMe</strong> from the <a href="'.get_admin_url( '', 'widgets.php' ).'" class="btn btn-success btn-small" style="margin:0">widgets page &rarr;</a></span></div>';
?>
<div id="header" class="clearfix">
	<div id="theme-logo">
		<a href="http://SwiftThemes.Com" class="alignleft"><img
			src="<?php echo get_template_directory_uri() ?>/lib/admin/images/SwiftThemesLogo.png"
			alt="SwiftThemes" class="alignleft"> </a><br />
	</div>
	<div id="theme-info" class="alignleft">
		<?php
		if(function_exists('wp_get_theme')):
		$ct = wp_get_theme();
		if(is_child_theme()){
			$pt = $ct->parent();
			$theme_name = $pt->get('Name');
			$theme_version =  $pt->get('Version');
			$child_theme_name = $ct->get('Name');
			$child_theme_version = $ct->get('Version');
		}else{
				$theme_name = $ct->get('Name');
				$theme_version =  $ct->get('Version');
			}
			?>
		<h3>
			<?php echo $theme_name.' <strong>v'.$theme_version.'</strong>';?>
		</h3>
		<span><?php echo __( 'Location:', 'swift') . str_replace( WP_CONTENT_DIR, '', get_template_directory() ); ?>
		</span>
		<?php if( get_template_directory() != get_stylesheet_directory() ){?>
		<h4>
			<?php echo $child_theme_name.' <strong>v'.$child_theme_version.'</strong>';?>
		</h4>
		<span><?php echo __( 'Location:', 'swift') . str_replace( WP_CONTENT_DIR, '', get_stylesheet_directory() ); ?>
		</span>
		<?php } ?>
		<?php
		endif;?>
	</div>
	<!--
	<div id="donate">
		<img
			src="<?php echo get_template_directory_uri()?>/lib/admin/images/coffee.png"
			width="110" class="alignleft">
		<div id="donate-form" class="alignright">
			<h4>
				Support <strong>Swift Basic</strong> development
			</h4>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input name="cmd" value="_xclick" type="hidden"> <input
					name="business" value="satish_g2009@yahoo.co.in" type="hidden"> <input
					name="item_name" value="Donation for SwiftBasic Theme"
					type="hidden"> <input name="currency_code" value="USD"
					type="hidden"> <input name="return"
					value="http://swiftthemes.com/thank-you" type="hidden">
				<div class="alignleft">
					<input name="amount" value="15.00" size="5" type="text"><b>$</b>
				</div>
				<input name="submit" value="Buy Satish a Coffee" type="submit"
					class="donate btn btn-success  alignright">
			</form>
		</div>
	</div>
	-->
</div>

<ul id="swift-nav" class="clearfix">
	<li id="hire" class="alignleft"><a
		href="http://swiftthemes.com/hire-me/"
		title="<?php _e( 'WordPress Services', 'swift' ); ?>"><?php _e( 'WordPress Services/Help', 'swift' ); ?>
	</a></li>
	<li id="manual"><a
		href="http://swiftthemes.com/wordpress-themes/swift/swift-user-guide/"
		title="<?php _e( 'A complete guide to installing and customizing SWIFT', 'swift' ); ?>"><?php _e( 'User Guide', 'swift' ); ?>
	</a></li>
	<li id="support"><a href="http://askwebexpert.com/forums/forum/wordpress/swift-basic-support/"
		title="<?php _e( 'Need more help? Check out support forum.', 'swift' ); ?>"><?php _e( 'Support forum', 'swift' ); ?>
	</a></li>
	<li id="testimonial"><a href="http://swiftthemes.com/testimonials/"
		title="<?php _e( 'Write a testimonial for SWIFT', 'swift' ); ?>"><?php _e( 'Write a Testimonial', 'swift' ); ?>
	</a></li>
</ul>

<div id="upgrade" class="clearfix">
	<div
		style="width: 420px; padding-right: 10px; border-right: solid 1px #999"
		class="clearfix alignleft">
		<?php echo $swift_promote[rand(3, 3)]?>
	</div>
	<div style="width: 418px; padding-left: 10px" class="alignleft">
		<h3>Got a WordPress or Web Development Related Question??</h3>
		If you need a quick solution for your problem, pick a support package
		below and ask your questions. You will get a refund of your payment if
		I don't respond to your question within one hour or if I'm unable to
		solve your problem <br /> <br />

		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick"> <input
				type="hidden" name="hosted_button_id" value="TAKWFCT2THH6A">
			<table style="display: block; float: left">
				<tr>
					<td><input type="hidden" name="on0" value="Swift Basic"><strong
						style="color: #e9830b">Choose a Support Package</strong></td>
				</tr>
				<tr>
					<td><select name="os0" style="width: 200px">
							<option value="One Question">One Question $10.00 USD</option>
							<option value="Two Questions">Two Questions $15.00 USD</option>
							<option value="Three Questions">Three Questions $20.00 USD</option>
							<option value="Blog Optimization">Blog Optimization $50.00 USD</option>
					</select>
					</td>
				</tr>
			</table>
			<input type="hidden" name="currency_code" value="USD"> <input
				type="image"
				style="width: 200px; border: 0; width: 140px;margin-top:-3px; float: right"
				src="https://www.paypal.com/en_GB/i/btn/btn_paynowCC_LG.gif"
				border="0" name="submit"
				alt="PayPal - The safer, easier way to pay online."> <img alt=""
				border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif"
				width="1" height="1">
		</form>
	</div>
</div>
