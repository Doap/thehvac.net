<?php
/**
 * Store Locator Plus social interface and management class.
 *
 * Make a social object an in-memory object and handle persistence via data I/O to the MySQL tables.
 *
 * @package StoreLocatorPlus\Social Media Extender
 * @author Lance Cleveland <lance@charlestonsw.com>
 * @copyright 2012-2013 Charleston Software Associates, LLC
 *
 * @property int $id
 * @property string $social_name          the social name
 * @property string $social_slug          the social slug
 * @property string $icon
 * @property string $description
 * @property string $base_url
 * @property string $option_value
 * @property datetime $lastupdated
 * @property mixed[] $attributes - the deserialized option_value field
 *
 * @property-read string $dbFieldPrefix - the database field prefix for social objects
 * @property-read string[] $dbFields - an array of properties that are in the db table
 *
 * @property SLPlus $slplus - the parent plugin object
 */
class SLPSME_Social {

    //-------------------------------------------------
    // Properties
    //-------------------------------------------------

    // Our database fields
    //

    /**
     * Unique social ID.
     * 
     * @var int $id
     */
    private $id;
    private $social_name;
    private $social_slug;
    private $icon;
    private $description;
    private $base_url;
    private $option_value;
    private $lastupdated;

    /**
     * The WordPress database connection and table_name.
     * 
     * @var \wpdb $db
     */
    private $db;
	private $table_name;

	// The database map
    //
    private $dbFields = array();

    /**
     * The deserialized option_value field. This can be augmented by multiple add-on packs.
     *
     * Tagalong adds:
     *  array[] ['store_categories']
     *       int[] ['stores']
     *
     * @var mixed[] $attributes
     */
    private $attributes;

    /**
     * True if the social data has changed.
     *
     * Used to manage the MakePersistent method, if false do not write to disk.
     * 
     * @var boolean $dataChanged
     */
    public $dataChanged = true;

    /**
     * Remember the last social data array passed into set properties via DB.
     *
     * @var mixed[] $socialData
     */
    private $socialData;

    // Assistants for this class
    //
    private $dbFieldPrefix      = 'sl_';

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

    //-------------------------------------------------
    // Methods
    //-------------------------------------------------

    /**
     * Initialize a new social
     *
     * @param mixed[] $params - a named array of the plugin options.
     */
    public function __construct($params) {
        foreach ($params as $property=>$value) {
            $this->$property = $value;
        }
        global $wpdb;
		$this->db = $wpdb;
		$this->table_name = $this->db->prefix . SLPSocialMediaExtender::SLP_SOCIAL_TABLE;
//		$this->social_slug = $this->get_SocialSlug();

        // Set gettext default properties.
        //
		$this->dbFields = array(
            'id'              => __('ID',            'csa-slp-sme'),
            'social_name'     => __('Social Name',   'csa-slp-sme'),
            'social_slug'     => __('Social Slug',   'csa-slp-sme'),
            'icon'            => __('Social Icon',   'csa-slp-sme'),
            'description'     => __('Description',   'csa-slp-sme'),
            'base_url'        => __('Base URL',      'csa-slp-sme'),
            'option_value'    => __('Option Values', 'csa-slp-sme'),
            'lastupdated'     => __('Last Updated',  'csa-slp-sme'),
        );
    }

    /**
     * Fetch a social property from the valid object properties list.
     *
     * $helperSocial = new SLPSME_Social();
     * print $helperSocial->id;
     * 
     * @param mixed $property - which property to set.
     * @return null
     */
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    /**
     * Simplify the plugin debugMP interface.
     *
     * @param string $type
     * @param string $hdr
     * @param string $msg
     */
    function debugMP($type,$hdr,$msg='') {
		return;
		if ($hdr == '') {
			$hdrShown = '';
		} else {
			$hdrShown = 'Social: ' . $hdr;
		}
        $this->addon->debugMP($type,$hdrShown,$msg,NULL,NULL,true);
    }

    /**
     * Put out the dump of the current social to DebugMP slp.main panel.
     * 
     */
    public function debugProperties() {
        //$this->debugMP('msg',__FUNCTION__);
        $output = array();
        foreach ($this->dbFields as $property => $name) {
            $output[$property] = $this->$property;
        }
        $output['attributes'] = $this->attributes;
        $this->debugMP('pr',__FUNCTION__,$output);
    }

