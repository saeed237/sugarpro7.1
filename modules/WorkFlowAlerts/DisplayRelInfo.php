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

global $app_list_strings;
global $beanList;





$seed_object = BeanFactory::getBean('WorkFlowAlertShells');

if(!empty($_REQUEST['parent_id']) && $_REQUEST['parent_id']!="") {
    $seed_object->retrieve($_REQUEST['parent_id']);
    $workflow_object = $seed_object->get_workflow_object();

} else {
	sugar_die("You shouldn't be here");	
}

$focus = BeanFactory::getBean('WorkFlowAlerts');
if(!empty($_REQUEST['record']) && $_REQUEST['record']!="") {
	$focus->retrieve($_REQUEST['record']);
}	
	
	if(!empty($_REQUEST['base_module2']) && $_REQUEST['base_module2']!=""){
		$base_module = $_REQUEST['base_module2'];
	} else {
		$base_module = $workflow_object->base_module;
	}		


	$rel_module_name = $_REQUEST['rel_module'];
	$rel_module = $focus->get_rel_module($base_module, $rel_module_name);

	
if($_REQUEST['type']=="rel_module"){
	$rel_select = get_select_options_with_id($focus->get_rel_module_array($rel_module, true),$_REQUEST['rel_module_value']);
	echo "<form name=\"EditView\">";
	echo "<select id='rel_module2' name='rel_module2' tabindex='2' onchange=\"window.parent.togglecustom()\">".$rel_select."</select>";
	echo "<input type='hidden' id='base_module2' name='base_module2' value='".$rel_module."'>";
	echo "</form>";
	?>
	<script>
	window.parent.togglecustom(false);

	</script>
	<?php
}

if($_REQUEST['type']=="rel_fields"){

	$rel_field_select = get_select_options_with_id($focus->get_field_value_array($rel_module, "Char"),$focus->field_value);
	$rel_email_select = get_select_options_with_id($focus->get_field_value_array($rel_module, "Email"),$focus->rel_email_value);
	echo "<form name=\"EditView\">";
	echo "User Name:<BR><select id='rel_field_value' name='rel_field_value' tabindex='2'>".$rel_field_select."</select>";
	echo "<BR>User E-mail:<BR><select id='rel_email_value' name='rel_email_value' tabindex='2'>".$rel_email_select."</select>";
	echo "</form>";

}


?>
