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





$dictionary['contracts_opportunities'] = array (
	'table' => 'contracts_opportunities',
	'fields' => array (
		array('name' => 'id', 'type' => 'varchar', 'len' => '36'),
		array('name' => 'opportunity_id', 'type' => 'varchar', 'len' => '36'),
		array('name' => 'contract_id', 'type' => 'varchar', 'len' => '36'),
		array('name' => 'date_modified', 'type' => 'datetime'),
		array('name' => 'deleted', 'type' => 'bool', 'len' => '1', 'default' => '0', 'required' => false),
	),
	'indices' => array (
		array('name' => 'contracts_opp_pk', 'type' =>'primary', 'fields'=>array('id')),
		array('name' => 'contracts_opp_alt', 'type'=>'alternate_key', 'fields'=>array('contract_id')),
	),
	'relationships' => array (
		'contracts_opportunities' => array(
			'lhs_module' => 'Contracts',
			'lhs_table' => 'contracts',
			'lhs_key' => 'id',
			'rhs_module' => 'Opportunities',
			'rhs_table' => 'opportunities',
			'rhs_key' => 'id',
			'relationship_type' => 'many-to-many',
			'join_table' => 'contracts_opportunities',
			'join_key_lhs' => 'contract_id',
			'join_key_rhs' => 'opportunity_id'
		),
	),
);
?>
