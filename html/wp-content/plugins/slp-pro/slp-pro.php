<?php

/**
 * Plugin Name: Store Locator Plus : Pro Pack
 * Plugin URI: http://www.charlestonsw.com/product/store-locator-plus/
 * Description: A premium add-on pack for Store Locator Plus that provides more admin power tools for wrangling locations.
 * Version: 4.1.06
 * Author: Charleston Software Associates
 * Author URI: http://charlestonsw.com/
 * Requires at least: 3.3
 * Tested up to : 4.0
 *
 * Text Domain: csa-slp-pro
 * Domain Path: /languages/
 */

// Exit if access directly, dang hackers
if (!defined('ABSPATH')) {
    exit;
} 
// No SLP? Get out...
//
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (!function_exists('is_plugin_active') || !is_plugin_active('store-locator-le/store-locator-le.php')) {
    return;
}

// Make sure the class is only defined once.
//
if (!class_exists('SLPPro')) {

    /**
     * The Pro Pack Add-On Pack for Store Locator Plus.
     *
     * @package StoreLocatorPlus\ProPack
     * @author Lance Cleveland <lance@charlestonsw.com>
     * @copyright 2014 Charleston Software Associates, LLC
     */
    class SLPPro {
        //-------------------------------------
        // Constants
        //-------------------------------------

        /**
         * @const string VERSION the current plugin version.
         */
        const VERSION = '4.1.06';

        /**
         * @const string MIN_SLP_VERSION the minimum SLP version required for this version of the plugin.
         */
        const MIN_SLP_VERSION = '4.1.31';

        /**
         * Our options are saved in this option name in the WordPress options table.
         */
        const OPTION_NAME = 'csl-slplus-PRO-options';

        /**
         * Our plugin slug.
         */
        const PLUGIN_SLUG = 'slp-pro';

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
         * The base object for the SLP plugin.
         *
         * @var \SLPlus
         * */
        public $slplus;

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
         * Settable options for this plugin. (Does NOT go into main plugin JavaScript)
         *
         * Admin Panel Settings
         * o highlight_uncoded if on the non-geocoded locations are highlighted on the manage locations table.
         *
         * UI View
         * o layout the overall locator page layout, uses special shortcodes, default set by base plugin \SLPlus class.
         *
         * UI Search
         * o tag_label text that appears before the form label
         * o tag_selector style of search form input 'none','hidden','dropdown','textinput'
         * o tag_selections list of drop down selections
         *
         * UI Results
         * o tag_output_processing how tag data should be pre-processed when sending JSONP response to front end UI.
         *
         * CSV Processing
         * o csv_duplicates_handling = how to handle incoming records that match name + add/add2/city/state/zip/country
         * oo add = add duplicate records (default)
         * oo skip = skip over duplicate records
         * oo update = update duplicate records, requires id field in csv file to update name or address fields
         *
         * Program Control Settings
         * o installed_version - set when the plugin is activated or updated
         *
         * @var mixed[] $options
         */
        public $options = array(
            'csv_first_line_has_field_name' => '0',
            'csv_skip_first_line' => '0',
            'csv_skip_geocoding' => '0',
            'csv_duplicates_handling' => 'add',
            'highlight_uncoded' => '1',
            'installed_version' => '',
            'layout' => '',
            'tag_label' => '',
            'tag_selector' => 'none',
            'tag_selections' => '',
            'tag_output_processing' => 'as_entered',
            'reporting_enabled' => '0'
        );

        //-------------------------------------
        // Properties (this add-on)
        //-------------------------------------

        /**
         * The Admin object.
         * 
         * @var \SLPPro_Admin $Admin
         */
        public $Admin;

        /**
         * Are we in Admin mode?
         * 
         * @var boolean adminMode
         */
        private $adminMode = false;

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
            if (!$instance) {
                load_plugin_textdomain('csa-slp-pro', false, dirname(plugin_basename(__FILE__)) . '/languages/');
                $instance = new SLPPro;
            }
            return $instance;
        }

        /**
         * Constructor
         *
         */
        function SLPPro() {
            $this->url = plugins_url('', __FILE__);
            $this->dir = plugin_dir_path(__FILE__);
            $this->slug = plugin_basename(__FILE__);
            $this->name = __('Pro Pack', 'csa-slp-pro');

            // Store Locator Plus invocation complete
            //
            add_action('slp_init_complete', array($this, 'slp_init'));
            add_action('admin_enqueue_scripts', array($this, 'action_EnqueueAdminScripts'));

            // Admin / Nav Menus (start of admin stack)
            //
            add_action('slp_admin_menu_starting', array($this, 'admin_menu'));

            // Reporting
            // Insert the query into the query DB
            // Insert the results into the reporting table
            add_action('slp_report_query_result', array($this, 'insert_Report_QueryandResults'), 10, 2);

            // Filters
            //
            add_filter('slp_shortcode_atts', array($this, 'extend_main_shortcode'));
            add_filter('slp_layout', array($this, 'filter_TakeOverLayout'), 5);

            add_filter('slp_menu_items', array($this, 'filter_AddMenuItems'), 90);
        }

        /**
         * WordPress admin_init hook for Pro Pack.
         */
        function admin_init() {
            // Attach the admin object.
            //
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
            if ( version_compare( $this->options['installed_version'] , SLPPro::VERSION , '<' ) ) {
                if (class_exists('Pro_Activation') == false) {
                    require_once(plugin_dir_path(__FILE__).'include/class.activation.php');
                }
                $this->activation = new Pro_Activation(array('addon'=>$this));
                $this->activation->update();
                $this->options['installed_version'] = SLPPro::VERSION;
                update_option(SLPPro::OPTION_NAME,$this->options);
            }            
        }

        /**
         * WordPress admin_menu hook.
         */
        function admin_menu() {
            if (!$this->setPlugin()) {
                return;
            }
            $this->adminMode = true;
            add_action('admin_init', array($this, 'admin_init'));
        }

        /**
         * Modify the marker data.
         *
         * @param mixed[] $marker the current marker data
         */
        function filter_ModifyAJAXResponse($marker) {

            // Tag output processing
            //
            switch ($this->options['tag_output_processing']) {
                case 'hide':
                    $marker['tags'] = '';
                    break;

                case 'replace_with_br':
                    $marker['tags'] = str_replace(',', '<br/>', $marker['tags']);
                    $marker['tags'] = str_replace('&#044;', '<br/>', $marker['tags']);
                    break;

                case 'as_entered':
                default:
                    break;
            }

            return $marker;
        }

        /**
         * Add tags selector to search layout.
         *
         */
        function filter_ModifySearchLayout($layout) {
            $this->debugMP('msg', __FUNCTION__);
            if (!$this->setPlugin()) {
                return $layout;
            }
            if (preg_match('/\[slp_search_element\s+.*dropdown_with_label="tag".*\]/i', $layout)) {
                return $layout;
            }
            if (preg_match('/\[slp_search_element\s+.*selector_with_label="tag".*\]/i', $layout)) {
                return $layout;
            }
            return $layout . '[slp_search_element selector_with_label="tag"]';
        }

        /**
         * Perform extra search form element processing.
         *
         * @param mixed[] $attributes
         */
        function filter_ProcessSearchElement($attributes) {
            $this->debugMP('pr', __FUNCTION__, $attributes);
  
            foreach ($attributes as $name => $value) {

                switch (strtolower($name)) {

                    // dropdown_with_label="tag"
                    //
                    case 'dropdown_with_label':
                        switch ($value) {
                            case 'tag':
                                $this->options['tag_selector'] = 'dropdown';
                                return array(
                                    'hard_coded_value' => $this->createstring_TagSelector()
                                );
                                break;

                            default:
                                break;
                        }
                        break;

                    // selector_with_label="tag"
                    //
                    case 'selector_with_label':
                        switch ($value) {
                            case 'tag':
                                return array(
                                    'hard_coded_value' => $this->createstring_TagSelector()
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
         * Do this stuff after SLP has started up.
         */
        function slp_init() {
            if (!$this->setPlugin()) {
                return;
            }

            // Check the base plugin minimum version requirement.
            //
            $this->slplus->VersionCheck(array(
                'addon_name' => $this->name,
                'addon_slug' => $this->slug,
                'min_required_version' => SLPPro::MIN_SLP_VERSION
            ));

            // Tell SLP we are here
            //
             $this->slplus->register_addon($this->slug, $this);

            // UI Updates
            //
            add_filter('shortcode_slp_searchelement', array($this, 'filter_ProcessSearchElement'));
            add_filter('slp_ui_headers', array($this, 'filter_UI_CustomCSS'));
            add_filter('slp_results_marker_data', array($this, 'filter_ModifyAJAXResponse'), 10);

            // AJAX Processing Filters
            //
            add_filter('slp_location_filters_for_AJAX', array($this, 'filter_JSONP_SearchByTags'));
        }

        /**
         * Convert an array to CSV.
         *
         * @param array[] $data
         * @return string
         */
        static function array_to_CSV($data) {
            $outstream = fopen("php://temp", 'r+');
            fputcsv($outstream, $data, ',', '"');
            rewind($outstream);
            $csv = fgets($outstream);
            fclose($outstream);
            return $csv;
        }

        /**
         * Set the plugin property to point to the primary plugin object.
         *
         * @global wpCSL_plugin__slplus $this->plugin
         * @return boolean true if plugin property is valid
         */
        function setPlugin() {
            if (!isset($this->slplus) || ($this->slplus == null)) {
                global $slplus_plugin;
                $this->slplus = $slplus_plugin;
            }
            $this->initOptions();

            return (
                    isset($this->slplus) &&
                    ($this->slplus != null)
                    );
        }

        /**
         * Create a Map Settings Debug My Plugin panel.
         *
         * @return null
         */
        static function create_DMPPanels() {
            if (!isset($GLOBALS['DebugMyPlugin'])) {
                return;
            }
            if (class_exists('DMPPanelSLPPro') == false) {
                require_once(plugin_dir_path(__FILE__) . 'include/class.dmppanels.php');
            }
            $GLOBALS['DebugMyPlugin']->panels['slp.pro'] = new DMPPanelSLPPro();
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

            return array_merge(
                    array(
                'endicon' => null,
                'homeicon' => null,
                'only_with_tag' => null,
                'tags_for_pulldown' => null,
                    ), $valid_atts
            );
        }

        /**
         * Add the Pro Pack menu
         *
         * @param mixed[] $menuItems
         * @return mixed[]
         */
        function filter_AddMenuItems($menuItems) {
            return array_merge(
                    $menuItems, array(
                array(
                    'label' => $this->name,
                    'slug' => 'slp_propack',
                    'class' => $this,
                    'function' => 'prepare_ProPack_Settings'
                ),
                array(
                    'label' => __('Reports', 'csa-slp-pro'),
                    'url' => $this->dir . 'reporting.php'
                )
                    )
            );
        }

        /**
         * Add the tags condition to the MySQL statement used to fetch locations with JSONP.
         *
         * @param type $currentFilters
         * @return type
         */
        function filter_JSONP_SearchByTags($currentFilters) {
            if (!isset($_POST['tags']) || ($_POST['tags'] == '')) {
                return $currentFilters;
            }

            $posted_tag = preg_replace('/^\s+(.*?)/', '$1', $_POST['tags']);
            $posted_tag = preg_replace('/(.*?)\s+$/', '$1', $posted_tag);
            return array_merge(
                    $currentFilters, array(" AND ( sl_tags LIKE '%%" . $posted_tag . "%%') ")
            );
        }

        /**
         * Take over the search form layout.
         *
         * @param string $HTML the original SLP layout
         * @return string the modified layout
         */
        function filter_TakeOverLayout($HTML) {
            $this->debugMP('msg', __FUNCTION__);
            if (empty($this->options['layout'])) {
                return $HTML;
            }
            $this->debugMP('msg', '', 'new layout:' . $this->options['layout']);
            return $this->options['layout'];
        }

        /**
         * Add Custom CSS to the UI header.
         * 
         * @param type $HTML
         */
        function filter_UI_CustomCSS($HTML) {
            return
                    $HTML .
                    strip_tags($this->slplus->settings->get_item('custom_css', ''))
            ;
        }

        /**
         * Initialize the options properties from the WordPress database.
         *
         * @param boolean $force
         */
        function initOptions($force = false) {
            if (!$force && $this->optionsSet) {
                return;
            }
            $this->debugMP('msg', __FUNCTION__ . ' for ' . $this->name . ' ' . SLPPro::VERSION);
            $dbOptions = get_option(SLPPro::OPTION_NAME);
            if (is_array($dbOptions)) {
                $this->options = array_merge($this->options, $dbOptions);
            }

            // Search Form
            // Since this defaults to off we only need to test this
            // if the database had Tagalong options in it.
            //
            if ($this->options['tag_selector'] !== 'none') {
                add_filter('slp_searchlayout', array($this, 'filter_ModifySearchLayout'), 999);
            }

            $this->optionsSet = true;
        }

        /**
         * Create and attach the admin processing object.
         */
        function createobject_Admin() {
            if (!isset($this->Admin)) {
                require_once($this->dir . 'include/class.admin.php');
                $this->Admin = new SLPPro_Admin(
                        array(
                    'addon' => $this,
                    'slplus' => $this->slplus,
                        )
                );
            }
        }

        /**
         * Puts the tag list on the search form for users to select tags by drop down.
         *
         * @param string[] $tags tags as an array of strings
         * @param boolean $showany show the any pulldown entry if true
         */
        function createstring_SearchFormTagDropdown($tags, $showany = false) {

            $HTML = "<select id='tag_to_search_for' >";

            // Show Any Option (blank value)
            //
                if ($showany) {
                $HTML.= "<option value=''>" .
                        get_option(SLPLUS_PREFIX . '_tag_pulldown_first', __('Any', 'csa-slp-pro')) .
                        '</option>';
            }

            foreach ($tags as $selection) {
                $clean_selection = preg_replace('/\((.*)\)/', '$1', $selection);
                $HTML.= "<option value='$clean_selection' ";
                $HTML.= (preg_match('#\(.*\)#', $selection)) ? " selected='selected' " : '';
                $HTML.= ">$clean_selection</option>";
            }
            $HTML.= "</select>";
            return $HTML;
        }

        /**
         * Puts the tag list on the search form for users to select tags by radio buttons
         *
         * @param string[] $tags tags as an array of strings
         * @param boolean $showany show the any pulldown entry if true
         */
        function createstring_SearchFormTagRadioButtons($tags, $showany = false) {
            $HTML = '';
            $thejQuery = "onClick='" .
                    "jQuery(\"#tag_to_search_for\").val(this.value);" .
                    (
                    ($this->slplus->settings->get_item('enhanced_search_auto_submit', 0) == 1) ?
                            "jQuery(\"#searchForm\").submit();" :
                            ''
                    ) .
                    "'"
            ;
            $oneChecked = false;
            $hiddenValue = '';
            foreach ($tags as $tag) {
                $checked = false;
                $clean_tag = preg_replace("/\((.*?)\)/", '$1', $tag);
                if (
                        ($clean_tag != $tag) ||
                        (!$oneChecked && !$showany && ($tag == $tags[0]))
                ) {
                    $checked = true;
                    $oneChecked = true;
                    $hiddenValue = $clean_tag;
                }
                $HTML .=
                        '<span class="slp_checkbox_entry">' .
                        "<input type='radio' name='tag_to_search_for' value='$clean_tag' " .
                        $thejQuery .
                        ($checked ? ' checked' : '') . ">" .
                        $clean_tag .
                        '</span>'
                ;
            }

            if ($showany) {
                $HTML .=
                        '<span class="slp_radio_entry">' .
                        "<input type='radio' name='tag_to_search_for' value='' " .
                        $thejQuery .
                        ($oneChecked ? '' : 'checked') . ">" .
                        "Any" .
                        '</span>';
            }

            // Hidden field to store selected tag for processing
            //
            $HTML .= "<input type='hidden' id='tag_to_search_for' name='hidden_tag_to_search_for' value='$hiddenValue'>";

            if (!empty($HTML)) {
                $HTML = '<div class="slp_checkbox_group">' . $HTML . '</div>';
            }

            return $HTML;
        }

        /**
         * Enqueue the admin scripts.
         *
         * @param string $hook
         */
        function action_EnqueueAdminScripts($hook) {
            $scriptHandle = '';
            $styleHandle = '';
            switch ($hook) {
                case 'slp-pro/reporting.php':
                    wp_enqueue_script('jquery_tablesorter', $this->url . '/jquery.tablesorter.js', array('jquery'));
                    wp_enqueue_script('slp_reporting', $this->url . '/reporting.js');
                    $scriptHandle = 'slp_reporting_js';
                    $styleHandle = 'slp_pro_style';
                    break;

                case SLP_ADMIN_PAGEPRE . 'slp_propack':
                    $scriptHandle = 'slp_pro_settings';
                    $styleHandle = 'slp_pro_style';
                    break;

                case SLP_ADMIN_PAGEPRE . 'slp_manage_locations':
                    $styleHandle = 'slp_pro_style';
                    break;


                default:
                    $scriptHandle = '';
                    break;
            }

            // If we have a script handle, load it up...
            //
            if ($scriptHandle != '') {
                wp_enqueue_script($scriptHandle, $this->url . '/settings.js', array('jquery'));
                $scriptData = array(
                    'plugin_url' => SLPLUS_PLUGINURL,
                    'core_url' => SLPLUS_COREURL,
                );
                wp_localize_script($scriptHandle, 'slp_pro', $scriptData);
            }

            // Load up the admin.css style sheet for Pro Pack
            //
            if ($styleHandle !== '') {
                wp_register_style('slp_pro_style', $this->url . '/pro_admin.css');
                wp_enqueue_style('slp_pro_style');
                wp_enqueue_style($this->slplus->AdminUI->styleHandle);
            }
        }

        /**
         * Process incoming AJAX request to download the CSV file.
         * TODO: use locations extended class
         */
        static function ajax_downloadLocationCSV($params) {
            if ( ! class_exists( 'CSVExportLocations' ) ) {
                require_once(plugin_dir_path(__FILE__) . 'include/class.csvexport.locations.php');
            }

            global $slplus_plugin;
            if ( ! is_a($slplus_plugin, 'SLPlus' ) ) {
                $slp_class_file = str_replace('slp-pro/slp-pro.php','store-locator-le/include/class.slplus.php',__FILE__);
                require_once($slp_class_file);
                $slplus_plugin = new SLPlus();                          
            }
            
            $csvLocationExporter = new CSVExportLocations(array(
                'slplus' => $slplus_plugin,
                'type' => 'Locations'
            ));
            $csvLocationExporter->do_SendFile();
        }

        /**
         * Process incoming AJAX request to download the CSV file.
         */
        static function ajax_downloadReportCSV() {
            // CSV Header
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=slplus_' . $_REQUEST['filename'] . '.csv');
            header('Content-Type: application/csv;');
            header('Pragma: no-cache');
            header('Expires: 0');

            // Setup our processing vars
            //
            global $wpdb;
            $query = $_REQUEST['query'];

            // All records - revise query
            //
            if (isset($_REQUEST['all']) && ($_REQUEST['all'] == 'true')) {
                $query = preg_replace('/\s+LIMIT \d+(\s+|$)/', '', $query);
            }

            $slpQueryTable = $wpdb->prefix . 'slp_rep_query';
            $slpResultsTable = $wpdb->prefix . 'slp_rep_query_results';
            $slpLocationsTable = $wpdb->prefix . 'store_locator';

            $expr = "/,(?=(?:[^\"]*\"[^\"]*\")*(?![^\"]*\"))/";
            $parts = preg_split($expr, trim(html_entity_decode($query, ENT_QUOTES)));
            $parts = preg_replace("/^\"(.*)\"$/", "$1", $parts);

            // Return the address in CSV format from the reports
            //
            if ($parts[0] === 'addr') {
                $slpReportStartDate = $parts[1];
                $slpReportEndDate = $parts[2];

                // Only Digits Here Please
                //
                $slpReportLimit = preg_replace('/[^0-9]/', '', $parts[3]);

                $query = "SELECT slp_repq_address, count(*)  as QueryCount FROM $slpQueryTable " .
                        "WHERE slp_repq_time > %s AND " .
                        "      slp_repq_time <= %s " .
                        "GROUP BY slp_repq_address " .
                        "ORDER BY QueryCount DESC " .
                        "LIMIT %d"
                ;
                $queryParms = array(
                    $slpReportStartDate,
                    $slpReportEndDate,
                    $slpReportLimit
                );

                // Return the locations searches in CSV format from the reports
            //
            } else if ($parts[0] === 'top') {
                $slpReportStartDate = $parts[1];
                $slpReportEndDate = $parts[2];

                // Only Digits Here Please
                //
                $slpReportLimit = preg_replace('/[^0-9]/', '', $parts[3]);

                $query = "SELECT sl_store,sl_city,sl_state, sl_zip, sl_tags, count(*) as ResultCount " .
                        "FROM $slpResultsTable res " .
                        "LEFT JOIN $slpLocationsTable sl " .
                        "ON (res.sl_id = sl.sl_id) " .
                        "LEFT JOIN $slpQueryTable qry " .
                        "ON (res.slp_repq_id = qry.slp_repq_id) " .
                        "WHERE slp_repq_time > %s AND slp_repq_time <= %s " .
                        "GROUP BY sl_store,sl_city,sl_state,sl_zip,sl_tags " .
                        "ORDER BY ResultCount DESC " .
                        "LIMIT %d"
                ;
                $queryParms = array(
                    $slpReportStartDate,
                    $slpReportEndDate,
                    $slpReportLimit
                );

                // Not Locations (top) or addresses entered in search
                // short circuit...
            //
            } else {
                die(__("Cheatin' huh!", 'csa-slp-pro'));
            }

            // No parms array?  GTFO
            //
            if (!is_array($queryParms)) {
                die(__("Cheatin' huh!", 'csa-slp-pro'));
            }


            // Run the query & output the data in a CSV
            $thisDataset = $wpdb->get_results($wpdb->prepare($query, $queryParms), ARRAY_N);


            // Sorting
            // The sort comes in based on the display table column order which
            // matches the query output column order listed here.
            //
            // It is a paired array, first number is the column number (zero offset)
            // second number is the sort order [0=ascending, 1=descending]
            //
            // The sort needs to happen AFTER the select.
            //

            // Get our sort array
            //
            $thisSort = explode(',', $_REQUEST['sort']);

            // Build our array_multisort command and our sort index/sort order arrays
            // we will need this later for helping do a multi-dimensional sort
            //
            $sob = 'sort';
            $amsstring = '';
            $sortarrayindex = 0;
            foreach ($thisSort as $sl_value) {
                if ($sob == 'sort') {
                    $sort[] = $sl_value;
                    $amsstring .= '$s[' . $sortarrayindex++ . '], ';
                    $sob = 'order';
                } else {
                    $order[] = $sl_value;
                    $amsstring .= ($sl_value == 0) ? 'SORT_ASC, ' : 'SORT_DESC, ';
                    $sob = 'sort';
                }
            }
            $amsstring .= '$thisDataset';

            // Now that we have our sort arrays and commands,
            // build the indexes that will be used to do the
            // multi-dimensional sort
            //
            foreach ($thisDataset as $key => $row) {
                $sortarrayindex = 0;
                foreach ($sort as $column) {
                    $s[$sortarrayindex++][$key] = $row[$column];
                }
            }

            // Now do the multidimensional sort
            //
            // This will sort using the first array ($s[0] we built in the above 2 steps)
            // to determine what order to put the "records" (the outter array $thisDataSet)
            // into.
            //
            // If there are secondary arrays ($s[1..n] as built above) we then further
            // refine the sort using these secondary arrays.  Think of them as the 2nd
            // through nth columns in a multi-column sort on a spreadsheet.
            //
            // This exactly mimics the jQuery sorts that manage our tables on the HTML
            // page.
            //

            //array_multisort($amsstring);
            // Output the sorted CSV strings
            // This simply iterates through our newly sorted array of records we
            // got from the DB and writes them out in CSV format for download.
            //
            foreach ($thisDataset as $thisDatapoint) {
                print SLPPro::array_to_CSV($thisDatapoint);
            }

            // Get outta here
            die();
        }

        /**
         * Create the tag input div wrapper and label.
         *
         * @param string $innerHTML the input field portion of the div.
         * @return string the div and label tags added.
         */
        function createstring_TagDiv($innerHTML) {
            return
                    '<div id="search_by_tag" class="search_item">' .
                    '<label for="tag_to_search_for">' .
                    $this->options['tag_label'] .
                    '</label>' .
                    $innerHTML .
                    '</div>';
        }

        /**
         * Add our custom tag selection div to the search form.
         *
         * @return string the HTML for this div appended to the other HTML
         */
        function createstring_TagSelector() {
            $this->debugMP('msg', __FUNCTION__);
            if (!$this->setPlugin()) {
                return;
            }

            // Only With Tag shortcode.
            // Set tag selector to hidden.
            //
            if (!empty($this->slplus->data['only_with_tag'])) {
                $this->options['tag_selector'] = 'hidden';
                $this->options['tag_selections'] = sanitize_title($this->slplus->data['only_with_tag']);
                $showTagInput = true;
            }

            // No Tag List For Drop Down
            // Set tag selector to textinput
            //
            if ($this->options['tag_selector'] === 'dropdown') {
                if (isset($this->slplus->data['tags_for_pulldown'])) {
                    $this->options['tag_selections'] = $this->slplus->data['tags_for_pulldown'];
                }

                // No pre-selected tags, use input box
                //
                if ($this->options['tag_selections'] === '') {
                    $this->options['tag_selector'] = 'textinput';
                    $this->options['tag_selections'] = (isset($this->slplus->data['only_with_tag'])) ?
                            $this->slplus->data['only_with_tag'] :
                            '';
                }
            }

            // Process the category selector type
            //
            switch ($this->options['tag_selector']) {

                // None
                //
                case 'none':
                    $HTML = '';
                    break;

                // Hidden Field
                //
                case 'hidden':
                    $HTML = "<input type='hidden' " .
                            "name='tag_to_search_for' " .
                            "id='tag_to_search_for' " .
                            "value='{$this->options['tag_selections']}' " .
                            "textvalue='{$this->slplus->data['only_with_tag']}' " .
                            '/>';
                    break;

                // Text Input
                //
                case 'textinput':
                    $this->options['tag_label'] = get_option(SLPLUS_PREFIX . '_search_tag_label', '');
                    $HTML = $this->createstring_TagDiv(
                            "<input type='text' " .
                            "name='tag_to_search_for' " .
                            "id='tag_to_search_for' size='50' " .
                            "value='{$this->options['tag_selections']}' " .
                            "/>"
                    );
                    break;

                // Radio Button Selector for Tags on UI
                //
                case 'radiobutton':
                    $this->options['tag_label'] = get_option(SLPLUS_PREFIX . '_search_tag_label', '');
                    $tag_selections = explode(",", $this->options['tag_selections']);
                    if (count($tag_selections) > 0) {
                        $HTML = $this->createstring_SearchFormTagRadioButtons(
                                $tag_selections, $this->slplus->is_CheckTrue(get_option(SLPLUS_PREFIX . '_show_tag_any', '0'))
                        );
                        $HTML = $this->createstring_TagDiv($HTML);
                    } else {
                        $HTML = '';
                        $this->debugMP('msg', '', 'The tag selection list is empty.');
                    }
                    break;

                // Drop Down Style Selector for Tags on UI
                //
                case 'dropdown':
                    $this->options['tag_label'] = get_option(SLPLUS_PREFIX . '_search_tag_label', '');
                    $tag_selections = explode(",", $this->options['tag_selections']);
                    if (count($tag_selections) > 0) {
                        $HTML = $this->createstring_SearchFormTagDropdown(
                                $tag_selections, $this->slplus->is_CheckTrue(get_option(SLPLUS_PREFIX . '_show_tag_any', '0'))
                        );
                        $HTML = $this->createstring_TagDiv($HTML);
                    } else {
                        $HTML = '';
                        $this->debugMP('msg', '', 'The tag selection list is empty.');
                    }
                    break;

                default:
                    $HTML = '';
                    break;
            }

            return $HTML;
        }

        /**
         * Simplify the plugin debugMP interface.
         *
         * @param string $type
         * @param string $hdr
         * @param string $msg
         */
        function debugMP($type, $hdr, $msg = '') {
            if (!is_object($this->slplus)) {
                return;
            }
            $this->slplus->debugMP('slp.pro', $type, $hdr, $msg, NULL, NULL, true);
        }

        /**
         * Attach admin and render the Pro Pack Settings tab.
         */
        function prepare_ProPack_Settings() {
            $this->createobject_Admin();
            $this->Admin->render_ProPack_SettingsTab();
        }

        /**
         * Insert the query into the query DB
         * Insert the results into the reporting table
         *
         * @param Associate Array Contain query sql, tags, address and radius
         * @param string[] Query result row id array
         */
        function insert_Report_QueryandResults($queryParams, $results) {
            global $wpdb;

            // Insert the query into the query DB
            //
			if ($this->slplus->is_CheckTrue($this->slplus->addons['slp-pro']->options['reporting_enabled'])) {

                $qry = sprintf(
                        "INSERT INTO {$this->slplus->db->prefix}slp_rep_query " .
                        "(slp_repq_query,slp_repq_tags,slp_repq_address,slp_repq_radius) " .
                        "values ('%s','%s','%s','%s')", mysql_real_escape_string($queryParams['QUERY_STRING']), mysql_real_escape_string($queryParams['tags']), mysql_real_escape_string($queryParams['address']), mysql_real_escape_string($queryParams['radius'])
                );
                $wpdb->query($qry);
                $slp_QueryID = mysql_insert_id();

                // Insert the results into the reporting table
                //
				foreach ($results as $rowid) {
                    $wpdb->query(
                            sprintf(
                                    "INSERT INTO {$this->slplus->db->prefix}slp_rep_query_results
				                    (slp_repq_id,sl_id) values (%d,%d)", $slp_QueryID, $rowid
                            )
                    );
                }
            }
        }

    }

    // Hook to invoke the plugin.
    //
    add_action('init', array('SLPPro', 'init'));

    // AJAX Listeners
    //
    add_action('wp_ajax_slp_download_report_csv', array('SLPPro', 'ajax_downloadReportCSV'));
    add_action('wp_ajax_slp_download_locations_csv', array('SLPPro', 'ajax_downloadLocationCSV'));

    // DMP
    //
    add_action('dmp_addpanel', array('SLPPro', 'create_DMPPanels'));
}
// Dad. Explorer. Rum Lover. Code Geek. Not necessarily in that order.
