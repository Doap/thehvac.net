<?php
/**
 * Plugin Name: Store Locator Plus : Social Media Extender
 * Plugin URI: http://www.charlestonsw.com/product/slp4-social-media-extender/
 * Description: A premium add-on pack for Store Locator Plus that lets store editors add social media functionality to locations.
 * Version: 4.1.005
 * Author: Charleston Software Associates - De B.A.A.T.
 * Author URI: http://charlestonsw.com/DeBAAT
 * Requires at least: 3.8
 * Tested up to : 3.8.1
 * 
 * Text Domain: csa-slp-sme
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// No SLP? Get out...
//
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( !function_exists('is_plugin_active') ||  !is_plugin_active( 'store-locator-le/store-locator-le.php')) {
	return;
}

// SLP_SME Plugin Dir and Url
//
if (defined('SLPLUS_PLUGINDIR_SME') === false) {
	define('SLPLUS_PLUGINDIR_SME', plugin_dir_path(__FILE__));
}
if (defined('SLPLUS_PLUGINURL_SME') === false) {
    define('SLPLUS_PLUGINURL_SME', plugins_url('',__FILE__));
}

// Make sure the class is only defined once.
//
if (!class_exists('SLPSocialMediaExtender'   )) {

	/**
	 * The Social Media Extender add-on pack for Store Locator Plus.
	 *
	 * @package StoreLocatorPlus\SocialMediaExtender
	 * @author De B.A.A.T. <slp-sme@de-baat.nl>
	 * @copyright 2014 Charleston Software Associates, LLC - De B.A.A.T.
	 */
	class SLPSocialMediaExtender {

		//-------------------------------------
		// Constants
		//-------------------------------------

		/**
		 * @const string VERSION the current plugin version.
		 */
		const SME_VERSION           = '4.1.004';
		const SOCIAL_DATA_VERSION   = '4.1.001';
		const SOCIAL_ICON_VERSION   = '4.1.001';

		/**
		 * @const string MIN_SLP_VERSION the minimum SLP version required for this version of the plugin.
		 */
		const MIN_SLP_VERSION   = '4.1';

		/**
		 * Our admin page slug.
		 */
		const ADMIN_PAGE_SLUG = 'slp_social_media_extender';

		/**
		 * Our plugin slug.
		 */
		const PLUGIN_SLUG = 'slp-social-media-extender';

		/**
		 * Our options are saved in this option name in the WordPress options table.
		 */
		const OPTION_NAME = 'slplus-social-media-extender-options';

		/**
		 * The prefix for the extended data fields.
		 */
		const SOCIAL_SLUG_PREFIX          = 'sme_social_';

		/**
		 * Our SocialObjects are saved in this WordPress table.
		 */
		const SLP_SOCIAL_TABLE = 'slp_social_objects';
		public $slp_social_table;
		private	$smeSocialSlugPrefixLen;

		//-------------------------------------
		// Properties
		//-------------------------------------

		/**
		 * The directory we live in.
		 *
		 * @var string $dir
		 */
		private $dir;

		/**
		 * WordPress data about this plugin.
		 *
		 * @var mixed[] $metadata
		 */
		public $metadata;

		/**
		 * Have the options been set?
		 *
		 * @var boolean
		 */
		private $optionsSet = false;

		/**
		 * Text name for this plugin.
		 *
		 * @var string $name
		 */
		public $name;

		/**
		 * Our plugin options.
		 *
		 * Version Control:
		 * - social_data_version = the Social Objects data version that is installed
		 * - social_icon_version = the Social Icons version that is installed
		 * - installed_version = the version of this add-on pack that is installed
		 *
		 * @var string[]
		 */
		public $options = array(
			'installed_version'              => '',
			'social_data_version'            => '',
			'social_icon_version'            => '',
			'social_icon_location'           => '',
			'sme_label_social_media'         => 'Social Media: ',
			'sme_show_option_all'            => 'Any',
			'sme_show_socials_on_search'     => '',
			'sme_default_icons'              => '',
			'sme_show_icon_array'            => '0',
			'sme_show_legend_text'           => '',
			'sme_hide_empty'                 => '',
		);

		/**
		 * The base class for the SLP plugin
		 *
		 * @var \SLPlus $plugin
		 **/
		private $plugin;

		/**
		 * Pointer to the AdminUI object for this plugin.
		 * 
		 * @var \SLPSME_Admin $Admin
		 */
		var $Admin;

		/**
		 * Slug for this plugin.
		 *
		 * @var string $slug
		 */
		public $slug;

		/**
		 * The url to this plugin admin features.
		 *
		 * @var string $url
		 */
		public $url;
		public $support_url;

		/**
		 * String to put a debug message in the AJAX mapdata responses.
		 *
		 * @var string $debugging
		 */
		private $debugging = '';

		/**
		 * The current social.
		 * 
		 * @var SLPSME_Social $helperSocial
		 */
		public $helperSocial;

		/**
		 * A shorthand for the Social objects.
		 *
		 * @var \SLPSME_Social
		 */
		public $socialObjects;

		/**
		 * Store socialObjects info in memory cache, don't keep hitting the database.
		 *
		 * @var mixed[] $socialObjectsCache
		 */
		private $socialObjectsCache;

		//--------------------------------------------------------------
		// METHODS :: PRIMARY INSTATIATION AND HELPERS FOR AN SLP ADD ON
		//
		// The slp_init hook ensures that SLP has been invoked and the
		// primary object is active before we start wiring in our SLP
		// depending calls.
		//
		// The slp_admin_menu_starting call happens even later and ONLY
		// when the admin panel is being called for the main plugin,
		// ensuring the primary SLP admin interfaces are active. Putting
		// admin only calls in admin_init reduces overhead.
		//--------------------------------------------------------------

		/**
		 * Invoke the plugin as singleton.
		 *
		 * @static
		 */
		public static function init() {
			static $instance = false;
			if ( !$instance ) {
				load_plugin_textdomain( 'csa-slp-sme', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
				$instance = new SLPSocialMediaExtender;
			}
			return $instance;
		}

		/**
		 * Constructor
		 *
		 * Hook to slp_init_complete and slp_admin_menu_starting only.
		 * This ensures we don't do anything until the SLP base plugin is running.
		 * Since plugins can load in any order (well, alphabetical) we need to ensure
		 * we go AFTER SLP.
		 *
		 * Properties, etc. should all go in the other methods for these hooks.
		 *
		 * slp_init_complete will run for ANY page, user or admin panel side.
		 * slp_admin_menu_starting will run ONLY for admin pages
		 *
		 * SLP Hook: slp_init_complete
		 * SLP Hook: slp_admin_menu_starting
		 */
		function SLPSocialMediaExtender() {
			$this->url = plugins_url('',__FILE__);
			$this->dir = plugin_dir_path(__FILE__);
			$this->slug = plugin_basename(__FILE__);
			$this->name = __('Social Media Extender','csa-slp-sme');
			$this->support_url = 'http://www.charlestonsw.com/support/documentation/store-locator-plus/social-media-extender/';

//			$this->plugin_path  = dirname( __FILE__ );
//			$this->plugin_url   = plugins_url('',__FILE__);

			add_action('slp_init_complete'          ,array($this,'slp_init')                            );
			add_action('slp_admin_menu_starting'    ,array($this,'admin_menu')                          );

		}

		/**
		 * After SLP initializes, do this.
		 *
		 * SLP Action: slp_init_complete
		 *
		 * @return null
		 */
		function slp_init() {
			if (!$this->setPlugin()) { return; }
//			$this->debugMP('msg',__FUNCTION__,' started!!!');

			// Check the base plugin minimum version requirement.
			//
			$this->plugin->VersionCheck(array(
				'addon_name'            => $this->name,
				'addon_slug'            => $this->slug,
				'min_required_version'  => SLPSocialMediaExtender::MIN_SLP_VERSION
			));

			// Tell SLP we are here
			//
			$this->plugin->register_addon($this->slug,$this);

			// Set Properties
			//
			$this->slp_social_table = $this->plugin->db->prefix . SLPSocialMediaExtender::SLP_SOCIAL_TABLE;
			$this->smeSocialSlugPrefixLen = strlen(SLPSocialMediaExtender::SOCIAL_SLUG_PREFIX);

			// General Init
			//
			$this->initOptions();
			$this->createobject_HelperSocial();


            // AJAX and other ubiquitous stuff
            // Save category data for stores taxonomy type
            //
//            add_filter   ('slp_location_filters_for_AJAX' ,array($this,'filter_JSONP_SearchBySocial')         );

			// Locator Pages and Store Pages Processing
			add_filter   ('slp_results_marker_data'       ,array($this,'filter_SetMapMarkersSME'              ),999   );
			add_filter   ('slp_layout'                    ,array($this,'filter_AddLegendSME'                  ),95    );
			add_filter   ('slp_shortcode_atts'            ,array($this,'filter_SetAllowedShortcodesSME'       )       );
//			add_filter   ('shortcode_slp_searchelement'   ,array($this,'filter_ProcessSearchElementSME'       )       );
//			add_filter   ('shortcode_storepage'           ,array($this,'filter_ProcessStorePageSME'           )       );
//			add_filter   ('slp_searchlayout'              ,array($this,'filter_ModifySearchLayoutSME'         ),990   );
			add_shortcode('social-media-extender'         ,array($this,'process_SocialMediaExtenderShortcode' )       );

			// Add data selection filters
			//
//			add_filter   ('slp_extend_get_SQL'            ,array($this,'filter_ExtendSelectSocialSME'         ),20    );
			add_filter   ('slp_extend_get_SQL'            ,array($this,'filter_ExtendedDataQueriesSME'        ),40    );
//			add_filter   ('slp_extend_get_SQL_selectall'  ,array($this,'filter_ExtendSelectAllSME'            )       );
//			add_filter   ('slp_locations_manage_filters'  ,array($this,'filter_AddManageLocationsFiltersSME'  )       );

		}

		/**
		 * Initialize the options properties from the WordPress database.
		 *
		 * @param boolean $force
		 */
		function initOptions($force = false) {
			if (!$force && $this->optionsSet) { return; }
			$this->debugMP('msg',__FUNCTION__);
			$dbOptions = get_option(SLPSocialMediaExtender::OPTION_NAME);
			if (is_array($dbOptions)) {
				array_walk($dbOptions,array($this,'set_ValidOptions'));
				$this->options = array_merge($this->options,$dbOptions);
			}
			$this->debugMP('pr',__FUNCTION__ . ' dbOptions:',$dbOptions);
			$this->optionsSet = true;
		}

		//-------------------------------------------------------------
		// METHODS :: PLUGIN OPTIONS
		//
		// The options property is a named array that is used to store
		// any add-on specific settings the user plays with.  They are
		// properties of this object that are serialized into the
		// wp_options database for permanent storage.
		//
		// They are saved manually by either using the hooks & filters
		// of SLP if we put settable items on pre-existing SLP admin
		// pages.
		//
		// If we create a new tab for this plugin then we create our
		// own action processor to save the options out as serialized
		// data.
		//-------------------------------------------------------------

		/**
		 * Set valid options from the incoming REQUEST
		 *
		 * @param mixed $val - the value of a form var
		 * @param string $key - the key for that form var
		 */
		function set_ValidOptions($val,$key) {
			$simpleKey = str_replace($this->plugin->prefix.'-','',$key);
			if (array_key_exists($simpleKey, $this->options)) {
				$this->options[$simpleKey] = stripslashes_deep($val);
			}
		}

		//-------------------------------------------------------------
		// METHODS :: STANDARD SLP ADD ON ADMIN INIT
		//
		// All admin related hooks and filters should go in admin init.
		//
		// AND admin init should be in a separate class file that is only
		// required when needed.
		//
		// This saves a ton of overhead on stacking admin-only calls
		// that will never get called unless you are on the admin
		// interface.
		//-------------------------------------------------------------

		/**
		 * Get our hooks & filters tied in to SLP.
		 *
		 * WordPress update checker and all admin-only things go in here.
		 *
		 * SLP Action: slp_admin_menu_starting
		 *
		 * @return null
		 */
		function admin_init() {
			if (!$this->setPlugin()) { return ''; }
			$this->debugMP('msg',__FUNCTION__);
	//		$this->AdminUI->createshorthand_SocialObjects();

			// Attach the admin object.
			//
			$this->createobject_Admin();

			// WordPress Update Checker - if this plugin is active
			//
			if (is_plugin_active($this->slug)) {
				$this->metadata = get_plugin_data(__FILE__, false, false);
				$this->Updates = new SLPlus_Updates(
						$this->metadata['Version'],
						$this->plugin->updater_url,
						$this->slug
						);
			}
		}

		/**
		 * Run when on admin page.
		 *
		 * Should only load CSS and JS and setup the admin_init hook.
		 *
		 * This ensures SLP is prepped for admin but waits until WordPress
		 * is further along before firing off related admin functions.
		 *
		 * SLP Action: slp_init_complete sets up...
		 *     WP Action: admin_menu
		 */
		function admin_menu(){
			$this->debugMP('msg',__FUNCTION__);

			// Admin Styles
			//
			add_action('admin_print_styles'     ,array($this, 'slp_sme_admin_stylesheets'));

			// Admin Actions
			//
			add_action('admin_init'             ,array($this,'admin_init'       )       );
			add_filter('slp_menu_items'         ,array($this,'add_menu_items'   ),120    );
		}

		/**
		 * Add our tag link to the main SLP navbar.
		 *
		 * SLP Action: slp_init_complete sets up...
		 *     WP Action: admin_menu sets up...
		 *         SLP Filter: slp_menu_items
		 *
		 *
		 * @param array $menuItems
		 * @return string
		 */
		function add_menu_items($menuItems) {
			if (!$this->setPlugin()) { return $menuItems; }
			$this->debugMP('msg',__FUNCTION__);
			return array_merge(
						$menuItems,
						array(
							array(
								'label'     => $this->name,
								'slug'      => SLPSocialMediaExtender::ADMIN_PAGE_SLUG,
								'class'     => $this,
								'function'  => 'renderPage_SLPSME_Admin'
							),
						)
					);
		}

		/**
		 * Create the Social Media Extender Admin page.
		 *
		 * It is hooked here to ensure the AdminUI object is instantiated first.
		 */
		function renderPage_SLPSME_Admin() {
			$this->debugMP('msg',__FUNCTION__);
			if (!$this->setPlugin()) { return ''; }
			$this->createobject_Admin();
			$this->Admin->render_AdminPage();
		}

		/**
		 * Register and enqueue the social-media-extender style sheets when needed.
		 */
		function slp_sme_admin_stylesheets() {
			$this->debugMP('msg',__FUNCTION__);
			wp_register_style('slp_sme_style', $this->url . '/css/admin.css');
			wp_enqueue_style ('slp_sme_style');

			wp_register_style('csl_slplus_admin_css', $this->plugin->plugin_url . '/css/admin.css');
			wp_enqueue_style ('csl_slplus_admin_css');
		}


		//-------------------------------------------------------------
		// METHODS :: STANDARD SLP HOOKS TO DEBUG BAR / DEBUG MY PLUGIN
		//
		// Debugging in SLP is all handled via the Debug Bar and
		// Debug My Plugin plugins.   If they are not active then the
		// debugging calls short-circuit to incur minimum CPU/RAM cost.
		//
		// Most SLP add-ons use DMP calls so there is one UX to dig
		// through the debugging stack.   /Tools/DebugMP in WP admin
		// panel has some useful settings like global counter & dump
		// REQUEST vars to the main panel.
		//-------------------------------------------------------------

		/**
		 * Set the plugin property to point to the primary plugin object.
		 *
		 * Returns false if we can't get to the main plugin object.
		 *
		 * @global wpCSL_plugin__slplus $slplus_plugin
		 * @return type boolean true if plugin property is valid
		 */
		function setPlugin() {
			if (!isset($this->plugin) || ($this->plugin == null)) {
				global $slplus_plugin;
				$this->plugin = $slplus_plugin;
				$this->debugMP('msg',__FUNCTION__);
			}
			return (isset($this->plugin) && ($this->plugin != null));
		}

		/**
		 * Simplify the plugin debugMP interface.
		 *
		 * Typical start of function call: $this->debugMP('msg',__FUNCTION__);
		 *
		 * @param string $type
		 * @param string $hdr
		 * @param string $msg
		 */
		function debugMP($type,$hdr,$msg='') {
			if (($type === 'msg') && ($msg!=='')) {
				$msg = esc_html($msg);
			}
			if ($hdr != '') { $hdr = 'SME::' . $hdr; }
			$this->plugin->debugMP('slp.sme',$type,$hdr,$msg,NULL,NULL,true);
		}

		/**
		 * Set the allowed shortcode attributes
		 *
		 * @param mixed[] $atts
		 */
		function filter_SetAllowedShortcodesSME($atts) {
			$this->debugMP('pr',__FUNCTION__ . ' atts: ', $atts);

			return array_merge(
					array(
						'show_social_icons'         => null,
						),
					$atts
				);
		}

		//====================================================
		// Helpers - Admin UI
		//====================================================


		/**
		 * Return the div string to render a social icon with a link to the account.
		 *
		 * @param array() $socialData - the data related to the social account
		 * @param string $theAccount - the social account
		 * @param boolean $showEmpty - show the icon image even when theAccount is empty
		 * @return string - the div text string with the image in it
		 */
		function show_SocialIcon($socialData = null, $theAccount = '', $showEmpty = false) {

			// Check whether there is an icon to show
			if ($socialData === null) { return; }
			if ($socialData === '')   { return; }
			$theHtml  = '';

			$theSlug    = (isset($socialData['sl_social_slug'])) ? $socialData['sl_social_slug'] : 'sl_social_slug';
			$theName    = (isset($socialData['sl_social_name'])) ? $socialData['sl_social_name'] : 'sl_social_name';
			$theBaseUrl = (isset($socialData['sl_base_url']))    ? $socialData['sl_base_url']    : '';
			$theIcon    = (isset($socialData['sl_icon']))        ? $socialData['sl_icon']        : '';

			// Show the social icon
			if ($theIcon !== '') {
				$theIconHtml =
					'<img src="'.$theIcon .'" '.
						'id="slp_social_icon_'.$theSlug.'" '.
						'class="slp_social_icon" '.
						'style="max-width:32px;" '.
						'alt="'.$theName.'" '.
						'title="'.$theName.'"/>'
					;
			}
			if (trim($theAccount) === '')   { 
				if ($showEmpty !== false) {
					$theHtml = $theIconHtml;
				} else {
					return '';
				}
			} else {
				$theHtml  = '';
//				$theHtml .= '<div class="slp_social_icon_image">';
				$theHtml .= '<a href="' . $theBaseUrl . $theAccount . '" target="_blank" style="max-width:32px;padding:2px;" >';
				$theHtml .= $theIconHtml;
				$theHtml .= '</a>';
//				$theHtml .= '</div>';
			}

			return $theHtml;
		}

		/**
		 * Return the div string to render an image.
		 *
		 * @param string $img - fully qualified image url
		 * @return string - the div text string with the image in it
		 */
		function show_Image($img = null) {
			if ($img === null) { return; }
			if ($img === '')   { return; }
			return '<div class="slp_social_data_image">' .
					   '<img src="'.$img.'"/>' .
				  '</div>'
				  ;
		}

		//----------------------------------
		// Create Methods
		//----------------------------------


		/**
		 * Get all Social Objects from the database
		 *
		 * @return socialObjects
		 */
		public function create_SocialObject($socialParams) {

			// Make sure the class is only defined once.
			if (class_exists('SLPSME_Social') == false) {
				require_once(plugin_dir_path(__FILE__).'/include/class.social.php'); 
			}

			// Make a dummy object for use by other classes
			$newSocialObject = new SLPSME_Social(array(
				'addon'     => $this,
				'slplus'    => $this->plugin,
				));

			// Fill it with optional new socialParams
			$newSocialObject->set_PropertiesViaArray($socialParams);
			$this->debugMP('pr',__FUNCTION__ . " done for socialParams: ",$socialParams);

			return $newSocialObject;
		}

		/**
		 * Create an admin interface object.
		 *
		 * The admin interface handles all UI, API, and other admin-panel based operations.
		 */
		function createobject_HelperSocial() {

			// Check whether the slp_social_table is already created
			if ( $this->plugin->db->get_var("SHOW TABLES LIKE '$this->slp_social_table'") != $this->slp_social_table ) { return; }

			// Get all SocialObjects
			$this->socialObjects = $this->get_SocialObjects();

			// Get the requested object
			if (isset($_REQUEST['social'])) {
				$socialValue = $_REQUEST['social'];
				if (is_array($socialValue)) {
					$socialValues = $socialValue;
					$helperSocial = $socialValue[0];
				} else {
					$socialValues[] = $socialValue;
					$helperSocial = $socialValue;
				}
				// Find the current socialObject
				foreach ($this->socialObjects as $curObj) {
					if ($curObj['sl_id'] == $helperSocial) {
						$this->helperSocial = $this->create_SocialObject($curObj);
						$this->debugMP('pr',__FUNCTION__.' found socialObjects',  $curObj);
						continue;
					}
				}
			} else {
				if (count($this->socialObjects) > 0) {
					$this->helperSocial = $this->create_SocialObject($this->socialObjects[0]);
				} else {
					// Make a dummy object for use by other classes
					$this->helperSocial = $this->create_SocialObject(array(
						'social_name' => 'Twitter',
						'social_slug' => 'twitter',
						'description' => __('The basic Twitter social media as provided by default.','csa-slp-sme'),
						'base_url'    => 'http://twitter.com/',
						'icon'        => 'Twitter',
						));
				}
			}
		}

		/**
		 * Create an admin interface object.
		 *
		 * The admin interface handles all UI, API, and other admin-panel based operations.
		 */
		function createobject_Admin() {
			if (!$this->setPlugin()) { return; }
			$this->debugMP('msg',__FUNCTION__);
			if (class_exists('SLPSME_Admin') == false) {
				require_once(plugin_dir_path(__FILE__).'/include/class.admin.php');
			}
			if (!isset($this->Admin)) {
				$this->Admin =
					new SLPSME_Admin(
						array(
							'parent'    => $this,
							'slplus'    => $this->plugin,
							'addon'     => $this,
						)
					);
			} else {

				// Admin skinning
				//
				add_filter('wpcsl_admin_slugs', array($this->Admin,'filter_AddOurAdminSlugSME'));
				$this->debugMP('msg',__FUNCTION__ . ' this->Admin already exists! AddOurAdminSlug already added too???');

			}
		}

		//----------------------------------
		// Create String Methods
		//----------------------------------

		/**
		 * Puts the socialObjects list on the search form for users to select socials by radio buttons
		 *
		 * @param boolean $showany show the any entry if true
		 */
		function createstring_SocialSearchRadioButtons($showany = false) {
			$HTML = '';
			$thejQuery = "onClick='jQuery(\"#socialTag\").val(this.value);'";
			$oneChecked = false;
			$hiddenValue = '';
			$allSocialObjects = $this->get_SocialObjects();
			$socialFirst = $allSocialObjects[0]['sl_social_slug'];
			foreach ($allSocialObjects as $curSocialObject) {
				$checked = false;
				$socialName = $curSocialObject['sl_social_name'];
				$socialSlug = $curSocialObject['sl_social_slug'];
				$clean_slug = preg_replace("/\((.*?)\)/", '$1',$socialSlug);
				if  (
						($clean_slug != $socialSlug) ||
						(!$oneChecked && !$showany && ($socialSlug == $socialFirst))
					 ){
					$checked = true;
					$oneChecked = true;
					$hiddenValue = $clean_slug;
				}
				$HTML .= '<span class="slp_checkbox_entry">';
				$HTML .= "<input type='radio' name='socialTag' value='$clean_slug' ";
				$HTML .= $thejQuery;
				$HTML .= ($checked?' checked':'').">";
				$HTML .= $socialName;
				$HTML .= '</span>';
			}

			if ($showany) {
				$HTML .= '<span class="slp_checkbox_entry">';
				$HTML .= "<input type='radio' name='socialTag' value='$clean_slug' ";
				$HTML .= $thejQuery;
				$HTML .= ($oneChecked?' checked':'').">";
				$HTML .= $this->options['sme_show_option_all'];
				$HTML .= '</span>';
			}

			// Hidden field to store selected tag for processing
			//
			$HTML .= "<input type='hidden' id='socialTag' name='socialTag' value='$hiddenValue'>";

			// JQuery to trigger the hidden field
			//
			$HTML .= "
				";
			return $HTML;
		}

		/**
		 * Create a cascading drop down array for socialObjects.
		 *
		 */
		function createstring_SocialSearchDropDown($showany = false) {
			$this->debugMP('msg',__FUNCTION__);

			// Build the socialObjects drop down object array
			//
			$allSocialObjects = $this->get_SocialObjects();
			$socialFirst = $allSocialObjects[0]['sl_social_slug'];

			$HTML = '<select id="socialTag" class="postform" name="socialTag">';

			// Show Any Option (blank value)
			//
			if ($showany) {
				$HTML .= "<option value='' selected='selected'>";
				$HTML .= $this->options['sme_show_option_all'];
				$HTML .= "</option>";
			}

			// Create the drop down HTML for each SocialObject found
			//
			foreach ($allSocialObjects as $curSocialObject) {
				$this->debugMP('pr',__FUNCTION__ . ' dropDownItem: ', $curSocialObject);

				$checked = false;
				$socialName = $curSocialObject['sl_social_name'];
				$socialSlug = $curSocialObject['sl_social_slug'];
				$clean_slug = preg_replace("/\((.*?)\)/", '$1',$socialSlug);
				if  (
						($clean_slug != $socialSlug) ||
						(!$showany && ($socialSlug == $socialFirst))
					 ){
					$checked = true;
				}

				$HTML .= "<option value='" . $clean_slug . "' ";
				$HTML .= ($checked)? " selected='selected' " : "";
				$HTML .= ">" . $socialName . "</option>";

			}

			$HTML.= "</select>";
            return $HTML;
		}

		/**
		 * Add our custom socialObjects selection div to the search form.
		 *
		 * @return string the HTML for this div appended to the other HTML
		 */
		function createstring_SocialDataSelector() {
			$this->debugMP('msg',__FUNCTION__ . ' for sme_show_socials_on_search: ' . $this->options['sme_show_socials_on_search']);

			if (!$this->setPlugin()) { return; }
			$HTML = '';
			// Process the socialTag selector type
			//
			switch ($this->options['sme_show_socials_on_search']) {

				case 'radiobutton':
					$HTML =
						'<div id="slp_sme_socialTag_selector" class="search_item">' .
							'<label for="socialTag">'.
								$this->options['sme_label_social_media']    .
							'</label>'.
							$this->createstring_SocialSearchRadioButtons($this->options['sme_show_option_all']).
						'</div>'
						;
					$this->debugMP('pr',__FUNCTION__ . ' radiobutton: ', $this->options['sme_show_socials_on_search']);
					break;
				case 'dropdown':
					$HTML =
						'<div id="slp_sme_socialTag_selector" class="search_item">' .
							'<label for="socialTag">'.
								$this->options['sme_label_social_media']    .
							'</label>'.
							$this->createstring_SocialSearchDropDown($this->options['sme_show_option_all']).
						'</div>'
						;
					$this->debugMP('pr',__FUNCTION__ . ' dropdown: ', $this->options['sme_show_socials_on_search']);
					break;

				default:
					$HTML = '';
					$this->debugMP('pr',__FUNCTION__ . ' NO sme_show_socials_on_search: ', $this->options['sme_show_socials_on_search']);
					break;
			}

			return $HTML;
		}

		/**
		 * Create the social icon array for a given location.
		 */
		function createstring_SocialIconArray() {
			$this->debugMP('msg',__FUNCTION__);

			$socialIconArray  = '';

			// Add the marker when the socialObject is used
			//
			if ($this->plugin->database->extension->has_ExtendedData()) {

				$extendedLocationData =
					((int)$this->plugin->currentLocation->id > 0)               ?
					$this->plugin->database->extension->get_data($this->plugin->currentLocation->id)   :
					null
					;

				// If data found...
				if ($extendedLocationData !== null) {
					// Get all registered socialObjects
					$allSocialObjects = $this->get_SocialObjects();

					// And add its slug to the set of markers
					foreach ($allSocialObjects as $curSocialObject) {
						$this->debugMP('pr',__FUNCTION__ . ' curSocialObject: ', $curSocialObject);
						$curSocialSlug = $this->make_SocialSlug($curSocialObject['sl_social_slug'], '', true);
						$socialIconArray .= $this->show_SocialIcon($curSocialObject, $extendedLocationData[$curSocialSlug], false);
					}
				} else {
//					$socialIconArray .= ' NoELD!';
				}
			}

			return $socialIconArray;
		}

		/**
		 * Create the LegendHTML String.
		 *
		 * @return string
		 */
		function createstring_LegendHTML() {
			$this->debugMP('msg',__FUNCTION__);
			$legendHTML = '';
			$this->debugMP('msg','','SLT: '.$this->options['sme_show_legend_text'].' means ' . (!empty($this->options['sme_show_legend_text'])?'show':'dont show'));
			// Add the marker when the socialObject is used
			//
			if ($this->plugin->database->extension->has_ExtendedData()) {

				$legendHTML .= '<div id="slp_sme_legend">';
				$legendHTML .= '<div id="slp_sme_list">';

				// Get all registered socialObjects
				$allSocialObjects = $this->get_SocialObjects();

				// And add its slug to the set of markers
				foreach ($allSocialObjects as $curSocialObject) {
					$curSocialSlug = $this->make_SocialSlug($curSocialObject['sl_social_slug'], '', true);
					$this->debugMP('pr','',' curSocialSlug= ' . $curSocialSlug);
					$legendHTML .= $this->show_SocialIcon($curSocialObject, '', false);
				}

				$legendHTML .= '</div>';
				$legendHTML .= '</div>';
			}

			return $legendHTML;
		}

		//----------------------------------
		// Filters
		//----------------------------------

		/**
		 * Add the social_data field to the csv export
		 *
		 * @param string[] $dbFields
		 */
		static function filter_AddCSVExportFieldsSME($dbFields) {
//			$this->debugMP('pr',__FUNCTION__ . ' dbFields: ', $dbFields);
			return array_merge(
						$dbFields,
						array('social_data')
					);
		}

        /**
         * Add the categry condition to the MySQL statement used to fetch locations with JSONP.
         *
         * @param type $currentFilters
         * @return type
         */
		function filter_JSONP_SearchBySocial($currentFilters) {
			return $currentFilters;
			if (!isset($_POST['formdata']) || ($_POST['formdata'] == '')){
				return $currentFilters;
			}

			// Set our JSON Post vars
			//
			$JSONPost = wp_parse_args($_POST['formdata'],array());

			// Don't have cat in the vars?  Don't add a new selection filter.
			//
			if (!isset($JSONPost['socialTag']) || ($JSONPost['socialTag'] <= 0)) {
				return $currentFilters;
			}

			//$this->create_DataObject();

			// Setup and clause to select stores by a specific socialTag
			//
			$filterSocialSlug = $this->make_SocialSlug($JSONPost['socialTag'], '', true);
			$SQL_SelectStoreBySocial = ' AND ' . $this->data->db->prepare($this->get_SQL_Social_Table('where_social_set'),$filterSocialSlug);

			$this->debugMP('msg',__FUNCTION__ . ' SQL_SelectStoreBySocial: ' . $SQL_SelectStoreBySocial);
			return array_merge($currentFilters,array($SQL_SelectStoreBySocial));
		}

		/**
		 * Add social_datas to the location data.
		 *
		 * @param mixed[] $locationArray
		 * @return mixed[]
		 */
		static function filter_AddCSVExportDataSME($locationArray) {
//			$this->debugMP('pr',__FUNCTION__ . ' BEFORE locationArray: ', $locationArray);
//            if (!class_exists('SLPSME_SocialData')) {
//                require_once(plugin_dir_path(__FILE__).'include/class.social-data.php');
//            }
//            $database = new SLPSME_SocialData();
//            $locationArray['social_data'] = '';
//            $offset = 0;
//            while ($social_data = $database->get_Record(array('slp_sme_selectall','whereslid'),$locationArray['sl_id'],$offset++)) {
//                $social_dataData = get_term($social_data['social_id'],'stores');
//                if (($social_dataData !== null) && !is_wp_error($social_dataData)) {
//                    $locationArray['social_data'] .= $social_dataData->slug . ',';
//                } else {
//                    if (is_wp_error($social_dataData)) {
//                        $locationArray['social_data'] .= $social_dataData->get_error_message();
//                    }
//                }
//            }
//            $locationArray['social_data'] = preg_replace('/,$/','',$locationArray['social_data']);
//			$this->debugMP('pr',__FUNCTION__ . ' AFTER locationArray: ', $locationArray);
			return $locationArray;
		}

		/**
		 * Add the SocialMediaExtender shortcode processing to whatever filter/hook we need it latched on to.
		 *
		 * The [social-media-extender] shortcode, used here, is setup in slp_init.
		 */
		function filter_AddLegendSME($layoutString) {
			$this->debugMP('msg',__FUNCTION__,$layoutString);
			$layoutString = do_shortcode($layoutString);
			return $layoutString;
		}

		/**
		 * Add Social Media Extender socialTag selector to search layout.
		 *
		 */
		function filter_ModifySearchLayoutSME($layout) {

			$this->debugMP('msg',__FUNCTION__. ' Layout = ',$layout);

			if ( empty( $this->options['sme_show_socials_on_search'] ) ) { return $layout; }

			if (preg_match('/\[slp_search_element\s+.*dropdown_with_label="socialTag".*\]/i',$layout)) { return $layout; }
			if (preg_match('/\[slp_search_element\s+.*selector_with_label="socialTag".*\]/i',$layout)) { return $layout; }
			return $layout . '[slp_search_element dropdown_with_label="socialTag"]';
		}

		/**
		 * Perform extra search form element processing.
		 *
		 * @param mixed[] $attributes
		 */
		function filter_ProcessSearchElementSME($attributes) {
			$this->debugMP('pr',__FUNCTION__,$attributes);

			foreach ($attributes as $name=>$value) {

				switch (strtolower($name)) {

					case 'selector_with_label':
					case 'dropdown_with_label':
						switch ($value) {
							case 'socialTag':
								return array(
									'hard_coded_value' =>
										!empty($this->options['sme_show_socials_on_search'])      ?
										$this->createstring_SocialDataSelector()             :
										''
									);
								break;

							default:
								break;
						}
						break;

					default:
						break;
				}
			}

			return $attributes;
		}

		/**
		 * Perform extra search form element processing.
		 *
		 * @param mixed[] $attributes
		 */
		function filter_ProcessStorePageSME($attributes) {
			$this->debugMP('pr',__FUNCTION__,$attributes);

			// Process the socialiconarray field only
			foreach ($attributes as $name=>$value) {

				switch (strtolower($name)) {

					case 'field':
						switch ($value) {
							case 'socialiconarray':
								return array(
									'hard_coded_value' => $this->createstring_SocialIconArray()
									);
								break;

							default:
								break;
						}
						break;

					default:
						break;
				}
			}

			return $attributes;
		}

		 /**
		  * Get the social-media-extender socialObjects data and use socialObjectsCache to cache it.
		  *
		  * @param String $social_slug
		  */
		 function get_SocialObjectFromCache($social_slug = '') {
			if ($social_slug == '') { return; }
			if (!isset($this->socialObjectsCache[$social_slug])) {
				$this->socialObjectsCache[$social_slug] = $this->get_SocialDataBySlug($social_slug);
			}
			$this->debugMP('pr',__FUNCTION__ . ' this->socialObjectsCache[social_slug]: ', $this->socialObjectsCache[$social_slug]);
			return $this->socialObjectsCache[$social_slug];
		 }

		/**
		 * Process the Social Media Extender shortcode
		 */
		function process_SocialMediaExtenderShortcode($atts) {
			$this->debugMP('pr',__FUNCTION__ . ' with attributes: ', $atts);
			$theKeys = array_map('strtolower',$atts);
			switch ($theKeys[0]) {
				case 'legend':
					return $this->createstring_LegendHTML();
					break;

				default:
					break;
			}
			return '';
		}

		/**
		 * Create a Social Media Extender Debug My Plugin panel.
		 *
		 * @return null
		 */
		static function create_DMPPanels() {
			if (!isset($GLOBALS['DebugMyPlugin'])) { return; }
			if (class_exists('DMPPanelSLPSocialMediaExtender') == false) {
				require_once(plugin_dir_path(__FILE__).'include/class.dmppanels.php');
			}
			$GLOBALS['DebugMyPlugin']->panels['slp.sme'] = new DMPPanelSLPSocialMediaExtender();
		}

		//-------------------------------------------------------------
		// METHODS :: THE STUFF THAT MAKES THIS ADD-ON UNIQUE
		//-------------------------------------------------------------


		/**
		 * Get an SQL statement for the slp_social_table database.
		 *
		 * @param string $command
		 * @return string
		 */
		function get_SQL_Social_Table($commandList) {
			$sqlStatement = '';
			if (!is_array($commandList)) { $commandList = array($commandList); }
			foreach ($commandList as $command) {
				switch ($command) {

					case 'create':

						$charset_collate = '';
						if ( ! empty($this->plugin->db->charset) )
							$charset_collate = "DEFAULT CHARACTER SET " . $this->plugin->db->charset;
						if ( ! empty($this->plugin->db->collate) )
							$charset_collate .= " COLLATE " . $this->plugin->db->collate;

						// Social Objects: Queries
						//
						return "CREATE TABLE {$this->slp_social_table} (
								sl_id mediumint(8) unsigned NOT NULL auto_increment,
								sl_social_name varchar(255) NULL,
								sl_social_slug varchar(255) NULL,
								sl_icon varchar(255) NULL,
								sl_description text NULL,
								sl_base_url varchar(255) NULL,
								sl_option_value longtext NULL,
								sl_lastupdated  timestamp NOT NULL default current_timestamp,			
								PRIMARY KEY  (sl_id),
								KEY sl_social_slug (sl_social_slug)
								)
								$charset_collate
								";
						break;

					case 'delete_by_id':
						return
							'DELETE FROM ' . $this->slp_social_table .
							' WHERE sl_id = %u '
							;
						break;

					case 'select_social_count_for_location':
						return
							'SELECT count(sl_id) FROM ' .  $this->slp_social_table . ' ' .
							'WHERE '.$this->plugin->plugin->database->info['table'].'.sl_id='.$this->slp_social_table.'.sl_id'
							;
						break;

					case 'social_selectall':
						$sqlStatement .= 'SELECT * FROM ' . $this->slp_social_table;
						break;

					case 'social_select_by_id':
						return
							'SELECT * FROM ' . $this->slp_social_table .
							' WHERE sl_id = %s';
						break;

					case 'social_select_by_slug':
						return
							'SELECT * FROM ' . $this->slp_social_table .
							' WHERE sl_social_slug = %s';
						break;

//					case 'select_by_keyandcat':
//						return
//							'SELECT * FROM ' . $this->slp_social_table   .
//							' WHERE sl_id = %u AND term_id = %u'            ;
//						break;
//
//					case 'select_where_location_has_social':
//						return
//							'SELECT sl_id, sl_option_value FROM ' . $this->plugin->plugin->database->info['table']  . ' ' .
//							"WHERE sl_option_value LIKE '%store_categories%'"                  ;
//						break; 

					case 'where_social_set':
						$sqlStatement .= " WHERE %s <> ''";
						break;

					case 'whereslid':
						$sqlStatement .= ' WHERE sl_id = %u ';
						break;

					default:
						break;
				}
			}
			return $sqlStatement;
		}

		/**
		 * Get all Social Objects from the database
		 *
		 * @return socialObjects
		 */
		public function get_SocialObjects($socID=null) {

			// Set the data query
			//
			if ($socID) {
				$socialQuery = $this->plugin->db->prepare($this->get_SQL_Social_Table('social_select_by_id'), $socID);
			} else {
				$socialQuery = $this->get_SQL_Social_Table('social_selectall');
			}
			$this->debugMP('msg',__FUNCTION__ . " SQL socialQuery: " . $socialQuery);

			// Get the slpSocials into the array
			//
			//$slpSocials = array();
			if ($slpSocials = $this->plugin->db->get_results($socialQuery,ARRAY_A)) {
				$this->debugMP('pr',__FUNCTION__ . " SQL socialQuery found slpSocials: ",$slpSocials);
			}

			return $slpSocials;
		}

		/**
		 * Get a Social data set from the database
		 *
		 * @return socialData
		 */
		public function get_SocialDataBySlug($socSlug = '') {

			$this->debugMP('msg',__FUNCTION__ . ' for socSlug: ' . $socSlug);
			$socialData = array();
			if ($socSlug == '') { return $socialData; }

			// Remove any SocialSlugPrefix
			$socialSlug = $this->remove_SocialSlugPrefix($socSlug);
			$this->debugMP('msg','',"socSlug translated into: " . $socialSlug);

			// Set the data query
			// 
			$socialQuery = $this->plugin->db->prepare($this->get_SQL_Social_Table('social_select_by_slug'), $socialSlug);
			$this->debugMP('msg','',"SQL socialQuery: " . $socialQuery);

			// Get the slpSocials into the array
			//
			//$slpSocials = array();
			if ($socialData = $this->plugin->db->get_results($socialQuery,ARRAY_A)) {
				$this->debugMP('pr',__FUNCTION__ . ' SQL socialQuery found socialData: ',$socialData);
			}

			if (count($socialData) > 0) {
				return $socialData[0];
			}
			return $socialData;
		}

		/**
		 * Extend the SQL query set for extended data queries for SME.
		 * 
		 * @param string $command
		 * @return string
		 */
//		function filter_ExtendSelectSocialSME($command) {
//
//			$sqlStatement = $this->get_SQL_Social_Table('social_selectall');
//			return $sqlStatement;
//		}

		/**
		 * Extend the SQL query set for extended data queries for SME.
		 * 
		 * @param string $command
		 * @return string
		 */
		function filter_ExtendedDataQueriesSME($command) {

//	echo '<h2>SQLFILTER Command: ' . $command . ' = function: ' . __FUNCTION__ . '</h2>';
//			return '';
			switch ($command) {
				// WHERE
				//
				case 'where_social_set':
					$addedSqlStatement = $this->get_SQL_Social_Table('where_social_set');
					$this->debugMP('msg',__FUNCTION__,' addedSqlStatement = ' . $addedSqlStatement);
					// Check whether a command was found
					if ($addedSqlStatement != '') {
						return $addedSqlStatement;
					} else {
						return $command;
					}
					break;


				// If the command is not matched it must be returned to the calling method.
				// This allows various add-on packs to "stack" SQL clause extensions.
				// Without it, this data extender would be the termination point, which
				// is NOT what most add-on packs should be doing.
				//
				default:
					return $command;
					break;
			}
		}

		/**
		 * Modify the marker array after it is loaded with SLP location data.
		 *
		 * @param named array $marker - the SLP data for a single marker
		 */
		function filter_SetMapMarkersSME($marker) {

			$this->debugMP('pr',__FUNCTION__ .' +++++++++++++++++++++++++++++++++++++++++++++++++++ started for markers:', $marker);
//			$this->debugMP('pr',__FUNCTION__ .' +++++++++++++++++++++++++++++++++++++++++++++++++++ started for _POST:', $_POST);


			$socialIconArray  = '';
			$filterOut = false;
//			$socialIconArray .= 'TEST: ' . count($_POST);
//			foreach ($marker as $key => $value) {
//				$socialIconArray .= 'M[' . $key . ']=' . $value . '; ';
//			}

			// Add the marker when the socialObject is used
			//
			if ($this->plugin->database->extension->has_ExtendedData()) {

				$extendedLocationData =
					((int)$this->plugin->currentLocation->id > 0)               ?
					$this->plugin->database->extension->get_data($this->plugin->currentLocation->id)   :
					null
					;

				// If data found...
				if ($extendedLocationData !== null) {

					// If we are looking for a specific socialTag,
					// check to see if it is assigned to this location
					//
//					$filterSocialTag = '';
//					if (isset($_POST['formdata']) && ($_POST['formdata'] != '')){
//						// Find socialTag in JSON Post vars
//						$JSONPost = wp_parse_args($_POST['formdata'],array());
//						if (isset($JSONPost['socialTag'])) {
//							$filterSocialTag = $JSONPost['socialTag'];
//						}
//					}

					// Get all registered socialObjects
					$allSocialObjects = $this->get_SocialObjects();
//					$filterSocialSlug = $this->make_SocialSlug($filterSocialTag, '', true);
//					$filterOut = ($extendedLocationData[$filterSocialSlug] == '');
//					$socialIconArray .= ' fit: ' . $filterSocialTag . ' OUT=' . $filterOut . '!';
//					$socialIconArray .= ' F[' . $filterSocialSlug . ']; ';
					
					// socialTag not found, filter this location out
//					if ($extendedLocationData[$filterSocialSlug] == '') {
//						$socialIconArray = ' FILTER OUT' . count($marker) . '!';
//						$filterOut = true;
//						return array();
//						return array(
//							'socialiconarray' => $socialIconArray,
//						);
//					}

					// And add its slug to the set of markers
					foreach ($allSocialObjects as $curSocialObject) {
						$this->debugMP('pr',__FUNCTION__ . ' curSocialObject: ', $curSocialObject);
						$curSocialSlug = $this->make_SocialSlug($curSocialObject['sl_social_slug'], '', true);
//						$socialIconArray .= $curSocialObject['sl_social_slug'] . ' = ' . $extendedLocationData[$curSocialSlug];
//						$filterOut = $filterOut || ($curSocialSlug === $filterSocialTag);
						$socialIconArray .= $this->show_SocialIcon($curSocialObject, $extendedLocationData[$curSocialSlug], false);
					}
				} else {
//					$socialIconArray .= ' NoELD!';
				}
			}

			// Return our modified array
			//
//			if ($filterOut) {
//				$marker['name'] = 'Geen match!';
////				return '';
//				return $marker;
//			}
			if ($this->options['sme_show_icon_array']) {
				return array_merge(
							$marker,
							array(
								'socialiconarray' => $socialIconArray,
							)
						);
			}
			return $marker;

		}

		/**
		 * Creates a slug value from the parameters given.
		 *
		 * @param string $title
		 * @param string $fallback
		 * @return string $sme_social_slug
		 */
		function make_SocialSlug($title, $fallback, $withPrefix = false) {

			$sme_social_slug = sanitize_title($title, $fallback, 'query');
			$sme_social_slug = str_replace('-','_',$sme_social_slug);

			// Add prefix if asked and slug not prefixed yet
			if ($withPrefix) {
				$sme_social_slug = $this->add_SocialSlugPrefix($sme_social_slug);
			}

			return $sme_social_slug;
		}

		/**
		 * Add the smeSocialPrefix if not added yet
		 *
		 * @param type $slug
		 * @return type
		 */
		public function add_SocialSlugPrefix($slug) {
			if (!$this->test_SocialSlugPrefix($slug)) {
				$slug = SLPSocialMediaExtender::SOCIAL_SLUG_PREFIX . strtolower($slug);
			}
			return $slug;
		}

		/**
		 * If the smeSocialPrefix is added, remove it
		 *
		 * @param type $slug
		 * @return type
		 */
		public function remove_SocialSlugPrefix($slug) {
			if ($this->test_SocialSlugPrefix($slug)) {
				$newSlug = substr($slug, $this->smeSocialSlugPrefixLen);
//				$this->debugMP('msg',__FUNCTION__ . ' into newSlug=' . $newSlug);
				return $newSlug;
			}
			return $slug;
		}

		/**
		 * Check if a slug starts with smeSocialPrefix
		 *
		 * @param type $slug
		 * @return type
		 */
		public function test_SocialSlugPrefix($slug) {
			return (strtolower(substr($slug, 0, $this->smeSocialSlugPrefixLen)) == SLPSocialMediaExtender::SOCIAL_SLUG_PREFIX);
		}

		/**
		 * Check if a URL starts with http://
		 *
		 * @param type $url
		 * @return type
		 */
		public function url_test($url) {
			return (strtolower(substr($url,0,7))=="http://");
		}

	}

	// Hook to invoke the plugin.
	//
	add_action('init'               ,array('SLPSocialMediaExtender','init'                ));
	add_action('dmp_addpanel'       ,array('SLPSocialMediaExtender','create_DMPPanels'    ));

	// Pro Pack AJAX Filters
	//
	add_filter('slp-pro-dbfields'   ,array('SLPSocialMediaExtender','filter_AddCSVExportFieldsSME'));
	add_filter('slp-pro-csvexport'  ,array('SLPSocialMediaExtender','filter_AddCSVExportDataSME'  ));

}

// Dad. Husband. Rum Lover. Code Geek. Not necessarily in that order. SocialMediaExtender