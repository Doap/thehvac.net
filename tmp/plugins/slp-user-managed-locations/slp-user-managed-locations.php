<?php
/**
 * Plugin Name: Store Locator Plus : User Managed Locations
 * Plugin URI: http://www.charlestonsw.com/product/slp4-user-managed-locations/
 * Description: A premium add-on pack for Store Locator Plus that lets store editors manage their own locations.
 * Version: 4.1.008
 * Author: Charleston Software Associates - De B.A.A.T.
 * Author URI: http://www.de-baat.nl/
 * Requires at least: 3.8
 * Tested up to : 3.9
 * 
 * Text Domain: csa-slp-uml
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// No SLP? Get out...
//
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( !function_exists('is_plugin_active') ||  !is_plugin_active( 'store-locator-le/store-locator-le.php')) {
	return;
}

// Make sure the class is only defined once.
//
if (!class_exists('SLPUserManagedLocations')) {

	/**
	 * The User Managed Locations add-on pack for Store Locator Plus.
	 *
	 * @package StoreLocatorPlus\UserManagedLocations
	 * @author De B.A.A.T. <slp-uml@de-baat.nl>
	 * @copyright 2014 Charleston Software Associates, LLC - De B.A.A.T.
	 */
	class SLPUserManagedLocations {

		//-------------------------------------
		// Constants
		//-------------------------------------

		/**
		 * @const string VERSION the current plugin version.
		 */
		const VERSION           = '4.1.008';
		const DATA_VERSION      = '4.1.004';

		/**
		 * @const string MIN_SLP_VERSION the minimum SLP version required for this version of the plugin.
		 */
		const MIN_SLP_VERSION   = '4.1';

		/**
		 * Our admin page slug.
		 */
		const ADMIN_PAGE_SLUG = 'slp_user_managed_locations';

		/**
		 * Our user capabilities.
		 */
		const SLP_UML_ADMIN_CAPABILITY = 'manage_slp_admin';
		const SLP_UML_USER_CAPABILITY  = 'manage_slp_user';

		/**
		 * Our plugin slug.
		 */
		const PLUGIN_SLUG = 'slp-user-managed-locations';

		/**
		 * Our options are saved in this option name in the WordPress options table.
		 */
		const OPTION_NAME = 'slplus-user-managed-locations-options';

		/**
		 * Our User Managed Locations field slug.
		 */
		const SLP_UML_USER_SLUG = 'store_user';

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
                 * The file name for the base php file for this add-on.
                 * 
                 * @var string $file 
                 */
                public $file;                

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
		 * - extended_data_version = the Super Extendo data version that is installed
		 * - installed_version = the version of this add-on pack that is installed
		 *
		 * @var string[]
		 */
		public $options = array(
			'extended_data_version'     => '',
			'installed_version'         => '',
			'uml_publish_location'      => 'on',
		);

		/**
		 * The base class for the SLP plugin
		 *
		 * @var \SLPlus $slplus
		 **/
		public $plugin;

		/**
		 * Pointer to the AdminUI object for this plugin.
		 * 
		 * @var \SLPUML_AdminUI
		 */
		var $AdminUI;

		/**
		 * WordPress data about this plugin.
		 *
		 * Needed by wpCSL, so don't remove this property.
		 *
		 * @var mixed[] $metadata
		 */
		public $metadata;

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
				load_plugin_textdomain( 'csa-slp-uml', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
				$instance = new SLPUserManagedLocations();
			}
			return $instance;
		}

		/**
		 * Constructor
		 */
		function SLPUserManagedLocations() {
			$this->url = plugins_url('',__FILE__);
			$this->dir = plugin_dir_path(__FILE__);
			$this->slug = plugin_basename(__FILE__);
			$this->name = __('User Managed Locations','csa-slp-uml');
			$this->support_url = 'http://www.charlestonsw.com/support/documentation/store-locator-plus/user-managed-locations/';
			$this->support_url = 'http://www.charlestonsw.com/support/documentation/store-locator-plus/';
                        $this->file = __FILE__;                        

			add_action('slp_init_complete'          ,array($this,'slp_init'             )           );
			add_action('slp_admin_menu_starting'    ,array($this,'admin_menu'           )           );
			add_filter('slp_menu_items'             ,array($this,'filter_AddMenuItems'  ), 95       );

			// For development purposes:
			$role = get_role('administrator');
			if (is_object($role) && !$role->has_cap(SLPUserManagedLocations::SLP_UML_ADMIN_CAPABILITY)) {
				$role->add_cap('manage_slp');
				$role->add_cap(SLPUserManagedLocations::SLP_UML_ADMIN_CAPABILITY);
				$role->add_cap(SLPUserManagedLocations::SLP_UML_USER_CAPABILITY);
			}

		}

		/**
		 * Set the slplus property to point to the primary plugin object.
		 *
		 * Returns false if we can't get to the main plugin object.
		 *
		 * @global wpCSL_plugin__slplus $slplus_plugin
		 * @return type boolean true if slplus property is valid
		 */
		function setPlugin() {
			if (!isset($this->plugin) || ($this->plugin == null)) {
				global $slplus_plugin;
				$this->plugin = $slplus_plugin;
				$this->initOptions();
				$this->debugMP('msg',__FUNCTION__);
			}
			return (isset($this->plugin) && ($this->plugin != null));
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
		 * Initialize the options properties from the WordPress database.
		 *
		 * @param boolean $force
		 */
		function initOptions($force = false) {
			$dbOptions = get_option(SLPUserManagedLocations::OPTION_NAME);
			if (is_array($dbOptions)) {
				array_walk($dbOptions,array($this,'set_ValidOptions'));
			}
			$this->debugMP('pr',__FUNCTION__ . ' dbOptions=',$dbOptions);
		}

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
		 * If we are in admin mode, run our admin updates.
		 */
		function admin_init() {
			if (!$this->setPlugin()) { return ''; }
			$this->debugMP('msg',__FUNCTION__);
			$this->createobject_AdminInterface();
			$this->AdminUI->admin_init();
		}

		/**
		 * WordPress admin_menu hook.
		 *
		 * Do not put any hooks/filters here other than the admin init hook.
		 */
		function admin_menu(){
			add_action('admin_init' ,array($this,'admin_init'));
		}

		/**
		 * Add the tabs/main menu items.
		 *
		 * @param mixed[] $menuItems
		 * @return mixed[]
		 */
		function filter_AddMenuItems($menuItems) {
			$this->debugMP('msg',__FUNCTION__);
			return array_merge(
						$menuItems,
						array(
							array(
								'label'     => $this->name,
								'slug'      => SLPUserManagedLocations::ADMIN_PAGE_SLUG,
								'class'     => $this,
								'function'  => 'createpage_UserManagedLocations_Admin'
							),
						)
					);
		}

		/**
		 * Create the User Managed Locations Admin page.
		 *
		 * It is hooked here to ensure the AdminUI object is instantiated first.
		 */
		function createpage_UserManagedLocations_Admin() {
			$this->debugMP('msg',__FUNCTION__);
			$this->createobject_AdminInterface();
			$this->AdminUI->render_AdminPage();
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
		 * After SLP initializes, do this.
		 *
		 * SLP Action: slp_init_complete
		 *
		 * @return null
		 */
		function slp_init() {
			if (!$this->setPlugin()) { return; }

			// Check the base plugin minimum version requirement.
			//
			$this->plugin->VersionCheck(array(
				'addon_name'            => $this->name,
				'addon_slug'            => $this->slug,
				'min_required_version'  => SLPUserManagedLocations::MIN_SLP_VERSION
			));

			// Tell SLP we are here
			//
			$this->plugin->register_addon($this->slug,$this);

			// Add data selection filters
			//
			if ($this->plugin->database->is_Extended()) {
				add_filter('slp_extend_get_SQL',           array($this,'filter_ExtendedDataQueriesUML'));
			}
		}

		/**
		 * Create a User Managed Locations Debug My Plugin panel.
		 *
		 * @return null
		 */
		static function create_DMPPanels() {
			if (!isset($GLOBALS['DebugMyPlugin'])) { return; }
			if (class_exists('DMPPanelSLPUserManagedLocations') == false) {
				require_once(plugin_dir_path(__FILE__).'class.dmppanels.php');
			}
			$GLOBALS['DebugMyPlugin']->panels['slp.uml'] = new DMPPanelSLPUserManagedLocations();
		}

		/**
		 * Create an admin interface object.
		 *
		 * The admin interface handles all UI, API, and other admin-panel based operations.
		 */
		function createobject_AdminInterface() {
			$this->debugMP('msg',__FUNCTION__);
			if (class_exists('SLPUML_AdminUI') == false) {
				require_once(plugin_dir_path(__FILE__).'/include/class.adminui.php');
			}
			if (!isset($this->AdminUI)) {
				$this->AdminUI =
					new SLPUML_AdminUI(
						array(
							'parent'    => $this,
							'slplus'    => $this->plugin,
							'addon'     => $this,
						)
					);
			}
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
			if (($hdr!=='')) {
				$hdr = 'UML::' . $hdr;
			}
			$this->plugin->debugMP('slp.uml',$type,$hdr,$msg,NULL,NULL,true);
		}

		//-------------------------------------------------------------
		// METHODS :: THE STUFF THAT MAKES THIS ADD-ON UNIQUE
		//-------------------------------------------------------------

		/**
		 * Check whether the current user is a Store Admin.
		 *
		 * @param boolean $noAdmin - whether to validate for non-admins only, default = false
		 * @return boolean
		 */
		public function slp_uml_is_admin($noAdmin = false) {

			// User must be logged in
			if (!is_user_logged_in()) { return false; }

			// User can be wordpress admin
			if ($noAdmin && current_user_can('manage_options')) { return true; }

			// Check what current_user_can manage
			if (current_user_can(SLPUserManagedLocations::SLP_UML_ADMIN_CAPABILITY)) { return true; }

			return false;
		}

		/**
		 * Check whether the current user is a User Managed Locations.
		 *
		 * @param boolean $noAdmin - whether to validate for non-admins only, default = false
		 * @return boolean
		 */
		public function slp_uml_is_user($noAdmin = false) {

			// User must be logged in
			if (!is_user_logged_in()) { return false; }

			// User may not be wordpress admin if explicitly excluded
			if ($noAdmin && current_user_can('manage_options')) { return false; }

			// Check what current_user_can manage
			if (current_user_can(SLPUserManagedLocations::SLP_UML_USER_CAPABILITY)) { return true; }

			return false;
		}

		/**
		 * Get the value to use in searching SQL for User Managed Locations.
		 *
		 * @return string
		 */
		function slp_uml_get_where_current_user($userLogin = '') {

			// Find nothing if user not logged in
			if (!is_user_logged_in())           { return ''; }

			// Find all if current_user_can manage_slp
			if ((current_user_can(SLPUserManagedLocations::SLP_UML_ADMIN_CAPABILITY)) && ($userLogin == '')) {
				return '';
			}

			// Filter if user allowed as store editor
			if ($this->slp_uml_is_user()) {
				if ($userLogin == '') {
					$currentUser = wp_get_current_user();
					$currentUserLogin = $currentUser->user_login;
				} else {
					$currentUserLogin = $userLogin;
				}
				$addedWhereStatement = " (" . SLPUserManagedLocations::SLP_UML_USER_SLUG . " = '" . $currentUserLogin . "') ";
				$this->debugMP('pr',__FUNCTION__ . ' where ' . $addedWhereStatement . ' used for currentUser=' . $currentUserLogin);
				return $addedWhereStatement;
			}

			return '';
		}

		/**
		 * Get the value to use in searching SQL for User Managed Locations.
		 *
		 * @return string
		 */
		function slp_uml_where_filter_store_user($theStoreUser = '') {

			// Use theStoreUser as filter
			$addedWhereStatement = " (" . SLPUserManagedLocations::SLP_UML_USER_SLUG . " = '" . $theStoreUser . "') ";
			$this->debugMP('pr',__FUNCTION__ . ' where ' . $addedWhereStatement . ' used for theStoreUser=' . $theStoreUser);
			return $addedWhereStatement;
		}

		/**
		 * Allow the user for User Managed Locations
		 *
		 * @params string $umlUserLogin the login of the user to allow User Managed Locations
		 * @return boolean true when success
		 */
		function slp_uml_user_allow($umlUserLogin) {

			// Validate access and parameters
			if (!$this->slp_uml_is_admin()) { return false; }
			if ($umlUserLogin == '')        { return false; }

			$user = get_user_by( 'login', $umlUserLogin );
			$user->add_cap( 'manage_slp' );
			$user->add_cap( SLPUserManagedLocations::SLP_UML_USER_CAPABILITY );
			$this->debugMP('pr',__FUNCTION__,$user);

			return true;
		}

		/**
		 * Disallow the user for User Managed Locations
		 *
		 * @params string $umlUserLogin the login of the user to disallow User Managed Locations
		 * @return boolean true when success
		 */
		function slp_uml_user_disallow($umlUserLogin) {

			// Validate access and parameters
			if (!$this->slp_uml_is_admin()) { return false; }
			if ($umlUserLogin == '')        { return false; }

			$user = get_user_by( 'login', $umlUserLogin );
			$user->remove_cap( 'manage_slp' );
			$user->remove_cap( SLPUserManagedLocations::SLP_UML_USER_CAPABILITY );
			$this->debugMP('pr',__FUNCTION__ . ' user = ',$user);

			return true;
		}

		/**
		 * Extend the SQL query set for extended data queries for UML.
		 * 
		 * @param string $command
		 * @return string
		 */
		function filter_ExtendedDataQueriesUML($command) {

			switch ($command) {
				// WHERE
				//
				case 'where_store_user':
					if (!$this->slp_uml_is_admin()) { 
//						$addedSqlStatement = " (" . SLPUserManagedLocations::SLP_UML_USER_SLUG . " like '" . $this->slp_uml_get_current_user_value() . "') ";
						$addedSqlStatement = $this->slp_uml_get_where_current_user();
						$this->debugMP('msg',__FUNCTION__,' addedSqlStatement = ' . $addedSqlStatement);
						return $addedSqlStatement;
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
		 * Count all locations related to the extendo parameter.
		 *
		 * @params string $sqlStatement the existing SQL command for Select All
		 * @return integer
		 */
		function slp_count_filtered_locations($umlUserLogin) {

			$debugMsg = '';
			$sqlStatement  = "SELECT * FROM ".$this->plugin->db->prefix."store_locator ";
			if ($this->plugin->database->is_Extended()) {
				$sqlStatement .= $this->plugin->database->extension->filter_ExtendedDataQueries('join_extendo');
			}
			$sqlStatement .= " WHERE " . $this->slp_uml_get_where_current_user($umlUserLogin);

			$locationsFound = $this->plugin->db->get_results( $sqlStatement );
			$totalLocations = count($locationsFound);
			$this->debugMP('pr',__FUNCTION__.' locationsFound=',$locationsFound);

			return $totalLocations;
		}

	}

	// Fire 'er up...
	//
	add_action('init'           ,array('SLPUserManagedLocations','init'               ));
	add_action('dmp_addpanel'   ,array('SLPUserManagedLocations','create_DMPPanels'   ));
}
// Dad. Husband. Rum Lover. Code Geek. Not necessarily in that order. UserManagedLocations