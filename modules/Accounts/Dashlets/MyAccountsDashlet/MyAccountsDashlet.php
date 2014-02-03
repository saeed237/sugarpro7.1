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





require_once('include/Dashlets/DashletGeneric.php');


class MyAccountsDashlet extends DashletGeneric { 
    function MyAccountsDashlet($id, $def = null) {
		global $current_user, $app_strings;
		require('modules/Accounts/Dashlets/MyAccountsDashlet/MyAccountsDashlet.data.php');

        parent::DashletGeneric($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'Accounts');

        $this->searchFields = $dashletData['MyAccountsDashlet']['searchFields'];
        $this->columns = $dashletData['MyAccountsDashlet']['columns'];

        $this->seedBean = BeanFactory::getBean('Accounts');        
    }
    
    /**
     * Overrides the generic process to include custom logic for email addresses,
     * since they are no longer stored in  a list view friendly manner.
     * (A record may have an undetermined number of email addresses).
     *
     * @param array $lvsParams
     */
     
	function process($lvsParams = array()) {
    	if (isset($this->displayColumns) && array_search('email1', $this->displayColumns) !== false) {
	    	$lvsParams['custom_select'] = ', email_address as email1';
	    	$lvsParams['custom_from'] = ' LEFT JOIN email_addr_bean_rel eabr ON eabr.deleted = 0 AND bean_module = \'Accounts\''
	    							  . ' AND eabr.bean_id = accounts.id AND primary_address = 1'
	    							  . ' LEFT JOIN email_addresses ea ON ea.deleted = 0 AND ea.id = eabr.email_address_id';
    	}
    	
        if (isset($this->displayColumns) && array_search('parent_name', $this->displayColumns) !== false) {
	    	$lvsParams['custom_select'] = empty($lvsParams['custom_select']) ? ', a1.name as parent_name ' : $lvsParams['custom_select'] . ', a1.name as parent_name ';
	    	$lvsParams['custom_from'] = empty($lvsParams['custom_from']) ? ' LEFT JOIN accounts a1 on a1.id = accounts.parent_id' : $lvsParams['custom_from'] . ' LEFT JOIN accounts a1 on a1.id = accounts.parent_id';
    	}    	

    	parent::process($lvsParams);
    }
}

?>
