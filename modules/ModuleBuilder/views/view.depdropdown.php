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

require_once('modules/ModuleBuilder/MB/ModuleBuilder.php');
require_once ("modules/ModuleBuilder/Module/StudioModuleFactory.php");

class ViewDepDropdown extends SugarView
{
    protected $vars = array("editModule", "field", "parentList", "childList");

    function display ()
    {
        $this->ss = new Sugar_Smarty();
        foreach($this->vars as $var)
        {
            if(isset($_REQUEST[$var])) {
                $this->$var = $_REQUEST[$var];
                $this->ss->assign($var, $_REQUEST[$var]);
            }
        }

        $mapping = empty($_REQUEST['mapping']) ? array() : json_decode(html_entity_decode($_REQUEST['mapping']), true);

        $this->ss->assign("mapping", $mapping);

        if (empty($_REQUEST['package']) || $_REQUEST['package'] == 'studio') {
            $sm = StudioModuleFactory::getStudioModule($_REQUEST['targetModule']);
            $fields = $sm->getFields();
            if (!empty($fields[$this->parentList]) && !empty($fields[$this->parentList]['options']))
                $this->parentList = $fields[$this->parentList]['options'];
            $parentOptions = translate($this->parentList);
            $childOptions = translate($this->childList);

        }
        else {
            $mb = new ModuleBuilder();
            $moduleName = $_REQUEST['targetModule'];
            $sm = $mb->getPackageModule($_REQUEST['package'], $moduleName);
            $sm->getVardefs();
            $fields = $sm->mbvardefs->vardefs['fields'];
            if (!empty($fields[$this->parentList]) && !empty($fields[$this->parentList]['options']))
                $this->parentList = $fields[$this->parentList]['options'];
            $parentOptions = $this->getMBOptions($this->parentList, $sm);
            $childOptions = $this->getMBOptions($this->childList, $sm);
        }

        $this->ss->assign("parent_list_options", $parentOptions);

        $parentOptionsArray = array();
        foreach($parentOptions as $value => $label)
        {
            $parentOptionsArray[] = array("value" => $value, "label" => $label);
        }
        $this->ss->assign("parentOptions",  json_encode($parentOptions));
        $this->ss->assign("child_list_options",  $childOptions);
        $childOptionsArray = array();
        foreach($childOptions as $value => $label)
        {
            $childOptionsArray[] = array("value" => $value, "label" => $label);
        }
        $this->ss->assign("childOptions",  json_encode($childOptionsArray));
        $this->ss->display("modules/ModuleBuilder/tpls/depdropdown.tpl");
    }


    protected function getMBOptions($label_key, $sm){
        global $app_list_strings;
        $lang = $GLOBALS['current_language'];
        $sm->mblanguage->generateAppStrings(false);
        $package_strings = $sm->mblanguage->getAppListStrings($lang.'.lang.php');
        $my_list_strings = $app_list_strings;
        $my_list_strings = array_merge($my_list_strings, $package_strings);
        foreach($my_list_strings as $key=>$value){
            if(!is_array($value)){
                unset($my_list_strings[$key]);
            }
        }

        if (empty($my_list_strings[$label_key]))
            return array();

        return $my_list_strings[$label_key];
    }
}
