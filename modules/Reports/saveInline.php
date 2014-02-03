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


$module = $_REQUEST['save_module'];
$record = $_REQUEST['save_record'];
$field_value = $_REQUEST['save_value'];
$field = $_REQUEST['save_field_name'];
$type = $_REQUEST['type'];

$bean = BeanFactory::getBean($module, $record);
if ($type != 'currency')
    $bean->$field = $field_value;
else {
    $bean->$field = unformat_number($field_value);
}

$bean->save(false);

$ret_array = array();
$ret_array['id'] = $record;
$ret_array['field'] = $field;
if ($type != 'currency')
    $ret_array['value'] = $bean->$field;
else {
    global $locale;
    $params = array();
    $params['currency_id'] = $_REQUEST['currency_id'];
    $params['convert'] = false;
    $params['currency_symbol'] = $_REQUEST['currency_symbol'];

    $ret_array['currency_formatted_value']  = currency_format_number($bean->$field, $params);
    $ret_array['formatted_value'] = format_number($bean->$field);
}

$json = getJSONobj();
echo 'result = '. $json->encode($ret_array);
?>
