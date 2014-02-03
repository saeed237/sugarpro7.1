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

 * Description: This file is used to override the default Meta-data EditView behavior
 * to provide customization specific to the Quotes module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once('modules/ModuleBuilder/MB/AjaxCompose.php');
require_once('modules/Leads/ConvertLayoutMetadataParser.php');

class ViewEditConvert extends SugarView {

	protected $_viewdefs = array();
	protected $fileName = "modules/Leads/metadata/convertdefs.php";

	function __construct ()
    {
	    parent::SugarView();
        global $current_user;
        if(!$current_user->isDeveloperForModule("Leads"))
        {
            die("Unauthorized Access to Administration");
        }

        if (isset($_REQUEST['action']) && ($_REQUEST['action'] == "saveLayout" || $_REQUEST['action'] == "saveAndPublishLayout"))
        {
        	$this->parser = new ConvertLayoutMetadataParser($_REQUEST['view_module']);
        	$this->parser->handleSave(true);
        }

        if (isset($_REQUEST['updateOrder']) && $_REQUEST['updateOrder'] && !empty($_REQUEST['data']))
        {
            require_once("include/JSON.php");
        	$json = new JSON();
        	$this->parser = new ConvertLayoutMetadataParser("Contacts");
            $this->parser->updateOrder(object_to_array_recursive($json->decode(html_entity_decode_utf8($_REQUEST['data']))));
        }

        if (isset($_REQUEST['removeLayout']) && $_REQUEST['removeLayout'] && !empty($_REQUEST['targetModule']))
        {
            require_once("include/JSON.php");
            $json = new JSON();
            $this->parser = new ConvertLayoutMetadataParser("Contacts");
            $this->parser->removeLayout($_REQUEST['targetModule']);
        }

    }

    function display(){
    	$smarty = $this->constructSmarty();

    	$ajax = new AjaxCompose();
        $ajax->addCrumb(translate('LBL_STUDIO', 'ModuleBuilder'), 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard")');
        $ajax->addCrumb(translate('LBL_MODULE_NAME'), 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view_module=Leads")');
        $ajax->addCrumb(translate('LBL_LAYOUTS', 'ModuleBuilder'), 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view=layouts&view_module=Leads")');
        $ajax->addCrumb(translate('LBL_CONVERTLEAD'), "");
        $ajax->addSection ( 'center', 'Convert Layout', $smarty->fetch ( "modules/Leads/tpls/EditConvertLead.tpl" ) ) ;

        echo $ajax->getJavascript();
    }

    protected function constructSmarty ()
    {
        global $mod_strings, $current_language;
        $json = getJSONobj () ;

    	$smarty = new Sugar_Smarty ( ) ;
        $smarty->assign ( 'translate', true ) ;
        $smarty->assign ( 'language', "Leads" ) ;
        $smarty->assign ( 'view_module', "Leads" ) ;
        $smarty->assign ( 'module', "Leads" ) ;
        $smarty->assign ( 'helpName', 'listViewEditor' ) ;
        $smarty->assign ( 'helpDefault', 'modify' ) ;
        $smarty->assign ( 'title', 'Convert Layout') ;
        $modules = $this->getModulesFromDefs();
        $smarty->assign ( 'modules', $json->encode ($modules) ) ;
        require_once 'modules/ModuleBuilder/parsers/relationships/DeployedRelationships.php' ;
        $relatableModules = DeployedRelationships::findRelatableModules () ;

        unset($relatableModules['Activities']);
        unset($relatableModules['KBDocuments']);
        unset($relatableModules['Products']);
        unset($relatableModules['ProductTemplates']);
        // bug 43393 - don't let Leads (or any non-contact module derived from Person) be added to convert flow
        unset($relatableModules['Leads']);
        unset($relatableModules['Users']);

        foreach($modules as $mDef) {
            if (isset($relatableModules[$mDef['module']]))
                unset($relatableModules[$mDef['module']]);
        }
        $displayModules = array();
        foreach ($relatableModules as $mod => $def)
        {
        	$displayModules[$mod] = translate($mod);
        }
        $smarty->assign ( 'availibleModules', $displayModules) ;
        $smarty->assign ( 'availibleModulesValues', $displayModules) ;
        $smarty->assign ( 'availibleModulesJSON', $json->encode ($relatableModules) ) ;
        $smarty->assign ( 'relationships', $json->encode ($this->getRelationshipsForModules($modules))) ;

        // Bug 38245 - Warn users if they were using the old lead convert screen and are looking to modify the new one
        if ( ( SugarAutoLoader::existingCustom('modules/Leads/ConvertLead.php') )
                && !SugarAutoLoader::existing('custom/modules/Leads/metadata/convertdefs.php') ) {
            $smarty->assign ( 'warningMessage', translate ('LBL_NOTICE_OLD_LEAD_CONVERT_OVERRIDE','Leads') ) ;
        }

        return $smarty ;
    }


    protected function getModulesFromDefs(){
        global $app_list_strings;

        $modules = array();
        if (!isset($this->defs))
        {
            $this->loadDefs();
        }
        foreach($this->defs as $module => $views)
        {
            foreach($views as $view => $def)
            {
                $modules[] = array(
                    "module" => $module,
                    "moduleName" => $app_list_strings['moduleList'][$module],
                    "required" => isset($def['required']) ? $def['required'] : false,
                    "select"   => isset($def['select'])   ? $def['select']   : false,
                    "copyData" => isset($def['copyData']) ? $def['copyData'] : false,
                );
            }
        }
        return $modules;
    }

    protected function getRelationshipsForModules($modules)
    {
    	$ret = array();
    	$seed = BeanFactory::getBean('Contacts');
    	$bean_rels = $seed->get_related_fields();
    	foreach($modules as $mDef)
    	{
    		foreach($bean_rels as $field => $fDef)
    		{
    			if (!empty($fDef['link']) && !empty($fDef['module']) && $fDef['module'] == $mDef['module'])
    			{
    				$ret[$mDef['module']][] = $fDef['name'];
    			}
    		}
    	}
    	return $ret;
    }

    protected function loadDefs()
    {
        $viewdefs = array();
        $this->medataDataFile = SugarAutoLoader::existingCustomOne($this->fileName);
        include($this->medataDataFile);
        $this->defs = $viewdefs;
    }


}
