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

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/SugarWireless/SugarWirelessListView.php');

/**
 * ViewWirelesslist extends SugarWirelessView and is the view for wireless list views.
 *
 */
class ViewWirelesslist extends SugarWirelessListView
{

 	/**
 	 * Private function for wireless list view
 	 *
 	 * This function retrieves the parameters from the search form or saved search and builds
 	 * a list view for smarty consumption. It is dependent on a REQUEST variable that provides the
 	 * search parameters.
 	 *
 	 * The function returns smarty assignments with the list data and other parameters.
 	 */
 	protected function wl_list_view_display(){
		// retrieve SavedSearch contents and populate $_REQUEST in preparation for searchForm->populateFromRequest()
		$backed_request = $_REQUEST;
		if (isset($_REQUEST['wl_saved_search_select'])){

			$savedSearch = BeanFactory::getBean('SavedSearch', $_REQUEST['wl_saved_search_select']);
			$_REQUEST = $savedSearch->returnSavedSearchContents($_REQUEST['wl_saved_search_select']);

			$this->ss->assign('SAVED_SEARCH_NAME', $savedSearch->name);
		}
		// set up Search Form to attain where clause
		$defs = SugarAutoLoader::loadWithMetafiles($GLOBALS['module'], 'searchdefs');
		if ($defs) {
			require_once('include/SearchForm/SearchForm2.php');
			$searchForm = new SearchForm($this->bean, $GLOBALS['module'], 'wirelesslist');
			$defs = SearchForm::retrieveSearchDefs($GLOBALS['module']);
			$searchForm->setup($defs['searchdefs'], $defs['searchFields'], 'SearchFormGeneric.tpl');
			$searchdefs = $defs['searchdefs'];
		}
		else{
			require_once('include/SearchForm/SearchForm.php');
			$searchForm = new SearchForm($GLOBALS['module'], $this->bean);
			$searchForm->setup();
			$searchdefs = array();
		}
		// determine where clause from _REQUEST variable
		$searchForm->populateFromRequest();
		$where_clauses = $searchForm->generateSearchWhere(true, $this->bean->module_dir);
		// if my_items flag is set, also append the assigned_user_id check
        $this->ss->assign('myitems', 'checked');
		if (isset($_REQUEST['my_items']) && $_REQUEST['my_items'] == 'on'){
			$where_clauses[] = $this->bean->table_name . ".assigned_user_id = '" . $GLOBALS['current_user']->id . "'";
        }
        else {
            $this->ss->assign('myitems', '');
		}
		$where = '';
		if (count($where_clauses) > 0 )$where = '('. implode(' ) AND ( ', $where_clauses) . ')';
		// reset $_REQUEST variable
		$_REQUEST = $backed_request;
		// set the limit query number
		if (isset($GLOBALS['sugar_config']['wl_list_max_entries_per_page'])){
			$limit = $GLOBALS['sugar_config']['wl_list_max_entries_per_page'];
		}
		else{
			$limit = 10;
		}

		// retrieve list view data according to where clause
		require_once('include/ListView/ListViewData.php');
		$lvd = new ListViewData();
		// get and set list view data
		$data = $lvd->getListViewData($this->bean, $where,0,$limit,$this->get_filter_fields($GLOBALS['module']),array('orderBy' => 'name'));
		$data['pageData']['offsets']['lastOffsetOnPage'] = $data['pageData']['offsets']['current'] + count($data['data']);

        $navStrings = array('next' => $GLOBALS['app_strings']['LNK_LIST_NEXT'],
                            'previous' => $GLOBALS['app_strings']['LNK_LIST_PREVIOUS'],
                            'end' => $GLOBALS['app_strings']['LNK_LIST_END'],
                            'start' => $GLOBALS['app_strings']['LNK_LIST_START'],
                            'of' => $GLOBALS['app_strings']['LBL_LIST_OF']);
        $this->ss->assign('navStrings', $navStrings);

		// DATA holds the list view records
		$this->ss->assign('DATA', $data['data']);
		// PAGEDATA holds the pagination parameters as well as offset and limit values
		$this->ss->assign('PAGEDATA', $data['pageData']);

		$this->ss->assign('WL_SEARCH_FORM', $this->wl_search_form($searchdefs));
		$this->ss->assign('WL_SAVED_SEARCH_FORM', $this->wl_saved_search_form());
 	}

 	/**
 	 * Private function that retrieves the subpanel records for a given record.
 	 *
 	 * The purpose of this function is to get all of the subpanel records from the
 	 * (See All Records) link on a detail view. It is dependent on the presence of a
 	 * parent_id REQUEST variable, and utilizes the wl_get_subpanel_data method to
 	 * gain the subpanel data.
 	 *
 	 * The function provides smarty variable assignment for the subpanel data for the
 	 * particular record, as well as the record itself.
 	 */
 	protected function wl_subpanel_list_view_display(){
 		// instantiate a child seed object

        $layout_defs = $this->getSubpanelDefs();
        $subpanel = isset($_REQUEST['subpanel']) ? $_REQUEST['subpanel'] : "";
        if (!empty($layout_defs['subpanel_setup'][$subpanel]))
        {
            $this->bean->retrieve($_REQUEST['parent_id']);
            $def = $layout_defs['subpanel_setup'][$subpanel];
            $link = !empty($def['get_subpanel_data']) ? $def['get_subpanel_data'] :  $subpanel;
            if ($this->bean->load_relationship($link))
            {
                $beans = $this->bean->$link->getbeans();
                $module = $this->bean->$link->getRelatedModuleName();
                $this->ss->assign('BEAN', $this->bean);
                $this->ss->assign('SUBPANEL_MODULE', $module);
                $this->ss->assign('SUBPANEL_LIST_VIEW', true);
                $this->ss->assign('DATA', $beans);
            }
        }
     }

 	/**
 	 * Public function that handles the display of the wireless list view.
 	 */
 	public function display(){
 		// print the header
		$this->wl_header();
		// print the select list
		$this->wl_select_list();

       	$this->ss->assign('displayColumns',$this->displayColumns);

		// check for presence of parent_id -- this is the subpanel list view
		if (isset($_REQUEST['parent_id'])){
			$this->wl_subpanel_list_view_display();
		}
		// normal list view display
		else{
			$this->wl_list_view_display();
		}

        $this->ss->assign('LITERAL_MODULE',$GLOBALS['app_strings']['LBL_SEARCH_MODULES']);
		// display the list view
		$this->ss->display('include/SugarWireless/tpls/wirelesslist.tpl');

		// print the footer
		$this->wl_footer();
 	}
}
?>
