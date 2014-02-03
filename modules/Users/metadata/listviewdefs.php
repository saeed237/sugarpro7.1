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




$listViewDefs['Users'] = array(
    'NAME' => array(
        'width' => '30', 
        'label' => 'LBL_LIST_NAME', 
        'link' => true,
        'related_fields' => array('last_name', 'first_name'),
        'orderBy' => 'last_name',
        'default' => true),
    'USER_NAME' => array(
        'width' => '5', 
        'label' => 'LBL_USER_NAME', 
        'link' => true,
        'default' => true),
    'TITLE' => array(
        'width' => '15', 
        'label' => 'LBL_TITLE', 
        'link' => true,
        'default' => true),        
    'DEPARTMENT' => array(
        'width' => '15', 
        'label' => 'LBL_DEPARTMENT', 
        'link' => true,
        'default' => true),
    'EMAIL1' => array(
        'width' => '30',
        'sortable' => false, 
        'label' => 'LBL_LIST_EMAIL', 
        'link' => true,
        'default' => true),
    'PHONE_WORK' => array(
        'width' => '25', 
        'label' => 'LBL_LIST_PHONE', 
        'link' => true,
        'default' => true),
    'STATUS' => array(
        'width' => '10', 
        'label' => 'LBL_STATUS', 
        'link' => false,
        'default' => true),
    'IS_ADMIN' => array(
        'width' => '10', 
        'label' => 'LBL_ADMIN', 
        'link' => false,
        'default' => true),
    'IS_GROUP' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_GROUP', 
        'link' => true,
        'default' => false),
);
?>
