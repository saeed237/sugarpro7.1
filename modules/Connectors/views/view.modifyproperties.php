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


require_once('include/MVC/View/SugarView.php');

class ViewModifyProperties extends SugarView 
{   
 	/**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;
	    
    	return array(
    	   "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
    	   "<a href='index.php?module=Connectors&action=ConnectorSettings'>".$mod_strings['LBL_ADMINISTRATION_MAIN']."</a>",
    	   $mod_strings['LBL_MODIFY_PROPERTIES_TITLE']
    	   );
    }
    
    /**
	 * @see SugarView::_getModuleTab()
	 */
	protected function _getModuleTab()
    {
        return 'Administration';
    }
    
    /**
	 * @see SugarView::display()
	 */
	public function display() 
	{
    	global $mod_strings, $app_strings;
		
		require_once('include/connectors/utils/ConnectorUtils.php');
		require_once('include/connectors/sources/SourceFactory.php');
		
		$this->ss->assign('mod', $mod_strings);
		$this->ss->assign('APP', $app_strings);
		$connectors = ConnectorUtils::getConnectors(true);
		$required_fields = array();
    	//Get required fields for first connector only

        $connectorsToShow = $connectors;
		foreach($connectors as $id=>$entry) {
			$s = SourceFactory::getSource($id);
			$connector_strings = ConnectorUtils::getConnectorStrings($id);
			$fields = $s->getRequiredConfigFields();
            
            if(!$s->isEnabledInAdminProperties() || empty($fields)){
                unset($connectorsToShow[$id]);
            }else{
                if(empty($required_fields)){
                    foreach($fields as $field_id) {
                        $label = isset($connector_strings[$field_id]) ? $connector_strings[$field_id] : $field_id;
                        $required_fields[$id][$field_id]=$label;
                    }
                }
            }
		}
		$this->ss->assign('SOURCES', $connectorsToShow);
		$this->ss->assign('REQUIRED_FIELDS', $required_fields);
	    echo $this->getModuleTitle(false);
        $this->ss->display($this->getCustomFilePathIfExists('modules/Connectors/tpls/modify_properties.tpl'));
    }
}