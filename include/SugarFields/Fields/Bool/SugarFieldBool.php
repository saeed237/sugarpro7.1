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


require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldBool extends SugarFieldBase {
	/**
	 *
	 * @return The html for a drop down if the search field is not 'my_items_only' or a dropdown for all other fields.
	 *			This strange behavior arises from the special needs of PM. They want the my items to be checkboxes and all other boolean fields to be dropdowns.
	 * @author Navjeet Singh
	 * @param $parentFieldArray -
	 **/
	function getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
		$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
		//If there was a type override to specifically render it as a boolean, show the EditView checkbox
		if( preg_match("/(favorites|current_user|open)_only.*/", $vardef['name']))
		{
			return $this->fetch($this->findTemplate('EditView'));
		} else {
			return $this->fetch($this->findTemplate('SearchView'));
		}
	}

    /**
     * @see SugarFieldBase::importSanitize()
     */
    public function importSanitize(
        $value,
        $vardef,
        $focus,
        ImportFieldSanitize $settings
        )
    {
        $bool_values = array(0=>'0',1=>'no',2=>'off',3=>'n',4=>'yes',5=>'y',6=>'on',7=>'1');
        $bool_search = array_search($value,$bool_values);
        if ( $bool_search === false ) {
            return false;
        }
        else {
            //Convert all the values to a real bool.
            $value = (int) ( $bool_search > 3 );
        }
        if ( isset($vardef['dbType']) && $vardef['dbType'] == 'varchar' )
            $value = ( $value ? 'on' : 'off' );

        return $value;
    }

    public function getEmailTemplateValue($inputField, $vardef, $context = null){
        global $app_list_strings;
        // This does not return a smarty section, instead it returns a direct value
        if ( $inputField == 'bool_true' || $inputField === true ) { // Note: true must be absolute true
            return $app_list_strings['checkbox_dom']['1'];
        } else if ( $inputField == 'bool_false' || $inputField === false){ // Note: false must be absolute false
            return $app_list_strings['checkbox_dom']['2'];
        } else { // otherwise we return blank display
            return '';
        }
    }

    public function unformatField($formattedField, $vardef){
        if ( empty($formattedField) ) {
            $unformattedField = false;
            return $unformattedField;
        }
        if ( $formattedField === '0' || $formattedField === 'off' || $formattedField === 'false' || $formattedField === 'no' ) {
            $unformattedField = false;
        } else {
            $unformattedField = true;
        }

        return $unformattedField;
    }

    /**
     * Formats a field for the Sugar API
     *
     * @param array     $data
     * @param SugarBean $bean
     * @param array     $args
     * @param string    $fieldName
     * @param array     $properties
     */
    public function apiFormatField(&$data, $bean, $args, $fieldName, $properties) {
        if (isset($bean->$fieldName)) {
            $data[$fieldName] = $this->normalizeBoolean($bean->$fieldName);
        } else {
            $data[$fieldName] = null;
        }
    }    

}

?>
