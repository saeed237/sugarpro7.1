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

class CalendarViewGetGR extends SugarView {

	function CalendarViewGetGR(){
 		parent::SugarView();
	}
	
	function process(){
		$this->display();
	}
	
	function display(){
		error_reporting(0);
		require_once('include/json_config.php');
		global $json;
        	$json = getJSONobj();
        	$json_config = new json_config();
        	$GRjavascript = $json_config->getFocusData($_REQUEST['type'], $_REQUEST['record']);
        	ob_clean();
        	echo $GRjavascript;
	}	

}

?>
