<?php
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

$viewdefs['ProductTemplates']['DetailView'] = array(
'templateMeta' => array('maxColumns' => '2', 
                        'widths' => array(
                                        array('label' => '10', 'field' => '30'), 
                                        array('label' => '10', 'field' => '30')
                                        ),
                        ),
'panels' =>array (
  
  array (
    'name',
    'status',
  ),
  
  array (
    
    array (
      'name' => 'website',
      'label' => 'LBL_URL',
      'type' => 'link',
    ),
    'date_available',
  ),
  
  array (
    'tax_class',
    
    array (
      'name' => 'qty_in_stock',
      'label' => 'LBL_QUANTITY',
    ),
  ),
  
  array (
    'manufacturer_id',
    'weight',
  ),
  
  array (
    'mft_part_num',
    
    array (
      'name' => 'category_name',
      'type' => 'varchar',
      'label' => 'LBL_CATEGORY',
    ),
  ),
  
  array (
    'vendor_part_num',
    
    array (
      'name' => 'type_id',
      'type' => 'varchar',
      'label' => 'LBL_TYPE',
    ),
  ),
  
  array (
    'currency_id',
    'support_name',
  ),
  
  array (
    
    array (
      'name' => 'cost_price',
      'label' => '{$MOD.LBL_COST_PRICE|strip_semicolon} ({$CURRENCY})',
    ),
    'support_contact',
  ),
  
  array (
    
    array (
      'name' => 'list_price',
      'label' => '{$MOD.LBL_LIST_PRICE|strip_semicolon} ({$CURRENCY})',
    ),
    'support_description',
  ),
  
  array (
    
    array (
      'name' => 'discount_price',
      'label' => '{$MOD.LBL_DISCOUNT_PRICE|strip_semicolon} ({$CURRENCY})',
    ),
    'support_term',
  ),
  
  array (
    'pricing_formula',
  ),
  
  array (
    array('name'=>'description', 'displayParams'=>array('nl2br'=>true)),
  ),
)


   
);
?>