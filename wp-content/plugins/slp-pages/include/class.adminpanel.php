<?php
if (! class_exists('SLPPages_AdminPanel')) {

    /**
     * Manage admin panel interface.
     *
     * @package StoreLocatorPlus\Pages\AdminPanel
     * @author Lance Cleveland <lance@charlestonsw.com>
     * @copyright 2012-2014 Charleston Software Associates, LLC
     */
    class SLPPages_AdminPanel {
        
        /**
         * This addon pack.
         *
         * @var \SLPPages $addon
         */
        private $addon;
        
        /**
         *
         * @var \wpCSL_settings__slplus $Settings
         */
        private $Settings;

        /**
         * The base SLPlus object.
         *
         * @var \SLPlus $slplus
         */
        private $slplus;
        
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

            // Setup and render settings page
            //
            $this->Settings = new wpCSL_settings__slplus(
                array(
                        'prefix'            => $this->addon->settingsSlug,
                        'css_prefix'        => $this->slplus->prefix,
                        'url'               => $this->slplus->url,
                        'name'              => $this->slplus->name . __(' - Store Pages','csa-slp-pages'),
                        'plugin_url'        => $this->slplus->plugin_url,
                        'render_csl_blocks' => true,
                        'form_action'       => admin_url().'admin.php?page='.$this->addon->settingsSlug
                    )
             );   
            

            // If we are updating settings...
            //
            if (isset($_REQUEST['action']) && ($_REQUEST['action']==='update')) {
                $this->updateSettings();
            }            
        }
        
         /**
          * Things we do when a new permalink has been set.
          *
          * Start by re-registering our post type with the new permalink info.
          *
          */
         function handle_new_permalink($newVal) {
            register_post_type('store_page',array('rewrite' => array('slug'=>$newVal)));
            flush_rewrite_rules();
         }
        

        /**
         * Render the admin panel.
         */
        function renderPage() {
            // Display any notices
            $this->slplus->notifications->display();

            //-------------------------
            // Navbar Section
            //-------------------------
            $this->Settings->add_section(
                array(
                    'name'          => 'Navigation',
                    'div_id'        => 'navbar_wrapper',
                    'description'   => $this->slplus->AdminUI->create_Navbar(),
                    'innerdiv'      => false,
                    'is_topmenu'    => true,
                    'auto'          => false,
                    'headerbar'     => false
                )
            );

            //-------------------------
            // General Settings Panel
            //-------------------------
            $panelName = __('Pages Settings','csa-slp-pages');
            $this->Settings->add_section(array('name'=>$panelName,'auto'=>true));

            // Group : Behavior
            //
            $groupName = __('Behavior','csa-slp-pages');
            $this->Settings->add_ItemToGroup(array(
                'section'       => $panelName                                           ,
                'group'         => $groupName                                           ,
                'type'          => 'dropdown'                                             ,
                'label'         => __('Default Page Status','csa-slp-pages')   ,
                'setting'       => 'default_page_status'                       ,
                'custom'        =>
                    array(
                        array(
                            'label'     => __('Draft','csa-slp-pages'),
                            'value'     =>'draft',
                            'selected'  => ($this->addon->options['default_page_status'] === 'draft'),
                            ),
                        array(
                            'label'     => __('Published','csa-slp-pages'),
                            'value'     =>'publish',
                            'selected'  => ($this->addon->options['default_page_status'] === 'publish'),
                            ),
                        array(
                            'label'     => __('Pending Review','csa-slp-pages'),
                            'value'     =>'pending',
                            'selected'  => ($this->addon->options['default_page_status'] === 'pending'),
                            ),
                        array(
                            'label'     => __('Future','csa-slp-pages'),
                            'value'     =>'future',
                            'selected'  => ($this->addon->options['default_page_status'] === 'future'),
                            ),
                        array(
                            'label'     => __('Private','csa-slp-pages'),
                            'value'     =>'private',
                            'selected'  => ($this->addon->options['default_page_status'] === 'private'),
                            ),
                    ),
                'description'   =>
                    __('When creating new Store Pages, what should the default status be?.','csa-slp-pages') . ' ' .
                    __('Default mode is draft.','csa-slp-pages')
                ));
            $this->Settings->add_ItemToGroup(array(
                    'section'       => $panelName,
                    'group'         => $groupName,
                    'type'          => 'slider',
                    'label'         => __('Pages Replace Websites', 'csa-slp-pages'),
                    'setting'       => 'pages_replace_websites',
                    'description'   => __('Use the Store Pages local URL in place of the website URL on the map results list.', 'csa-slp-pages'),
                    'value'         => $this->addon->options['pages_replace_websites']
                ));
            $this->Settings->add_ItemToGroup(array(
                    'section'       => $panelName,
                    'group'         => $groupName,
                    'type'          => 'slider',
                    'label'         => __('Prevent New Window', 'csa-slp-pages'),
                    'setting'       => 'prevent_new_window',
                    'description'   => __('Prevent Store Pages web links from opening in a new window.', 'csa-slp-pages'),
                    'value'         => $this->addon->options['prevent_new_window']
                ));
            $this->Settings->add_ItemToGroup(array(
                    'section'       => $panelName,
                    'group'         => $groupName,
                    'type'          => 'slider',
                    'label'         => __('Prepend URL With Blog Path', 'csa-slp-pages'),
                    'setting'       => 'prepend_permalink_blog',
                    'description'   => __('If checked the page URL will be prepended with the standard blog path. Example: '.
                                          'if your permalink structure is /blog/, then your links will be /blog/store-page. '.
                                          'If this is unchecked it will be /store-page.', 'csa-slp-pages'),
                    'value'         => $this->addon->options['prepend_permalink_blog']
                ));
            $this->Settings->add_ItemToGroup(array(
                    'section'       => $panelName,
                    'group'         => $groupName,
                    'type'          => 'text',
                    'label'         => __('Permalink Starts With','csa-slp-pages'),
                    'setting'       => 'permalink_starts_with',
                    'description'   => 
                        __('Set the middle part of the store page URLs, defaults to "store_page".'          ,'csa-slp-pages') .
                        sprintf(
                            __('<a href="%s">Permalinks</a> needs to be set to something other than default.'   ,'csa-slp-pages'),
                            admin_url('options-permalink.php')
                        )
                        ,
                    'value'         => $this->addon->options['permalink_starts_with']
                ));
            
            // Group : Initial Page Features
            //
            $groupName = __('Initial Page Features','csa-slp-pages');
            $this->Settings->add_ItemToGroup(array(
                    'section'       => $panelName,
                    'group'         => $groupName,
                    'type'          => 'slider',
                    'label'         => __('Default Comments', 'csa-slp-pages'),
                    'setting'       => 'default_comments',
                    'description'   => __('Should comments be on or off by default when a new store page is created?', 'csa-slp-pages'),
                    'value'         => $this->addon->options['default_comments']
                ));
            $this->Settings->add_ItemToGroup(array(
                    'section'       => $panelName,
                    'group'         => $groupName,
                    'type'          => 'slider',
                    'label'         => __('Default Trackbacks', 'csa-slp-pages'),
                    'setting'       => 'default_trackbacks',
                    'description'   => __('Should pingbacks/trackbacks be on or off by default when a new store page is created?', 'csa-slp-pages'),
                    'value'         => $this->addon->options['default_trackbacks']
                ));

            if (empty($this->addon->options['page_template'])) {
                $this->addon->options['page_template'] = $this->addon->Admin->createstring_DefaultPageTemplate();
            }
            $this->Settings->add_ItemToGroup(array(
                    'section'       => $panelName,
                    'group'         => $groupName,
                    'type'          => 'textarea',
                    'label'         => __('Page Template','csa-slp-pages'),
                    'setting'       => 'page_template',
                    'description'   =>
                            __('The HTML that is used to create new store pages.'   ,'csa-slp-pages') .
                            __('Leave blank to reset to default layout.'            ,'csa-slp-pages')
                            ,
                    'value'         => $this->addon->options['page_template']
                ));


            //------------------------------------------
            // RENDER
            //------------------------------------------
            $this->Settings->render_settings_page();
        }
        

        /**
         * Set the options from the incoming REQUEST
         *
         * @param mixed $val - the value of a form var
         * @param string $key - the key for that form var
         */
        function setOptions($val,$key) {
            $simpleKey = preg_replace('/^'.$this->addon->settingsSlug.'\-/','',$key);
            if ($simpleKey !== $key){

                // Special Actions
                switch ($simpleKey) {
                    case 'permalink_starts_with':
                        if ($this->addon->options[$simpleKey] !== $val) {
                            $this->handle_new_permalink($val);
                        }
                        break;
                    case 'page_template':
                        if ($this->addon->options[$simpleKey] !== $val) {
                            $val = stripslashes($val);
                        }
                        break;
                }

                // Now set the value...
                $this->addon->options[$simpleKey] = $val;
            }
         }
         

        /**
         * Update Store Pages settings
         */
        function updateSettings() {
           if (!isset($_REQUEST['page']) || ($_REQUEST['page']!=$this->addon->settingsSlug)) { return; }
           if (!isset($_REQUEST['_wpnonce'])) { return; }

           // Initialize inputs to '' if not set
           //
           $BoxesToHit = array(
               'default_comments',
               'default_trackbacks',
               'pages_replace_websites',
               'page_template',
               'permalink_starts_with',
               'prevent_new_window',
               'prepend_permalink_blog',
               );
           foreach ($BoxesToHit as $BoxName) {
               if (!isset($_REQUEST[$this->addon->settingsSlug.'-'.$BoxName])) {
                   $_REQUEST[$this->addon->settingsSlug.'-'.$BoxName] = '';
               }
           }

           // Go update the local options setting
           //
           array_walk($_REQUEST,array($this,'setOptions'));

           update_option($this->addon->settingsSlug.'-options', $this->addon->options);
        }         
        
    }
}
