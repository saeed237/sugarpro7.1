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


class ViewQuickview extends SugarView{
	function ViewQuickview(){
		parent::SugarView();
	}

	function display()
	{
	    $focus = BeanFactory::getBean('Notifications', empty($_REQUEST['record']) ? "" : $_REQUEST['record']);

	    if(!empty($focus->id)) {
    	    //Mark as read.
    	    $focus->is_read = true;
    	    $focus->save(FALSE);
	    }

	    $results = array('contents' => $this->_formatNotificationForDisplay($focus) );

	    $json = getJSONobj();
		$out = $json->encode($results);
		ob_clean();
		print($out);
		sugar_cleanup(true);

	}

	function _formatNotificationForDisplay($notification)
    {
        global $app_strings;
        $this->ss->assign('APP', $app_strings);
        $this->ss->assign('focus', $notification);
        return $this->ss->fetch("modules/Notifications/tpls/detailView.tpl");
    }
}