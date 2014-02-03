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
require_once('include/Sugarpdf/FontManager.php');
class ConfiguratorViewAddFontView extends SugarView {
   
    /**
     * Constructor
     */
    public function AddFontView(){
        parent::SugarView();
    }
    /** 
     * display the form
     */
    public function display(){
        global $mod_strings, $app_list_strings, $app_strings, $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);  
        }
        $this->ss->assign("MODULE_TITLE", 
            getClassicModuleTitle(
                $mod_strings['LBL_MODULE_ID'], 
                array($mod_strings['LBL_ADDFONT_TITLE']), 
                true
                )
            );
        if(!empty($_REQUEST['error'])){
            $this->ss->assign("error", $_REQUEST['error']);
        }
        $this->ss->assign("MOD", $mod_strings);
        $this->ss->assign("APP", $app_strings);
        if(isset($_REQUEST['return_action'])){
            $this->ss->assign("RETURN_ACTION", $_REQUEST['return_action']);
        }else{
            $this->ss->assign("RETURN_ACTION", 'FontManager');
        }
        $this->ss->assign("STYLE_LIST", array(
                "regular"=>$mod_strings["LBL_FONT_REGULAR"],
                "italic"=>$mod_strings["LBL_FONT_ITALIC"],
                "bold"=>$mod_strings["LBL_FONT_BOLD"],
                "boldItalic"=>$mod_strings["LBL_FONT_BOLDITALIC"]
         ));
         $this->ss->assign("ENCODING_TABLE", array_combine(explode(",",PDF_ENCODING_TABLE_LIST), explode(",",PDF_ENCODING_TABLE_LABEL_LIST)));
        
//display
        $this->ss->display('modules/Configurator/tpls/addFontView.tpl');
    }
}
    