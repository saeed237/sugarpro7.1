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

$dictionary['product_bundle_quote'] = array (
	'table' => 'product_bundle_quote',
	'fields' => array (
       array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
      , array ('name' => 'date_modified','type' => 'datetime')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required' => false,)
      , array('name' =>'bundle_id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'quote_id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'bundle_index', 'type' =>'int', 'len'=>'11', 'default' => 0, 'required' => false,)
	),
	'indices' => array (
       array('name' =>'prod_bundl_quotepk', 'type' =>'primary', 'fields'=>array('id'))
      , array('name' =>'idx_pbq_bundle', 'type' =>'index', 'fields'=>array('bundle_id'))
      , array('name' =>'idx_pbq_quote', 'type' =>'index', 'fields'=>array('quote_id'))
      , array('name' =>'idx_pbq_bq', 'type'=>'alternate_key', 'fields'=>array('quote_id','bundle_id'))
      , array('name' => 'bundle_index_idx', 'type'=>'index', 'fields'=>array('bundle_index'))
	),

	'relationships' => array ('product_bundle_quote' => array('lhs_module'=> 'ProductBundles', 'lhs_table'=> 'product_bundles', 'lhs_key' => 'id',
		'rhs_module'=> 'Quotes', 'rhs_table'=> 'quotes', 'rhs_key' => 'id',
		'relationship_type'=>'many-to-many',
		'join_table'=> 'product_bundle_quote', 'join_key_lhs'=>'bundle_id', 'join_key_rhs'=>'quote_id'))
);
?>
