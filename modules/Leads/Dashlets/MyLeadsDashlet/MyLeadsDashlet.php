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


class MyLeadsDashlet extends DashletGeneric { 
    function MyLeadsDashlet($id, $def = null) {
        global $current_user, $app_strings;
		require('modules/Leads/Dashlets/MyLeadsDashlet/MyLeadsDashlet.data.php');
		
        parent::DashletGeneric($id, $def);
         
        if(empty($def['title'])) $this->title = translate('LBL_LIST_MY_LEADS', 'Leads');
        
        $this->searchFields = $dashletData['MyLeadsDashlet']['searchFields'];
        $this->columns = $dashletData['MyLeadsDashlet']['columns'];
        $this->seedBean = BeanFactory::getBean('Leads');        
    }
}

?>
