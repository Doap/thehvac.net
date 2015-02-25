<?php
/**
 * Plugin Name: Store Locator Plus : Enhanced Search
 * Plugin URI: http://www.charlestonsw.com/product/slp4-enhanced-search/
 * Description: A premium add-on pack for Store Locator Plus that adds enhanced search features to the plugin.
 * Version: 4.1.04
 * Author: Charleston Software Associates
 * Author URI: http://charlestonsw.com/
 * Requires at least: 3.3
 * Tested up to : 3.9.1
 *
 * Text Domain: csa-slp-es
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
if (!class_exists('SLPEnhancedSearch'   )) {
    /**
     * The Enhanced Search Add-On Pack for Store Locator Plus.
     *
     * @package StoreLocatorPlus\EnhancedSearch
     * @author Lance Cleveland <lance@charlestonsw.com>
     * @copyright 2012-2014 Charleston Software Associates, LLC
     */
    class SLPEnhancedSearch {
        //-------------------------------------
        // Constants
        //-------------------------------------

        /**
         * @const string VERSION the current plugin version.
         */
        const VERSION           = '4.1.04';

        /**
         * @const string MIN_SLP_VERSION the minimum SLP version required for this version of the plugin.
         */
        const MIN_SLP_VERSION   = '4.1.28';

        /**
         * Our options are saved in this option name in the WordPress options table.
         */
        const OPTION_NAME = 'csl-slplus-ES-options';

        //-------------------------------------
        // Properties (all add-ons)
        //-------------------------------------

        /**
         * True if the allow_addy_in_url is present in the slplus shortcode.
         * 
         * @var boolean $attribute_allow_addy_is_set
         */
        private $attribute_allow_addy_is_set = false;

        /**
         * The directory we live in.
         *
         * @var string $dir
         */
        private $dir;

        /**
         * Used when testing if address was passed succesfully in URL and is valid to process.
         * 
         * @var boolean $is_address_in_url
         */
        private $is_address_in_url = null;

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
         * The base class for the SLP plugin
         *
         * @var \SLPlus $plugin
         **/
        public  $plugin;

        /**
         * Have shortcode attributes been processed?
         * 
         * @var boolean $shortcode_attributes_processed
         */
        private $shortcode_attributes_processed = false;

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
         * Have the options been set?
         *
         * @var boolean
         */
        private $optionsSet = false;

        /**
         * Settable options for this plugin.
         *
         * o address_placeholder
         * o city_selector
         * o country_selector
         * o hide_search_form
         * o ignore_radius
         * o name_placeholder
         * o label_for_city_selector
         * o label_for_country_selector
         * o label_for_state_selector
         * o search_by_name
         * o searchlayout
         * o searchnear
         * o state_selector
         *
         * TODO: Serialize these options...
         * These are only for shortcode atts, they have global settings but
         * are currently wired into the old-school non-serialized options data.
         *
         * o allow_addy_in_url
         *
         * @var mixed[] $options
         */
        public  $options                = array(
            'address_placeholder'           => ''           ,
            'allow_addy_in_url'             => '0'          ,
            'city_selector'                 => 'hidden'     ,
            'country_selector'              => 'hidden'     ,
            'hide_search_form'              => '0'          ,
            'ignore_radius'                 => '0'          ,
            'installed_version'             => ''           ,
            'name_placeholder'              => ''           ,
            'label_for_city_selector'       => 'City'       ,
            'label_for_country_selector'    => 'Country'    ,
            'label_for_state_selector'      => 'State'      ,
            'search_by_name'                => '0'          ,
            'searchlayout'                  => ''           ,
            'searchnear'                    => 'world'      ,
            'state_selector'                => 'hidden'     ,
            'append_to_search'              => ''           ,
        );


        private $shortcode_options_combo = array (
            'state_selector' => array ('discrete' => 'dropdown_discretefilter', 'input' => 'dropdown_addressinput', 'hidden' => 'hidden'),
        );


        /**
         * List of option keys that are checkboxes.
         *
         * Helps with processing during save of form posts.
         *
         * @var string[] $cb_options
         */
        private $cb_options = array (
            'hide_search_form',
            'ignore_radius',
            'search_by_name',
        );

        //-------------------------------------
        // Properties (this add-on)
        //-------------------------------------
        private $msUI;

        //------------------------------------------------------
        // METHODS
        //------------------------------------------------------

        /**
         * Invoke the Enhanced Search plugin.
         *
         * @static
         */
        public static function init() {
            static $instance = false;
            if ( !$instance ) {
                load_plugin_textdomain( 'csa-slp-es', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
                $instance = new SLPEnhancedSearch;
            }
            return $instance;
        }


        /**
         * Constructor
         */
        function SLPEnhancedSearch() {
            $this->url = plugins_url('',__FILE__);
            $this->dir = plugin_dir_path(__FILE__);
            $this->slug = plugin_basename(__FILE__);
            $this->name = __('Enhanced Search','csa-slp-es');
            
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
            // Check the base plugin minimum version requirement.
            //
            $this->plugin->VersionCheck(array(
                'addon_name'            => $this->name,
                'addon_slug'            => $this->slug,
                'min_required_version'  => SLPEnhancedSearch::MIN_SLP_VERSION
            ));

            // Tell SLP we are here
            //
             $this->plugin->register_addon($this->slug,$this);

            // UI: Augment Search Form, Allow show/hide search form
            //
            add_filter('slp_searchlayout'               ,array($this,'filter_ModifySearchLayout'        )       );
            add_filter('shortcode_slp_searchelement'    ,array($this,'filter_ProcessSearchElement'      )       );
            add_filter('slp_search_form_html'           ,array($this,'modifySearchForm'                 )       );
            add_filter('slp_search_default_address'     ,array($this,'set_SearchAddressFromRequest'     )       );
            add_filter('slp_script_data'                ,array($this,'filter_ModifyScriptData'          ),10    );
            add_filter('slp_js_options'                 ,array($this,'filter_ModifyJSOptions'           )       );

            // UI: Backend Processing
            //
            add_filter('slp_ajaxsql_fullquery'          ,array($this,'filter_JSONP_ModifyFullSQL'       )       );
            add_filter('slp_ajaxsql_queryparams'        ,array($this,'filter_JSONP_ModifyFullSQLParams' )       );
            add_filter('slp_location_filters_for_AJAX'  ,array($this,'filter_JSONP_SearchByStore'       )       );
            add_filter('slp_ajaxsql_where'              ,array($this,'filter_JSONP_SearchFilters'       ),20    );

            // Hook to prep the data to be written to the database
            //
            add_action('slp_save_map_settings'          ,array($this,'slp_save_map_settings'            ), 9    );

            // Shortcode attributes
            //
            add_filter('slp_shortcode_atts'             ,array($this,'filter_SetAllowedShortcodeAtts'   ),90, 3 );

            add_filter('slp_map_html'                   ,array($this,'filter_ModifyMapOutput'           ),90    );
        }

        /**
         * If we are in admin mode, run our admin updates.
         */
        function admin_init() {
            if (!$this->setPlugin()) { return ''; }

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

            // Activation/Update Processing
            //
            if (version_compare($this->options['installed_version']     , SLPEnhancedSearch::VERSION, '<')){
                if (class_exists('SLPES_Activation') == false) {
                    require_once(plugin_dir_path(__FILE__).'include/class.activation.php');
                }
                $this->activation = new SLPES_Activation(array('plugin'=>$this));
                $this->activation->update();
                $this->options['installed_version'] = SLPEnhancedSearch::VERSION;
                update_option(SLPEnhancedSearch::OPTION_NAME,$this->options);
            }

            // Hooks that allow us to directly output HTML in the pre-existing
            // SLP Admin UI / Map Settings / Search Form settings groups
            //
            add_action('slp_settings_search_features'           ,array($this,'filter_AddSearchSettings'             ), 9   );
            add_action('slp_settings_search_labels'             ,array($this,'filter_AddSearchLabels'               ), 9   );

            // General Settings tab : Google section
            //
            add_action('slp_generalsettings_modify_userpanel'   ,array($this,'action_AddUserSettings'               ), 9 , 2);
            add_filter('slp_save_general_settings_checkboxes'   ,array($this,'filter_SaveGeneralCBSettings'         )       );

            // Filter allows us to manipulate the Admin UI / Map Settings / Search Form HTML
            //
            add_filter('slp_map_settings_searchform'            ,array($this,'add_placeholders'                     )       );
        }

        /**
         * WordPress admin_menu hook.
         *
         */
        function admin_menu(){
            add_action('admin_init' ,array($this,'admin_init'));
        }


        /**
         * Create the city pulldown list, mark the checked item.
         *
         * @return string
         */
        private function createstring_CityPD() {
            $myOptions = '';
            $cs_array=$this->plugin->db->get_results(
                "SELECT CONCAT(TRIM(sl_city), ', ', TRIM(sl_state)) as city_state " .
                    "FROM ".$this->plugin->db->prefix."store_locator " .
                    "WHERE sl_city<>'' AND sl_latitude<>'' AND sl_longitude<>'' " .
                    "GROUP BY city_state " .
                    "ORDER BY city_state ASC",
                ARRAY_A);

            if ($cs_array) {
                foreach($cs_array as $sl_value) {
                    $sl_value['city_state'] = preg_replace('/, $/','',$sl_value['city_state']);
                    $myOptions.="<option value='$sl_value[city_state]'>$sl_value[city_state]</option>";
                }
            }
            return $myOptions;
        }


        /**
         * Add City pulldown to search form.
         *
         * @param string $HTML the initial pulldown HTML, typically empty.
         */
        function createstring_CitySelector() {
            $this->debugMP('msg',__FUNCTION__);
            $onChange =
                    ($this->options['city_selector'] === 'dropdown_discretefilter') ?
                    ''                                                              :
                    'aI=document.getElementById("searchForm").addressInput;if(this.value!=""){oldvalue=aI.value;aI.value=this.value;}else{aI.value=oldvalue;}';
            return
                "<div id='addy_in_city' class='search_item'>".
                    "<label for='addressInputCity'>".
                        $this->options['label_for_city_selector'] .
                    '</label>'.
                    "<select id='addressInputCity' name='addressInputCity' onchange='$onChange'>".
                        "<option value=''>".
                            get_option(SLPLUS_PREFIX.'_search_by_city_pd_label',__('--Search By City--','csa-slp-es')).
                         '</option>'.
                        $this->createstring_CityPD().
                    '</select>'.
                '</div>'
                ;
        }

        /**
         * Create the country pulldown list, mark the checked item.
         *
         * @return string
         */
        private function createstring_CountryPD() {
            $myOptions = '';
            $cs_array=$this->plugin->db->get_results(
                "SELECT TRIM(sl_country) as country " .
                    "FROM ".$this->plugin->db->prefix."store_locator " .
                    "WHERE sl_country<>'' " .
                        "AND sl_latitude<>'' AND sl_longitude<>'' " .
                    "GROUP BY country " .
                    "ORDER BY country ASC",
                ARRAY_A);
            if ($cs_array) {
                foreach($cs_array as $sl_value) {
                  $myOptions.="<option value='{$sl_value['country']}'>{$sl_value['country']}</option>";
                }
            }
            return $myOptions;
        }

        /**
         * Create the state pulldown list, mark the checked item.
         *
         * @return string
         */
        private function createstring_StatePD() {
            $myOptions = '';

            // TODO: replace this select with the base plugin get_SQL('select_state_list')
            $cs_array=$this->plugin->db->get_results(
                "SELECT TRIM(sl_state) as state " .
                    "FROM ".$this->plugin->db->prefix."store_locator " .
                    "WHERE sl_state<>'' " .
                        "AND sl_latitude<>'' AND sl_longitude<>'' " .
                    "GROUP BY state " .
                    "ORDER BY state ASC",
                ARRAY_A);

            // If we have country data show it in the pulldown
            //
            if ($cs_array) {
                foreach($cs_array as $sl_value) {
                  $myOptions.=
                    "<option value='$sl_value[state]'>" .
                    $sl_value['state']."</option>";
                }
            }
            return $myOptions;
        }


        /**
         * Add State pulldown to search form.
         *
         * @param string $HTML the initial pulldown HTML, typically empty.
         */
        function createstring_StateSelector() {
            $this->debugMP('msg',__FUNCTION__);
            $onChange = 
                    ($this->options['state_selector'] === 'dropdown_discretefilter') ? 
                    ''                                                              :
                    'aI=document.getElementById("searchForm").addressInput;if(this.value!=""){oldvalue=aI.value;aI.value=this.value;}else{aI.value=oldvalue;}';
            return
                "<div id='addy_in_state' class='search_item'>".
                    "<label for='addressInputState'>".
                        $this->options['label_for_state_selector'] .
                    '</label>'.
                    "<select id='addressInputState' name='addressInputState' onchange='$onChange'>".
                        "<option value=''>".
                            get_option(SLPLUS_PREFIX.'_search_by_state_pd_label',__('--Search By State--','csa-slp-es')).
                         '</option>'.
                        $this->createstring_StatePD().
                    '</select>'.
                    (($this->options['state_selector'] === 'dropdown_discretefilter' || $this->options['state_selector'] === 'dropdown_discretefilteraddress')?
                    '<input type="hidden" name="state_selector_discrete" value="on" />':'').
                '</div>'
                ;
        }

        /**
         * Create a Map Settings Debug My Plugin panel.
         *
         * @return null
         */
        static function create_DMPPanels() {
            if (!isset($GLOBALS['DebugMyPlugin'])) { return; }
            if (class_exists('DMPPanelSLPES') == false) {
                require_once(plugin_dir_path(__FILE__).'class.dmppanels.php');
            }
            $GLOBALS['DebugMyPlugin']->panels['slp.es'] = new DMPPanelSLPES();
        }

        /**
         * Simplify the plugin debugMP interface.
         *
         * @param string $type
         * @param string $hdr
         * @param string $msg
         */
        function debugMP($type,$hdr,$msg='') {
            $this->plugin->debugMP('slp.es',$type,$hdr,$msg,NULL,NULL,true);
        }

        /**
         * Extends the main SLP shortcode approved attributes list, setting defaults.
         *
         * This will extend the approved shortcode attributes to include the items listed.
         * The array key is the attribute name, the value is the default if the attribute is not set.
         *
         * @param mixed[] $attArray current list of approved attributes
         * @param mixed[] $attributes the shortcode attributes as entered by the user
         * @param string $content
         */
        function filter_SetAllowedShortcodeAtts($attArray,$attributes,$content) {
            $this->debugMP('msg',__FUNCTION__);

            // Shortcode settable on/off switches
            //
            $allowed_atts = array();
            $attribute_names = array(
                'allow_addy_in_url',
                'hide_search_form',
                'ignore_radius',
                );
            foreach ($attribute_names as $attname) {
                if (isset($attributes[$attname])) {
                    $this->options[$attname] = $this->ShortcodeAttTrue($attributes[$attname]);
                    if ($attname === 'allow_addy_in_url') { $this->attribute_allow_addy_is_set = true; }
                }
                $allowed_atts[$attname] = $this->options[$attname];
            }

            // Shortcode Atts with Values (not on/off)
            //
            if (isset($attributes['append_to_search'])) {
                $this->options['append_to_search'] = $attributes['append_to_search'];
            } 
            $allowed_atts = array_merge(
                array(
                    'initial_results_returned' => $this->plugin->options['initial_results_returned'],
                    'append_to_search'         => $this->options['append_to_search'],
                    ),
                $allowed_atts
            );

            // Shortcode Atts with combo values
            // Set option value base on shorcode attr, find the value in $valuePairs
            //
            foreach ($this->shortcode_options_combo as $attname => $valuePairs) {
                if (isset($attributes[$attname]) && isset($valuePairs[$attributes[$attname]])) {
                    $this->options[$attname] = $valuePairs[$attributes[$attname]];
                }
                $allowed_atts[$attname] = $this->options[$attname];
            }
            

            // Return the allowed attributes merged with our updated array.
            //
            $this->shortcode_attributes_processed = true;
            return array_merge($allowed_atts,$attArray);
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

        /**
         * Sets the search form address input on the UI to a post/get var.
         *
         * The option "allow address in URL" needs to be on.
         *
         * @param string $currentVal
         * @return string the default input value
         */
        function set_SearchAddressFromRequest($currentVal) {
            $this->debugMP('msg',__FUNCTION__,"currentval {$currentVal}");
            if ($this->test_AddressPassedByURL() && empty($currentVal)) {
                return stripslashes_deep($_REQUEST['address']);
            }
            return $currentVal;
        }

         /**
         * Modify the map layout.
         *
         * @param type $HTML
         * @return type
         */
        function filter_ModifyMapOutput($HTML) {
            if ($this->test_AddressPassedByURL()) {
                $HTML = str_replace('<div id="map_box_map">', '<div id="map_box_map" style="display:block;">', $HTML);
            }

            return $HTML;
        }

        /**
         * Add items to the General Settings tab : Google section
         *
         * @param \SLPlus_AdminUI_GeneralSettings $settings
         * @param string $sectName
         */
        function action_AddUserSettings($settings,$sectName) {
            $groupName = __('Program Interface','csa-slp-es');
            $settings->add_ItemToGroup(
                    array(
                        'section'       => $sectName        ,
                        'group'         => $groupName       ,
                        'type'          => 'subheader'      ,
                        'label'         => $this->name      ,
                        'show_label'    => false
                    ));
            $settings->add_ItemToGroup(
                    array(
                        'section'       => $sectName    ,
                        'group'         => $groupName   ,
                        'type'          => 'slider'     ,
                        'setting'       => 'es_allow_addy_in_url',
                        'label'         => __('Allow Address In URL','csa-slp-es'),
                        'description'   =>
                            __('If checked an address can be pre-loaded via a URL string ?address=blah.', 'csa-slp-es') .
                            ' ' .
                            __('This will disable the Pro Pack location sensor whenever the address is used in the URL.', 'csa-slp-es')
                    ));
        }

        /**
         *
         * @param type $currentHTML
         */
        function add_placeholders($currentHTML) {
            if (!is_object($this->msUI)) { $this->msUI = $this->plugin->AdminUI->MapSettings; }

            $newHTML =
                $this->msUI->CreateInputDiv(
                    '-ES-options[address_placeholder]',
                    __('Address', 'csa-slp-es'),
                    __('Instructions to place in the address input.','csa-slp-es')
                    ) .
                $this->msUI->CreateInputDiv(
                    '-ES-options[name_placeholder]',
                    __('Name', 'csa-slp-es'),
                    __('Instructions to place in the name input.','csa-slp-es')
                    )
                ;

            // TODO: Convert to new panel builder with add_ItemToGroup() in wpCSL (see Tagalong admin panel)
            return
                $currentHTML .
                $this->plugin->settings->create_SettingsGroup(
                    'slpes_input_placeholders',
                    __('Search Placeholders','csa-slp-es'),
                    __('Placeholders are text instructions that appear inside an input box before data is entered.','csa-slp-es'),
                    $newHTML
                    );
        }

        /**
         * Modify the AJAX processor SQL statement.
         * 
         * Remove the distance clause (having distance) if the ignore radius option is set.
         * 
         * @param string $sqlStatement full SQL statement.
         * @return string modified SQL statement
         */
        function filter_JSONP_ModifyFullSQL($sqlStatement) {
            $this->init_OptionsViaAJAX();
            if ( $this->plugin->is_CheckTrue( $this->options['ignore_radius'] ) ) {
                $sqlStatement = str_replace('HAVING (sl_distance < %d)','HAVING (sl_distance >= 0)',$sqlStatement);
            }
            return $sqlStatement;
        }

        /**
         * Modify the AJAX processor SQL statement params.
         *
         * Remove the distance param if the ignore radius option is set.
         *
         * @param mixed[] $paramArray the current list of parameters.
         * @return mixed[] modified parameters list.
         */
        function filter_JSONP_ModifyFullSQLParams($paramArray) {
            if ( $this->plugin->is_CheckTrue( $this->options['ignore_radius'] ) ) {
                $limit  = array_pop($paramArray);
                $radius = array_pop($paramArray);
                $paramArray[] = $limit;
            }
            return $paramArray;
        }

        /**
         * Add the store name condition to the MySQL statement used to fetch locations with JSONP.
         *
         * @param string $currentFilters
         * @return string the modified where clause
         */
        function filter_JSONP_SearchByStore($currentFilters) {
            if (empty($_POST['name'])) { return $currentFilters; }
            $posted_name = preg_replace('/^\s+(.*?)/','$1',$_POST['name']);
            $posted_name = preg_replace('/(.*?)\s+$/','$1',$posted_name);
            return array_merge(
                    $currentFilters,
                    array(" AND (sl_store LIKE '%%".$posted_name."%%')")
                    );
        }

        /**
         * Add the selected filters to the search results.
         *
         */
        function filter_JSONP_SearchFilters($where) {

            // Discrete City Output
            //
            if (
                ( 
                  ($this->options['city_selector'] === 'dropdown_discretefilter')           ||
                  ($this->options['city_selector'] === 'dropdown_discretefilteraddress')
                ) &&
                !empty($this->plugin->addons['slp.AjaxHandler']->formdata['addressInputCity'])
                ){

                $sql_city_expression =
                        (preg_match('/, /',$this->plugin->addons['slp.AjaxHandler']->formdata['addressInputCity']) === 1) ?
                        'CONCAT_WS(", ",sl_city,sl_state)=%s'   :
                        'sl_city=%s'                            ;

                $where =
                    $this->plugin->database->extend_Where(
                        $where,
                        $this->plugin->db->prepare(
                            $sql_city_expression,
                            sanitize_text_field($this->plugin->addons['slp.AjaxHandler']->formdata['addressInputCity'])
                        )
                    );
            }
            
            // Discrete State Output
            //
            if (
                !empty($this->plugin->addons['slp.AjaxHandler']->formdata['state_selector_discrete']) &&
                !empty($this->plugin->addons['slp.AjaxHandler']->formdata['addressInputState'])
                ){
                $where = 
                    $this->plugin->database->extend_Where(
                        $where,
                        $this->plugin->db->prepare(
                            'sl_state=%s',
                            sanitize_text_field($this->plugin->addons['slp.AjaxHandler']->formdata['addressInputState'])
                        )
                    );
            }

            // Discrete Country Output
            //
            if (
                (
                  ($this->options['country_selector'] === 'dropdown_discretefilter')           ||
                  ($this->options['country_selector'] === 'dropdown_discretefilteraddress')
                ) &&

                !empty($this->plugin->addons['slp.AjaxHandler']->formdata['addressInputCountry'])
                ){
                $where =
                    $this->plugin->database->extend_Where(
                        $where,
                        $this->plugin->db->prepare(
                            'sl_country=%s',
                            sanitize_text_field($this->plugin->addons['slp.AjaxHandler']->formdata['addressInputCountry'])
                        )
                    );
            }

            return $where;
        }

        /**
         * Modify the slplus.options object going into SLP.js
         *
         * @param mixed[] $options
         */
        function filter_ModifyJSOptions($options) {
            return array_merge($options,
                        array(
                            'searchnear'       => $this->options['searchnear'],
                            'append_to_search' => $this->options['append_to_search'],
                        )
                    );
        }

        /**
         * Modify the slplus object going into SLP.js
         *
         * @param mixed[] $options
         */
        function filter_ModifyScriptData($options) {
            $this->debugMP('msg',__FUNCTION__);
            if (!$this->test_AddressPassedByURL()) { return $options; }
            $this->debugMP('msg','','disable location sensor');
            $this->plugin->options['immediately_show_locations'] = '1';
            return array_merge($options,
                        array(
                            'use_sensor' => ''
                        )
                    );
        }

        /**
         * Change the search form layout, hide it, etc.
         *
         * Shortcode attribute takes precedence, then check the map settings hide search form.
         */
        function filter_ModifySearchLayout($layout) {
            $this->debugMP('msg',__FUNCTION__);
            $alwaysOutput = '';

            // Ignore Radius Set, possibly in shortcode attribute, make sure it is on the form.
            //
            $ignore_radius_value = ( $this->plugin->is_CheckTrue( $this->options['ignore_radius'] ) ? '1':'0');
            $alwaysOutput .= "<input type='hidden' name='ignore_radius' id='ignore_radius' value='{$ignore_radius_value}' />" ;

            // Hide Search Form
            //
            if ( $this->plugin->is_CheckTrue( $this->options['hide_search_form'] ) ) { return $alwaysOutput; }

            // Custom Layout
            //
            if (!empty($this->options['searchlayout'])) {
                $layout = $this->options['searchlayout'];
                $this->debugMP('msg','','Custom Search Layout: '.$layout);
            }

            // Add Name Search
            //
            if (
                   ( $this->plugin->is_CheckTrue( $this->options['search_by_name'] ) )
                &&
                   (!preg_match('/\[slp_search_element\s+.*input_with_label="name".*\]/i',$layout))
                ){
                $layout .= '[slp_search_element input_with_label="name"]';
            }

            // Add City Dropdown
            //
            if (
                   ($this->options['city_selector'] !== 'hidden')
                &&
                   (!preg_match('/\[slp_search_element\s+.*dropdown_with_label="city".*\]/i',$layout))
                ){
                $layout .= '[slp_search_element dropdown_with_label="city"]';
            }

            // Add State Dropdown
            //
            if (
                   ($this->options['state_selector'] !== 'hidden')
                &&
                   (!preg_match('/\[slp_search_element\s+.*dropdown_with_label="state".*\]/i',$layout))
                ){
                $layout .= '[slp_search_element dropdown_with_label="state"]';
            }


            // Add Country Dropdown
            //
            if (
                   ($this->options['country_selector'] !== 'hidden')
                &&
                   (!preg_match('/\[slp_search_element\s+.*dropdown_with_label="country".*\]/i',$layout))
                ){
                $layout .= '[slp_search_element dropdown_with_label="country"]';
            }

            return $layout.$alwaysOutput;
        }

        /**
         * Perform extra search form element processing.
         *
         * @param mixed[] $attributes
         */
        function filter_ProcessSearchElement($attributes) {
            $this->debugMP('pr',__FUNCTION__,$attributes);
            foreach ($attributes as $name=>$value) {

                switch (strtolower($name)) {

                    case 'dropdown_with_label':
                        switch ($value) {

                            case 'city':
                                return array(
                                    'hard_coded_value' =>
                                        ($this->options['city_selector']!=='hidden') ?
                                        $this->createstring_CitySelector()        :
                                        ''
                                    );
                                break;

                            case 'country':
                                return array(
                                    'hard_coded_value' =>
                                        ($this->options['country_selector']!=='hidden') ?
                                        $this->createstring_CountrySelector()     :
                                        ''
                                    );
                                break;

                            case 'state':
                                return array(
                                    'hard_coded_value' =>
                                        ($this->options['state_selector']!=='hidden') ?
                                        $this->createstring_StateSelector()         :
                                        ''
                                    );
                                break;

                            default:
                                break;
                        }
                        break;

                    case 'input_with_label':
                        switch ($value) {
                            case 'address':
                                return array(
                                    'hard_coded_value'  =>
                                        $this->plugin->UI->createstring_DefaultSearchDiv_Address($this->options['address_placeholder'])
                                );

                            case 'name':
                                return array(
                                    'hard_coded_value' =>
                                        $this->plugin->UI->createstring_InputDiv(
                                            'nameSearch',
                                            get_option('sl_name_label',__('Name of Store','csa-slp-es')),
                                            $this->options['name_placeholder'],
                                            ($this->options['search_by_name'] === '0'),
                                            'div_nameSearch'
                                            )
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
         * Save the General Settings tab checkboxes.
         *
         * @param mixed[] $cbArray
         * @return mixed[]
         */
        function filter_SaveGeneralCBSettings($cbArray) {
            $this->debugMP('msg',__FUNCTION__);
            return array_merge($cbArray,
                    array(
                            SLPLUS_PREFIX.'-es_allow_addy_in_url',
                        )
                    );
        }

        /**
         * Create the country drop down input for the search form.
         */
        function createstring_CountrySelector() {
            $this->debugMP('msg',__FUNCTION__);
            $onChange =
                    ($this->options['country_selector'] === 'dropdown_discretefilter') ?
                    ''                                                                 :
                    'aI=document.getElementById("searchForm").addressInput;if(this.value!=""){oldvalue=aI.value;aI.value=this.value;}else{aI.value=oldvalue;}' ;
            return
                "<div id='addy_in_country' class='search_item'>".
                    "<label for='addressInputCountry'>".
                        $this->options['label_for_country_selector'] .
                    '</label>'.
                    "<select id='addressInputCountry' name='addressInputCountry' onchange='$onChange'>".
                        "<option value=''>".
                            get_option(SLPLUS_PREFIX.'_search_by_country_pd_label',__('--Search By Country--','csa-slp-es')).
                         '</option>'.
                        $this->createstring_CountryPD().
                    '</select>'.
                '</div>'
                ;
        }

        /**
         * Initialize the options properties from the WordPress database.
         *
         * @param boolean $force
         */
        function initOptions($force = false) {
            if (!$force && $this->optionsSet) { return; }
            $this->debugMP('msg',__FUNCTION__);

            $dbOptions = get_option(SLPEnhancedSearch::OPTION_NAME);
            if (is_array($dbOptions)) {
                array_walk($dbOptions,array($this,'set_ValidOptions'));
            }
            
            // Defaults
            //
            if (empty($this->options['searchlayout'])) {
                $this->options['searchlayout'] =  $this->plugin->defaults['searchlayout']; 
            }

            $this->optionsSet = true;
        }

        /**
         * Set options based on the AJAX formdata properties.
         *
         * This will allow AJAX entries to take precedence over local options.
         * Typically these are passed via slp.js by using hidden fields with the name attribute.
         * The name must match the options available to this add-on pack for jQuery to pass them along.
         */
        function init_OptionsViaAJAX() {
            if (isset($this->plugin->addons['slp.AjaxHandler']->formdata)) {
                if (is_array($this->plugin->addons['slp.AjaxHandler']->formdata)) {
                    array_walk($this->plugin->addons['slp.AjaxHandler']->formdata,array($this,'set_ValidOptions'));
                }
            }
        }

        /**
         * Make inline changes to the search form.
         *
         * @param type $currentHTML
         * @return type
         */
        function modifySearchForm($currentHTML) {

            // Address Placeholder
            //
            // <input type='text' id='addressInput' placeholder='' size='50' value='' />
            //
            $pattern = "/<input(.*?)id='addressInput'(.*?)placeholder=''(.*?)>/";
            $placeholder = $this->options['address_placeholder'];
            $replacement = '<input${1}id="addressInput"${2}placeholder="'.$placeholder.'"${3}>';
            $currentHTML = preg_replace($pattern,$replacement,$currentHTML);

            // Name Placeholder
            //
            $pattern = "/<input(.*?)id='nameSearch'(.*?)placeholder=''(.*?)>/";
            $placeholder = $this->options['name_placeholder'];
            $replacement = '<input${1}id="nameSearch"${2}placeholder="'.$placeholder.'"${3}>';
            $currentHTML = preg_replace($pattern,$replacement,$currentHTML);

            return $currentHTML;
        }

        /**
         * Add new settings for the search for to the map settings/search form section.
         *
         * @return null
         */
        function filter_AddSearchSettings($HTML) {
            if (!is_object($this->msUI)) { $this->msUI = $this->plugin->AdminUI->MapSettings; }

            $HTML .=
                $this->plugin->helper->create_SubheadingLabel($this->name) .

                $this->plugin->helper->CreateCheckboxDiv(
                    '-ES-options[hide_search_form]',
                    __('Hide Search Form','csa-slp-es'),
                    __('Hide the user input on the search page, regardless of the SLP theme used.', 'csa-slp-es'),
                    null,false,0,
                    $this->options['hide_search_form']
                    ) .

                $this->plugin->helper->CreateCheckboxDiv(
                    '-ES-options[ignore_radius]',
                    __('Ignore Radius Input', 'csa-slp-es'),
                    __('Results are limited by filters and search criteria only.  Radius limits are removed. Especially useful for discrete city, country, state filters.', 'csa-slp-es'),
                    null,false,0,
                    $this->options['ignore_radius']
                    ) .

                $this->plugin->helper->CreateCheckboxDiv(
                    '_hide_radius_selections',
                    __('Hide Radius Selections','csa-slp-es'),
                    __('Hide the radius selection drop down.', 'csa-slp-es')
                    ) .

                $this->plugin->helper->CreateCheckboxDiv(
                    '-ES-options[search_by_name]',
                    __('Show Search By Name', 'csa-slp-es'),
                    __('Shows the name search entry box to the user.', 'csa-slp-es'),
                    null,false,0,
                    $this->options['search_by_name']
                    ) .

                $this->plugin->helper->createstring_DropDownDiv(
                    array(
                        'id'        => 'city_selector',
                        'name'      => SLPLUS_PREFIX.'-ES-options[city_selector]',
                        'label'     => __('City Selector','csa-slp-es'),
                        'helptext'  =>
                            __('Show the city selector on the search form.', 'csa-slp-es') .
                            sprintf(__('View the <a href="%s" target="csa">documentation</a> for more info. ','csa-slp-es'),$this->plugin->support_url) .
                            __('Consider setting ignore radius when using discrete search mode.', 'csa-slp-es')
                            ,
                        'selectedVal' => $this->options['city_selector'],
                        'items' => array (
                                array(
                                    'label' => __('Hidden','csa-slp-es'),
                                    'value' => 'hidden',
                                ),
                                array(
                                    'label' => __('Dropdown, Address Input','csa-slp-es'),
                                    'value' => 'dropdown_addressinput',
                                ),
                                array(
                                    'label' => __('Dropdown, Discrete Filter','csa-slp-es'),
                                    'value' => 'dropdown_discretefilter',
                                ),
                                array(
                                    'label' => __('Dropdown, Discrete + Address Input','csa-slp-es'),
                                    'value' => 'dropdown_discretefilteraddress',
                                ),
                            )
                    )
                ) .

                $this->plugin->helper->createstring_DropDownDiv(
                    array(
                        'id'        => 'country_selector',
                        'name'      => SLPLUS_PREFIX.'-ES-options[country_selector]',
                        'label'     => __('Country Selector','csa-slp-es'),
                        'helptext'  =>
                            __('Show the country selector on the search form.', 'csa-slp-es') .
                            sprintf(__('View the <a href="%s" target="csa">documentation</a> for more info. ','csa-slp-es'),$this->plugin->support_url) .
                            __('Consider setting ignore radius when using discrete search mode.', 'csa-slp-es')
                            ,
                        'selectedVal' => $this->options['country_selector'],
                        'items' => array (
                                array(
                                    'label' => __('Hidden','csa-slp-es'),
                                    'value' => 'hidden',
                                ),
                                array(
                                    'label' => __('Dropdown, Address Input','csa-slp-es'),
                                    'value' => 'dropdown_addressinput',
                                ),
                                array(
                                    'label' => __('Dropdown, Discrete Filter','csa-slp-es'),
                                    'value' => 'dropdown_discretefilter',
                                ),
                                array(
                                    'label' => __('Dropdown, Discrete + Address Input','csa-slp-es'),
                                    'value' => 'dropdown_discretefilteraddress',
                                ),

                            )
                    )
                ) .

                $this->plugin->helper->createstring_DropDownDiv(
                    array(
                        'id'        => 'state_selector',
                        'name'      => SLPLUS_PREFIX.'-ES-options[state_selector]',
                        'label'     => __('State Selector','csa-slp-es'),
                        'helptext'  =>
                            __('Show the state selector on the search form.', 'csa-slp-es') .
                            sprintf(__('View the <a href="%s" target="csa">documentation</a> for more info. ','csa-slp-es'),$this->plugin->support_url) .
                            __('Consider setting ignore radius when using discrete search mode.', 'csa-slp-es')
                            ,
                        'selectedVal' => $this->options['state_selector'],
                        'items' => array (
                                array(
                                    'label' => __('Hidden','csa-slp-es'),
                                    'value' => 'hidden',
                                ),
                                array(
                                    'label' => __('Dropdown, Address Input','csa-slp-es'),
                                    'value' => 'dropdown_addressinput',
                                ),
                                array(
                                    'label' => __('Dropdown, Discrete Filter','csa-slp-es'),
                                    'value' => 'dropdown_discretefilter',
                                ),
                                array(
                                    'label' => __('Dropdown, Discrete + Address Input','csa-slp-es'),
                                    'value' => 'dropdown_discretefilteraddress',
                                ),

                            )
                    )
                ) .

                $this->plugin->helper->createstring_DropDownDiv(
                        array(
                            'id'        => 'searchnear',
                            'name'      => SLPLUS_PREFIX.'-ES-options[searchnear]',
                            'label'     => __('Search Address Nearest','csa-slp-es'),
                            'helptext'  =>
                                __('Worldwide is the default search, letting Google make the best guess which addres the user wants.','csa-slp-es') . ' '.
                                __('Current Map will find the best matching address nearest the current area shown on the map.','csa-slp-es'),
                            'selectedVal' => $this->options['searchnear'],
                            'items'     => array(
                                array(
                                    'label' => __('Worldwide','csa-slp-es'),
                                    'value' => 'world'
                                    ),
                                array(
                                    'label' => __('Current Map','csa-slp-es'),
                                    'value' => 'currentmap'
                                    ),
                                )
                        )
                     );

                $HTML .= $this->msUI->CreateTextAreaDiv(
                    '-ES-options[searchlayout]',
                    __('Search Layout','csa-slp-es'),
                    __('Enter your custom search form layout. ','csa-slp-es') .
                        sprintf('<a href="%s" target="csa">%s</a> ',
                                $this->plugin->support_url,
                                sprintf(__('Uses HTML plus %s shortcodes.','csa-slp-es'),$this->name)
                                ) .
                        __('Set it to blank to reset to the default layout. ','csa-slp-es') .
                        __('Overrides all other search form settings.','csa-slp-es')
                        ,
                    SLPLUS_PREFIX,
                    $this->options['searchlayout'],
                    true
                    );

                $HTML .= $this->msUI->CreateInputDiv(
                    '-ES-options[append_to_search]',
                    __('Append This To Searches','csa-slp-es'),
                    __('Anything you enter in this box will automatically be appended to the address a user types into the locator search form address box on your site. ','csa-slp-es'),
                    SLPLUS_PREFIX,
                    $this->options['append_to_search']
                    )
                ;


            return $HTML;
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

        /**
         * Return '1' if the given value is set to 'true', 'on', or '1' (case insensitive).
         * Return '0' otherwise.
         *
         * @param string $attValue
         * @return boolean
         */
        function ShortcodeAttTrue($attValue) {
            return ( $this->plugin->is_CheckTrue($attValue) ? '1' : '0' );
        }

        /**
         * Add new custom labels.
         *
         */
        function filter_AddSearchLabels($HTML) {
            if (!is_object($this->msUI)) { $this->msUI = $this->plugin->AdminUI->MapSettings; }

            $HTML .=
                $this->plugin->helper->create_SubheadingLabel($this->name) .

                $this->msUI->CreateInputDiv(
                    '_find_button_label',
                    __('Find Button', 'csa-slp-es'),
                    __('The label on the find button, if text mode is selected.','csa-slp-es'),
                    SLPLUS_PREFIX,
                    __('Find Locations','csa-slp-es')
                    ) .

                $this->msUI->CreateInputDiv(
                    'sl_name_label',
                    __('Name', 'csa-slp-es'),
                    __('The label that precedes the name input box.','csa-slp-es'),
                    '',
                    'Name'
                    ) .

                // City
                //
                $this->msUI->CreateInputDiv(
                    '-ES-options[label_for_city_selector]',
                    __('City Selector Label', 'csa-slp-es'),
                    __('The label that precedes the city selector.','csa-slp-es'),
                    SLPLUS_PREFIX,
                    $this->options['label_for_city_selector'],
                    $this->options['label_for_city_selector']
                    ) .
                $this->msUI->CreateInputDiv(
                    '_search_by_city_pd_label',
                    __('City Selector First Entry', 'csa-slp-es'),
                    __('The first entry on the search by city selector.','csa-slp-es'),
                    SLPLUS_PREFIX,
                    __('--Search By City--','csa-slp-es')
                    ) .

                // State
                //
                $this->msUI->CreateInputDiv(
                    '-ES-options[label_for_state_selector]',
                    __('State Selector Label', 'csa-slp-es'),
                    __('The label that precedes the state selector.','csa-slp-es'),
                    SLPLUS_PREFIX,
                    $this->options['label_for_state_selector'],
                    $this->options['label_for_state_selector']
                    ) .
                $this->msUI->CreateInputDiv(
                    '_search_by_state_pd_label',
                    __('State Selector First Entry', 'csa-slp-es'),
                    __('The first entry on the search by state selector.','csa-slp-es'),
                    SLPLUS_PREFIX,
                    __('--Search By State--','csa-slp-es')
                    ) .

                // Country
                //
                $this->msUI->CreateInputDiv(
                    '-ES-options[label_for_country_selector]',
                    __('Country Selector Label', 'csa-slp-es'),
                    __('The label that precedes the country selector.','csa-slp-es'),
                    SLPLUS_PREFIX,
                    $this->options['label_for_country_selector'],
                    $this->options['label_for_country_selector']
                    ) .
                $this->msUI->CreateInputDiv(
                    '_search_by_country_pd_label',
                    __('Country Selector First Entry', 'csa-slp-es'),
                    __('The first entry on the search by country selector.','csa-slp-es'),
                    SLPLUS_PREFIX,
                    __('--Search By Country--','csa-slp-es')
                    )
                ;

            return $HTML;
        }

        /**
         * Save the map settings via SLP Action slp_save_map_settings.
         *
         * @return string
         */
        function slp_save_map_settings() {
            $this->debugMP('msg',__FUNCTION__);

            // Checkboxes with special names
            //
            $BoxesToHit = array(
                SLPLUS_PREFIX.'_hide_radius_selections'     ,
                );
            foreach ($BoxesToHit as $JustAnotherBox) {
                $this->plugin->helper->SaveCheckBoxToDB($JustAnotherBox,'','');
            }

            // Text boxes
            //
            $BoxesToHit = array(
                SLPLUS_PREFIX.'_find_button_label'              ,
                'sl_name_label'                                 ,
                SLPLUS_PREFIX.'_state_pd_label'                 ,
                SLPLUS_PREFIX.'_search_by_city_pd_label'        ,
                SLPLUS_PREFIX.'_search_by_state_pd_label'       ,
                SLPLUS_PREFIX.'_search_by_country_pd_label'     ,
                );
            foreach ($BoxesToHit as $JustAnotherBox) {
                $this->plugin->helper->SavePostToOptionsTable($JustAnotherBox);
            }

            // Serialized : Compound Options
            //
            $this->options =
                $this->plugin->AdminUI->save_SerializedOption(
                    SLPEnhancedSearch::OPTION_NAME,
                    $this->options,
                    $this->cb_options
                    );
        }


        /**
         * Return true if the address was passed in via the URL and that option is enabled.
         *
         * @return boolean
         */
        function test_AddressPassedByURL() {

            // This will not work if shortcode attributes have not been processed.
            // Return false as the default case.
            //
            if (! $this->shortcode_attributes_processed ) { return false; }

            if ($this->is_address_in_url === null) {

                // Shortcode allow_addy_in_url is used and set to true.
                //
                $shortcode_is_on = $this->attribute_allow_addy_is_set && $this->plugin->is_CheckTrue($this->plugin->data['allow_addy_in_url']);

                // Option is turned on
                //
                $option_enabled = $this->plugin->is_CheckTrue(get_option('csl-slplus-es_allow_addy_in_url',0));

                // Check Address In URL
                //
                $this->is_address_in_url = (($shortcode_is_on || ($option_enabled && !$this->attribute_allow_addy_is_set)) && isset($_REQUEST['address']));

                // Debug Output
                //s
                $this->debugMP('msg',__FUNCTION__,
                    (($this->is_address_in_url) ? 'YES' : 'NO') . ':' .
                    "shortcode att active? {$this->attribute_allow_addy_is_set} : att on? {$shortcode_is_on} : option on? {$option_enabled}"
                    );

            }

            return $this->is_address_in_url;
        }

        /**
         * Enqueue the Enhanced Search Scripts
         */
        function wp_enqueue_scripts() {
            wp_enqueue_script(
                    'slp_enhanced_search_test_script',
                    $this->url.'/my.js',
                    'slp_script'
            );
        }
    }

    // Hook to invoke the plugin.
    //
    add_action('init'           ,array('SLPEnhancedSearch','init'               ));
    add_action('dmp_addpanel'   ,array('SLPEnhancedSearch','create_DMPPanels'   ));
}
// Dad. Husband. Rum Lover. Code Geek. Not necessarily in that order.
