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

require_once('include/MVC/View/views/view.popup.php');
class ReportsViewPopup extends ViewPopup
{
	var $type ='list';

	function display()
	{
		global $popupMeta, $mod_strings;

        if(($this->bean instanceOf SugarBean) && !$this->bean->ACLAccess('list')){
            ACLController::displayNoAccess();
            sugar_cleanup(true);
        }

		if(isset($_REQUEST['metadata']) && strpos($_REQUEST['metadata'], "..") !== false) {
		    ACLController::displayNoAccess();
		    sugar_cleanup(true);
		}

		$popupMeta = SugarAutoLoader::loadPopupMeta($this->module, isset($_REQUEST['metadata'])?$_REQUEST['metadata']:null);

		$defs = $this->loadWithPopup('listviewdefs');
		if(is_array($defs)) {
		    $listViewDefs[$this->module] = $defs;
		} elseif(!empty($defs)) {
		    require $defs;
		}

		$defs = $this->loadWithPopup('searchdefs');
		if(is_array($defs)) {
			$searchdefs[$this->module]['layout']['advanced_search'] = $defs;
		} elseif(!empty($defs)) {
			require $defs;
		}

        if(!empty($this->bean) && isset($_REQUEST[$this->module.'2_'.strtoupper($this->bean->object_name).'_offset'])) {//if you click the pagination button, it will populate the search criteria here
            if(!empty($_REQUEST['current_query_by_page'])) {
                $blockVariables = array('mass', 'uid', 'massupdate', 'delete', 'merge', 'selectCount', 'lvso', 'sortOrder', 'orderBy', 'request_data', 'current_query_by_page');
                $current_query_by_page = unserialize(base64_decode($_REQUEST['current_query_by_page']));
                foreach($current_query_by_page as $search_key=>$search_value) {
                    if($search_key != $this->module.'2_'.strtoupper($this->bean->object_name).'_offset' && !in_array($search_key, $blockVariables)) {
						$_REQUEST[$search_key] = $GLOBALS['db']->quote($search_value);
                    }
                }
            }
        }

		foreach(SugarAutoLoader::existing('modules/' . $this->module . '/Popup_picker.php',
		    'include/Popups/Popup_picker.php') as $file) {
		    require_once $file;
		    break;
		}

		$popup = new Popup_Picker();
		$popup->_hide_clear_button = true;
		echo $popup->process_page();
	}
}
