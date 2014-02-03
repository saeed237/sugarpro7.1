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


require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

    class SugarFieldEncrypt extends SugarFieldBase {

    /**
     * Decrypt encrypt fields values before inserting them into the emails
     *
     * @param string $inputField
     * @param mixed $vardef
     * @param mixed $displayParams
     * @param int $tabindex
     * @return string
     */
	public function getEmailTemplateValue($inputField, $vardef, $displayParams = array(), $tabindex = 0){
        // Uncrypt the value
        $account = BeanFactory::getBean('Empty');
        return $account->decrypt_after_retrieve($inputField);
    }
}
?>
