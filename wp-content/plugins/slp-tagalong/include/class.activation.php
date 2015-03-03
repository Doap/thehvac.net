<?php
/**
 * Manage plugin activation.
 *
 * @package StoreLocatorPlus\Tagalong\Activation
 * @author Lance Cleveland <lance@charlestonsw.com>
 * @copyright 2013 Charleston Software Associates, LLC
 *
 */
class Tagalong_Activation {

    //----------------------------------
    // Methods
    //----------------------------------

    /**
     * The plugin object
     *
     * @var \SLPTagalong $plugin
     */
    var $plugin;

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

        if (class_exists('Tagalong_Data') == false) {
            require_once(plugin_dir_path(__FILE__).'/class.data.php');
        }
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
        global $wpdb;
        $retval = ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) ? 'new' : 'updated';
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        global $EZSQL_ERROR;
        $EZSQL_ERROR=array();
        return $retval;
    }

    /**
     * Install or update the main table
     * @global object $wpdb
     */
    function create_MoreInfoTable() {
        $sql = $this->plugin->data->get_SQL('create_tagalong_helper');
        $this->status[$this->plugin->data->plugintable['name']] = $this->dbupdater($sql,$this->plugin->data->plugintable['name']);
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
        if (!isset($this->plugin) || !isset($this->plugin->data)) {
            $this->set_StatusFailed();
            return;
        }

        $this->create_MoreInfoTable();

        // If the installed version is < 1.0, load up the new category table
        //
        if (version_compare($this->plugin->options['installed_version'], '1.1', '<')) {
            $theSQL = $this->plugin->data->get_SQL('select_where_optionvalue_has_cats');
            $offset = 0;
            while (($location = $this->plugin->data->db->get_row($theSQL, ARRAY_A, $offset++))!=NULL) {
                $optionValues = maybe_unserialize($location['sl_option_value']);
                foreach ($optionValues['store_categories']['stores'] as $categoryID) {
                    $this->plugin->data->add_RecordIfNeeded($location['sl_id'], $categoryID);
                }
            }
        }
    }
}
