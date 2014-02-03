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

$dictionary['InboundEmail_autoreply'] = array ('table' => 'inbound_email_autoreply',
	'fields' => array (
		'id' => array (
			'name' => 'id',
			'vname' => 'LBL_ID',
			'type' => 'id',
			'required' => true,
			'reportable' => false,
		),
		'deleted' => array (
			'name' => 'deleted',
			'vname' => 'LBL_DELETED',
			'type' => 'bool',
			'required' => false,
			'default' => '0',
			'reportable'=>false,
		),
		'date_entered' => array (
			'name' => 'date_entered',
			'vname' => 'LBL_DATE_ENTERED',
			'type' => 'datetime',
			'required' => true,
		),
		'date_modified' => array (
			'name' => 'date_modified',
			'vname' => 'LBL_DATE_MODIFIED',
			'type' => 'datetime',
			'required' => true,
		),
		'autoreplied_to' => array (
			'name' => 'autoreplied_to',
			'vname' => 'LBL_AUTOREPLIED_TO',
			'type' => 'varchar',
			'len'		=> 100,
			'required' => true,
			'reportable'=>false,
		),
		'ie_id' => array(
			'name' => 'ie_id',
		    'vname' => 'LBL_INBOUNDEMAIL_ID',
			'type' => 'id',
		    'len' => '36',
		    'default' => '',
			'required' => true,
		    'reportable' => false,
		),
	),
	'indices' => array (
		array(
			'name' => 'ie_autopk',
			'type' =>'primary',
			'fields' => array(
				'id'
			)
		),
		array(
		'name' =>'idx_ie_autoreplied_to',
		'type'=>'index',
		'fields' => array(
			'autoreplied_to'
			)
		),
	), /* end indices */
	'relationships' => array (
	), /* end relationships */
);

?>
