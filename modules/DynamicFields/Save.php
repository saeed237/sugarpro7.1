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


require_once('modules/DynamicFields/DynamicField.php');

$module = $_REQUEST['module_name'];
$custom_fields = new DynamicField($module);
if(!empty($module)){
    $mod = BeanFactory::getBean($module);
	$custom_fields->setup($mod);
}else{
	echo "\n".$mod_strings['ERR_NO_MODULE_INCLUDED'];
}
$name = $_REQUEST['field_label'];
$options = '';
if($_REQUEST['field_type'] == 'enum'){
	$options = $_REQUEST['options'];
}
$default_value = '';

$custom_fields->addField($name,$name, $_REQUEST['field_type'],'255','optional', $default_value, $options, '', '' );
$html = $custom_fields->getFieldHTML($name, $_REQUEST['file_type']);

set_register_value('dyn_layout', 'field_counter', $_REQUEST['field_count']);
$label = $custom_fields->getFieldLabelHTML($name, $_REQUEST['field_type']);
require_once('modules/DynamicLayout/AddField.php');
$af = new AddField();
$af->add_field($name, $html,$label, 'window.opener.');
echo $af->get_script('window.opener.');
echo "\n<script>window.close();</script>";

?>
