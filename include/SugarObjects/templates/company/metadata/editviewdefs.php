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

/*
 * Created on Aug 2, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
$module_name = '<module_name>';
$_object_name = '<_object_name>';
$viewdefs[$module_name]['EditView'] = array(
    'templateMeta' => array(
                            'form' => array('buttons'=>array('SAVE', 'CANCEL')),
                            'maxColumns' => '2',
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'),
                                            array('label' => '10', 'field' => '30'),
                                            ),
                            'includes'=> array(
                                            array('file'=>'modules/Accounts/Account.js'),
                                         ),
                           ),

    'panels' => array(
	   'lbl_account_information'=>array(
		        array('name','phone_office'),
		        array('website', 'phone_fax'),
		        array('ticker_symbol', 'phone_alternate'),
		        array('rating', 'employees'),
		        array('ownership','industry'),

		        array($_object_name . '_type', 'annual_revenue'),
			    array (
			      array('name'=>'team_name', 'displayParams'=>array('display'=>true)),
			      ''
			    ),
                array('assigned_user_name'),
	   ),
	   'lbl_address_information'=>array(
				array (
				      array (
					  'name' => 'billing_address_street',
				      'hideLabel'=> true,
				      'type' => 'address',
				      'displayParams'=>array('key'=>'billing', 'rows'=>2, 'cols'=>30, 'maxlength'=>150),
				      ),
				array (
				      'name' => 'shipping_address_street',
				      'hideLabel' => true,
				      'type' => 'address',
				      'displayParams'=>array('key'=>'shipping', 'copy'=>'billing', 'rows'=>2, 'cols'=>30, 'maxlength'=>150),
				      ),
				),
	   ),

  	   'lbl_email_addresses'=>array(
  				array('email1')
  	   ),

	   'lbl_description_information' =>array(
		        array('description'),
	   ),

    )
);
