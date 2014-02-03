<?php
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


/**
 * SugarFieldJson.php
 * 
 * A sugar field that json encodes the content of the field.
 *
 */

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldJson extends SugarFieldBase {
	/**
     * This function handles turning the API's version of a teamset into what we actually store
     * @param SugarBean $bean - the bean performing the save
     * @param array $params - an array of paramester relevant to the save, which will be an array passed up to the API
     * @param string $fieldName - The name of the field to save (the vardef name, not the form element name)
     * @param array $properties - Any properties for this field
     */
    public function apiSave(SugarBean $bean, array $params, $fieldName, $properties) {
        // json encode the content
    	$bean->$fieldName = json_encode($params[$fieldName]);
    }
    
    /**
     * This function will decode the json
     * 
     * @param array     $data
     * @param SugarBean $bean
     * @param array     $args
     * @param string    $fieldName
     * @param array     $properties
     */
    
    public function apiFormatField(array &$data, SugarBean $bean, array $args, $fieldName, $properties) {
        if(isset($bean->$fieldName)) {
            $data[$fieldName] = json_decode($bean->$fieldName, true);
        }
    }

    
}
?>