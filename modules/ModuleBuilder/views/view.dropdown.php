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

require_once('modules/ModuleBuilder/MB/AjaxCompose.php');

class ViewDropdown extends SugarView
{
    /**
     * @see SugarView::_getModuleTitleParams()
     */
    protected function _getModuleTitleParams($browserTitle = false)
    {
        global $mod_strings;

        return array(
            translate('LBL_MODULE_NAME','Administration'),
            ModuleBuilderController::getModuleTitle(),
        );
    }

    function display()
    {
        $ajax = new AjaxCompose();
        $smarty = $this->generateSmarty();

        if (isset($_REQUEST['refreshTree'])) {
            require_once ('modules/ModuleBuilder/Module/DropDownTree.php');
            $mbt = new DropDownTree();
            $ajax->addSection('west', $mbt->getName(), $mbt->fetchNodes());
            $smarty->assign('refreshTree',true);
        }

        global $mod_strings;

        $smarty->assign('deleteImage', SugarThemeRegistry::current()->getImage('delete_inline', '', null, null, '.gif', $mod_strings['LBL_MB_DELETE']));
        $smarty->assign('editImage', SugarThemeRegistry::current()->getImage('edit_inline', '', null, null, '.gif', $mod_strings['LBL_EDIT']));
        $smarty->assign('action', 'savedropdown');
        $body = $smarty->fetch('modules/ModuleBuilder/tpls/MBModule/dropdown.tpl');
        $ajax->addSection('east2', $mod_strings['LBL_SECTION_DROPDOWNED'], $body);
         echo $ajax->getJavascript();
     }

     function generateSmarty()
     {
        global $locale;

        //get the selected language
        if (!empty($_REQUEST['dropdown_lang'])) {
            $selected_lang = $_REQUEST['dropdown_lang'];
        } else {
            $selected_lang = $locale->getAuthenticatedUserLanguage();
        }

        $vardef = array();
        $package_name = 'studio';
        $package_strings = array();
        $new =false;
        $my_list_strings = return_app_list_strings_language( $selected_lang ) ;

        $smarty = new Sugar_Smarty();

        //if we are using ModuleBuilder then process the following
        if (!empty($_REQUEST['view_package']) && $_REQUEST['view_package'] != 'studio') {
            require_once('modules/ModuleBuilder/MB/ModuleBuilder.php');
            $mb = new ModuleBuilder();
            $module = $mb->getPackageModule($_REQUEST['view_package'], $_REQUEST['view_module']);
            $package = $mb->packages[$_REQUEST['view_package']];
            $package_name = $package->name;
            $module->getVardefs();
            if (empty($_REQUEST['dropdown_name']) && !empty($_REQUEST['field'])) {
                $new = true;
                $_REQUEST['dropdown_name'] = $_REQUEST['field']. '_list';
            }

            $vardef = (!empty($module->mbvardefs->fields[$_REQUEST['dropdown_name']]))? $module->mbvardefs->fields[$_REQUEST['dropdown_name']]: array();
            $module->mblanguage->generateAppStrings(false);
            $my_list_strings = array_merge($my_list_strings, $module->mblanguage->appListStrings[$selected_lang.'.lang.php']);
            $smarty->assign('module_name', $module->name);
        }

        $module_name = !empty($module->name) ?  $module->name : '';
        $module_name = (empty($module_name) && !empty($_REQUEST['view_module'])) ?  $_REQUEST['view_module'] : $module_name;

        foreach ($my_list_strings as $key=>$value) {
            if (!is_array($value)) {
                unset($my_list_strings[$key]);
            }
        }

        $dropdowns = array_keys($my_list_strings);
        asort($dropdowns);
        $keys = array_keys($dropdowns);
        $first_string = $my_list_strings[$dropdowns[$keys[0]]];

        $name = '';
        $selected_dropdown = array();

        $json = getJSONobj();
        
        $required_items = array();
        if (!empty($_REQUEST['dropdown_name']) && !$new) {
            $name = $_REQUEST['dropdown_name'];

            // handle the case where we've saved a dropdown in one language, and
            // now attempt to edit it for another language. The $name exists, 
            // but $my_list_strings[$name] doesn't for now, we just treat it as 
            // if it was new. A better approach might be to use the first language 
            // version as a template for future languages
            if (!isset($my_list_strings[$name])) {
                $my_list_strings[$name] = array();
            }
            
            // Handle required elements of a drop down
            $required_items = getRequiredDropdownListItemsByDDL($name);

            $selected_dropdown = (!empty($vardef['options']) && !empty($my_list_strings[$vardef['options']])) ? $my_list_strings[$vardef['options']] : $my_list_strings[$name];
            $smarty->assign('ul_list', 'list = '.$json->encode(array_keys($selected_dropdown)));
            $smarty->assign('dropdown_name', (!empty($vardef['options']) ? $vardef['options'] : $_REQUEST['dropdown_name']));
            $smarty->assign('name', $_REQUEST['dropdown_name']);
            $smarty->assign('options', $selected_dropdown);
        } else {
            $smarty->assign('ul_list', 'list = {}');
            //we should try to find a name for this dropdown based on the field name.
            $pre_pop_name = '';
            if (!empty($_REQUEST['field'])) {
                $pre_pop_name = $_REQUEST['field'];
            }
            //ensure this dropdown name does not already exist
            $use_name = $pre_pop_name.'_list';
            for ($i = 0; $i < 100; $i++) {
                if (empty($my_list_strings[$use_name])) {
                    break;
                } else {
                    $use_name = $pre_pop_name.'_'.$i;
                }
            }
            $smarty->assign('prepopulated_name', $use_name);
        }

        $smarty->assign('required_items', json_encode($required_items));
        $smarty->assign('module_name', $module_name);
        $smarty->assign('APP', $GLOBALS['app_strings']);
        $smarty->assign('MOD', $GLOBALS['mod_strings']);
        $smarty->assign('selected_lang', $selected_lang);
        $smarty->assign('available_languages',get_languages());
        $smarty->assign('package_name', $package_name);
        return $smarty;
     }
}
