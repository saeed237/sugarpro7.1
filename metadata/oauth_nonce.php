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


/**
 * table storing reports filter information */
$dictionary['oauth_nonce'] = array(
	'table' => 'oauth_nonce',
	'fields' => array(
		'conskey' => array(
			'name'		=> 'conskey',
			'type'		=> 'varchar',
			'len'		=> 32,
			'required'	=> true,
			'isnull'	=> false,
		),
		'nonce' => array(
			'name'		=> 'nonce',
			'type'		=> 'varchar',
			'len'		=> 32,
			'required'	=> true,
			'isnull'	=> false,
		),
		'nonce_ts' => array(
			'name'		=> 'nonce_ts',
			'type'		=> 'long',
			'required'	=> true,
		),
	),
	'indices' => array(
		array(
			'name'			=> 'oauth_nonce_pk',
			'type'			=> 'primary',
			'fields'		=> array('conskey', 'nonce')
		),
		array(
			'name'			=> 'oauth_nonce_keyts',
			'type'			=> 'index',
			'fields'		=> array('conskey', 'nonce_ts')
		),
	),
);
