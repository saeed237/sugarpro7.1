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



/**
 * SugarFieldAddress.php
 * SugarFieldAddress translates and displays fields from a vardef definition into different formats
 * for EditViews and DetailViews.  A sample invocation from a Meta-Data file is as follows:
 * 
 *  array (
 * 	   'name' => 'primary_address_street',
 *	   'type' => 'address',
 *	   'displayParams'=>array('key'=>'primary'),
 *  ),
 * 
 * Where name is set to the field for ACL verification, type is set to 'address'
 * to override the default field type and the displayParams array includes the key
 * for the address field.  Assumptions are made that the vardefs.php contains address
 * elements with the corresponding names. There is the optional displayParam index
 * 'copy' that accepts as value the key of the other address fields.  In our
 * example we may enable copying from the primary address fields with:
 * 
 *  array (
 * 	   'name' => 'altaddress_street',
 *	   'type' => 'address',
 *	   'displayParams'=>array('key'=>'alt', 'copy'=>'primary'),
 *  ),
 * 
 */
require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');
class SugarFieldAddress extends SugarFieldBase {

    function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        global $app_strings;
        if(!isset($displayParams['key'])) {
           $GLOBALS['log']->debug($app_strings['ERR_ADDRESS_KEY_NOT_SPECIFIED']);	
           $this->ss->trigger_error($app_strings['ERR_ADDRESS_KEY_NOT_SPECIFIED']);
           return;
        }
        
        //Allow for overrides.  You can specify a Smarty template file location in the language file.
        if(isset($app_strings['SMARTY_ADDRESS_DETAILVIEW'])) {
           $tplCode = $app_strings['SMARTY_ADDRESS_DETAILVIEW'];
           return $this->fetch($tplCode);	
        }
        
        return $this->fetch($this->findTemplate('DetailView'));
    }
    
    function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);        
        global $app_strings;
        if(!isset($displayParams['key'])) {
           $GLOBALS['log']->debug($app_strings['ERR_ADDRESS_KEY_NOT_SPECIFIED']);	
           $this->ss->trigger_error($app_strings['ERR_ADDRESS_KEY_NOT_SPECIFIED']);
           return;
        }
        
        //Allow for overrides.  You can specify a Smarty template file location in the language file.
        if(isset($app_strings['SMARTY_ADDRESS_EDITVIEW'])) {
           $tplCode = $app_strings['SMARTY_ADDRESS_EDITVIEW'];
           return $this->fetch($tplCode);	
        }       

        return $this->fetch($this->findTemplate('EditView'));      
    }
    
}
?>
