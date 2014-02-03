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


require_once('include/Sugarpdf/Sugarpdf.php');

/**
 * This is an helper class to generate PDF using smarty template.
 * You have to extend this class, set the templateLocation to your smarty template
 * location and assign the Smarty variables ($this->ss->assign()) in the overriden
 * preDisplay method (don't forget to call the parent).
 * 
 * @author bsoufflet
 *
 */
class SugarpdfSmarty extends Sugarpdf{
    
    /**
     * 
     * @var String
     */
    protected $templateLocation = "";
    /**
     * The Sugar_Smarty object
     * @var Sugar_Smarty
     */
    protected $ss;
    /**
     * These 5 variables are use for the writeHTML method.
     * @see vendor/tcpdf/tcpdf.php writeHTML()
     */
    protected $smartyLn = true;
    protected $smartyFill = false;
    protected $smartyReseth = false;
    protected $smartyCell = false;
    protected $smartyAlign = "";
    
    function preDisplay(){
        parent::preDisplay();
        $this->print_header = false;
        $this->print_footer = false;
        $this->_initSmartyInstance();
    }
    
    function display(){
        //turn off all error reporting so that PHP warnings don't munge the PDF code
        error_reporting(E_ALL);
        set_time_limit(1800);
        
        //Create new page           
        $this->AddPage();
        $this->SetFont(PDF_FONT_NAME_MAIN,'',8);
        
        if(!empty($this->templateLocation)){
            $str = $this->ss->fetch($this->templateLocation);
            $this->writeHTML($str, $this->smartyLn, $this->smartyFill, $this->smartyReseth, $this->smartyCell, $this->smartyAlign);
        }else{
            $this->Error('The class SugarpdfSmarty has to be extended and you have to set a location for the Smarty template.');
        }
    }
    
    /**
     * Init the Sugar_Smarty object.
     */
    private function _initSmartyInstance(){
        if ( !($this->ss instanceof Sugar_Smarty) ) {
            $this->ss = new Sugar_Smarty();
            // TODO: Remove after MAR-1064 is merged.
            // Enable enhanced security for user-provided templates. This
            // includes disabling the {php} Smarty tag.
            $this->ss->security = true;
            $this->ss->assign('MOD', $GLOBALS['mod_strings']);
            $this->ss->assign('APP', $GLOBALS['app_strings']);
        }
    }
    
}