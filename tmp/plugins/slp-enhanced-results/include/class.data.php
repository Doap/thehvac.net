<?php
/**
 * The data interface helper.
 *
 * @package StoreLocatorPlus\EnhancedResults\Data
 * @author Lance Cleveland <lance@charlestonsw.com>
 * @copyright 2013 Charleston Software Associates, LLC
 *
 */
class ER_Data {

    //-------------------------------------------------
    // Properties
    //-------------------------------------------------

    /**
     * The global WordPress DB
     *
     * @var \wpdb $db
     */
    var $db;


    //-------------------------------------------------
    // Methods
    //-------------------------------------------------

    /**
     * Invoke an ER data object.
     *
     * Connects to the extender tables.
     *
     */
    public function __construct($params = null) {
        if (($params != null) && is_array($params)) {
            foreach ($params as $key=>$value) {
                $this->$key = $value;
            }
        }
        
        // Set the DB properties
        //
        global $wpdb;
        $this->db = $wpdb;

        // Set the plugin details table properties
        //
        $this->plugintable['name']  = $this->db->prefix . SLPlus_Data::TableName_Extendo;
        $this->metatable['name']    = $this->db->prefix . SLPlus_Data::TableName_ExtendoMeta;
    }
}
