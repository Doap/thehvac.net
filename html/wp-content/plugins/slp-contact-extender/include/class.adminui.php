<?php
/**
 * Admin interface methods.
 *
 * @package StoreLocatorPlus\Contacts\AdminUI
 * @author Lance Cleveland <lance@charlestonsw.com>
 * @copyright 2014 Charleston Software Associates, LLC
 *
 */
class SLPCEX_AdminUI {

    //----------------------------------
    // Properties
    //----------------------------------

    /**
     * The add-on pack from whence we came.
     * 
     * @var \SLPExtendoContacts $parent
     */
    private $addon;

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
     * We call admin_init in the parent to wire this in, then relegate the rest to
     * this class as this entire class file only loads into RAM when admin_init is
     * called.  This prevents the base add-on pack from carrying around excess
     * admin weight when processing front-end pages.
     *
     */
    function admin_init() {

        // Check the installed version,
        // if newer than installed version run some update stuff.
        //
        if(version_compare($this->addon->options['installed_version'], SLPExtendoContacts::VERSION, '<')) {
            $this->addon->debugMP('msg', "Updating plugin from version {$this->addon->options['installed_version']} to ".SLPExtendoContacts::VERSION);

            if (class_exists('SLPCEX_Activation') == false) {
                require_once('class.activation.php');
            }
            $this->activation = new SLPCEX_Activation(array('addon' => $this->addon, 'AdminUI' => $this));
            $this->activation->update();

            $this->addon->options['installed_version'] = SLPExtendoContacts::VERSION;
            update_option(SLPExtendoContacts::OPTION_NAME,$this->addon->options);
        }

        // WordPress Update Checker - if this plugin is active
        // See if there is a newer version out there somewhere
        // over the rainbow.
        //
        if (is_plugin_active($this->addon->slug)) {
            $this->addon->metadata = get_plugin_data($this->addon->file, false, false);
            $this->Updates = new SLPlus_Updates(
                    $this->addon->metadata['Version'],
                    $this->slplus->updater_url,
                    $this->addon->slug
                    );
        }
        
        // Pro Pack Filters
        //
        if ($this->slplus->is_AddonActive('slp-pro')) {
            add_filter('slp_csv_locationdata'       , array( $this, 'filter_CheckForPreExistingIdentifier'  ) );
        }
    }

    /**
     * Look to see if incoming Identifier data is already in the extended data set.
     *
     * @param mixed[] $location_data
     */
    public function filter_CheckForPreExistingIdentifier($location_data) {
       if ( isset( $location_data['sl_identifier'] ) && ! empty( $location_data['sl_identifier'] ) ) {

            // Fetch sl_id from provided identifier.
            //
            $location_se_data = $this->slplus->database->get_Record(
                array(
                    'select_slid',
                    " WHERE identifier = '%s' "
                    ),
                array(
                    $location_data['sl_identifier']
                )
            );

            // If there the select returned a valid data record object.
            //
            if ( is_object( $location_se_data ) && isset( $location_se_data->sl_id ) && ! empty ( $location_se_data->sl_id ) ) {
                $this->addon->debugMP(
                        'msg',
                        'SLPCEX_AdminUI::'.__FUNCTION__,
                        "Found match for identifier {$location_data['sl_identifier']} in ID {$location_se_data->sl_id}."
                        );
                $location_data['sl_id'] = $location_se_data->sl_id;
            }
       }
       return $location_data;
    }
}