    /**
     * Get the array of dbFields names registered for this object.
     * 
     */
    public function get_dbFieldsNames() {
		return $this->get_dbFields('name');
    }

    /**
     * Get the array of dbFields names registered for this object.
     * 
     */
    public function get_dbFieldsNamesDB() {
		return $this->get_dbFields('dbName');
    }

    /**
     * Get the array of dbFields slugs registered for this object.
     * 
     */
    public function get_dbFieldsSlugs() {
		return $this->get_dbFields('slug');
    }

    /**
     * Get the array of dbFields slugs registered for this object.
     * 
     */
    public function get_dbFieldsSlugsDB() {
		return $this->get_dbFields('dbSlug');
    }

    /**
     * Get the array of dbFields registered for this object.
     * 
     */
    private function get_dbFields($fieldType = 'name') {
		//$this->debugMP('msg',__FUNCTION__);
        $fields = array();
        foreach ($this->dbFields as $slug => $name) {
			switch ($fieldType) {
				case 'name':
					$fields[$slug] = $name;
					break;
				case 'slug':
					$fields[$slug] = $slug;
					break;
				case 'dbName':
					$fields[$this->dbFieldPrefix . $slug] = $name;
					break;
				case 'dbSlug':
					$fields[$this->dbFieldPrefix . $slug] = $slug;
					break;
				default:
					break;
			}
		}
		//$this->debugMP('pr',__FUNCTION__,$fields);
		return $fields;
    }


    /**
     * Delete this social permanently from the database.
     */
    public function DeletePermanently() {
        $this->debugMP('msg',__FUNCTION__,"SocialID: {$this->id}, Social name: {$this->social_name}");
        if (!ctype_digit($this->id) || ($this->id<0)) { return; }

        // ACTION: slp_deletesocial_starting
        //
        $this->debugMP('msg',__FUNCTION__,"TODO: do_action('slp_deletesocial_starting');");
//		do_action('slp_deletesocial_starting');
//
		$this->debugMP('msg',__FUNCTION__,"Deleting sl_id [" . $this->id . "] from table [" . $this->table_name . "]!!!");
		$this->slplus->db->delete(
			$this->table_name,
			array('sl_id' => $this->id)
			);

		// Remove the SocialSlug from the extended data set
		if ($this->slplus->database->is_Extended()) {
			$this->slplus->database->extension->remove_field( $this->social_name, array('slug'=>  $this->get_SocialSlug(true)), 'immediate');
		}

	}

    /**
     * Return the values for each of the persistent properties of this social.
     *
     * @param string $property name of the persistent property to get, defaults to 'all' = array of all properties
     * @return mixed the value the property or a named array of all properties (default)
     */
    public function get_PersistentProperty($property='all') {
        $this->debugMP('msg',__FUNCTION__);
        $persistentData = array_reduce($this->get_dbFieldsSlugs(),array($this,'mapPropertyToField'));
        return (($property==='all')?$persistentData:(isset($persistentData[$property])?$persistentData[$property]:null));
    }

    /**
     * Set all the db field properties to blank.
     */
    public function reset() {
        foreach ($this->dbFields as $property => $name) {
            $this->$property = '';
        }
        $this->attributes = null;
    }

