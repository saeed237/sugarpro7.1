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




$listViewDefs['SavedSearch'] = array(
	'NAME' => array(
		'width' => '40%', 		
		'label' => 'LBL_LIST_NAME',
		'link' => true,
		'customCode' => '<a  href="index.php?action=index&module=SavedSearch&saved_search_select={$ID}">{$NAME}</a>'),
	'SEARCH_MODULE' => array(
		'width' => '35%', 
		'label' => 'LBL_LIST_MODULE'), 
	'TEAM_NAME' => array(
		'width' => '15%', 
		'label' => 'LBL_LIST_TEAM',
		'default' => false),
	'ASSIGNED_USER_NAME' => array(
		'width' => '10%', 
		'label' => 'LBL_LIST_ASSIGNED_USER')
);
?>
