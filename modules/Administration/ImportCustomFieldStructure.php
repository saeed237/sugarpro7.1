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

	if(empty($_FILES)){
echo $mod_strings['LBL_IMPORT_CUSTOM_FIELDS_DESC'];
echo <<<EOQ
<br>
<br>
<form enctype="multipart/form-data" action="index.php" method="POST">
   	<input type='hidden' name='module' value='Administration'>
   	<input type='hidden' name='action' value='ImportCustomFieldStructure'>
   {$mod_strings['LBL_IMPORT_CUSTOM_FIELDS_STRUCT']}: <input name="sugfile" type="file" />
    <input type="submit" value="{$mod_strings['LBL_ICF_IMPORT_S']}" class='button'/>
</form>
EOQ;

	
	}else{
	
	$fmd = BeanFactory::getBean('EditCustomFields');
	
	echo $mod_strings['LBL_ICF_DROPPING'] . '<br>';
	$lines = file($_FILES['sugfile']['tmp_name']);
	$cur = array();
	foreach($lines as $line){

		if(trim($line) == 'DONE'){
			$fmd->new_with_id  = true;
			echo $mod_strings['LBL_IMPORT_CUSTOM_FIELDS_ADDING'].':'.$fmd->custom_module . '-'. $fmd->name. '<br>';
			$fmd->db->query("DELETE FROM $fmd->table_name WHERE id='$fmd->id'");
			$fmd->save(false);
			$fmd = BeanFactory::getBean('EditCustomFields');
			

			
		}else{

			$ln = explode(':::', $line ,2); 
			if(sizeof($ln) == 2){
			$KEY = trim($ln[0]);
				$fmd->$KEY = trim($ln[1]);
			}
		}	
		
	}
	$_REQUEST['run'] = true;
	$result = $fmd->db->query("SELECT count(*) field_count FROM $fmd->table_name");
	$row = $fmd->db->fetchByAssoc($result);
	echo $mod_strings['LBL_IMPORT_CUSTOM_FIELDS_COUNT'].' :' . $row['field_count'] . '<br>';
	include('modules/Administration/UpgradeFields.php');
	}
?>
