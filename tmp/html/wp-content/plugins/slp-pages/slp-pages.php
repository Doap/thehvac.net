<?php
/**
 * Plugin Name: Store Locator Plus : Store Pages
 * Plugin URI: http://www.storelocatorplus.com/product/slp4-store-pages/
 * Description: A premium add-on pack for Store Locator Plus that creates custom pages for your locations.
 * Version: 4.1.02
 * Author: Charleston Software Associates
 * Author URI: http://charlestonsw.com/
 * Requires at least: 3.4
 * Tested up to : 3.9.1
 *
 * Text Domain: csa-slp-pages
 * Domain Path: /languages/
 */

if (!defined( 'ABSPATH'     )) { exit;   } // Exit if accessed directly, dang hackers

// No SLP? Get out...
//
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( !function_exists('is_plugin_active') ||  !is_plugin_active( 'store-locator-le/store-locator-le.php')) {
    return;
}

// Make sure the class is only defined once.
//
if (!class_exists('SLPPages'   )) {

    /**
     * The Store Pages add-on pack for Store Locator Plus
     *
     * @package StoreLocatorPlus\Pages
     * @author Lance Cleveland <lance@charlestonsw.com>
     * @copyright 2012-2014 Charleston Software Associates, LLC
     */
    class SLPPages {
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
        const MIN_SLP_VERSION   = '4.1.08';

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
        private $metadata;

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
         * The slug for the settings page.
         * 
         * @var string $settingsSlug
         */
        public $settingsSlug = 'slp_storepages';        

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
            'default_comments'                  => '1',
            'default_page_status'               => 'draft',
            'default_trackbacks'                => '1',
            'pages_replace_websites'            => '0',
            'page_template'                     => '',
            'permalink_starts_with'             => 'store-page',
            'prevent_new_window'                => '0',
            'prepend_permalink_blog'            => '1'
        );

        //-------------------------------------
        // Properties (this add-on)
        //-------------------------------------
        
        /**
         * The admin object interface.
         * 
         * @var \SLPPages_Admin $Admin
         */
        public $Admin;

        /**
         * Stores the values for the current Store Page.
         *
         * @var array an array of page values
         */
        private $currentPage = null;

        public $plugin_path = null;

        public $Settings    = null;

        //------------------------------------------------------
        // Methods
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
                load_plugin_textdomain( 'csa-slp-pages', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
                $instance = new SLPPages;
                
                // Property inits (one time only please)
                //
                $instance->plugin_path = dirname( __FILE__ );
            }

            // Load up the options
            //
            $dbOptions = get_option($instance->settingsSlug.'-options');
            if (is_array($dbOptions)) {
                $instance->options = array_merge($instance->options,$dbOptions);
            }
            
            return $instance;
        }

        /**
         * Constructor
         */
        function SLPPages() {
            $this->slug = plugin_basename(__FILE__);
            $this->name = __('Store Pages','csa-slp-pages');

            // SLP Actions & Filters
            //
            add_action('slp_admin_menu_starting'        ,array($this,'admin_menu'               )   );
            add_action('slp_init_starting'              ,array($this,'action_SLPInitStarting'   )   );
            add_action('slp_init_complete'              ,array($this,'action_SLPInitComplete'   )   );
            add_filter('slp_storepage_features'         ,array($this,'modify_storepage_features')   );

            // Locations Search Result
            //
            add_filter('slp_results_marker_data'                ,array($this,'filter_ModifyAJAXResponse'            ),10        );
        }

        //====================================================
        // WordPress Admin Actions
        //====================================================

        /**
         * WordPress admin_init hook for Tagalong.
         */
        function admin_init(){
            
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
        }

        /**
         * WordPress admin_menu hook.
         */
        function admin_menu(){
            
            if (!$this->setPlugin()) {  return;}
            $this->createobject_Admin();

           // Admin Styles
            //
            add_action(
                    'admin_print_styles-'.SLP_ADMIN_PAGEPRE.'slp_storepages',
                    array($this->Admin,'enqueue_admin_stylesheet')
                    );

            // Admin Actions
            //
            add_action('admin_init'                 ,array($this,'admin_init'                   )       );
            add_action('before_delete_post'         ,array($this,'action_DeleteStorePage'       )       );
            add_filter('slp_menu_items'             ,array($this,'add_menu_items'               ),100   );
        }

        //====================================================
        // Helpers
        //====================================================

        /**
         * Simplify the plugin debugMP interface.
         *
         * @param string $type
         * @param string $hdr
         * @param string $msg
         */
        function debugMP($type,$hdr,$msg='') {
            $this->plugin->debugMP('slp.pages',$type,$hdr,$msg,NULL,NULL,true);
        }

        /**
         * Set the plugin property to point to the primary plugin object.
         *
         * @global wpCSL_plugin__slplus $slplus_plugin
         * @return boolean true if plugin property is valid
         */
        function setPlugin() {
            if (!isset($this->plugin) || ($this->plugin == null)) {
                global $slplus_plugin;
                $this->plugin = $slplus_plugin;
                $this->slplus = $slplus_plugin;
            }
            return (
                isset($this->plugin)    &&
                ($this->plugin != null)
                );
        }


        //====================================================
        // Store Pages Custom Methods
        //====================================================

        /**
         * Add the Store Pages Menu Item
         *
         * @param type $menuItems
         * @return type
         */
        function add_menu_items($menuItems) {
            return array_merge(
                        $menuItems,
                        array(
                            array(
                            'label' => __('Store Pages','csa-slp-pages'),
                            'slug'              => 'slp_storepages',
                            'class'             => $this->Admin,
                            'function'          => 'render_SettingsPage'
                            )
                        )
                    );
        }

        /**
         * Create and attach the admin processing object.
         */
        function createobject_Admin() {
            if (!isset($this->Admin)) {
                require_once($this->dir.'include/class.admin.php');
                $this->Admin =
                    new SLPPages_Admin(
                        array(
                            'addon'     => $this,
                            'slplus'    => $this->slplus,
                        )
                    );
            }
        }        

         /**
          * Return an SQL command component based on the command key provided.
          *
          * @param string $command
          * @return string
          */
         function filter_ExtendGetSQL($command) {
             switch ($command) {

                    // WHERE
                    //
                    case 'wherelinkedpostid':
                        return ' WHERE sl_linked_postid=%d ';
                        break;

                    default:
                        return $command;
                        break;
             }
         }

        /**
         * Modify the slplus.options object going into SLP.js
         *
         * @param mixed[] $options
         */
        function filter_ModifyJSOptions($options) {
            return array_merge($options,
                        array(
                            'use_pages_links' => $this->options['pages_replace_websites'],
                            'use_same_window' => $this->options['prevent_new_window'    ],
                        )
                    );
        }

        /**
         * Modify the marker data.
         *
         * @param mixed[] $marker the current marker data
         */
        function filter_ModifyAJAXResponse($marker) {
            
            // If the pages URL is set
            //
            if (!is_null($marker['sl_pages_url']) && $marker['sl_pages_url'] != '') {
                
                // Get the data for the linked pages post id
                //
                $locationID = $marker['id'];
                $locData =
                    $this->plugin->database->get_Record(
                        array('selectall','whereslid'),
                        $locationID
                    ); 
                $sl_page_status = get_post_status($locData['sl_linked_postid']);
                
                // If the page is not published do NOT show the website link
                // by blanking out the seo page and the standard web link
                //
                if ($sl_page_status !== 'publish') {
                    $marker['sl_pages_url'] = '';
                    $marker['url'] = '';
                }
            }

            return $marker;
        }

        /**
         * Create a Map Settings Debug My Plugin panel.
         *
         * @return null
         */
        static function create_DMPPanels() {
            if (!isset($GLOBALS['DebugMyPlugin'])) { return; }
            if (class_exists('DMPPanelSLPPages') == false) {
                require_once(plugin_dir_path(__FILE__).'class.dmppanels.php');
            }
            $GLOBALS['DebugMyPlugin']->panels['slp.pages']           = new DMPPanelSLPPages();
        }

         /**
          * Run this every time SLP init finishes
          */
         function action_SLPInitStarting() {

            // WordPress Hooks
            add_shortcode('storepage',array($this,'process_storepage_Shortcode'));
            add_action('the_post',array($this,'action_PostProcessing'));

            // SLP Hooks
            //
            add_filter('slp_storepage_attributes'   ,array($this,'modify_storepage_attributes'  )       );
         }

         /**
          * Set the link in store locations table to null when a store page is permanently deleted.
          *
          * @param type $pageID
          * @return boolean
          */
         function action_DeleteStorePage($pageID) {
             $locationID =
                 $this->plugin->database->get_Value(
                     array('selectslid','wherelinkedpostid'),
                     $pageID
                     );
             $this->debugMP('msg',__FUNCTION__,"Location # ".print_r($locationID,true));
             $this->plugin->currentLocation->set_PropertiesViaDB($locationID);

             if (($this->plugin->currentLocation->linked_postid!=='') ||
                 ($this->plugin->currentLocation->pages_url!==''    )
                ){
                $this->plugin->currentLocation->linked_postid = '';
                $this->plugin->currentLocation->pages_url = '';
                $this->plugin->currentLocation->MakePersistent();
             }
             return true;
         }

         /**
          * Things we do ONE TIME when a post is being processed.
          *
          * Set the plugin currentLocation based on the current post ID.
          */
         function action_PostProcessing() {
            if (get_post_type(get_the_ID()) !== 'store_page'){ return; }
            if ($this->currentPage['ID'] === null           ){ return; }
            if (!ctype_digit($this->currentPage['ID'])      ){ return; }
            $this->debugMP('msg',__FUNCTION);
            $this->plugin->currentLocation->set_PropertiesViaArray(
                $this->plugin->database->get_Record(
                    array('select_all','wherelinkedpostid'),
                    $this->currentPage['ID']
                )
            );
         }

         /**
          * Run this when the SLP Init has completed.
          */
         function action_SLPInitComplete() {
            if (!$this->setPlugin()) {  return;}

            // Check the base plugin minimum version requirement.
            //
            $this->plugin->VersionCheck(array(
                'addon_name'            => $this->name,
                'addon_slug'            => $this->slug,
                'min_required_version'  => SLPPages::MIN_SLP_VERSION
            ));

            // Set Properties
            //
            $this->url = plugins_url('',__FILE__);
            $this->dir = plugin_dir_path(__FILE__);

            /**
             * Data processing
             */
            add_filter('slp_extend_get_SQL'                 ,array($this,'filter_ExtendGetSQL'                  )           );

            /**
             * UI Changes
             */
            add_filter('slp_js_options'     ,array($this,'filter_ModifyJSOptions'   ));

            $this->plugin->register_addon($this->slug);
         }

         /**
          * Manage the storepage shortcode
          *
          * @param array $attributes named array of attributes set in shortcode
          * @param string $content the existing content that we will modify
          * @return string the modified HTML content
          */
         function process_storepage_Shortcode($attributes, $content = null) {
            $this->debugMP('msg',__FUNCTION__);

            // Get current location
            //
            if ($this->plugin->currentLocation->id == '') {
                $this->plugin->currentLocation->set_PropertiesViaArray(
                    $this->plugin->database->get_Record(
                        array('selectall','wherelinkedpostid'),
                        get_the_ID()
                    )
                );
                $this->debugMP('msg','',"Set current location data for linked post id ".get_the_ID());
            }

            // Pre-process the attributes.
            //
            // This allows third party plugins to man-handle the process by
            // tweaking the attributes.  If, for example, they were to return
            // array('hard_coded_value','blah blah blah') that is all we would return.
            //
            // FILTER: shortcode_storepage
            //
            $attributes = apply_filters('shortcode_storepage',$attributes);
            $this->debugMP('pr','',$attributes);

            // Process the attributes
            //
            foreach ($attributes as $key=>$value) {
                $key=strtolower($key);
                switch ($key) {

                    // Field attribute: output specified field
                    //
                    case 'field':

                        // Convert legacy sl_<field> references
                        //
                        $value = preg_replace('/\W/','',htmlspecialchars_decode($value));
                        $value = preg_replace('/^sl_/','',strtolower($value));
                        $content = $this->plugin->currentLocation->$value;
                        break;

                    case 'type':
                        switch ($value) {
                            case 'hyperlink':
                                $content = esc_url($content);
                                break;

                            default:
                                break;
                        }
                        break;

                    case 'hard_coded_value':
                        $content = $value;
                        break;

                    default:
                        break;
                }
            }

            return $content;
         }

         /**
          * Modify the default store pages attributes.
          *
          * Basically turns on/off store pages.
          *
          * @param type $attributes
          * @return type
          */
         function modify_storepage_attributes($attributes) {
            if (!$this->setPlugin()) {  return;}
            return array_merge(
                    $attributes,
                    array(
                        'public'    => true,
                        'rewrite'   =>
                            array(
                                'slug'       => $this->options['permalink_starts_with'],
                                'with_front' => $this->plugin->is_CheckTrue($this->options['prepend_permalink_blog'])
                            )
                    )
                    );
         }

         /**
          * Modify the default store pages features.
          *
          * @param type $attributes
          * @return type
          */
         function modify_storepage_features($features) {
            return array_merge(
                    $features,
                    array(
                    )
                    );
         }
    }

    // Hook to invoke the plugin.
    //
    add_action('init'           ,array('SLPPages','init'            ));
    add_action('dmp_addpanel'   ,array('SLPPages','create_DMPPanels'));
}
// Dad. Explorer. Rum Lover. Code Geek. Not necessarily in that order.
