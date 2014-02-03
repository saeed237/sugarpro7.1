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


require_once('include/MVC/View/views/view.list.php');
require_once('include/connectors/sources/SourceFactory.php');

class ViewSearchProperties extends ViewList 
{
 	/**
	 * @see SugarView::process()
	 */
	public function process() 
	{
 		$this->options['show_all'] = false;
 		$this->options['show_javascript'] = true;
 		$this->options['show_footer'] = false;
 		$this->options['show_header'] = false;
 	    parent::process();
 	}
 	
    /**
	 * @see SugarView::display()
	 */
	public function display() 
	{    	
        require_once('include/connectors/utils/ConnectorUtils.php');
        require_once('include/connectors/sources/SourceFactory.php');
        $source_id = $_REQUEST['source_id'];
        $connector_strings = ConnectorUtils::getConnectorStrings($source_id);
        $is_enabled = ConnectorUtils::isSourceEnabled($source_id);
        $modules_sources = array();
        $sources = ConnectorUtils::getConnectors();
        $display_data = array();
        
        if($is_enabled) {
	        $searchDefs = ConnectorUtils::getSearchDefs();
	        $searchDefs = !empty($searchDefs[$_REQUEST['source_id']]) ? $searchDefs[$_REQUEST['source_id']] : array();
	                
	        $source = SourceFactory::getSource($_REQUEST['source_id']);
	        $field_defs = $source->getFieldDefs();
	       

	    	//Create the Javascript code to dynamically add the tables
	    	$json = getJSONobj();
	    	foreach($searchDefs as $module=>$fields) {
	    		
	    		$disabled = array();
	    		$enabled = array();
	 		
	    		$enabled_fields = array_flip($fields);
	    		$field_keys = array_keys($field_defs);
	
	    		foreach($field_keys as $index=>$key) {
                    if(!empty($field_defs[$key]['hidden']) || empty($field_defs[$key]['search'])) {
                       continue;
                    }

	    			if(!isset($enabled_fields[$key])) {
	    			   $disabled[$key] = !empty($connector_strings[$field_defs[$key]['vname']]) ? $connector_strings[$field_defs[$key]['vname']] : $key;
	    			} else {
	    			   $enabled[$key] = !empty($connector_strings[$field_defs[$key]['vname']]) ? $connector_strings[$field_defs[$key]['vname']] : $key;
	    			}
	    		}
	
	    		$modules_sources[$module] = array_merge($enabled, $disabled);

	    		asort($disabled);
	    		$display_data[$module] = array('enabled' => $enabled, 'disabled' => $disabled,
                                               'module_name' => isset($GLOBALS['app_list_strings']['moduleList'][$module]) ? $GLOBALS['app_list_strings']['moduleList'][$module] : $module);
	    	}	
        }
        
        $this->ss->assign('no_searchdefs_defined', !$is_enabled);	
    	$this->ss->assign('display_data', $display_data);
	    $this->ss->assign('modules_sources', $modules_sources);    	
    	$this->ss->assign('sources', $sources);
    	$this->ss->assign('mod', $GLOBALS['mod_strings']);
    	$this->ss->assign('APP', $GLOBALS['app_strings']);
    	$this->ss->assign('source_id', $_REQUEST['source_id']);
    	$this->ss->assign('theme', $GLOBALS['theme']);
    	$this->ss->assign('connector_language', $connector_strings);
    	echo $this->ss->fetch($this->getCustomFilePathIfExists('modules/Connectors/tpls/search_properties.tpl'));
    }
}