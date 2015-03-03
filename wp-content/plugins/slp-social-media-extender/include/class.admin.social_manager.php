<?php
// Make sure the classes are only defined once.
//
if (!class_exists('WP_List_Table')){ require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' ); }
if (!class_exists('SLPSME_Social')){ require_once('class.social.php'); }

/**
 * The data interface helper.
 *
 * @package StoreLocatorPlus\SocialMediaExtender\AdminUI\SocialManager
 * @author De B.A.A.T. <slp-sme@de-baat.nl>
 * @copyright 2014 Charleston Software Associates, LLC - De B.A.A.T.
 *
 */
class SLPSME_Admin_SocialManager extends WP_List_Table {


	/**
	 * The base class for the SLP plugin
	 *
	 * @var \SLPlus $slplus
	 **/
	private $slplus;

	/**
	 * The base class for the parent SME class
	 *
	 * @var \SLPSocialMediaExtender $addon
	 **/
	private $addon;

	/**
	 * Pointer to the AdminUI object for this plugin.
	 * 
	 * @var \SLPSME_Admin
	 */
	var $parent;

	/**
	 *
	 * @var string $baseAdminURL
	 */
	public $baseAdminURL = '';

	/**
	 *
	 * @var string $cleanAdminURl
	 */
	public $cleanAdminURL = '';

	/**
	 * The manage socials URL with params we like to keep such as page number and sort order.
	 * 
	 * @var string $hangoverURL
	 */
	public $hangoverURL = '';

	/**
	 * The order by direction for the order by clause.
	 * 
	 * @var string
	 */
	private $db_orderbydir = '';

	/**
	 * Order by field for the order by clause.
	 * 
	 * @var string
	 */
	private $db_orderbyfield = '';

	/**
	 * Where clause for the social selections.
	 * 
	 * @var string
	 */
	private $db_where = '';

	/**
	 * Start listing socials from this record offset.
	 *
	 * @var int
	 */
	private $start = 0;

	/**
	 * Total Socials on list.
	 * 
	 * @var int
	 */
	private $totalSocials = 0;

	/**
	 * The wpCSL settings object that helps render social settings.
	 *
	 * @var \wpCSL_settings__slplus $settings
	 */
//    public $settings;

	/**
	 * Where clause for the social selections.
	 * 
	 * @var string
	 */
	private $csl_separator = '--';

	//-------------------------------------
	// Methods : Base
	//-------------------------------------

	/**
	 * Initialize the List Table
	 *
	 * @param mixed[] $params
	 */
	public function __construct($params=null) {
		if (($params != null) && is_array($params)) {
			foreach ($params as $key=>$value) {
				$this->$key = $value;
			}
		}
		parent::__construct( array(
			'singular' => 'social',
			'plural'   => 'socials',
			'ajax'     => false
		) );

		// Get the currentAction
//		$this->set_CurrentAction();

		// Set our base Admin URL
		//
		if (isset($_SERVER['REQUEST_URI'])) {
			$this->cleanAdminURL =
				isset($_SERVER['QUERY_STRING'])?
					str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']) :
					$_SERVER['REQUEST_URI']
					;

			$queryParams = array();

			// Base Admin URL = must have params
			//
			if (isset($_REQUEST['page'])) { $queryParams['page'] = $_REQUEST['page']; }
			$this->baseAdminURL = $this->cleanAdminURL . '?' . build_query($queryParams);


			// Hangover URL = params we like to carry around sometimes
			//
			if ( $this->parent->current_action === 'show_all' ){
				$_REQUEST['searchfor'] = '';
			}
			if (isset($_REQUEST['searchfor' ]) && !empty($_REQUEST['searchfor']     )){
				$queryParams['searchfor']  = $_REQUEST['searchfor'];
			}
			if (isset($_REQUEST['start'     ]) && ((int)$_REQUEST['start'] >= 0     )){
				$queryParams['start']      = $_REQUEST['start']    ;
			}
			if (isset($_REQUEST['orderBy'   ]) && !empty($_REQUEST['orderBy']       )) {
				$queryParams['orderBy'] = $_REQUEST['orderBy'];
			}
			if (isset($_REQUEST['sortorder' ]) && !empty($_REQUEST['sortorder']     )) {
				$queryParams['sortorder'] = $_REQUEST['sortorder'];
			}

			$this->hangoverURL = $this->cleanAdminURL . '?' . build_query($queryParams);

			$this->debugMP('msg',__FUNCTION__);
			$this->debugMP('msg','','cleanAdminURL: '.$this->cleanAdminURL);
			$this->debugMP('msg','','baseAdminURL:  '.$this->baseAdminURL);
			$this->debugMP('msg','','hangoverURL:   '.$this->hangoverURL);
		}

		// Create a standard wpCSL settings interface.
		// It has better UI management features than the custom versions prevelant in legacy code.
		//
//		$this->debugMP('msg','','Create new wpCSL_settings__slplus for locationForm');
//		$this->settings = new wpCSL_settings__slplus(
//			array(
//					'parent'            => $this->slplus,
//					'prefix'            => $this->slplus->prefix,
//					'css_prefix'        => $this->slplus->prefix,
//					'url'               => $this->slplus->url,
//					'name'              => $this->slplus->name . __(' - Social Objects','csa-slp-sme'),
//					'plugin_url'        => $this->slplus->plugin_url,
//					'render_csl_blocks' => false,
//					'form_action'       => $this->baseAdminURL,
//					'no_save_button'    => true,
//					'form_name'         => 'locationForm'
//				)
//		 );
	}

	/**
	 * Used to help set column labels and output structure.
	 *
	 * @return mixed[]
	 */
	function get_columns() {
		// Get all fields of the SLPSME_Social object as column
		$columns = array(
			'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
		);
		$dbColumns = $this->addon->helperSocial->get_dbFieldsNamesDB();
		foreach ($dbColumns as $slug => $name) {
			$columns[$slug] = $name;
		}
		return $columns;
	}

	/**
	 * Used to help set column meta data about which table columns should be hidden.
	 *
	 * @return mixed[]
	 */
	function get_hidden_columns() {
		$hidden_columns = array(
		);
		return $hidden_columns;
	}

	/**
	 * Used to help set column meta data about which table columns can be sorted.
	 *
	 * @return mixed[]
	 */
	function get_sortable_columns() {
		// Get all fields of the SLPSME_Social object as column
		$dbColumns = $this->addon->helperSocial->get_dbFieldsNamesDB();

		// Make all columns sortable
		$sortable_columns = array();
		foreach ($dbColumns as $slug => $name) {
			if ($slug == 'sl_social_name') {
				$sortable_columns[$slug] = array($slug,true);     //true means it's already sorted
			} else {
				$sortable_columns[$slug] = array($slug,false);
			}
		}
		return $sortable_columns;
	}

	/**
	 * Output the special checkbox column.
	 * @param mixed[] $item
	 * @return string
	 */
	function column_cb($item){
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("social")
			/*$2%s*/ $item['sl_id']         //The value of the checkbox should be the record's id
			);
	}

	/**
	 * Output the column showing the sl_social_name.
	 * @param mixed[] $item
	 * @return string
	 */
	function column_sl_id($item){

		$socID = $item['sl_id'];
		$this->hangoverURL = '?page=' . $_REQUEST['page'];
		// create Action Buttons
//				href='".$this->hangoverURL."#wpcsl-option-add_social_media&act=edit&social=$socID'></a>"
		$editActionButtonsHTML =
			'<a class="action_icon edit_icon" alt="' . __( 'Edit'  ,'csa-slp-sme' ) . '" title="' . __( 'Edit'  ,'csa-slp-sme' ) . '" ' . 
				'href="' . $this->hangoverURL . '&act=edit&social=' . $socID . '" ' .
				'></a>'
			;
		$deleteActionButtonsHTML =
			'<a class="action_icon delete_icon" alt="' . __( 'Delete','csa-slp-sme' ) . '" title="' . __( 'Delete','csa-slp-sme' ) . '" ' .
				'href="' . $this->hangoverURL . '&act=delete&social=' . $socID . '" ' .
				'onclick="AdminUI.confirmClick(\'' . sprintf(__('Delete %s?','csa-slp-sme'),$item['sl_social_name']) . '\', this.href); return false;"' . 
				'></a>'
			;
		//Build row actions
		$actions = array(
			'edit'     => $editActionButtonsHTML,
			'delete'   => $deleteActionButtonsHTML,
		);

//		//Build row actions
//        $actions = array(
//            'edit'     => sprintf('<a href="?page=%s&action=%s&social=%s">' . __( 'Edit'  ,'csa-slp-sme' ) . '</a>',$_REQUEST['page'],'edit',$item['id']),
//            'delete'   => sprintf('<a href="?page=%s&action=%s&social=%s">' . __( 'Delete','csa-slp-sme' ) . '</a>',$_REQUEST['page'],'delete',$item['id']),
//        );

		//Return the title contents
		return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
			/*$1%s*/ $item['sl_id'],
			/*$2%s*/ $item['sl_id'],
//			/*$3%s*/ $actions
			/*$3%s*/ $this->row_actions($actions)
		);
	}

	/**
	 *
	 * @param type $item
	 * @param type $column_name
	 */
	function column_default($item,$column_name) {
		//$this->debugMP('pr',__FUNCTION__.' column_default ' . $column_name . ' for item:',$item);
		switch ($column_name) {
			case 'sl_icon':
				// Check whether the value represents an image
				if ($this->addon->url_test($item[$column_name])) {
					return "<img id='social_icon_preview' src='" . $item[$column_name] . "' align='top'>";
				} else {
					return $item[$column_name];
				}
				break;
			case 'id':
			case 'social_name':
			case 'social_slug':
			default:
				return $item[$column_name];
				break;
		}
	}

	/** ************************************************************************
	 * Optional. If you need to include bulk actions in your list table, this is
	 * the place to define them. Bulk actions are an associative array in the format
	 * 'slug'=>'Visible Title'
	 * 
	 * If this method returns an empty value, no bulk action will be rendered. If
	 * you specify any bulk actions, the bulk actions box will be rendered with
	 * the table automatically on display().
	 * 
	 * Also note that list tables are not automatically wrapped in <form> elements,
	 * so you will need to create those manually in order for bulk actions to function.
	 * 
	 * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
	 **************************************************************************/
	function get_bulk_actions() {
		$actions = array(
			'edit'     => __( 'Edit',  'csa-slp-sme' ),
			'delete'   => __( 'Delete Permanently','csa-slp-sme' )
		);
		return $actions;
	}


	/** ************************************************************************
	 * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
	 * For this example package, we will handle it in the class to keep things
	 * clean and organized.
	 * 
	 * @see $this->prepare_items()
	 **************************************************************************/
	function process_bulk_action() {

		if (!isset($_REQUEST['social'])) { return false; }
		$socialValue = $_REQUEST['social'];
		if (is_array($socialValue)) {
			$socialValues = $socialValue;
		} else {
			$socialValues[] = $socialValue;
		}
		$this->debugMP('pr',__FUNCTION__.': Process [' . $this->parent->current_action . '] for socials :',$socialValues);

//        //Detect when and which bulk action is being triggered...
//        if( 'edit'===$this->AdminUI->current_action ) {
//			$this->debugMP('pr',__FUNCTION__.' Edit socials :',$socialValues);
////			foreach ($socialValues as $curSocial) {
////				$this->plugin->slp_sme_social_allow($curSocial);
////			}
//        }
//        if( 'delete'===$this->AdminUI->current_action ) {
//			$this->debugMP('pr',__FUNCTION__.' Delete socials :',$socialValues);
////			foreach ($socialValues as $curSocial) {
////				$this->plugin->slp_sme_social_disallow($curSocial);
////			}
//        }

		if ( $this->parent->current_action === '' ) { return; }

		switch ($this->parent->current_action) {

			// ADD
			//
//			case 'add' :
//				$this->social_Add();
//				break;

			// DELETE
			//
			case 'delete':
				//$socialList = is_array($_REQUEST['sl_id'])?$_REQUEST['sl_id']:array($_REQUEST['sl_id']);
				$this->debugMP('pr',__FUNCTION__ . " Delete Action: for :",$socialValues);
				foreach ($socialValues as $socialID) {
					$this->addon->helperSocial->set_PropertiesViaDB($socialID);
					$this->addon->helperSocial->debugProperties();
					$this->addon->helperSocial->DeletePermanently();
				}
				break;

			// Stuff that is not an exact string match
			//
			default:

				// TODO: Move To Pro Pack
				//
				$this->debugMP('msg',__FUNCTION__,"Unsupported Bulk Action: {" . $this->parent->current_action . "}");
//                if ( preg_match( '#tag#i' , $this->AdminUI->current_action ) ) {
//                    if (isset($_REQUEST['sl_id'])) { $this->social_tag($_REQUEST['sl_id']); }
//                }
				break;
		}
		do_action('slp_manage_socials_action');
	}

	/**
	 * Get the list from the output buffer of parent method.
	 *
	 * @return string
	 */
	function display() {
		ob_start();
		//<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
		// Form is now generated by the social navbar
//		echo '<form id="socials-filter" method="get">';
			//<!-- For plugins, we also need to ensure that the form posts back to our current page -->
			echo '<input type="hidden" name="page" value="' . $_REQUEST['page'] . '" />';
			//<!-- Now we can render the completed list table -->
			parent::display();
		// Close the form for the Social Manager
//		echo '</form>';
		return ob_get_clean();
	}

	/**
	 * No extendo socials found.
	 */
	function no_items() {
		_e( 'No socials were found.', 'csa-slp-sme');
	}

	/**
	 * Fetch the socials from the database.
	 */
	function prepare_items() {

		// If there are searches added at a later date
		// this array can have where SQL commands added
		// to filter the return results
		//
		$this->debugMP('msg',__FUNCTION__.' started.');

		/**
		 * First, lets decide how many records per page to show
		 */
		$per_page = 20;

		// Define the columns to use
		$columns  = $this->get_columns();
		$hidden   = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();
		//$this->debugMP('pr',__FUNCTION__.' $columns:',$columns);
		//$this->debugMP('pr',__FUNCTION__.' $hidden:',$hidden);
		//$this->debugMP('pr',__FUNCTION__.' $sortable:',$sortable);

		$this->_column_headers = array($columns, $hidden, $sortable);

		/**
		 * Optional. You can handle your bulk actions however you see fit. In this
		 * case, we'll handle them within our package just to keep things clean.
		 */
		$this->process_bulk_action();

		// Query the socials as a copy from WP_List_Table
		//$args = array(
		//	'fields' => 'all_with_meta'
		//);
		//$this->debugMP('pr',__FUNCTION__ . ': $args= ',$args);

		// Create the data to show in the table
		$table_data = $this->addon->get_SocialObjects();
		$this->debugMP('pr',__FUNCTION__ . ': tableData= ',$table_data);

		/**
		 * REQUIRED for pagination. Let's figure out what page the social is currently 
		 * looking at. We'll need this later, so you should always include it in 
		 * your own package classes.
		 */
		$current_page = $this->get_pagenum();

		/**
		 * REQUIRED for pagination. Let's check how many items are in our data array. 
		 * In real-world use, this would be the total number of items in your database, 
		 * without filtering. We'll need this later, so you should always include it 
		 * in your own package classes.
		 */
		$total_items = count($table_data);


		/**
		 * The WP_List_Table class does not handle pagination for us, so we need
		 * to ensure that the data is trimmed to only the current page. We can use
		 * array_slice() to 
		 */
		$table_data = array_slice($table_data,(($current_page-1)*$per_page),$per_page);



		/**
		 * REQUIRED. Now we can add our *sorted* data to the items property, where 
		 * it can be used by the rest of the class.
		 */
		$this->items = $table_data;

		$this->set_pagination_args( array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
			'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
		) );
	}

	//-------------------------------------
	// Methods : Added for Social Editor
	//-------------------------------------


	/**
	 * Returns the string that is the Social Info Form guts.
	 *
	 * @param bool $addform - true if rendering add socials form
	 */
	function get_FormSocialData($addform=false) {
		$this->debugMP('msg',__FUNCTION__,($addform?'add':'edit').' mode.');
		$addingSocial = true;

		// Determin whether to add or edit
		$curAction = $this->set_CurrentAction();
		if (($curAction == 'edit') || ($addform == false)) {
			$addingSocial = false;
		}

		// Get the existing data to edit from the url if present
		if ( isset($_REQUEST['social'])) {
			if (is_array($_REQUEST['social'])) {
				$idString = $_REQUEST['social'][0];
			} else {
				$idString = $_REQUEST['social'];				
			}
//			$this->addon->helperSocial->set_PropertiesViaDB($idString);
		}

//		// Check whether we have a valid helperSocial
//		if (!$this->addon->helperSocial->isvalid_ID()) { 
//			$addingSocial = true;
//		}

		// Create a new helperSocial when adding
		//
		if ($addingSocial) {
			// Create a new Social Object to add
			$this->debugMP('msg','set social data to blank...','');
			$this->addon->helperSocial = new SLPSME_Social(array(
													'addon'     => $this->addon,
													'slplus'    => $this->slplus,
													));
			$idString = '';
		} else {
			$idString = $this->addon->helperSocial->id;
		}
		return $addingSocial;
	}

	/**
	 * Returns the string that is the Social Info Form guts.
	 *
	 * @param bool $addform - true if rendering add socials form
	 */
	function render_SocialManagePage($addform=false) {
		$this->debugMP('msg',__FUNCTION__,' Manage mode.');

		$this->prepare_items();
		$sectName = __('Manage Social Media','csa-slp-sme');

		// Create the main settings group
		$sectionDivID    = 'manage_social_media';		// Same as used for Edit section
		$this->parent->Settings->add_section(array('name' => $sectName, 'show_label' => false, 'div_id' => $sectionDivID, 'innerdiv' => true));
		$this->parent->Settings->add_ItemToGroup(
			array(
				'section'       => $sectName,
				'group'         => $sectName,
				'label'         => __('Manage the list of registered socials','csa-slp-sme'),
				'type'          => 'subheader',
				'show_label'    => false,
				'description'   => $this->parent->adminSocialManager->display()
				)
			);
	}

	/**
	 * Returns the string that is the Social Info Form guts.
	 *
	 * @param bool $addform - true if rendering add socials form
	 */
	function render_SocialAddEditPage($addform=false) {
		$this->debugMP('msg',__FUNCTION__,($addform?' Add':' Edit').' mode.');

		// Get the data to populate the form
//		$addingSocial   = $this->get_FormSocialData($addform);
		$addingSocial   = $addform;
		if ($addingSocial) {
			$addingAction   = 'add';
			$sectionDivID    = 'add_social_media';
			$settingID      = '';
			$addingSection  = __('Add Social Media','csa-slp-sme');
			$addingButton   = __('Add','csa-slp-sme');
			$this->debugMP('pr',__FUNCTION__ . ' ' . $addingAction . ' for helperSocial debugProperties :', $this->addon->helperSocial->debugProperties());

			$edResetURL     = admin_url().'admin.php?page='.SLPSocialMediaExtender::ADMIN_PAGE_SLUG . "#wpcsl-option-add_social_media";
			$edCancelURL    = admin_url().'admin.php?page='.SLPSocialMediaExtender::ADMIN_PAGE_SLUG;
		} else {
			$addingAction   = 'update';
			$sectionDivID    = 'manage_social_media';		// Same as used for Manage section
			$settingID      = $this->addon->helperSocial->id;
			$addingSection  = __('Edit Social Media','csa-slp-sme');
			$addingButton   = __('Update','csa-slp-sme');
			$this->debugMP('pr',__FUNCTION__ . ' ' . $addingAction . ' for helperSocial debugProperties :', $this->addon->helperSocial->debugProperties());

			$edResetURL     = isset( $_REQUEST['social'] ) ?
				preg_replace('/&id='.$_REQUEST['social'].'/', '',$_SERVER['REQUEST_URI']) :
				$_SERVER['REQUEST_URI'];
			$edCancelURL    = admin_url().'admin.php?page='.SLPSocialMediaExtender::ADMIN_PAGE_SLUG;
		}

		// Create the form.
		//

		//-------------------------
		// Add or Edit Social Object main group
		//-------------------------
		$this->parent->Settings->add_section(array('name' => $addingSection, 'show_label' => false, 'div_id' => $sectionDivID, 'innerdiv' => true));

		// Set some hidden fields
		$hiddenCustomContent  = "";
		$hiddenCustomContent .= "<input type='hidden' name='act' value='" . $addingAction . "' />";
		$hiddenCustomContent .= ( isset($_REQUEST['start'])     ? "<input type='hidden' name='start'     id='start'     value='{$_REQUEST['start']}'     />" : '' );
		$hiddenCustomContent .= ( isset($_REQUEST['page'])      ? "<input type='hidden' name='page'      id='page'      value='{$_REQUEST['page']}'      />" : '' );
		$hiddenCustomContent .= ( isset($_REQUEST['orderby'])   ? "<input type='hidden' name='orderby'   id='orderby'   value='{$_REQUEST['orderby']}'   />" : '' );
		$hiddenCustomContent .= ( isset($_REQUEST['searchfor']) ? "<input type='hidden' name='searchfor' id='searchfor' value='{$_REQUEST['searchfor']}' />" : '' );
		$hiddenCustomContent .= ( isset($_REQUEST['sortorder']) ? "<input type='hidden' name='sortorder' id='sortorder' value='{$_REQUEST['sortorder']}' />" : '' );
		if (!$addingSocial) {
			$hiddenCustomContent .= "<input type='hidden' name='social' ";
			$hiddenCustomContent .= "id='social' value='" . $this->addon->helperSocial->id . "' />";
			$hiddenCustomContent .= "<input type='hidden' name='social_slug-{$this->addon->helperSocial->id}' ";
			$hiddenCustomContent .= "id='social_slug-{$this->addon->helperSocial->id}' ";
			$hiddenCustomContent .= "value='" . $this->addon->helperSocial->social_slug . "' />";
		}

		// ===== Social Icon Picker
		//
		$socialIconSetting = $this->create_SettingsSetting('icon', $addingAction, $settingID);
		$socialIconPreview = 'social_icon_preview_' . $addingAction;
		$socialIconImage   = $addingSocial ? '' : $this->addon->helperSocial->icon;
		$socialIconPicker  = $this->parent->social_CreateIconSelector($socialIconSetting,$socialIconPreview);
		$socialIconCustomContent =
					"<div class='form_entry'>".
						"<label for='sl_social_icon'>".__('Social Marker', 'csa-slp-sme')."</label>".
						"<input id='" . $socialIconSetting . "' name='" . $socialIconSetting . "' dir='rtl' size='45' ".
								"value='" . $socialIconImage . "' ".
								'onchange="document.getElementById(\'prev\').src=this.value">'.
						"<img id='" . $socialIconPreview . "' src='" . $socialIconImage . "' align='top'><br/>".
						$socialIconPicker.
					"</div>".
					'<br/><p>'.
					__('Saved social icons live here: ','csa-slp-sme') . $this->addon->options['social_icon_location'];
			;
		$this->debugMP('msg',__FUNCTION__ . ' $socialIconPicker = ',$socialIconPicker);
		$this->debugMP('msg',__FUNCTION__ . ' $slpDescription = ',$socialIconCustomContent);

		// Group : Results
		//
		$groupName  = $addingSection;
		$this->parent->Settings->add_ItemToGroup(array(
				'section'       => $addingSection,
				'group'         => $groupName,
				'setting'       => $this->create_SettingsSetting('social_name', $addingAction, $settingID),
				'type'          => 'text',
				'value'         => $addingSocial ? '' : $this->addon->helperSocial->social_name,
				'label'         => __('Social Name', 'csa-slp-sme'),
				'description'   => __('The name of the social medium.', 'csa-slp-sme')
				));
		// The social_slug is not editable, can only be added
		if ($addform) {
			$this->parent->Settings->add_ItemToGroup(array(
					'section'       => $addingSection,
					'group'         => $groupName,
					'type'          => 'text',
					'setting'       => $this->create_SettingsSetting('social_slug', $addingAction, $settingID),
					'value'         => $addingSocial ? '' : $this->addon->helperSocial->social_slug,
					'label'         => __('Social Slug', 'csa-slp-sme'),
					'description'   => __('The slug for this social medium.', 'csa-slp-sme')
					));
		}
		$this->parent->Settings->add_ItemToGroup(array(
				'section'       => $addingSection,
				'group'         => $groupName,
				'setting'       => $this->create_SettingsSetting('description', $addingAction, $settingID),
				'type'          => 'textarea',
				'value'         => $addingSocial ? '' : $this->addon->helperSocial->description,
				'label'         => __('Description', 'csa-slp-sme'),
				'description'   => __('The description for this social medium.', 'csa-slp-sme')
				));
		$this->parent->Settings->add_ItemToGroup(array(
				'section'       => $addingSection,
				'group'         => $groupName,
				'setting'       => $this->create_SettingsSetting('base_url', $addingAction, $settingID),
				'type'          => 'text',
				'value'         => $addingSocial ? '' : $this->addon->helperSocial->base_url,
				'label'         => __('Social Base URL', 'csa-slp-sme'),
				'description'   => __('The base url for this social medium, e.g. http://twitter.com.', 'csa-slp-sme')
				));
		$this->parent->Settings->add_ItemToGroup(array(
				'section'       => $addingSection,
				'group'         => $groupName,
				'setting'       => $this->create_SettingsSetting('social_hidden', $addingAction, $settingID),
				'type'          => 'custom',
				'show_label'    => false,
				'custom'        => $hiddenCustomContent,
				'value'         => $addingSocial ? '' : $this->addon->helperSocial->id,
				'label'         => __('Social Hidden', 'csa-slp-sme'),
				));
		$this->parent->Settings->add_ItemToGroup(array(
				'section'       => $addingSection,
				'group'         => $groupName,
				'setting'       => $socialIconSetting,
				'type'          => 'custom',
				'value'         => $socialIconImage,
				'label'         => __('Social Icon', 'csa-slp-sme'),
				'description'   => __('The url to the icon for this social medium.', 'csa-slp-sme'),
				'custom'        => $socialIconCustomContent,
				));
		
		
		//------------------------------------------
		// Group buttons
		//------------------------------------------

		$onClick = ($addingSocial) ?
				"AdminUI.doAction('add' ,'','locationForm');"    :
				"AdminUI.doAction('save','','locationForm' );"    ;

		$buttonContent  = "";
		$buttonContent .= ($addingSocial ? '' : "<span class='slp-edit-location-id'>Social Media # " . $this->addon->helperSocial->id . "</span>");
		$buttonContent .= "<div id='slp_form_buttons' style='padding-left:188px;'>";
		$buttonContent .= "<input type='submit' class='button-primary' style='width:150px;margin:3px;' ";
		$buttonContent .= 'value="'   . $addingButton . '" ';
		$buttonContent .= 'onClick="' . $onClick . '" ';
		$buttonContent .= "' alt='" . $addingButton . "' title='" . $addingButton . "'";
		$buttonContent .= ">";
		$buttonContent .= "<input type='button' class='button' style='width:150px;margin:3px;' ";
		$buttonContent .= "value='" . __('Cancel', 'csa-slp-sme') . "' ";
//		$buttonContent .= "onclick='social.href=\"".$edCancelURL."\"'>";
		$buttonContent .= "onclick='location.href=\"".$edCancelURL."\"'>";
		// Add Reset Form button on edit screen only
		if (!$addingSocial) {
			$buttonContent .= "<input type='button' class='button' style='width:150px;margin:3px;' ";
			$buttonContent .= "value='" . __('Reset Form', 'csa-slp-sme') . "' ";
//			$buttonContent .= "onclick='social.href=\"".$edCancelURL."\"'>";
			$buttonContent .= "onclick='location.href=\"".$edResetURL."\"'>";
		}
		$buttonContent .= "</div>";

		$this->parent->Settings->add_ItemToGroup(array(
				'section'       => $addingSection,
				'group'         => $groupName,
				'setting'       => $this->create_SettingsSetting('social_buttons', $addingAction, $settingID),
				'type'          => 'custom',
				'show_label'    => false,
				'custom'        => $buttonContent,
				'value'         => $addingSocial ? '' : $this->addon->helperSocial->id,
				'label'         => __('Social Buttons', 'csa-slp-sme'),
				));

		//------------------------------------------
		// RENDER
		//------------------------------------------
		//$this->parent->Settings->render_settings_page();

	}

	/**
	 * Returns the string that is the Social Info Form guts.
	 *
	 * @param bool $addform - true if rendering add socials form
	 */
	function display_SocialAddEditForm_Manual($addform=false) {
		$this->debugMP('msg',__FUNCTION__,($addform?'add':'edit').' mode.');

		// Get the data to populate the form
		$addingSocial = $this->get_FormSocialData($addform);
		$addingAction = $addingSocial ? 'add' : 'edit';
		$this->debugMP('pr',__FUNCTION__ . ' ' . $addingAction . ' for helperSocial debugProperties :', $this->addon->helperSocial->debugProperties());

		// Create the form.
		//
		$formContent  = "";
		$formContent .= "<form id='manualAddForm' name='manualAddForm' method='post'>";
		$formContent .= "<input type='hidden' name='act' value=" . $addingAction . " />";
		$formContent .= "<input type='hidden' name='social' ";
		$formContent .= "id='social' value='{$this->addon->helperSocial->id}' />";
		$formContent .= "<input type='hidden' name='social_slug-{$this->addon->helperSocial->id}' ";
		$formContent .= "id='social_slug-{$this->addon->helperSocial->id}' ";
		$formContent .= "value='" . $this->addon->helperSocial->social_slug . "' />";
		$formContent .= ( isset($_REQUEST['start'])  ? "<input type='hidden' name='start' id='start' value='{$_REQUEST['start']}' />" : '' );
		$formContent .= "<a name='a{$this->addon->helperSocial->id}'></a>";
		$formContent .= "<table cellpadding='0' class='slp_socialinfoform_table'>";
		$formContent .= "<tr>";

		// Left Cell
		$formContent .= "<td id='slp_manual_update_table_left_cell' valign='top'>";
		$formContent .= "<div id='slp_edit_left_column' class='add_social_form'>";

		// Create the Social Fields and buttons
		$formContent .= $this->display_AddEditSocial_Fields($addingSocial);
		$formContent .= $this->display_AddEditSocial_Submit($addingSocial);

		$formContent .= '</div>';
		$formContent .= '</td>';
		$formContent .= '</tr></table>';

		// FILTER: slp_add_social_form_footer
		$formContent .= ($addingSocial?apply_filters('slp_add_social_form_footer', ''):'');

		$formContent .= '</form>';

		// FILTER: slp_socialinfoform
		//
		return apply_filters('slp_socialinfoform',$formContent);

	}

	//-------------------------------------
	// createstring Methods
	//-------------------------------------

	/**
	 * Create HTML string for hidden inputs we need to keep track of filters, etc.
	 *
	 * @return string $HTML
	 */
	function createstring_HiddenInputs() {
		$html = '';
		$onlyHide = array('start');
		foreach($_REQUEST as $key=>$val) {
			if (!in_array($key,$onlyHide,true)) { continue; }
			$html.="<input type='hidden' value='$val' id='$key' name='$key'>\n";
		}
		return $html;
	}

	/**
	 * Create the add/edit form field.
	 *
	 * Leave fldLabel blank to eliminate the leading <label>
	 *
	 * inType can be 'input' (default) or 'textarea'
	 *
	 * @param string $fldName name of the field, base name only
	 * @param string $fldLabel label to show ahead of the input
	 * @param string $fldValue
	 * @param string $inputclass class for input field
	 * @param boolean $noBR skip the <br/> after input
	 * @param string $inType type of input field (default:input)
	 * @return string the form HTML output
	 */
	function createstring_InputElement($fldName,$fldLabel,$fldValue, $inputClass='', $noBR = false, $inType='input') {
		$matches = array();
		$matchStr = '/(.+)\[(.*)\]/';
		if (preg_match($matchStr,$fldName,$matches)) {
			$fldName = $matches[1];
			$subFldName = '['.$matches[2].']';
		} else {
			$subFldName='';
		}
		return
			(empty($fldLabel)?'':"<label  for='{$fldName}-{$this->addon->helperSocial->id}{$subFldName}'>{$fldLabel}</label>").
			"<{$inType} "                                                                .
				"id='edit-{$fldName}-{$this->addon->helperSocial->id}{$subFldName}' "                                     .
				"name='{$fldName}-{$this->addon->helperSocial->id}{$subFldName}' "   .
				(($inType==='input')?
						"value='".esc_html($fldValue)."' "  :
						"rows='5' cols='17'  "
				 )                                                          .
				(empty($inputClass)?'':"class='{$inputClass}' ")            .
			'>'                                                             .
			(($inType==='textarea')?esc_textarea($fldValue):'')             .
			(($inType==='textarea')?'</textarea>'   :'')                    .
			($noBR?'':'<br/>')
			;
	}

	/**
	 * Add the left column to the add/edit socials form.
	 *
	 * @param string $HTML the html of the base form.
	 * @return string HTML of the form inputs
	 */
	function display_AddEditSocial_Fields($addingSocial) {

		$content = 
			$this->createstring_InputElement(
				'social_name',
				__('Social Name', 'csa-slp-sme'),
				$this->addon->helperSocial->social_name
				).
			$this->createstring_InputElement(
				'social_slug',
				__('Social Slug', 'csa-slp-sme'),
				$this->addon->helperSocial->social_slug
				).
			$this->createstring_InputElement(
				'description',
				__('Description', 'csa-slp-sme'),
				$this->addon->helperSocial->description,
				'',
				false,
				'textarea'
				).
			$this->createstring_InputElement(
				'base_url',
				__('Base URL', 'csa-slp-sme'),
				$this->addon->helperSocial->base_url
				).
			$this->createstring_InputElement(
				'icon',
				__('Icon', 'csa-slp-sme'),
				$this->addon->helperSocial->icon
				).
			'';
		return $content;
	}

	/**
	 * Put the add/cancel button on the add/edit socials form.
	 *
	 * This is rendered AFTER other HTML stuff.
	 *
	 * @param string $HTML the html of the base form.
	 * @return string HTML of the form inputs
	 */
	function display_AddEditSocial_Submit($addingSocial) {
		$this->debugMP('msg',__FUNCTION__,'Value of $addingSocial' . $addingSocial);

		$edCancelURL = isset( $_REQUEST['social'] ) ?
			preg_replace('/&id='.$_REQUEST['social'].'/', '',$_SERVER['REQUEST_URI']) :
			$_SERVER['REQUEST_URI']
			;
		$alTitle =
			($addingSocial?
				__('Add Social','csa-slp-sme'):
				sprintf("%s #%d",__('Update Social', 'csa-slp-sme'),$this->addon->helperSocial->id)
			);

		$value   =
				($addingSocial)    ?
				__('Add'   ,'csa-slp-sme')  :
				__('Update','csa-slp-sme')  ;

		$onClick =
				($addingSocial)                             ?
//				"AdminUI.doAction('add' ,'','manualAddForm');"    :
//				"AdminUI.doAction('save','','socialForm');"    ;
				"AdminUI.doAction('add' ,'','locationForm');"    :
				"AdminUI.doAction('save','','locationForm');"    ;
		$this->debugMP('msg','','Value of edCancelURL: ' . $edCancelURL);
		$this->debugMP('msg','','Value of alTitle:     ' . $alTitle);
		$this->debugMP('msg','','Value of value:       ' . $value);
		$this->debugMP('msg','','Value of onClick:     ' . $onClick);

		$content  = "";
		$content .= ($addingSocial? '' : "<span class='slp-edit-social-id'>Social # " . $this->addon->helperSocial->id . "</span>");
		$content .= "<div id='slp_form_buttons'>";
		$content .= "<input type='submit' value='"  .$value  ."' onClick='" . $onClick . "' ";
		$content .= "' alt='" . $alTitle . "' title='" . $alTitle . "' class='button-primary'";
		$content .= ">";
		$content .= "<input type='button' class='button' value='" . __('Cancel', 'csa-slp-sme') . "' onclick='social.href=\"" . $edCancelURL . "\"'>";
		$content .= "<input type='hidden' name='option_value-" . $this->addon->helperSocial->id . "' ";
		$content .= "value='" . ($addingSocial?'':$this->addon->helperSocial->option_value);
		$content .= "' />";
		$content .= "</div>";

		return $content;
	}

	// Add a social
	//
	function social_Add() {
		$this->debugMP('msg',__FUNCTION__);

		//Inserting addresses by manual input
		//
		$socialData = array();
		if ( isset($_POST['social_name-']) && !empty($_POST['social_name-'])) {
			foreach ($_POST as $key => $sl_value) {
				if (preg_match('#\-$#', $key)) {
//                    $fieldName='sl_'.preg_replace('#\-$#','',$key);
					$fieldName = 'sl_' . $this->get_SettingsSettingKey($key, 'add');
					$socialData[$fieldName]=(!empty($sl_value)?$sl_value:'');
				}
			}

			$this->debugMP('pr','social_Add socialData',$socialData,NULL,NULL,true);
			$returnCode = $this->social_AddToDatabase(
					$socialData,
					'update'
					);
			if ($returnCode != 'added') {
				print "<div class='updated fade'>".
						stripslashes_deep($_POST['social_slug-']) ." " .
						__("Updated Successfully",'csa-slp-sme') . '.</div>';
			} else {
				print "<div class='updated fade'>".
						stripslashes_deep($_POST['social_slug-']) ." " .
						__("Added Successfully",'csa-slp-sme') . '.</div>';
			}
		} else {
			$this->debugMP('pr','social_Add no POST[social_slug-]',$socialData,NULL,NULL,true);
			print "<div class='updated fade'>".
					__('Social not added.','csa-slp-sme') . ' ' .
					sprintf(__('The add social form on your server is not rendering properly, the %s field is mandatory.','csa-slp-sme'),  __('Social Name', 'csa-slp-sme')) . 
					'</div>';
		}
	}

	/**
	 * Add an address into the SLP socials database.
	 *
	 * duplicates_handling can be:
	 * o none = ignore duplicates
	 * o skip = skip duplicates
	 * o update = update duplicates
	 *
	 * Returns:
	 * o added = new social added
	 * o social_exists = store id provided and not in update mode
	 * o not_updated = existing social not updated
	 * o skipped = duplicate skipped
	 * o updated = existing social updated
	 *
	 * @param array[] $socialData
	 * @param string $duplicates_handling
	 * @return string 
	 *
	 */
	function social_AddToDatabase($socialData,$duplicates_handling='none') {
		$this->debugMP('msg','SLPlus_AdminUI_Socials::'.__FUNCTION__,
							 "duplicates handling mode: {$duplicates_handling} ");

		$return_code = '';

		// Make sure socialData['sl_id'] is set to SOMETHING.
		//
		if (!isset($socialData['social'])) {
			// Not a valid incoming ID, reset current social.
			//
			$socialData['social'] = null;
			$this->addon->helperSocial->reset();
		} else {

			// If the incoming social ID is of a valid format...
			// Go fetch that social record.
			// This also ensures that ID actually exists in the database.
			//
			if ($this->addon->helperSocial->isvalid_ID($socialData['social'])) {
				$this->debugMP('msg','',"social ID {$socialData['social']} being loaded");
				$this->addon->helperSocial->set_PropertiesViaDB($socialData['social']);
				$socialData['social'] = $this->addon->helperSocial->id;

			// Not a valid incoming ID, reset current social.
			//
			} else {
				$socialData['social'] = null;
				$this->addon->helperSocial->reset();
			}
		}

		// If the social ID is not valid either because it does not exist
		// in the database or because it was not provided in a valid format,
		// Go see if the social can be found by social_slug
		//
		if ($socialData['social'] == null) {
			$this->debugMP('msg','','social ID not provided or invalid.');
			$duplicateSocialData = $this->addon->get_SocialObjectFromCache($this->val_or_blank($socialData,'sl_social_slug'));
			$this->debugMP('pr',"social_slug {$socialData['sl_social_slug']} found duplicateSocialData:",$duplicateSocialData);
			// Check whether duplicate is found
			if (isset($duplicateSocialData['sl_social_slug']) && ($socialData['sl_social_slug'] == $duplicateSocialData['sl_social_slug'])) {
				$socialData['social'] = $duplicateSocialData['sl_id'];
			}
		}

		// Check valid id
		//if ( $this->addon->helperSocial->isvalid_ID( $socialData['social'] ) ) {
		if ($socialData['social'] == null) {
			// Social ID does not exist, we are adding a new record.
			//
			$this->debugMP('msg','',"social {$socialData['social']} not found via address lookup, original handling mode {$duplicates_handling}.");
			$duplicates_handling = 'add';
			$return_code = 'added';

		} else {

			// Social ID exists, we have a duplicate entry...
			//
			$this->debugMP('msg','',"social ID {$socialData['social']} found or provided is valid.");
			if ($duplicates_handling === 'skip') { return 'skipped'; }

			// array ID and helperSocial ID do not match,
			// must have found ID via address lookup, go load up the helperSocial record
			//
			if ($socialData['social'] != $this->addon->helperSocial->id) {
				$this->addon->helperSocial->set_PropertiesViaDB($socialData['social']);
			}

			// TODO: if mode = 'add' force helperSocial->id to blank and set return code to 'added'.
			//

			$return_code = 'updated';
		}

		// Set the current social data
		//
		// In update duplicates mode this will not obliterate existing settings
		// it will augment them.  To set a value to blank for an existing record
		// it must exist in the column data and be set to blank.
		//
		// Non-update mode, it starts from a blank slate.
		//
		$this->debugMP('msg','',"set social properties via array in {$duplicates_handling} duplicates handling mode");
		$this->addon->helperSocial->set_PropertiesViaArray( $socialData, $duplicates_handling );

		// HOOK: slp_social_add
		//
		do_action('slp_social_add');

		// Write to disk
		//
		if ( $this->addon->helperSocial->dataChanged ) {
			$this->addon->helperSocial->MakePersistent();

		// Set not updated return code.
		//
		} else {
			$return_code = 'not_updated';
		}

		// HOOK: slp_social_added
		//
		do_action('slp_social_added');

		return $return_code;
	}

	/**
	 * Save a social.
	 */
	function social_Save() {
//        if ( ! $this->addon->helperSocial->isvalid_ID( null, 'social' ) ) { return; }
		$this->debugMP('msg',__FUNCTION__ . " social # {$_REQUEST['social']}");
//		$this->slplus->notifications->delete_all_notices();

		// Get our original address first
		//
		$this->addon->helperSocial->set_PropertiesViaDB($_REQUEST['social']);

		// Update The Social Data
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

		// Show Notices
		//
//		if ($this->slplus->notifications->get()) {
//			$this->slplus->notifications->display();
//			$this->debugMP('msg','',"*********************************************************** SHOW notices so dont do wp_get_referer! ");
//		} else {
//			// Check and do referer
//			//$this->debugMP('msg','',"*********************************************************** wp_get_referer: {" . wp_get_referer() . "}");
//			$this->debugMP('msg','','cleanAdminURL: '.$this->cleanAdminURL);
//			$this->debugMP('msg','','baseAdminURL:  '.$this->baseAdminURL);
//			$this->debugMP('msg','','hangoverURL:   '.$this->hangoverURL);
////			wp_safe_redirect( get_site_url(null, $this->baseAdminURL) );
////			exit;
//		}
	}

	/**
	 * Create the edit panel form.
	 * 
	 * @return string
	 */
	private function createstring_EditPanel() {
		$this->addon->helperSocial->set_PropertiesViaDB($_REQUEST['id']);
		return $this->create_SocialAddEditForm(false);
	}

	/**
	 * Return the value of the specified social data element or blank if not set.
	 *
	 * @param mixed[] $socialdata the social data array
	 * @param string $dataElement store locator plus social data array key
	 * @return mixed - the data element value or a blank string
	 */
	private function val_or_blank($data,$key) {
		return isset($data[$key]) ? $data[$key] : '';
	}


	//-------------------------------------
	// Methods : Added
	//-------------------------------------

	/**
	 * Creates the string to use a name for the setting.
	 *
	 * @param bool $addform - true if rendering add socials form
	 */
	function create_SettingsSetting($settingName, $settingAction, $settingID='') {
		$this->debugMP('msg',__FUNCTION__ . ' settingName = ' . $settingName . ', settingID = ' . $settingID . '.');

		return $settingAction . $this->csl_separator . $settingName . $this->csl_separator . $settingID;

	}

	/**
	 * Get the string used as name for the setting.
	 *
	 * @param bool $addform - true if rendering add socials form
	 */
	function get_SettingsSettingKey($settingKey, $settingAction, $settingID='') {
		$this->debugMP('msg',__FUNCTION__,' settingKey = ' . $settingKey . ', settingID = ' . $settingID . '.');
//            if (preg_match('#\-'.$this->addon->helperSocial->id.'#', $key)) {
//                $slpFieldName = preg_replace('#\-'.$this->addon->helperSocial->id.'#', '', $key);

		$keyPattern = '#^.*' . $settingAction . $this->csl_separator . '(.*)' . $this->csl_separator . '.*#';
		$keyReplacement = '\1';
		$newSettingKey = preg_replace($keyPattern, $keyReplacement, $settingKey);
		$this->debugMP('msg','',' keyPattern = ' . $keyPattern . ', keyReplacement = ' . $keyReplacement . '.');
		$this->debugMP('msg','',' settingKey = ' . $settingKey . ', newSettingKey = ' . $newSettingKey . '.');

		return $newSettingKey;

//		$testSettingName = $this->create_SettingsSetting($settingName, $settingID);
//		if (stripos($settingKey, $testSettingName)) {
//			return $newSettingKey;
//		}
//		return false;
	}

	/**
	 * Simplify the plugin debugMP interface.
	 *
	 * @param string $type
	 * @param string $hdr
	 * @param string $msg
	 */
	function debugMP($type,$hdr,$msg='') {
		if ($hdr == '') {
			$hdrShown = '';
		} else {
			$hdrShown = 'Manager: ' . $hdr;
		}
		$this->addon->debugMP($type,$hdrShown,$msg,NULL,NULL,true);
	}

}
