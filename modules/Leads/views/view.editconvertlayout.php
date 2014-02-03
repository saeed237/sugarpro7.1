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
require_once("modules/Leads/ConvertLayoutMetadataParser.php");
require_once ('modules/ModuleBuilder/MB/AjaxCompose.php') ;

class ViewEditConvertLayout extends SugarView {

	protected $_viewdefs = array();

	function __construct ()
    {
	    parent::SugarView();
        global $current_user;
        if(!$current_user->isAdmin() && !$current_user->isDeveloperForModule("Leads"))
        {
            die("Unauthorized Acccess to Administration");
        }

        $GLOBALS [ 'log' ]->debug ( 'in ViewLayoutView' ) ;
        $this->editModule = $_REQUEST [ 'view_module' ] ;
        $this->editLayout = "ConvertLead" ;
        $this->package = null;
        $this->fromModuleBuilder = isset ( $_REQUEST [ 'MB' ] ) || !empty($_REQUEST [ 'view_package' ]);
        if ($this->fromModuleBuilder)
        {
            $this->package = $_REQUEST [ 'view_package' ] ;
        } else
        {
            global $app_list_strings ;
            $moduleNames = array_change_key_case ( $app_list_strings [ 'moduleList' ] ) ;
            $this->translatedEditModule = $moduleNames [ strtolower ( $this->editModule ) ] ;
        }
    }

    function display(){
        global $mod_strings ;
        $parser = new ConvertLayoutMetadataParser($this->editModule);
        $history = $parser->getHistory () ;
        $preview = false;
        $smarty = new Sugar_Smarty ( ) ;
        //Add in the module we are viewing to our current mod strings
        if (! $this->fromModuleBuilder) {
            global $current_language;
            $editModStrings = return_module_language($current_language, $this->editModule);
            $mod_strings = sugarLangArrayMerge($editModStrings, $mod_strings);
        }
        $smarty->assign('mod', $mod_strings);
        $smarty->assign('MOD', $mod_strings);

        $this->assignButtons($smarty, $preview, $history);

        $viewdef = $parser->getDefForModule($this->editModule);
        $smarty->assign('relationships', $this->getRelationshipsForModule($this->editModule,
            isset($viewdef['select'])   ? $viewdef['select']   : ""));
        $smarty->assign('required', isset($viewdef['required']) ? $viewdef['required'] : false);
        $smarty->assign('copyData', isset($viewdef['copyData']) ? $viewdef['copyData'] : false);
        $smarty->assign('select',   isset($viewdef['select'])   ? $viewdef['select']   : false);

        // assign fields and layout
        $smarty->assign ( 'available_fields', $parser->getAvailableFields () ) ;
        $smarty->assign ('calc_field_list', json_encode($parser->getCalculatedFields()));
        $smarty->assign ( 'layout', $parser->getLayout () ) ;
        $smarty->assign ( 'view_module', $this->editModule ) ;
        $smarty->assign ( 'view', $this->editLayout ) ;
        $smarty->assign ( 'maxColumns', $parser->getMaxColumns() ) ;
        $smarty->assign ( 'nextPanelId', $parser->getFirstNewPanelId() ) ;
        $smarty->assign ( 'fieldwidth', 150 ) ;
        $smarty->assign ( 'translate', true ) ;

        if ($this->fromModuleBuilder)
        {
            $smarty->assign ( 'fromModuleBuilder', $this->fromModuleBuilder ) ;
            $smarty->assign ( 'view_package', $this->package ) ;
        }

                // set up language files
        $smarty->assign ( 'language', $parser->getLanguage() ) ; // for sugar_translate in the smarty template
        $smarty->assign('from_mb', false);
		$smarty->assign('disable_tabs', true);
        $smarty->assign('single_panel', true);

        // Bug 38245 - Warn users if they were using the old lead convert screen and are looking to modify the new one
        if ( ( SugarAutoLoader::existingCustom('modules/Leads/ConvertLead.php') )
                && !SugarAutoLoader::existing('custom/modules/Leads/metadata/convertdefs.php') ) {
            $smarty->assign ( 'warningMessage', translate ('LBL_NOTICE_OLD_LEAD_CONVERT_OVERRIDE','Leads') ) ;
        }

        echo $smarty->fetch ( 'modules/Leads/tpls/EditConvertLeadTop.tpl' );
        echo $smarty->fetch ( 'modules/ModuleBuilder/tpls/layoutView.tpl' );
    }

