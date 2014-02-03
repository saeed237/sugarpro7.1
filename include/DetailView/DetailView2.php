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

require_once('include/TemplateHandler/TemplateHandler.php');
require_once('include/EditView/EditView2.php');

/**
 * DetailView - display single record
 * New implementation
 * @api
 */
class DetailView2 extends EditView
{
    var $view = 'DetailView';

    /**
     * DetailView constructor
     * This is the DetailView constructor responsible for processing the new
     * Meta-Data framework
     *
     * @param $module String value of module this detail view is for
     * @param $focus An empty sugarbean object of module
     * @param $id The record id to retrieve and populate data for
     * @param $metadataFile String value of file location to use in overriding default metadata file
     * @param tpl String value of file location to use in overriding default Smarty template
     */
    function setup(
        $module,
        $focus,
        $metadataFile = null,
        $tpl = 'include/DetailView/DetailView.tpl'
        )
    {
        $this->th = new TemplateHandler();
        $this->th->ss = $this->ss;
        $this->focus = $focus;
        $this->tpl = $tpl;
        $this->module = $module;
        $this->metadataFile = $metadataFile;
        if(isset($GLOBALS['sugar_config']['disable_vcr'])) {
           $this->showVCRControl = !$GLOBALS['sugar_config']['disable_vcr'];
        }

        if(!empty($this->metadataFile) && SugarAutoLoader::fileExists($this->metadataFile)){
        	include($this->metadataFile);
        }

        $this->defs = $viewdefs[$this->module][$this->view];
    }

}
?>
