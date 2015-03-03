<?php
if (! class_exists('SLPPages_Admin')) {
    require_once(SLPLUS_PLUGINDIR.'/include/base_class.admin.php');

    /**
     * Holds the admin-only code.
     *
     * This allows the main plugin to only include this file in admin mode
     * via the admin_menu call.   Reduces the front-end footprint.
     *
     * @package StoreLocatorPlus\SLPPagese\Admin
     * @author Lance Cleveland <lance@charlestonsw.com>
     * @copyright 2014 Charleston Software Associates, LLC
     */
    class SLPPages_Admin extends SLP_BaseClass_Admin {

        //-------------------------------------
        // Properties
        //-------------------------------------

        /**
         * The admin panel processor.
         *
         * @var \SLPPages_AdminPanel
         */
        private $AdminPanel;

        //-------------------------------------
        // Methods : Base Override
        //-------------------------------------

        /**
         * Admin specific hooks and filters.
         *
         */
        function add_hooks_and_filters() {

            // Register the admin stylesheet
            //
            wp_register_style(
                $this->addon->settingsSlug.'_style',
                $this->addon->url . '/admin.css'
                );

            // Admin skinning
            //
            add_filter('wpcsl_admin_slugs'                      ,array($this,'filter_AddOurAdminSlug'               )           );

            // SLP Action Hooks & Filters (admin UI only)
            //
            add_action('slp_manage_locations_action'            ,array($this,'action_ExtendManageLocations'         )           );
            add_filter('slp_location_page_attributes'           ,array($this,'filter_SetPageAttributes'             )           );

            // Edit Locations
            //
            add_filter('slp_edit_location_right_column'         ,array($this,'filter_AddFieldsToEditForm'           ),12        );

            // Manage Locations
            //
            add_filter('slp_locations_manage_bulkactions'       ,array($this,'filter_AddBulkAction'                 )           );
            add_filter('slp_manage_expanded_location_columns'   ,array($this,'add_manage_locations_columns'         )           );
            add_filter('slp_manage_locations_actionbuttons'     ,array($this,'add_manage_locations_actionbuttons'   ),15,2      );
            add_filter('slp_column_data'                        ,array($this,'filter_AddFieldDataToManageLocations' ),90    ,3  );

            // Manage Store Page
            //
            add_action('publish_'.SLPlus::locationPostType      ,array($this,'action_CheckPostContentWhenPublish'   ),90    ,2  );               
        }


        /** 
         * Check if the content of Store Page post is blank when it's being published.
         * If it is, set content to default template value.
         *
         * @param mixed $post_id
         * @param mixed $post
         */
        function action_CheckPostContentWhenPublish($post_id, $post) {
            if ( trim( $post->post_content ) == '') {
                $post->post_content = $this->createstring_DefaultPageTemplate();
                wp_update_post($post);
            }
        }
        
        
         /**
          * Handle actions from the Manage Locations interface.
          */
         function action_ExtendManageLocations() {
             $this->addon->debugMP('msg','SLPPages_Admin::'.__FUNCTION__,"Action: {$_REQUEST['act']}");

             switch($_REQUEST['act']) {
                case 'createpage':
                    if (isset($_REQUEST['sl_id'])) {
                        if (!is_array($_REQUEST['sl_id'])) {
                            $theLocations = array($_REQUEST['sl_id']);
                        } else {
                            $theLocations = $_REQUEST['sl_id'];
                        }
                        foreach ($theLocations as $locationID) {
                            $this->slplus->currentLocation->set_PropertiesViaDB($locationID);
                            $this->slplus->currentLocation->crupdate_Page();
                        }
                    }
                    break;

                case 'deletepage':
                    if (isset($_REQUEST['sl_id'])) {
                        if (!is_array($_REQUEST['sl_id'])) {
                            $theLocations = array($_REQUEST['sl_id']);
                        } else {
                            $theLocations = $_REQUEST['sl_id'];
                        }
                        foreach ($theLocations as $locationID) {
                            $this->slplus->currentLocation->set_PropertiesViaDB($locationID);
                            $post = get_post($this->slplus->currentLocation->linked_postid);
                            if (($post !== null) && ($post->post_type === SLPLUS::locationPostType)) {
                                wp_delete_post($this->slplus->currentLocation->linked_postid,true);
                            }
                        }
                    }
                    break;

                default:
                    break;
            }
         }

        /**
         * Add a location action button.
         *
         * @param string $theHTML - the HTML of the original buttons in place
         * @param array $locationValues
         * @return string - the augmented HTML
         */
        function add_manage_locations_actionbuttons($theHTML,$locationValues) {
            if (!isset($locationValues['sl_id']))   { return $theHTML;  }
            if ($locationValues['sl_id'] < 0)       { return $theHTML;  }

            // Set the URL
            //
            $shortSPurl = preg_replace('/^.*?store_page=/','',$locationValues['sl_pages_url']);
            $locationValues['sl_pages_url'] = "<a href='$locationValues[sl_pages_url]' target='csa'>$shortSPurl</a>";

            $pageClass = (($locationValues['sl_linked_postid']>0)?'haspage_icon' : 'createpage_icon');
            $pageURL  = preg_replace(
                            '/&createpage=/'.(isset($_GET['createpage'])?$_GET['createpage']:''),
                            '',
                            $_SERVER['REQUEST_URI']
                            ).
                         '&act=createpage'.
                         '&sl_id='.$locationValues['sl_id'].
                         '&slp_pageid='.$locationValues['sl_linked_postid'].
                         '#a'.$locationValues['sl_id']
                    ;
            return $theHTML .
                   "<a  class='action_icon $pageClass' ".
                        "alt='".__('create page','csa-slp-pages')."' ".
                        "title='".__('create page','csa-slp-pages')."' ".
                        "href='$pageURL'></a>"
                    ;
        }         
         
        /**
         * Add the Store Pages URL column.
         *
         * @param array $theColumns - the array of column data/titles
         * @return array - modified columns array
         */
        function add_manage_locations_columns($theColumns) {
            return array_merge($theColumns,
                    array(
                        'sl_pages_url'      => __('Pages URL'          ,'csa-slp-pages'),
                    )
                );
        }      


         /**
          * Create the action entry string based on the params entries.
          *
          * params['label'] - required, the text to show for the link
          * params['ifok']  - boolean, if true only show this item if the pages_url for the current location is set
          *
          * @param mixed[] $params
          * @return string
          */
         function createstring_PagesActionEntry($params) {
             // If all these things are true that means we have no page URL
             // and we are not supposed to be showing this... get out
             //
             if (($this->slplus->currentLocation->pages_url=='') && isset($params['ifpageexists']) && $params['ifpageexists']   ) { return; }
             if (!isset($params['label']) || empty($params['label'])                                            ) { return; }

             // Set title if not set
             if (!isset($params['title'])) { $params['title'] = $params['label']; }

             // Set link if not set
             if (!isset($params['link']))  { $params['link'] = '#'; }

             // Rel used?
             //
             if (isset($params['rel'])) { $params['rel'] = " rel='{$params['rel']}' "; }
             else { $params['rel'] = ''; }

             // Target used?
             //
             if (isset($params['target'])) { $params['target'] = " target='{$params['target']}' "; }
             else { $params['target'] = ''; }

             // Class used?
             //
             if (isset($params['class'])) { $params['class'] = " class='{$params['class']}' "; }
             else { $params['class'] = ''; }

             return "<a {$params['class']} {$params['rel']} title='{$params['title']}' href='{$params['link']}' {$params['target']}>{$params['label']}</a>";
         }
        
        
         /**
          * Create the action row string for the manage locations entries.
          *
          * This appears under the pages_url column.
          */
         function createstring_PagesActionRow() {
             $actions = array();

             // Things we only do for posts with a linked post ID
             //
             if ($this->slplus->currentLocation->linked_postid > 0) {
                $pageStatus = get_post_status($this->slplus->currentLocation->linked_postid);

                // Recreate
                //
                $link = $this->createstring_PagesActionEntry(array(
                       'ifpageexists'  => true,
                       'label' => __('Recreate','csa-slp-pages'),
                       'link'  => $this->slplus->AdminUI->ManageLocations->hangoverURL.'&act=createpage&sl_id='.$this->slplus->currentLocation->id
                       ));
                if (!empty($link)) { $actions['create'] = $link; }

                // Edit
                //
                $link = $this->createstring_PagesActionEntry(array(
                       'ifpageexists'  => true,
                       'label' => __('Edit','csa-slp-pages'),
                       'link'  => admin_url() . 'post.php?post=' . $this->slplus->currentLocation->linked_postid . '&action=edit'
                       ));
                if (!empty($link)) { $actions['edit'] = $link; }

                // Trash
                //
                if ($pageStatus !== 'trash') {
                    $link = $this->createstring_PagesActionEntry(array(
                           'ifpageexists'  => true,
                           'label' => __('Trash','csa-slp-pages'),
                           'class' =>'submitdelete',
                           'link'  => get_delete_post_link($this->slplus->currentLocation->linked_postid)
                           ));
                    if (!empty($link)) { $actions['trash'] = $link; }
                }

                // Delete Permanently
                //
                $link = $this->createstring_PagesActionEntry(array(
                       'ifpageexists'  => true,
                       'label' => __('Delete','csa-slp-pages'),
                       'class' =>'submitdelete',
                       'link'  => get_delete_post_link($this->slplus->currentLocation->linked_postid,'',true)
                       ));
                if (!empty($link)) { $actions['delete'] = $link; }


                // View/Preview
                //
                switch ($pageStatus) {
                    // View mode for published, private items
                    //
                    case 'private':
                    case 'publish':
                        $link = $this->createstring_PagesActionEntry(array(
                            'ifpageexists'      => true,
                            'label'     => __('View','csa-slp-pages'),
                            'rel'       => 'permalink',
                            'target'    => 'csa',
                            'link'      => $this->slplus->currentLocation->pages_url
                            ));
                        if (!empty($link)) { $actions['view'] = $link; }
                        break;

                    // All others - preview mode
                    //
                    default:
                        $link = $this->createstring_PagesActionEntry(array(
                            'ifpageexists'      => true,
                            'label'     => __('Preview','csa-slp-pages'),
                            'rel'       => 'permalink',
                            'target'    => 'csa',
                            'link'      => get_site_url().'?post_type=store_page&p=' . $this->slplus->currentLocation->linked_postid . '&preview=true'
                            ));
                        if (!empty($link)) { $actions['view'] = $link; }
                        break;
                }
             }

             return  $this->slplus->AdminUI->ManageLocations->row_actions($actions);
         }
         

        /**
         * Create and attach the admin processing object.
         */
        function createobject_AdminPanel() {
            if (!isset($this->Admin)) {
                require_once('class.adminpanel.php');
                $this->AdminPanel =
                    new SLPPages_AdminPanel(
                        array(
                            'addon'     => $this->addon,
                            'slplus'    => $this->slplus,
                        )
                    );
            }
        }            

        /**
         * Create the default Store Page content.
         *
         * @return string - HTML content that is the WordPress page content.
         */
        function createstring_DefaultPageTemplate() {
            $content =
                '<span class="storename">[storepage field="store"]</span>'                     ."\n".
                '<img class="alignright size-full" title="[storepage field="store"]" '         .
                    'src="[storepage field="image"]"'                                          .
                 '/>'                                                                          ."\n".
                '[storepage field="address"]'                                                  ."\n".
                '[storepage field="address2"]'                                                 ."\n".
                '[storepage field="city"] [storepage field="state"] [storepage field="zip"] '  ."\n".
                '[storepage field="country"]'                                                  ."\n".
                '<h1>'.__('Description','csa-slp-pages').'</h1>'                               ."\n".
                '<p>[storepage field="description"]</p>'                                       ."\n".
                '<h1>'.__('Contact Info','csa-slp-pages').'</h1>'                              ."\n".
                $this->slplus->WPML->getWPMLText(SLPLUS_PREFIX.'_label_phone', get_option(SLPLUS_PREFIX.'_label_phone',__('Phone','csa-slp-pages'))).'[storepage field="phone"]'                      ."\n".
                $this->slplus->WPML->getWPMLText(SLPLUS_PREFIX.'_label_fax'  , get_option(SLPLUS_PREFIX.'_label_fax'  ,__('Fax','csa-slp-pages'))).  '[storepage field="fax"]'                          ."\n".
                '<a href="mailto:[storepage field="email"]">[storepage field="email"]</a>'     ."\n".
                '<a href="[storepage field="url" type="hyperlink"]">[storepage field="url"]</a>'."\n"
                ;

            return apply_filters('slp_pages_default_content',$content);
        }
         
         
         /**
          * Create the content for a Store Page.
          *
          * Creates the content for the page.  If plus pack is installed
          * it uses the plus template file, otherwise we use the hard-coded
          * layout.
          *
          * @param type $store
          * @return string
          */
        function createstring_PageContent($store=null) {

            // Make sure we have a default template.
            //
             if (empty($this->addon->options['page_template'])) {
                 $this->addon->options['page_template'] = $this->createstring_DefaultPageTemplate();
             }

             // FILTER: slp_pages_content
             //
             return apply_filters('slp_pages_content',$this->addon->options['page_template']);
         }     

        /**
         * Create a short Store Page URL for use on manage locations interface.
         *
         * @param string $fullURL
         * @return string the short hyperlinked URL
         */
        function createstring_ShortPageURL($fullURL) {
            $pattern = '/^(.*?)=/';
            $shortURL = preg_replace($pattern,'',$fullURL);
            $shortURL = str_replace(get_site_url(),'',$shortURL);
            return "<a href='$fullURL' target='csa'>$shortURL</a>";
        }

        /**
         * Enqueue the style sheet when needed.
         */
        function enqueue_admin_stylesheet() {
            wp_enqueue_style($this->addon->settingsSlug.'_style');
        }
        
        /**
         * Add more actions to the Bulk Action drop down on the admin Locations/Manage Locations interface.
         *
         * @param mixed[] $BulkActions
         */
        function filter_AddBulkAction($BulkActions) {
            return
                array_merge(
                    $BulkActions,
                    array(
                        array(
                            'label'     =>  __('Create Pages','csa-slp-pages')  ,
                            'value'     => 'createpage'                       ,
                        ),
                        array(
                            'label'     =>  __('Delete Pages Permanently','csa-slp-pages')  ,
                            'value'     => 'deletepage'                         ,
                        ),                )
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
         * @return string the modified data
         */
        function filter_AddFieldDataToManageLocations($theData,$theField,$theLabel) {
            switch ($theField) {

                // sl_pages_url column
                //
                case 'sl_pages_url':
                    $theData = '';
                    if ($this->slplus->currentLocation->pages_url!='') {
                        $theData .= '<span class="infoid floater">'.get_post_status($this->slplus->currentLocation->linked_postid).'</span>';
                        $theData .= $this->createstring_ShortPageURL($this->slplus->currentLocation->pages_url);
                    }
                    $theData .= $this->createstring_PagesActionRow();
                    break;

                default:
                    break;
            }
            return $theData;
        }        

        /**
         * Extend the edit location form to show store pages data.
         *
         * @param string $HTML
         * @return string
         */
        function filter_AddFieldsToEditForm($HTML) {
            $this->addon->debugMP('msg',__FUNCTION__);
            if ($this->slplus->AdminUI->ManageLocations->addingLocation) { return $HTML; }
            $shortSPurl = preg_replace('/^.*?store_page=/','',$this->slplus->currentLocation->pages_url);
            if ($this->slplus->currentLocation->linked_postid>=0) {
                $pageEditLink =
                    sprintf('<a href="%s" class="action_icon edit_icon" target="_blank"></a>',
                        admin_url().'post.php?post='.$this->slplus->currentLocation->linked_postid.'&action=edit'
                        );
            }
            return
                $HTML .
                '<div id="slp_pages_fields" class="slp_editform_section">'.
                    $this->slplus->helper->create_SubheadingLabel(__('Store Pages','csa-slp-pages')).
                    "<label for='pages_url'>".
                        sprintf(__('Store Page (%d):','csa-slp-pages'),$this->slplus->currentLocation->linked_postid).
                    "</label>".
                    $pageEditLink . ' ' .
                    "<a name='pages_url' href='{$this->slplus->currentLocation->pages_url}' target='csa'>$shortSPurl</a>" .
                '</div>'
                ;
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
                        'slp_storepages',
                        SLP_ADMIN_PAGEPRE.'slp_storepages',
                        )
                    );
        }

        /**
         * Set the page content when location create/update page is called.
         *
         * @param mixed[] $pageData
         */
        function filter_SetPageAttributes($pageData) {
            return
                array_merge($pageData,
                    array(
                        'post_content'  =>  $this->createstring_PageContent(),
                        'post_status'   => $this->addon->options['default_page_status']
                    )
                );
        }
        
         // Render the settings page
         //
         function render_SettingsPage() {
             $this->createobject_AdminPanel( 
                array(
                    'addon'     => $this->addon , 
                    'slplus'    => $this->slplus 
                )
            );
            $this->AdminPanel->renderPage();
         }        

        /**
         * Set base class properties so we can have more cross-add-on methods.
         */
        function set_addon_properties() {
            $this->admin_page_slug = $this->addon->slug;
        }
    }
}
// Dad. Explorer. Rum Lover. Code Geek. Not necessarily in that order.
