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

require_once('modules/Reports/config.php');

class ReportsViewBuildreportmoduletree extends SugarView
{
    /**
     * @see SugarView::display()
     */
    public function display()
    {
        global $beanFiles, $beanList, $app_list_strings;
        if(empty($beanFiles)) {
            include('include/modules.php');
        }

        $ACLAllowedModules = getACLAllowedModules();
        $module_array = array();

        $module = BeanFactory::getBean($_REQUEST['report_module']);
        $bean_name = $module->object_name;
        $linked_fields = $module->get_linked_fields();

        foreach($linked_fields as $linked_field)
        {
            $module->load_relationship($linked_field['name']);
            $field = $linked_field['name'];
            if(empty($module->$field) || (isset($linked_field['reportable']) && $linked_field['reportable'] == false))
            {
                continue;
            }
            $relationship = $module->$field->_relationship;
            if(empty($relationship) || empty($beanList[$relationship->lhs_module]) || empty($beanList[$relationship->rhs_module]))
            {
                continue;
            }
            // Bug 37311 - Don't allow reporting on relationships to the currencies module
            if($relationship->lhs_module == 'Currencies' || $relationship->rhs_module == 'Currencies') {
                continue;
            }

            $bean_is_lhs = $module->$field->_get_bean_position();
            if($bean_is_lhs == true && isset($beanList[$relationship->rhs_module])) {
                $link_bean = $beanList[$relationship->rhs_module];
                $link_module = $relationship->rhs_module;
            }
            else if (isset($beanList[$relationship->lhs_module])){
                $link_bean =  $beanList[$relationship->lhs_module];
                $link_module = $relationship->lhs_module;
            }
            if (!isset($ACLAllowedModules[$link_module])) {
                continue;
            }

			$custom_label = 'LBL_' . strtoupper ( $relationship->relationship_name . '_FROM_' . $link_module  ) . '_TITLE';
			$custom_subpanel_label  = 'LBL_' . strtoupper ( $link_module) . '_SUBPANEL_TITLE';
			//bug 47834
			$lang = $GLOBALS['current_language'];
			foreach(SugarAutoLoader::existing("custom/modules/".$_REQUEST['report_module']."/Ext/Language/".$lang.".lang.ext.php") as $file) {
			    require $file;
			}//end 47834
			// Bug 37308 - Check if the label was changed in studio
		    //bug 47834 -  added check to see if the new label name is set in custom $lang.lang.ext.php file
            if (translate($custom_label, $_REQUEST['report_module']) != $custom_label && isset($mod_strings[$custom_label]))
			{
				$linked_field['label'] = translate($custom_label, $_REQUEST['report_module']);
            }
			// Bug 37308 - Check if the label was changed in studio
			//bug 47834 -  added check to see if the new label name is set in custom $lang.lang.ext.php file
            elseif (translate($custom_subpanel_label, $_REQUEST['report_module']) != $custom_subpanel_label && $link_module != $_REQUEST['report_module'] && isset($mod_strings[$custom_subpanel_label]))
			{
				$linked_field['label'] = translate($custom_subpanel_label, $_REQUEST['report_module']);
            }
            elseif (! empty($linked_field['vname']))
            {
                $linked_field['label'] = translate($linked_field['vname'], $_REQUEST['report_module']);
            } else {
                $linked_field['label'] =$linked_field['name'];
            }
            $linked_field['label'] = preg_replace('/:$/','',$linked_field['label']);
            $linked_field['label'] = addslashes($linked_field['label']);

	if (isset($app_list_strings['moduleList'][$linked_field['label']])) {
		$linked_field['label'] = $app_list_strings['moduleList'][$linked_field['label']];
	}

            $module_array[] = $this->_populateNodeItem($bean_name,$link_module,$linked_field);
        }

        // Sort alphabetically
        function compare_text($a, $b) {
            return strnatcmp($a['text'], $b['text']);
        }
        usort($module_array, 'compare_text');

        $json = getJSONobj();
        echo $json->encode($module_array);
    }

    protected function _populateNodeItem($bean_name,$link_module,$linked_field)
    {
        $node = array();
        $node['text'] = $linked_field['label'];
        $node['href'] = "javascript:SUGAR.reports.populateFieldGrid('". $link_module . "','".$linked_field['relationship']."','".$bean_name."','".str_replace(array('&#039;', '&#39;'), "\'", $linked_field['label'])."');";
        $node['leaf'] = false;
        $node['category'] = $link_module;
        $node['relationship_name'] = $linked_field['relationship'];
        $node['link_name'] = $linked_field['name'];
        $node['link_module'] = $link_module;
        return $node;
    }
}