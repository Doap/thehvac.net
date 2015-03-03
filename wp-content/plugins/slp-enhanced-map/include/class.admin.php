<?php
if (! class_exists('SLPEnhancedMap_Admin')) {

    /**
     * Holds the admin-only code.
     *
     * This allows the main plugin to only include this file in admin mode
     * via the admin_menu call.   Reduces the front-end footprint.
     *
     * @package StoreLocatorPlus\EnhancedMap\Admin
     * @author Lance Cleveland <lance@charlestonsw.com>
     * @copyright 2013 Charleston Software Associates, LLC
     */
    class SLPEnhancedMap_Admin {

        //-------------------------------------
        // Properties
        //-------------------------------------

        /**
         * The activation handler.
         * 
         * @var \SLPEnhancedMap_Activation $activation
         */
        private $activation;

        /**
         * This addon pack.
         *
         * @var \SLPEnhancedMap $addon
         */
        private $addon;

        /**
         * The parent add-on pack.
         *
         * @var \SLPEnhancedMap $parent
         */
        private $parent = null;

        /**
         * The base SLPlus object.
         *
         * @var \SLPlus $slplus
         */
        private $slplus;

        //-------------------------------------
        // Methods
        //-------------------------------------

        /**
         * Instantiate the admin panel object.
         *
         * @param mixed[] $params
         */
        function __construct($params) {
            // Set properties based on constructor params,
            // if the property named in the params array is well defined.
            //
            if ($params !== null) {
                foreach ($params as $property=>$value) {
                    if (property_exists($this,$property)) { $this->$property = $value; }
                }
            }

            // Check the version.
            //
            global $wpdb;
            if ( version_compare( $this->addon->options['installed_version'] , SLPEnhancedMap::VERSION , '<' ) ) {
                if (class_exists('SLPEnhancedMap_Activation') == false) {
                    require_once(plugin_dir_path(__FILE__).'class.activation.php');
                }
                $this->activation = new SLPEnhancedMap_Activation(array('plugin'=>$this->parent));
                $this->activation->update();
                $this->addon->options['installed_version'] = SLPEnhancedMap::VERSION;
                update_option(SLPEnhancedMap::OPTION_NAME,$this->addon->options);
            }

            // Manage Location Fields
            // - tweak the add/edit form
            //
            add_filter('slp_edit_location_right_column'         ,array($this,'filter_AddFieldsToEditForm'   ),11);

            // Map Settings Page
            //
            add_filter('slp_map_features_settings'          ,array($this,'filter_MapFeatures_AddSettings'   ),10);
            add_filter('slp_map_settings_settings'          ,array($this,'filter_MapSettings_AddSettings'   ),10);

            // Save Data
            //
            add_filter('slp_save_map_settings_checkboxes'   ,array($this,'filter_SaveUXCheckboxes'           ),10);
            add_filter('slp_save_map_settings_inputs'       ,array($this,'filter_SaveUXInputs'               ),10);
        }


        /**
         * Add extra fields that show in results output to the edit form.
         *
         * SLP Filter: slp_edit_location_right_column
         *
         * @param string $theForm the original HTML form for the manage locations edit (right side)
         * @return string the modified HTML form
         */
        function filter_AddFieldsToEditForm($theHTML) {
            $theHTML .=
                '<div id="slp_em_fields" class="slp_editform_section">'.
                $this->slplus->helper->create_SubheadingLabel(__('Enhanced Map','csa-slp-em'))
                ;

            // Add or Edit
            //
            $theHTML .=
                $this->slplus->AdminUI->ManageLocations->createstring_InputElement(
                        'attributes[marker]',
                        __("Map Marker", 'csa-slp-em'),
                        isset($this->slplus->currentLocation->attributes['marker'])?
                            $this->slplus->currentLocation->attributes['marker']   :
                            '',
                        'iconfield',
                        true
                        ).
                 '<img id="location-marker" align="top" src="'.
                            (isset($this->slplus->currentLocation->attributes['marker'])?
                            $this->slplus->currentLocation->attributes['marker']   :
                            '')  .
                            '">' .
                 $this->slplus->AdminUI->CreateIconSelector('edit-attributes-'.$this->slplus->currentLocation->id.'[marker]','location-marker')
                 ;

            $theHTML .=
                '</div>'
                ;

            return $theHTML;
        }


        /**
         * Add map feature settings.
         *
         * @param string $html starting html for map feature settings
         * @return string modified HTML
         */
        function filter_MapFeatures_AddSettings($html) {
            return
                $html .
                $this->slplus->helper->create_SubheadingLabel(__('Enhanced Map','csa-slp-em')).
                $this->slplus->helper->CreateCheckboxDiv(
                        '-no_homeicon_at_start',
                        __('Hide Immediate Home Marker', 'csa-slp-em'),
                        __('Do not include the home map marker for the initial map loading with immediately show locations enabled.','csa-slp-em'),
                        null,
                        false,
                        $this->addon->options['no_homeicon_at_start']
                        ) .
                $this->slplus->helper->CreateCheckboxDiv(
                        '-enmap_hidemap',
                        __('Hide The Map', 'csa-slp-em'),
                        __('Do not show the map on the page.','csa-slp-em')
                        ) .
                $this->slplus->helper->CreateCheckboxDiv(
                        '-show_maptoggle',
                        __('Add Map Toggle On UI', 'csa-slp-em'),
                        __('Add a map on/off toggle to the user interface.','csa-slp-em')
                        ) .
                $this->slplus->AdminUI->MapSettings->CreateInputDiv(
                        '-maptoggle_label',
                        __('Toggle Label', 'csa-slp-em'),
                        __('The text that appears before the display map on/off toggle.','csa-slp-em'),
                        SLPLUS_PREFIX,
                        __('Map','csa-slp-em')
                    ).
                $this->slplus->helper->createstring_DropDownDiv(array(
                                                                'id'               => 'map_initial_display',
                                                                'name'             => 'map_initial_display',
                                                                'label'            => 'Starting Map Display',
                                                                'helptext'         => sprintf("%s<br/>%s<br/>%s<br/>%s"
                                                                                     ,__('Set what to display when the page loads, the options are:', 'csa-slp-em')
                                                                                     ,__('Show Map - Display a map.', 'csa-slp-em')
                                                                                     ,__('Hide Until Search - Display nothing.', 'csa-slp-em')
                                                                                     ,__('Image Until Search - Display the image set by Starting Image.','csa-slp-em')),            
                                                                'onchange'         => 'if(this.value != \'image\') {jQuery(\'[name=&quot;sl_starting_image&quot;]\').prop(\'disabled\', true);}'.
                                                                                      ' else {jQuery(\'[name=&quot;sl_starting_image&quot;]\').prop(\'disabled\', false);}',
                                                                'selectedVal'      => (empty($this->addon->options['map_initial_display'])?'':$this->addon->options['map_initial_display']),
                                                                'items'            => array(
                                                                    array( 'label' => __('Show Map', 'csa-slp-em'), 'value'           => 'map' ),
                                                                    array( 'label' => __('Hide Until Search', 'csa-slp-em'), 'value'  => 'hide'),
                                                                    array( 'label' => __('Image Until Search', 'csa-slp-em'), 'value' => 'image')
                                                                ))).
                $this->slplus->AdminUI->MapSettings->CreateInputDiv(
                    'sl_starting_image',
                    __('Starting Image','csa-slp-em'),
                    __('If set, this image will be displayed until a search is performed.  Enter the full URL for the image.','csa-slp-em'),
                    '', '', null, $this->addon->options['map_initial_display']=='image'
                    ) .
                $this->slplus->AdminUI->MapSettings->CreateTextAreaDiv(
                    'maplayout',
                    __('Map Layout','csa-slp-em'),
                    __('Enter your custom map area layout for the Store Locator Plus page. ','csa-slp-em') .
                        __('Must have the [slp_mapcontent] shortcode to where you want Google to put the map. ','csa-slp-em').
                        __('[slp_maptagline] puts the Store Locator Plus tagline in place. ','csa-slp-em').
                        __('Set it to blank to reset to the default layout.','csa-slp-em')
                    ,
                    null,
                    (empty($this->addon->options['maplayout'])?$this->slplus->defaults['maplayout']:$this->addon->options['maplayout']),
                    true
                    ) .
                $this->slplus->helper->CreateCheckboxDiv(
                        'hide_bubble',
                        __('Hide Info Bubble', 'csa-slp-em'),
                        __('Disable the on-map info bubble.','csa-slp-em'),
                        '',
                        false,
                        0,
                        $this->addon->options['hide_bubble']
                        ) .
                $this->slplus->AdminUI->MapSettings->CreateTextAreaDiv(
                    'bubblelayout',
                    __('Bubble Layout','csa-slp-em'),
                    __('Enter your custom info bubble layout. ','csa-slp-em') .
                        __('Set it to blank to reset to the default layout.','csa-slp-em')
                    ,
                    null,
                    (empty($this->addon->options['bubblelayout'])?$this->slplus->defaults['bubblelayout']:$this->addon->options['bubblelayout']),
                    true
                    )
                ;
        }

        /**
         * Extend the maps settings panel.
         *
         * @param string $html - original HTML string
         * @return string - augmented HTML string
         */
        function filter_MapSettings_AddSettings($html) {
            return $html .
                   $this->slplus->helper->create_SubheadingLabel(__('Enhanced Map','csa-slp-em')) .

                    $this->slplus->helper->CreateCheckboxDiv(
                        '-no_autozoom',
                        __('Do Not Auto-zoom', 'csa-slp-em'),
                        __('Use only the "zoom level" setting when rendering the initial map for immediately show locations. ','csa-slp-em') .
                        __('Do not automatically zoom the map to show all iniital locations.','csa-slp-em'),
                        null,
                        false,
                        $this->addon->options['no_autozoom']
                        ) .

                   $this->slplus->helper->CreateCheckboxDiv(
                       'sl_map_overview_control',
                       __('Show Map Inset Box','csa-slp-em'),
                       __('When checked the map inset is shown.', 'csa-slp-em'),
                       ''
                       ) .
                   $this->slplus->helper->CreateCheckboxDiv(
                       '_disable_scrollwheel',
                       __('Disable Scroll Wheel','csa-slp-em'),
                       __('Disable the scrollwheel zoom on the maps interface.', 'csa-slp-em')
                       ) .
                   $this->slplus->helper->CreateCheckboxDiv(
                       '_disable_largemapcontrol3d',
                       __('Hide map 3d control','csa-slp-em'),
                       __('Turn the large map 3D control off.', 'csa-slp-em')
                       ) .
                   $this->slplus->helper->CreateCheckboxDiv(
                       '_disable_scalecontrol',
                       __('Hide map scale','csa-slp-em'),
                       __('Turn the map scale off.', 'csa-slp-em')
                       ) .
                   $this->slplus->helper->CreateCheckboxDiv(
                       '_disable_maptypecontrol',
                       __('Hide map type','csa-slp-em'),
                       __('Turn the map type selector off.', 'csa-slp-em')
                       )
                   ;
        }


        /**
         * Augment the list of checkbox entries to save on the map settings page.
         *
         * @param type $theArray
         */
        function filter_SaveUXCheckboxes($theArray) {
            return array_merge(
                    $theArray,
                    array(
                       SLPLUS_PREFIX.'-enmap_hidemap'               ,
                       SLPLUS_PREFIX.'-show_maptoggle'              ,
                       'sl_map_overview_control'                    ,
                       SLPLUS_PREFIX.'_disable_scrollwheel'         ,
                       SLPLUS_PREFIX.'_disable_largemapcontrol3d'   ,
                       SLPLUS_PREFIX.'_disable_scalecontrol'        ,
                       SLPLUS_PREFIX.'_disable_maptypecontrol'      ,
                    )
                );
        }

        /**
         * Augment the list of inputs to save on the map settings page.
         *
         * @param type $theArray
         */
        function filter_SaveUXInputs($theArray) {

            // Force Prefixed checkboxes to blank
            //
            $BoxesToHit = array(
                'no_autozoom',
                'no_homeicon_at_start'
                );
            foreach ($BoxesToHit as $BoxName) {
                if (!isset($_REQUEST[SLPLUS_PREFIX.'-'.$BoxName])) {
                    $_REQUEST[SLPLUS_PREFIX.'-'.$BoxName] = '';
                }
            }

            // Force Non-Prefixed checkboxes to blank
            //
            $BoxesToHit = array(
                'hide_bubble',
                );
            foreach ($BoxesToHit as $BoxName) {
                if (!isset($_REQUEST[$BoxName])) {
                    $_REQUEST[$BoxName] = '';
                }
            }

            // Serialized Save (use this as often as possible, one data I/O = faster)
            //
            array_walk($_REQUEST,array($this,'set_ValidOptions'));
            update_option(SLPLUS_PREFIX.'-EM-options', $this->addon->options);

            // Input/text areas
            //
            return array_merge(
                    $theArray,
                    array(
                        SLPLUS_PREFIX.'-maptoggle_label'    ,
                        'sl_starting_image'                 ,
                    )
                    );
        }

        /**
         * Set valid options from the incoming REQUEST
         *
         * @param mixed $val - the value of a form var
         * @param string $key - the key for that form var
         */
        function set_ValidOptions($val,$key) {
            $simpleKey = str_replace($this->slplus->prefix.'-','',$key);
            if (array_key_exists($simpleKey, $this->addon->options)) {
                $this->addon->options[$simpleKey] = stripslashes_deep($val);
                $this->addon->debugMP('msg','',"set options[{$simpleKey}]=".stripslashes_deep($val),NULL,NULL,true);
            }
         }

   }
}
