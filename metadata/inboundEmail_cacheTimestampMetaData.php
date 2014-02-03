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

$dictionary['InboundEmail_cacheTimestamp'] = array ('table' => 'inbound_email_cache_ts',
	'fields' => array (
		'id' => array (
			'name' => 'id',
			'vname' => 'LBL_ID',
			'type' => 'varchar',
			'len'	=> 255,
			'required' => true,
			'reportable' => false,
		),
		'ie_timestamp' => array(
			'name'	=> 'ie_timestamp',
			'type'	=> 'uint',
			'len'	=> 16,
			'required'	=> true,
		),
	),
	'indices' => array (
		array(
			'name' => 'ie_cachetimestamppk',
			'type' =>'primary',
			'fields' => array(
				'id'
			)
		),
	), /* end indices */
	'relationships' => array (
	), /* end relationships */
);

?>
