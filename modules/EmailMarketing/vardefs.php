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


$dictionary['EmailMarketing'] = array('table' => 'email_marketing'
                               ,'fields' => array (
 	'id' =>
  	array (
	    'name' => 'id',
	    'vname' => 'LBL_NAME',
	    'type' => 'id',
	    'required'=>true,
  	),
  	'deleted' => array (
		'name' => 'deleted',
		'vname' => 'LBL_CREATED_BY',
		'type' => 'bool',
		'required' => false,
		'reportable'=>false,
	),
	'date_entered' =>
  	array (
		'name' => 'date_entered',
    	'vname' => 'LBL_DATE_ENTERED',
    	'type' => 'datetime',
    	'required'=>true,
  	),
  	'date_modified' =>
  	array (
	    'name' => 'date_modified',
	    'vname' => 'LBL_DATE_MODIFIED',
	    'type' => 'datetime',
     	'required'=>true,
  	),
  	'modified_user_id' =>
  	array (
	    'name' => 'modified_user_id',
	    'rname' => 'user_name',
	    'id_name' => 'modified_user_id',
	    'vname' => 'LBL_MODIFIED_BY',
	    'type' => 'assigned_user_name',
	    'table' => 'users',
	    'isnull' => 'false',
	    'dbType' => 'id'
  	),
	'created_by' =>
  	array (
    	'name' => 'created_by',
    	'rname' => 'user_name',
    	'id_name' => 'modified_user_id',
    	'vname' => 'LBL_CREATED_BY',
    	'type' => 'assigned_user_name',
    	'table' => 'users',
    	'isnull' => 'false',
    	'dbType' => 'id'
  	),
  	'name' =>
  	array (
	    'name' => 'name',
	    'vname' => 'LBL_NAME',
	    'type' => 'varchar',
	    'len' => '255',
	    'importable' => 'required',
  		'required' => true
  	),
  	'from_name' =>  //starting from 4.0 from_name is obsolete..replaced with inbound_email_id
  	array (
	    'name' => 'from_name',
	    'vname' => 'LBL_FROM_NAME',
	    'type' => 'varchar',
	    'len' => '100',
	    'importable' => 'required',
  		'required' => true
  	),
  	'from_addr' =>
  	array (
	    'name' => 'from_addr',
    	'vname' => 'LBL_FROM_ADDR',
    	'type' => 'varchar',
    	'len' => '100',
    	'importable' => 'required',
  		'required' => true
  	),
  	'reply_to_name' =>
  	array (
	    'name' => 'reply_to_name',
	    'vname' => 'LBL_REPLY_NAME',
	    'type' => 'varchar',
	    'len' => '100',
  	),
  	'reply_to_addr' =>
  	array (
	    'name' => 'reply_to_addr',
    	'vname' => 'LBL_REPLY_ADDR',
    	'type' => 'varchar',
    	'len' => '100',
  	),
  	'inbound_email_id' =>
  	array (
	    'name' => 'inbound_email_id',
	    'vname' => 'LBL_FROM_MAILBOX',
	    'type' => 'varchar',
	    'len' => '36',
  	),
  	'date_start' =>
  	array (
	    'name' => 'date_start',
    	'vname' => 'LBL_DATE_START',
    	'type' => 'datetime',
    	'importable' => 'required',
  		'required' => true
    	),

  	'template_id' =>
  	array (
	    'name' => 'template_id',
	    'vname' => 'LBL_TEMPLATE',
	    'type' => 'id',
	    'required'=>true,
	    'importable' => 'required',
  	),
  	'status' =>
  	array (
	    'name' => 'status',
	    'vname' => 'LBL_STATUS',
	    'type' => 'enum',
	    'len' => 100,
		'required'=>true,
		'options' => 'email_marketing_status_dom',
		'importable' => 'required',
  	),
  	'campaign_id' =>
  	array (
	    'name' => 'campaign_id',
	    'vname' => 'LBL_CAMPAIGN_ID',
	    'type' => 'id',
	    'isnull' => true,
	    'required'=>false,
  	),
  	'all_prospect_lists' => array (
		'name' => 'all_prospect_lists',
		'vname' => 'LBL_ALL_PROSPECT_LISTS',
		'type' => 'bool',
		'default'=> 0,
	),
//no-db-fields.
	'template_name' =>
  	array (
	    'name' => 'template_name',
	    'rname' => 'name',
	    'id_name' => 'template_id',
	    'vname' => 'LBL_TEMPLATE_NAME',
	    'type' => 'relate',
	    'table' => 'email_templates',
	    'isnull' => 'true',
	    'module' => 'EmailTemplates',
	    'dbType' => 'varchar',
	    'link'=>'emailtemplate',
	    'len' => '255',
   	 	'source'=>'non-db',
  	),
  	'prospect_list_name' =>
  	array (
	    'name' => 'prospect_list_name',
	    'vname' => 'LBL_PROSPECT_LIST_NAME',
	    'type' => 'varchar',
	    'len'=>100,
	    'source'=>'non-db',
  	),

//related fields.
	'prospectlists'=> array (
		'name' => 'prospectlists',
    	'type' => 'link',
    	'relationship' => 'email_marketing_prospect_lists',
    	'source'=>'non-db',
  	),
	'emailtemplate'=> array (
		'name' => 'emailtemplate',
    	'type' => 'link',
    	'relationship' => 'email_template_email_marketings',
    	'source'=>'non-db',
  	),
  ),
  'indices' => array (
       array('name' =>'emmkpk', 'type' =>'primary', 'fields'=>array('id')),
       array('name' =>'idx_emmkt_name', 'type'=>'index', 'fields'=>array('name')),
       array('name' =>'idx_emmkit_del', 'type'=>'index', 'fields'=>array('deleted')),
  ),
  'relationships' => array (
	'email_template_email_marketings' => array('lhs_module'=> 'EmailTemplates', 'lhs_table'=> 'email_templates', 'lhs_key' => 'id',
							  'rhs_module'=> 'EmailMarketing', 'rhs_table'=> 'email_marketing', 'rhs_key' => 'template_id',
							  'relationship_type'=>'one-to-many'),
  ),
);
?>
