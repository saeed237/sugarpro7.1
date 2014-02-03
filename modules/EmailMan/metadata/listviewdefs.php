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




$listViewDefs['EmailMan'] = array(
    'CAMPAIGN_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_CAMPAIGN', 
        'link' => true,
		'customCode' => '<a href="index.php?module=Campaigns&action=DetailView&record={$CAMPAIGN_ID}">{$CAMPAIGN_NAME}</a>',
        'default' => true),
    'RECIPIENT_NAME' => array(
		'sortable' => false,
        'width' => '10', 
        'label' => 'LBL_LIST_RECIPIENT_NAME',
		'customCode' => '<a href="index.php?module={$RELATED_TYPE}&action=DetailView&record={$RELATED_ID}">{$RECIPIENT_NAME}</a>', 
        'default' => true),
    'RECIPIENT_EMAIL' => array(
		'sortable' => false,
        'width' => '10', 
        'label' => 'LBL_LIST_RECIPIENT_EMAIL',
		'customCode' => '{$EMAIL1_LINK}{$RECIPIENT_EMAIL}</a>',
        'default' => true),
    'MESSAGE_NAME' => array(
		'sortable' => false,
        'width' => '10', 
        'label' => 'LBL_LIST_MESSAGE_NAME',
		'customCode' => '<a href="index.php?module=EmailMarketing&action=DetailView&record={$MARKETING_ID}">{$MESSAGE_NAME}</a>',
        'default' => true),
    'SEND_DATE_TIME' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_SEND_DATE_TIME', 
        'default' => true),
    'SEND_ATTEMPTS' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_SEND_ATTEMPTS', 
        'default' => true),
    'IN_QUEUE' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_IN_QUEUE', 
        'default' => true),
);
