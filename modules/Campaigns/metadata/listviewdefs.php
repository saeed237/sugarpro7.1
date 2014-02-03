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



global $theme, $mod_strings;

$listViewDefs['Campaigns'] = array(
	'NAME' => array(
		'width' => '20', 
		'label' => 'LBL_LIST_CAMPAIGN_NAME',
        'link' => true,
        'default' => true), 
	'STATUS' => array(
		'width' => '10', 
		'label' => 'LBL_LIST_STATUS',
        'default' => true),
    'CAMPAIGN_TYPE' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_TYPE',
        'default' => true),
    'END_DATE' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_END_DATE',
        'default' => true),        
        
	'TEAM_NAME' => array(
		'width' => '15', 
		'label' => 'LBL_LIST_TEAM',
        'default' => false),
	'ASSIGNED_USER_NAME' => array(
		'width' => '8', 
		'label' => 'LBL_LIST_ASSIGNED_USER',
		'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true),
    'TRACK_CAMPAIGN' => array(
        'width' => '1', 
        'label' => '&nbsp;',
        'link' => true,
        'customCode' => ' <a title="{$TRACK_CAMPAIGN_TITLE}" href="index.php?action=TrackDetailView&module=Campaigns&record={$ID}"><!--not_in_theme!--><img border="0" src="{$TRACK_CAMPAIGN_IMAGE}" alt="{$TRACK_VIEW_ALT_TEXT}"></a> ',
        'default' => true,
        'studio' => false,
        'nowrap' => true,
        'sortable' => false),      
    'LAUNCH_WIZARD' => array(
        'width' => '1', 
        'label' => '&nbsp;',
        'link' => true,
        'customCode' => ' <a title="{$LAUNCH_WIZARD_TITLE}" href="index.php?action=WizardHome&module=Campaigns&record={$ID}"><!--not_in_theme!--><img border="0" src="{$LAUNCH_WIZARD_IMAGE}"  alt="{$LAUNCH_WIZ_ALT_TEXT}"></a>  ',
        'default' => true,
        'studio' => false,
        'nowrap' => true,
        'sortable' => false),
	'DATE_ENTERED' => array (
	    'width' => '10',
	    'label' => 'LBL_DATE_ENTERED',
	    'default' => true),              
);
?>
