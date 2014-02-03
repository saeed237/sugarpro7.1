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

$module_name = 'ACLRoles';
global $mod_string;
$viewdefs[$module_name]['base']['menu']['header'] = array(
    array(
        'route'=>'#'.$module_name,
        'label' =>'LIST_ROLES',
        'acl_module'=>$module_name,
        'acl_action'=>'list',
        'icon' => 'icon-reorder',
    ),
    array(
        'route'=>'#bwc/index.php?module=ACLRoles&action=ListUsers',
        'label' =>'LIST_ROLES_BY_USER',
        'acl_module'=>$module_name,
        'acl_action'=>'list',
        'icon' => 'icon-reorder',
    ),
);