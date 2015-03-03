<?php
/**
 * Manage plugin activation.
 *
 * @package StoreLocatorPlus\UserManagedLocations\Activation
 * @author De B.A.A.T. <slp-uml@de-baat.nl>
 * @copyright 2014 Charleston Software Associates, LLC - De B.A.A.T.
 *
 */
class SLPUML_Activation {

	//----------------------------------
	// Properties
	//----------------------------------

	/**
	 * Pointer to the AdminUI object for this plugin.
	 * 
	 * @var \SLPUML_AdminUI
	 */
	var $parent;

	/**
	 * The slp_uml plugin (add-on pack) object
	 *
	 * @var \SLPUserManagedLocations $slp_uml
	 */
	var $addon;

	/**
	 * The base plugin object.
	 *
	 * @var \SLPlus $slplus
	 */
	var $slplus;

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
	} 

	/**
	 * Update or create the data tables.
	 *
	 * This can be run as a static function or as a class method.
	 */
	function update() {
		if (!isset($this->addon)) { return; }
		$this->debugMP('msg',__FUNCTION__);

		// Extended Location Data Enhancements for User Managed Locations
		//
		if ($this->slplus->database->is_Extended()) {
			if ((version_compare($this->addon->options['extended_data_version'], SLPUserManagedLocations::DATA_VERSION, '<'))){
				$this->debugMP(
					'msg',
					'',
					sprintf(
						__("Update extended data version %s to version %s",'csa-slp-uml' ),
						$this->addon->options['extended_data_version'],
						SLPUserManagedLocations::DATA_VERSION
					)
				);

				// Only add the new Extendo field if it doesn't exist already
				if ( ! $this->slplus->database->extension->has_field(SLPUserManagedLocations::SLP_UML_USER_SLUG) ) {
					$this->slplus->database->extension->add_field( __( 'Store User','csa-slp-uml' ), 'varchar', array('slug'=>SLPUserManagedLocations::SLP_UML_USER_SLUG), 'wait' );
					$this->slplus->database->extension->update_data_table();
				}

				$this->addon->options['extended_data_version'] = SLPUserManagedLocations::DATA_VERSION;
			}

		// Plugin is NOT extended,
		// TODO: Show instructional message on how to activate this properly.
		//
		} else {

			// Deactivate this plugin.
			// Get Super Extendo, Install, Activate
			// Re-activate this plugin.
			$this->debugMP('msg','User Managed Locations Error: Deactivate this plugin and install Super Extendo add-on first!');

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
		if (($hdr!=='')) { $hdr = 'Activation: ' . $hdr; }
		$this->addon->debugMP($type,$hdr,$msg,NULL,NULL,true);
	}

}
