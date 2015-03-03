<?php
/**
 * Plugin Name: Store Locator Plus : Enhanced Map
 * Plugin URI: http://www.storelocatorplus.com/product/slp4-enhanced-map/
 * Description: A premium add-on pack for Store Locator Plus that adds enhanced map UI to the plugin.
 * Version: 4.1.02
 * Author: Charleston Software Associates
 * Author URI: http://charlestonsw.com/
 * Requires at least: 3.4
 * Tested up to : 3.9.1
 *
 * Text Domain: csa-slp-em
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
if (!class_exists('SLPEnhancedMap'   )) {
    /**
     * The Enhanced Map Add-On Pack for Store Locator Plus.
     *
     * @package StoreLocatorPlus\EnhancedMap
     * @author Lance Cleveland <lance@charlestonsw.com>
     * @copyright 2012-2014 Charleston Software Associates, LLC
     */
    class SLPEnhancedMap {
        //-------------------------------------
        // Constants
        //-------------------------------------

        /**
         * @const string VERSION the current plugin version.
         */
        const VERSION           = '4.1.02';

        /**
         * @const string MIN_SLP_VERSION the minimum SLP version required for this version of the plugin.
         */
        const MIN_SLP_VERSION   = '4.1';

        /**
         * Our options are saved in this option name in the WordPress options table.
         */
        const OPTION_NAME = 'csl-slplus-EM-options';

        //-------------------------------------
        // Properties (all add-ons)
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
         * Text name for this plugin.
         *
         * @var string $name
         */
        private $name;

        /**
         * Have the options been set?
         *
         * @var boolean
         */
        private $optionsSet = false;

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
        private $slug;

        /**
         * The url to this plugin admin features.
         *
         * @var string $url
         */
        public $url;

        //-------------------------------------
        // Properties (most add-ons)
        //-------------------------------------

        /**
         * Settable options for this plugin.
         *
         * @var mixed[] $options
         */
        public  $options                = array(
            'bubblelayout'          => ''   ,
            'hide_bubble'           => '0'  ,
            'installed_version'     => ''   ,
            'no_autozoom'           => '0'  ,
            'no_homeicon_at_start'  => '0'  ,
            'maplayout'             => ''   ,
            'map_initial_display'   => 'map',
        );

        //------------------------------------------------------
        // Properties (this add on)
        //------------------------------------------------------

        //------------------------------------------------------
        // METHODS
        //------------------------------------------------------

        /**
         * Invoke the plugin.
         *
         * This ensures a singleton of this plugin.
         *
         * @static
         */
        public static function init() {
            static $instance = false;
            if ( !$instance ) {
                load_plugin_textdomain( 'csa-slp-em', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
                $instance = new SLPEnhancedMap;
            }
            return $instance;
        }

        /**
         * Constructor
         */
        function SLPEnhancedMap() {
            $this->slug = plugin_basename(__FILE__);
            $this->name = __('Enhanced Map','csa-slp-em');

            add_action('slp_init_complete'          ,array($this,'slp_init')                            );
            add_action('slp_admin_menu_starting'    ,array($this,'admin_menu')                          );
        }

        /**
         * After SLP initializes, do this.
         *
         * Runs on any page type where SLP is active (admin panel or UI).
         *
         * SLP Action: slp_init_complete
         *
         * @return null
         */
        function slp_init() {
            if (!$this->setPlugin()) { return; }

            // Set Properties
            //
            $this->url = plugins_url('',__FILE__);
            $this->dir = plugin_dir_path(__FILE__);

            // Check the base plugin minimum version requirement.
            //
            $this->plugin->VersionCheck(array(
                'addon_name'            => $this->name,
                'addon_slug'            => $this->slug,
                'min_required_version'  => SLPEnhancedMap::MIN_SLP_VERSION
            ));

            // Tell SLP we are here
            //
             $this->plugin->register_addon($this->slug,$this);

            // Hooks and Filters
            //
            add_filter('slp_map_center'                     ,array($this,'set_MapCenter')              );
            add_filter('slp_shortcode_atts'                 ,array($this,'extend_main_shortcode')   ,10);

            // User Interface Elements
            //
            add_filter('slp_js_options'                     ,array($this,'filter_ModifyJSOptions'   )   );
            add_filter('slp_map_html'                       ,array($this,'filter_ModifyMapOutput'   ),05);
            add_filter('slp_results_marker_data'            ,array($this,'filter_ModifyAJAXResponse'),10);
            add_filter('slp_script_data'                    ,array($this,'filter_ModifyScriptData'  ),10);
        }

        /**
         * Hook into WordPress admin init when SLP admin menu is started.
         */
        function admin_menu() {
            if (!$this->setPlugin()) { return; }
            add_action('admin_init'             ,array($this,'admin_init'       )       );
        }

        /**
         * Stuff we do when SLP is ready for admin and WordPress is too.
         */
        function admin_init() {

            // Attach the admin object.
            //
            $this->createobject_Admin();

            // WordPress Update Checker - if this plugin is active
            //
            if (is_plugin_active($this->slug)) {
                $this->metadata = get_plugin_data(__FILE__, false, false);
                if (!$this->setPlugin()) { return; }
                $this->Updates = new SLPlus_Updates(
                        $this->metadata['Version'],
                        $this->plugin->updater_url,
                        $this->slug
                        );
            }
        }

        /**
         * Set the plugin property to point to the primary plugin object.
         *
         * Returns false if we can't get to the main plugin object.
         *
         * @global wpCSL_plugin__slplus $slplus_plugin
         * @return boolean true if plugin property is valid
         */
        function setPlugin() {
            if (!isset($this->plugin) || ($this->plugin == null)) {
                global $slplus_plugin;
                $this->plugin = $slplus_plugin;
            }
           $this->initOptions();
            return (isset($this->plugin) && ($this->plugin != null));
        }

        /**
         * Change the map center as specified.
         *
         * @param string $addy original address (center of country)
         * @return string
         */
        function set_MapCenter($addy) {
            // Shortcode Processing, Takes Precedence
            //
            if (!empty($this->plugin->data['center_map_at']) && (preg_replace('/\W/','',$this->plugin->data['center_map_at']) != '')) {
                return str_replace(array("\r\n","\n","\r"),', ',esc_attr($this->plugin->data['center_map_at']));
            }
            return $addy;
        }

        /**
         * Initialize the options properties from the WordPress database.
         *
         * @param boolean $force
         */
        function initOptions($force = false) {
            if (!$force && $this->optionsSet) { return; }
            $this->debugMP('msg',__FUNCTION__);
            $this->optionsSet = true;
            $dbOptions = get_option(SLPLUS_PREFIX.'-EM-options');
            if (is_array($dbOptions)) {
                $this->options = array_merge($this->options,$dbOptions);
            }
            $this->debugMP('pr','',$this->options);
        }

        /**
         * Render a simplified map dive that is hidden.
         *
         * Used to replace the standard map rendering with a simple hidden version.
         */
        function render_hidden_map_div() {
            if (!$this->setPlugin()) { return; }

            $content =
                '<div id="map" ' .
                    'style="display: none; visibility: hidden;"' .
                    '>'.
                '</div>';

            echo apply_filters('slp_map_html',$content);
        }

        /**
         * Generate the HTML for the map on/off slider button if requested.
         *
         * @return string HTML for the map slider.
         */
        function CreateMapDisplaySlider() {
            $content =
                ($this->plugin->UI->ShortcodeOrSettingEnabled('show_maptoggle','show_maptoggle')) ?
                $this->plugin->UI->CreateSliderButton(
                        'maptoggle',
                        __('Map','csa-slp-em'),
                        !$this->plugin->UI->ShortcodeOrSettingEnabled('hide_map','enmap_hidemap'),
                        "jQuery('#map').toggle();jQuery('#slp_tagline').toggle();"
                        ):
                ''
                ;
            return $content;
            }

        /**
         * Create a Map Settings Debug My Plugin panel.
         *
         * @return null
         */
        static function create_DMPPanels() {
            if (!isset($GLOBALS['DebugMyPlugin'])) { return; }
            if (class_exists('DMPPanelSLPEM') == false) {
                require_once(plugin_dir_path(__FILE__).'class.dmppanels.php');
            }
            $GLOBALS['DebugMyPlugin']->panels['slp.em']           = new DMPPanelSLPEM();
        }

        /**
         * Create and attach the admin processing object.
         */
        function createobject_Admin() {
            if (!isset($this->Admin)) {
                require_once($this->dir.'include/class.admin.php');
                $this->Admin =
                    new SLPEnhancedMap_Admin(
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
         * @param string $type
         * @param string $hdr
         * @param string $msg
         */
        function debugMP($type,$hdr,$msg='') {
            $this->plugin->debugMP('slp.em',$type,$hdr,$msg,NULL,NULL,true);
        }

        /**
         * Extends the main SLP shortcode approved attributes list, setting defaults.
         *
         * This will extend the approved shortcode attributes to include the items listed.
         * The array key is the attribute name, the value is the default if the attribute is not set.
         *
         * @param array $valid_atts - current list of approved attributes
         */
        function extend_main_shortcode($valid_atts) {
            if (!$this->setPlugin()) { return array(); }

            return array_merge(
                    array(
                        'center_map_at'     => null,
                        'hide_map'          => null,
                        'show_maptoggle'    => null,
                        ),
                    $valid_atts
                );
        }

        /**
         * Modify the marker data.
         *
         * @param mixed[] $marker the current marker data
         */
        function filter_ModifyAJAXResponse($marker) {
            $locationIcon = '';
            
            // The Location-specific Map Marker is set
            //
            if ( isset( $marker['attributes']['marker'] ) ) {
                $locationIcon = $marker['attributes']['marker'];
            } elseif ( isset( $marker['icon'] ) ) {
                $locationIcon = $marker['icon'];
            }
            
            return
                array_merge(
                    $marker,
                    array(
                        'icon' => $locationIcon
                    )
                );
        }

        /**
         * Modify the script data array prior to localization.
         *
         * Here we merge the options from this add-on pack to the main options.
         *
         * @param mixed $scriptData
         */
        function filter_ModifyScriptData($scriptData) {
            return array_merge(
                    $scriptData,
                    array(
                        'options' => array_merge($scriptData['options'],$this->options)
                    )
                );
        }

        /**
         * Modify the slplus.options object going into SLP.js
         *
         * @param mixed[] $options
         */
        function filter_ModifyJSOptions($options) {
            if ($this->plugin->is_CheckTrue($this->options['hide_bubble'])) { $this->options['bubblelayout'] = ''; }
            return array_merge($options, $this->options);
        }

        /**
         * Modify the map layout.
         *
         * @param type $HTML
         * @return type
         */
        function filter_ModifyMapOutput($HTML) {
            $this->debugMP('msg','map_initial_display is:' . $this->options['map_initial_display']);
            //---------------------
            // Hide The Map?
            //
            if ($this->plugin->UI->ShortcodeOrSettingEnabled('hide_map','enmap_hidemap')) {
                return '<div id="map" style="display:none;"></div>';
            }


            //---------------------
            // Map Layout
            //
            $HTML .=
              empty($this->options['maplayout'])            ?
                    $this->plugin->defaults['maplayout']    :
                    $this->options['maplayout']             ;

            //---------------------
            // Map Toggle Addition
            //
            if (!isset($this->plugin->data['show_maptoggle'])) {
                $this->plugin->data['show_maptoggle'] = (
                    ($this->plugin->settings->get_item('show_maptoggle',0) == 1) ?
                        'true' :
                        'false'
                    );
            }
            $HTML = 
                $this->CreateMapDisplaySlider() .
                $HTML
                ;

            if ($this->options['map_initial_display'] == 'hide') {
                //---------------------
                // Map hidden
                //
                $HTML = 
                    '<div id="map_box_map">' .
                        $HTML .
                    '</div>';
            } else if ($this->options['map_initial_display'] == 'image') {
                //---------------------
                // Starting Image
                //
                $startingImage          = get_option('sl_starting_image','');
                $startingImageActive    = !empty($startingImage);
                if ($startingImageActive) {

                    // Make sure URL starts with the pluging URL if it is not an absolute URL
                    //
                    $startingImage =
                        ((preg_match('/^http/',$startingImage) <= 0) ?SLPLUS_PLUGINURL:'') .
                        $startingImage
                        ;
    
                    $HTML =
                        '<div id="map_box_image" ' .
                            'style="'.
                                "width:". $this->plugin->data['sl_map_width'].
                                          $this->plugin->data['sl_map_width_units'] .
                                          ';'.
                                "height:".$this->plugin->data['sl_map_height'].
                                          $this->plugin->data['sl_map_height_units'].
                                          ';'.
                            '"'.
                        '>'.
                            "<img src='{$startingImage}'>".
                        '</div>' .
                        '<div id="map_box_map">' .
                            $HTML .
                        '</div>'
                        ;
                }
            }
            return $HTML;
        }
    }

    // Hook to invoke the plugin.
    //
    add_action('init'           ,array('SLPEnhancedMap','init'              ));
    add_action('dmp_addpanel'   ,array('SLPEnhancedMap','create_DMPPanels'  ));
}
// Dad. Husband. Rum Lover. Code Geek. Not necessarily in that order.
