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

 define('VCREND', '50');
 define('VCRSTART', '10');
 /**
  * @api
  */
 class SugarVCR{

 	/**
 	 * records the query in the session for later retrieval
 	 */
 	function store($module, $query){
 		$_SESSION[$module .'2_QUERY'] = $query;
 	}

 	/**
 	 * This function retrieves a query from the session
 	 */
 	function retrieve($module){
 		return (!empty($_SESSION[$module .'2_QUERY']) ? $_SESSION[$module .'2_QUERY'] : '');
 	}

 	/**
 	 * return the start, prev, next, end
 	 */
 	function play($module, $offset){
 		//given some global offset try to determine if we have this
 		//in our array.
 		$ids = array();
 		if(!empty($_SESSION[$module.'QUERY_ARRAY']))
 			$ids = $_SESSION[$module.'QUERY_ARRAY'];
 		if(empty($ids[$offset]) || empty($ids[$offset+1]) || empty($ids[$offset-1]))
 			$ids = SugarVCR::record($module, $offset);
 		$menu = array();
 		if(!empty($ids[$offset])){
 			//return the control given this id
 			$menu['PREV'] = ($offset > 1) ? $ids[$offset-1] : '';
 			$menu['CURRENT'] = $ids[$offset];
 			$menu['NEXT'] = !empty($ids[$offset+1]) ? $ids[$offset+1] : '';
 		}
 		return $menu;
 	}

    function menu($module, $offset, $isAuditEnabled, $saveAndContinue = false ){
        $html_text = "";
        if ($offset < 0)
        {
            $offset = 0;
        }

        //this check if require in cases when you visit the edit view before visiting that modules list view.
        //you can do this easily either from home, activities or sitemap.
        $stored_vcr_query = SugarVCR::retrieve($module);

        // bug 15893 - only show VCR if called as an element in a set of records
        if (!empty($_REQUEST['record']) and !empty($stored_vcr_query) and isset($_REQUEST['offset']) and (empty($_REQUEST['isDuplicate']) or $_REQUEST['isDuplicate'] == 'false'))
        {
            //syncing with display offset;
            $offset ++;
            $action = (!empty($_REQUEST['action']) ? $_REQUEST['action'] : 'EditView');

            $menu = SugarVCR::play($module, $offset);

            $list_link = '';
            if ($saveAndContinue && !empty($menu['NEXT']))
            {
                $list_link = ajaxLink('index.php?action=' . $action . '&module=' . $module . '&record=' . $menu['NEXT'] . '&offset=' . ($offset + 1));
            }

            $previous_link = "";
            if (!empty($menu['PREV']))
            {
                $previous_link = ajaxLink('index.php?module=' . $module . '&action=' . $action . '&offset=' . ($offset - 1) . '&record=' . $menu['PREV']);
            }

            $next_link = "";
            if (!empty($menu['NEXT']))
            {
                $next_link = ajaxLink('index.php?module=' . $module . '&action=' . $action . '&offset=' . ($offset + 1) . '&record=' . $menu['NEXT']);
            }

            $ss = new Sugar_Smarty();
            $ss->assign('app_strings', $GLOBALS['app_strings']);
            $ss->assign('module', $module);
            $ss->assign('action', $action);
            $ss->assign('menu', $menu);
            $ss->assign('list_link', $list_link);
            $ss->assign('previous_link', $previous_link);
            $ss->assign('next_link', $next_link);

            $ss->assign('offset', $offset);
            $ss->assign('total', '');
            $ss->assign('plus', '');

            if (!empty($_SESSION[$module . 'total']))
            {
                $ss->assign('total', $_SESSION[$module . 'total']);
                if (
                    !empty($GLOBALS['sugar_config']['disable_count_query'])
                    && (($_SESSION[$module. 'total']-1) % $GLOBALS['sugar_config']['list_max_entries_per_page'] == 0)
                )
                {
                    $ss->assign('plus', '+');
                }
            }

            $html_text .= $ss->fetchCustom('include/EditView/SugarVCR.tpl');
        }
        return $html_text;
    }

 	function record($module, $offset){
 		$GLOBALS['log']->debug('SUGARVCR is recording more records');
 		$start = max(0, $offset - VCRSTART);
 		$index = $start;
	    $db = DBManagerFactory::getInstance();

 		$result = $db->limitQuery(SugarVCR::retrieve($module),$start,($offset+VCREND),false);
 		$index++;

 		$ids = array();
 		while(($row = $db->fetchByAssoc($result)) != null){
 			$ids[$index] = $row['id'];
 			$index++;
 		}
 		//now that we have the array of ids, store this in the session
 		$_SESSION[$module.'QUERY_ARRAY'] = $ids;
 		return $ids;
 	}

 	function recordIDs($module, $rids, $offset, $totalCount){
 		$index = $offset;
 		$index++;
 		$ids = array();
 		foreach($rids as $id){
 			$ids[$index] = $id;
 			$index++;
 		}
 		//now that we have the array of ids, store this in the session
 		$_SESSION[$module.'QUERY_ARRAY'] = $ids;
 		$_SESSION[$module.'total'] = $totalCount;
 	}

 	function erase($module){
 		unset($_SESSION[$module. 'QUERY_ARRAY']);
 	}

 }
?>
