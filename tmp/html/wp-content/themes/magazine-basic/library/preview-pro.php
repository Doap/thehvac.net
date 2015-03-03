<?php
class Bavotasan_Preview_Pro {
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 1000 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Add a 'Preview Pro' menu item to the admin bar
	 *
	 * This function is attached to the 'admin_bar_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_bar_menu( $wp_admin_bar ) {
	    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() )
	    	$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'preview_pro', 'title' => sprintf( __( 'Upgrade to %s', 'magazine-basic' ), BAVOTASAN_PRO_UPGRADE_NAME ), 'href' => esc_url( admin_url( 'themes.php?page=bavotasan_preview_pro' ) ) ) );
	}

	/**
	 * Add a 'Preview Pro' menu item to the Appearance panel
	 *
	 * This function is attached to the 'admin_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {
		add_theme_page( sprintf( __( 'Upgrade to %s', 'magazine-basic' ), BAVOTASAN_PRO_UPGRADE_NAME ), __( 'Upgrade to Premium', 'magazine-basic' ), 'edit_theme_options', 'bavotasan_preview_pro', array( $this, 'bavotasan_preview_pro' ) );
	}

	public function bavotasan_preview_pro() {
		$theme_url = 'https://themes.bavotasan.com/2010/magazine-premium/';
		?>
		<div class="wrap about-wrap" id="custom-background">
			<h1><?php echo get_admin_page_title(); ?></h1>
			<div class="about-text">
				<?php printf( __( 'Take your site to the next level with %s. Check out some of the advanced features that\'ll give you more control over your site\'s layout and design.', 'magazine-basic' ), '<em>' . BAVOTASAN_PRO_UPGRADE_NAME . '</em>' ); ?>
				<br /><a href="http://www.youtube.com/watch?v=LrxZ298e6yY" target="_blank"><?php _e( 'View the demo video &rarr;', 'magazine-basic' ); ?></a>
			</div>

			<h2 class="nav-tab-wrapper">
				<?php _e( 'Features', 'magazine-basic' ); ?>
			</h2>

			<div class="changelog">
				<h3><?php _e( 'Advanced Color Picker', 'magazine-basic' ); ?></h3>

				<div class="feature-section images-stagger-right">
					<img alt="" src="<?php echo MB_THEME_URL; ?>/library/images/color-picker.jpg" class="image-66">
					<h4><?php _e( 'So Many Colors to Choose From', 'magazine-basic' ); ?></h4>
					<p><?php printf( __( 'Sometimes the default colors just aren\'t working for you. With %s you can use the advanced color picker to make sure you get the exact colors you want.', 'magazine-basic' ), '<em>' . BAVOTASAN_PRO_UPGRADE_NAME . '</em>' ); ?></p>
					<p><?php _e( 'Easily select one of the eight preset colors or dive even deeper into your customization by using a more specific hex code.', 'magazine-basic' ); ?></p>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Front Page Grid', 'magazine-basic' ); ?></h3>

				<div class="feature-section images-stagger-left">
					<img alt="" src="<?php echo MB_THEME_URL; ?>/library/images/advanced-front-page.jpg" class="image-66">
					<h4><?php _e( 'Create a Custom Front Page Layout', 'magazine-basic' ); ?></h4>
					<p><?php _e( 'With the Advanced Front Page admin, you can create a unique grid layout to feature all of your important articles and categories.', 'magazine-basic' ); ?></p>
					<p><?php _e( 'Add new sections to the Lower Layout area to activate an extra front page sidebar.', 'magazine-basic' ); ?></p>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Google Fonts', 'magazine-basic' ); ?></h3>

				<div class="feature-section images-stagger-right">
					<img alt="" src="<?php echo MB_THEME_URL; ?>/library/images/google-fonts.jpg" class="image-66">
					<h4><?php _e( 'Over 20 Modern Fonts', 'magazine-basic' ); ?></h4>
					<p><?php _e( 'Web-safe fonts are a thing of the past, so why not try to spice things up a bit?', 'magazine-basic' ); ?></p>
					<p><?php _e( 'Choose from some of Google Fonts\' most popular fonts to improve your site\'s typography and make things look even more amazing.', 'magazine-basic' ); ?></p>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Custom CSS Editor', 'magazine-basic' ); ?></h3>

				<div class="feature-section images-stagger-left">
					<img alt="" src="<?php echo MB_THEME_URL; ?>/library/images/custom-css.jpg" class="image-66">
					<h4><?php _e( 'Take Control of Design', 'magazine-basic' ); ?></h4>
					<p><?php _e( 'Sometimes the Theme Options don\'t let you control everything you want. That\'s where the Custom CSS Editor comes into play.', 'magazine-basic' ); ?></p>
					<p><?php _e( 'Use CSS to style any element without having to worry about losing your changes when you update. All your Custom CSS is safely stored in the database.', 'magazine-basic' ); ?></p>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Extended Widgetized Footer', 'magazine-basic' ); ?></h3>

				<div class="feature-section images-stagger-right">
					<img alt="" src="<?php echo MB_THEME_URL; ?>/library/images/extended-footer.jpg" class="image-66">
					<h4><?php _e( 'Add More Widgets', 'magazine-basic' ); ?></h4>
					<p><?php _e( 'If you need to include more widgets on your site, take advantage of the Extended Footer.', 'magazine-basic' ); ?></p>
					<p><?php _e( 'With the Theme Options customizer you can select the number of columns you want to appear. You can also customize the copyright notice in the bottom left.', 'magazine-basic' ); ?></p>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Even More Theme Options', 'magazine-basic' ); ?></h3>
				<div class="feature-section col two-col">
					<div>
						<h4><?php _e( 'Full Width Posts/Pages', 'magazine-basic' ); ?></h4>
						<p><?php _e( 'Each page/post has an option to remove both sidebars so you can use the full width of your site to display whatever you want.', 'magazine-basic' ); ?></p>
					</div>
					<div class="last-feature">
						<h4><?php _e( 'Multiple Sidebar Layouts', 'magazine-basic' ); ?></h4>
						<p><?php _e( 'Sometimes one sidebar just isn\'t enough, so add a second one and place it where you want.', 'magazine-basic' ); ?></p>
					</div>
				</div>

				<div class="feature-section col two-col">
					<div>
						<h4><?php _e( 'Twitter Bootstrap Shortcodes', 'magazine-basic' ); ?></h4>
						<p><?php printf( __( 'Shortcodes are awesome and easy to use. That\'s why %s comes with a bunch, like a slideshow carousel, alert boxes and more.', 'magazine-basic' ), '<em>' . BAVOTASAN_PRO_UPGRADE_NAME . '</em>' ); ?></p>
					</div>
					<div class="last-feature">
						<h4><?php _e( 'Import/Export Tool', 'magazine-basic' ); ?></h4>
						<p><?php _e( 'Once you\'ve set up your site exactly how you want, you can easily export the Theme Options and Custom CSS for safe keeping.', 'magazine-basic' ); ?></p>
					</div>
				</div>
			</div>

			<p><a href="<?php echo $theme_url; ?>" target="_blank" class="button-primary button-large"><?php printf( __( 'Buy %s Now &rarr;', 'magazine-basic' ), '<strong>' . BAVOTASAN_PRO_UPGRADE_NAME . '</strong>' ); ?></a></p>
		</div>
		<?php
	}
}
$bavotasan_preview_pro = new Bavotasan_Preview_Pro;