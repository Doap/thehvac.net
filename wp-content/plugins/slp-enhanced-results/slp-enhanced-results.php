<?php
/**
 * Plugin Name: Store Locator Plus : Enhanced Results
 * Plugin URI: http://www.storelocatorplus.com/product/slp4-enhanced-results/
 * Description: A premium add-on pack for Store Locator Plus that adds enhanced search results to the plugin.
 * Version: 4.1.10
 * Author: Charleston Software Associates
 * Author URI: http://charlestonsw.com/
 * Requires at least: 3.4
 * Tested up to : 3.9.1
 *
 * Text Domain: csa-slp-er
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
if (!class_exists('SLPEnhancedResults'   )) {
    /**
     * The Enhanced Results Add-On Pack for Store Locator Plus.
     *
     * @package StoreLocatorPlus\EnhancedResults
     * @author Lance Cleveland <lance@charlestonsw.com>
     * @copyright 2012-2014 Charleston Software Associates, LLC
     */
    class SLPEnhancedResults {
        //-------------------------------------
        // Constants
        //-------------------------------------
        
        /**
         * @const string VERSION the current plugin version.
         */
        const VERSION           = '4.1.10';
        
        /**
         * @const string DATA_VERSION only changes when extended data changes
         */
        const DATA_VERSION           = '4.1.10';

        /**
         * @const string MIN_SLP_VERSION the minimum SLP version required for this version of the plugin.
         */
        const MIN_SLP_VERSION   = '4.1.16';

        /**
         * Our options are saved in this option name in the WordPress options table.
         */
        const OPTION_NAME = 'csl-slplus-ER-options';

        //-------------------------------------
        // Properties (all add-ons)
        //-------------------------------------

        /**
         * The admin interface object.
         *
         * @var \SLPEnhancedResults_Admin $Admin
         */
        private $Admin;

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
        public $name;

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
        public  $slplus;

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

        //-------------------------------------
        // Properties (most add-ons)
        //-------------------------------------

        /**
         * Settable options for this plugin.
         * 
         * Since these options are being merged with the main plugin options on 
         * their way into the localize call for the JavaScript on the UI, it is
         * best to try to make these unique from all other options in the SLPlus
         * ecosystem.  That includes the base plugin and all add-on packs.
         *
         * Plugin meta data:
         * o extended_data_version <string> the current extended data table version that has been installed.
         * o installed_version <string> the current installed version of this add-on pack.
         *
         * UI options:
         * o add_tel_to_phone <boolean> add tel: prefix to phone field output '0'/'1'
         * o orderby <string> the order by sort
         * o resultslayout <strong> the custom results layout string
         * o show_country <boolean> show country toggle '0'/'1'
         * o show_hours <boolean> show hours toggle '0'/'1'
         * o featured_locations_display_type <string> how to render featured locations
         *
         * @var mixed[] $options
         */
        public  $options                = array(
            'add_tel_to_phone'               => '0'                  ,
            'extended_data_version'          => ''                   ,
            'installed_version'              => ''                   ,
            'orderby'                        => 'sl_distance ASC'    ,
            'resultslayout'                  => ''                   ,
            'show_country'                   => '0'                  ,
            'show_hours'                     => '1'                  ,
            'featured_location_display_type' => 'show_within_radius' ,
        );

        //------------------------------------------------------
        // METHODS
        //------------------------------------------------------
        /**
         * Invoke the Enhanced Results plugin.
         *
         * @static
         */
        public static function init() {
            static $instance = false;
            if ( !$instance ) {
                load_plugin_textdomain( 'csa-slp-er', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
                $instance = new SLPEnhancedResults;
            }
            return $instance;
        }

        /**
         * Constructor
         */
        function SLPEnhancedResults() {
            $this->dir = plugin_dir_path(__FILE__);
            $this->name = __('Enhanced Results','csa-slp-er');
            $this->url = plugins_url('',__FILE__);
            $this->slug = plugin_basename(__FILE__);

            add_action('slp_init_complete'          ,array($this,'slp_init')                            );
            add_action('slp_admin_menu_starting'    ,array($this,'admin_menu'));
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

            // Check the base plugin minimum version requirement.
            //
            $this->slplus->VersionCheck(array(
                'addon_name'            => $this->name,
                'addon_slug'            => $this->slug,
                'min_required_version'  => SLPEnhancedResults::MIN_SLP_VERSION
            ));

            // Tell SLP we are here
            //
            $this->slplus->register_addon($this->slug,$this);

            // Hooks and Filters
            //
            add_filter('slp_results_marker_data'                , array( $this , 'modify_marker'                    )           );
            add_filter('slp_javascript_results_string'          , array( $this , 'mangle_results_output'            ), 90       );
            add_filter('slp_script_data'                        , array( $this , 'filter_ModifyScriptData'          ), 90       );
            add_filter('slp_ajaxsql_orderby'                    , array( $this , 'filter_AJAX_ModifyOrderBy'        ), 40       );
            add_filter('slp_ajaxsql_results'                    , array( $this , 'filter_AJAX_ModifyResults'        ), 50       );
            add_filter('slp_location_having_filters_for_AJAX'   , array( $this , 'filter_AJAX_AddHavingClause'      ), 50       );

            add_filter('slp_column_data'                        , array( $this , 'filter_FieldDataToManageLocations'), 90 , 3   );

            // Shortcode attributes
            //
            add_filter('slp_shortcode_atts'                     , array( $this ,'filter_SetAllowedShortcodeAtts'    ), 90 , 3   );
            
            // AJAX Helpers
            //
            add_filter( 'slp_js_options'                        , array( $this , 'filter_AddOptionsToJS'            )           );
            
            // Pro Pack Export
            //
            add_filter('slp-pro-dbfields'                       , array( $this , 'filter_Locations_Export_Field'    ), 90       );
            add_filter('slp-pro-csvexport'                      , array( $this , 'filter_Locations_Export_Data'     ), 90       );                        
        }

        //====================================================
        // Helpers
        //====================================================

        /**
         * Set the plugin property to point to the primary plugin object.
         *
         * Returns false if we can't get to the main plugin object.
         *
         * @global wpCSL_plugin__slplus $slplus_plugin
         * @return boolean true if plugin property is valid
         */
        function setPlugin() {
            if (!isset($this->slplus) || ($this->slplus == null)) {
                global $slplus_plugin;
                $this->slplus = $slplus_plugin;
            }
           $this->initOptions();
            return (isset($this->slplus) && ($this->slplus != null));
        }


        //====================================================
        // WordPress Admin Actions
        //====================================================

        /**
         * WordPress admin_init hook.
         */
        function admin_init(){
            if (!$this->setPlugin()) { return ''; }
            $this->createobject_Admin();

            // WordPress Update Checker - if this plugin is active
            //
            if (is_plugin_active($this->slug)) {
                $this->metadata = get_plugin_data(__FILE__, false, false);
                $this->Updates = new SLPlus_Updates(
                        $this->metadata['Version'],
                        $this->slplus->updater_url,
                        $this->slug
                        );
            }

            // Activation/Update Processing
            //
            if (
               (version_compare($this->options['installed_version']     , SLPEnhancedResults::VERSION, '<')) ||
               (version_compare($this->options['extended_data_version'] , SLPEnhancedResults::VERSION, '<'))
               ){
                if (class_exists('SLPER_Activation') == false) {
                    require_once(plugin_dir_path(__FILE__).'include/class.activation.php');
                }
                $this->activation = new SLPER_Activation(array('addon'=>$this));
                $this->activation->update();
                $this->options['installed_version'] = SLPEnhancedResults::VERSION;
                update_option(SLPEnhancedResults::OPTION_NAME,$this->options);
            }
        }

        /**
         * WordPress admin_menu hook for Enhanced Results.
         */
        function admin_menu(){
            $this->adminMode = true;
            add_action('admin_init' , array($this,'admin_init'));
        }

        /**
         * Create a Map Settings Debug My Plugin panel.
         *
         * @return null
         */
        static function create_DMPPanels() {
            if (!isset($GLOBALS['DebugMyPlugin'])) { return; }
            if (class_exists('DMPPanelSLPER') == false) {
                require_once(plugin_dir_path(__FILE__).'class.dmppanels.php');
            }
            $GLOBALS['DebugMyPlugin']->panels['slp.er'] = new DMPPanelSLPER();
        }


        /**
         * Create and attach the admin processing object.
         */
        function createobject_Admin() {
            if (!isset($this->Admin)) {
                require_once($this->dir.'include/class.admin.php');
                $this->Admin =
                    new SLPEnhancedResults_Admin(
                        array(
                            'addon'     => $this,
                            'slplus'    => $this->slplus,
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
            $this->slplus->debugMP('slp.er',$type,$hdr,$msg,NULL,NULL,true);
        }

        /**
         * Add the options from this plugin to the list of options going to JavaScript on the UI.
         * 
         * @param mixed[] $options the current options array going into the JS localize call
         * @return mixed[] the options array with this plugin's options added to it
         */
        public function filter_AddOptionsToJS( $options ) {
            $this->debugMP( 'msg' , __FUNCTION__ );
            $this->options['orderby'] = isset( $options['order_by'] ) ? $options['order_by'] : $this->options['orderby'];
            
            // Make booleans '1' or '0' strings
            //
            $this->options['immediately_show_locations'] = ( $this->slplus->UI->ShortcodeOrSettingEnabled( 'immediately_show_locations' ) ? '1' : '0' );

            $this->debugMP( 'pr' , '', $this->options );
            
            return
                array_merge(
                    $options,
                    $this->options
                );
        }
        
        /**
         * Extends the main SLP shortcode approved attributes list, setting defaults.
         *
         * This will extend the approved shortcode attributes to include the items listed.
         * The array key is the attribute name, the value is the default if the attribute is not set.
         * 
         * NOTE: THIS SHOULD SET ACTUAL VALUES BASED ON ATTRIBUTES
         * This is the last change to do this as localizeScript gets no data about shortcode
         * attribute settings.
         * 
         * The attribute values are set in the SLP UI class render_shortcode method via WordPress core
         * functions.
         *
         * @param mixed[] $attArray current list of approved attributes in slug => default value pairs.
         * @param mixed[] $attributes the shortcode attributes as entered by the user
         * @param string $content
         */
        function filter_SetAllowedShortcodeAtts($attArray,$attributes,$content) {
            $this->debugMP('msg',__FUNCTION__);
            $this->debugMP('pr','attributes',$attributes);
            
            $allowed_atts = array();
            $allowed_atts['immediately_show_locations'] = 
                isset( $attributes['immediately_show_locations'] )                       ? 
                    $this->slplus->is_CheckTrue( $attributes['immediately_show_locations'] ) :
                    $this->slplus->options['immediately_show_locations']
                ;
            $allowed_atts['order_by']                   = $this->options['orderby'];
            $this->debugMP('pr','',$allowed_atts);
            return array_merge($allowed_atts,$attArray);
	}
		
        /**
         * Change the export location row data.
         *
         * @param mixed[] $location A location data ih associated array
         * @return mixed[] Location data need to export
         */
        function filter_Locations_Export_Data($location) {
            $this->slplus->database->createobject_DatabaseExtension();
            $exData = $this->slplus->database->extension->get_data($location['sl_id']);
            $location['featured'] = isset($exData['featured']) && $this->slplus->is_CheckTrue($exData['featured']) ? '1' : '0';
            $location['rank'    ] = isset($exData['rank']) ? $exData['rank'] : '';

            return $location;
        }

        /**
         * Change the export location field.
         *
         * @param mixed[] $location Field array
         * @return mixed[] Fields need to export
         */
        function filter_Locations_Export_Field($dbFields) {
            array_push($dbFields, 'featured');
            array_push($dbFields, 'rank'    );

            return $dbFields;
        }

        /**
         * Change the results order based on admin panel settings.
         *
         * @param string $orderby the current order by clause
         * @return string modified order by clause
         */
        function filter_AJAX_ModifyOrderBy( $orderby ) {
            
            $our_order = 
                ( ! empty( $this->slplus->options['orderby'] ) )    ? 
                    $this->slplus->options['orderby']               :   
                    $this->options['orderby']                       ;
            
            $sql_order_by_clause = '';            
            switch ( $our_order ) {
                case 'random':
                    $sql_order_by_clause = 'sl_distance ASC';
                    break;
                default:
                    $sql_order_by_clause = $our_order;
                    break;
            }

            return $this->slplus->database->extend_OrderBy($orderby,$sql_order_by_clause);
        }

        /**
         * Randomize the results order if random order is selected for search results output.
         *
         * @param mixed[] $results the named array location results from an AJAX search
         * @return mixed[]
         */
        function filter_AJAX_ModifyResults($results) {
            if ( $this->options['orderby'] === 'random' ) {
                shuffle($results);
            }
            return $results;
        }

        /**
         * Add having clause to sql which do query work by ajaxhandler
         *
         * @param mixed[] having cluuse array
         * @return mixed[]
         */
        function filter_AJAX_AddHavingClause($clauseArray) {
            if ( $this->options['featured_location_display_type'] === 'show_always' ) {
                array_push( $clauseArray, ' OR (featured = 1) ');
            }
            return $clauseArray;
        }

        /**
         * Augment the Script Data variables passed into csl.js
         *
         * @param mixed[] $scriptData key = script var name, value = setting
         * @return mixed[] modified script data array
         */
        function filter_ModifyScriptData($scriptData) {
            return array_merge(
                $scriptData,
                array(
                    'disable_dir'       => (get_option(SLPLUS_PREFIX.'_disable_initialdirectory' )==1),
                )
            );
        }

        /**
         * Render the extra fields on the manage location table.
         *
         * SLP Filter: slp_column_data
         *
         * @param string $theData  - the option_value field data from the database
         * @param string $theField - the name of the field from the database (should be sl_option_value)
         * @param string $theLabel - the column label for this column (should be 'Categories')
         * @return type
         */
        function filter_FieldDataToManageLocations($theData,$theField,$theLabel) {
            if (
                ($theField === 'featured') &&
                ($theData  === '0')
               ) {
                $theData = '';
            }
            return $theData;
        }

        //====================================================
        // Enhanced Results
        //====================================================

        /**
         * Modify the marker array after it is loaded with SLP location data.
         *
         * @param named array $marker - the SLP data for a single marker
         */
        function modify_marker($marker) {
            if (($this->options['add_tel_to_phone'] == 1)) {
                $marker['phone'] = sprintf('<a href="tel:%s">%s</a>',$marker['phone'],$marker['phone']);
            }

            if (($this->options['show_country'] == 0)) {
                $marker['country'] = '';
            }

            // Add Extendo Data Fields
            //
            if ($this->slplus->database->is_Extended() && $this->slplus->database->extension->has_ExtendedData()) {
                $exData = $this->slplus->currentLocation->exdata;
                foreach ($exData as $slug => $value) {

                    // Special featured setting (v. just returning "on")
                    if (($slug === 'featured') && $this->slplus->is_CheckTrue($value)) { $value='featured'; }

                    $marker[$slug] = $value;
                }

                if ( ! isset($marker['featured']) ) { $marker['featured'] = ''; }
                if ( ! isset($marker['rank'    ]) ) { $marker['rank'    ] = ''; }
            }

            return $marker;
        }

        /**
         * Set valid options.
         *
         * @param mixed $val the value of a form var
         * @param string $key the key for that form var
         */
        function set_ValidOptions($val,$key) {
            $simpleKey = str_replace($this->slplus->prefix.'-','',$key);
            if (array_key_exists($simpleKey, $this->options)) {
                $this->options[$simpleKey] = stripslashes_deep($val);
                $this->debugMP('msg','',"set options[{$simpleKey}]=".stripslashes_deep($val));
            }
         }

        /**
         * Initialize the options properties from the WordPress database.
         *
         * @param boolean $force
         */
        function initOptions($force = false) {
            if (!$force && $this->optionsSet) { return; }
            $this->debugMP('msg',__FUNCTION__);

            // Load options from DB
            //
            $dbOptions = get_option(SLPEnhancedResults::OPTION_NAME);
            if (is_array($dbOptions)) {
                array_walk($dbOptions,array($this,'set_ValidOptions'));
            }

            // Defaults
            //
            if (empty($this->options['resultslayout'])) {
                $this->options['resultslayout'] = $this->slplus->defaults['resultslayout'];
                $this->debugMP('msg','',"options[resultslayout] now {$this->options['resultslayout']}");
            }

            $this->optionsSet = true;
        }

        /**
         * Change how the information below the map is rendered.
         *
         * SLP Filter: slp_javascript_results_string (old school format, still used by JavaScript)
         *
         *              {0} aMarker.name,
         *              {1} parseFloat(aMarker.distance).toFixed(1),
         *              {2} slplus.distance_unit,
         *              {3} street,
         *              {4} street2,
         *              {5} city_state_zip,
         *              {6} thePhone,
         *              {7} theFax,
         *              {8} link,
         *              {9} elink,
         *              {10} slplus.map_domain,
         *              {11} encodeURIComponent(this.address),
         *              {12} encodeURIComponent(address),
         *              {13} slplus.label_directions,
         *              {14} tagInfo,
         *              {15} aMarker.id
         *              {16} aMarker.country
         *              {17} aMarker.hours
         */
        function mangle_results_output($resultString) {

            // Get our saved result string
            // escape that text area value
            // strip the slashes
            // then run through the shortcode processor.
            //
            $resultString = $this->options['resultslayout'];

            // Hide Distance
            //
            if (($this->slplus->settings->get_item('enhanced_results_hide_distance_in_table',0) == 1)) {
                $pattern = '/<span class="location_distance">\[slp_location distance_1\] \[slp_location distance_unit\]<\/span>/';
                $resultString = preg_replace($pattern,'',$resultString,1);
            }

            // Show Country
            //
            if (($this->options['show_country'] == 0)) {
                $pattern = '/<span class="slp_result_address slp_result_country">\[slp_location country\]<\/span>/';
                $newPattern = '';
                $resultString = preg_replace($pattern,$newPattern,$resultString,1);
            }

            // Show Hours
            //
            if (($this->options['show_hours'] == 0)) {
                $pattern = '/<span class="slp_result_contact slp_result_hours">\[slp_location hours\]<\/span>/';
                $newPattern = '';
                $resultString = preg_replace($pattern,$newPattern,$resultString,1);
            }

            // Send them back the string
            //
            return $resultString;
        }
    }

    // Hook to invoke the plugin.
    //
    add_action('init'           ,array('SLPEnhancedResults','init'              ));
    add_action('dmp_addpanel'   ,array('SLPEnhancedResults','create_DMPPanels'  ));
}
// Dad. Explorer. Rum Lover. Code Geek. Not necessarily in that order.