    protected function getRelationshipsForModule($module, $currentRel = "")
    {
        $ret = array();
        $seed = BeanFactory::getBean('Contacts');
        $bean_rels = $seed->get_related_fields();
        foreach($bean_rels as $field => $fDef)
        {
            if (!empty($fDef['link']) && !empty($fDef['module']) && $fDef['module'] == $module)
            {
                $rel = array('name' => $fDef['name'], 'label' => $fDef['name']);
                $rel['selected'] = $fDef['name'] == $currentRel;
            	$ret[] = $rel;
            }
        }
        if(sizeOf($ret) == 1)
            $ret[0]['label'] = "Yes";
        return $ret;
    }

    protected function assignButtons($smarty, $preview, $history)
    {
    	// assign buttons
        $images = array ( 'icon_save' => 'studio_save' , 'icon_publish' => 'studio_publish' , 'icon_address' => 'icon_Address' , 'icon_emailaddress' => 'icon_EmailAddress' , 'icon_phone' => 'icon_Phone' ) ;
        foreach ( $images as $image => $file )
        {
            $smarty->assign ( $image, SugarThemeRegistry::current()->getImage($file,'',null,null,'.gif',$file) ) ;
        }

        $buttons = array ( ) ;

        if ($preview)
        {
            $smarty->assign ( 'layouttitle', translate ( 'LBL_LAYOUT_PREVIEW', 'ModuleBuilder' ) ) ;
        } else
        {
            $smarty->assign ( 'layouttitle', translate ( 'LBL_CURRENT_LAYOUT', 'ModuleBuilder' ) ) ;
            $buttons [] = array ( 'id' => 'saveBtn' , 'text' => translate ( 'LBL_BTN_SAVE', 'ModuleBuilder' ) , 'actionScript' => "onclick='if (Studio2.countGridFields()==0) ModuleBuilder.layoutValidation.popup() ; else Studio2.handleSave();'" ) ;
            $buttons [] = array ( 'id' => 'publishBtn' , 'text' => translate ( 'LBL_BTN_SAVEPUBLISH', 'ModuleBuilder' ) , 'actionScript' => "onclick='if (Studio2.countGridFields()==0) ModuleBuilder.layoutValidation.popup() ; else Studio2.handlePublish();'" ) ;
            $buttons [] = array ( 'id' => 'spacer' , 'width' => '50px' ) ;
            //$buttons [] = array ( 'id' => 'historyBtn' , 'text' => translate ( 'LBL_HISTORY', 'ModuleBuilder' ) , 'actionScript' => "onclick='ModuleBuilder.history.browse(\"{$this->editModule}\", \"{$this->editLayout}\")'") ;
            //$buttons [] = array ( 'id' => 'historyDefault' , 'text' => translate ( 'LBL_RESTORE_DEFAULT', 'ModuleBuilder' ) , 'actionScript' => "onclick='ModuleBuilder.history.revert(\"{$this->editModule}\", \"{$this->editLayout}\", \"{$history->getLast()}\", \"\")'" ) ;
        }

        $html = "" ;
        foreach ( $buttons as $button )
        {
            if ($button['id'] == "spacer") {
                $html .= "<td style='width:{$button['width']}'> </td>";
            } else {
                $html .= "<td><input id='{$button['id']}' type='button' valign='center' class='button' style='cursor:pointer' "
                   . "onmousedown='this.className=\"buttonOn\";return false;' onmouseup='this.className=\"button\"' "
                   . "onmouseout='this.className=\"button\"' {$button['actionScript']} value = '{$button['text']}' ></td>" ;
            }
        }

        $smarty->assign ( 'buttons', $html ) ;
    }
}
