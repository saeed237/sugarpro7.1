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

$module_name = 'Documents';
$viewdefs[$module_name]['base']['menu']['header'] = array(
    array(
        'route' => '#bwc/index.php?' . http_build_query(
            array(
                'module' => $module_name,
                'action' => 'editview'
            )
        ),
        'label' =>'LNK_NEW_DOCUMENT',
        'acl_action'=>'create',
        'acl_module'=>$module_name,
        'icon' => 'icon-plus',
    ),
    array(
        'route'=>'#'.$module_name,
        'label' =>'LNK_DOCUMENT_LIST',
        'acl_action'=>'list',
        'acl_module'=>$module_name,
        'icon' => 'icon-reorder',
    ),
    //TODO look at old file and deal with this
    /*array(
        'route'=>'#bwc/index.php?module=MailMerge&action=index&reset=true',
        'label' =>'LNK_NEW_MAIL_MERGE',
        'acl_action'=>'',
        'acl_module'=>'',
        'icon' => '',
    ),*/
);
