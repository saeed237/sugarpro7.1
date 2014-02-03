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

$module_name = 'Reports';
$viewdefs[$module_name]['base']['menu']['header'] = array(
    array(
        'route' => '#bwc/index.php?module=Reports&report_module=&action=index&page=report&Create+Custom+Report=Create+Custom+Report',
        'label' =>'LBL_CREATE_REPORT',
        'acl_action'=>'create',
        'acl_module'=>$module_name,
        'icon' => 'icon-plus',
    ),
    array(
        'route'=>'#bwc/index.php?module=Reports&favorite=1&action=index',
        'label' =>'LBL_FAVORITE_REPORTS',
        'acl_action'=>'list',
        'acl_module'=>$module_name,
        'icon' => 'icon-favorite',
    ),
    array(
        'route'=>'#bwc/index.php?module=Reports&action=index',
        'label' =>'LBL_ALL_REPORTS',
        'acl_action'=>'list',
        'acl_module'=>$module_name,
        'icon' => 'icon-reorder',
    ),
);
