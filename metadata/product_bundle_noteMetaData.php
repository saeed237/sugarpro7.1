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

$dictionary['product_bundle_note'] = array (
	'table' => 'product_bundle_note',
	'fields' => array (
       array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
      , array ('name' => 'date_modified','type' => 'datetime')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required' => false,)
      , array('name' =>'bundle_id', 'type' =>'varchar', 'len'=>'36', )
      , array('name' =>'note_id', 'type' =>'varchar', 'len'=>'36', )
      , array('name' =>'note_index', 'type' =>'int', 'len'=>'11', 'default'=>'0', 'required' => false,)      
	),
	'indices' => array (
       array('name' =>'prod_bundl_notepk', 'type' =>'primary', 'fields'=>array('id'))
      , array('name' =>'idx_pbn_bundle', 'type' =>'index', 'fields'=>array('bundle_id'))
      , array('name' =>'idx_pbn_note', 'type' =>'index', 'fields'=>array('note_id'))
      , array('name' =>'idx_pbn_pb_nb', 'type'=>'alternate_key', 'fields'=>array('note_id','bundle_id'))
	),
	'relationships' => array ('product_bundle_note' => array('lhs_module'=> 'ProductBundles', 'lhs_table'=> 'product_bundles', 'lhs_key' => 'id',
		'rhs_module'=> 'ProductBundleNotes', 'rhs_table'=> 'product_bundle_note', 'rhs_key' => 'id',
		'relationship_type'=>'many-to-many',
		'join_table'=> 'product_bundle_note', 'join_key_lhs'=>'bundle_id', 'join_key_rhs'=>'note_id'))		
);
?>
