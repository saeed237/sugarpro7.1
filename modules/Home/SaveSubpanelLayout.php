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




global $current_user;

if(!empty($_REQUEST['layout']) && !empty($_REQUEST['layoutModule'])) {
//    sleep (2);
//  _ppd($_REQUEST['layout']); 
    $subpanels = explode(',', $_REQUEST['layout']);
    
    $layoutParam = $_REQUEST['layoutModule'];
    
    if(!empty($_REQUEST['layoutGroup']) && $_REQUEST['layoutGroup']!= translate('LBL_TABGROUP_ALL')) {
    	$layoutParam .= ':'.$_REQUEST['layoutGroup'];
    }
    
    $current_user->setPreference('subpanelLayout', $subpanels, 0, $layoutParam);
}
else {
    echo 'oops';
}

?>