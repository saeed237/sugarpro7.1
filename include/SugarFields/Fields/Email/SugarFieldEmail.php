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

require_once 'include/SugarFields/Fields/Base/SugarFieldBase.php';

class SugarFieldEmail extends SugarFieldBase
{
    /**
     * Formats a field for the Sugar API, unsets the email
     * record from the data array if the user does not have access
     *
     * @param array $data
     * @param SugarBean $bean
     * @param array $args
     * @param string $fieldName
     * @param array $properties
     */    
    public function apiFormatField(&$data, $bean, $args, $fieldName, $properties)
    {
        $emailsRaw = $bean->emailAddress->getAddressesByGUID($bean->id, $bean->module_name);

        if (!empty($emailsRaw)) {
            array_walk($emailsRaw, array($this, "formatEmails"));
            $data[$fieldName] = $emailsRaw;
        } else {
            $data[$fieldName] = array();
        }
    }
    /**
     * This should be called when the bean is saved from the API. 
     * Most fields can just use default, which calls the field's 
     * individual ->save() function instead.
     * 
     * @param SugarBean $bean the bean performing the save
     * @param array $params an array of paramester relevant to the save, which will be an array passed up to the API
     * @param string $field The name of the field to save (the vardef name, not the form element name)
     * @param array $properties Any properties for this field
     */
    public function apiSave(SugarBean $bean, array $params, $field, $properties)
    {
        if (!is_array($params[$field])) {
            // Not an array, don't do anything.
            return;
        }

        if (!isset($bean->emailAddress)) {
            $bean->emailAddress = BeanFactory::getBean('EmailAddresses');
        }
        
        array_walk($params[$field], array($this, 'formatEmails'));
        
        $bean->emailAddress->addresses = array();
        foreach ($params[$field] as $email ) {
            if (empty($email['email_address'])) {
                // Can't save an empty email address
                continue;
            }
            $email['primary_address'] = isset($email['primary_address'])?$email['primary_address']:false;
            $email['invalid_email'] = isset($email['invalid_email'])?$email['invalid_email']:false;
            $email['opt_out'] = isset($email['opt_out'])?$email['opt_out']:false;

            $bean->emailAddress->addAddress($email['email_address'],
                                            $email['primary_address'],
                                            false,
                                            $email['invalid_email'],
                                            $email['opt_out']);
        }

        $bean->emailAddress->save($bean->id, $bean->module_dir, $params[$field]);

        // Here is a hack for SugarEmailAddress.php so it doesn't attempt a legacy save
        $bean->emailAddress->dontLegacySave = true;
    }

    /**
     * Format a Raw email array record from the email_address relationship
     * 
     * @param array $rawEmail 
     * @return array
     */
    public function formatEmails(array &$rawEmail, $key) 
    {
        static $emailProperties = array(
            'email_address' => true,
            'opt_out' => true,
            'invalid_email' => true,
            'primary_address' => true,
            'reply_to_address' => true,
        );

        static $boolProperties = array(
            'opt_out',
            'invalid_email',
            'primary_address',
            'reply_to_address',
        );            

        $rawEmail = array_intersect_key($rawEmail, $emailProperties);
        
        foreach ($boolProperties as $prop) {
            if (isset($rawEmail[$prop])) {
                $rawEmail[$prop] = (bool)$rawEmail[$prop];
            }
        }
        
        if (isset($rawEmail['email_address'])) {
            $rawEmail['email_address'] = trim($rawEmail['email_address']);
        }
    }
}
