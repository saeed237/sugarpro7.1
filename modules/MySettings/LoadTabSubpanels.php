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


/**
 * Created on Jul 17, 2006
 * Ajax Procedure for loading all subpanels for a certain subpanel tab.
 */

require_once('include/DetailView/DetailView.php');
$detailView = new DetailView();

$focus = BeanFactory::getBean($_REQUEST['loadModule']);
$focus->id = $_REQUEST['record'];

require_once('include/SubPanel/SubPanelTiles.php');
$subpanel = new SubPanelTiles($focus, $_REQUEST['loadModule']);

if(!function_exists('get_form_header')) {
    global $theme;

}

// set up data for subpanels
global $currentModule;
$currentModule = $_REQUEST['loadModule'];
$_REQUEST['action'] = 'DetailView';

//This line of code is critical.  We need to ensure that the global controller bean is set to the $currentModule global variable
$GLOBALS['app']->controller->bean = $focus;
echo $subpanel->display(false);
?>
