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
class ConfiguratorViewAddFontResult extends SugarView {
   var $log="";
    /**
     * display the form
     */
    public function display(){
        global $mod_strings, $app_list_strings, $app_strings, $current_user;
        if(!is_admin($current_user)){
           sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $error = $this->addFont();

        $this->ss->assign("MODULE_TITLE",
            getClassicModuleTitle(
                $mod_strings['LBL_MODULE_ID'],
                array($mod_strings['LBL_ADDFONTRESULT_TITLE']),
                false
                )
            );
        if($error){
            $this->ss->assign("error", $this->log);
        }else{
            $this->ss->assign("info", $this->log);
        }
        $this->ss->assign("MOD", $mod_strings);
        $this->ss->assign("APP", $app_strings);
//display
        $this->ss->display('modules/Configurator/tpls/addFontResult.tpl');
    }

    /**
     * This method prepares the received data and call the addFont method of the fontManager
     * @return boolean true on success
     */
    private function addFont(){
        $this->log="";
        $error=false;
        $files = array("pdf_metric_file","pdf_font_file");
        foreach($files as $k){
            // handle uploaded file
            $uploadFile = new UploadFile($k);
            if (isset($_FILES[$k]) && $uploadFile->confirm_upload()){
                $uploadFile->final_move(basename($_FILES[$k]['name']));
                $uploadFileNames[$k] = $uploadFile->get_upload_path(basename($_FILES[$k]['name']));
            }else{
                $this->log = translate('ERR_PDF_NO_UPLOAD', "Configurator");
                $error=true;
            }
        }
        if(!$error){
            require_once('include/Sugarpdf/FontManager.php');
            $fontManager = new FontManager();
            $error = $fontManager->addFont($uploadFileNames["pdf_font_file"],$uploadFileNames["pdf_metric_file"], $_REQUEST['pdf_embedded'], $_REQUEST['pdf_encoding_table'], eval($_REQUEST['pdf_patch']), htmlspecialchars_decode($_REQUEST['pdf_cidinfo'],ENT_QUOTES), $_REQUEST['pdf_style_list']);
            $this->log .= $fontManager->log;
            if($error){
                $this->log .= implode("\n",$fontManager->errors);
            }
        }
        return $error;
    }
}
