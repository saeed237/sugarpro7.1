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


require_once('include/SugarFields/Fields/Float/SugarFieldFloat.php');

class SugarFieldCurrency extends SugarFieldFloat 
{
    function getListViewSmarty($parentFieldArray, $vardef, $displayParams, $col) {
        $tabindex = 1;
    	$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex, false);
        
        $this->ss->left_delimiter = '{';
        $this->ss->right_delimiter = '}';
        $this->ss->assign('col',strtoupper($vardef['name']));        
	    if(is_object($parentFieldArray) ){
            if(!empty($parentFieldArray->currency_id)) {
                $this->ss->assign('currency_id',$parentFieldArray->currency_id);
            }
	    } else if (!empty($parentFieldArray['CURRENCY_ID'])) {
	    	$this->ss->assign('currency_id',$parentFieldArray['CURRENCY_ID']);
	    } else if (!empty($parentFieldArray['currency_id'])) {
	    	$this->ss->assign('currency_id',$parentFieldArray['currency_id']);
	    }
        return $this->fetch($this->findTemplate('ListView'));
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
        $value = str_replace($settings->currency_symbol,"",$value);
        
        return $settings->float($value,$vardef,$focus);
    }


    /**
     * Handles export field sanitizing for field type
     *
     * @param $value string value to be sanitized
     * @param $vardef array representing the vardef definition
     * @param $focus SugarBean object
     * @param $row Array of a row of data to be exported
     *
     * @return string sanitized value
     */
    public function exportSanitize($value, $vardef, $focus, $row = array())
    {
        require_once('include/SugarCurrency/SugarCurrency.php');
        if (isset($vardef['convertToBase']) && $vardef['convertToBase']) {
            // convert amount to base
            $baseRate = isset($row['base_rate']) ? $row['base_rate'] : $focus->base_rate;
            $value = SugarCurrency::convertWithRate($value, $baseRate);
            $currency_id = '-99';
        } else {
            //If the row has a currency_id set, use that instead of the $focus->currency_id value
            $currency_id = isset($row['currency_id']) ? $row['currency_id'] : $focus->currency_id;
        }
        return SugarCurrency::formatAmountUserLocale($value, $currency_id);
    }

    /**
	 * format the currency field based on system locale values for currency
     * Note that this may be different from the precision specified in the vardefs.
	 * @param string $rawfield value of the field
     * @param string $somewhere vardef for the field being processed
	 * @return number formatted according to currency settings
	 */
    public function formatField($rawField, $vardef){
        // for currency fields, use the user or system precision, not the precision in the vardef
        //this is achived by passing in $precision as null
        $precision = null;

        if ( $rawField === '' || $rawField === NULL ) {
            return '';
        }
        return format_number($rawField,$precision,$precision);
    }
}