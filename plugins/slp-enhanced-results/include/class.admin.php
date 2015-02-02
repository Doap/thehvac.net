<?php
if (! class_exists('SLPEnhancedResults_Admin')) {
    require_once(SLPLUS_PLUGINDIR.'/include/base_class.admin.php');

    /**
     * Holds the admin-only code.
     *
     * This allows the main plugin to only include this file in admin mode
     * via the admin_menu call.   Reduces the front-end footprint.
     *
     * @package StoreLocatorPlus\SLPEnhancedResults\Admin
     * @author Lance Cleveland <lance@charlestonsw.com>
     * @copyright 2014 Charleston Software Associates, LLC
     */
    class SLPEnhancedResults_Admin extends SLP_BaseClass_Admin {

        //-------------------------------------
        // Properties
        //-------------------------------------

        /**
         * List of option keys that are checkboxes.
         *
         * Helps with processing during save of form posts.
         *
         * @var string[] $cb_options
         */
        private $cb_options = array (
            'add_tel_to_phone'  ,
            'show_country'      ,
            'show_hours'        ,
        );

        //-------------------------------------
        // Methods : Base Override
        //-------------------------------------

        /**
         * Admin specific hooks and filters.
         *
         */
        function add_hooks_and_filters() {
            // Admin : Locations
            //
            add_filter('slp_manage_location_columns'        ,array($this,'filter_AddFieldHeadersToManageLocations'      )           );
            add_filter('slp_column_data'                    ,array($this,'filter_AddFieldDataToManageLocations'         ), 90 ,  3  );
            add_filter('slp_locations_manage_cssclass'      ,array($this,'filter_HighlightFeatured'                     )           );
            
            // Pro Pack Imports
            //
            add_filter('slp_csv_locationdata_added'         ,array($this,'filter_CSVImportLocationFeatures'             ), 90 , 2   );

            // Admin : User Experience
            //
            add_filter('slp_settings_results_locationinfo'  ,array($this,'filter_AddResultsSettingsPanel'               ), 20       );
            add_filter('slp_settings_results_labels'        ,array($this,'filter_AddLabelSettings'                      )           );

            // Data Saving
            //
            add_filter('slp_save_map_settings_checkboxes'   ,array($this,'filter_SaveMapCBSettings'                     )           );
            add_filter('slp_save_map_settings_inputs'       ,array($this,'filter_SaveMapInputSettings'                  )           );
            add_action('slp_save_map_settings'              ,array($this,'filter_SaveSerialData'                        ),  9       );

            // Location bulk action
            //
            add_filter('slp_locations_manage_bulkactions'   ,array($this,'filter_LocationsBulkAction'                   )           );
            add_action('slp_manage_locations_action'        ,array($this,'action_ManageLocationsProcessing'             )           );
        }


        /**
         * Set base class properties so we can have more cross-add-on methods.
         */
        function set_addon_properties() {
            $this->admin_page_slug = $this->addon->slug;
        }


        //-------------------------------------
        // Methods : Custom : String Creation
        //-------------------------------------

        /**
         * Create the order by setting string section.
         *
         * Selections include:
         * - Featured, Rank, Closest
         * - Featured, Rank, A..Z
         * - Featured Then Closest
         * - Featured Then A..Z
         * - Rank Then Closest
         * - Rank Then A..Z
         * - Closest..Furthest
         * - A..Z
         * - Random
         *
         */
        function createstring_OrderByDropdown() {
            $selections[__('Featured, Rank, Closest','csa-slp-er')] = 'featured DESC,rank ASC,sl_distance ASC';
            $selections[__('Featured, Rank, A..Z'   ,'csa-slp-er')] = 'featured DESC,rank ASC,sl_store ASC';
            $selections[__('Featured Then Closest','csa-slp-er')] = 'featured DESC,sl_distance ASC';
            $selections[__('Featured Then A..Z'   ,'csa-slp-er')] = 'featured DESC,sl_store ASC';
            $selections[__('Rank Then Closest','csa-slp-er')] = 'rank ASC,sl_distance ASC';
            $selections[__('Rank Then A..Z'   ,'csa-slp-er')] = 'rank ASC,sl_store ASC';
            $selections[__('Closest..Furthest'  ,'csa-slp-er')]  = 'sl_distance ASC';
            $selections[__('Name A..Z'          ,'csa-slp-er')]  = 'sl_store ASC';
            $selections[__('Random'             ,'csa-slp-er')]  = 'random';

            $content =
                "<div class='form_entry'>"                  .
                    "<label for='".SLPLUS_PREFIX."-ER-options[orderby]'>"         .
                    __('Order Results By: ', 'csa-slp-er')  .
                    "</label>"                              .
                    "<select name='".SLPLUS_PREFIX."-ER-options[orderby]'>"
                    ;
            foreach ($selections as $key=>$value) {
                $selected=($this->addon->options['orderby']==$value)?" selected " : "";
                $content .= "<option value='$value' $selected>$key</option>\n";
            }
            $content .= "</select></div>";

            return $content;
        }

        //-------------------------------------
        // Methods : Custom : Filters
        //-------------------------------------

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
        function filter_AddFieldDataToManageLocations($theData,$theField,$theLabel) {
            if (
                ($theField === 'sl_image') &&
                ($theLabel === __('Image'        ,'csa-slp-er'))
               ) {
                $theData =($this->slplus->currentLocation->image!='')?
                          "<a href='".$this->slplus->currentLocation->image.
                                "' target='blank'>".__('View', 'csa-slp-er')."</a>" :
                          "" ;
            }
            return $theData;
        }

        /**
         * Add the images column header to the manage locations table.
         *
         * SLP Filter: slp_manage_location_columns
         *
         * @param mixed[] $currentCols column name + column label for existing items
         * @return mixed[] column name + column labels, extended with our extra fields data
         */
        function filter_AddFieldHeadersToManageLocations($currentCols) {
            return array_merge($currentCols,
                    array(
                        'sl_image'       => __('Image'        ,'csa-slp-er'),
                    )
                );
        }

        /**
         * Add more settings to the Result / Label section of Map Setings.
         *
         * @param string $HTML the initial form HTML
         * @return string the modified form HTML
         */
        function filter_AddLabelSettings($HTML) {
            return $HTML .
                '<strong>'.$this->addon->name.'</strong><br/>'.
                $this->slplus->AdminUI->MapSettings->CreateInputDiv(
                        '_message_noresultsfound',
                        __('No Results Message', 'csa-slp-er'),
                        __('No results found message that appears under the map.','csa-slp-er'),
                        SLPLUS_PREFIX,
                        __('Results not found.','csa-slp-er')
                        );
        }

        /**
         * Add settings the the SLP Map Settings Results panel.
         *
         * @param string $HTML - the default (or current) results string HTML
         * @return string - the modified HTML
         */
        function filter_AddResultsSettingsPanel($HTML) {
            $this->msUI = $this->slplus->AdminUI->MapSettings;
            $this->UI   = $this->slplus->helper;

            return
                $HTML .
                $this->UI->create_SubheadingLabel(__('Enhanced Results','csa-slp-er')).
                $this->UI->CreateCheckboxDiv(
                    '_disable_initialdirectory',
                    __('Disable Initial Directory','csa-slp-er'),
                    __('Do not display the listings under the map when "immediately show locations" is checked.', 'csa-slp-er')
                    ) .
                $this->UI->CreateCheckboxDiv(
                    '-ER-options[add_tel_to_phone]',
                    __('Use tel URI','csa-slp-er'),
                    __('When checked, wraps the phone number in the results in a tel: href tag.', 'csa-slp-er'),
                    null,false,0,
                    $this->addon->options['add_tel_to_phone']
                    ) .
                $this->UI->CreateCheckboxDiv(
                    '-enhanced_results_hide_distance_in_table',
                    __('Hide Distance','csa-slp-er'),
                    __('Do not show the distance to the location in the results table.', 'csa-slp-er')
                    ) .
                $this->UI->CreateCheckboxDiv(
                    '-ER-options[show_country]',
                    __('Show Country','csa-slp-er'),
                    __('Display the country in the results table address.', 'csa-slp-er'),
                    null,false,0,
                    $this->addon->options['show_country']
                    ) .
                $this->UI->CreateCheckboxDiv(
                    '-ER-options[show_hours]',
                    __('Show Hours','csa-slp-er'),
                    __('Display the hours in the results table under the Directions link.', 'csa-slp-er'),
                    null,false,0,
                    $this->addon->options['show_hours']
                    ) .
                $this->createstring_OrderByDropdown().
                $this->slplus->helper->createstring_DropDownDiv(array(
                                                                'id'               => 'featured_location_display_type',
                                                                'name'             => 'featured_location_display_type',
                                                                'label'            => 'Featured Locations',
                                                                'helptext'         => sprintf("%s<br/>%s<br/>%s"
                                                                                     ,__('Set if the featured location should be showed:', 'csa-slp-er')
                                                                                     ,__('Show If In Radius - Only when the location are in rsdius.', 'csa-slp-er')
                                                                                     ,__('Always Show - Always show featured locations.', 'csa-slp-er')),
                                                                'onchange'         => '',
                                                                'selectedVal'      => (empty($this->addon->options['featured_location_display_type'])?''
                                                                                      :$this->addon->options['featured_location_display_type']),
                                                                'items'            => array(
                                                                    array( 'label' => __('Show If In Radius', 'csa-slp-er'), 'value' => 'show_within_radius' ),
                                                                    array( 'label' => __('Always Show',       'csa-slp-er'), 'value' => 'show_always'),
                                                                ))).
                $this->msUI->CreateTextAreaDiv(
                    '-ER-options[resultslayout]',
                    __('Results Layout','csa-slp-er'),
                    __('Enter your custom results area layout for the location results. ','csa-slp-er') .
                        sprintf('<a href="%s/user-experience/results/results-layout/" target="csa">%s</a> ',
                                $this->slplus->support_url,
                                sprintf(__('Uses HTML plus %s shortcodes.','csa-slp-er'),$this->addon->name)
                                ) .
                        __('Set it to blank to reset to the default layout. ','csa-slp-er') .
                        __('Overrides all other results settings.','csa-slp-er')
                        ,
                    SLPLUS_PREFIX,
                    $this->addon->options['resultslayout'],
                    true
                    )
               ;
        }

        /**
         * Process incoming CSV import data and add our extended field attributes.
         *
         * note: CSV import field names always get the sl_ prefixed.
         *
         * @param mixed[] $locationData
         * @param string $result
         * @return the original data, unchanged
         */
        function filter_CSVImportLocationFeatures($locationData, $result) {
            $newData = array();
            $extended_data_fields = array('featured', 'rank');
            foreach ($extended_data_fields as $field) {
                if ( isset($locationData['sl_'.$field]) ) { $newData[$field] = $locationData['sl_'.$field]; }
            }
            if ( count( $newData ) > 0 ) {
                $this->slplus->database->extension->update_data(
                    $this->slplus->currentLocation->id,
                    $newData
                 );
            }
            return array($locationData,$result);
        }

        /**
         * Highlight the featured elements on the manage locations panel.
         *
         * @param string $extraCSSClasses
         */
        function filter_HighlightFeatured($extraCSSClasses) {
            return $extraCSSClasses . (($this->slplus->currentLocation->featured)?' featured ':'');
        }


        /**
         * Save our checkboxes from the map settings page.
         *
         * @param string[] $cbArray array of checkbox names to be saved
         * @return string[] augmented list of inputs to save
         */
        function filter_SaveMapCBSettings($cbArray) {
            return array_merge($cbArray,
                    array(
                        SLPLUS_PREFIX.'_disable_initialdirectory'                   ,
                        SLPLUS_PREFIX.'-enhanced_results_hide_distance_in_table'    ,
                        )
                    );
        }

        /**
         * Add the input settings to be saved on the map settings page.
         *
         * @param string[] $inArray names of inputs already to be saved
         * @return string[] modified array with our Pro Pack inputs added.
         */
        function filter_SaveMapInputSettings($inArray) {
            array_walk($_REQUEST,array($this->addon,'set_ValidOptions'));
            update_option(SLPEnhancedResults::OPTION_NAME, $this->addon->options);
            return array_merge($inArray,
                    array(
                        SLPLUS_PREFIX.'-enhanced_results_string',
                        SLPLUS_PREFIX.'_message_noresultsfound' ,
                        )
                    );
        }

        /**
         * Save the serialized data an drop down to the database.
         */
        function filter_SaveSerialData() {
            $this->addon->options =
                $this->slplus->AdminUI->save_SerializedOption(
                    SLPEnhancedResults::OPTION_NAME,
                    $this->addon->options,
                    $this->cb_options
                    );
            $this->slplus->initOptions(true);
        }

        /**
         * Add more actions to the Bulk Action drop down on the admin Locations/Manage Locations interface.
         *
         * @param mixed[] $BulkActions
         */
        function filter_LocationsBulkAction($items) {
            return
                array_merge(
                    $items,
                    array(
                        array(
                            'label'     =>  __('Feature Location','csa-slp-er')      ,
                            'value'     => 'feature_location'                        ,
                        ),
                        array(
                            'label'     =>  __('Stop Featuring Location','csa-slp-er') ,
                            'value'     => 'remove_feature_location'                 ,
                        ),
                    )
                );
        }

        /**
         * Additional location processing on manage locations admin page.
         *
         */
        function action_ManageLocationsProcessing() {
            switch ($_REQUEST['act']) {

                // Add tags to locations
                case 'feature_location':
                    if (isset($_REQUEST['sl_id'])) { $this->feature_Locations('add'); }
                    break;

                // Remove tags from locations
                case 'remove_feature_location':
                    if (isset($_REQUEST['sl_id'])) { $this->feature_Locations('remove'); }
                    break;

                default:
                    break;
            }
        }

        /**
         * feature a location
         *
         * @param string $action = add or remove
         */
        function feature_Locations($action) {

            // Setup the location ID array
            //
            if ( is_array( $_REQUEST['sl_id'] ) ) {
                $locationIDs = $_REQUEST['sl_id'];
            } else {
                $locationIDs = array();
                $locationIDs[] = $_REQUEST['sl_id'];
            }
            foreach ( $locationIDs as $locationID ) {
                $this->slplus->database->extension->update_data(
                    $locationID,
                    array('featured' => ( $action === 'add' ) ? '1' : '0' )
                 );
            }
        }

    }
}
// Dad. Explorer. Rum Lover. Code Geek. Not necessarily in that order.
