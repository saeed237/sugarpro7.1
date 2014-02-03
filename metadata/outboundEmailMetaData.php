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

$dictionary['OutboundEmail'] = array ('table' => 'outbound_email',
	'fields' => array (
		'id' => array (
			'name' => 'id',
			'vname' => 'LBL_ID',
			'type' => 'id',
			'required' => true,
			'reportable' => false,
		),
		'name' => array (
			'name' => 'name',
			'vname' => 'LBL_NAME',
			'type' => 'varchar',
			'len' => 50,
			'required' => true,
			'reportable' => false,
		),
		'type' => array (
			'name' => 'type',
			'vname' => 'LBL_TYPE',
			'type' => 'varchar',
			'len' => 15,
			'required' => true,
			'default' => 'user',
			'reportable' => false,
		),
		'user_id' => array (
			'name' => 'user_id',
			'vname' => 'LBL_USER_ID',
			'type' => 'id',
			'required' => true,
			'reportable' => false,
		),
		'mail_sendtype' => array(
			'name' => 'mail_sendtype',
			'vname' => 'LBL_MAIL_SENDTYPE',
			'type' => 'varchar',
			'len' => 8,
			'required' => true,
			'default' => 'smtp',
			'reportable' => false,
		),
		'mail_smtptype' => array(
			'name' => 'mail_smtptype',
			'vname' => 'LBL_MAIL_SENDTYPE',
			'type' => 'varchar',
			'len' => 20,
			'required' => true,
			'default' => 'other',
			'reportable' => false,
		),
		'mail_smtpserver' => array(
			'name' => 'mail_smtpserver',
			'vname' => 'LBL_MAIL_SMTPSERVER',
			'type' => 'varchar',
			'len' => 100,
			'required' => false,
			'reportable' => false,
		),
		'mail_smtpport' => array(
			'name' => 'mail_smtpport',
			'vname' => 'LBL_MAIL_SMTPPORT',
			'type' => 'int',
			'len' => 5,
			'default' => 0,
			'reportable' => false,
		),
		'mail_smtpuser' => array(
			'name' => 'mail_smtpuser',
			'vname' => 'LBL_MAIL_SMTPUSER',
			'type' => 'varchar',
			'len' => 100,
			'reportable' => false,
		),
		'mail_smtppass' => array(
			'name' => 'mail_smtppass',
			'vname' => 'LBL_MAIL_SMTPPASS',
			'type' => 'encrypt',
			'len' => 100,
			'reportable' => false,
		),
		'mail_smtpauth_req' => array(
			'name' => 'mail_smtpauth_req',
			'vname' => 'LBL_MAIL_SMTPAUTH_REQ',
			'type' => 'bool',
			'default' => 0,
			'reportable' => false,
		),
		'mail_smtpssl' => array(
			'name' => 'mail_smtpssl',
			'vname' => 'LBL_MAIL_SMTPSSL',
			'type' => 'int',
			'len' => 1,
			'default' => 0,
			'reportable' => false,
		),
	),
	'indices' => array (
		array(
			'name' => 'outbound_email_pk',
			'type' =>'primary',
			'fields' => array(
				'id'
			)
		),
		array(
			'name' => 'oe_user_id_idx',
			'type' =>'index',
			'fields' => array(
				'id',
				'user_id',
			)
		),
	), /* end indices */
);

