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
require_once('modules/Teams/Popup_picker.php');
class TeamsViewPopup extends SugarView
{
	var $type ='list';

	function display(){
		if(SugarAutoLoader::existing('modules/' . $this->module . '/Popup_picker.php')){
			require_once('modules/' . $this->module . '/Popup_picker.php');
		}else{
			require_once('include/Popups/Popup_picker.php');
		}

		$popup = new Popup_Picker();
		$popup->_hide_clear_button = true;
		if(!empty($_REQUEST['html'])){
			$method = $_REQUEST['html'];
			if(method_exists($popup, $method)){
				echo $popup->$method();
				return;
			}
		}
		echo $popup->process_page();
	}
}