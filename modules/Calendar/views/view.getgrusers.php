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

require_once('include/MVC/View/SugarView.php');

class CalendarViewGetGRUsers extends SugarView {

	function CalendarViewGetGRUsers(){
 		parent::SugarView();
	}
	
	function process(){
		$this->display();
	}
	
	function display(){
		$users_arr = array();
		require_once("modules/Users/User.php");	
	
		$user_ids = explode(",", trim($_REQUEST['users'],','));	
		$user_ids = array_unique($user_ids);	

		require_once('include/json_config.php');
		global $json;
		$json = getJSONobj();
		$json_config = new json_config();        
	       
		foreach($user_ids as $u_id){
			if(empty($u_id))
				continue;
			$bean = BeanFactory::getBean('Users', $u_id);
			array_push($users_arr, $json_config->populateBean($bean));        	
		}
		
		$GRjavascript = "\n" . $json_config->global_registry_var_name."['focus'].users_arr = " . $json->encode($users_arr) . ";\n";       	
		ob_clean();
		echo $GRjavascript;
	}	

}

?>
