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

/*
 * Created on Jul 24, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once 'modules/ModuleBuilder/MB/AjaxCompose.php';
require_once 'modules/ModuleBuilder/views/view.modulefields.php';
require_once 'modules/ModuleBuilder/parsers/ParserFactory.php';

class ViewLabels extends ViewModulefields
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

     //STUDIO LABELS ONLY//
     //TODO Bundle Studio and ModuleBuilder label handling to increase maintainability.
     function display()
     {
        global $locale;

        $editModule = $_REQUEST['view_module'];
        $allLabels = (!empty($_REQUEST['labels']) && $_REQUEST['labels']== 'all');

         if (!isset($_REQUEST['MB'])) {
            global $app_list_strings;
            $moduleNames = array_change_key_case($app_list_strings['moduleList']);
            $translatedEditModule = $moduleNames[strtolower($editModule)];
        }
        $selected_lang = null;

        if (!empty($_REQUEST['selected_lang'])) {
            $selected_lang = $_REQUEST['selected_lang'];
        } else {
            $selected_lang = $locale->getAuthenticatedUserLanguage();
        }

        $smarty = new Sugar_Smarty();
        global $mod_strings;
        $smarty->assign('mod_strings', $mod_strings);
        $smarty->assign('available_languages',get_languages());

        $objectName = BeanFactory::getObjectName($editModule);
        VardefManager::loadVardef($editModule, $objectName);
        global $dictionary;
        $vnames = array();
        //jchi 24557 . We should list all the lables in viewdefs(list,detail,edit,quickcreate) that the user can edit them.
        $parser = ParserFactory::getParser(MB_LISTVIEW, $editModule);
        foreach ($parser->getLayout() as $key => $def) {
            if(isset($def['label'])) {
               $vnames[$def['label']] = $def['label'];
            }
        }

        require_once 'modules/ModuleBuilder/parsers/views/GridLayoutMetaDataParser.php';
        $variableMap = $this->getVariableMap($editModule);
        foreach ($variableMap as $key => $value) {
            $gridLayoutMetaDataParserTemp = ParserFactory::getParser($key, $editModule);
            foreach ($gridLayoutMetaDataParserTemp->getLayout() as $panel) {
                foreach ($panel as $row) {
                    foreach ($row as $fieldArray) { // fieldArray is an array('name'=>name,'label'=>label)
                        if (isset($fieldArray['label'])) {
                            $vnames[$fieldArray['label']] = $fieldArray['label'];
                        }
                    }
                }
            }
        }
        //end

        //Get Subpanel Labels:
        require_once ('include/SubPanel/SubPanel.php');
        $subList =  SubPanel::getModuleSubpanels ( $editModule );
        foreach ($subList as $subpanel => $titleLabel) {
            $vnames[$titleLabel] = $titleLabel;
        }

        foreach ($dictionary[$objectName]['fields'] as $name=>$def) {
            if (isset($def['vname'])) {
               $vnames[$def['vname']] = $def['vname'];
            }
        }
        $formatted_mod_strings = array();

         // we shouldn't set the $refresh=true here, or will lost template language
         // mod_strings. 
         // return_module_language($selected_lang, $editModule,false) : 
         // the mod_strings will be included from cache files here.
        foreach (return_module_language($selected_lang, $editModule,false) as $name=>$label) {
            //#25294
            if($allLabels || isset($vnames[$name]) || preg_match( '/lbl_city|lbl_country|lbl_billing_address|lbl_alt_address|lbl_shipping_address|lbl_postal_code|lbl_state$/si' , $name)) {
                // Bug 58174 - Escaped labels are sent to the client escaped
                // even in the label editor in studio
                $formatted_mod_strings[$name] = html_entity_decode($label);
            }
        }
        //Grab everything from the custom files
        $mod_bak = $mod_strings;
        $files = array(
            "custom/modules/$editModule/language/$selected_lang.lang.php",
            "custom/modules/$editModule/Ext/Language/$selected_lang.lang.ext.php"
        );
        foreach ($files as $langfile) {
            $mod_strings = array();
            if (is_file($langfile)) {
               include($langfile);
               foreach ($mod_strings as $key => $label) {
                   // Bug 58174 - Escaped labels are sent to the client escaped
                   // even in the label editor in studio
                   $formatted_mod_strings[$key] = html_entity_decode($label);
               }
            }
        }
        $mod_strings = $mod_bak;
        ksort($formatted_mod_strings);
        $smarty->assign('MOD', $formatted_mod_strings);
        $smarty->assign('view_module', $editModule);
        $smarty->assign('APP', $GLOBALS['app_strings']);
        $smarty->assign('selected_lang', $selected_lang);
        $smarty->assign('defaultHelp', 'labelsBtn');
        $smarty->assign('assistant', array('key'=>'labels', 'group'=>'module'));
        $smarty->assign('labels_choice', $mod_strings['labelTypes']);
        $smarty->assign('labels_current', $allLabels?"all":"");

        $ajax = new AjaxCompose();
        $ajax->addCrumb($mod_strings['LBL_STUDIO'], 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard")');
        $ajax->addCrumb($translatedEditModule, 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&view_module='.$editModule.'")');
        $ajax->addCrumb($mod_strings['LBL_LABELS'], '');

        $html = $smarty->fetch('modules/ModuleBuilder/tpls/labels.tpl');
        $ajax->addSection('center', $GLOBALS['mod_strings']['LBL_SECTION_EDLABELS'], $html);
        echo $ajax->getJavascript();
     }

    // fixing bug #39749: Quick Create in Studio
    public function getVariableMap($module)
    {
        if (isModuleBWC($module)) {
            $variableMap = array(
                MB_EDITVIEW => 'EditView',
                MB_DETAILVIEW => 'DetailView',
                MB_QUICKCREATE => 'QuickCreate',
            );
            
            $hideQuickCreateForModules = array(
                'KBDocuments',
                'Campaigns',
                'Quotes',
                'ProductTemplates',
            );

            if (in_array($module, $hideQuickCreateForModules)) {
                if (isset($variableMap['quickcreate'])) {
                    unset($variableMap['quickcreate']);
                }
            }

            if ($module == 'KBDocuments') {
                $variableMap  = array();
            }
        } else {
            $variableMap = array(
                MB_RECORDVIEW => 'record',
            );
        }

        return $variableMap;
    }
}
