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

class ViewSourceProperties extends ViewList {
   
 	function ViewSourceProperties(){
 		parent::ViewList();
 	}

    function display() {
		require_once('include/connectors/sources/SourceFactory.php');
		require_once('include/connectors/utils/ConnectorUtils.php');
		
		$source_id = $_REQUEST['source_id'];
		$connector_language = ConnectorUtils::getConnectorStrings($source_id);
    	$source = SourceFactory::getSource($source_id);
    	$properties = $source->getProperties();
        
    	$required_fields = array();
    	$config_fields = $source->getRequiredConfigFields();
	    $fields = $source->getRequiredConfigFields();
	    foreach($fields as $field_id) {
	    	$label = isset($connector_language[$field_id]) ? $connector_language[$field_id] : $field_id;
	        $required_fields[$field_id]=$label;
	    }
    	
    	$this->ss->assign('required_properties', $required_fields);
    	$this->ss->assign('source_id', $source_id);
    	$this->ss->assign('properties', $properties);
    	$this->ss->assign('mod', $GLOBALS['mod_strings']);
    	$this->ss->assign('app', $GLOBALS['app_strings']);
    	$this->ss->assign('connector_language', $connector_language);
    	$this->ss->assign('hasTestingEnabled', $source->hasTestingEnabled());

        echo $this->ss->fetch($this->getCustomFilePathIfExists('modules/Connectors/tpls/source_properties.tpl'));
    }
}

