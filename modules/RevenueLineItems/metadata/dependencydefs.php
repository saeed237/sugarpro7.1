<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
$fields = array(
    'category_name',
    'discount_price',
    'tax_class',
    'mft_part_num',
    'weight'
);

$dependencies['RevenueLineItems']['read_only_fields'] = array(
    'hooks' => array("edit"),
    //Trigger formula for the dependency. Defaults to 'true'.
    'trigger' => 'true',
    'triggerFields' => array('product_template_name'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(),
);

foreach ($fields as $field) {
    $dependencies['RevenueLineItems']['read_only_fields']['actions'][] = array(
        'name' => 'ReadOnly', //Action type
        //The parameters passed in depend on the action type
        'params' => array(
            'target' => $field,
            'label' => $field . '_label', //normally <field>_label
            'value' => 'not(equal($product_template_name,""))', //Formula
        ),
    );
}
