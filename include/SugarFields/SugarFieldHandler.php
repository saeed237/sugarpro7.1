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
 * Handle Sugar fields
 * @api
 */
class SugarFieldHandler
{

    function SugarFieldHandler() {
    }

    static function fixupFieldType($field) {
            switch($field) {
               case 'double':
               case 'decimal':
                    $field = 'float';
                    break;
               case 'uint':
               case 'ulong':
               case 'long':
               case 'short':
               case 'tinyint':
                    $field = 'int';
                    break;
               case 'url':
               		$field = 'link';
               		break;
               case 'varchar':
                    $field = 'base';
                    break;
            }

        return ucfirst($field);
    }

    /**
     * return the singleton of the SugarField
     *
     * @param field string field type
     */
    static function getSugarField($field, $returnNullIfBase=false) {
        static $sugarFieldObjects = array();

        $field = self::fixupFieldType($field);
        $field = ucfirst($field);

        if(!isset($sugarFieldObjects[$field])) {
        	//check custom directory
        	$file = SugarAutoLoader::existingCustomOne("include/SugarFields/Fields/{$field}/SugarField{$field}.php");

        	if($file) {
                $type = $field;
        	} else {
                // No direct class, check the directories to see if they are defined
        		if( $returnNullIfBase &&
        		    !SugarAutoLoader::existing('include/SugarFields/Fields/'.$field)) {
                    return null;
                }
        		$file = 'include/SugarFields/Fields/Base/SugarFieldBase.php';
                $type = 'Base';
        	}
			require_once($file);

			$class = SugarAutoLoader::customClass('SugarField' . $type);
			//could be a custom class check it
       		$sugarFieldObjects[$field] = new $class($field);
        }
        return $sugarFieldObjects[$field];
    }

    /**
     * Returns the smarty code to be used in a template built by TemplateHandler
     * The SugarField class is choosen dependant on the vardef's type field.
     *
     * @param parentFieldArray string name of the variable in the parent template for the bean's data
     * @param vardef vardef field defintion
     * @param displayType string the display type for the field (eg DetailView, EditView, etc)
     * @param displayParam parameters for displayin
     *      available paramters are:
     *      * labelSpan - column span for the label
     *      * fieldSpan - column span for the field
     */
    static function displaySmarty($parentFieldArray, $vardef, $displayType, $displayParams = array(), $tabindex = 1) {
        $string = '';
        $displayTypeFunc = 'get' . $displayType . 'Smarty'; // getDetailViewSmarty, getEditViewSmarty, etc...

		// This will handle custom type fields.
		// The incoming $vardef Array may have custom_type set.
		// If so, set $vardef['type'] to the $vardef['custom_type'] value
		if(isset($vardef['custom_type'])) {
		   $vardef['type'] = $vardef['custom_type'];
		}
		if(empty($vardef['type'])) {
			$vardef['type'] = 'varchar';
		}

		$field = self::getSugarField($vardef['type']);
		if ( !empty($vardef['function']) ) {
			$string = $field->displayFromFunc($displayType, $parentFieldArray, $vardef, $displayParams, $tabindex);
		} else {
			$string = $field->$displayTypeFunc($parentFieldArray, $vardef, $displayParams, $tabindex);
		}

        return $string;
    }
}


?>