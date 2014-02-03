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

class SugarFieldPassword extends SugarFieldBase 
{
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
        $value = md5($value);
        
        return $value;
    }

   /**
     * This function will set any password field to true if there is
     * a password, else null
     * @param array $data
     * @param SugarBean $bean
     * @param array $args
     * @param string $fieldName
     * @param array $properties
     */
    public function apiFormatField(array &$data, SugarBean $bean, array $args, $fieldName, $properties)
    {
        $data[$fieldName] = true;
        if(empty($bean->$fieldName)) {
            $data[$fieldName] = null;
        }
    }

    /**
     * Encrypt and save a password
     * {@inheritdoc}
     */
    public function apiSave(SugarBean $bean, array $params, $fieldName, $properties)
    {
        if(!isset($params[$fieldName])) {
            return;
        }
        if(empty($params[$fieldName])) {
            $bean->$fieldName = null;
        } elseif($params[$fieldName] !== true) {
            $bean->$fieldName = User::getPasswordHash($params[$fieldName]);
        }
    }
}
?>