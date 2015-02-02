<?php
/**
 * Plugin Name: Store Locator Plus : Contact Extender
 * Plugin URI: http://www.charlestonsw.com/product/slp4-contact-extender/
 * Description: A premium add-on pack for Store Locator Plus that adds custom contact fields.
 * Version: 4.1.02
 * Author: Charleston Software Associates
 * Author URI: http://charlestonsw.com/
 * Requires at least: 3.3
 * Tested up to : 3.9.1
 * 
 * Text Domain: csa-slp-cex
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// No SLP? Get out...
//
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( !function_exists('is_plugin_active') ||  !is_plugin_active( 'store-locator-le/store-locator-le.php')) {
    return;
}

/**
 * The Contact add-on pack for Store Locator Plus.
 *
 * @package StoreLocatorPlus\Contacts
 * @author Lance Cleveland <lance@charlestonsw.com>
 * @copyright 2014 Charleston Software Associates, LLC
 */
class SLPExtendoContacts {

    //-------------------------------------
    // Constants
    //-------------------------------------

    /**
     * @const string VERSION the current plugin version.
     */
    const VERSION           = '4.1.02';
    
    /**
     * @const string DATA_VERSION only changes when extended data changes
     */
    const DATA_VERSION           = '4.1.02';    

    /**
     * @const string MIN_SLP_VERSION the minimum SLP version required for this version of the plugin.
     */
    const MIN_SLP_VERSION   = '4.1.04';
    
    /**
     * Our options are saved in this option name in the WordPress options table.
     */
    const OPTION_NAME = 'slplus-extendo-contacts-options';

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
     * WordPress data about this plugin.
     *
     * @var mixed[] $metadata
     */
    public $metadata;

    /**
     * Text name for this plugin.
     *
     * @var string $name
     */
    private $name;
    
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
    );

    /**
     * The base class for the SLP plugin
     *
     * @var \SLPlus $plugin
     **/
    public  $plugin;

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

    //-------------------------------------------------------------
    // METHODS :: PRIMARY INSTATIATION AND HELPERS FOR A SLP ADD ON
    //
    // The slp_init hook ensures that SLP has been invoked and the
    // primary object is active before we start wiring in our SLP
    // depending calls.
    //
    // The slp_admin_menu_starting call happens even later and ONLY
    // when the admin panel is being called for the main plugin,
    // ensuring the primary SLP admin interfaces are active. Putting
    // admin only calls in admin_init reduces overhead.
    //-------------------------------------------------------------

    /**
     * Invoke the plugin as singleton.
     *
     * @static
     */
    public static function init() {
        static $instance = false;
        if ( !$instance ) {
            load_plugin_textdomain( 'csa-slp-cex', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
            $instance = new SLPExtendoContacts();
        }
        return $instance;
    }

    /**
     * Constructor
     */
    function __construct() {
        $this->url = plugins_url('',__FILE__);
        $this->dir = plugin_dir_path(__FILE__);
        $this->slug = plugin_basename(__FILE__);
        $this->name = __('Super Extendo Contacts','csa-slp-cex');
        $this->file = __FILE__;

        add_action('slp_init_complete'          ,array($this,'slp_init'             )           );
        add_action('slp_admin_menu_starting'    ,array($this,'admin_menu'           )           );
    }

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
            $this->initOptions();
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
        $this->debugMP('msg','initOptions');
        $dbOptions = get_option(SLPExtendoContacts::OPTION_NAME);
        if (is_array($dbOptions)) {
            array_walk($dbOptions,array($this,'set_ValidOptions'));
        }
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
             'min_required_version'  => SLPExtendoContacts::MIN_SLP_VERSION
         ));

        // Tell SLP we are here
        //
         $this->plugin->register_addon($this->slug,$this);
    }

    /**
     * Create a Map Settings Debug My Plugin panel.
     *
     * @return null
     */
    static function create_DMPPanels() {
        if (!isset($GLOBALS['DebugMyPlugin'])) { return; }
        if (class_exists('DMPPanelSLPEXContacts') == false) {
            require_once(plugin_dir_path(__FILE__).'class.dmppanels.php');
        }
        $GLOBALS['DebugMyPlugin']->panels['slp.exc'] = new DMPPanelSLPEXContacts();
    }

    /**
     * Create and admin interface object.
     *
     * The admin interface handles all UI, API, and other admin-panel based operations.
     */
    function createobject_AdminInterface() {
        if (class_exists('SLPCEX_AdminUI') == false) {
            require_once(plugin_dir_path(__FILE__).'/include/class.adminui.php');
        }
        if (!isset($this->AdminUI)) {
            $this->AdminUI =
                new SLPCEX_AdminUI(
                    array(
                        'addon'   => $this,
                        'slplus'  => $this->plugin
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
        $this->plugin->debugMP('slp.exc',$type,$hdr,$msg,NULL,NULL,true);
    }

    //-------------------------------------------------------------
    // METHODS :: THE STUFF THAT MAKES THIS ADD-ON UNIQUE
    //-------------------------------------------------------------
}

// Fire 'er up...
//
add_action('init'           ,array('SLPExtendoContacts','init'               ));
add_action('dmp_addpanel'   ,array('SLPExtendoContacts','create_DMPPanels'   ));

// Dad. Explorer. Rum Lover. Code Geek. Not necessarily in that order.