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

$dictionary['ProductBundle'] = array('table' => 'product_bundles', 'comment' => 'Quote groups'
                               ,'fields' => array (
 'id' =>
  array (
    'name' => 'id',
    'vname' => 'LBL_NAME',
    'type' => 'id',
    'required' => true,
    'reportable'=>false,
    'comment' => 'Unique identifier'
  ),
   'deleted' =>
  array (
    'name' => 'deleted',
    'vname' => 'LBL_DELETED',
    'type' => 'bool',
    'required' => false,
    'default' => '0',
    'reportable'=>false,
    'comment' => 'Record deletion indicator'
  ),
   'date_entered' =>
  array (
    'name' => 'date_entered',
    'vname' => 'LBL_DATE_ENTERED',
    'type' => 'datetime',
    'required' => true,
    'comment' => 'Date record created'
  ),
  'date_modified' =>
  array (
    'name' => 'date_modified',
    'vname' => 'LBL_DATE_MODIFIED',
    'type' => 'datetime',
    'required' => true,
    'comment' => 'Date record last modified'
  ),
    'modified_user_id' =>
  array (
    'name' => 'modified_user_id',
    'rname' => 'user_name',
    'id_name' => 'modified_user_id',
    'vname' => 'LBL_ASSIGNED_TO',
    'type' => 'assigned_user_name',
    'table' => 'users',
    'isnull' => 'false',
    'dbType' => 'id',
    'reportable'=>true,
    'comment' => 'User who last modified record'
  ),
  'created_by' =>
  array (
    'name' => 'created_by',
    'rname' => 'user_name',
    'id_name' => 'modified_user_id',
    'vname' => 'LBL_ASSIGNED_TO',
    'type' => 'assigned_user_name',
    'table' => 'users',
    'isnull' => 'false',
    'dbType' => 'id',
    'comment' => 'User who created record'
  ),
  'name' =>
  array (
    'name' => 'name',
    'vname' => 'LBL_NAME',
    'dbType' => 'varchar',
    'type' => 'name',
    'len' => '255',
    'comment' => 'Name of the group'
  ),
  'bundle_stage' =>
  array (
    'name' => 'bundle_stage',
    'vname' => 'LBL_BUNDLE_STAGE',
    'type' => 'varchar',
    'len' => '255',
    'comment' => 'Processing stage of the group (ex: Draft)'
  ),
  'description' =>
  array (
    'name' => 'description',
    'vname' => 'LBL_DESCRIPTION',
    'type' => 'text',
    'comment' => 'Group description'
  ),
  'tax' =>
  array (
    'name' => 'tax',
    'vname' => 'LBL_TAX',
    'type' => 'decimal',
    'len' => '26,6',
    'disable_num_format' => true,
    'comment' => 'Tax rate applied to items in the group',
    'related_fields' => array(
        'currency_id',
        'base_rate'
    ),
  ),
  'tax_usdollar' =>
    array (
        'name' => 'tax_usdollar',
        'vname' => 'LBL_TAX_USDOLLAR',
    'type' => 'decimal',
        'len' => '26,6',
        'disable_num_format' => true,
        'comment' => 'Total tax for all items in group in USD',
        'studio' => array(
        'mobile' => false,
        ),
        'readonly' => true,
        'is_base_currency' => true,
        'related_fields' => array(
            'currency_id',
            'base_rate'
        ),
        'formula' => 'divide($tax,$base_rate)',
        'calculated' => true,
        'enforced' => true,
    ),
  'total' =>
  array (
        'name' => 'total',
        'vname' => 'LBL_TOTAL',
    'type' => 'decimal',
        'len' => '26,6',
        'disable_num_format' => true,
        'comment' => 'Total amount for all items in the group',
        'related_fields' => array(
          'currency_id',
          'base_rate'
        ),
  ),
   'total_usdollar' =>
    array (
        'name' => 'total_usdollar',
        'vname' => 'LBL_TOTAL_USDOLLAR',
    'type' => 'decimal',
        'len' => '26,6',
        'disable_num_format' => true,
        'comment' => 'Total amount for all items in the group in USD',
        'studio' => array(
          'mobile' => false,
        ),
        'readonly' => true,
        'is_base_currency' => true,
        'related_fields' => array(
          'currency_id',
          'base_rate'
        ),
        'formula' => 'divide($total,$base_rate)',
        'calculated' => true,
        'enforced' => true,
    ),

  'subtotal_usdollar' =>
    array (
        'name' => 'subtotal_usdollar',
        'vname' => 'LBL_SUBTOTAL_USDOLLAR',
    'type' => 'decimal',
        'len' => '26,6',
        'disable_num_format' => true,
        'comment' => 'Group total minus tax and shipping in USD',
        'studio' => array(
        'mobile' => false,
        ),
        'readonly' => true,
        'is_base_currency' => true,
        'related_fields' => array(
            'currency_id',
            'base_rate'
        ),
        'formula' => 'divide($subtotal,$base_rate)',
        'calculated' => true,
        'enforced' => true,
    ),
  'shipping_usdollar' =>
  array (
        'name' => 'shipping_usdollar',
        'vname' => 'LBL_SHIPPING',
    'type' => 'decimal',
        'len' => '26,6',
        'disable_num_format' => true,
        'comment' => 'Shipping charge for group in USD',
        'studio' => array(
        'mobile' => false,
        ),
        'readonly' => true,
        'is_base_currency' => true,
        'related_fields' => array(
          'currency_id',
          'base_rate'
        ),
      'formula' => 'divide($shipping,$base_rate)',
      'calculated' => true,
      'enforced' => true,
  ),
  'deal_tot' =>
    array(
        'name' => 'deal_tot',
        'vname' => 'LBL_DEAL_TOT',
    'type' => 'decimal',
    'len' => '26,2',
        'disable_num_format' => true,
        'comment' => 'discount amount',
        'related_fields' => array(
            'currency_id',
            'base_rate'
        ),
    ),
  'deal_tot_usdollar' =>
    array(
        'name' => 'deal_tot_usdollar',
        'vname' => 'LBL_DEAL_TOT',
    'type' => 'decimal',
    'len' => '26,2',
        'disable_num_format' => true,
        'comment' => 'discount amount',
        'studio' => array(
            'mobile' => false,
        ),
        'readonly' => true,
        'is_base_currency' => true,
        'related_fields' => array(
            'currency_id',
            'base_rate'
        ),
        'formula' => 'divide($deal_tot,$base_rate)',
        'calculated' => true,
        'enforced' => true,
    ),
  'new_sub' =>
    array(
        'name' => 'new_sub',
        'vname' => 'LBL_NEW_SUB',
    'type' => 'decimal',
    'len' => '26,6',
        'disable_num_format' => true,
        'comment' => 'Group total minus discount and tax and shipping',
        'related_fields' => array(
            'currency_id',
            'base_rate'
        ),
    ),
  'new_sub_usdollar' =>
    array (
        'name' => 'new_sub_usdollar',
        'vname' => 'LBL_NEW_SUB',
    'type' => 'decimal',
        'len' => '26,6',
        'disable_num_format' => true,
        'comment' => 'Group total minus discount and tax and shipping',
        'studio' => array(
            'mobile' => false,
        ),
        'readonly' => true,
        'is_base_currency' => true,
        'related_fields' => array(
            'currency_id',
            'base_rate'
        ),
        'formula' => 'divide($new_sub,$base_rate)',
        'calculated' => true,
        'enforced' => true,

    ),
  'subtotal' =>
    array(
        'name' => 'subtotal',
        'vname' => 'LBL_SUBTOTAL',
    'type' => 'decimal',
    'len' => '26,6',
        'disable_num_format' => true,
        'comment' => 'Group total minus tax and shipping',
        'related_fields' => array(
            'currency_id',
            'base_rate'
        ),
    ),
  'shipping' =>
    array(
        'name' => 'shipping',
        'vname' => 'LBL_SHIPPING',
    'type' => 'decimal',
    'len' => '26,6',
        'disable_num_format' => true,
        'comment' => 'Shipping charge for group',
        'related_fields' => array(
            'currency_id',
            'base_rate'
        ),
    ),
  'currency_id' =>
  array (
    'name' => 'currency_id',
    'type' => 'currency_id',
    'dbType' => 'id',
    'required'=>false,
    'reportable'=>false,
    'default'=>'-99',
    'comment' => 'Currency used'
  ),
        'base_rate' => array(
            'name' => 'base_rate',
            'vname' => 'LBL_CURRENCY_RATE',
            'type' => 'decimal',
            'len' => '26,6',
            'required' => true,
            'studio' => false
        ),
    'products' =>
      array (
        'name' => 'products',
        'type' => 'link',
        'relationship' => 'product_bundle_product',
        'module'=>'Products',
        'bean_name'=>'Product',
        'source'=>'non-db',
        'rel_fields'=>array('product_index'=>array('type'=>'integer')),
        'vname'=>'LBL_PRODUCTS',
      ),
    'quotes' =>
        array(
            'name' => 'quotes',
            'type' => 'link',
            'relationship' => 'product_bundle_quote',
            'module' => 'Quotes',
            'bean_name' => 'Quote',
            'source' => 'non-db',
            'rel_fields' => array('bundle_index' => array('type' => 'integer')),
            'relationship_fields' => array('bundle_index' => 'bundle_index'),
            'vname' => 'LBL_QUOTES',
        ),
    'product_bundle_notes' =>
        array(
            'name' => 'product_bundle_notes',
            'type' => 'link',
            'relationship' => 'product_bundle_note',
            'module' => 'ProductBundleNotes',
            'bean_name' => 'ProductBundleNote',
            'source' => 'non-db',
            'rel_fields' => array('note_index' => array('type' => 'integer')),
            'vname' => 'LBL_NOTES',
        ),
)
                                                      , 'indices' => array (
       array('name' =>'procuct_bundlespk', 'type' =>'primary', 'fields'=>array('id')),
       array('name' =>'idx_products_bundles', 'type'=>'index', 'fields'=>array('name','deleted')),
                                                      )
                            );

VardefManager::createVardef('ProductBundles','ProductBundle', array(
'team_security',
));
?>
