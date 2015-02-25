<?php
if (! class_exists('SLPTagalong_Admin')) {

    /**
     * Holds the admin-only code.
     *
     * This allows the main plugin to only include this file in admin mode
     * via the admin_menu call.   Reduces the front-end footprint.
     *
     * @package StoreLocatorPlus\Tagalong\Admin
     * @author Lance Cleveland <lance@charlestonsw.com>
     * @copyright 2013 Charleston Software Associates, LLC
     */
    class SLPTagalong_Admin {

        //-------------------------------------
        // Properties
        //-------------------------------------

        /**
         * The activation handler.
         * 
         * @var \Tagalong_Activation $activation
         */
        private $activation;

        /**
         * This addon pack.
         *
         * @var \SLPTagalong $addon
         */
        private $addon;

        /**
         * The admin interface.
         *
         * @var \SLPTagalong_AdminPanel
         */
        private $AdminUI;

        /**
         * Store the category post data in here.
         *
         * @var mixed[]
         */
        private $categoryPostData;

        /**
         * The data helper object.
         *
         * @var \Tagalong_Data $data
         */
        private $data;

        /**
         * The new categories for a location being added.
         * @var mixed[] $new_categories
         */
        private $new_categories;

        /**
         * The Tagalong add-on pack.
         *
         * @var \SLPTagalong $parent
         */
        private $parent = null;

        /**
         * The tag list settings object.
         *
         * @var \wpCSL_settings__slplus $Settings
         */
        public $Settings;

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
         * @param SLPTagalong $parent
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

            $this->data     = $this->parent->data;

            // Check the version.
            //
            global $wpdb;
            if (
                (version_compare($this->addon->options['installed_version'], SLPTagalong::VERSION, '<')) ||
                ($wpdb->get_var("SHOW TABLES LIKE '{$this->data->plugintable['name']}'") != $this->data->plugintable['name'])
            ){
                if (class_exists('Tagalong_Activation') == false) {
                    require_once(plugin_dir_path(__FILE__).'class.activation.php');
                }
                $this->activation = new Tagalong_Activation(array('plugin'=>$this->parent));
                $this->activation->update();
                $this->addon->options['installed_version'] = SLPTagalong::VERSION;
                update_option(SLPLUS_PREFIX.'-TAGALONG-options',$this->addon->options);
            }

            // Register the admin stylesheet
            //
            wp_register_style(
                'slp_tagalong_style',
                $this->parent->url . '/admin.css'
                );

            // Admin skinning
            //
            add_filter('wpcsl_admin_slugs'          , array($this,'filter_AddOurAdminSlug'  ));

            // The Categories Interface (aka Taxonomy)
            // where we attach the icon/marker to a category
            //
            add_action('slp_manage_locations_action'    ,array($this,'categorize_locations'                             )           );
            add_action('stores_add_form_fields'         ,array($this,'filter_stores_add_form_fields'                    )           );
            add_action('stores_edit_form'               ,array($this,'filter_stores_edit_form'                          )           );
            
            // Location Added
            //
            add_action('slp_location_add'               ,array($this,'data_UpdateLocationCategoryandPageID'             )           );
            add_action('slp_location_added'             ,array($this,'data_AssignCategories'                            )           );
            add_action('slp_location_save'              ,array($this,'data_UpdateLocationCategoryandPageID'             )           );
            add_action('slp_location_saved'             ,array($this,'data_AssignCategories'                            )           );
            add_filter('slp_csv_locationdata'           ,array($this,'set_CategoryPostData_From_LocationData'           )           );

            // Location Deleted
            //
            add_action('slp_deletelocation_starting'    ,array($this,'action_DeleteLocationCategories'                  )           );

            // Manage Locations Interface
            //
            add_filter('slp_locations_manage_bulkactions'   ,array($this,'filter_AddManageLocationsBulkAction'              )           );
            add_filter('slp_manage_location_columns'        ,array($this,'filter_AddCategoriesHeaderToManageLocations'      )           );
            add_filter('slp_edit_location_right_column'     ,array($this,'filter_AddCategoriesToEditForm'                   ),20        );
            add_filter('slp_column_data'                    ,array($this,'filter_RenderCategoriesInManageLocationsTable'    ),90    ,3  );

        }

        /**
         * Delete current location categories from Tagalong categories table.
         */
        function action_DeleteLocationCategories() {
            $this->data->db->query(
                $this->data->db->prepare($this->data->get_SQL('delete_category_by_id'),$this->slplus->currentLocation->id)
             );
        }


        /**
         * Perform the manage locations action for bulk categorization.
         */
        function categorize_locations() {
            $this->addon->debugMP('msg','SLPTagalong_Admin::'.__FUNCTION__);
            if (!isset($_REQUEST['act'])            ) { return; }
            if (!isset($_REQUEST['sl_id'])          ) { return; }
            if ($_REQUEST['act'] !== 'categorize'   ) { return; }

            // Extract the categories
            //
            $inputCats = $this->get_CategoriesFromInput();
            if (count($inputCats)<=0                ) { return; }

            // Process the categories
            //
            $locationArray =
                is_array($_REQUEST['sl_id'])    ?
                    $_REQUEST['sl_id']          :
                    array($_REQUEST['sl_id'])
                ;
            foreach ($locationArray as $location) {

                // Set currentLocation
                //
                $this->slplus->currentLocation->set_PropertiesViaDB($location);

                // Assign categories
                //
                $this->data_UpdateLocationCategoryandPageID();

                // Save Them
                //
                $this->slplus->currentLocation->MakePersistent();
            }
        }

        //----------------------------------
        // Object Creation Methods
        //----------------------------------

        /**
         * Create an AdminUI object and attached to this->AdminUI
         *
         */
        function createobject_AdminUI() {
            if ( ! class_exists( 'SLPTagalong_AdminPanel' ) ) {
                require_once('class.adminpanel.php');
            }

            if ( ! isset( $this->AdminUI ) ) {
                $this->AdminUI = new SLPTagalong_AdminPanel(
                        array(
                            'parent'    => $this,
                            'slplus'    => $this->slplus,
                            'addon'     => $this->parent,
                        )
                );
            }
        }

        //----------------------------------
        // Data I/O Methods
        //----------------------------------

        /**
         * Assign categories to a given location via the data relation table.
         *
         * Does NOT update the currentLocation (wp_store_locator table) attributes.
         *
         * Assumes plugin currentLocation is accurate and uses $this->new_categories.
         */
        function data_AssignCategories() {
            $this->addon->debugMP('msg',__FUNCTION__,"location #{$this->slplus->currentLocation->id}");

            // Connect Data Object
            //
            if (!isset($this->data)) {
                $this->parent->createobject_Data();
                $this->data = $this->parent->data;
            }

            // Store Them In The Tagalong Table
            //
            foreach ($this->new_categories as $category) {
                $this->data->add_RecordIfNeeded($this->slplus->currentLocation->id,$category);
                $this->addon->debugMP('msg','',"assigned category ({$category})");
            }
        }

        /**
         * Attach our category data to the update string.
         *
         * Put it in the sl_option_value field as a seralized string.
         *
         * Assumes currentLocation is set.
         *
         * @return string the modified SQL set syntax
         */
        function data_UpdateLocationCategoryandPageID() {
            $this->addon->debugMP('msg','SLPTagalong_Admin::'.__FUNCTION__,
                    !ctype_digit($this->slplus->currentLocation->id)     ?
                        'new location'                                  :
                        "location #{$this->slplus->currentLocation->id}"
                    );

            // Set our filter to get the page data updated
            //
            add_filter('slp_location_page_attributes',array($this,'filter_SetTaxonomyForLocation'));

            // Create a related page if it does not exist.
            // Updates the current Location but does not make it persistent.
            // The calling actions slp_location_save and slp_location_added will do that.
            //
            $this->slplus->currentLocation->crupdate_Page(false);

            // Build an options array that has...
            // All original options +
            // The new store categories from POST['tax_input'] +
            // A linked post ID for the current SLP Page for the location
            //
            $newOptionArray =
                array(
                    'store_categories'  => $this->get_CategoriesFromInput(),
                );
            $this->new_categories = $newOptionArray['store_categories']['stores'];

            // Remove un-needed records
            //
            $inTerms = join(',',array_map(array($this,'do_AddSingleQuotes'),$this->new_categories));
            $this->data->db->query(
                $this->data->db->prepare($this->data->get_SQL('delete_category_by_id'),$this->slplus->currentLocation->id) .
                    (!empty($inTerms)?'AND TERM_ID NOT IN ('.$inTerms.')':'')
             );


            // Blank out the serialized store_categories
            //
            if ( ! empty ( $this->slplus->currentLocation->attributes['store_categories'] ) ) {
                if ( is_array( $this->slplus->currentLocation->attributes['store_categories'] ) ) {
                    unset($this->slplus->currentLocation->attributes['store_categories']);
                }
                $this->slplus->currentLocation->update_Attributes( array() );
            }

            // Update Tagalong Table
            //
            $this->data_AssignCategories();
        }

        /**
         * Add single quotes to a string.
         *
         * @param string $string
         * @return string
         */
        function do_AddSingleQuotes($string) {
            return "'$string'";
        }

        /**
         * Add the categories column header to the manage locations table.
         *
         * SLP Filter: slp_manage_location_columns
         *
         * @param mixed[] $currentCols column name + column label for existing items
         * @return mixed[] column name + column labels, extended with our categories data
         */
        function filter_AddCategoriesHeaderToManageLocations($currentCols) {
            return array_merge($currentCols,
                    array(
                        'sl_option_value'       => __('Categories'        ,'csa-slp-tagalong')
                    )
                );

        }

        /**
         * Add the category editor/selector on the manage/edit location form.
         *
         * SLP Filter: slp_edit_location_right_column
         *
         * @param string $theForm the original HTML form for the manage locations edit (right side)
         * @return string the modified HTML form
         */
        function filter_AddCategoriesToEditForm($theForm) {
            $this->addon->debugMP('msg',__FUNCTION__);
            $theForm .= '<div id="slp_tagalong_fields" class="slp_editform_section"><strong>Tagalong</strong>'.
                    '<p>Categories:</p>'.
                    '<ul>'.
                    $this->get_CheckList($this->slplus->currentLocation->linked_postid) .
                    '</ul></div>';
            return $theForm;
        }

        /**
         * Add more actions to the Bulk Action drop down on the admin Locations/Manage Locations interface.
         *
         * @param mixed[] $BulkActions
         */
        function filter_AddManageLocationsBulkAction($items) {
            return
                array_merge(
                    $items,
                    array(
                        array(
                            'label'     =>  __('Categorize','csa-slp-tagalong')  ,
                            'value'     => 'categorize'                     ,
                            'extras'    =>
                                '<script type="text/javascript">' .
                                    'var hiddenInputs=new Array();'.
                                    "jQuery(document).ready(function(){" .
                                        "jQuery('#slp_tagalong_fields input:checkbox').change(function(){" .
                                            'theCats="";' .
                                            'hiddenInputs=new Array();' .
                                            'jQuery("#slp_tagalong_fields li").' .
                                                'find("input[type=checkbox]:checked" ).' .
                                                    'each(function(idx) {' .
                                                        'theCats += jQuery(this).parent().text() + ", ";' .
                                                        'hiddenInputs.push("<input type=\'hidden\' name=\'tax_input[stores][]\' value=\'"+jQuery(this).val()+"\'/>");' .
                                                     '})' .
                                            ';' .
                                        "});" .
                                    "});" .
                                 '</script>' .
                            '<div id="extra_categorize" class="bulk_extras">'.
                                __('Select your categories: ','csa-slp-tagalong') .
                                '<div id="slp_tagalong_selector">' .
                                    '<div id="slp_tagalong_fields" class="slp_editform_section">'.
                                        '<ul>'.
                                            $this->get_CheckList(0) .
                                        '</ul>'.
                                    '</div>'.
                                '</div>' .
                            '</div>'
                        ),
                    )
                );
        }

        /**
         * Add our admin pages to the valid admin page slugs.
         *
         * @param string[] $slugs admin page slugs
         * @return string[] modified list of admin page slugs
         */
        function filter_AddOurAdminSlug($slugs) {
            return array_merge($slugs,
                    array(
                        'slp_tagalong',
                        'store-locator-plus_page_slp_tagalong',
                        'edit_tags-stores'
                        )
                    );
        }

        /**
         * Render the categories column in the manage locations table.
         *
         * SLP Filter: slp_column_data
         *
         * @param string $theData  - the option_value field data from the database
         * @param string $theField - the name of the field from the database (should be sl_option_value)
         * @param string $theLabel - the column label for this column (should be 'Categories')
         * @return type
         */
        function filter_RenderCategoriesInManageLocationsTable($theData,$theField,$theLabel) {
            if (
                ($theField === 'sl_option_value') &&
                ($theLabel === __('Categories'        ,'csa-slp-tagalong'))
               ) {
                $this->addon->debugMP('msg',__FUNCTION__);
                return $this->addon->createstring_IconArray( array( 'show_label' => true , 'add_edit_link' => true ) );
            } else {
                return $theData;
            }
        }

        /**
         * Set the Tagalong categories for the new store page.
         *
         * SLP Filter: slp_location_page_attributes
         *
         * @param mixed[] $pageAttributes - the wp_insert_post page attributes
         * @return mixed[] - pageAttributes with tax_input set
         */
        function filter_SetTaxonomyForLocation($pageAttributes) {
            $this->addon->debugMP('msg',__FUNCTION__);
            $newPageAtts = array_merge($pageAttributes,array('tax_input' => $this->get_CategoriesFromInput()));
            $this->addon->debugMP('pr','',$newPageAtts);
            return $newPageAtts;
        }

        /**
         * Render the extra tagalong category fields for the add form.
         */
        function filter_stores_add_form_fields() {
            $this->render_ExtraCategoryFields();
        }

        /**
         * Render the extra tagalong category fields for the edit form.
         */
        function filter_stores_edit_form($tag) {
            print '<div id="tagalong_editform" class="form-wrap">';
            $this->render_ExtraCategoryFields($tag->term_id,get_option(SLPLUS_PREFIX.'-TAGALONG-category_'.$tag->term_id));
            print '</div>';
        }

         /**
          * Get the right bulk Cats from the form input.
          *
          * @return mixed[]
          */
         function get_CategoriesFromInput() {
            $this->addon->debugMP('msg','SLPTagalong_Admin::'.__FUNCTION__);
            if (!isset($this->categoryPostData)) {
                $this->addon->debugMP('msg','','setup categoryPostData');
                $this->categoryPostData =
                    (isset($_REQUEST['tax_input']['stores']) && is_array($_REQUEST['tax_input']['stores'])) ?
                        $_REQUEST['tax_input']                                                              :
                        array('stores'=>array())                                                            ;
            }
            $this->addon->debugMP('pr','',$this->categoryPostData);
            return $this->categoryPostData;
         }

        /**
         * Generate the categories check list.
         *
         * @param int $postID the ID for the store page related to the location.
         * @return string HTML of the checklist.
         */
        function get_CheckList($postID) {
            ob_start();
            wp_terms_checklist(
                        $postID,
                        array(
                            'checked_ontop' => false,
                            'taxonomy' => 'stores',
                        )
                    );
            return ob_get_clean();
         }

        /**
         * Set the tagalong options from the incoming REQUEST
         *
         * @param mixed $val - the value of a form var
         * @param string $key - the key for that form var
         */
        function isTagalongOption($val,$key) {
            $simpleKey = preg_replace('/^'.SLPLUS_PREFIX.'-TAGALONG-/','',$key);
            if ($simpleKey !== $key){
                $this->addon->options[$simpleKey] = $val;
            }
         }

        //----------------------------------
        // Render Screen Methods
        //----------------------------------

        /**
         * Render the extended Tagalong fields on the WordPress add/edit category forms for store_page categories.
         *
         * @param int $term_id the category id.
         * @param mixed[] $TagalongData tagalong data for this category.
         */
        function render_ExtraCategoryFields($term_id = null ,$TagalongData=null) {
            print '<div id="tagalong_extended_data">';
            print '<h3>Tagalong' . __(' Extended Data','csa-slp-tagalong'). '</h3>';

            // Medium Icon
            //
            print
                  '<div class="form-field">' .
                       '<label for="medium-icon">Medium Icon</label>' .
                       '<input type="text" id="medium-icon" name="medium-icon" value="'.$TagalongData['medium-icon'].'">'.
                       '<p>'.__('This graphic appears as the icon or icon array in the result listing or map info bubble.','csa-slp-tagalong').'</p>' .
                       '<p><img id="medium-icon-image" align="top" src=""></p>'.
                       $this->addon->show_Image($TagalongData['medium-icon']).
                  '</div>'
                  ;
            print $this->slplus->AdminUI->CreateIconSelector('medium-icon','medium-icon-image');

            // Map Marker
            //
            print
                  '<div class="form-field">' .
                       '<label for="map-marker">Map Marker</label>' .
                       '<input type="text" id="map-marker" name="map-marker" value="'.$TagalongData['map-marker'].'">'.
                       '<p>'.__('This is the graphic used as the map marker on the map.','csa-slp-tagalong').'</p>' .
                       '<p><img id="map-marker-image" align="top" src=""></p>'.
                       $this->addon->show_Image($TagalongData['map-marker']).
                  '</div>'
                  ;
            print $this->slplus->AdminUI->CreateIconSelector('map-marker','map-marker-image');
            print '</div>';
        }

        /**
         * Render the Tag List page.
         */
        function render_TagListPage() {

            $this->Settings = new wpCSL_settings__slplus(
                array(
                        'prefix'            => $this->slplus->prefix,
                        'css_prefix'        => $this->slplus->prefix,
                        'url'               => $this->slplus->url,
                        'name'              => $this->slplus->name . __(' - Tagalong','csa-slp-tagalong'),
                        'plugin_url'        => $this->slplus->plugin_url,
                        'render_csl_blocks' => true,
                        'form_action'       => admin_url().'admin.php?page=slp_tagalong',
                        'form_name'         => 'tagalong_settings',
                        'form_enctype'      => 'multipart/form-data',
                    )
             );

            // Attach Admin Interface
            //
            $this->createobject_AdminUI();

            // If we are updating settings...
            //
            if (isset($_REQUEST['action'])) {
                $this->updateTagalongSettings();
            }

            $this->AdminUI->renderPage();
        }

        /**
         * Save our settings.
         * @return type
         */
        function save_Settings() {
            $BoxesToHit = array(
                'ajax_orderby_catcount' ,
                'default_icons'         ,
                'hide_empty'            ,
                'label_category'        ,
                'show_cats_on_search'   ,
                'show_icon_array'       ,
                'show_legend_text'      ,
                );
            foreach ($BoxesToHit as $BoxName) {
                if (!isset($_REQUEST[SLPLUS_PREFIX.'-TAGALONG-'.$BoxName])) {
                    $_REQUEST[SLPLUS_PREFIX.'-TAGALONG-'.$BoxName] = '';
                }
            }

            // Check options, then save them all in one place (serialized)
            //
            array_walk($_REQUEST,array($this,'isTagalongOption'));
            update_option(SLPLUS_PREFIX.'-TAGALONG-options', $this->addon->options);

            $this->slplus->notifications->add_notice(
                    9,
                    __('Tagalong settings saved.','csa-slp-tagalong')
                    );
            return;
        }

        /**
         * Update the Tagalong settings.
         */
        function updateTagalongSettings() {
            $this->addon->debugMP('msg',__FUNCTION__);
            if (!isset($_REQUEST['page']) || ($_REQUEST['page']!='slp_tagalong')) { return; }
            if (!isset($_REQUEST['_wpnonce'])) { return; }
            switch ($_REQUEST['action']) {
                case 'import':
                    $this->AdminUI->process_CSVCategoryFile();
                    break;
                case 'update':
                    $this->save_Settings();
                    break;
                default:
                    break;
            }
        }


        /**
         * Additional processing of CSV records during an import.
         *
         * @param string[] $locationData
         * @param string $addStatus
         */
        function set_CategoryPostData_From_LocationData($locationData) {
            $this->addon->debugMP('msg','SLPTagalong_Admin::'.__FUNCTION__);

            // No category set, make it blank
            //
            if (!isset($locationData['sl_category']         )) {
                $this->addon->debugMP('pr','',$locationData);
                $this->categoryPostData = array('stores'=>array());
                return $locationData;
            }
            $locationData['sl_category'] = trim($locationData['sl_category']);
            if (empty($locationData['sl_category']          )) {
                $this->categoryPostData = array('stores'=>array());
                return $locationData;
            }

            // Setup Category Import Object
            //
            $this->createobject_AdminUI();
            $this->AdminUI->create_CSVCategoryImporter();

            // Build the category list
            //
            $categoryList=array();
            $locationData['sl_category']= wp_kses_decode_entities(trim($locationData['sl_category']));
            $categories = explode(',',$locationData['sl_category']);

            $this->addon->debugMP('pr','',$categories);

            // If category could be located, attach it to the location.
            //
            foreach ($categories as $categoryName) {

                // Create category if necessary
                //
                $this->AdminUI->csvImporter->create_StoreCategory(array('category'=>$categoryName));

                // Manage colon separated category names,
                // assume they are in category import parent::child::grandchild::n-child format
                //
                $colon_separated_categories = explode('::',$categoryName);

                // Process each of the separated colon category names
                //
                foreach ($colon_separated_categories as $individual_category_name) {
                    $category = get_term_by('slug',sanitize_title($individual_category_name),SLPlus::locationTaxonomy);
                    if (is_object($category) && $category->term_id) {
                        $categoryList[] = $category->term_id;
                    }
                }
            }
            $this->categoryPostData = array('stores'=>$categoryList);
            return $locationData;
        }
   }
}