    /**
     * Make the social data persistent.
     *
     * @return boolean data write OK
     */
    public function MakePersistent() {
        $this->debugMP('msg',__FUNCTION__);
        $this->debugMP('msg',__FUNCTION__,"TODO: Check for duplicates with social_slug!");

        $dataWritten = true;
        $dataToWrite = array_reduce($this->get_dbFieldsSlugs(),array($this,'mapPropertyToField'));

        // sl_id int field blank, unset it we will insert a new auto-int record
        //
        if (empty($dataToWrite['sl_id'])) {
            unset($dataToWrite['sl_id']);
        }
        
        // sl_last_upated is blank, unset to get auto-date value
        //
        if (empty($dataToWrite['sl_lastupdated'])) {
            unset($dataToWrite['sl_lastupdated']);
        }

        // sl_social_slug set to sanitize_title value
        //
//        $dataToWrite['sl_social_slug'] = $this->get_SocialSlug();

		// Social is set, update it.
        //
        if ($this->id > 0) {
            $this->debugMP('msg','',"Update social {$this->id}");
            if(!$this->slplus->db->update($this->table_name,$dataToWrite,array('sl_id' => $this->id))) {
                $dataWritten = false;
                $this->debugMP('msg','',"Update social {$this->id} DID NOT update core data.");
            }

        // No social, add it.
        //
        } else {
            $this->debugMP('msg','','Adding new Social since no ID was provided.');
            if (!$this->slplus->db->insert($this->table_name,$dataToWrite)) {
                $this->slplus->notifications->add_notice(
                        'warning',
                        sprintf(__('Could not add %s as a new social object!','csa-slp-sme'),$this->social_name)
                        );
                $dataWritten = false;
                $this->id = '';

            // Set our social ID to be the newly inserted record!
            //
            } else {
                $this->id = $this->slplus->db->insert_id;

				// Add the new SocialSlug to the extended data set
				if ($this->slplus->database->is_Extended()) {
					$this->slplus->database->extension->add_field( $this->social_name, 'varchar', array('slug'=>  $this->get_SocialSlug(true)), 'immediate');
				}
            }

        }

        // Reset the data changed flag, used to manage MakePersistent calls.
        // Stops MakePersistent from writing data to disk if it has not changed.
        //
        //$this->addon->helperSocial->dataChanged = false;

        return $dataWritten;
    }

    /**
     * Creates a slug value from the parameters given.
     *
     * @param string $title
     * @param string $fallback
     * @return string $sme_social_slug
     */
    function get_SocialSlug($withPrefix = false) {

		return $this->addon->make_SocialSlug($this->social_slug, $this->social_name, $withPrefix);

	}

    /**
     * Return true if the given string is an int greater than 0.
     *
     * If no id is presented, check the current social ID.
     *
     * request_param is used if ID is set to null to try to set the value from a request variable of that name.
     *
     * @param string $id
     * @param string $request_param
     * @return boolean
     */
    function isvalid_ID($id=null, $request_param=null ) {

        if ( isset( $_REQUEST[$request_param] ) ) { $id = $_REQUEST[$request_param];    }
        if ( $id === null                       ) { $id = $this->id;                    }

        return ( ctype_digit( $id ) && ( $id > 0 ) );
    }

    /**
     * Return a named array that sets key = db field name, value = social property
     *
     * @param string $property - name of the social property
     * @return mixed[] - key = string of db field name, value = social property value
     */
    private function mapPropertyToField($result, $property) {
        // Map attributes back into option_value
        //
        if ($property == 'option_value') {
            $this->$property = maybe_serialize($this->attributes);
        }

        // Set field to property
        //
        $result[$this->dbFieldPrefix.$property]=$this->$property;
        return $result;
    }

    /**
     * Set a social property in the valid object properties list to the given value.
     *
     * $helperSocial = new SLPSME_Social();
     * $helperSocial->social_name = 'My Social';
     *
     * @param mixed $property
     * @param mixed $value
     * @return \SLPSME_Social
     */
    public function __set($property,$value) {
        if (property_exists($this, $property)) {
			if ($property == 'social_slug') {
				$this->$property = sanitize_title($value);
				$this->debugMP('msg',__FUNCTION__,"Sanitized property " . $property . " from value:" . $value . " to value:" . $this->$property);
			} else {
				$this->$property = $value;
			}
        }
        return $this;
    }

