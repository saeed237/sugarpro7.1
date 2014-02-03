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

$module_name = 'EmailMarketing';
$viewdefs[$module_name]['base']['menu']['header'] = array(
    array(
        'route'=>'#Campaigns/create',
        'label' =>'LNK_NEW_CAMPAIGN',
        'acl_action'=>'create',
        'acl_module'=>'Campaigns',
        'icon' => 'icon-plus',
    ),
    array(
        'route'=>'#Campaigns/',
        'label' =>'LNK_NEW_CAMPAIGN',
        'acl_action'=>'list',
        'acl_module'=>'Campaigns',
        'icon' => 'icon-reorder',
    ),
    array(
        'route'=>'#ProspectLists/create',
        'label' =>'LNK_NEW_PROSPECT_LIST',
        'acl_action'=>'create',
        'acl_module'=>'ProspectLists',
        'icon' => 'icon-plus',
    ),
    array(
        'route'=>'#ProspectLists/',
        'label' =>'LNK_NEW_PROSPECT_LIST',
        'acl_action'=>'list',
        'acl_module'=>'ProspectLists',
        'icon' => 'icon-reorder',
    ),
    array(
        'route'=>'#Prospects/create',
        'label' =>'LNK_NEW_PROSPECT',
        'acl_action'=>'create',
        'acl_module'=>'Prospects',
        'icon' => 'icon-plus',
    ),
    array(
        'route'=>'#Prospects/',
        'label' =>'LNK_NEW_PROSPECT',
        'acl_action'=>'list',
        'acl_module'=>'Prospects',
        'icon' => 'icon-reorder',
    ),
);