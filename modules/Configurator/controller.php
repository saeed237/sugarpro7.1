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


require_once('include/MVC/Controller/SugarController.php');
class ConfiguratorController extends SugarController
{
    /**
     * Go to the font manager view
     */
    function action_FontManager(){
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']); 
        }
        $this->view = 'fontmanager';
    }

    /**
     * Delete a font and go back to the font manager
     */
    function action_deleteFont(){
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $urlSTR = 'index.php?module=Configurator&action=FontManager';
        if(!empty($_REQUEST['filename'])){
            require_once('include/Sugarpdf/FontManager.php');
            $fontManager = new FontManager();
            $fontManager->filename = $_REQUEST['filename'];
            if(!$fontManager->deleteFont()){
                $urlSTR .='&error='.urlencode(implode("<br>",$fontManager->errors));
            }
        }
        header("Location: $urlSTR");
    }

    function action_listview(){
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']); 
        }
        $this->view = 'edit';
    }
    /**
     * Show the addFont view
     */
    function action_addFontView(){
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']); 
        }
        $this->view = 'addFontView';
    }
    /**
     * Add a new font and show the addFontResult view
     */
    function action_addFont(){
        global $current_user, $mod_strings;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        if(empty($_FILES['pdf_metric_file']['name'])){
            $this->errors[]=translate("ERR_MISSING_REQUIRED_FIELDS")." ".translate("LBL_PDF_METRIC_FILE", "Configurator");
            $this->view = 'addFontView';
            return;
        }
        if(empty($_FILES['pdf_font_file']['name'])){
            $this->errors[]=translate("ERR_MISSING_REQUIRED_FIELDS")." ".translate("LBL_PDF_FONT_FILE", "Configurator");
            $this->view = 'addFontView';
            return;
        }
        $path_info = pathinfo($_FILES['pdf_font_file']['name']);
        $path_info_metric = pathinfo($_FILES['pdf_metric_file']['name']);
        if(($path_info_metric['extension']!="afm" && $path_info_metric['extension']!="ufm") ||
        ($path_info['extension']!="ttf" && $path_info['extension']!="otf" && $path_info['extension']!="pfb")){
            $this->errors[]=translate("JS_ALERT_PDF_WRONG_EXTENSION", "Configurator");
            $this->view = 'addFontView';
            return;
        }

        if($_REQUEST['pdf_embedded'] == "false"){
            if(empty($_REQUEST['pdf_cidinfo'])){
                $this->errors[]=translate("ERR_MISSING_CIDINFO", "Configurator");
                $this->view = 'addFontView';
                return;
            }
            $_REQUEST['pdf_embedded']=false;
        }else{
            $_REQUEST['pdf_embedded']=true;
            $_REQUEST['pdf_cidinfo']="";
        }
        if(empty($_REQUEST['pdf_patch'])){
            $_REQUEST['pdf_patch']="return array();";
        }else{
            $_REQUEST['pdf_patch']="return {$_REQUEST['pdf_patch']};";
        }
        $this->view = 'addFontResult';
    }
    function action_saveadminwizard()
    {
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']); 
        }
        $focus = Administration::getSettings();
        $focus->saveConfig();

        $configurator = new Configurator();
        $configurator->populateFromPost();
        $configurator->handleOverride();
        $configurator->parseLoggerSettings();
        $configurator->saveConfig();

        // Bug 37310 - Delete any existing currency that matches the one we've just set the default to during the admin wizard
        $currency = BeanFactory::getBean('Currencies');
        $currency->retrieve_id_by_name($_REQUEST['default_currency_name']);
        if ( !empty($currency->id)
                && $currency->symbol == $_REQUEST['default_currency_symbol']
                && $currency->iso4217 == $_REQUEST['default_currency_iso4217'] ) {
            $currency->deleted = 1;
            $currency->save();
        }

        SugarApplication::redirect('index.php?module=Users&action=Wizard&skipwelcome=1');
    }

    function action_saveconfig()
    {
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']); 
        }
        $configurator = new Configurator();
        $configurator->saveConfig();

        $focus = BeanFactory::getBean('Administration');
        $focus->saveConfig();

        // Clear the Contacts file b/c portal flag affects rendering
        if (file_exists($cachedfile = sugar_cached('modules/Contacts/EditView.tpl')))
           unlink($cachedfile);

        SugarApplication::redirect('index.php?module=Administration&action=index');
    }

    function action_detail()
    {
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']); 
        }
        $this->view = 'edit';
    }
}