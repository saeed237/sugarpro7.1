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

/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/




global $mod_strings;


$focus = BeanFactory::getBean('ProspectLists', $_POST['record']);
if (isset($_POST['isDuplicate']) && $_POST['isDuplicate'] == true) {

	$focus->id='';
	$focus->name=$mod_strings['LBL_COPY_PREFIX'].' '.$focus->name;
	
	$focus->save();
	$return_id=$focus->id; 
	//duplicate the linked items.
	$query  = "select * from prospect_lists_prospects where prospect_list_id = '".$_POST['record']."'";
	$result = $focus->db->query($query);
	if ($result != null) {
	
		while(($row = $focus->db->fetchByAssoc($result)) != null) {
			$iquery ="INSERT INTO prospect_lists_prospects (id,prospect_list_id, related_id, related_type,date_modified) ";
			$iquery .= "VALUES ("."'".create_guid()."',"."'".$focus->id."',"."'".$row['related_id']."',"."'".$row['related_type']."',"."'".TimeDate::getInstance()->nowDb()."')";
			$focus->db->query($iquery); //save the record.	
		}	
	}
}
header("Location: index.php?action=DetailView&module=ProspectLists&record=$return_id");
?>