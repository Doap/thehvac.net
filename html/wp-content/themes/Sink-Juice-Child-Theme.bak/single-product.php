<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>
<h5>Or buy with Bitcoin </h5>
<a class="coinbase-button" data-code="8c4fc9c75d597bc7077f2781689737fb" href="https://coinbase.com/checkouts/8c4fc9c75d597bc7077f2781689737fb">Pay With Bitcoin</a><script src="https://coinbase.com/assets/button.js" type="text/javascript"></script>

<a href="https://coinbase.com/checkouts/f1a4bf0a63c63eaab8e588ab6843256e" target="_blank">Pay With Bitcoin</a>

<iframe id="coinbase_inline_iframe_76be03554fa3d3b77f6f90786ac56ead" src="https://coinbase.com/inline_payments/76be03554fa3d3b77f6f90786ac56ead" style="width: 500px; height: 160px; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.25); overflow: hidden;" scrolling="no" allowtransparency="true" frameborder="0"></iframe>

<h5>Or use PayPal</h5>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="CKZZQB7VTW32E">
<table>
<tr><td><input type="hidden" name="on0" value="How many?">How many?</td></tr><tr><td><select name="os0">
	<option value="One Sink Juicer">One Sink Juicer $9.00 USD</option>
	<option value="4 pack of Sink Juicers">4 pack of Sink Juicers $35.00 USD</option>
	<option value="6 pack of Sink Juicers">6 pack of Sink Juicers $45.00 USD</option>
</select> </td></tr>
<tr><td><input type="hidden" name="on1" value="What Color">What color?</td></tr><tr><td><select name="os1">
	<option value="Blue Sink Juicer">Blue Sink Juicer </option>
	<option value="Red Sink Juicer">Red Sink Juicer </option>
	<option value="Green Sink Juicer">Green Sink Juicer </option>
	<option value="Yellow  Sink Juicer">Yellow  Sink Juicer </option>
	<option value="Orange Sink Juicer">Orange Sink Juicer </option>
	<option value="Purple Sink Juicer">Purple Sink Juicer </option>
	<option value="Green Sink Juicer">Green Sink Juicer </option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>
