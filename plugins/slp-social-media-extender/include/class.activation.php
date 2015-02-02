<?php
/**
 * Manage plugin activation.
 *
 * @package StoreLocatorPlus\SocialMediaExtender\Activation
 * @author De B.A.A.T. <slp-sme@de-baat.nl>
 * @copyright 2014 Charleston Software Associates, LLC - De B.A.A.T.
 *
 */
class SLPSME_Activation {

	//----------------------------------
	// Properties
	//----------------------------------

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
	 * @var \SLPSME_Admin $parent
	 */
	var $parent;

	/**
	 * Initialize the object.
	 *
	 * @param mixed[] $params
	 */
	function __construct($params = null) {
		// Do the setting override or initial settings.
		//
		if ($params != null) {
			foreach ($params as $name => $value) {
				$this->$name = $value;
			}
		}

		//$this->slplus = $this->addon->setPlugin();
	} 

	/**
	 * Update or create the data tables.
	 *
	 * This can be run as a static function or as a class method.
	 */
	function update() {
		$this->debugMP('msg',__FUNCTION__);
		if (!isset($this->addon)) { return; }

		// Check the version of the Social Icons
		if ((version_compare($this->addon->options['social_icon_version'], SLPSocialMediaExtender::SOCIAL_ICON_VERSION, '<'))){
			$this->debugMP(
				'msg',
				'',
				sprintf(
					__("Update social icon version %s to version %s",'csa-slp-sme' ),
					$this->addon->options['social_icon_version'],
					SLPSocialMediaExtender::SOCIAL_ICON_VERSION
				)
			);

			// Set default social_icon_location if not set before
			if ($this->addon->options['social_icon_location'] == '') {
				$this->addon->options['social_icon_location'] = SLPLUS_PLUGINURL_SME . "/images/social-icons";
			}

			// Save Social Icons Files
			$filesSaved = $this->save_social_icon_files();

			$this->addon->options['social_icon_version'] = SLPSocialMediaExtender::SOCIAL_ICON_VERSION;
		} else {
			// Version is ok
			$this->debugMP('msg','Social Media Extender Social Icons ok!');
		}

		// Check the version of Social Data for Social Media Extender
		//
		if ((version_compare($this->addon->options['social_data_version'], SLPSocialMediaExtender::SOCIAL_DATA_VERSION, '<'))){
			$this->debugMP('msg','',
				sprintf(__("Update social object data version %s to version %s",'csa-slp-sme' ),
						$this->addon->options['social_data_version'],
						SLPSocialMediaExtender::SOCIAL_DATA_VERSION
				)
			);

			// Extended Location Data Enhancements for Social Media Extender
			//
			if ($this->slplus->database->is_Extended()) {

				$this->install_social_object_tables();

				// Make a set default objects for starters
				$this->addon->helperSocial = $this->addon->create_SocialObject(array(
					'social_name' => 'Facebook',
					'social_slug' => 'facebook',
					'description' => __('The basic Facebook social media as provided by default.','csa-slp-sme'),
					'base_url'    => 'http://facebook.com/',
					'icon'        => $this->addon->options['social_icon_location'] . '/facebook.png',
					));
				$this->addon->helperSocial->MakePersistent();
				$this->addon->helperSocial = $this->addon->create_SocialObject(array(
					'social_name' => 'Twitter',
					'social_slug' => 'twitter',
					'description' => __('The basic Twitter social media as provided by default.','csa-slp-sme'),
					'base_url'    => 'http://twitter.com/',
					'icon'        => $this->addon->options['social_icon_location'] . '/twitter.png',
					));
				$this->addon->helperSocial->MakePersistent();

				$this->addon->options['social_data_version'] = SLPSocialMediaExtender::SOCIAL_DATA_VERSION;

			// Plugin is NOT extended,
			// TODO: Show instructional message on how to activate this properly.
			//
			} else {
				$this->debugMP('msg','Social Media Extender Error: Super Extendo data not installed!');
			}

		} else {
			// Version is ok
			$this->debugMP('msg','Social Media Extender Social Data ok!');
		}
		
		// Update the options
		update_option(SLPSocialMediaExtender::OPTION_NAME,$this->addon->options);
	}

