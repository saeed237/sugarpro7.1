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

require_once('include/SugarObjects/templates/basic/Basic.php');

class Company extends Basic
{

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function Company()
    {
        self::__construct();
    }

 	/**
 	 * Constructor
 	 */
    public function __construct()
 	{
 		parent::__construct();
 		$this->emailAddress = BeanFactory::getBean('EmailAddresses');
 	}

    /**
     *
     * @see parent::save()
     */
    public function save($check_notify = false)
    {
        if (static::inOperation('saving_related')) {
            parent::save($check_notify);
            return $this;
        }
        $this->add_address_streets('billing_address_street');
        $this->add_address_streets('shipping_address_street');
        $ori_in_workflow = empty($this->in_workflow) ? false : true;
        $this->emailAddress->handleLegacySave($this, $this->module_dir);
        parent::save($check_notify);
        $override_email = array();
        if (!empty($this->email1_set_in_workflow)) {
            $override_email['emailAddress0'] = $this->email1_set_in_workflow;
        }
        if (!empty($this->email2_set_in_workflow)) {
            $override_email['emailAddress1'] = $this->email2_set_in_workflow;
        }
        if (!isset($this->in_workflow)) {
            $this->in_workflow = false;
        }
        if ($ori_in_workflow === false || !empty($override_email)) {
            $this->emailAddress->save($this->id, $this->module_dir, $override_email, '', '', '', '',
                $this->in_workflow);
        }
        return $this;
    }

 	/**
 	 * Populate email address fields here instead of retrieve() so that they are properly available for logic hooks
 	 *
 	 * @see parent::fill_in_relationship_fields()
 	 */
	public function fill_in_relationship_fields()
	{
	    parent::fill_in_relationship_fields();
	    $this->emailAddress->handleLegacyRetrieve($this);
	}

	/**
 	 * @see parent::get_list_view_data()
 	 */
	public function get_list_view_data()
	{
		global $system_config;
		global $current_user;
		$temp_array = $this->get_list_view_array();
		$temp_array['EMAIL1'] = $this->emailAddress->getPrimaryAddress($this);
		$temp_array['EMAIL1_LINK'] = $current_user->getEmailLink('email1', $this, '', '', 'ListView');
		return $temp_array;
	}
}
