<?php
class Shortcodes_Ultimate_Extra {

	/**
	 * Constructor
	 */
	function __construct() {
		// Load textdomain
		load_plugin_textdomain( 'sue', false, dirname( plugin_basename( SUE_PLUGIN_FILE ) ) . '/lang/' );
		// Reset cache on activation
		if ( class_exists( 'Su_Generator' ) ) register_activation_hook( SUE_PLUGIN_FILE, array( 'Su_Generator', 'reset' ) );
		// Init plugin
		add_action( 'plugins_loaded', array( __CLASS__, 'init' ), 20 );
		// Make pluin meta translation-ready
		__( 'Vladimir Anokhin', 'sue' );
		__( 'Shortcodes Ultimate: Extra Shortcodes', 'sue' );
		__( 'Extra set of shortcodes for Shortcodes Ultimate', 'sue' );
	}

	/**
	 * Plugin init
	 */
	public static function init() {
		// Check for SU
		if ( !function_exists( 'shortcodes_ultimate' ) ) {
			// Show notice
			add_action( 'admin_notices', array( __CLASS__, 'su_notice' ) );
			// Break init
			return;
		}
		// Register assets
		add_action( 'init', array( __CLASS__, 'assets' ) );
		// Add new group to Generator
		add_filter( 'su/data/groups', array( __CLASS__, 'group' ) );
		// Add source CSS files links to the settings page
		add_action( 'su/admin/css/originals/after', array( __CLASS__, 'sources' ) );
		// Register new shortcodes
		add_filter( 'su/data/shortcodes', array( __CLASS__, 'data' ) );
		// Register examples
		add_filter( 'su/data/examples', array( __CLASS__, 'examples' ) );
		// Add plugin meta links
		add_filter( 'plugin_row_meta', array( __CLASS__, 'meta_links' ), 10, 2 );
	}

	/**
	 * Show SU notice
	 */
	public static function su_notice() {
		?><div class="updated">
			<p><?php _e( 'Please install and activate latest version of <b>Shortcodes Ultimate</b> to use it\'s addon <b>Shortcodes Ultimate Extra Set</b>.<br />Deactivate this addon to hide this message.', 'sue' ); ?></p>
			<p><a href="<?php echo admin_url( 'plugin-install.php?tab=plugin-information&plugin=shortcodes-ultimate' ); ?>" onClick="document.getElementById('sue_su_install_iframe').style.display='block';this.style.display='none';return false;" target="_blank" class="button button-primary"><?php _e( 'Install Sortcodes Ultimate', 'sue' ); ?> &rarr;</a></p>
			<iframe src="<?php echo admin_url( 'plugin-install.php?tab=plugin-information&plugin=shortcodes-ultimate' ); ?>" id="sue_su_install_iframe" style="display:none;width:100%;height:600px;margin-top:1em;overflow:auto;border:none"></iframe>
		</div><?php
	}

	public static function assets() {
		wp_register_style( 'su-extra', plugins_url( 'assets/css/extra.css', SUE_PLUGIN_FILE ), false, SUE_PLUGIN_VERSION, 'all' );
		wp_register_script( 'su-extra', plugins_url( 'assets/js/extra.js', SUE_PLUGIN_FILE ), array( 'jquery' ), SUE_PLUGIN_VERSION, true );
	}

	public static function meta_links( $links, $file ) {
		if ( $file === plugin_basename( SUE_PLUGIN_FILE ) ) $links[] = '<a href="http://gndev.info/cs/" target="_blank">' . __( 'Customer support', 'sue' ) . '</a>';
		return $links;
	}

	/**
	 * Add new group to the Generator
	 */
	public static function group( $groups ) {
		$groups['extra'] = __( 'Extra set', 'sue' );
		return $groups;
	}

	/**
	 * Add links to CSS files at settings page
	 */
	public static function sources() {
?>
		<p><strong><?php _e( 'Shortcodes Ultimate: Extra Shortcodes', 'sue' ); ?></strong></p>
		<div class="sunrise-inline-menu">
			<a href="<?php echo plugins_url( 'assets/css/extra.css', SUE_PLUGIN_FILE ); ?>">extra.css</a>
		</div>
<?php
	}

	public static function examples( $examples ) {
		$examples['extra'] = array(
			'title' => __( 'Shortcodes Ultimate: Extra Shortcodes', 'sue' ),
			'items' => array(
				array(
					'name' => __( 'Parallax sections', 'sue' ),
					'id'   => 'parallax-sections',
					'code' => plugin_dir_path( SUE_PLUGIN_FILE ) . '/inc/examples/parallax-sections.example',
					'icon' => 'arrows-alt'
				),
				array(
					'name' => __( 'Pricing tables', 'sue' ),
					'id'   => 'pricing-tables',
					'code' => plugin_dir_path( SUE_PLUGIN_FILE ) . '/inc/examples/pricing-tables.example',
					'icon' => 'table'
				),
				array(
					'name' => __( 'Testimonials', 'sue' ),
					'id'   => 'testimonials',
					'code' => plugin_dir_path( SUE_PLUGIN_FILE ) . '/inc/examples/testimonials.example',
					'icon' => 'comments-o'
				),
				array(
					'name' => __( 'Icons, progress bars, pies', 'sue' ),
					'id'   => 'icons-progress-bars-pies',
					'code' => plugin_dir_path( SUE_PLUGIN_FILE ) . '/inc/examples/icons-progress-bars-pies.example',
					'icon' => 'star-half-o'
				),
				array(
					'name' => __( 'Content slider', 'sue' ),
					'id'   => 'content-slider',
					'code' => plugin_dir_path( SUE_PLUGIN_FILE ) . '/inc/examples/content-slider.example',
					'icon' => 'desktop'
				),
				array(
					'name' => __( 'Panels', 'sue' ),
					'id'   => 'panels',
					'code' => plugin_dir_path( SUE_PLUGIN_FILE ) . '/inc/examples/panels.example',
					'icon' => 'pencil-square-o'
				),
				array(
					'name' => __( 'Shadows', 'sue' ),
					'id'   => 'shadows',
					'code' => plugin_dir_path( SUE_PLUGIN_FILE ) . '/inc/examples/shadows.example',
					'icon' => 'moon-o'
				),
			)
		);
		return $examples;
	}

