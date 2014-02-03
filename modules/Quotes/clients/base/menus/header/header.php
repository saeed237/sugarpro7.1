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

$module_name = 'Quotes';
$viewdefs[$module_name]['base']['menu']['header'] = array(
    array(
        'route' => '#bwc/index.php?module=Quotes&action=EditView&return_module=Quotes&return_action=DetailView',
        'label' =>'LNK_NEW_QUOTE',
        'acl_action'=>'create',
        'acl_module'=>$module_name,
        'icon' => 'icon-plus',
    ),
    array(
        'route'=>'#'.$module_name,
        'label' =>'LNK_QUOTE_LIST',
        'acl_action'=>'list',
        'acl_module'=>$module_name,
        'icon' => 'icon-reorder',
    ),
    array(
        'route'=>'#bwc/index.php?module=Reports&action=index&view=quotes&query=true&report_module=Quotes',
        'label' =>'LNK_QUOTE_REPORTS',
        'acl_action'=>'list',
        'acl_module'=>$module_name,
        'icon' => 'icon-bar-chart',
    ),
);
