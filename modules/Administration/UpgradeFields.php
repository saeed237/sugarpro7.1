<?php
if(!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
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

require_once ('modules/DynamicFields/DynamicField.php');
require_once ('modules/DynamicFields/FieldCases.php');
global $db, $mod_strings;

if (!isset ($db)) {
	$db = DBManagerFactory:: getInstance();
}

$result = $db->query('SELECT * FROM fields_meta_data WHERE deleted = 0 ORDER BY custom_module');
$modules = array ();
/*
 * get the real field_meta_data
 */
while ($row = $db->fetchByAssoc($result)) {
	$the_modules = $row['custom_module'];
	if (!isset ($modules[$the_modules])) {
		$modules[$the_modules] = array ();
	}
	$modules[$the_modules][$row['name']] = $row['name'];
}

$simulate = false;
if (!isset ($_REQUEST['run'])) {
	$simulate = true;
	echo $mod_strings['LBL_UPGRADE_FIELDS_SIMULATION_MODE'];
}

foreach ($modules as $the_module => $fields) {
	echo "<br><br>".$mod_strings['LBL_UPGRADE_FIELDS_SCANNING']." $the_module <br>";
    $mod = BeanFactory::getBean($the_module);
	if (!$db->tableExists($mod->table_name."_cstm")) {
		$mod->custom_fields = new DynamicField();
		$mod->custom_fields->setup($mod);
		$mod->custom_fields->createCustomTable();
	}

	$table = $db->getTableDescription($mod->table_name."_cstm");
	foreach($table as $row) {
		$col = strtolower(empty ($row['Field']) ? $row['field'] : $row['Field']);
		$the_field = $mod->custom_fields->getField($col);
		$type = strtolower(empty ($row['Type']) ? $row['type'] : $row['Type']);
		if (!empty($row['data_precision']) && !empty($row['data_scale'])) {
			$type.='(' . $row['data_precision'];
			if (!empty($row['data_scale'])) {
				$type.=',' . $row['data_scale'];
			}
			$type.=')';
		} elseif(!empty($row['data_length']) && (strtolower($row['type'])=='varchar' or strtolower($row['type'])=='varchar2')) {
			$type.='(' . $row['data_length'] . ')';
		}
		if (!isset ($fields[$col]) && $col != 'id_c') {
			if (!$simulate) {
				$db->query("ALTER TABLE $mod->table_name"."_cstm DROP COLUMN $col");
			}
			unset ($fields[$col]);
            echo string_format($mod_strings['LBL_UPGRADE_FIELDS_DROPPING_COLUMN'], array($col, $mod->table_name."_cstm", $the_module))."<br>";
		} else {
			if ($col != 'id_c') {
				$db_data_type = strtolower(str_replace(' ' , '', $the_field->get_db_type()));

				$type = strtolower(str_replace(' ' , '', $type));
				if (strcmp($db_data_type,$type) != 0) {

					echo string_format($mod_strings['LBL_UPGRADE_FIELDS_FIXING_COLUMN'], array($col, $type)) . $db_data_type."<br>";
					if (!$simulate) {
						$db->query($the_field->get_db_modify_alter_table($mod->table_name.'_cstm'));
                    }
				}
			}

			unset ($fields[$col]);
		}

	}

	echo sizeof($fields)." ".$mod_strings['LBL_UPGRADE_FIELDS_FIELD_MISSING']." $mod->table_name"."_cstm<br>";
	foreach ($fields as $field) {
		echo string_format($mod_strings['LBL_UPGRADE_FIELDS_ADDING_COLUMN'], array($field))." $mod->table_name"."_cstm<br>";
		if (!$simulate)
			$mod->custom_fields->add_existing_custom_field($field);
	}

}

DynamicField :: deleteCache();
echo '<br>'.$mod_strings['LBL_DONE'].'<br>';
if ($simulate) {
	echo '<a href="index.php?module=Administration&action=UpgradeFields&run=true">'.$mod_strings['LBL_UPGRADE_FIELDS_EXECUTE_NON_SIM_MODE'].'</a>';
}
?>