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
$viewdefs[$module_name]['QuickCreate'] = array(
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
		        array(array('name'=>'name', 'displayParams'=>array('required'=>true)), 'assigned_user_name'),
			    array('website',
			      array('name'=>'team_name', 'displayParams'=>array('display'=>true)),
			    ),
		        array('industry', array('name'=>'phone_office')),
		        array($_object_name . '_type',  'phone_fax'), 
		         array('annual_revenue', ''),
	   ),
  	   'lbl_email_addresses'=>array(
  				array('email1')
  	   ),
    )
);
