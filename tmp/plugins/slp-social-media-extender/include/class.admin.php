<?php
if (! class_exists('SLPSME_Admin')) {

	/**
	 * Holds the admin-only code.
	 *
	 * This allows the main plugin to only include this file in admin mode
	 * via the admin_menu call.   Reduces the front-end footprint.
	 *
	 * @package StoreLocatorPlus\SocialMediaExtender\Admin
	 * @author De B.A.A.T. <slp-sme@de-baat.nl>
	 * @copyright 2014 Charleston Software Associates, LLC - De B.A.A.T.
	 *
	 */
	class SLPSME_Admin {

		//----------------------------------
		// Properties
		//----------------------------------


		/**
		 * The activation handler.
		 * 
		 * @var \SLPSME_Activation $activation
		 */
		private $activation;

		/**
		 * This addon pack.
		 *
		 * @var \SLPSocialMediaExtender $addon
		 */
		private $addon;

		/**
		 * The admin interface.
		 *
		 * @var \SLPSME_AdminPanel
		 */
		private $AdminUI;

		/**
		 * The data helper object.
		 *
		 * @var \SLPSME_Data $data
		 */
//		private $data;

		/**
		 * The base class for the parent SME class
		 *
		 * @var \SLPSocialMediaExtender $parent
		 **/
		private $parent;

		/**
		 * The settings object.
		 *
		 * @var \wpCSL_settings__slplus $Settings
		*/
		public $Settings;

		/**
		 * The base class for the SLP plugin
		 *
		 * @var \SLPlus $slplus
		 **/
		private $slplus;

		/**
		 * Social Manager object.
		 *
		 * @var \SLPSME_Admin_SocialManager $socialManager
		 */
		public $adminSocialManager;

		/**
		 * The current action as determined by the incoming $_REQUEST['act'] string.
		 *
		 * @var string $current_action
		 */
		public $current_action;

		/**
		 * Where clause for the social selections.
		 * 
		 * @var string
		 */
		private $csl_separator = '--';

		//-------------------------------------
		// Methods : Class Administration
		//-------------------------------------

		/**
		 * Instantiate an object of this class.
		 *
		 * @param mixed[] $params Admin UI properties.
		 */
		function __construct($params = null) {

			// Set properties based on constructor params,
			// if the property named in the params array is well defined.
			//
			if ($params !== null) {
				foreach ($params as $property=>$value) {
					if (property_exists($this,$property)) { $this->$property = $value; }
				}
			}

			// Check the installed version,
			// if newer than installed version run some update stuff.
			//
			global $wpdb;
			if (version_compare($this->addon->options['installed_version'], SLPSocialMediaExtender::SME_VERSION, '<')) {
				if (class_exists('SLPSME_Activation') == false) {
					require_once(plugin_dir_path(__FILE__).'class.activation.php');
				}
				$this->activation = new SLPSME_Activation(
						array(
                            'parent'    => $this,
                            'slplus'    => $this->slplus,
                            'addon'     => $this->addon,
						)
					);
				$this->activation->update();
				$this->addon->options['installed_version'] = SLPSocialMediaExtender::SME_VERSION;
				update_option(SLPSocialMediaExtender::OPTION_NAME,$this->addon->options);
			} else {
				$this->debugMP('msg',__FUNCTION__ . ' Social Media Extender up-to-date with version: ' . $this->addon->options['installed_version'] . '!');
			}


			// Admin skinning
			//
			add_filter('wpcsl_admin_slugs'                  ,array($this,'filter_AddOurAdminSlugSME'                         )           );

			// The SocialDatas Interface (aka Taxonomy)
			// where we attach the icon/marker to a social_data
			//
			add_action('stores_add_form_fields'             ,array($this,'filter_stores_add_form_fieldsSME'                  )           );
			add_action('stores_edit_form'                   ,array($this,'filter_stores_edit_formSME'                        )           );

			// Location Deleted
			//
			add_action('slp_deletelocation_starting'        ,array($this,'action_DeleteLocationSocialDatasSME'               )           );

			// Manage Locations Interface
			//
			add_filter('slp_column_data'                    ,array($this,'filter_RenderSocialDatasInManageLocationsTableSME' ),90    ,3  );

		}


		//-------------------------------------
		// Methods : WP Hooks and Filters
		//-------------------------------------

		/**
		 * Delete current location social_datas from SLPSocialMediaExtender social_datas table.
		 */
		function action_DeleteLocationSocialDatasSME() {
			$this->debugMP('msg',__FUNCTION__);
//            $this->data->db->query(
//                $this->data->db->prepare($this->data->get_SQL('delete_by_id'),$this->slplus->currentLocation->id)
//             );
		}


		//----------------------------------
		// Object Creation Methods
		//----------------------------------

		/**
		 * Create an AdminUI object and attached to this->AdminUI
		 *
		 */
		function createobject_AdminPanel() {
			if ( ! class_exists( 'SLPSME_AdminPanel' ) ) {
				require_once('class.adminpanel.php');
			}

			if ( ! isset( $this->AdminUI ) ) {
				$this->AdminUI = new SLPSME_AdminPanel(
						array(
							'parent'    => $this,
							'slplus'    => $this->slplus,
							'addon'     => $this->addon,
						)
				);
			}
		}

		/**
		 * Create the data interface object.
		 */
		function createobject_SocialManager() {
			$this->debugMP('msg',__FUNCTION__.' started.');
			if (class_exists('SLPSME_Admin_SocialManager') == false) {
				require_once('class.admin.social_manager.php');
			}
			if (!isset($this->adminSocialManager)) {
				$this->adminSocialManager = new SLPSME_Admin_SocialManager(array(
					'slplus'   => $this->slplus,
					'parent'   => $this,
					'addon'    => $this->addon,
					)
				);
			}
		}

		//----------------------------------
		// Data I/O Methods
		//----------------------------------

		/**
		 * Help deserialize data to array.
		 *
		 * Useful for sl_option_value  field processing.
		 *
		 * @param type $value
		 * @return type
		 */
		function deserialize_to_array($value) {
			$value=stripslashes_deep($value);
			$this->debugMP('msg',__FUNCTION__,$value);
			$arrayData = maybe_unserialize($value);
			if (!is_array($arrayData)) {
				if ($arrayData == '') {
					$arrayData = array();
				} else {
					$arrayData = array('value' => $arrayData);
				}
			}
			return $arrayData;
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
		 * Add our admin pages to the valid admin page slugs.
		 *
		 * @param string[] $slugs admin page slugs
		 * @return string[] modified list of admin page slugs
		 */
		function filter_AddOurAdminSlugSME($slugs) {

			$this->debugMP('pr',__FUNCTION__.' started for slugs:', $slugs);
			$this->debugMP('pr',__FUNCTION__.' merged with:', array(
						SLPSocialMediaExtender::ADMIN_PAGE_SLUG,
						SLP_ADMIN_PAGEPRE.SLPSocialMediaExtender::ADMIN_PAGE_SLUG,
						));

			return array_merge($slugs,
					array(
						SLPSocialMediaExtender::ADMIN_PAGE_SLUG,
						SLP_ADMIN_PAGEPRE.SLPSocialMediaExtender::ADMIN_PAGE_SLUG,
						)
					);
		}

		/**
		 * Render the social_datas column in the manage locations table.
		 *
		 * SLP Filter: slp_column_data
		 *
		 * @param string $theData  - the option_value field data from the database
		 * @param string $theField - the name of the field from the database (should be sl_option_value)
		 * @param string $theLabel - the column label for this column (should be 'SocialDatas')
		 * @return type
		 */
		function filter_RenderSocialDatasInManageLocationsTableSME($theData,$theField,$theLabel) {
			$this->debugMP('msg',__FUNCTION__ . ' for theField: ' . $theField);

			if ($this->addon->test_SocialSlugPrefix($theField)) {

				$this->debugMP('msg','', '+ theData: '  . $theData);
				$this->debugMP('msg','', '+ theLabel: ' . $theLabel);
				$curSocial = $this->addon->get_SocialObjectFromCache($theField);
				$theNewData = '';
				if ($curSocial) {
					$this->debugMP('pr','Found curSocial: ', $curSocial);

					$theNewData .= '<div class="slp_sme_entry">';
					$theNewData .= $this->addon->show_SocialIcon($curSocial, $theData);
					$theNewData .= '<span class="slp_sme_entry_name">'.$theData.'<span></div>';
					$theNewData .= '</div>';
				}

				return $theNewData;

			}
			return $theData;
		}

		/**
		 * Render the extra social-media-extender social_data fields for the add form.
		 */
		function filter_stores_add_form_fieldsSME() {
//			$this->debugMP('msg',__FUNCTION__);
			// TODO: Let Social Media fields stand out from the other extended data
		}

		/**
		 * Render the extra social-media-extender social_data fields for the edit form.
		 */
		function filter_stores_edit_formSME($socialData) {
//			$this->debugMP('msg',__FUNCTION__);
			// TODO: Let Social Media fields stand out from the other extended data
		}

		/**
		 * Set the social-media-extender options from the incoming REQUEST
		 *
		 * @param mixed $val - the value of a form var
		 * @param string $key - the key for that form var
		 */
		function isSLPSocialMediaExtenderOption($val,$key) {
			$simpleKey = preg_replace('/^'.SLPLUS_PREFIX.'-SLP_SME-/','',$key);
			if ($simpleKey !== $key){
				$this->addon->options[$simpleKey] = $val;
			}
		 }

		//----------------------------------
		// Render Screen Methods
		//----------------------------------

		/**
		 * Render the Social Media Extender tab
		 */
		function render_AdminPage() {

			// Create the child objects
			$this->createobject_SocialManager();
			$this->createobject_AdminPanel();
			$this->set_CurrentAction();
			$this->debugMP('msg',__FUNCTION__.' started for ****************************************** action =.' . $this->current_action);

			// Process the actions
			//
			$this->process_Actions();

			// Setup and render settings page
			//
			$this->Settings = new wpCSL_settings__slplus(
				array(
						'prefix'            => $this->slplus->prefix,
						'css_prefix'        => $this->slplus->prefix,
						'url'               => $this->slplus->url,
						'name'              => $this->slplus->name . ' - ' . $this->addon->name,
						'plugin_url'        => $this->slplus->plugin_url,
						'render_csl_blocks' => true,
//						'form_name'         => 'slp_social_form',
						'form_name'         => 'locationForm',
						'form_enctype'      => 'multipart/form-data',
						'no_save_button'    => true,
						'form_action'       => admin_url().'admin.php?page='.SLPSocialMediaExtender::ADMIN_PAGE_SLUG
					)
			 );

			// Attach Admin Panel and create the menu
			//
			$this->AdminUI->render_AdminPanelPage();

//			$this->debugMP('pr',__FUNCTION__ . ' Settings: ', $this->Settings);

			//------------------------------------------
			// RENDER
			//------------------------------------------
//			$this->Settings->render_settings_page();
		}

		/**
		 * Save our settings.
		 * @return type
		 */
		function save_SocialSettings() {
			$this->debugMP('msg',__FUNCTION__);
			$BoxesToHit = array(
				'sme_label_social_media',
				'sme_show_option_all',
				'sme_show_socials_on_search',
				'sme_default_icons',
				'sme_show_icon_array',
				'sme_show_legend_text',
				'sme_hide_empty',
				);
			foreach ($BoxesToHit as $BoxName) {
				if (!isset($_REQUEST[SLPLUS_PREFIX.'-SLP_SME-'.$BoxName])) {
					$_REQUEST[SLPLUS_PREFIX.'-SLP_SME-'.$BoxName] = '';
				}
			}

			// Check options, then save them all in one place (serialized)
			//
			array_walk($_REQUEST,array($this,'isSLPSocialMediaExtenderOption'));
			update_option(SLPSocialMediaExtender::OPTION_NAME, $this->addon->options);

			$this->slplus->notifications->add_notice(
					9,
					__('SLPSocialMediaExtender settings saved.','csa-slp-sme')
					);
			return;
		}

		/**
		 * Update the SLPSocialMediaExtender settings.
		 */
		function update_SocialSettings() {
			$this->debugMP('msg',__FUNCTION__);
			if (!isset($_REQUEST['page']) || ($_REQUEST['page']!='slp_sme')) { return; }
			if (!isset($_REQUEST['_wpnonce'])) { return; }
			switch ($_REQUEST['action']) {
				case 'import':
					$this->AdminUI->process_CSVSocialDataFile();
					break;
				case 'update':
					$this->save_SocialSettings();
					break;
				default:
					break;
			}
		}

		/**
		 * Initialize all our Admin mode goodness.
		 *
		 * This is put into the admin_init stack of WordPress via the admin_menu hook.
		 * It must come AFTER admin_menu to ensure the base plugin has been initialized.
		 *
		 * We call admin_init in the parent to wire this in, then relegate the rest to
		 * this class as this entire class file only loads into RAM when admin_init is
		 * called.  This prevents the base add-on pack from carrying around excess
		 * admin weight when processing front-end pages.
		 *
		 */
		function admin_init() {

			$this->debugMP('msg',__FUNCTION__.' started.');

			// Check the installed version,
			// if newer than installed version run some update stuff.
			//
			if(version_compare($this->addon->options['installed_version'], SLPSocialMediaExtender::SME_VERSION, '<')) {
				$this->debugMP('msg', '', "Updating plugin from version " . $this->addon->options['installed_version'] . " to " . SLPSocialMediaExtender::SME_VERSION);

				if (class_exists('SLPSME_Activation') == false) {
					require_once('class.activation.php');
				}
				$this->activation = new SLPSME_Activation(array(
					'slplus'  => $this->slplus,
					'addon'   => $this->addon,
					'parent'  => $this,
					));
				$this->activation->update();

				$this->addon->options['installed_version'] = SLPSocialMediaExtender::SME_VERSION;
				update_option(SLPSocialMediaExtender::OPTION_NAME,$this->addon->options);

			} else {
				$this->debugMP('msg', '', "Plugin up to date with version " . $this->addon->options['installed_version'] . ". ");
			}

			// WordPress Update Checker - if this plugin is active
			// See if there is a newer version out there somewhere
			// over the rainbow.
			//
			if (is_plugin_active($this->addon->slug)) {
				$this->addon->metadata = get_plugin_data(__FILE__, false, false);
				$this->Updates = new SLPlus_Updates(
						$this->addon->metadata['Version'],
						$this->slplus->updater_url,
						$this->addon->slug
						);
			}

			// wpCSL Filters
			//
			// wpcsl_admin_slugs : skin and script the admin UI
			//
			add_filter('wpcsl_admin_slugs'              ,array($this,'filter_AddOurAdminSlugSME'                        ) );

			// SLP Action Hooks
			//
			// slp_location_added : update extendo data when adding a location
			// slp_location_saved : update extendo data when changing a location
			//

			// SLP Filters
			//
			// slp_edit_location_right_column : add extendo fields to location add/edit form
			// slp_manage_location_columns : show extendo fields on the locations list table
			// slp_column_data : manipulate per-location data when it is rendered in the locations list table
			//
			// NOTE: Make sure these are executed AFTER the filters of Super Extendo!!!
			//
			add_filter('slp_edit_location_right_column'         ,array($this,'filter_AddExtendedDataToEditFormSME'              ),06        );

		}

		/** ************************************************************************
		 * Process the actions for this request.
		 **************************************************************************/
		function process_Actions() {

	//		$this->current_action = 'TESTINGTESTING';
			$this->current_action = $this->set_CurrentAction();
			$this->debugMP('msg',__FUNCTION__.': Process [' . $this->current_action . '] for helperSocial :' . $this->addon->helperSocial->id);

			if ( $this->current_action === '' ) { return; }

			switch ($this->current_action) {

				// ADD
				//
				case 'add' :
					$this->add_Social();
					break;

				// SAVE
				//
				case 'edit':
				case 'update':
				case 'save':

					// Check whether the social value to process is set
					$this->save_Social();
					break;

				case 'save_settings':

					// Check whether the social value to process is set
					$this->save_SocialSettings();
					break;

				// DELETE
				//
//				case 'delete':
//					//$socialList = is_array($_REQUEST['sl_id'])?$_REQUEST['sl_id']:array($_REQUEST['sl_id']);
//					$this->debugMP('pr',__FUNCTION__ . " Delete Action: for :",$socialValues);
//					foreach ($socialValues as $socialID) {
//						$this->addon->helperSocial->set_PropertiesViaDB($socialID);
//						$this->addon->helperSocial->debugProperties();
//						$this->addon->helperSocial->DeletePermanently();
//					}
//					break;

				// Stuff that is not an exact string match
				//
				default:

					// Unsupported action
					$this->debugMP('msg',__FUNCTION__,"Unsupported Action: {" . $this->current_action . "}");
					break;
			}
			do_action('slp_manage_socials_action');
		}

		/**
		 * Set the current action being executed by the plugin.
		 */
		function set_CurrentAction() {
			//if ( !isset( $_REQUEST['act'] ) ) { $this->current_action = '';                               }
			// Check for dedicated actions
			if ( isset( $_REQUEST['action'] ) && -1 != $_REQUEST['action'] ) {
				$this->current_action = strtolower( $_REQUEST['action'] );
			} elseif ( isset( $_REQUEST['action2'] ) && -1 != $_REQUEST['action2'] ) {
				$this->current_action = strtolower( $_REQUEST['action2'] );
			} elseif ( isset( $_REQUEST['act'] ) ) {
				$this->current_action = strtolower( $_REQUEST['act'] );
			}

			// Special Processing of Actions
			//
			switch ($this->current_action) {
				case 'edit':
					if ( isset( $_REQUEST['action'] ) ) {
						$this->current_action = $_REQUEST['action'];
					}
					break;

				default:
					break;
			}
			return $this->current_action;
		}

		// Add a social
		//
		function add_Social() {
			$this->debugMP('msg',__FUNCTION__);

			// Get the data to process
			$socialData = array();
			foreach ($_POST as $key => $sl_value) {
				if (preg_match('#\-$#', $key)) {
					$fieldName = 'sl_' . $this->get_SettingsSettingKey($key, 'add');
					$socialData[$fieldName]=(!empty($sl_value)?$sl_value:'');
				}
			}

			//Inserting addresses by manual input
			//
			if (($socialData['sl_social_name'] == '') && ($socialData['sl_social_slug'] == '')) {
				$this->debugMP('pr','social_Add found no valid social_slug in socialData:',$socialData);
				$errorMsg  = __("Social Media not added! ",'csa-slp-sme');
				$errorMsg .= __('The add social form on your server is not rendering properly.','csa-slp-sme');
				$errorMsg .= sprintf(__('At least one of the fields %s or %s is mandatory.','csa-slp-sme'),  __('Social Name', 'csa-slp-sme'), __('Social Slug', 'csa-slp-sme'));
				$this->slplus->notifications->add_notice(2, $errorMsg);

			} else {
				if ($socialData['sl_social_name'] == '') {
					$socialData['sl_social_name'] = $socialData['sl_social_slug'];
				}
				$socialData['sl_social_slug'] = $this->addon->make_SocialSlug($socialData['sl_social_slug'], $socialData['sl_social_name']);

				$this->debugMP('pr','add_Social found valid socialData:',$socialData);
				$resultObject = $this->addon->create_SocialObject($socialData);
				if ($resultObject) {
					$this->addon->helperSocial = $resultObject;
					$this->addon->helperSocial->MakePersistent();
					$this->slplus->notifications->add_notice('info', sprintf(__("Social %s added successfully for %s.",'csa-slp-sme'), $this->addon->helperSocial->id, $socialData['sl_social_slug']));
				} else {
					$errorMsg = sprintf(__("Social %s not added!",'csa-slp-sme'), stripslashes_deep($socialData['sl_social_slug']));
					$this->slplus->notifications->add_notice('warning', $errorMsg);
				}
			}
		}

		/**
		 * Save a social.
		 */
		function save_Social() {

			if (!isset($_REQUEST['social'])) {
				$this->debugMP('msg',__FUNCTION__ . " social # _REQUEST[social] NOT set so do not process!");
			}

			$this->debugMP('msg',__FUNCTION__ . " social # {$_REQUEST['social']}");
	//		$this->slplus->notifications->delete_all_notices();

			// Get our original address first
			//
			$this->addon->helperSocial->set_PropertiesViaDB($_REQUEST['social']);

			// Get the updated Social Data
			//
			foreach ($_POST as $key => $value) {
				if (preg_match('#\-'.$this->addon->helperSocial->id.'#', $key)) {
	//                $slpFieldName = preg_replace('#\-'.$this->addon->helperSocial->id.'#', '', $key);
					$slpFieldName = $this->get_SettingsSettingKey($key, 'update');

					// Has the data changed?
					//
					$stripped_value = stripslashes_deep($value);
					if ($this->addon->helperSocial->$slpFieldName !== $stripped_value) {
						$this->debugMP('msg','',"social $slpFieldName set to $stripped_value");
						$this->addon->helperSocial->$slpFieldName = $stripped_value;
						$this->addon->helperSocial->dataChanged = true;
					}
				}
			}

			// Make persistent
			//
			// HOOK: slp_social_save
			//
			do_action('slp_social_save');
			$this->addon->helperSocial->debugProperties();
			if ($this->addon->helperSocial->dataChanged) {
				$this->addon->helperSocial->MakePersistent();
			}

			// HOOK: slp_social_saved
			// Stuff that is done after a social has been saved.
			//
			do_action('slp_social_saved');

		}

		//-------------------------------------
		// Methods : SLP Hooks
		//-------------------------------------

		/**
		 * Hide the Store Social for a Social Media Extender
		 * 
		 * @param $theform
		 */
		function filter_AddExtendedDataToEditFormSME($theform) {
			$this->debugMP('msg',__FUNCTION__.' started.',"Current Social: " . $this->addon->helperSocial->id);
			// This functionality should handle the SME specific fields
			//
			// Optionally, it could list all SME-related extended fields, recognised by starting with SLPSocialMediaExtender::SOCIAL_SLUG_PREFIX
			return $theform;
		}

		//-------------------------------------
		// Methods : Object Management
		//-------------------------------------

		/**
		 * Get the string used as name for the setting.
		 *
		 * @param bool $addform - true if rendering add socials form
		 */
		function get_SettingsSettingKey($settingKey, $settingAction, $settingID='') {
			$this->debugMP('msg',__FUNCTION__,' settingKey = ' . $settingKey . ', settingID = ' . $settingID . '.');

			$keyPattern = '#^.*' . $settingAction . $this->csl_separator . '(.*)' . $this->csl_separator . '.*#';
			$keyReplacement = '\1';
			$newSettingKey = preg_replace($keyPattern, $keyReplacement, $settingKey);
			$this->debugMP('msg','',' keyPattern = ' . $keyPattern . ', keyReplacement = ' . $keyReplacement . '.');
			$this->debugMP('msg','',' settingKey = ' . $settingKey . ', newSettingKey = ' . $newSettingKey . '.');

			return $newSettingKey;

		}

		/**
		 * Return the icon selector HTML for the icon images in saved markers and default icon directories.
		 *
		 * @param type $inputFieldID
		 * @param type $inputImageID
		 * @return string
		 */
		 function social_CreateIconSelector($inputFieldID = null, $inputImageID = null) {
			if (($inputFieldID == null) || ($inputImageID == null)) { return ''; }


			$htmlStr = '';
			$files=array();
			$fqURL=array();


			// If we already got a list of icons and URLS, just use those
			//
			if (
				isset($this->slplus->data['social_iconselector_files']) &&
				isset($this->slplus->data['social_iconselector_urls'] )
			   ) {
				$files = $this->slplus->data['social_iconselector_files'];
				$fqURL = $this->slplus->data['social_iconselector_urls'];

			// If not, build the icon info but remember it for later
			// this helps cut down looping directory info twice (time consuming)
			// for things like home and end icon processing.
			//
			} else {

				// Load the file list from our directories
				//
				// using the same array for all allows us to collapse files by
				// same name, last directory in is highest precedence.
				$iconAssets = apply_filters('slp_icon_directories',
						array(
								array('dir'=>SLPLUS_UPLOADDIR.'social-icons/',
									  'url'=>SLPLUS_UPLOADURL.'social-icons/'
									 ),
	//                            array('dir'=>SLPLUS_ICONDIR,
	//                                  'url'=>SLPLUS_ICONURL
	//                                 )
							)
						);
				$fqURLIndex = 0;
				foreach ($iconAssets as $icon) {
					if (is_dir($icon['dir'])) {
						if ($iconDir=opendir($icon['dir'])) {
							$fqURL[] = $icon['url'];
							while ($filename = readdir($iconDir)) {
								if (strpos($filename,'.')===0) { continue; }
								$files[$filename] = $fqURLIndex;
							};
							closedir($iconDir);
							$fqURLIndex++;
						} else {
							$this->slplus->notifications->add_notice(
									9,
									sprintf(
											__('Could not read icon directory %s','csa-slp-sme'),
											$directory
											)
									);
							 $this->slplus->notifications->display();
						}
				   }
				}
				ksort($files);
				$this->slplus->data['social_iconselector_files'] = $files;
				$this->slplus->data['social_iconselector_urls']  = $fqURL;
			}

			// Build our icon array now that we have a full file list.
			//
			foreach ($files as $filename => $fqURLIndex) {
				if (
					(preg_match('/\.(png|gif|jpg)/i', $filename) > 0) &&
					(preg_match('/shadow\.(png|gif|jpg)/i', $filename) <= 0)
					) {
					$htmlStr .=
						"<div class='slp_icon_selector_box'>".
							"<img class='slp_icon_selector'
								 src='".$fqURL[$fqURLIndex].$filename."'
								 onclick='".
									"document.getElementById(\"".$inputFieldID."\").value=this.src;".
									"document.getElementById(\"".$inputImageID."\").src=this.src;".
								 "'>".
						 "</div>"
						 ;
				}
			}

			// Wrap it in a div
			//
			if ($htmlStr != '') {
				$htmlStr = '<div id="'.$inputFieldID.'_icon_row" class="slp_icon_row">'.$htmlStr.'</div>';

			}


			return $htmlStr;
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
			if ($hdr != '') { $hdr = 'Admin: ' . $hdr; }
			$this->addon->debugMP($type,$hdr,$msg,NULL,NULL,true);
		}

	}
}