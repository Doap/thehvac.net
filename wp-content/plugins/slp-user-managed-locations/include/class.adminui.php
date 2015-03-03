<?php
if (! class_exists('SLPUML_AdminUI')) {
	/**
	 * Admin interface methods.
	 *
	 * @package StoreLocatorPlus\UserManagedLocations\AdminUI
	 * @author De B.A.A.T. <slp-uml@de-baat.nl>
	 * @copyright 2014 Charleston Software Associates, LLC - De B.A.A.T.
	 *
	 */
	class SLPUML_AdminUI {

		//----------------------------------
		// Properties
		//----------------------------------

		/**
		 * The add-on pack from whence we came.
		 * 
		 * @var \SLPUserManagedLocations $addon
		 */
		private $addon;

		/**
		 * The UserManagedLocations add-on pack.
		 * 
		 * @var \SLPUserManagedLocations $parent
		 */
		private $parent;

		/**
		 * A shorthand for the Super Extendo Data object.
		 *
		 * @var \Extendo_Data
		 */
		public $SEData;

		/**
		 * The base SLPlus object.
		 *
		 * @var \SLPlus $slplus
		 */
		private $slplus;

		/**
		 * User Manager object.
		 *
		 * @var \SLPUML_AdminUI_UserManager $usermanager
		 */
		private $usermanager;

		/**
		 * The current action as determined by the incoming $_REQUEST['action'] string.
		 *
		 * @var string $current_action
		 */
		public $current_action;

		/**
		 * The settings object.
		 *
		 * @var \wpCSL_settings__slplus $Settings
		*/
		//public $Settings;

		//-------------------------------------
		// Methods : Class Aministration
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
		}


		//-------------------------------------
		// Methods : WP Hooks and Filters
		//-------------------------------------

		/**
		 * Initialize all our Admin mode goodness.
		 *
		 * This is put into the admin_init stack of WordPress via the admin_menu hook.
		 * It must come AFTER admin_menu to ensure the base plugin has been initialized.
		 *
		 * We call admin_init in the slpuml to wire this in, then relegate the rest to
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
			if(version_compare($this->addon->options['installed_version'], SLPUserManagedLocations::VERSION, '<')) {
				$this->debugMP('msg','',"Updating plugin from version " . $this->addon->options['installed_version'] . " to " . SLPUserManagedLocations::VERSION);

				if (class_exists('SLPUML_Activation') == false) {
					require_once('class.activation.php');
				}
				$this->activation = new SLPUML_Activation(
											array(
												'parent'    => $this,
												'slplus'    => $this->slplus,
												'addon'     => $this->parent,
											));
				$this->createshorthand_SEDataObject();
				$this->activation->update();

				$this->addon->options['installed_version'] = SLPUserManagedLocations::VERSION;
				update_option(SLPUserManagedLocations::OPTION_NAME,$this->addon->options);

			}

			// WordPress Update Checker - if this plugin is active
			// See if there is a newer version out there somewhere
			// over the rainbow.
			//
			if (is_plugin_active($this->addon->slug)) {
				$this->addon->metadata = get_plugin_data( $this->addon->file , false, false);
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
			add_filter('wpcsl_admin_slugs'                      ,array($this,'filter_AddOurAdminSlug'                           )           );

			// Manage Locations UI
			//
			add_filter('slp_locations_manage_bulkactions'       ,array($this,'filter_LocationsBulkActionUML'                    )           );
			add_filter('slp_locations_manage_filters'           ,array($this,'filter_AddManageLocationsFiltersUML'              )           );

			// Manage Locations Processing
			//
			add_action('slp_manage_locations_action'            ,array($this,'action_ManageLocationsProcessingUML'              )           );

			// Manage Locations
			//
			add_action('slp_manage_location_where'              ,array($this,'filter_ManageLocations_FilterUser'                ), 110      );

			// SLP Action Hooks
			//
			// slp_location_added : update extendo data when adding a location
			// slp_location_saved : update extendo data when changing a location
			//
			add_action('slp_location_added'                     ,array($this,'action_SaveExtendedDataUML'                       ), 110      );
			add_action('slp_location_saved'                     ,array($this,'action_SaveExtendedDataUML'                       ), 110      );
			add_action('slp_deletelocation_starting'            ,array($this,'action_DeleteExtendedDataUML'                     ), 110      );

			// SLP Filters
			//
			// slp_edit_location_right_column : add extendo fields to location add/edit form
			// slp_manage_location_columns : show extendo fields on the locations list table
			// slp_column_data : manipulate per-location data when it is rendered in the locations list table
			//
			// NOTE: Make sure these are executed AFTER the filters of Super Extendo!!!
			//
			add_filter('slp_edit_location_right_column'         ,array($this,'filter_AddExtendedDataToEditFormUML'              ),06        );
			add_filter('slp_manage_expanded_location_columns'   ,array($this,'filter_AddExtendedDataToLocationColumnsUML'       ),15        );
			add_filter('slp_column_data'                        ,array($this,'filter_ShowExtendedDataInColumnsUML'              ),85    ,3  );

			// Pro Pack Filters
			//
			if ($this->slplus->is_AddonActive('slp-pro')) {
				add_filter('slp_csv_locationdata'       , array( $this, 'filter_CheckForPreExistingIdentifierUML'  ) );
			}
		}

		/**
		 * Create the shorthand for the Super Extendo Data object.
		 */
		function createshorthand_SEDataObject() {

			$this->debugMP('msg',__FUNCTION__.' started.');

			if (!isset($this->SEData) && $this->slplus->database->is_Extended()) {
				$this->slplus->database->createobject_DatabaseExtension();
				$this->SEData = $this->slplus->database->extension;
			}
		}

		/**
		 * Add our admin pages to the valid admin page slugs.
		 *
		 * @param string[] $slugs admin page slugs
		 * @return string[] modified list of admin page slugs
		 */
		function filter_AddOurAdminSlug($slugs) {

			$this->debugMP('msg',__FUNCTION__.' started.');

			return array_merge($slugs,
					array(
						SLPUserManagedLocations::ADMIN_PAGE_SLUG,
						SLP_ADMIN_PAGEPRE.SLPUserManagedLocations::ADMIN_PAGE_SLUG,
						)
					);
		}

		/**
		 * Add more filters to the Filter drop down on the admin Locations/Manage Locations interface.
		 *
		 * @param mixed[] $items
		*/
		function filter_AddManageLocationsFiltersUML($items) {

			// Only add this filter if the current_user slp_uml_is_admin
			if ($this->addon->slp_uml_is_admin()) { 
				return
					array_merge(
						$items,
						array(
							array(
								'label'     =>  __('Filter User','csa-slp-uml')  ,
								'value'     => 'filter_store_user'               ,
								'extras'    =>
									'<div id="extra_filter_store_user" class="filter_extras">'.
										'<label for="sl_filter_store_user">'.__('Enter the store user to filter on: ','csa-slp-uml').'</label>'.
//										'<input name="sl_filter_store_user" onkeydown="if (event.keyCode == 13) document.getElementById(\'doaction_filterType\').click()">'.
//										'<input name="sl_filter_store_user" onkeypress="if (event.keyCode == 13) AdminUI.doAction(jQuery(\'#filterType\').val(),\'\');">'.
										'<input name="sl_filter_store_user" onkeypress="if (event.keyCode == 13) document.getElementById(\'doaction_filterType\').click();">'.
									'</div>'
							)
						)
					);
			}
			return $items;
		}

		/**
		 * Setup the Filter User filter for manage locations.
		 * Filter the locations on the store_user entered
		 *
		 * @param string $where
		 * @return string
		 */
		function filter_ManageLocations_FilterUser($where) {

			$this->debugMP('msg',__FUNCTION__ . ' STARTED with clause: ',$where);
			$operator = empty($where) ? '' : " AND ";
			$newClause = '';

			// Use different filter for admins and non-admins
			if ($this->addon->slp_uml_is_admin()) {
				// Check filter button parameter for admins

				// Check some values to validate the filter action
				if (!isset($_REQUEST['filter']))                { return $where; }
				if ($_REQUEST['filter'] != 'filter_store_user') { return $where; }
				if (!isset($_REQUEST['sl_filter_store_user']))  { return $where; }
				if ($_REQUEST['sl_filter_store_user'] == '')    { return $where; }

				// If request valid, create additional filter where clause
				$newClause = $this->addon->slp_uml_where_filter_store_user($_REQUEST['sl_filter_store_user']);
			} else {
				// Filter on user for non-admins
				$newClause = $this->addon->slp_uml_get_where_current_user();
			}

			// Append new clause and original clause
			$whereClause = $where . $operator . $newClause;

			$this->debugMP('msg',__FUNCTION__ . ' CONTINUED with clause: ',$whereClause);
            return $whereClause;
		}

		/**
		 * Add more actions to the Bulk Action drop down on the admin Locations/Manage Locations interface.
		 *
		 * @param mixed[] $BulkActions
		 */
		function filter_LocationsBulkActionUML($items) {
			$this->debugMP('pr',__FUNCTION__.' started for items: ', $items);

			// Add bulk actions if user is Store Admin
			//
			if ($this->addon->slp_uml_is_admin()) {
				// Store Admin so add bulk actions.
				$return_items = 
					array_merge(
						$items,
						array(
							array(
								'label'     =>  __('Assign Store User','csa-slp-uml'),
								'value'     => 'assign_store_user',
								'extras'    =>
									'<div id="extra_assign_store_user" class="bulk_extras">'.
										'<label for="sl_assign_store_user">'.__('Define the store user to assign: ','csa-slp-uml').'</label>'.
										'<input name="sl_assign_store_user">'.
									'</div>'
							),
						),
						array(
							array(
								'label'     =>  __('Remove Store User','csa-slp-uml'),
								'value'     => 'remove_store_user',
							),
						)
					);
			} else {
				// No Store Admin so don't add anything.
				$return_items = $items;
			}
			return $return_items;
		}

		/**
		 * Additional location processing on manage locations admin page.
		 *
		 */
		function action_ManageLocationsProcessingUML() {
			$this->debugMP('msg',__FUNCTION__.' started. ');

			// If user is no Store Admin, don't do anything
			//
			if (!$this->addon->slp_uml_is_admin()) {
				return;
			}
			
			// If user is Store Admin, process the actions
			switch ($_REQUEST['act']) {

				// Add store_user setting to locations
				case 'assign_store_user':
					$this->debugMP('msg',__FUNCTION__.' should ASSIGN store user value: '.$_REQUEST['sl_assign_store_user']);
					if (isset($_REQUEST['sl_id'])) { $this->uml_LocationsBulkActionSetStoreUser($_REQUEST['sl_id'],$_REQUEST['sl_assign_store_user']); }
					break;

				// Remove store_user setting from locations
				case 'remove_store_user':
					$this->debugMP('msg',__FUNCTION__.' should REMOVE store user value! ');
					if (isset($_REQUEST['sl_id'])) { $this->uml_LocationsBulkActionSetStoreUser($_REQUEST['sl_id'],''); }
					break;

				default:
					$this->debugMP('msg',__FUNCTION__.' should process unknown action ' . $_REQUEST['act'] . ' for store user value! ');
					break;
			}
		}

		/**
		 * Tag a location
		 *
		 * @param string $action = add or remove
		 */
		function uml_LocationsBulkActionSetStoreUser($location_IDs = '', $newStoreUserValue = '') {
			global $wpdb;

			$this->debugMP('pr',__FUNCTION__.' started for location_IDs: ', $location_IDs);

			//assigning or removing newStoreUserValue for specified locations
			//
			// Make an array of locationIDs
			$theLocations = (!is_array($location_IDs)) ? array($location_IDs) : $theLocations = $location_IDs;
			
			// Define the new value to use
			$newValues = array();
			$newValues[SLPUserManagedLocations::SLP_UML_USER_SLUG] = $newStoreUserValue;

			// Process locationIDs Array
			//
			foreach ($theLocations as $locationID) {
				$this->slplus->currentLocation->set_PropertiesViaDB($locationID);
				if ($this->slplus->database->is_Extended()) {
					$this->slplus->database->extension->update_data($this->slplus->currentLocation->id, $newValues);
				}
			}
			$this->slplus->notifications->display();

		}

		/**
		 * Look to see if incoming Identifier data is already in the extended data set.
		 *
		 * @param mixed[] $location_data
		 */
		public function filter_CheckForPreExistingIdentifierUML($location_data) {

			$this->debugMP('msg',__FUNCTION__.' started.');
			return $location_data;
		}

		/**
		 * Render the User Managed Locations tab
		 */
		function render_AdminPage() {

			// Process the actions
			//
			$this->set_CurrentAction();
			$this->debugMP('msg',__FUNCTION__.' started for action =.' . $this->current_action);
			$this->process_Actions();

			// Show Notices
			//
			$this->slplus->notifications->display();

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
						'form_name'         => 'locationForm',
						'form_enctype'      => 'multipart/form-data',
						'no_save_button'    => true,
						'form_action'       => admin_url().'admin.php?page='.SLPUserManagedLocations::ADMIN_PAGE_SLUG
					)
			 );

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
			// User Manager
			//-------------------------
			$this->createobject_UserManager();
			$this->usermanager->prepare_items();
			$sectName = __('User Manager','csa-slp-uml');

			// Create the main settings group
			$sectionDivID    = 'manage_users';		// Same as used for Edit section
			$this->Settings->add_section(
				array(
					'name' => $sectName, 
					'show_label' => false, 
					'div_id' => $sectionDivID, 
					'innerdiv' => true));
			$this->Settings->add_ItemToGroup(
				array(
					'section'       => $sectName,
					'group'         => $sectName,
					'label'         => __('Manage the list of registered users','csa-slp-uml'),
					'type'          => 'subheader',
					'show_label'    => false,
					'description'   => $this->usermanager->display()
					)
				);


			//-------------------------
			// User Managed Locations Settings
			//-------------------------
			$this->render_UMLSettingsPage();

			//------------------------------------------
			// RENDER
			//------------------------------------------
			$this->Settings->render_settings_page();
		}

		/**
		 * Render the admin panel.
		 */
		function render_UMLSettingsPage() {

			//-------------------------
			// SLPUserManagedLocations Settings Panel
			//-------------------------
			$panelName  = __('Settings','csa-slp-uml');
			$this->Settings->add_section(array('name' => $panelName));

			$groupName  = __('Settings','csa-slp-uml');

			// Group : User Rights
			//
			$this->Settings->add_ItemToGroup(
				array(
					'section'       => $panelName,
					'group'         => $groupName,
					'label'         => __('User Rights','csa-slp-uml'),
					'type'          => 'subheader',
					'show_label'    => false,
					'description'   => '',
					)
				);
			$this->Settings->add_ItemToGroup(array(
					'section'       => $panelName,
					'group'         => $groupName,
					'type'          => 'slider',
					'setting'       => 'SLP_UML-uml_publish_location',
					'value'         => $this->addon->options['uml_publish_location'],
					'label'         => __('Publish Location Immediately','csa-slp-uml'),
					'description'   =>
						__('When enabled a newly entered location is published immediately.','csa-slp-uml') . ' ' .
						__('When disabled, the geocode of a newly entered location is removed to block publishing.','csa-slp-uml') . ' ' .
						sprintf(__('This needs the re-geocoding functionality of %s to publish blocked locations.','csa-slp-uml'),SLPLUS::linkToPRO)
				));


			//------------------------------------------
			// Group buttons
			//------------------------------------------

			$onClick = "AdminUI.doAction('save_settings','','locationForm' );";

			$buttonContent  = '';
			$buttonContent .= '<div id="slp_form_buttons" style="padding-left:188px;">';
			$buttonContent .= '<input name="act" type="hidden">';
			$buttonContent .= '<input type="submit" class="button-primary" style="width:150px;margin:3px;" ';
			$buttonContent .= 'value="'   . __('Save Settings','csa-slp-uml') . '" ';
			$buttonContent .= 'onClick="' . $onClick . '" ';
			$buttonContent .= 'alt="' . __('Save Settings','csa-slp-uml') . '" title="' . __('Save Settings','csa-slp-uml') . '" ';
			$buttonContent .= '>';
			$buttonContent .= '</div>';

			$this->Settings->add_ItemToGroup(array(
					'section'       => $panelName,
					'group'         => $groupName,
					'setting'       => 'uml_save_setting_button',
					'type'          => 'custom',
					'show_label'    => false,
					'custom'        => $buttonContent,
					'value'         => '',
					'label'         => __('UML Buttons', 'csa-slp-uml'),
					));

			// Settings : Explanation
			//
			$groupName = __('Documentation','csa-slp-uml') ;
			$this->Settings->add_ItemToGroup(
				array(
					'section'       => $panelName                   ,
					'group'         => $groupName                   ,
					'label'         => ''                           ,
					'type'          => 'subheader'                  ,
					'show_label'    => false                        ,
					'description'   =>
						sprintf(__('View the <a href="%s" target="csa">documentation</a> for more info. ','csa-slp-uml'),$this->addon->support_url)
					)
				);

		}

		/**
		 * Save our settings.
		 * @return type
		 */
		function save_UMLSettings() {
			$this->debugMP('msg',__FUNCTION__);
			$BoxesToHit = array(
				'uml_publish_location',
				);
			foreach ($BoxesToHit as $BoxName) {
				if (!isset($_REQUEST[SLPLUS_PREFIX.'-SLP_UML-'.$BoxName])) {
					$_REQUEST[SLPLUS_PREFIX.'-SLP_UML-'.$BoxName] = '';
				}
			}

			// Check options, then save them all in one place (serialized)
			//
			array_walk($_REQUEST,array($this,'isSLPUserManagedLocationsOption'));
			update_option(SLPUserManagedLocations::OPTION_NAME, $this->addon->options);

			$this->slplus->notifications->add_notice(
					9,
					__('Settings saved.','csa-slp-uml')
					);
			return;
		}

		/** ************************************************************************
		 * Process the actions for this request.
		 **************************************************************************/
		function process_Actions() {

			$this->current_action = $this->set_CurrentAction();
			$this->debugMP('msg',__FUNCTION__.': Process [' . $this->current_action . ']');

			if ( $this->current_action === '' ) { return; }

			switch ($this->current_action) {

				// Save the settings
				case 'save_settings':
					$this->save_UMLSettings();
					break;

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

		/**
		 * Set the user-managed-location options from the incoming REQUEST
		 *
		 * @param mixed $val - the value of a form var
		 * @param string $key - the key for that form var
		 */
		function isSLPUserManagedLocationsOption($val,$key) {
			$simpleKey = preg_replace('/^'.SLPLUS_PREFIX.'-SLP_UML-/','',$key);
			if ($simpleKey !== $key){
				$this->addon->options[$simpleKey] = $val;
			}
		 }

		/**
		 * Add the Store Locator panel to the admin sidebar for non-admin editors.
		 *
		 */
		function slp_user_managed_locations_admin_menu() {

			$this->debugMP('msg',__FUNCTION__.' started.');
			return;

		}

		//-------------------------------------
		// Methods : SLP Hooks
		//-------------------------------------

		/**
		 * Delete the extended data.
		 */
		function action_DeleteExtendedDataUML() {
			$this->debugMP('msg',__FUNCTION__);
			// This functionality is already handled by SLP Super Extendo hooks
		}

		/**
		 * Save the extended data after adding new or updating existing.
		 */
		function action_SaveExtendedDataUML() {
			$this->debugMP('msg',__FUNCTION__);

			// Remove the lat/long if user is store editor and noAdmin and publish rights are revoked
			//
			if ($this->addon->slp_uml_is_user(true)) {
				if (!$this->addon->options['uml_publish_location']) {
					$this->debugMP('msg',__FUNCTION__ . ' slp_uml_is_user() but user has no rights to publish immediately so remove lat/long.');
					$this->slplus->currentLocation->latitude = '';
					$this->slplus->currentLocation->longitude = '';
					$this->slplus->currentLocation->MakePersistent();
				} else {
					$this->debugMP('msg',__FUNCTION__ . ' slp_uml_is_user() and user has the rights to publish immediately.');
				}
			} else {
				$this->debugMP('msg',__FUNCTION__ . ' slp_uml_is_user() returned false so lat/long are not touched.');
			}

			// Check our extended columns and see if there is a matching property in exdata in currentLocation
			$newValues = array();

			// Store the current user login in the store_user field if user is store editor and noAdmin
			//
			if ($this->addon->slp_uml_is_user(true)) {
				$current_user = wp_get_current_user();
				$newValues[SLPUserManagedLocations::SLP_UML_USER_SLUG] = $current_user->user_login;
			} else {
				$this->debugMP('msg',__FUNCTION__ . ' slp_uml_is_user() returned false so store_user is not overwritten.');
			}

			// New values?  Write them to disk...
			if (count($newValues) > 0){
				$this->debugMP('pr',__FUNCTION__,$newValues);
				$this->createshorthand_SEDataObject();
				if ($this->slplus->database->is_Extended()) {
					$this->slplus->database->extension->update_data($this->slplus->currentLocation->id, $newValues);
				}
			} else {
				$this->debugMP('msg',__FUNCTION__ . ' No extended data overwritten.');
			}
		}

		/**
		 * Hide the Store User for a User Managed Locations
		 * 
		 * @param $theform
		 */
		function filter_AddExtendedDataToEditFormUML($theform) {
			$this->debugMP('msg',__FUNCTION__.' started for current Location: ' . $this->slplus->currentLocation->id);

			// Make the User Managed Locations columns hidden if store editor
			if ($this->addon->slp_uml_is_user(true)) {

				// Find and hide the label
				$patternText = "/label for='".SLPUserManagedLocations::SLP_UML_USER_SLUG."/";
				$replaceText = "label style='visibility:hidden!important' for=".SLPUserManagedLocations::SLP_UML_USER_SLUG;
				$new_form_tmp = preg_replace($patternText, $replaceText, $theform);
				$this->debugMP('msg','',' Made SED columns hidden, searched for:' . $patternText);

				// Find and hide the input field and set the default value to current user login value
				$curStoreUser = wp_get_current_user();
				$patternText = "/input type='text' id='edit-".SLPUserManagedLocations::SLP_UML_USER_SLUG."'([^>]*) value='[^>]*' /";
				$replaceText = "input type='hidden' id='edit-".SLPUserManagedLocations::SLP_UML_USER_SLUG."'$1 value='".$curStoreUser->user_login."' ";
				$new_form = preg_replace($patternText, $replaceText, $new_form_tmp);
				$this->debugMP('msg','',' Made SED columns hidden, searched for:' . $patternText);
				$this->debugMP('msg','',' Made SED columns hidden, to be replaced by:' . $replaceText);

			} else {
				// No changes
				$new_form = $theform;
			}

			return $new_form;
		}

		/**
		 * Removes the User Managed Locations columns for a User Managed Locations
		 * @param $current_cols array The current columns
		 */
		function filter_AddExtendedDataToLocationColumnsUML($current_cols) {
			$this->debugMP('pr',__FUNCTION__.' started for current_cols:',$current_cols);

			// Remove User Managed Locations columns if allowed user
			//if (!$this->slpuml->slp_uml_is_admin()) {
			if ($this->addon->slp_uml_is_user(true)) {
				$new_cols = $this->remove_UserManagedLocations_Fields($current_cols);
				$this->debugMP('pr',__FUNCTION__.' removed SED columns new_cols:',$new_cols);
			} else {
				// No changes
				$new_cols = $current_cols;
			}
			return $new_cols;
		}

		/**
		 * Allows editing of the extendo data for the location
		 * 
		 * @param $thedata  - option value field
		 * @param $thefield - The name of the field
		 * @param $thelabel - The column label
		 */
		function filter_ShowExtendedDataInColumnsUML($thedata, $thefield, $thelabel) {
	//		$this->debugMP('pr',__FUNCTION__.' started for theData:',$thedata);

			// This functionality is already handled by SLP Super Extendo hooks

			return $thedata;
		}

		//-------------------------------------
		// Methods : Object Management
		//-------------------------------------

		/**
		 * Create the data interface object.
		 */
		function remove_UserManagedLocations_Fields($sedColumns = array()) {
			$this->debugMP('msg',__FUNCTION__.' started.');

			// Remove the User Managed Locations fields from the set of columns
			unset($sedColumns[SLPUserManagedLocations::SLP_UML_USER_SLUG]);

			return $sedColumns;
		}

		/**
		 * Create the data interface object.
		 */
		function createobject_UserManager() {
			$this->debugMP('msg',__FUNCTION__.' started.');
			if (class_exists('SLPUML_AdminUI_UserManager') == false) {
				require_once('class.adminui.user_manager.php');
			}
			if (!isset($this->usermanager)) {
				$this->usermanager = new SLPUML_AdminUI_UserManager(array('slpuml' => $this->addon));
	//            $this->debugMP('msg',__FUNCTION__ . ' created:',$this->usermanager);
			}
		}

		/**
		 * Simplify the plugin debugMP interface.
		 *
		 * Typical start of function call: $this->debugMP('msg',__FUNCTION__);
		 *
		 * @param string $type
		 * @param string $hdr
		 * @param string $msg
		 */
		function debugMP($type,$hdr,$msg='') {
			if (($type === 'msg') && ($msg!=='')) {
				$msg = esc_html($msg);
			}
			if (($hdr!=='')) {
				$hdr = 'AdminUI: ' . $hdr;
			}
			$this->addon->debugMP($type,$hdr,$msg,NULL,NULL,true);
		}
	}
}