	/*************************************
	 * Install social object tables
	 *
	 * Update the plugin version in config.php on every structure change.
	 */
	function install_social_object_tables() {

		// Get the sql to create the Social_Table and execute it
		$sql = $this->addon->get_SQL_Social_Table('create');
		$this->debugMP('msg',__FUNCTION__ . ' create table with SQL:' . $sql . ' for table ' . $this->addon->slp_social_table . '!');
		$this->dbupdater($sql, $this->addon->slp_social_table);     

	}

	/*************************************
	 * Copy social-icon files to wp-content/uploads/sl-uploads for safekeeping.
	 */
	function save_social_icon_files() {
		$allOK = true;
		$this->debugMP('msg',__FUNCTION__ ,' allOK=' . $allOK);

		$orgSocialIconDir = SLPLUS_PLUGINDIR_SME . "/images/social-icons";
		$orgSocialIconURl = SLPLUS_PLUGINURL_SME . "/images/social-icons";
		$newSocialIconDir = SLPLUS_UPLOADDIR . "social-icons";
		$newSocialIconUrl = SLPLUS_UPLOADURL . "social-icons";

		// Make the upload director(ies)
		//
		if (!is_dir(ABSPATH . "wp-content/uploads")) {
			mkdir(ABSPATH . "wp-content/uploads", 0755);
		}
		if (!is_dir(SLPLUS_UPLOADDIR)) {
			mkdir(SLPLUS_UPLOADDIR, 0755);
		}
		if (!is_dir($newSocialIconDir)) {
			mkdir($newSocialIconDir, 0755);
		}

		// Copy ./images/social-icons to custom-icons save loation
		//
		if (is_dir($orgSocialIconDir) && is_dir($newSocialIconDir)) {
			$allOK = $allOK && $this->copyr($orgSocialIconDir, $newSocialIconDir);
			$this->debugMP('msg','',' allOK=' . $allOK);
			$this->addon->options['social_icon_location'] = $newSocialIconUrl;
			update_option(SLPSocialMediaExtender::OPTION_NAME,$this->addon->options);
		}

		$this->debugMP('msg','',' SLPLUS_UPLOADDIR=' . SLPLUS_UPLOADDIR);
		$this->debugMP('msg','',' SLPLUS_PLUGINDIR_SME=' . SLPLUS_PLUGINDIR_SME);
		$this->debugMP('msg','',' orgSocialIconDir=' . $orgSocialIconDir);
		$this->debugMP('msg','',' newSocialIconDir=' . $newSocialIconDir);

		return $allOK;
	}

	/************************************************************
	 * Copy a file, or recursively copy a folder and its contents
	 */
	public function copyr($source, $dest) {

		// Check for symlinks
		if (is_link($source)) {
			return symlink(readlink($source), $dest);
		}

		// Simple copy for a file
		if (is_file($source)) {
			return copy($source, $dest);
		}

		if (!is_dir($dest)) {
			mkdir($dest, 0755);
		}

		// Loop through the folder
		$dir = dir($source);
		while (false !== $entry = $dir->read()) {
			// Skip pointers
			if ($entry == '.' || $entry == '..') {
				continue;
			}

			// Deep copy directories
			$this->copyr("$source/$entry", "$dest/$entry");
		}

		// Clean up
		$dir->close();
		return true;
	}

	/**
	 * Update the data structures on new db versions.
	 *
	 * @global object $wpdb
	 * @param type $sql
	 * @param type $table_name
	 * @return string
	 */
	function dbupdater($sql,$table_name) {
//        global $wpdb;
		$retval = ( $this->slplus->db->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) ? 'new' : 'updated';

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		return $retval;
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
			$hdrShown = 'Activate: ' . $hdr;
		}
		$this->addon->debugMP($type,$hdrShown,$msg,NULL,NULL,true);
	}

}
