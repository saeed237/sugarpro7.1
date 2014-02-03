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



$subpanel_layout = array(
	'top_buttons' => array(
	),

	'where' => '',

	'list_fields' => array(
	   'id'=>array(
			'name'=>'id',
	        'width' => '10%',
	        'vname' => 'LBL_ID',
		),
		'tstate'=>array(
			'name'=>'tstate',
	        'width' => '10%',
		    'vname' => 'LBL_STATUS',
		),
		'token_ts'=>array(
			'name'=>'token_ts',
	        'width' => '10%',
		    'vname' => 'LBL_TS',
		    'function' => 'testfunc',
		),
		'consumer_name' => array(
		    'name' => 'consumer_name',
		 	'module' => 'OAuthKeys',
		 	'target_record_key' => 'consumer',
		 	'target_module' => 'OAuthKeys',
			'width' => '10%',
		    'vname' => 'LBL_CONSUMER',
		),
		'del_button'=>array(
			'widget_class' => 'SubPanelDeleteButton',
			'vname' => 'LBL_LIST_DELETE',
			'width' => '6%',
			'sortable'=>false,
		),
		)
);
