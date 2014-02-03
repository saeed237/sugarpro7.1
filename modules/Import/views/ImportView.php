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


class ImportView extends SugarView
{
    protected $currentStep;
    protected $pageTitleKey;
    protected $instruction;

    public function __construct($bean = null, $view_object_map = array())
    {
        global $mod_strings;

        parent::__construct($bean, $view_object_map);

        if (isset($_REQUEST['button']) && trim($_REQUEST['button']) == htmlentities($mod_strings['LBL_BACK'])) {
            // if the request comes from the "Back" button, decrease the step count
            $this->currentStep = isset($_REQUEST['current_step']) ? ($_REQUEST['current_step'] - 1) : 1;
        } else {
            $this->currentStep = isset($_REQUEST['current_step']) ? ($_REQUEST['current_step'] + 1) : 1;
        }
        $this->importModule = isset($_REQUEST['import_module']) ? $_REQUEST['import_module'] : '';
        
    }

    /**
     * @see SugarView::getMenu()
     */
    public function getMenu($module = null)
    {
        global $mod_strings, $current_language;

        if ( empty($module) )
            $module = $this->importModule;

        $old_mod_strings = $mod_strings;
        $mod_strings = return_module_language($current_language, $module);
        $returnMenu = parent::getMenu($module);
        $mod_strings = $old_mod_strings;

        return $returnMenu;
    }

 	/**
     * @see SugarView::_getModuleTab()
     */
 	protected function _getModuleTab()
    {
        global $app_list_strings, $moduleTabMap;

 		// Need to figure out what tab this module belongs to, most modules have their own tabs, but there are exceptions.
        if ( !empty($_REQUEST['module_tab']) )
            return $_REQUEST['module_tab'];
        elseif ( isset($moduleTabMap[$this->importModule]) )
            return $moduleTabMap[$this->importModule];
        // Default anonymous pages to be under Home
        elseif ( !isset($app_list_strings['moduleList'][$this->importModule]) )
            return 'Home';
        else
            return $this->importModule;
 	}

    /**
     * Send our output to the importer controller.
     * 
     * @param string $html
     * @param string $submitContent
     * @param string $script
     * @param bool $encode
     * @return void
     */
    protected function sendJsonOutput($html = "", $submitContent = "", $script = "", $encode = FALSE)
    {
        $title = $this->getModuleTitle(false);
        $out = array(
            'html'          => $html,
            'submitContent' => $submitContent,
            'title'         => $title,
            'script'        => $script);

        if($encode){
            array_walk($out, create_function('&$val', '$val = htmlspecialchars($val,ENT_NOQUOTES);'));
        }
        echo json_encode($out);
    }

    /**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings, $app_list_strings;
	    $returnArray = array(string_format($mod_strings[$this->pageTitleKey], array($this->currentStep)));

	    return $returnArray;
    }

    protected function getInstruction()
    {
        global $mod_strings;

        $ins = '';
        
        if ($this->instruction) {
            $ins_string = $mod_strings[$this->instruction];
            $ins = '<div class="import_instruction">' . $ins_string . '</div>';
        }

        return $ins;
    }

     /**
     * Displays the Smarty template for an error
     *
     * @param string $message error message to show
     * @param string $module what module we were importing into
     * @param string $action what page we should go back to
     */
    protected function _showImportError($message,$module,$action = 'Step1')
    {
        $ss = new Sugar_Smarty();

        $ss->assign("MESSAGE",$message);
        $ss->assign("ACTION",$action);
        $ss->assign("IMPORT_MODULE",$module);
        $ss->assign("MOD", $GLOBALS['mod_strings']);
        $ss->assign("SOURCE","");
        if ( isset($_REQUEST['source']) )
            $ss->assign("SOURCE", $_REQUEST['source']);

        echo $ss->fetch('modules/Import/tpls/error.tpl');
    }
}