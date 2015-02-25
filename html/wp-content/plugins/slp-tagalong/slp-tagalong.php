<?php
/**
 * Plugin Name: Store Locator Plus : Tagalong
 * Plugin URI: http://www.storelocatorplus.com/product/slp4-tagalong/
 * Description: A premium add-on pack for Store Locator Plus that adds advanced location tagging features.
 * Version: 4.1.06
 * Author: Charleston Software Associates
 * Author URI: http://charlestonsw.com/
 * Requires at least: 3.4
 * Test up to : 3.9.1
 *
 * Text Domain: csa-slp-tagalong
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
if (!class_exists('SLPTagalong'   )) {

    /**
     * The Tagalong Add-On Pack for Store Locator Plus.
     *
     * @package StoreLocatorPlus\Tagalong
     * @author Lance Cleveland <lance@charlestonsw.com>
     * @copyright 2012-2014 Charleston Software Associates, LLC
     */
    class SLPTagalong {
        //-------------------------------------
        // Constants
        //-------------------------------------

        /**
         * @const string VERSION the current plugin version.
         */
        const VERSION           = '4.1.06';

        /**
         * @const string MIN_SLP_VERSION the minimum SLP version required for this version of the plugin.
         */
        const MIN_SLP_VERSION   = '4.1.08';

        //-------------------------------------
        // Properties (all add-ons)
        //-------------------------------------

        /**
         * The array of current location category IDs.
         * 
         * @var int[] $current_location_categories
         */
        private $current_location_categories = array();

        /**
         * The detailed category term data from the WP taxonomy with custom Tagalong data as well.
         *
         * @var mixed[] $category_details
         */
        private $category_details = array();

        /**
         * The directory we live in.
         *
         * @var string $dir
         */
        private $dir;

        /**
         * WordPress data about this plugin.
         *
         * Needed by wpCSL, so don't remove this property.
         *
         * @var mixed[] $metadata
         */
        public $metadata;


        /**
         * Which level of the nested drop down tree are we processing?
         *
         * @var int
         */
        private $node_level = 0;

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
        private $name;

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
         * @var mixed[] $options
         */
        public  $options                = array(
            'ajax_orderby_catcount' => '0'          ,
            'default_icons'         => '0'          ,
            'hide_empty'            => '0'          ,
            'installed_version'     => ''           ,
            'label_category'        => 'Category: ' ,
            'show_icon_array'       => '0'          ,
            'show_legend_text'      => '0'          ,
            'show_option_all'       => 'Any'        ,
            'show_cats_on_search'   => ''           ,
            );

        //-------------------------------------
        // Properties (this add-on)
        //-------------------------------------

        /**
         * Which location ID is the current_location_categories loaded with?
         *
         * @var int $categories_loaded_for
         */
        private $categories_loaded_for = null;

        /**
         * The category drop downs.
         * 
         * @var mixed[] $categoryDropDowns
         */
        private $categoryDropDowns = array();

        /**
         * The data helper object.
         *
         * @var \Tagalong_Data $data
         */
        public $data;
        
        /**
         * True if debug bar is active.
         * 
         * @var boolean 
         */
        private $debugbar_enabled = false;

        /**
         * String to put a debug message in the AJAX mapdata responses.
         *
         * @var string $debugging
         */
        private $debugging = '';

        /**
         * Connect the legend walker object here.
         *
         * @var \Tagalong_CategoryWalker_Legend $LegendWalker
         */
        public $LegendWalker;

        /**
         * True of the Store Pages add-on pack is active.
         *
         * @var boolean $StorePagesActive
         */
        public $StorePagesActive       = false;

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
                load_plugin_textdomain( 'csa-slp-tagalong', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
                $instance = new SLPTagalong;
            }
            return $instance;
        }

        /**
         * Constructor.
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
        function SLPTagalong() {
            $this->url          = plugins_url('',__FILE__);
            $this->dir          = plugin_dir_path(__FILE__);
            $this->slug         = plugin_basename(__FILE__);
            $this->name         = __('Tagalong','csa-slp-tagalong');

            $this->plugin_path  = dirname( __FILE__ );
            $this->plugin_url   = plugins_url('',__FILE__);

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
            $this->debugbar_enabled  = isset( $GLOBALS['DebugMyPlugin'] );

            // Check the base plugin minimum version requirement.
            //
            $this->slplus->VersionCheck(array(
                'addon_name'            => $this->name,
                'addon_slug'            => $this->slug,
                'min_required_version'  => SLPTagalong::MIN_SLP_VERSION
            ));
            
            // Tell SLP we are here
            //
             $this->slplus->register_addon($this->slug,$this);

            // Set Properties
            //
            $this->StorePagesActive = ( function_exists('is_plugin_active') &&  is_plugin_active( 'slp-pages/slp-pages.php'));

            // General Init
            //
            $this->initOptions();

            // AJAX and other ubiquitous stuff
            // Save category data for stores taxonomy type
            //
            add_filter( 'slp_location_filters_for_AJAX' , array($this,'filter_JSONP_SearchByCategory')       );
            add_filter( 'slp_ajaxsql_orderby'           , array($this,'filter_AJAX_ModifyOrderBy'    ),99    );
            add_filter( 'slp_extend_get_SQL'            , array($this,'filter_AddTagalongSQL'        )       );

            // AJAX Called from WordPress action stack on taxonomy system.
            // ./wp-includes/taxonomy.php
            //
            //  do_action("edited_$taxonomy", $term_id, $tt_id);
            //  do_action("create_$taxonomy", $term_id, $tt_id);
            //
            add_action('edited_stores'                  ,array($this,'create_or_edited_stores'                          ),10 ,2     );
            add_action('create_stores'                  ,array($this,'create_or_edited_stores'                          ),10 ,2     );


            // Locator Pages and Store Pages Processing
            add_filter   ('slp_results_marker_data'     ,array($this,'filter_SetMapMarkers'          )       );
            add_filter   ('slp_layout'                  ,array($this,'filter_AddLegend'              ),95    );
            add_filter   ('slp_shortcode_atts'          ,array($this,'filter_SetAllowedShortcodes'   )       );
            add_filter   ('shortcode_slp_searchelement' ,array($this,'filter_ProcessSearchElement'   )       );
            add_filter   ('shortcode_storepage'         ,array($this,'filter_ProcessStorePage'       )       );
            add_filter   ('slp_searchlayout'            ,array($this,'filter_ModifySearchLayout'     ),999   );
            add_shortcode('tagalong'                    ,array($this,'process_TagalongShortcode'     )       );
        }

        /**
         * Initialize the options properties from the WordPress database.
         */
        function initOptions($force=false) {
            if (!$force && $this->optionsSet) { return; }
            $this->debugMP('msg',__FUNCTION__ . ' for ' . $this->name . ' ' . SLPTagalong::VERSION);
            $dbOptions = get_option(SLPLUS_PREFIX.'-TAGALONG-options');
            if (is_array($dbOptions)) {
                $this->options = array_merge($this->options,$dbOptions);

                // Do allow hide empty if Store Pages is not active.
                //
                if (!$this->StorePagesActive) {
                    $this->options['hide_empty'] = '0';
                }
            }
            $this->optionsSet = true;
        }

        //====================================================
        // WordPress Admin Actions
        //====================================================

        /**
         * Get our hooks & filters tied in to SLP.
         *
         * WordPress update checker and all admin-only things go in here.
         *
         * SLP Action: slp_admin_menu_starting
         *
         * @return null
         */
        function admin_init(){
            $this->debugMP('msg',__FUNCTION__);

            // Attach a data object.
            //
            $this->createobject_Data();
            
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
        }

        /**
         * Run when on admin page.
         *
         * Should only load CSS and JS and setup the admin_init hook.
         *
         * This ensures SLP is prepped for admin but waits until WOrddPress
         * is further along before firing off related admin functions.
         *
         * SLP Action: slp_init_complete sets up...
         *     WP Action: admin_menu
         */
        function admin_menu(){
            $this->debugMP('msg',__FUNCTION__);

            // Admin Styles
            //
            add_action(
                    'admin_print_styles-'.SLP_ADMIN_PAGEPRE.'slp_tagalong',
                    array($this,'enqueue_tagalong_admin_stylesheet')
                    );
            add_action(
                    'admin_print_styles-'.SLP_ADMIN_PAGEPRE.'slp_manage_locations',
                    array($this,'enqueue_tagalong_admin_stylesheet')
                    );
            add_action(
                   'admin_print_styles-'.SLP_ADMIN_PAGEPRE.'slp_add_locations',
                    array($this,'enqueue_tagalong_admin_stylesheet')
                    );

            if (isset($_REQUEST['taxonomy']) && ($_REQUEST['taxonomy']==='stores')) {
                 add_action(
                         'admin_print_styles-' . 'edit-tags.php',
                         array($this,'enqueue_tagalong_admin_stylesheet')
                         );
            }

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
            return array_merge(
                        $menuItems,
                        array(
                            array(
                            'label' => __('Tagalong','csa-slp-tagalong'),
                            'slug'              => 'slp_tagalong',
                            'class'             => $this,
                            'function'          => 'renderPage_TagList'
                            )
                        )
                    );
        }

        /**
         * Enqueue the tagalong style sheet when needed.
         */
        function enqueue_tagalong_admin_stylesheet() {
            wp_enqueue_style('slp_tagalong_style');
            wp_enqueue_style($this->slplus->AdminUI->styleHandle);
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
            return (isset($this->slplus) && ($this->slplus != null));
        }

        /**
         * Simplify the plugin debugMP interface.
         *
         * @param string $type
         * @param string $hdr
         * @param string $msg
         */
        function debugMP($type,$hdr,$msg='') {
            if (($type === 'msg') && ($msg!=='')) {
                $msg = esc_html($msg);
            }
            $this->slplus->debugMP('slp.tag',$type,$hdr,$msg,NULL,NULL,true);
        }

        /**
         * Set the allowed shortcode attributes
         *
         * @param mixed[] $atts
         */
        function filter_SetAllowedShortcodes($atts) {
            return array_merge(
                    array(
                        'only_with_category'     => null,
                        ),
                    $atts
                );
        }

        /**
         * Set custom map marker for this location.
         *
         * Add the icon marker and filters out any results that don't match the selected category.
         *
         * SLP Filter: slp_results_marker_data
         *
         * @param type $mapData
         */
        function filter_SetMapMarkers($mapData) {
            if (!ctype_digit($mapData['id'])) { return $mapData; }
            $this->set_LocationCategories();

            // If we are looking for a specific category,
            // check to see if it is assigned to this location
            // Category searched for not in array, Skip this one.
            //
            //
            $filterOut = isset($_POST['formflds']) && isset($_POST['formflds']['cat']) && ($_POST['formflds']['cat'] > 0);
            if ($filterOut) {
                $selectedCat = (int)$_POST['formflds']['cat'];
                if ( ! in_array ( $selectedCat , $this->current_location_categories ) ) { return array(); }
            }

            // Set the location marker.
            //
            $locationMarker = '';
            if (
                ( ! $this->slplus->is_CheckTrue( $this->options['default_icons'] ) )         &&
                ( count( $this->current_location_categories ) > 0 ) 
               ) {
                    $category_details = $this->get_TermWithTagalongData( $this->current_location_categories[0] );
                    $locationMarker =
                            isset($category_details['map-marker'])     ?
                                $category_details['map-marker']        :
                                ''                                     ;
                    
            // Enhanced Map Marker or Default Marker
            //
            } else {
                $locationMarker = ( isset( $mapData['attributes']['marker'] ) ? $mapData['attributes']['marker'] : '' );
            }

            // Debugging.. this can go away at some point.
            //
            if ( $this->debugbar_enabled ) {
                $this->debugging .= "Tagalong sets icon to '$locationMarker'";
            }

            // Return our modified array
            //
            return array_merge(
                        $mapData,
                        array(
                            'attributes'    => $this->slplus->currentLocation->attributes   ,
                            'categories'    => $this->current_location_categories           ,
                            'icon'          => $locationMarker                              ,
                            'iconarray'     => $this->createstring_IconArray()              ,
                            'debugging'     => $this->debugging                             ,
                        )
                    );
        }

        //====================================================
        // Helpers - Admin UI
        //====================================================


        /**
         * Return the div string to render an image.
         *
         * @param string $img - fully qualified image url
         * @return string - the div text string with the image in it
         */
        function show_Image($img = null) {
            if ($img === null) { return; }
            if ($img === '')   { return; }
            return '<div class="slp_tagalog_category_image">' .
                       '<img src="'.$img.'"/>' .
                  '</div>'
                  ;
        }

        //----------------------------------
        // Create Methods
        //----------------------------------


        /**
         * Setup the legend category walker object.
         */
        function create_CategoryWalkerForLegend() {
            if (class_exists('Tagalong_CategoryWalker_Legend') == false) {
                require_once(plugin_dir_path(__FILE__).'include/class.categorywalker.legend.php');
            }
            if (!isset($this->LegendWalker)) {
                $this->LegendWalker = new Tagalong_CategoryWalker_Legend(array('addon'=>$this,'slplus'=>$this->slplus));
            }
        }

        /**
         * Setup the data helper.
         */
        function createobject_Data() {
            if (class_exists('Tagalong_Data') == false) {
                require_once(plugin_dir_path(__FILE__).'include/class.data.php');
            }
            if (!isset($this->data)) {
                $this->data = new Tagalong_Data(array('plugin'=>$this));
            }
        }

        /**
         * Create a drop down object for all items with a parent category as specified.
         *
         * Recursive, calls the same method for each child.
         *
         * @param string $parent_cat the parent category (int)
         * @param mixed $grandparent_cat the grandparent category (int) or null
         * @return mixed
         */
        function create_DropDownForCat($parent_cat,$grandparent_cat=null) {
            if (!ctype_digit($parent_cat)) { return array(); }
            $categories = get_categories(
                    array(
                        'hierarchical'      => false,
                        'hide_empty'        => false,
                        'orderby'           => 'name',
                        'parent'            => $parent_cat,
                        'taxonomy'          => SLPLUS::locationTaxonomy
                    )
                );
            if (count($categories)<=0) { return array(); }
            $dropdownItems = array();
            $dropdownItems[] =
                array(
                    'label' => $this->options['show_option_all'],
                    'value' => ''
                );
            foreach ($categories as $category) {
                $dropdownItems[] =
                    array(
                        'label' => $category->name,
                        'value' => $category->term_id
                    );
                $this->create_DropDownForCat($category->term_id,$parent_cat);
            }
            $this->categoryDropDowns[] = array(
                'grandparent' => $grandparent_cat,
                'parent'    => $parent_cat,
                'id'        => 'catsel_'.$parent_cat,
                'name'      => 'catsel_'.$parent_cat,
                'items'     => $dropdownItems,
                'onchange'  =>
                    "jQuery('#children_of_{$parent_cat}').children('div.category_selector.child').hide();" .
                    "childDD='#children_of_'+jQuery('option:selected',this).val();" .
                    "jQuery(childDD).show();" .
                    "jQuery(childDD+' option:selected').prop('selected',false);" .
                    "jQuery(childDD+' option:first').prop('selected','selected');" .
                    "if (jQuery('option:selected',this).val()!=''){jQuery('#cat').val(jQuery('option:selected',this).val());}" .
                    "else{jQuery('#cat').val(jQuery('#catsel_{$grandparent_cat} option:selected').val());}"
            );
        }

        /**
         * Create a category icon array.
         *
         * **$params values**
         * - **show_label** if true put text under the icons (default: false)
         * - **add_edit_link** if true wrap the output in a link to the category edit page (default: false)
         *
         * **Example**
         * /---code php
         * $this->create_LocationIcons($category_list, array('show_label'=>false, 'add_edit_link'=>false));
         * \---
         *
         * @param mixed[] $categories array of category details
         * @param mixed[] $params the parameters
         * @return string html of the icon array
         */
        function create_LocationIcons($categories,$params = array()) {
            $this->debugMP('msg',__FUNCTION__,'Parameters: ' . print_r($params,true));

            // Make sure all params have defaults
            //
            $params =
                array_merge(
                    array(
                        'show_label'    => false,
                        'add_edit_link' => false,
                    ),
                    $params
                );

            // Now build the image tags for each category
            //
            $locationIcons = '';
            ksort($categories);
            $this->debugMP('pr','',$categories);
            foreach ($categories as $category) {
                $locationIcons .= $this->createstring_CategoryIconHTML($category,$params);
            }

            return $locationIcons;
        }

        /**
         * Create and attach the admin processing object.
         */
        function createobject_Admin() {
            if (!isset($this->Admin)) {
                require_once($this->dir.'include/class.admin.php');
                $this->Admin =
                    new SLPTagalong_Admin(
                        array(
                            'parent'    => $this,
                            'slplus'    => $this->slplus,
                            'addon'     => $this,
                        )
                    );
            }
        }

        /**
         * Called after a store category is inserted or updated in the database.
         *
         * Creates an entry in the wp_options table with an option name
         * based on the category ID and a tagalong prefix like this:
         *
         * csl-slplus-TAGALONG-category_14
         *
         * The data is serialized.  WordPress update_option() and get_option
         * will take care of serializing and deserializing our data.
         *
         * @param int $term_id - the newly inserted category ID
         */
        function create_or_edited_stores($term_id,$ttid) {
            if ( isset( $_POST['medium-icon'] ) && isset( $_POST['map-marker']  )) {
                $medium_icon = isset( $_POST['medium-icon'] ) ? $_POST['medium-icon'] : '';
                $map_marker  = isset( $_POST['map-marker']  ) ? $_POST['map-marker' ] : '';
                $TagalongData = array(
                    'medium-icon' => $medium_icon,
                    'map-marker'  => $map_marker
                );
                update_option(SLPLUS_PREFIX.'-TAGALONG-category_'.$term_id, $TagalongData);
            }
        }

        //----------------------------------
        // Create String Methods
        //----------------------------------

        /**
         * Create a cascading drop down array for location categories.
         *
         */
        function createstring_CascadingCategoryDropDown() {
            $this->debugMP('msg',__FUNCTION__);


            // Build the category drop down object array, recursive.
            //
            $this->create_DropDownForCat('0');
            $HTML = '<input type="hidden" id="cat" name="cat" value=""/>';

            // Create the drop down HTML for each level
            //
            if (count($this->categoryDropDowns) > 0) {
                $this->categoryDropDowns = array_reverse($this->categoryDropDowns);
                $nested_html = $this->createstring_NestedDropDownDivs($this->categoryDropDowns[0]['parent']);
            } else {
                $nested_html = '';
            }

            return
                $HTML .
                '<div id="tagalong_cascade_dropdowns">' .
                $nested_html .
                '</div>'
                ;
        }

        /**
         * Create a link to the category editor if warranted.
         *
         * @param int $category_id the category ID
         * @param string $html the HTML output to be wrapped
         * @return string the HTML wrapped in a link to the category editor.
         */
        function createstring_CategoryEditLink($category_id, $html) {
            return
                sprintf(
                    "<a href='%s' title='edit category' alt='edit category'>%s</a>",
                    get_edit_tag_link( $category_id , SLPLUS::locationTaxonomy ),
                    $html
                );
        }

        /**
         * Create the category HTML output for admin and user interface with images and text.
         *
         * **$params values**
         * - **show_label** if true put text under the icons (default: false)
         * - **add_edit_link** if true wrap the output in a link to the category edit page (default: false)
         *
         * **Example**
         * /---code php
         * $this->createstring_CategoryIconHTML($category, array('show_label'=>false, 'add_edit_link'=>false));
         * \---
         *         
         * @param mixed[] $category a taxonomy array
         * @param mixed[] $params the parameters we accept
         * @return string HTML for the category output on UI and admin panels
         */
        function createstring_CategoryIconHTML($category,$params) {
            $this->debugMP('msg',__FUNCTION__,'parameters: '.print_r($params,true));
            $this->debugMP('pr','',$category);

            // Image URL
            //
            $HTML = $this->createstring_CategoryImageHTML($category);

            // Add label?
            //
            if ( $params['show_label'] ) {
                $HTML .= $this->createstring_CategoryLegendText($category);
            }

            // Category Edit Link
            //
            if ( $params['add_edit_link'] ) {
                $HTML =
                    $this->createstring_CategoryEditLink(
                        $category['term_id'],
                        $HTML
                    );
            }

            return $HTML;
        }

        /**
         * Create the image string HTML
         * 
         * @param mixed[] $category a taxonomy array
         * @return string HTML for presenting an image
         */
        function createstring_CategoryImageHTML($category) {
            if ( empty( $category['medium-icon'] ) ) { return ''; }
            return
                sprintf(
                    '<img src="%s" alt="%s" title="%s" width="32" height="32">',
                    $category['medium-icon'],
                    $category['name'],
                    $category['name']
                );
        }

        /**
         * Create the category title span HTML
         * 
         * @param mixed[] $category a taxonomy array
         * @return string HTML for putting category title in a span
         */
        function createstring_CategoryLegendText($category) {
            return
                sprintf(
                    '<span class="legend_text">%s</span>',
                    $category['name']
                );
        }

        /**
         * Create nested divs with the drop down menus within.
         * 
         * @param string $parent_category_id (int)
         * @return string
         */
        function createstring_NestedDropDownDivs($parent_category_id) {
            $this->node_level++;
            $HTML = '';
            foreach ($this->categoryDropDowns as $dropdown) {
                if ($dropdown['parent']===$parent_category_id) {
                    $HTML .= 
                        "<div id='div_{$dropdown['id']}' name='div_{$dropdown['id']}' class='category_selector parent' >" .
                        $this->slplus->helper->createstring_DropDownMenu(
                            array(
                                'id'        => $dropdown['id'],
                                'name'      => $dropdown['name'],
                                'onchange'  => $dropdown['onchange'],
                                'items'     => $dropdown['items']
                            )
                         ) .
                         '</div>'
                         ;
                    foreach ($dropdown['items'] as $item) {
                        $HTML .= $this->createstring_NestedDropDownDivs($item['value']);
                    }
                }
            }

            if (!empty($HTML)) {
                $parent_or_child = (($this->node_level === 1) ? 'parent':'child');
                $HTML =
                    "<div id='children_of_{$parent_category_id}' class='category_selector {$parent_or_child} level_{$this->node_level}'>" .
                    $HTML .
                    '</div>';
            }

            $this->node_level--;
            return $HTML;
        }

        /**
         * Add our custom category selection div to the search form.
         *
         * @return string the HTML for this div appended to the other HTML
         */
        function createstring_CategorySelector() {
            $this->debugMP('msg',__FUNCTION__);

            if (!$this->setPlugin()) { return; }

            // Only With Category shortcode.
            //
            if ( ! empty( $this->slplus->data['only_with_category'] ) ) {
                $category_list = array();
                $category_slugs = preg_split( '/,/' , $this->slplus->data['only_with_category'] );
                foreach ( $category_slugs as $slug ) {
                    $category = get_term_by('slug',sanitize_title( $slug ),SLPlus::locationTaxonomy);
                    if ( $category ) { $category_list[] = $category->term_id; }
                }
                $category_id_list = join( ',' , $category_list );
                $this->options['show_cats_on_search'] = 'only_with_category';
            } else {
                $category_id_list = '';
            }

            // Process the category selector type
            //
            switch ($this->options['show_cats_on_search']) {

                case 'only_with_category':
                    if ( ! empty( $category_id_list ) ) {
                        $HTML =
                            "<input type='hidden' name='cat' id='cat' ".
                                "value='{$category_id_list}' " .
                                "textvalue='{$this->slplus->data['only_with_category']}' " .
                                '/>';
                    } else { 
                        $HTML = "<!-- only_with_category term {$this->slplus->data['only_with_category']}  does not exist -->";
                    }
                    break;

                // Single Style Menu
                //
                case 'single':
                    $HTML =
                        '<div id="tagalong_category_selector" class="search_item">' .
                            '<label for="cat">'.
                                $this->slplus->WPML->getWPMLText(
                                    'TAGALONG-label_category'           ,
                                    $this->options['label_category']    ,
                                    'csa-slp-tagalong'
                                ) .
                            '</label>'.
                            wp_dropdown_categories(
                                    array(
                                        'echo'              => 0,
                                        'hierarchical'      => 1,
                                        'depth'             => 99,
                                        'hide_empty'        => ( $this->slplus->is_CheckTrue( $this->options['hide_empty'] ) ? 1 : 0 ),
                                        'orderby'           => 'NAME',
                                        'show_option_all'   =>
                                            $this->slplus->WPML->getWPMLText(
                                                'TAGALONG-show_option_all'          ,
                                                $this->options['show_option_all']   ,
                                                'csa-slp-tagalong'
                                            ),
                                        'taxonomy'          => SLPLUS::locationTaxonomy
                                    )
                                    ).
                        '</div>'
                        ;
                    break;

                // Cascading Style Menu
                //
                case 'cascade':
                    $HTML =
                        '<div id="tagalong_category_selector" class="search_item">' .
                            '<label for="cat">'.
                                $this->slplus->WPML->getWPMLText(
                                    'TAGALONG-label_category'           ,
                                    $this->options['label_category']    ,
                                    'csa-slp-tagalong'
                                )     .
                            '</label>'.
                            $this->createstring_CascadingCategoryDropDown().
                        '</div>'
                        ;
                    break;

                default:
                    $HTML = '';
                    break;
            }

            return $HTML;
        }

        /**
         * Create the icon array for a given location.
         *
         * $params array values:
         *  'show_label' = if true show the labels under the icon strings
         *
         * @param mixed $params named array of settings
         */
        function createstring_IconArray($params=array()) {
            $this->debugMP('msg',__FUNCTION__,'Parameters: ' . print_r($params,true));

            // Set parameter defaults
            //
            $params =
                array_merge(
                    array(
                        'show_label' => false,
                    ),
                    $params
                );

            // Setup the location categories from the helper table
            //
            $this->set_LocationCategories( $this->current_location_categories );

            // If there are categories assigned to this location...
            //
            if ( count( $this->current_location_categories ) > 0 ) {
                foreach ( $this->current_location_categories as $category_id ) {
                    $category_details = $this->get_TermWithTagalongData( $category_id );
                    $assigned_categories[$category_details['slug']] = $category_details;
                }

                $icon_string = $this->create_LocationIcons($assigned_categories, $params);

            // Make the icon string blank if there are no categories.
            //
            } else {
                $icon_string = '';
            }

            // Return the icon string
            //
            return $icon_string;

        }

        /**
         * Create the LegendHTML String.
         *
         * @return string
         */
        function createstring_LegendHTML() {
            $this->debugMP('msg',__FUNCTION__);
            $this->create_CategoryWalkerForLegend();
            $this->debugMP('msg','','SLT: '.$this->options['show_legend_text'].' means ' . (!empty($this->options['show_legend_text'])?'show':'dont show'));

            $HTML =
                '<div id="tagalong_legend">'                        .
                    '<div id="tagalong_list">'                      .
                wp_list_categories(
                            array(
                                'echo'              => 0,
                                'hierarchical'      => 0,
                                'depth'             => 99,
                                'hide_empty'        => ( $this->slplus->is_CheckTrue( $this->options['hide_empty'] ) ? 1 : 0 ),
                                'style'             => 'none',
                                'taxonomy'          => 'stores',
                                'walker'            => $this->LegendWalker
                            )
                        ) .
                    '</div>'.
                '</div>'
                ;
            return $HTML;
        }

        /**
         * Fill the current_location_categories array with the category IDs assigned to the current location.
         *
         * Assumes slplus->currentLocation is loaded with the current location data.
         */
        function set_LocationCategories() {
            $this->debugMP('msg',__FUNCTION__, " location # {$this->slplus->currentLocation->id}");
            if ( $this->categories_loaded_for == $this->slplus->currentLocation->id ) { return; }


            // Reset the current location categories
            //
            $this->current_location_categories = array();

            // Get the first record from tagalong helper table
            //
            $location_category = $this->slplus->database->get_Record(
                    'select_categories_for_location',
                    $this->slplus->currentLocation->id,
                    0);

            // First record exists, 
            // push category ID onto current_location_categories
            // and loop through other category records,
            // appending to array
            //
            if ( $location_category !== null ) {
                $this->current_location_categories[] = $location_category['term_id'];
                $offset = 1;
                while (
                    ($location_category =
                        $this->slplus->database->get_Record(
                            'select_categories_for_location',
                            $this->slplus->currentLocation->id,
                            $offset++
                            )
                     ) !== null
                ) {
                    $this->current_location_categories[] = $location_category['term_id'];
                }
            }

            $this->debugMP('pr','',$this->current_location_categories);

            $this->categories_loaded_for = $this->slplus->currentLocation->id;
        }

        //----------------------------------
        // Filters
        //----------------------------------


        /**
         * Add categories to the location data.
         *
         * @param mixed[] $locationArray
         * @return mixed[]
         */
        static function filter_AddCSVExportData($locationArray) {
            if (!class_exists('Tagalong_Data')) {
                require_once(plugin_dir_path(__FILE__).'include/class.data.php');
            }
            $database = new Tagalong_Data();
            $locationArray['category'] = '';
            $offset = 0;
            while ($category = $database->get_Record(array('tagalong_selectall','whereslid'),$locationArray['sl_id'],$offset++)) {
                $categoryData = get_term($category['term_id'],'stores');
                if (($categoryData !== null) && !is_wp_error($categoryData)) {
                    $locationArray['category'] .= $categoryData->slug . ',';
                } else {
                    if (is_wp_error($categoryData)) {
                        $locationArray['category'] .= $categoryData->get_error_message() . ',';
                    }
                }
            }
            $locationArray['category'] = preg_replace('/,$/','',$locationArray['category']);
            return $locationArray;
        }

        /**
         * Add the category field to the csv export
         *
         * @param string[] $dbFields
         */
        static function filter_AddCSVExportFields($dbFields) {
            return array_merge(
                        $dbFields,
                        array('category')
                    );
        }

        /**
         * Change the results order.
         *
         * Precedence is given to the order by category count option over all other extensions that came before it.
         * This is enacted by placing the special category count clause as the first parameter of extend_OrderBy,
         * and by setting the filter to a high priority (run last).
         *
         * @param string $orderby
         * @return string modified order by
         */
        function filter_AJAX_ModifyOrderBy($orderby) {
            if (empty($this->options['ajax_orderby_catcount'])) { return $orderby; }
            $this->createobject_Data();
            return $this->slplus->database->extend_OrderBy('('.$this->data->get_SQL('select_categorycount_for_location').') DESC ',$orderby);
        }

        /**
         * Add tagalong-specific SQL to base plugin get_SQL command.
         *
         * @param string $command The SQL command array
         * @return string
         */
        function filter_AddTagalongSQL($command) {
            $this->createobject_Data();
            $sql_statement = $this->data->get_SQL($command);
            return $sql_statement;
        }

        /**
         * Add the categry condition to the MySQL statement used to fetch locations with JSONP.
         *
         * @param type $currentFilters
         * @return type
         */
        function filter_JSONP_SearchByCategory($currentFilters) {
            if (!isset($_POST['formdata']) || ($_POST['formdata'] == '')){
                return $currentFilters;
            }

            // Set our JSON Post vars
            //
            $JSONPost = wp_parse_args($_POST['formdata'],array());

            // Don't have cat in the vars?  Don't add a new selection filter.
            //
            if (!isset($JSONPost['cat']) || ($JSONPost['cat'] <= 0)) {
                return $currentFilters;
            }

            $this->createobject_Data();
            
            // Setup and clause to select stores by a specific category
            //
            $SQL_SelectStoreByCat = 
                ' AND ' .
                   ' sl_id IN ('.
                        sprintf(
                            'SELECT sl_id FROM ' . $this->data->plugintable['name'] . ' WHERE term_id IN ( %s )',
                            $JSONPost['cat']
                           ) .
                    ') '
                ;

            $this->slplus->debugMP('slp.tag','msg','filter_JSONP_SearchByCategory',$SQL_SelectStoreByCat,NULL,NULL,true);
            return array_merge($currentFilters,array($SQL_SelectStoreByCat));
        }

        /**
         * Add the Tagalong shortcode processing to whatever filter/hook we need it latched on to.
         *
         * The [tagalong] shortcode, used here, is setup in slp_init.
         */
        function filter_AddLegend($layoutString) {
            $this->debugMP('msg',__FUNCTION__,$layoutString);
            $layoutString = do_shortcode($layoutString);
            return $layoutString;
        }

        /**
         * Add Tagalong category selector to search layout.
         *
         */
        function filter_ModifySearchLayout($layout) {
            $this->debugMP('msg',__FUNCTION__);
            $this->debugMP('pr','',$this->slplus->data);

            if ( ! empty ( $this->slplus->data['only_with_category'] ) ) { $this->options['show_cats_on_search'] = '1'; }
            if ( empty( $this->options['show_cats_on_search'] ) ) { return $layout; }
            
            if (preg_match('/\[slp_search_element\s+.*dropdown_with_label="category".*\]/i',$layout)) { return $layout; }
            return $layout . '[slp_search_element dropdown_with_label="category"]';
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

                    case 'selector_with_label':
                    case 'dropdown_with_label':
                        switch ($value) {
                            case 'category':
                                return array(
                                    'hard_coded_value' =>
                                        !empty($this->options['show_cats_on_search'])      ?
                                        $this->createstring_CategorySelector()             :
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
        function filter_ProcessStorePage($attributes) {
            $this->debugMP('pr',__FUNCTION__,$attributes);
            $this->set_LocationCategories();

            // No categories set?  Get outta here...
            //
            if ( count( $this->current_location_categories ) < 1 ) { return $attributes; }

            foreach ($attributes as $name=>$value) {

                switch (strtolower($name)) {

                    case 'field':
                        switch ($value) {
                            case 'iconarray':
                                return array(
                                    'hard_coded_value' => $this->createstring_IconArray()
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
         * Add extended tagalong data to the category array.
         *
         * @param int $term_id the category term id
         * @return mixed[] named array of category attributes
         */
        function get_TermWithTagalongData($term_id) {
            if ( !isset( $this->category_details[$term_id] ) ) {
                
                $category_array = get_term_by('id',$term_id,SLPlus::locationTaxonomy,ARRAY_A);
                if ( ! is_array($category_array) ) { $category_array = array(); }

                $category_options = get_option(SLPLUS_PREFIX.'-TAGALONG-category_'.$term_id);
                if ( ! is_array($category_options) ) { $category_options = array(); }

                $this->category_details[$term_id] = array_merge($category_options,$category_array);
            }
            return $this->category_details[$term_id];
        }

        /**
         * Create a Map Settings Debug My Plugin panel.
         *
         * @return null
         */
        static function create_DMPPanels() {
            if (!isset($GLOBALS['DebugMyPlugin'])) { return; }
            if (class_exists('DMPPanelSLPTag') == false) {
                require_once(plugin_dir_path(__FILE__).'include/class.dmppanels.php');
            }
            $GLOBALS['DebugMyPlugin']->panels['slp.tag']           = new DMPPanelSLPTag();
        }

        /**
         * Process the Tagalong shortcode
         */
        function process_TagalongShortcode($atts) {
            $this->debugMP('msg',__FUNCTION__);
            if (is_array($atts)) {
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
        }

        /**
         * Prep the admin class and call it to render the admin pages for Tagalong.
         */
        function renderPage_TagList() {
            $this->debugMP('msg',__FUNCTION__);
            if (!$this->setPlugin()) { return ''; }
            $this->createobject_Admin();
            $this->Admin->render_TagListPage();
        }
    }

    // Hook to invoke the plugin.
    //
    add_action('init'           , array('SLPTagalong','init'                ));
    add_action('dmp_addpanel'   , array('SLPTagalong','create_DMPPanels'    ));

    // Pro Pack AJAX Filters
    //
    add_filter('slp-pro-dbfields'                   ,array('SLPTagalong','filter_AddCSVExportFields'), 100 );
    add_filter('slp-pro-csvexport'                  ,array('SLPTagalong','filter_AddCSVExportData'  ), 100 );
}
// Dad. Explorer. Rum Lover. Code Geek. Not necessarily in that order.
