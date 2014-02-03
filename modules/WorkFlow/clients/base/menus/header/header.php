<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

$viewdefs['WorkFlow']['base']['menu']['header'] = array(
    array(
        'route'=>'#bwc/index.php?module=WorkFlow&action=EditView&return_module=WorkFlow&return_action=DetailView',
        'label' =>'LNK_NEW_WORKFLOW',
        'acl_action'=>'',
        'acl_module'=>'',
        'icon' => 'icon-plus',
    ),
    array(
        'route'=>'#bwc/index.php?module=WorkFlow&action=index&return_module=WorkFlow&return_action=DetailView',
        'label' =>'LNK_WORKFLOW',
        'acl_action'=>'',
        'acl_module'=>'',
        'icon' => 'icon-reorder',
    ),
    array(
        'route'=>'#bwc/index.php?module=WorkFlow&action=WorkFlowListView&return_module=WorkFlow&return_action=index',
        'label' =>'LNK_ALERT_TEMPLATES',
        'acl_action'=>'',
        'acl_module'=>'',
        'icon' => 'icon-magic',
    ),
    array(
        'route'=>'#bwc/index.php?module=WorkFlow&action=ProcessListView&return_module=WorkFlow&return_action=index',
        'label' =>'LNK_PROCESS_VIEW',
        'acl_action'=>'',
        'acl_module'=>'',
        'icon' => 'icon-sitemap',
    ),
);
