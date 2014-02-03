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




global $theme;









class Popup_Picker
{
	
	
	/*
	 * 
	 */
	function Popup_Picker()
	{
		;
	}
	
	/*
	 * 
	 */
	function _get_where_clause()
	{
		$where = '';
		if(isset($_REQUEST['query']))
		{
			$where_clauses = array();
			append_where_clause($where_clauses, "name", "saved_reports.name");
			append_where_clause($where_clauses, "module_name", "saved_reports.module");		
			$where = generate_where_statement($where_clauses);
		}
		
		return $where;
	}
	
	/**
	 *
	 */
	function process_page()
	{
		global $theme;
		global $mod_strings;
		global $app_strings;
		global $app_list_strings;
		global $currentModule;
		global $sugar_version, $sugar_config;
		
		$output_html = '';
		$where = '';
		
		$where = $this->_get_where_clause();
		
		
		
		$name = empty($_REQUEST['name']) ? '' : $_REQUEST['name'];

		$request_data = empty($_REQUEST['request_data']) ? '' : $_REQUEST['request_data'];
		$hide_clear_button = empty($_REQUEST['hide_clear_button']) ? false : true;
		$button  = "<form action='index.php' method='post' name='form' id='form'>\n";
		//START:FOR MULTI-SELECT
		$multi_select=false;
		if (!empty($_REQUEST['mode']) && strtoupper($_REQUEST['mode']) == 'MULTISELECT') {
			$multi_select=true;
			$button .= "<input type='button' name='button' id='selectButton' class='button' onclick=\"send_back_selected('SavedReports',document.MassUpdate,'mass[]','" .$app_strings['ERR_NOTHING_SELECTED']."');\" title='"
				.$app_strings['LBL_SELECT_BUTTON_TITLE']."' value='  "
				.$app_strings['LBL_SELECT_BUTTON_LABEL']."  ' />\n";
		}
		//END:FOR MULTI-SELECT
		if(!$hide_clear_button)
		{
			$button .= "<input type='button' name='button' id='clearButton' class='button' onclick=\"send_back('','');\" title='"
				.$app_strings['LBL_CLEAR_BUTTON_TITLE']."' value='  "
				.$app_strings['LBL_CLEAR_BUTTON_LABEL']."  ' />\n";
		}
		$button .= "<input type='submit' name='button' id='selectButton' class='button' onclick=\"window.close();\" title='"
			.$app_strings['LBL_CANCEL_BUTTON_TITLE']."' accesskey='"
			.$app_strings['LBL_CANCEL_BUTTON_KEY']."' value='  "
			.$app_strings['LBL_CANCEL_BUTTON_LABEL']."  ' />\n";
		$button .= "</form>\n";

		$form = new XTemplate('modules/Reports/Popup_picker.html');
		$form->assign('MOD', $mod_strings);
		$form->assign('APP', $app_strings);
		$form->assign('THEME', $theme);
		$form->assign('MODULE_NAME', $currentModule);
		$form->assign('request_data', $request_data);
		if (!empty($_REQUEST['module_name'])) $form->assign('FILTER_MODULE_NAME', $_REQUEST['module_name']);
		
		$form->assign('NAME', $name);

		ob_start();
		insert_popup_header($theme);
		$output_html .= ob_get_contents();
		ob_end_clean();
		
		$output_html .= get_form_header($mod_strings['LBL_SEARCH_FORM_TITLE'], '', false);
		
		$form->parse('main.SearchHeader');
		$output_html .= $form->text('main.SearchHeader');
		
		// Reset the sections that are already in the page so that they do not print again later.
		$form->reset('main.SearchHeader');

		// create the listview
		$seed_bean = BeanFactory::getBean('Reports');
		$ListView = new ListView();
		$ListView->show_export_button = false;
		$ListView->process_for_popups = true;
		
		// Bug 50020
		// If the popup mode is SINGLE, don't show select dropdown or delete button
		$mode  = empty($_REQUEST['mode']) ? '' : strtoupper($_REQUEST['mode']);
		if ($mode == "SINGLE") {
			$ListView->show_select_menu = false;
			$ListView->show_delete_button = false;
		}
		
		$ListView->setXTemplate($form);
		$ListView->multi_select_popup=$multi_select;  //FOR MULTI-SELECT	
		if ($multi_select) $ListView->xTemplate->assign("TAG_TYPE","SPAN"); else  $ListView->xTemplate->assign("TAG_TYPE","A");//FOR MULTI-SELECT
		//$ListView->setHeaderTitle($mod_strings['LBL_LIST_FORM_TITLE']); //FOR MULTI-SELECT
		//$ListView->setHeaderText($button); //FOR MULTI-SELECT
		$ListView->setQuery($where, '', 'name', 'SAVEDREPORT');
		$ListView->setModStrings($mod_strings);

		ob_start();
		$output_html .= get_form_header($mod_strings['LBL_LIST_FORM_TITLE'], $button, false); //FOR MULTI-SELECT		
		$ListView->processListView($seed_bean, 'main', 'SAVEDREPORT');
		$output_html .= ob_get_contents();
		ob_end_clean();
				
		$output_html .= insert_popup_footer();
		return $output_html;
	}
} // end of class Popup_Picker
?>