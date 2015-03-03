<?php
/**
 * Manage plugin activation.
 *
 * @package StoreLocatorPlus\EnhancedSearch\Activation
 * @author Lance Cleveland <lance@charlestonsw.com>
 * @copyright 2013 Charleston Software Associates, LLC
 *
 */
class SLPES_Activation {

    //----------------------------------
    // Methods
    //----------------------------------

    /**
     * The plugin object
     *
     * @var \SLPEnhancedResults $plugin
     */
    var $plugin;

    /**
     * The base plugin object.
     *
     * @var \SLPlus $slplus
     */
    var $slplus;

    /**
     * Plugin table update status, key = table name, value = "new" or "updated"
     *
     * @var string[] $status
     */
    var $status;

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

        $this->slplus = $this->plugin->plugin;
    } 

    /**
     * Set the status array to failed.
     */
    function set_StatusFailed() {
        $this->status['all']='failed';
    }

    /**
     * Update or create the data tables.
     *
     * This can be run as a static function or as a class method.
     */
    function update() {
        if (!isset($this->plugin)) {
            $this->set_StatusFailed();
            return;
        }

        // Version specific updates
        // Options do not need to be written/updated as the calling admin_init will do that.
        //

        // Prior to version 4.0.014?
        // 
        // Move enhanced_results_orderby into serialized array.
        // Move SLPLUS_PREFIX.'_slper' into csl-slplus-ER-options
        //
        if ((version_compare($this->plugin->options['installed_version'], '4.0.014', '<'))){

            // Serialize Hide Search Form
            $optionName = SLPLUS_PREFIX.'-enhanced_search_hide_search_form';
            $this->plugin->options['hide_search_form'] = ((get_option($optionName,$this->plugin->options['state_selector']) === '1')?'1':'0');
            delete_option($optionName);

            // Serialize Search By Name
            $optionName = SLPLUS_PREFIX.'_show_search_by_name';
            $this->plugin->options['search_by_name'] = get_option($optionName,$this->plugin->options['search_by_name']);
            delete_option($optionName);

            // Serialize Show State PD
            $optionName = 'slplus_show_state_pd';
            $this->plugin->options['state_selector'] =
                get_option($optionName,$this->plugin->options['state_selector']) === '1' ?
                    'dropdown_addressinput' :
                    'hidden'             ;
            delete_option($optionName);

            // Rename _slpes Serial to -ES-options
            $optionName = SLPLUS_PREFIX.'_slpes';
            $this->plugin->options = array_merge(get_option($optionName,array()),$this->plugin->options);
            delete_option($optionName);
        }

        if ((version_compare($this->plugin->options['installed_version'], '4.1', '<'))){

            // Serialize City Selector PD
            $optionName = 'sl_use_city_search';
            $this->plugin->options['city_selector'] =
                get_option($optionName,$this->plugin->options['state_selector']) === '1' ?
                    'dropdown_addressinput' :
                    'hidden'             ;
            delete_option($optionName);

            // Serialize Country Selector PD
            $optionName = 'sl_use_country_search';
            $this->plugin->options['country_selector'] =
                get_option($optionName,$this->plugin->options['country_selector']) === '1' ?
                    'dropdown_addressinput' :
                    'hidden'             ;
            delete_option($optionName);

        }
    }
}
