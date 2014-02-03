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


global $mod_strings;

$popupMeta = array('moduleMain' => 'Opportunity',
						'varName' => 'OPPORTUNITY',
						'orderBy' => 'name',
						'whereClauses' => 
							array('name' => 'opportunities.name', 
									'account_name' => 'accounts.name'),
						'searchInputs' =>
							array('name', 'account_name'),
						'listviewdefs' => array(
											'NAME' => array(
												'width'   => '30',  
												'label'   => 'LBL_LIST_OPPORTUNITY_NAME', 
												'link'    => true,
										        'default' => true),
											'ACCOUNT_NAME' => array(
												'width'   => '20', 
												'label'   => 'LBL_LIST_ACCOUNT_NAME', 
												'id'      => 'ACCOUNT_ID',
										        'module'  => 'Accounts',
										        'default' => true,
										        'sortable'=> true,
										        'ACLTag' => 'ACCOUNT'),
										    'OPPORTUNITY_TYPE' => array(
										        'width' => '15', 
										        'default' => true,
										        'label' => 'LBL_TYPE'),
											'SALES_STAGE' => array(
												'width'   => '10',  
												'label'   => 'LBL_LIST_SALES_STAGE',
										        'default' => true), 
										    'ASSIGNED_USER_NAME' => array(
												'width' => '5', 
												'label' => 'LBL_LIST_ASSIGNED_USER',
										        'default' => true),
											),
						'searchdefs'   => array(
										 	'name', 
											array('name' => 'account_name', 'displayParams' => array('hideButtons'=>'true', 'size'=>30, 'class'=>'sqsEnabled sqsNoAutofill')), 
											'opportunity_type',
											'sales_stage',
											array('name' => 'assigned_user_id', 'type' => 'enum', 'label' => 'LBL_ASSIGNED_TO', 'function' => array('name' => 'get_user_array', 'params' => array(false))),
										  )
						);


?>