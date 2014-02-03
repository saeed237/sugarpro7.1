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

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 *********************************************************************************/

/**
 * table storing reports filter information */
$dictionary['report_cache'] = array(
	'table' => 'report_cache',
	'fields' => array(
		'id' => array(
			'name'		=> 'id',
			'type'		=> 'id',
			'required'	=> true,
		),
		'assigned_user_id' => array(
			'name'		=> 'assigned_user_id',
			'type'		=> 'id',
			'required'	=> true,
		),
		'contents' => array (
			'name'			=> 'contents',
			'type'			=> 'text',
			'comment'		=> 'contents of report object',
			'default'		=> NULL,
		),
		'report_options' => array (
			'name'			=> 'report_options',
			'type'			=> 'text',
			'comment'		=> 'options of report object like hide details, hide shart etc..',
			'default'		=> NULL,
		),
		'deleted' => array(
			'name'		=> 'deleted',
			'type'		=> 'varchar',
			'len'		=> 1,
			'required'	=> true,
		),
		'date_entered' => array (
			'name' => 'date_entered',
			'vname' => 'LBL_DATE_ENTERED',
			'type' => 'datetime',
			'required'=>true,
			'comment' => 'Date record created',
		),
		'date_modified' => array (
			'name' => 'date_modified',
			'vname' => 'LBL_DATE_MODIFIED',
			'type' => 'datetime',
			'required'=>true,
			'comment' => 'Date record last modified',
		),
	),
	'indices' => array(
		array(
			'name'			=> 'report_cache_pk',
			'type'			=> 'primary',
			'fields'		=> array('id', 'assigned_user_id')
		),
	),
);