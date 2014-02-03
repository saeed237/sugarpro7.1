<?php
/*
 * Created on Aug 2, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
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

$module_name = '<module_name>';
$_object_name = '<_object_name>';
$viewdefs[$module_name]['DetailView'] = array(
    'templateMeta' => array('form' => array('buttons'=>array('EDIT', 'DUPLICATE', 'DELETE', 'FIND_DUPLICATES')),
                            'maxColumns' => '2', 
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'), 
                                            array('label' => '10', 'field' => '30')
                                            ),
                           ),
    'panels' => array(
        array('name', 'phone_office'),
        array(array('name'=>'website', 'type'=>'link'), 'phone_fax'),
        array('ticker_symbol', array('name'=>'phone_alternate', 'label'=>'LBL_OTHER_PHONE')),
        array('', 'employees'),
        array('ownership', 'rating'),
        array('industry'),
        array($_object_name . '_type', 'annual_revenue'),
		array(
            array('name'=>'date_modified', 'label'=>'LBL_DATE_MODIFIED', 'customCode'=>'{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}'),
            'team_name',
        ),
		array(array('name'=>'assigned_user_name', 'label'=>'LBL_ASSIGNED_TO_NAME'),
              array('name'=>'date_entered', 'customCode'=>'{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}')),
		array (
		      array (
			  'name' => 'billing_address_street',
		      'label'=> 'LBL_BILLING_ADDRESS',
		      'type' => 'address',
		      'displayParams'=>array('key'=>'billing'),
		      ),
		array (
		      'name' => 'shipping_address_street',
		      'label'=> 'LBL_SHIPPING_ADDRESS',
		      'type' => 'address',
		      'displayParams'=>array('key'=>'shipping'),      
		      ),
		),

	    array('description'),
	    array('email1'),		      
     ),
    
    
);
