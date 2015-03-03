<?php
/**
 * Manage plugin activation.
 *
 * @package StoreLocatorPlus\Contacts\Activation
 * @author Lance Cleveland <lance@charlestonsw.com>
 * @copyright 2014 Charleston Software Associates, LLC
 *
 */
class SLPCEX_Activation {

    //----------------------------------
    // Properties
    //----------------------------------

    /**
     * Pointer to the AdminUI object for this plugin.
     * 
     * @var \SLPCES_AdminUI
     */
    var $AdminUI;

    /**
     * The parent plugin (add-on pack) object
     *
     * @var \SLPExtendoContacts $parent
     */
    var $addon;

    /**
     * The base plugin object.
     *
     * @var \SLPlus $slplus
     */
    var $slplus;
    
    /**
     * Extended data fields that were updated during an upgrade.
     * 
     * @var string[] $updated_slugs
     */
    private $updated_slugs = array();

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

        $this->slplus = $this->addon->plugin;
    } 

    /**
     * Update or create the data tables.
     *
     * This can be run as a static function or as a class method.
     */
    function update() {
        if (!isset($this->addon)) { return; }
        $this->addon->debugMP('msg','SLPCEX_Activation::'.__FUNCTION__);

        // Extended Location Data Enhancements
        //
        if ($this->slplus->database->is_Extended()) {
            
            // Active Version < 4.1.02
            // In this version we make the field name fixed at 'featured' not the translated version of __('featured')
            //
            if ( version_compare( $this->addon->options['extended_data_version'] , '4.1.02' , '<' ) ){      
                add_filter('sanitize_title', array($this->slplus->database->extension, 'filter_SanitizeTitleForMySQLField'), 10, 3);
                
                $this->update_MetaData(   __('Identifier'       ,'csa-slp-cex') , 'identifier'             );
                $this->update_MetaData(   __('Contact'          ,'csa-slp-cex') , 'contact'                );
                $this->update_MetaData(   __('First Name'       ,'csa-slp-cex') , 'first_name'             );
                $this->update_MetaData(   __('Last Name'        ,'csa-slp-cex') , 'last_name'              );
                $this->update_MetaData(   __('Title'            ,'csa-slp-cex') , 'title'                  );
                $this->update_MetaData(   __('Department'       ,'csa-slp-cex') , 'department'             );
                $this->update_MetaData(   __('Training'         ,'csa-slp-cex') , 'training'               );
                $this->update_MetaData(   __('Facility Type'    ,'csa-slp-cex') , 'facility_type'          );
                $this->update_MetaData(   __('Office Phone'     ,'csa-slp-cex') , 'office_phone'           );
                $this->update_MetaData(   __('Mobile Phone'     ,'csa-slp-cex') , 'mobile_phone'           );
                $this->update_MetaData(   __('Contact Fax'      ,'csa-slp-cex') , 'contact_fax'            );
                $this->update_MetaData(   __('Contact Email'    ,'csa-slp-cex') , 'contact_email'          );
                $this->update_MetaData(   __('Office Hours'     ,'csa-slp-cex') , 'office_hours'           );
                $this->update_MetaData(   __('Contact Address'  ,'csa-slp-cex') , 'contact_address'        );
                $this->update_MetaData(   __('Notes'            ,'csa-slp-cex') , 'notes'                  );
                
                $this->data_RenameColumn( __('Identifier'       ,'csa-slp-cex') , 'identifier'   , 'varchar' );
                $this->data_RenameColumn( __('Contact'          ,'csa-slp-cex') , 'contact'      , 'varchar' );
                $this->data_RenameColumn( __('First Name'       ,'csa-slp-cex') , 'first_name'   , 'varchar' );
                $this->data_RenameColumn( __('Last Name'        ,'csa-slp-cex') , 'last_name'    , 'varchar' );
                $this->data_RenameColumn( __('Title'            ,'csa-slp-cex') , 'title'        , 'varchar' );
                $this->data_RenameColumn( __('Department'       ,'csa-slp-cex') , 'department'   , 'varchar' );
                $this->data_RenameColumn( __('Training'         ,'csa-slp-cex') , 'training'     , 'varchar' );
                $this->data_RenameColumn( __('Facility Type'    ,'csa-slp-cex') , 'facility_type', 'varchar' );
                $this->data_RenameColumn( __('Office Phone'     ,'csa-slp-cex') , 'office_phone' , 'varchar' );
                $this->data_RenameColumn( __('Mobile Phone'     ,'csa-slp-cex') , 'mobile_phone' , 'varchar' );
                $this->data_RenameColumn( __('Contact Fax'      ,'csa-slp-cex') , 'contact_fax'  , 'varchar' );
                $this->data_RenameColumn( __('Contact Email'    ,'csa-slp-cex') , 'contact_email', 'varchar' );
                $this->data_RenameColumn( __('Office Hours'     ,'csa-slp-cex') , 'office_hours'   ,'text'   );
                $this->data_RenameColumn( __('Contact Address'  ,'csa-slp-cex') , 'contact_address','text'   );
                $this->data_RenameColumn( __('Notes'            ,'csa-slp-cex') , 'notes'          ,'text'   );
                
                remove_filter('sanitize_title', array($this->slplus->database->extension, 'filter_SanitizeTitleForMySQLField'));                
            }
            
            if ((version_compare($this->addon->options['extended_data_version'], SLPExtendoContacts::DATA_VERSION, '<'))){
                $this->addon->debugMP(
                    'msg',
                    '',
                    sprintf(
                        "Update extended data version % to version %s",
                        $this->addon->options['extended_data_version'],
                        SLPExtendoContacts::VERSION
                    )
                );

                $this->slplus->database->extension->add_field( __( 'Identifier'       ,'csa-slp-cex' ), 'varchar', array( 'slug' => 'identifier' )      , 'wait' );
                $this->slplus->database->extension->add_field( __( 'Contact'          ,'csa-slp-cex' ), 'varchar', array( 'slug' => 'contact' )         , 'wait' );
                $this->slplus->database->extension->add_field( __( 'First Name'       ,'csa-slp-cex' ), 'varchar', array( 'slug' => 'first_name' )      , 'wait' );
                $this->slplus->database->extension->add_field( __( 'Last Name'        ,'csa-slp-cex' ), 'varchar', array( 'slug' => 'last_name' )       , 'wait' );
                $this->slplus->database->extension->add_field( __( 'Title'            ,'csa-slp-cex' ), 'varchar', array( 'slug' => 'title' )           , 'wait' );
                $this->slplus->database->extension->add_field( __( 'Department'       ,'csa-slp-cex' ), 'varchar', array( 'slug' => 'department' )      , 'wait' );
                $this->slplus->database->extension->add_field( __( 'Training'         ,'csa-slp-cex' ), 'varchar', array( 'slug' => 'training' )        , 'wait' );
                $this->slplus->database->extension->add_field( __( 'Facility Type'    ,'csa-slp-cex' ), 'varchar', array( 'slug' => 'facility_type' )   , 'wait' );
                $this->slplus->database->extension->add_field( __( 'Office Phone'     ,'csa-slp-cex' ), 'varchar', array( 'slug' => 'office_phone' )    , 'wait' );
                $this->slplus->database->extension->add_field( __( 'Mobile Phone'     ,'csa-slp-cex' ), 'varchar', array( 'slug' => 'mobile_phone' )    , 'wait' );
                $this->slplus->database->extension->add_field( __( 'Contact Fax'      ,'csa-slp-cex' ), 'varchar', array( 'slug' => 'contact_fax' )     , 'wait' );
                $this->slplus->database->extension->add_field( __( 'Contact Email'    ,'csa-slp-cex' ), 'varchar', array( 'slug' => 'contact_email' )   , 'wait' );
                $this->slplus->database->extension->add_field( __( 'Office Hours'     ,'csa-slp-cex' ), 'text'   , array( 'slug' => 'office_hours' )    , 'wait' );
                $this->slplus->database->extension->add_field( __( 'Contact Address'  ,'csa-slp-cex' ), 'text'   , array( 'slug' => 'contact_address' ) , 'wait' );
                $this->slplus->database->extension->add_field( __( 'Notes'            ,'csa-slp-cex' ), 'text'   , array( 'slug' => 'notes' )           , 'wait' );
                $this->slplus->database->extension->update_data_table();

                $this->options['extended_data_version'] = SLPExtendoContacts::DATA_VERSION;  // made persistent via addon admin_init call
            }

        }
    }
    
    /**
     * Create the SQL command to rename a column.
     * 
     * @param string $label
     * @param string $slug
     * @param string $type
     * @return string
     */
    function data_RenameColumn( $label , $slug , $type ) {
        if ( ! in_array( $slug , $this->updated_slugs ) ) { return; }
        if ( $type === 'varchar' ) { $type = 'varchar(250)'; }
        $sql_command =
            sprintf(
                'ALTER TABLE %s change %s %s %s', 
                $this->slplus->database->extension->plugintable['name'],
                sanitize_title($label, '', 'save'),
                $slug,
                $type
               );     
        return $this->slplus->db->query( $sql_command );        
    }
    
    /**
     * Update the extended data table meta data.
     * 
     * @param type $label
     * @param type $slug
     * @return string $slug the slug if it was updated, empty if not
     */
    function update_MetaData( $label , $slug ) {
        if ( 
            $this->slplus->database->extension->has_field( sanitize_title( $label ) ) &&
            ! $this->slplus->database->extension->has_field( $slug ) 
           ) {
            $this->slplus->db->update(
                $this->slplus->database->extension->metatable['name'],
                array(
                    'label' => $label ,
                    'slug'  =>  $slug
                ) ,
                array(
                    'slug' => sanitize_title($label, '', 'save')
                ) ,
                array ( '%s' , '%s' )
            );        
            $this->updated_slugs[] = $slug;
        } 
    }    
}
