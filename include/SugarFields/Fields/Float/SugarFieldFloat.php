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


require_once('include/SugarFields/Fields/Int/SugarFieldInt.php');

class SugarFieldFloat extends SugarFieldInt 
{
    public function formatField($rawField, $vardef){
        // A null precision uses the user prefs / system prefs by default
        $precision = null;
        if ( isset($vardef['precision']) ) {
            $precision = $vardef['precision'];
        }
        
        if ( $rawField === '' || $rawField === NULL ) {
            return '';
        }

        return format_number($rawField,$precision,$precision);
    }

    public function apiFormatField(&$data, $bean, $args, $fieldName, $properties){
        $data[$fieldName] = isset($bean->$fieldName) && is_numeric($bean->$fieldName)
                            ? (float)$bean->$fieldName : null;
    }

    public function unformatField($formattedField, $vardef){
        if ( $formattedField === '' || $formattedField === NULL ) {
            return '';
        }
        return (float)unformat_number($formattedField);
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
        $value = str_replace($settings->num_grp_sep,"",$value);
        $dec_sep = $settings->dec_sep;
        if ( $dec_sep != '.' ) {
            $value = str_replace($dec_sep,".",$value);
        }
        if ( !is_numeric($value) ) {
            return false;
        }
        
        return $value;
    }
}
