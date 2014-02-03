<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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




require_once('data/SugarBeanApiHelper.php');

class QuotesApiHelper extends SugarBeanApiHelper
{
    /**
     * This function sets up shipping and billing address for new Quote.
     *
     * @param SugarBean $bean
     * @param array $submittedData
     * @param array $options
     * @return array
     */
    public function populateFromApi(SugarBean $bean, array $submittedData, array $options = array())
    {
        $data = parent::populateFromApi($bean, $submittedData, $options);

        // Bug #57888 : REST API: Create related quote must populate billing/shipping contact and account
        if ( isset($submittedData['module']) && $submittedData['module'] == 'Contacts' && isset($submittedData['record']) )
        {
            $contactBean = BeanFactory::getBean('Contacts', $submittedData['record']);
            $bean->shipping_contact_id = $submittedData['record'];
            $bean->billing_contact_id = $submittedData['record'];

            $bean->shipping_address_street      = $this->getAddressFormContact ($bean->shipping_address_street, $contactBean, 'address_street' );
            $bean->shipping_address_city        = $this->getAddressFormContact( $bean->shipping_address_city, $contactBean, 'address_city' );
            $bean->shipping_address_state       = $this->getAddressFormContact( $bean->shipping_address_state, $contactBean, 'address_state' );
            $bean->shipping_address_postalcode  = $this->getAddressFormContact( $bean->shipping_address_postalcode, $contactBean, 'address_street' );
            $bean->shipping_address_country     = $this->getAddressFormContact( $bean->shipping_address_country, $contactBean, 'address_street' );

            if ( !empty($contactBean->account_id) )
            {
                $bean->billing_account_id = $contactBean->account_id;
                $bean->billing_address_street      = $this->getAddressFormContact ($bean->billing_address_street, $contactBean, 'address_street' );
                $bean->billing_address_city        = $this->getAddressFormContact( $bean->billing_address_city, $contactBean, 'address_city' );
                $bean->billing_address_state       = $this->getAddressFormContact( $bean->billing_address_state, $contactBean, 'address_state' );
                $bean->billing_address_postalcode  = $this->getAddressFormContact( $bean->billing_address_postalcode, $contactBean, 'address_street' );
                $bean->billing_address_country     = $this->getAddressFormContact( $bean->billing_address_country, $contactBean, 'address_street' );
            }
        }

        return $data;
    }

    protected function getAddressFormContact($bean_property, $bean, $property)
    {
        $primary_property = 'primary_'.$property;
        $alt_property = 'alt_'.$property;
        return !empty($bean_property) ? $bean_property
            : ( isset($bean->$primary_property) ? $bean->$primary_property
                : ( isset($bean->$alt_property) ? $bean->$alt_property
                    : '' ) );
    }
}
