<?php
if (! class_exists('SLPSME_AdminPanel')) {

	/**
	 * Manage admin panel interface elements for SocialMediaExtender.
	 *
	 * @package StoreLocatorPlus\SocialMediaExtender\AdminPanel
	 * @author De B.A.A.T. <slp-sme@de-baat.nl>
	 * @copyright 2014 Charleston Software Associates, LLC - De B.A.A.T.
	 */
	class SLPSME_AdminPanel {


		//-------------------------------------
		// Properties
		//-------------------------------------

		/**
		 * This addon pack.
		 *
		 * @var \SLPSocialMediaExtender $addon
		 */
		private $addon;

		/**
		 * The csvImporter object.
		 *
		 * @var \CSVImportCategories $csvImporter
		 */
		public $csvImporter;

		/**
		 * The SLPSocialMediaExtender Admin object.
		 *
		 * @var \SLPSME_Admin $parent
		 */
		private $parent = null;

//		/**
//		 * Connect the list walker object here.
//		 *
//		 * @var \Tagalong_CategoryWalker_List $LegendWalker
//		 */
//		public $ListWalker;

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
		 * @param SLPSocialMediaExtender $parent
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
		}

		/**
		 * Create the menu for the Social Media Extender tab
		 */
		function render_AdminPanelPage() {

			$this->debugMP('msg',__FUNCTION__);


			// Show Notices
			//
			$this->slplus->notifications->display();

			//-------------------------
			// Navbar Section
			//-------------------------
			$this->parent->Settings->add_section(
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
			// Social Manager
			//-------------------------
			if ($this->parent->current_action != 'edit') {

				//-------------------------
				// Manage Social Objects
				//-------------------------
				$this->parent->adminSocialManager->render_SocialManagePage();
			} else {

				//-------------------------
				// Edit Social Object
				//-------------------------
				$this->parent->adminSocialManager->render_SocialAddEditPage(false);
			}

			//-------------------------
			// Add Social Object
			//-------------------------
			$this->parent->adminSocialManager->render_SocialAddEditPage(true);

			//-------------------------
			// Social Media Settings
			//-------------------------
			$this->render_SocialSettingsPage();

			//------------------------------------------
			// RENDER
			//------------------------------------------
			$this->parent->Settings->render_settings_page();
		}

		/**
		 * Render the admin panel.
		 */
		function render_SocialSettingsPage() {


			//-------------------------
			// SLPSocialMediaExtender Settings Panel
			//-------------------------
			$panelName  = __('Social Settings','csa-slp-sme');
			$this->parent->Settings->add_section(array('name' => $panelName));

			$groupName  = __('Social Settings','csa-slp-sme');

			// Group : Search
//			$this->parent->Settings->add_ItemToGroup(
//				array(
//					'section'       => $panelName,
//					'group'         => $groupName,
//					'label'         => __('Search','csa-slp-sme'),
//					'type'          => 'subheader',
//					'show_label'    => false,
//					'description'   => '',
//					)
//				);
//			$this->parent->Settings->add_ItemToGroup(array(
//				'section'       => $panelName,
//				'group'         => $groupName,
//				'type'          => 'dropdown',
//				'label'         => __('Show Social Media On Search','csa-slp-sme'),
//				'setting'       => 'SLP_SME-sme_show_socials_on_search',
//				'custom'        =>
//					array(
//						array(
//							'label'     => __('No','csa-slp-sme'),
//							'value'     => '',
//							'selected'  => ($this->addon->options['sme_show_socials_on_search'] === ''),
//							),
//						array(
//							'label'     => __('Drop Down','csa-slp-sme'),
//							'value'     => 'dropdown',
//							'selected'  => ($this->addon->options['sme_show_socials_on_search'] === 'dropdown'),
//							),
//						array(
//							'label'     => __('Radio Buttons','csa-slp-sme'),
//							'value'     => 'radiobutton',
//							'selected'  => ($this->addon->options['sme_show_socials_on_search'] === 'radiobutton'),
//							),
//					),
//				'description'   =>
//					__('How to show the social media selector on the search form.','csa-slp-sme') . ' ' .
//					__('No will not show the social media selector.','csa-slp-sme') . ' ' .
//					__('Drop Down shows the social media selector as a single drop down.','csa-slp-sme') . ' ' .
//					__('Radio Buttons shows the social media selector as a set of radio buttons.','csa-slp-sme')
//				));
////			$this->parent->Settings->add_ItemToGroup(array(
////				'section'       => $panelName,
////				'group'         => $groupName,
////				'type'          => 'slider',
////				'setting'       => 'SLP_SME-sme_hide_empty',
////				'value'         => $this->slplus->is_CheckTrue($this->addon->options['sme_hide_empty']),
////				'label'         => __('Hide Unpublished Social Media','csa-slp-sme'),
////				'description'   =>
////					__('Hide the empty social media from the social media selector.','csa-slp-sme'),
////				));
//			$this->parent->Settings->add_ItemToGroup(array(
//				'section'       => $panelName,
//				'group'         => $groupName,
//				'type'          => 'text',
//				'setting'       => 'SLP_SME-sme_show_option_all',
//				'value'         => $this->addon->options['sme_show_option_all'],
//				'label'         => __('Any Social Media Label','csa-slp-sme'),
//				'description'   =>
//					__('If set, prepends this text to select "any social media" as an option to the selector. Set to blank to not provide the any selection.','csa-slp-sme'),
//				));
//			$this->parent->Settings->add_ItemToGroup(array(
//				'section'       => $panelName,
//				'group'         => $groupName,
//				'type'          => 'text',
//				'setting'       => 'SLP_SME-sme_label_social_media',
//				'value'         => $this->addon->options['sme_label_social_media'],
//				'label'         => __('Social Media Select Label','csa-slp-sme'),
//				'description'   =>
//					__('The label for the social media selector.','csa-slp-sme'),
//				 ));

			// Group : Results
			//
			$this->parent->Settings->add_ItemToGroup(
				array(
					'section'       => $panelName,
					'group'         => $groupName,
					'label'         => __('Results','csa-slp-sme'),
					'type'          => 'subheader',
					'show_label'    => false,
					'description'   => '',
					)
				);
			$this->parent->Settings->add_ItemToGroup(array(
					'section'       => $panelName,
					'group'         => $groupName,
					'type'          => 'slider',
					'setting'       => 'SLP_SME-sme_show_icon_array',
					'value'         => $this->addon->options['sme_show_icon_array'],
					'label'         => __('Show Icon Array','csa-slp-sme'),
					'description'   =>
						__('When enabled an array of icons will be created in the below map results.','csa-slp-sme')
				));

			// Group : View
			//
		$use_social_option_view = false;
		if ($use_social_option_view) {
			$this->parent->Settings->add_ItemToGroup(
				array(
					'section'       => $panelName,
					'group'         => $groupName,
					'label'         => __('View','csa-slp-sme'),
					'type'          => 'subheader',
					'show_label'    => false,
					'description'   => '',
					)
				);
			$this->parent->Settings->add_ItemToGroup(array(
					'section'       => $panelName,
					'group'         => $groupName,
					'type'          => 'slider',
					'setting'       => 'SLP_SME-sme_show_legend_text',
					'value'         => $this->addon->options['sme_show_legend_text'],
					'label'         => __('Show Text Under Legend','csa-slp-sme'),
					'description'   =>
						__('When enabled text will appear under each Social Media icon in the legend. ','csa-slp-sme') .
						sprintf(__('Add legend to the output with the [social-media-extender legend] shortcode via the %s view setting.','csa-slp-sme'),
								SLPlus::linkToPRO)
					)
			 );
		}

			//------------------------------------------
			// Group buttons
			//------------------------------------------

			$onClick = "AdminUI.doAction('save_settings','','locationForm' );";

			$buttonContent  = "";
			$buttonContent .= "<div id='slp_form_buttons' style='padding-left:188px;'>";
			$buttonContent .= "<input type='submit' class='button-primary' style='width:150px;margin:3px;' ";
			$buttonContent .= 'value="'   . __('Save Settings','csa-slp-sme') . '" ';
			$buttonContent .= 'onClick="' . $onClick . '" ';
			$buttonContent .= "' alt='" . __('Save Settings','csa-slp-sme') . "' title='" . __('Save Settings','csa-slp-sme') . "'";
			$buttonContent .= ">";
			$buttonContent .= "</div>";

			$this->parent->Settings->add_ItemToGroup(array(
					'section'       => $panelName,
					'group'         => $groupName,
					'setting'       => 'sme_save_setting_button',
					'type'          => 'custom',
					'show_label'    => false,
					'custom'        => $buttonContent,
					'value'         => '',
					'label'         => __('Social Buttons', 'csa-slp-sme'),
					));

			// Settings : Explanation
			//
			$groupName = __('Explanation','csa-slp-sme') ;
			$this->parent->Settings->add_ItemToGroup(
				array(
					'section'       => $panelName                   ,
					'group'         => $groupName                   ,
					'label'         => __('Documentation','csa-slp-sme')    ,
					'type'          => 'subheader'                  ,
					'show_label'    => false                        ,
					'description'   =>
						sprintf(__('View the <a href="%s" target="csa">documentation</a> for more info. ','csa-slp-sme'),$this->addon->support_url)
					)
				);

		}

		/**
		 * Create and attach the \CSVImportLocations object
		 */
		function create_CSVSocialDataImporter($params=null) {
//            if (!class_exists('CSVImportSocialDatas')) {
//                require_once(plugin_dir_path(__FILE__).'class.csvimport.social_data.php');
//            }
//            if ($params===null) { $params = array(); }
//            if (!isset($this->csvImporter)) {
//                $this->csvImporter =
//                    new CSVImportSocialDatas(
//                        array_merge(
//                            array(
//                                'parent'    => $this->parent,
//                                'plugin'    => $this->slplus,
//                            ),
//                            $params
//                         )
//                    );
//            }
		}

		/**
		 * Render the list of store social_datas.
		 *
		 *  @return string HTML for the social_data list.
		 */
		function createstring_StoreSocialDataList() {
//            $this->debugMP('msg',__FUNCTION__);
//            return
//                '<ul id="slp_sme_social_data_list">' .
//                wp_list_categories(
//                        array(
//                            'echo'              => 0,
//                            'hierarchical'      => 1,
//                            'hide_empty'        => 0,
//                            'show_count'        => 1,
//                            'taxonomy'          => 'stores',
//                            'title_li'          => '',
//                            'walker'            => $this->ListWalker
//                        )
//                    ) .
//                '</ul>'
//                ;
		}

		/**
		 * Process an incoming CSV import file.
		 */
		function process_CSVSocialDataFile() {
//            $this->create_CSVSocialDataImporter();
//            $this->csvImporter->process_File();
		}

		/**
		 * Simplify the parent debugMP interface.
		 *
		 * @param string $type
		 * @param string $hdr
		 * @param string $msg
		 */
		function debugMP($type,$hdr,$msg='') {
			if (($type === 'msg') && ($msg!=='')) {
				$msg = esc_html($msg);
			}
			if ($hdr != '') { $hdr = 'APanel: ' . $hdr; }
			$this->slplus->debugMP($type,$hdr,$msg,NULL,NULL,true);
		}

	}
}