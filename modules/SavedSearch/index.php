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

/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

	
if(!empty($_REQUEST['saved_search_action'])) {

	$ss = BeanFactory::getBean('SavedSearch');
	
	switch($_REQUEST['saved_search_action']) {
        case 'update': // save here
        	$savedSearchBean = BeanFactory::getBean($_REQUEST['search_module']);
            $ss->handleSave('', true, false, $_REQUEST['saved_search_select'], $savedSearchBean);
            break;
		case 'save': // save here
			$savedSearchBean = BeanFactory::getBean($_REQUEST['search_module']);
			$ss->handleSave('', true, false, null, $savedSearchBean);
			break;
		case 'delete': // delete here
			$ss->handleDelete($_REQUEST['saved_search_select']);
			break;			
	}
}
elseif(!empty($_REQUEST['saved_search_select'])) { // requesting a search here.
    if(!empty($_REQUEST['searchFormTab'])) // where is the request from  
        $searchFormTab = $_REQUEST['searchFormTab'];
    else 
        $searchFormTab = 'saved_views';

	if($_REQUEST['saved_search_select'] == '_none') { // none selected
		$_SESSION['LastSavedView'][$_REQUEST['search_module']] = '';
        $current_user->setPreference('ListViewDisplayColumns', array(), 0, $_REQUEST['search_module']);
        $ajaxLoad = empty($_REQUEST['ajax_load']) ? "" : "&ajax_load=" . $_REQUEST['ajax_load'];
        header("Location: index.php?action=index&module={$_REQUEST['search_module']}&searchFormTab={$searchFormTab}&query=true&clear_query=true$ajaxLoad");
		die();
	}
	else {
		
		$ss = BeanFactory::getBean('SavedSearch');
        $show='no';
        if(isset($_REQUEST['showSSDIV'])){$show = $_REQUEST['showSSDIV'];}
		$ss->returnSavedSearch($_REQUEST['saved_search_select'], $searchFormTab, $show);
	}
}
else {
	include('modules/SavedSearch/ListView.php');
}

?>