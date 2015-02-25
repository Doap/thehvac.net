<?php
/**
 * Manage plugin activation.
 *
 * @package StoreLocatorPlus\EnhancedMap\Activation
 * @author Lance Cleveland <lance@charlestonsw.com>
 * @copyright 2013 Charleston Software Associates, LLC
 *
 */
class SLPEnhancedMap_Activation {

    //----------------------------------
    // Methods
    //----------------------------------

    /**
     * The plugin object
     *
     * @var \SLPEnhancedMap $plugin
     */
    var $plugin;

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
        if ( ! isset( $this->plugin ) ) { return; }

        // Version Comparison Stuff Goes Here
        //
    
        // If below 4.1.01 then set map_initial_display option base on sl_starting_image option 
        //
        if ( version_compare( $this->plugin->options['installed_version'] , '4.1.01' , '<' ) ) {
            $startingImage = get_option('sl_starting_image','');
            if (!empty($startingImage)) {
                $this->plugin->options['map_initial_display'] = 'image';
            } else {
                $this->plugin->options['map_initial_display'] = 'map';
            }
        }
    }
}
