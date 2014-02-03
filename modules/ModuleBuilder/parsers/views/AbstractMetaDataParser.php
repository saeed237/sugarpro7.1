<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
 ********************************************************************************/


abstract class AbstractMetaDataParser
{
    /**
     * The client making this request for the parser. Default is empty. NOT ALL
     * PARSERS SET THIS.
     *
     * @var string
     */
    public $client;

    //Make these properties public for now until we can create some usefull accessors
    public $_fielddefs;
    public $_viewdefs;
    public $_paneldefs = array();
	protected $_moduleName;

    /**
     * object to handle the reading and writing of files and field data
     *
     * @var DeployedMetaDataImplementation|UndeployedMetaDataImplementation
     */
    protected $implementation;

    function getLayoutAsArray ()
    {
        $viewdefs = $this->_panels ;
    }

    function getLanguage ()
    {
        return $this->implementation->getLanguage () ;
    }

    function getHistory ()
    {
        return $this->implementation->getHistory () ;
    }

    public function getFieldDefs()
    {
        return $this->_fielddefs;
    }

    public function getPanelDefs() {
        return $this->_paneldefs;
    }

    function removeField ($fieldName)
    {
    	return false;
    }

    public function useWorkingFile() {
        return $this->implementation->useWorkingFile();
    }

    /*
     * Is this field something we wish to show in Studio/ModuleBuilder layout editors?
     *
     * @param array $def     Field definition in the standard SugarBean field definition format - name, vname, type and so on
     * @param string $view   The name of the view
     * @param string $client The client for this request
     * @return boolean       True if ok to show, false otherwise
     */
    static function validField($def, $view = "", $client = '')
    {
        //Studio invisible fields should always be hidden
        if (isset($def['studio'])) {
            if (is_array($def['studio'])) {
                // Handle client specific studio setting for a field
                $clientRules = self::getClientStudioValidation($def['studio'], $view, $client);
                if ($clientRules !== null) {
                    return $clientRules;
                }
                
                if (!empty($view) && isset($def['studio'][$view])) {
                    return $def [ 'studio' ][$view] !== false && $def [ 'studio' ][$view] !== 'false' && $def [ 'studio' ][$view] !== 'hidden';
                }
                
                if (isset($def['studio']['visible'])) {
                    return $def['studio']['visible'];
                }
            } else {
                return ($def [ 'studio' ] != 'false' && $def [ 'studio' ] != 'hidden' && $def [ 'studio' ] !== false) ;
			}
        }

        // bug 19656: this test changed after 5.0.0b - we now remove all ID type fields - whether set as type, or dbtype, from the fielddefs
        return
		(
		  (
		    (empty ( $def [ 'source' ] ) || $def [ 'source' ] == 'db' || $def [ 'source' ] == 'custom_fields')
			&& isset($def [ 'type' ]) && $def [ 'type' ] != 'id' && $def [ 'type' ] != 'parent_type'
			&& (empty ( $def [ 'dbType' ] ) || $def [ 'dbType' ] != 'id')
			&& ( isset ( $def [ 'name' ] ) && strcmp ( $def [ 'name' ] , 'deleted' ) != 0 )
		  ) // db and custom fields that aren't ID fields
          ||
		  // exclude fields named *_name regardless of their type...just convention
          (isset ( $def [ 'name' ] ) && substr ( $def [ 'name' ], -5 ) === '_name' ) ) ;
    }

	protected function _standardizeFieldLabels ( &$fielddefs )
	{
		foreach ( $fielddefs as $key => $def )
		{
			if ( !isset ($def [ 'label' ] ) )
			{
				$fielddefs [ $key ] [ 'label'] = ( isset ( $def [ 'vname' ] ) ) ? $def [ 'vname' ] : $key ;
			}
		}
	}

	abstract static function _trimFieldDefs ( $def ) ;

	public function getRequiredFields(){
	    $fieldDefs = $this->implementation->getFielddefs();
	    $newAry = array();
	    foreach($fieldDefs as $field){
	        if(isset($field['required']) && $field['required'] && isset($field['name']) && empty( $field['readonly'])) {
	            array_push($newAry , '"'.$field['name'].'"');
            }
        }
        return $newAry;
	}

    /**
     * Used to determine if a field property is true or false given that it could be
     * the boolean value or a string value such use 'false' or '0'
     * @static
     * @param $val
     * @return bool
     */
    protected static function isTrue($val)
    {
        if (is_string($val))
        {
            $str = strtolower($val);
            return ($str != '0' && $str != 'false' && $str != "");
        }
        //For non-string types, juse use PHP's normal boolean conversion
        else{
            return ($val == true);
        }

        return true;
    }

    /**
     * Public accessor for the isTrue method, to allow handlers outside of the
     * parsers to test truthiness of a value in metadata
     *
     * @static
     * @param mixed $val
     * @return bool
     */
    public static function isTruthy($val) {
        return self::isTrue($val);
    }

    /**
     * Cache killer, to be defined in child classes as needed.
     */
    protected function _clearCaches() {}
    
    /**
     * Gets client specific vardef rules for a field for studio
     * 
     * @param Array $studio The value of $defs['studio']
     * @param string $view A view name, which could be empty
     * @param string $client The client for this request
     * @return bool|null Boolean if there is a setting for a client, null otherwise
     */
    public static function getClientStudioValidation(Array $studio, $view, $client)
    {
        // Handle client specific studio setting for a field
        if ($client && isset($studio[$client])) {
            // Posibilities are:
            // studio[client] = true|false
            // studio[client] = array(view => true|false)
            if (is_bool($studio[$client])) {
                return $studio[$client];
            }
            
            // Check for a client -> specific studio setting
            if (!empty($view) && is_array($studio[$client]) && isset($studio[$client][$view])) {
                return $studio[$client][$view] !== false;
            }
        }
        
        return null;
    }
}