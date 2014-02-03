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

/*********************************************************************************

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
$module_name = '<module_name>';
$_object_name = '<_object_name>';
$viewdefs[$module_name]['DetailView'] = array(
    'templateMeta' => array('form' => array('buttons'=>array('EDIT', 'DUPLICATE', 'DELETE', 'FIND_DUPLICATES',)),
       						'maxColumns' => '2',
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'),
                                            array('label' => '10', 'field' => '30')
                                            ),
                           ),
    'panels' => array(
        array('name', array('name'=>'amount','label' => '{$MOD.LBL_AMOUNT} ({$CURRENCY})'),),//'{$MOD.LBL_AMOUNT} ({$CURRENCY})'),),
        array('date_closed', 'sales_stage'),
        array($_object_name.'_type', 'next_step'),
        array('lead_source' ,array('name'=>'date_entered', 'customCode'=>'{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}'),
        ),
        array(
		'team_name',
		'probability'),
        array('assigned_user_name', array('name'=>'date_modified', 'label'=>'LBL_DATE_MODIFIED', 'customCode'=>'{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}')),
                array(array('name' => 'description', 'nl2br' => true)),
    )
);
