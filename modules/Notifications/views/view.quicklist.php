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


class ViewQuicklist extends SugarView{
	function ViewQuicklist(){
		parent::SugarView();
	}

	function display()
	{
		global $current_user;
		
	    $query_fields = array('is_read' => 0,'assigned_user_id' => $current_user->id);
	    $n = BeanFactory::getBean('Notifications');
	    $where = "is_read = '0'";
	    //$data = $n->get_list('date_entered',$where);
	   $n1 = BeanFactory::getBean('Notifications');
	   $n1->name = 'Roger';
	   $data['list'][] = $n1;
		echo $this->_formatNotificationsForQuickDisplay($data['list'], "modules/Notifications/tpls/quickView.tpl");
	}
	function _formatNotificationsForQuickDisplay($notifications, $tplFile)
    {
        global $app_strings;
        $this->ss->assign('APP', $app_strings);
        $this->ss->assign('data', $notifications);
        return $this->ss->display($tplFile);
    }
}