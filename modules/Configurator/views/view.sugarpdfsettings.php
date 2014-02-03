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


class ConfiguratorViewSugarpdfsettings extends SugarView
{

    /**
     * @see SugarView::_getModuleTab()
     */
    protected function _getModuleTab()
    {
        return 'PdfManager';
    }

    /**
	 * @see SugarView::preDisplay()
	 */
	public function preDisplay()
    {
        if(!is_admin($GLOBALS['current_user']))
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
    }

    /**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;

    	return array(
    	   "<a href='index.php?module=PdfManager&action=index'>".translate('LBL_MODULE_NAME','PdfManager')."</a>",
    	   $mod_strings['LBL_PDFMODULE_NAME']
    	   );
    }

	/**
	 * @see SugarView::display()
	 */
	public function display()
	{
	    global $mod_strings, $app_strings, $app_list_strings;

	    foreach(SugarAutoLoader::existingCustom("modules/Configurator/metadata/SugarpdfSettingsdefs.php") as $file) {
	        include $file;
	    }

        if(!empty($_POST['save'])){
            // Save the logos
            $error=$this->checkUploadImage();
            if(empty($error)){
                $focus = BeanFactory::getBean('Administration');
                foreach($SugarpdfSettings as $k=>$v){
                    if($v['type'] == 'password'){
                        if(isset($_POST[$k])){
                            $_POST[$k] = blowfishEncode(blowfishGetKey($k), $_POST[$k]);
                        }
                    }
                }
                if(!empty($_POST["sugarpdf_pdf_class"]) && $_POST["sugarpdf_pdf_class"] != PDF_CLASS){
                    // clear the cache for quotes detailview in order to switch the pdf class.
                    if(is_file($cachedfile = sugar_cached('modules/Quotes/DetailView.tpl'))) {
                        unlink($cachedfile);
                    }
                }
                $focus->saveConfig();
                header('Location: index.php?module=PdfManager&action=index');
            }
        }

        if(!empty($_POST['restore'])){
            $focus = BeanFactory::getBean('Administration');
            foreach($_POST as $key => $val) {
                $prefix = $focus->get_config_prefix($key);
                if(in_array($prefix[0], $focus->config_categories)) {
                    $result = $focus->db->query("SELECT count(*) AS the_count FROM config WHERE category = '{$prefix[0]}' AND name = '{$prefix[1]}'");
                    $row = $focus->db->fetchByAssoc($result);
                    if( $row['the_count'] != 0){
                        $focus->db->query("DELETE FROM config WHERE category = '{$prefix[0]}' AND name = '{$prefix[1]}'");
                    }
                }
            }
            header('Location: index.php?module=Configurator&action=SugarpdfSettings');
        }

        echo getClassicModuleTitle(
                "Administration",
                array(
                    "<a href='index.php?module=PdfManager&action=index'>".translate('LBL_MODULE_NAME','PdfManager')."</a>",
                   $mod_strings['LBL_PDFMODULE_NAME'],
                   ),
                false
                );

        $pdf_class = array("TCPDF"=>"TCPDF","EZPDF"=>"EZPDF");

        $this->ss->assign('APP_LIST', $app_list_strings);
        $this->ss->assign("JAVASCRIPT",get_set_focus_js());
        $this->ss->assign("SugarpdfSettings", $SugarpdfSettings);
        $this->ss->assign("pdf_enable_ezpdf", PDF_ENABLE_EZPDF);
        if(PDF_ENABLE_EZPDF == "0" && PDF_CLASS == "EZPDF"){
            $error = "ERR_EZPDF_DISABLE";
            $this->ss->assign("selected_pdf_class", "TCPDF");
        }else{
            $this->ss->assign("selected_pdf_class", PDF_CLASS);
        }
        $this->ss->assign("pdf_class", $pdf_class);

        if(!empty($error)){
            $this->ss->assign("error", $mod_strings[$error]);
        }
        if (!function_exists('imagecreatefrompng')) {
            $this->ss->assign("GD_WARNING", 1);
        }
        else
            $this->ss->assign("GD_WARNING", 0);

        $this->ss->display('modules/Configurator/tpls/SugarpdfSettings.tpl');

        require_once("include/javascript/javascript.php");
        $javascript = new javascript();
        $javascript->setFormName("ConfigureSugarpdfSettings");
        foreach($SugarpdfSettings as $k=>$v){
            if(isset($v["required"]) && $v["required"] == true)
                $javascript->addFieldGeneric($k, "varchar", $v['label'], TRUE, "");
        }

        echo $javascript->getScript();
    }

    private function checkUploadImage()
    {
        $error="";
        $files = array('sugarpdf_pdf_small_header_logo'=>$_FILES['new_small_header_logo']);
        foreach($files as $k=>$v){
            if(empty($error) && isset($v) && !empty($v['name'])){
                $file_name = K_PATH_CUSTOM_IMAGES .'pdf_logo_'. basename($v['name']);
                if(file_exists($file_name))
                    rmdir_recursive($file_name);
                if (!empty($v['error']))
                    $error='ERR_ALERT_FILE_UPLOAD';
                if(!mkdir_recursive(K_PATH_CUSTOM_IMAGES))
                   $error='ERR_ALERT_FILE_UPLOAD';
                if(empty($error)){
                    if (!move_uploaded_file($v['tmp_name'], $file_name))
                        die("Possible file upload attack!\n");
                    if(file_exists($file_name) && is_file($file_name)){
                        if(!empty($_REQUEST['sugarpdf_pdf_class']) && $_REQUEST['sugarpdf_pdf_class'] == "EZPDF") {
                            if(!verify_uploaded_image($file_name, true)) {
                                $error='LBL_ALERT_TYPE_IMAGE_EZPDF';
                            }
                        } else {
                            if(!verify_uploaded_image($file_name)) {
                                $error='LBL_ALERT_TYPE_IMAGE';
                            }
                        }
                        if(!empty($error)){
                            rmdir_recursive($file_name);
                        }else{
                            $_POST[$k]='pdf_logo_'. basename($v['name']);
                        }
                    }else{
                        $error='ERR_ALERT_FILE_UPLOAD';
                    }
                }
            }
        }
        return $error;
    }
}
