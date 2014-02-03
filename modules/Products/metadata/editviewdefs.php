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

$viewdefs['Products']['EditView'] = array(
    'templateMeta' => array('maxColumns' => '2',
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'),
                                            array('label' => '10', 'field' => '30')
                                            ),
    'javascript' => '{sugar_getscript file="cache/include/javascript/sugar_grp_jsolait.js"}
{sugar_getscript file="modules/Products/EditView.js"}'
),

'panels' =>array (
  'default' =>
  array (

    array (
      array('name'=>'name',
            'displayParams'=>array('required'=>true),
            'customCode'=>'<input name="name" id="name" type="text" value="{$fields.name.value}">'.
                          '<input name="product_template_id" id="product_template_id" type="hidden" value="{$fields.product_template_id.value}">'.
                          '&nbsp;<input title="{$APP.LBL_SELECT_BUTTON_TITLE}" type="button" class="button" value="{$APP.LBL_SELECT_BUTTON_LABEL}" onclick=\'return get_popup_product("{$form_name}");\'>' .
            		      '&nbsp;<input tabindex="1" title="{$LBL_CLEAR_BUTTON_TITLE}" class="button" onclick="this.form.product_template_id.value = \'\'; this.form.name.value = \'\';" type="button" value="{$APP.LBL_CLEAR_BUTTON_LABEL}">',
      ),
      'status'
    ),

    array (
      'account_name',
      'contact_name',
    ),

    array (
      array('name'=>'quantity','displayParams'=>array('size'=>5)),
      'date_purchased',
    ),

    array (
      'serial_number',
      'date_support_starts',
    ),

    array (
      'asset_number',
      'date_support_expires',
    ),
  ),

  array (

    array (
      'currency_id',
      '',
    ),

    array (
      'cost_price',
      '',
    ),

    array (
      'list_price',
      'book_value',
    ),

    array (
      'discount_price',
      'book_value_date',
    ),
    array (
      'discount_amount',
      'discount_select',
    ),
  ),

  array (

    array (
      array('name'=>'website', 'type'=>'Link'),
      'tax_class',
    ),

    array (
      'manufacturer_id',
      'weight',
    ),

    array (
      'mft_part_num',
      'category_id',
    ),

    array (
      'vendor_part_num',
      'type_id',
    ),

    array (
      'description',
    ),

    array (
      'support_name',
      'support_contact',
    ),

    array (
      'support_description',
      'support_term',
    ),
  ),
)


);
?>