	/**
	 * New shortcodes data
	 */
	public static function data( $shortcodes ) {
		$shortcodes['splash'] = array(
			'name'     => __( 'Splash screen', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra box',
			'content'  => __( 'Splash screen content', 'sue' ),
			'desc'     => __( 'Fully customizable splash screen', 'sue' ),
			'icon'     => 'bullhorn',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'splash' ),
			'atts'     => array(
				'style' => array(
					'type'    => 'select',
					'default' => 'dark',
					'name'    => __( 'Style', 'sue' ),
					'desc'    => __( 'Choose splash screen style', 'sue' ),
					'values'   => array(
						'dark'               => __( 'Dark', 'sue' ),
						'dark-boxed'         => __( 'Dark boxed', 'sue' ),
						'light'              => __( 'Light', 'sue' ),
						'light-boxed'        => __( 'Light boxed', 'sue' ),
						'blue-boxed'         => __( 'Blue boxed', 'sue' ),
						'light-boxed-blue'   => __( 'Light boxed blue', 'sue' ),
						'light-boxed-green'  => __( 'Light boxed green', 'sue' ),
						'light-boxed-orange' => __( 'Light boxed orange', 'sue' ),
						'maintenance'        => __( 'Maintenance', 'sue' )
					)
				),
				'width' => array(
					'type'    => 'slider',
					'min'     => 100,
					'max'     => 1600,
					'step'    => 20,
					'default' => 480,
					'name'    => __( 'Width', 'sue' ),
					'desc'    => __( 'Width of splash screen content', 'sue' )
				),
				'opacity' => array(
					'type'    => 'slider',
					'min'     => 0,
					'max'     => 100,
					'step'    => 5,
					'default' => 80,
					'name'    => __( 'Opacity', 'sue' ),
					'desc'    => __( 'Background opacity in percents', 'sue' )
				),
				'onclick' => array(
					'type'    => 'select',
					'default' => 'close-bg',
					'name'    => __( 'Action on click', 'sue' ),
					'desc'    => __( 'Choose splash screen behavior when it is clicked', 'sue' ),
					'values'  => array(
						'none'     => __( 'Do nothing', 'sue' ),
						'close'    => __( 'Close splash screen (click anywhere)', 'sue' ),
						'close-bg' => __( 'Close on background click', 'sue' ),
						'url'      => __( 'Go to specified url', 'sue' )
					)
				),
				'url' => array(
					'name'    => __( 'URL', 'sue' ),
					'desc'    => __( 'Enter url to go when splash screen is clicked (this option must selected in dropdown list above)', 'sue' ),
					'default' => get_bloginfo( 'url' )
				),
				'delay' => array(
					'type'    => 'slider',
					'min'     => 0,
					'max'     => 120,
					'step'    => 1,
					'default' => 0,
					'name'    => __( 'Delay', 'sue' ),
					'desc'    => __( 'Specify the time in which the splash screen will be shown (in seconds)', 'sue' )
				),
				'esc' => array(
					'type'    => 'bool',
					'default' => 'yes',
					'name'    => __( 'Esc hotkey', 'sue' ),
					'desc'    => __( 'Close the screen by pressing Esc', 'sue' )
				),
				'close' => array(
					'type'    => 'bool',
					'default' => 'yes',
					'name'    => __( 'Close button', 'sue' ),
					'desc'    => __( 'Show Close button', 'sue' )
				),
				'once' => array(
					'type'    => 'bool',
					'default' => 'no',
					'name'    => __( 'Show once', 'sue' ),
					'desc'    => __( 'Show this splash screen only once on this page', 'sue' )
				),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			)
		);

		$shortcodes['panel'] = array(
			'name'     => __( 'Panel', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra box',
			'content'  => __( 'Panel content', 'sue' ),
			'desc'     => __( 'Colorful box with custom content', 'sue' ),
			'icon'     => 'pencil-square-o',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'panel' ),
			'atts'     => array(
				'background' => array(
					'type' => 'color',
					'default' => '#ffffff',
					'name' => __( 'Background', 'sue' ),
					'desc' => __( 'Panel background color', 'sue' )
				),
				'color' => array(
					'type' => 'color',
					'default' => '#333333',
					'name' => __( 'Color', 'sue' ),
					'desc' => __( 'Panel text color', 'sue' )
				),
				'border' => array(
					'type'    => 'border',
					'default' => '1px solid #cccccc',
					'name'    => __( 'Border', 'sue' ),
					'desc'    => __( 'Panel border', 'sue' )
				),
				'shadow' => array(
					'type'    => 'shadow',
					'default' => '0px 1px 2px #eeeeee',
					'name'    => __( 'Shadow', 'sue' ),
					'desc'    => __( 'Panel shadow', 'sue' )
				),
				'radius' => array(
					'type' => 'slider',
					'min' => 0,
					'max' => 60,
					'step' => 1,
					'default' => 0,
					'name' => __( 'Border radius', 'sue' ),
					'desc' => __( 'Panel border radius (px)', 'sue' )
				),
				'text_align' => array(
					'type'    => 'select',
					'default' => 'left',
					'values' => array(
						'left' => __( 'Left', 'sue' ),
						'center' => __( 'Center', 'sue' ),
						'right' => __( 'Right', 'sue' )
					),
					'name'    => __( 'Text align', 'sue' ),
					'desc'    => __( 'Text alignment for panel content', 'sue' )
				),
				'url' => array(
					'default' => '',
					'name'    => __( 'URL', 'sue' ),
					'desc'    => __( 'You can type here any hyperlink to make this panel clickable', 'sue' )
				),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			)
		);

		$shortcodes['photo_panel'] = array(
			'name'     => __( 'Photo panel', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra box',
			'content'  => __( 'Panel content', 'sue' ),
			'desc'     => __( 'Colorful box with image', 'sue' ),
			'icon'     => 'pencil-square-o',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'photo_panel' ),
			'atts'     => array(
				'background' => array(
					'type' => 'color',
					'default' => '#ffffff',
					'name' => __( 'Background', 'sue' ),
					'desc' => __( 'Panel background color', 'sue' )
				),
				'color' => array(
					'type' => 'color',
					'default' => '#333333',
					'name' => __( 'Color', 'sue' ),
					'desc' => __( 'Panel text color', 'sue' )
				),
				'border' => array(
					'type'    => 'border',
					'default' => '1px solid #cccccc',
					'name'    => __( 'Border', 'sue' ),
					'desc'    => __( 'Panel border', 'sue' )
				),
				'shadow' => array(
					'type'    => 'shadow',
					'default' => '0 1px 2px #eeeeee',
					'name'    => __( 'Shadow', 'sue' ),
					'desc'    => __( 'Panel shadow', 'sue' )
				),
				'radius' => array(
					'type' => 'slider',
					'min' => 0,
					'max' => 60,
					'step' => 1,
					'default' => 0,
					'name' => __( 'Border radius', 'sue' ),
					'desc' => __( 'Panel border radius (px)', 'sue' )
				),
				'text_align' => array(
					'type'    => 'select',
					'default' => 'left',
					'values' => array(
						'left' => __( 'Left', 'sue' ),
						'center' => __( 'Center', 'sue' ),
						'right' => __( 'Right', 'sue' )
					),
					'name'    => __( 'Text align', 'sue' ),
					'desc'    => __( 'Text alignment for panel content', 'sue' )
				),
				'photo' => array(
					'type' => 'upload',
					'default' => 'http://lorempixel.com/400/300/food/',
					'name'    => __( 'Photo', 'sue' ),
					'desc'    => __( 'Select the photo for this panel', 'sue' )
				),
				'url' => array(
					'default' => '',
					'name'    => __( 'URL', 'sue' ),
					'desc'    => __( 'You can type here any hyperlink to make this panel clickable', 'sue' )
				),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			)
		);

		$shortcodes['icon_panel'] = array(
			'name'     => __( 'Icon panel', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra box',
			'content'  => __( 'Panel content', 'sue' ),
			'desc'     => __( 'Colorful box with icon', 'sue' ),
			'icon'     => 'pencil-square-o',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'icon_panel' ),
			'atts'     => array(
				'background' => array(
					'type'    => 'color',
					'default' => '#ffffff',
					'name'    => __( 'Background', 'sue' ),
					'desc'    => __( 'Panel background color', 'sue' )
				),
				'color' => array(
					'type'    => 'color',
					'default' => '#333333',
					'name'    => __( 'Color', 'sue' ),
					'desc'    => __( 'Panel text color', 'sue' )
				),
				'border' => array(
					'type'    => 'border',
					'default' => '1px solid #cccccc',
					'name'    => __( 'Border', 'sue' ),
					'desc'    => __( 'Panel border', 'sue' )
				),
				'shadow' => array(
					'type'    => 'shadow',
					'default' => '0 1px 2px #eeeeee',
					'name'    => __( 'Shadow', 'sue' ),
					'desc'    => __( 'Panel shadow', 'sue' )
				),
				'radius' => array(
					'type'    => 'slider',
					'min'     => 0,
					'max'     => 60,
					'step'    => 1,
					'default' => 0,
					'name'    => __( 'Border radius', 'sue' ),
					'desc'    => __( 'Panel border radius (px)', 'sue' )
				),
				'text_align' => array(
					'type'    => 'select',
					'default' => 'center',
					'name'    => __( 'Text align', 'sue' ),
					'desc'    => __( 'Text alignment for panel content', 'sue' ),
					'values'  => array(
						'left'   => __( 'Left', 'sue' ),
						'center' => __( 'Center', 'sue' ),
						'right'  => __( 'Right', 'sue' )
					)
				),
				'icon' => array(
					'type'    => 'icon',
					'default' => 'icon: heart',
					'name'    => __( 'Icon', 'sue' ),
					'desc'    => __( 'Select the icon for this panel', 'sue' )
				),
				'icon_color' => array(
					'type'    => 'color',
					'default' => '#333333',
					'name'    => __( 'Icon color', 'sue' ),
					'desc'    => __( 'Select icon color. This color will be aplied only to built-in icons. Does not works for uploaded icons', 'sue' )
				),
				'icon_size' => array(
					'type'    => 'slider',
					'min' => 10,
					'max' => 320,
					'step' => 1,
					'default' => 24,
					'name'    => __( 'Icon size', 'sue' ),
					'desc'    => __( 'Select icon size (px)', 'sue' )
				),
				'url' => array(
					'default' => '',
					'name'    => __( 'URL', 'sue' ),
					'desc'    => __( 'You can type here any hyperlink to make this panel clickable', 'sue' )
				),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			)
		);

		$shortcodes['icon_text'] = array(
			'name'     => __( 'Text with icon', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra content',
			'content'  => __( 'Content', 'sue' ),
			'desc'     => __( 'Text block with customizable icon', 'sue' ),
			'icon'     => 'pencil',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'icon_text' ),
			'atts'     => array(
				'color' => array(
					'type'    => 'color',
					'default' => '#333333',
					'name'    => __( 'Color', 'sue' ),
					'desc'    => __( 'Text color', 'sue' )
				),
				'icon' => array(
					'type'    => 'icon',
					'default' => 'icon: heart',
					'name'    => __( 'Icon', 'sue' ),
					'desc'    => __( 'Select the icon for this text block', 'sue' )
				),
				'icon_color' => array(
					'type'    => 'color',
					'default' => '#333333',
					'name'    => __( 'Icon color', 'sue' ),
					'desc'    => __( 'Select icon color. This color will be aplied only to built-in icons. Does not works for uploaded icons', 'sue' )
				),
				'icon_size' => array(
					'type'    => 'slider',
					'min' => 10,
					'max' => 320,
					'step' => 1,
					'default' => 24,
					'name'    => __( 'Icon size', 'sue' ),
					'desc'    => __( 'Select icon size (px)', 'sue' )
				),
				'url' => array(
					'default' => '',
					'name'    => __( 'URL', 'sue' ),
					'desc'    => __( 'You can type here any hyperlink to make this panel clickable', 'sue' )
				),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			)
		);

		$shortcodes['progress_pie'] = array(
			'name'     => __( 'Progress pie', 'sue' ),
			'type'     => 'single',
			'group'    => 'extra other',
			'desc'     => __( 'Customizable pie chart with counter', 'sue' ),
			'icon'     => 'star-half-o',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'progress_pie' ),
			'atts'     => array(
				'percent' => array(
					'type' => 'slider',
					'min' => 0,
					'max' => 100,
					'step' => 1,
					'default' => 75,
					'name' => __( 'Percent', 'sue' ),
					'desc' => __( 'Specify percentage', 'sue' )
				),
				'text' => array(
					'default' => '',
					'name'    => __( 'Text', 'sue' ),
					'desc'    => __( 'You can show custom text instead of percent. Leave this field empty to show the percent', 'sue' )
				),
				'before' => array(
					'default' => '',
					'name'    => __( 'Before', 'sue' ),
					'desc'    => __( 'This content will be shown before the percent', 'sue' )
				),
				'after' => array(
					'default' => '',
					'name'    => __( 'After', 'sue' ),
					'desc'    => __( 'This content will be shown after the percent', 'sue' )
				),
				'size' => array(
					'type' => 'slider',
					'min' => 20,
					'max' => 1200,
					'step' => 20,
					'default' => 200,
					'name' => __( 'Size', 'sue' ),
					'desc' => __( 'Pie size (pixels)', 'sue' )
				),
				'pie_width' => array(
					'type' => 'slider',
					'min' => 0,
					'max' => 100,
					'step' => 5,
					'default' => 30,
					'name' => __( 'Pie width', 'sue' ),
					'desc' => __( 'Pie border width (percents)', 'sue' )
				),
				'text_size' => array(
					'type' => 'slider',
					'min' => 10,
					'max' => 120,
					'step' => 5,
					'default' => 40,
					'name' => __( 'Text size', 'sue' ),
					'desc' => __( 'Pie text size (pixels)', 'sue' )
				),
				'align' => array(
					'type' => 'select',
					'values' => array(
						'none'   => __( 'None', 'sue' ),
						'left'   => __( 'Left', 'sue' ),
						'center' => __( 'Center', 'sue' ),
						'right'  => __( 'Right', 'sue' ),
					),
					'default' => 'center',
					'name' => __( 'Align', 'sue' ),
					'desc' => __( 'Pie alignment', 'sue' )
				),
				'pie_color' => array(
					'type' => 'color',
					'default' => '#f0f0f0',
					'name' => __( 'Pie color', 'su' ),
					'desc' => __( 'Unfilled pie background color', 'sue' )
				),
				'fill_color' => array(
					'type' => 'color',
					'default' => '#97daed',
					'name' => __( 'Fill color', 'su' ),
					'desc' => __( 'Filled pie background color', 'sue' )
				),
				'text_color' => array(
					'type' => 'color',
					'default' => '#cccccc',
					'name' => __( 'Text color', 'su' ),
					'desc' => __( 'Select pie text color', 'sue' )
				),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			)
		);