    /**
     * Set social properties via a named array containing the field data.
     *
     * Used to set properties based on the MySQL SQL fetch to ARRAY_A method
     * or on a prepped named array where the field names are keys and
     * field values are the values.
     *
     * Mode parameter:
     * o dbreset  = reset social data to blank before loading it up
     * o reset = reset social data to blank before loading it up
     * o update = do NOT reset social data to blank before updating
     *
     * Assumes the field names start with 'sl_'.
     *
     * @param mixed[] $socialData
     * @param string $mode which mode?  'reset' or 'update' defaults to reset;
     * @return boolean
     */
    public function set_PropertiesViaArray($socialData,$mode='reset') {
        $this->debugMP('msg',__FUNCTION__,"Mode: {$mode}");

		$this->debugMP('pr',__FUNCTION__,"TODO: Make persistent for socialData:",$socialData);
//        $this->debugMP('msg',__FUNCTION__,"TODO: Point to the right object, use another as $plugin attribute, e.g. parent?!");
//        $this->debugMP('msg',__FUNCTION__,"TODO: Define the name of the table to use!!!");
//return true;

        // If we have an array, assume we are on the right track...
        if (is_array($socialData)) {

            // Do not set the data if it is unchanged from the last go-around
            //
            if ($socialData === $this->socialData) {
                return true;
            }

            // Process mode.
            // Ensures any value other than 'dbreset' or 'update' resets the social data.
            //
            switch ($mode) {
                case 'dbreset':
                case 'update':
                    break;
                default:
                    $this->debugMP('msg','','data reset');
                    $this->reset();
                    break;
            }

            // Go through the named array and extract properties.
            //
            foreach ($socialData as $field => $value) {

                // TODO: This is probably wrong and can be deleted.  Should be sl_id, but that causes duplicate entries.
                if ($field==='id') { continue; }

                // Get rid of the leading field prefix (usually sl_)
                //
                $property = str_replace($this->dbFieldPrefix,'',$field);
				
				// Create a valid slug
				if ($property == 'social_slug') {
//					if ($value == '') {
//						$value = $socialData[$this->dbFieldPrefix.'social_name'];
//					}
//					$value = sanitize_title($value);
//					$value = str_replace('-', '_', $value);
//					$new_value = $this->addon->make_SocialSlug($value,$socialData[$this->dbFieldPrefix.'social_name']);
					if (isset($socialData['social_name'])) {
						$new_value = $this->addon->make_SocialSlug($value,$socialData['social_name']);
					} else {
						$new_value = $this->addon->make_SocialSlug($value,'');
					}
					$this->debugMP('msg',__FUNCTION__,"Sanitized for property " . $property . " to value:" . $new_value);
				} else {
					$new_value = $value;
				}

                // Set our property value
                //
                $ssd_value = stripslashes_deep($new_value);
                if ($this->$property != $ssd_value ) {
//                    $debug_message = empty($this->property)?"set to {$new_value}" : "changed {$this->$property} to {$new_value} ";
//                    $this->debugMP('msg',''," {$property}: {$debug_message} ");
                    $this->$property = $ssd_value;
                    $this->dataChanged = true;
                }
            }

            // Deserialize the option_value field
            //
            $this->attributes = maybe_unserialize($this->option_value);

            $this->socialData = $socialData;

            return true;
        }

        $this->debugMP('msg','','ERROR: socialData not in array format.');
        return false;
    }


    /**
     * Load a social from the database.
     *
     * Only re-reads database if the social ID has changed.
     *
     * @param int $socialID - ID of social to be loaded
     * @return SLPSME_Social $this - the social object
     */
    public function set_PropertiesViaDB($socialID) {
        $this->debugMP('msg',__FUNCTION__);
        
        // Reset the set_PropertiesViaArray tracker.
        //
        $this->socialData = null;

        // Our current ID does not match, load new social data from DB
        //
        if ($this->id != $socialID) {
            $this->reset();
			
			// Get the social data
            $socData = $this->addon->get_SocialObjects($socialID);
            $this->debugMP('pr',"Social {$socialID} loaded from disk:",$socData);
            if (is_array($socData)) {
				if (isset($socData[0])) {
					$this->set_PropertiesViaArray($socData[0],'dbreset');
				} else {
					$this->set_PropertiesViaArray($socData,'dbreset');
				}
			}
        }

        // Reset the data changed flag, used to manage MakePersistent calls.
        // Stops MakePersistent from writing data to disk if it has not changed.
        //
        $this->dataChanged = false;
		$this->addon->helperSocial = $this;

        return $this;
    }

    /**
     * Update the social attributes, merging existing attributes with new attributes.
     *
     * @param mixed[] $newAttributes
     */
    function update_Attributes($newAttributes) {
        $this->debugMP('pr',__FUNCTION__,$newAttributes);
        if (is_array($newAttributes)) { 
            $this->attributes =
                is_array($this->attributes)                     ?
                array_merge($this->attributes,$newAttributes)   :
                $newAttributes
                ;
            $this->dataChanged = true;
        }
    }
}