		$shortcodes['progress_bar'] = array(
			'name'     => __( 'Progress bar', 'sue' ),
			'type'     => 'single',
			'group'    => 'extra other',
			'desc'     => __( 'Customizable progress bar', 'sue' ),
			'icon'     => 'star-half-o',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'progress_bar' ),
			'atts'     => array(
				'style' => array(
					'type' => 'select',
					'values' => array(
						'default' => __( 'Default', 'sue' ),
						'fancy'   => __( 'Fancy', 'sue' ),
						'thin'    => __( 'Thin', 'sue' )
					),
					'default' => 'default',
					'name' => __( 'Style', 'sue' ),
					'desc' => __( 'Select progress bar style', 'sue' )
				),
				'percent' => array(
					'type' => 'slider',
					'min' => 0,
					'max' => 100,
					'step' => 1,
					'default' => 75,
					'name' => __( 'Percent', 'sue' ),
					'desc' => __( 'Specify percentage', 'sue' )
				),
				'text' => array(
					'default' => '',
					'name'    => __( 'Text', 'sue' ),
					'desc'    => __( 'You can show custom text instead of percent. Leave this field empty to show the percent', 'sue' )
				),
				'bar_color' => array(
					'type' => 'color',
					'default' => '#f0f0f0',
					'name' => __( 'Bar color', 'su' ),
					'desc' => __( 'Unfilled bar background color', 'sue' )
				),
				'fill_color' => array(
					'type' => 'color',
					'default' => '#97daed',
					'name' => __( 'Fill color', 'su' ),
					'desc' => __( 'Filled bar background color', 'sue' )
				),
				'text_color' => array(
					'type' => 'color',
					'default' => '#555555',
					'name' => __( 'Text color', 'su' ),
					'desc' => __( 'Select bar text color', 'sue' )
				),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			)
		);

		$shortcodes['member'] = array(
			'name'     => __( 'Member', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra box content',
			'content'  => __( 'Type here some info about this team member', 'sue' ),
			'desc'     => __( 'Team member', 'sue' ),
			'icon'     => 'users',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'member' ),
			'atts'     => array(
				'background' => array(
					'type' => 'color',
					'default' => '#ffffff',
					'name' => __( 'Background', 'sue' ),
					'desc' => __( 'Panel background color', 'sue' )
				),
				'color' => array(
					'type' => 'color',
					'default' => '#333333',
					'name' => __( 'Color', 'sue' ),
					'desc' => __( 'Panel text color', 'sue' )
				),
				'border' => array(
					'type'    => 'border',
					'default' => '1px solid #cccccc',
					'name'    => __( 'Border', 'sue' ),
					'desc'    => __( 'Panel border', 'sue' )
				),
				'shadow' => array(
					'type'    => 'shadow',
					'default' => '0 1px 2px #eeeeee',
					'name'    => __( 'Shadow', 'sue' ),
					'desc'    => __( 'Panel shadow', 'sue' )
				),
				'radius' => array(
					'type' => 'slider',
					'min' => 0,
					'max' => 60,
					'step' => 1,
					'default' => 0,
					'name' => __( 'Border radius', 'sue' ),
					'desc' => __( 'Panel border radius (px)', 'sue' )
				),
				'text_align' => array(
					'type'    => 'select',
					'default' => 'left',
					'values'  => array(
						'left' => __( 'Left', 'sue' ),
						'center' => __( 'Center', 'sue' ),
						'right' => __( 'Right', 'sue' )
					),
					'name'    => __( 'Text align', 'sue' ),
					'desc'    => __( 'Text alignment for panel content', 'sue' )
				),
				'photo' => array(
					'type' => 'upload',
					'default' => 'http://lorempixel.com/400/300/business/',
					'name'    => __( 'Photo', 'sue' ),
					'desc'    => __( 'Select the photo for this member', 'sue' )
				),
				'name' => array(
					'default' => __( 'John Doe', 'sue' ),
					'name'    => __( 'Name', 'sue' ),
					'desc'    => __( 'Member name', 'sue' )
				),
				'role' => array(
					'default' => __( 'Designer', 'sue' ),
					'name'    => __( 'Role', 'sue' ),
					'desc'    => __( 'Member role', 'sue' )
				),
				'icon_1' => array(
					'type'    => 'icon',
					'default' => '',
					'name'    => sprintf( __( 'Icon %d', 'sue' ), 1 ),
					'desc'    => __( 'Select social icon for this member', 'sue' )
				),
				'icon_1_url' => array(
					'default' => '',
					'name'    => sprintf( __( 'Icon %d URL', 'sue' ), 1 ),
					'desc'    => __( 'Enter here social profile URL', 'sue' )
				),
				'icon_1_color' => array(
					'type'    => 'color',
					'default' => '#333333',
					'name'    => sprintf( __( 'Icon %d color', 'sue' ), 1 ),
					'desc'    => __( 'Choose color for this icon. This color will only be applied to the built-in icons', 'sue' )
				),
				'icon_1_title' => array(
					'default' => '',
					'name'    => sprintf( __( 'Icon %d title', 'sue' ), 1 ),
					'desc'    => __( 'This text will be shown as icon tooltip', 'sue' )
				),
				'icon_2' => array(
					'type'    => 'icon',
					'default' => '',
					'name'    => sprintf( __( 'Icon %d', 'sue' ), 2 ),
					'desc'    => __( 'Select social icon for this member', 'sue' )
				),
				'icon_2_url' => array(
					'default' => '',
					'name'    => sprintf( __( 'Icon %d URL', 'sue' ), 2 ),
					'desc'    => __( 'Enter here social profile URL', 'sue' )
				),
				'icon_2_color' => array(
					'type'    => 'color',
					'default' => '#333333',
					'name'    => sprintf( __( 'Icon %d color', 'sue' ), 2 ),
					'desc'    => __( 'Choose color for this icon. This color will only be applied to the built-in icons', 'sue' )
				),
				'icon_2_title' => array(
					'default' => '',
					'name'    => sprintf( __( 'Icon %d title', 'sue' ), 2 ),
					'desc'    => __( 'This text will be shown as icon tooltip', 'sue' )
				),
				'icon_3' => array(
					'type'    => 'icon',
					'default' => '',
					'name'    => sprintf( __( 'Icon %d', 'sue' ), 3 ),
					'desc'    => __( 'Select social icon for this member', 'sue' )
				),
				'icon_3_url' => array(
					'default' => '',
					'name'    => sprintf( __( 'Icon %d URL', 'sue' ), 3 ),
					'desc'    => __( 'Enter here social profile URL', 'sue' )
				),
				'icon_3_color' => array(
					'type'    => 'color',
					'default' => '#333333',
					'name'    => sprintf( __( 'Icon %d color', 'sue' ), 3 ),
					'desc'    => __( 'Choose color for this icon. This color will only be applied to the built-in icons', 'sue' )
				),
				'icon_3_title' => array(
					'default' => '',
					'name'    => sprintf( __( 'Icon %d title', 'sue' ), 3 ),
					'desc'    => __( 'This text will be shown as icon tooltip', 'sue' )
				),
				'url' => array(
					'default' => '',
					'name'    => __( 'URL', 'sue' ),
					'desc'    => __( 'You can type here any hyperlink to make this panel clickable', 'sue' )
				),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			)
		);

		$shortcodes['section'] = array(
			'name'     => __( 'Section', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra box',
			'content'  => __( 'Section content', 'sue' ),
			'desc'     => __( 'Content section with customizable background, dimensions and optional parallax effect', 'sue' ),
			'icon'     => 'arrows-alt',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'section' ),
			'atts'     => array(
				'background' => array(
					'type'    => 'color',
					'default' => '#ffffff',
					'name'    => __( 'Background color', 'sue' ),
					'desc'    => __( 'Section background color', 'sue' )
				),
				'image' => array(
					'type' => 'upload',
					'default' => '',
					'name'    => __( 'Background image', 'sue' ),
					'desc'    => sprintf( __( 'Select background image for this section. Example value: %s', 'sue' ), '<b%value>http://lorempixel.com/1200/600/abstract/</b>' )
				),
				'parallax' => array(
					'type'    => 'bool',
					'default' => 'yes',
					'name'    => __( 'Parallax', 'sue' ),
					'desc'    => __( 'Enable parallax effect. Parallax effect may not work in Live preview mode', 'sue' )
				),
				'mobile' => array(
					'type'    => 'bool',
					'default' => 'yes',
					'name'    => __( 'Enable on mobile devices', 'sue' ),
					'desc'    => __( 'Enable parallax effect on devices with screen width less than 768px', 'sue' )
				),
				'speed' => array(
					'type'    => 'slider',
					'min'     => 1,
					'max'     => 12,
					'step'    => 1,
					'default' => 10,
					'name'    => __( 'Parallax speed', 'sue' ),
					'desc'    => __( 'Adjust speed of parallax effect', 'sue' )
				),
				'max_width' => array(
					'type'    => 'slider',
					'min'     => 0,
					'max'     => 1600,
					'step'    => 10,
					'default' => 960,
					'name'    => __( 'Content width', 'sue' ),
					'desc'    => __( 'Maximum width for this section content (px)', 'sue' )
				),
				'margin' => array(
					'default' => '0px 0px 0px 0px',
					'name'    => __( 'Margin', 'sue' ),
					'desc'    => sprintf( '%s (px), [%s]', __( 'Section margin', 'sue' ), __( 'top right bottom left', 'sue' ) )
				),
				'padding' => array(
					'default' => '30px 0px 30px 0px',
					'name'    => __( 'Padding', 'sue' ),
					'desc'    => sprintf( '%s (px), [%s]', __( 'Section padding', 'sue' ), __( 'top right bottom left', 'sue' ) )
				),
				'border' => array(
					'type'    => 'border',
					'default' => '1px solid #cccccc',
					'name'    => __( 'Border', 'sue' ),
					'desc'    => __( 'Top and bottom section borders', 'sue' )
				),
				'color' => array(
					'type'    => 'color',
					'default' => '#333333',
					'name'    => __( 'Text color', 'sue' ),
					'desc'    => __( 'Section text color', 'sue' )
				),
				'text_align' => array(
					'type'    => 'select',
					'default' => 'left',
					'values'  => array(
						'left'   => __( 'Left', 'sue' ),
						'center' => __( 'Center', 'sue' ),
						'right'  => __( 'Right', 'sue' )
					),
					'name'    => __( 'Text align', 'sue' ),
					'desc'    => __( 'Text alignment for panel content', 'sue' )
				),
				'text_shadow' => array(
					'type'    => 'shadow',
					'default' => '0 1px 10px #ffffff',
					'name'    => __( 'Text shadow', 'sue' ),
					'desc'    => __( 'Pick a shadow for section text', 'sue' )
				),
				'url' => array(
					'default' => '',
					'name'    => __( 'URL', 'sue' ),
					'desc'    => __( 'You can type here any hyperlink to make this section clickable', 'sue' )
				),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			)
		);

		$shortcodes['pricing_table'] = array(
			'name'     => __( 'Pricing table', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra box',
			'desc'     => __( 'Wrapper for pricing plans', 'sue' ),
			'icon'     => 'table',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'pricing_table' ),
			'atts'     => array(
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			)
		);

		$shortcodes['plan'] = array(
			'name'     => __( 'Pricing plan', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra box',
			'desc'     => __( 'Single pricing plan', 'sue' ),
			'icon'     => 'table',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'plan' ),
			'atts'     => array(
				'name' => array(
					'default' => '',
					'name'    => __( 'Plan name', 'sue' ),
					'desc'    => sprintf( '%s<br>%s: <b_>%s</b>, <b_>%s</b>, <b_>%s</b>', __( 'Type here the name of this pricing plan', 'sue' ), __( 'Example values', 'sue' ), __( 'Starter', 'sue' ), __( 'Business', 'sue' ), __( 'Professional', 'sue' ) )
				),
				'price' => array(
					'default' => '',
					'name'    => __( 'Price', 'sue' ),
					'desc'    => sprintf( '%s<br>%s: <b_>%s</b>, <b_>%s</b>, <b_>%s</b>', __( 'Specify the price for this plan (without currency).', 'sue' ), __( 'Example values', 'sue' ), __( 'Free', 'sue' ), '10', '29' )
				),
				'before' => array(
					'default' => '',
					'name'    => __( 'Before price', 'sue' ),
					'desc'    => sprintf( '%s<br>%s<br>%s: %s', __( 'This text will be shown right before plan price.', 'sue' ), __( 'It is a good place to add currency.', 'sue' ), __( 'Example values', 'sue' ), '<b_>$</b>, <b_>€</b>, <b_>¥</b>, <b_>euro</b>, <b_>dollars</b>' )
				),
				'after' => array(
					'default' => '',
					'name'    => __( 'After price', 'sue' ),
					'desc'    => sprintf( '%s<br>%s<br>%s: %s', __( 'This text will be shown right after plan price.', 'sue' ), __( 'It is a good place to add currency.', 'sue' ), __( 'Example values', 'sue' ), '<b_>$</b>, <b_>€</b>, <b_>¥</b>, <b_>euro</b>, <b_>dollars</b>' )
				),
				'period' => array(
					'default' => '',
					'name'    => __( 'Period', 'sue' ),
					'desc'    => sprintf( '%s<br>%s: <b_>%s</b>, <b_>%s</b>, <b_>%s</b>', __( 'Specify plan period. Leave this field empty to hide this text.', 'sue' ), __( 'Example values', 'sue' ), __( 'weekly', 'sue' ), __( 'per month', 'sue' ), __( '1 year', 'sue' ) )
				),
				'featured' => array(
					'type'    => 'bool',
					'default' => 'no',
					'name'    => __( 'Featured', 'sue' ),
					'desc'    => __( 'Show this plan as featured', 'sue' )
				),
				'background' => array(
					'type'    => 'color',
					'default' => '#f9f9f9',
					'name'    => __( 'Background color', 'sue' ),
					'desc'    => __( 'This color will be applied to the pricing plan head (plan name, price and period area)', 'sue' )
				),
				'color' => array(
					'type'    => 'color',
					'default' => '#333333',
					'name'    => __( 'Text color', 'sue' ),
					'desc'    => __( 'This color will be applied to the pricing plan head (plan name, price and period area)', 'sue' )
				),
				'border' => array(
					'type'    => 'color',
					'default' => '#eeeeee',
					'name'    => __( 'Border color', 'sue' ),
					'desc'    => __( 'Pick an border color for this plan', 'sue' )
				),
				'shadow' => array(
					'type'    => 'shadow',
					'default' => '0px 0px 25px #eeeeee',
					'name'    => __( 'Featured plan shadow', 'sue' ),
					'desc'    => __( 'Adjust box shadow value. Shadow will be only applied to the featured plans', 'sue' )
				),
				'icon' => array(
					'type'    => 'icon',
					'default' => '',
					'name'    => __( 'Icon', 'sue' ),
					'desc'    => __( 'You can add an icon to each pricing plan. Leave this field empty to hide icon', 'sue' )
				),
				'icon_color' => array(
					'type'    => 'color',
					'default' => '#333333',
					'name'    => __( 'Icon color', 'sue' ),
					'desc'    => __( 'Pick an icon color. This color will only be applied to the built-in icons', 'sue' )
				),
				'icon_size' => array(
					'type'    => 'slider',
					'min'     => 8,
					'max'     => 256,
					'step'    => 8,
					'default' => 48,
					'name'    => __( 'Icon size', 'sue' ),
					'desc'    => __( 'Specify icon size (px)', 'sue' )
				),
				'btn_url' => array(
					'default' => '',
					'name'    => __( 'Button URL', 'sue' ),
					'desc'    => __( 'Enter here the URL for button', 'sue' )
				),
				'btn_target' => array(
					'type'    => 'select',
					'default' => 'self',
					'name'    => __( 'Button link target', 'sue' ),
					'desc'    => __( 'Choose button link target', 'sue' ),
					'values'   => array(
						'self' => __( 'Open link in same window/tab', 'sue' ),
						'blank' => __( 'Open link in new window/tab', 'sue' )
					)
				),
				'btn_text' => array(
					'default' => '',
					'name'    => __( 'Button text', 'sue' ),
					'desc'    => sprintf( '%s<br>%s: <b_>%s</b>', __( 'Enter here the text for button.', 'sue' ), __( 'Example value', 'sue' ), __( 'Sign Up', 'sue' ) )
				),
				'btn_background' => array(
					'type'    => 'color',
					'default' => '#999999',
					'name'    => __( 'Button background color', 'sue' ),
					'desc'    => __( 'Choose button background color', 'sue' )
				),
				'btn_color' => array(
					'type'    => 'color',
					'default' => '#ffffff',
					'name'    => __( 'Button text color', 'sue' ),
					'desc'    => __( 'Choose button text color', 'sue' )
				),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			),
			'content' => sprintf( "<ul>\n<li>%s</li>\n<li>%s</li>\n<li>%s</li>\n</ul>", __( 'Option 1', 'sue' ), __( 'Option 2', 'sue' ), __( 'Option 3', 'sue' ) )
		);

		$shortcodes['testimonial'] = array(
			'name'     => __( 'Testimonial', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra box',
			'desc'     => __( 'Styled testimonial box', 'sue' ),
			'icon'     => 'comments-o',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'testimonial' ),
			'atts'     => array(
				'name' => array(
					'default' => '',
					'name'    => __( 'Person name', 'sue' ),
					'desc'    => __( 'Type here a testimonial author name', 'sue' )
				),
				'photo' => array(
					'type'    => 'upload',
					'default' => '',
					'name'    => __( 'Person photo', 'sue' ),
					'desc'    => __( 'Choose testimonial author photo', 'sue' )
				),
				'company' => array(
					'default' => '',
					'name'    => __( 'Company', 'sue' ),
					'desc'    => __( 'Type here a company name. Leave this field empty to hide company name', 'sue' )
				),
				'url' => array(
					'default' => '',
					'name'    => __( 'Company URL', 'sue' ),
					'desc'    => __( 'Type here a company URL. Leave this field empty to disable link', 'sue' )
				),
				'target' => array(
					'type'    => 'select',
					'default' => 'blank',
					'name'    => __( 'Link target', 'sue' ),
					'desc'    => __( 'Choose link target', 'sue' ),
					'values'   => array(
						'self' => __( 'Open link in same window/tab', 'sue' ),
						'blank' => __( 'Open link in new window/tab', 'sue' )
					)
				),
				'border' => array(
					'type'    => 'bool',
					'default' => 'yes',
					'name'    => __( 'Show border', 'sue' ),
					'desc'    => __( 'Show grey border around this testimonial', 'sue' )
				),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			),
			'content' => __( 'Testimonial text', 'sue' )
		);

		$shortcodes['icon'] = array(
			'name'     => __( 'Icon', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra content media',
			'desc'     => __( 'Fully customizable icon', 'sue' ),
			'icon'     => 'rocket',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'icon' ),
			'atts'     => array(
				'icon' => array(
					'type'    => 'icon',
					'default' => '',
					'name'    => __( 'Icon', 'sue' ),
					'desc'    => __( 'Choose icon shape', 'sue' )
				),
				'background' => array(
					'type'    => 'color',
					'default' => '#eeeeee',
					'name'    => __( 'Background', 'sue' ),
					'desc'    => __( 'Icon background color', 'sue' )
				),
				'color' => array(
					'type'    => 'color',
					'default' => '#333333',
					'name'    => __( 'Color', 'sue' ),
					'desc'    => __( 'Icon shape color. This color be only applied to the built-in icons', 'sue' )
				),
				'text_color' => array(
					'type'    => 'color',
					'default' => '#333333',
					'name'    => __( 'Text color', 'sue' ),
					'desc'    => __( 'Pick a color for icon text', 'sue' )
				),
				'size' => array(
					'type'    => 'slider',
					'default' => '32',
					'min'     => '4',
					'max'     => '256',
					'step'    => '4',
					'name'    => __( 'Size', 'sue' ),
					'desc'    => __( 'Icon size (px)', 'sue' )
				),
				'shape_size' => array(
					'type'    => 'slider',
					'default' => '16',
					'min'     => '4',
					'max'     => '256',
					'step'    => '4',
					'name'    => __( 'Shape size', 'sue' ),
					'desc'    => __( 'Background shape size (px)', 'sue' )
				),
				'radius' => array(
					'type'    => 'slider',
					'default' => '256',
					'min'     => '0',
					'max'     => '256',
					'step'    => '4',
					'name'    => __( 'Radius', 'sue' ),
					'desc'    => __( 'Icon background shape radius (px)', 'sue' )
				),
				'text_size' => array(
					'type'    => 'slider',
					'default' => '16',
					'min'     => '4',
					'max'     => '80',
					'step'    => '2',
					'name'    => __( 'Text size', 'sue' ),
					'desc'    => __( 'Icon text size (px)', 'sue' )
				),
				'margin' => array(
					'default' => '0px 20px 20px 0px',
					'name'    => __( 'Margin', 'sue' ),
					'desc'    => sprintf( '%s (px), [%s]', __( 'Icon margin', 'sue' ), __( 'top right bottom left', 'sue' ) )
				),
				'url' => array(
					'default' => '',
					'name'    => __( 'URL', 'sue' ),
					'desc'    => __( 'Icon link', 'sue' )
				),
				'target' => array(
					'type'    => 'select',
					'default' => 'blank',
					'name'    => __( 'Link target', 'sue' ),
					'desc'    => __( 'Choose icon link target', 'sue' ),
					'values'   => array(
						'self' => __( 'Open link in same window/tab', 'sue' ),
						'blank' => __( 'Open link in new window/tab', 'sue' )
					)
				),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			)
		);

		$shortcodes['content_slider'] = array(
			'name'     => __( 'Content slider', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra gallery',
			'desc'     => __( 'Advanced responsive content slider', 'sue' ),
			'icon'     => 'desktop',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'content_slider' ),
			'atts'     => array(
				'style' => array(
					'type'    => 'select',
					'default' => 'default',
					'name'    => __( 'Style', 'sue' ),
					'desc'    => __( 'Choose slider skin', 'sue' ),
					'values'   => array(
						'default' => __( 'Default', 'sue' ),
						'dark'    => __( 'Dark', 'sue' ),
						'light'   => __( 'Light', 'sue' )
					)
				),
				'effect' => array(
					'type'    => 'select',
					'default' => 'slide',
					'name'    => __( 'Effect', 'sue' ),
					'desc'    => __( 'Choose transition animation', 'sue' ),
					'values'   => array(
						'slide'     => __( 'Slide', 'sue' ),
						'fade'      => __( 'Fade', 'sue' ),
						'fadeUp'    => __( 'Fade Up', 'sue' ),
						'backSlide' => __( 'Back Slide', 'sue' ),
						'goDown'    => __( 'Go Down', 'sue' )
					)
				),
				'arrows' => array(
					'type'    => 'select',
					'default' => 'yes',
					'name'    => __( 'Show arrows', 'sue' ),
					'desc'    => __( 'Show left/right arrows navigation', 'sue' ),
					'values'   => array(
						'no'    => __( 'Never', 'sue' ),
						'hover' => __( 'On hover', 'sue' ),
						'yes'   => __( 'Always', 'sue' )
					)
				),
				'pages' => array(
					'type'    => 'select',
					'default' => 'no',
					'name'    => __( 'Show pages', 'sue' ),
					'desc'    => __( 'Show pagination navigation', 'sue' ),
					'values'   => array(
						'no'    => __( 'Never', 'sue' ),
						'hover' => __( 'On hover', 'sue' ),
						'yes'   => __( 'Always', 'sue' )
					)
				),
				'autoplay' => array(
					'type'    => 'slider',
					'default' => '5',
					'min'     => '0',
					'max'     => '60',
					'step'    => '0.5',
					'name'    => __( 'Autoplay', 'sue' ),
					'desc'    => __( 'Specify autoplay interval (seconds). Set to 0 to disable autoplay', 'sue' )
				),
				// 'speed' => array(
				// 	'type'    => 'slider',
				// 	'default' => '0.5',
				// 	'min'     => '0',
				// 	'max'     => '10',
				// 	'step'    => '0.1',
				// 	'name'    => __( 'Speed', 'sue' ),
				// 	'desc'    => __( 'Specify animation speed (seconds). This speed will be only used for slide transitions', 'sue' )
				// ),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			),
			'content' => sprintf( '[__content_slide] %1$s [/__content_slide]%2$s[__content_slide] %1$s [/__content_slide]%2$s[__content_slide] %1$s [/__content_slide]', __( 'Slide content', 'sue' ), "\n" )
		);

		$shortcodes['content_slide'] = array(
			'name'     => __( 'Content slide', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra gallery',
			'desc'     => __( 'Single content slide', 'sue' ),
			'icon'     => 'desktop',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'content_slide' ),
			'atts'     => array(
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			)
		);

		$shortcodes['shadow'] = array(
			'name'     => __( 'Shadow', 'sue' ),
			'type'     => 'wrap',
			'group'    => 'extra other',
			'desc'     => __( 'Adds shadow to any nested element', 'sue' ),
			'icon'     => 'moon-o',
			'function' => array( 'Shortcodes_Ultimate_Extra_Shortcodes', 'shadow' ),
			'atts'     => array(
				'style' => array(
					'type'    => 'select',
					'default' => 'default',
					'name'    => __( 'Style', 'sue' ),
					'desc'    => __( 'Choose shadow style', 'sue' ),
					'values'   => array(
						'default'    => __( 'Default', 'sue' ),
						'left'       => __( 'Left corner', 'sue' ),
						'right'      => __( 'Right corner', 'sue' ),
						'horizontal' => __( 'Horizontal', 'sue' ),
						'vertical'   => __( 'Vertical', 'sue' ),
						'bottom'     => __( 'Bottom', 'sue' ),
						'simple'     => __( 'Simple', 'sue' )
					)
				),
				'inline' => array(
					'type'    => 'bool',
					'default' => 'no',
					'name'    => __( 'Inline', 'sue' ),
					'desc'    => __( 'Display shadow container as an inline element. This option can be useful for small images and other inline elements', 'sue' )
				),
				'class' => array(
					'default' => '',
					'name'    => __( 'Class', 'sue' ),
					'desc'    => __( 'Extra CSS class', 'sue' )
				)
			)
		);

		return $shortcodes;
	}
}

new Shortcodes_Ultimate_Extra;
