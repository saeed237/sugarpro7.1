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

require_once('include/EditView/EditView2.php');
/**
 * Quick create form in the subpanel
 * @api
 */
class SubpanelQuickCreate{
    public $defaultProcess = true;

    /**
     * The view type to use
     *
     * @var string
     */
    public $viewType = 'QuickCreate';

    public function SubpanelQuickCreate($module, $view='QuickCreate', $proccessOverride = false)
    {
        $this->viewType = $view;

        //treat quickedit and quickcreate views as the same
        if($this->viewType == 'QuickEdit') {
            $this->viewType = 'QuickCreate';
        }

		// locate the best viewdefs to use: 1. custom/module/quickcreatedefs.php 2. module/quickcreatedefs.php 3. editviewdefs as in metafile
		$source = SugarAutoLoader::existingCustomOne("modules/{$module}/metadata/quickcreatedefs.php");
		if(!$source) {
            $source = SugarAutoLoader::loadWithMetafiles($module, "editviewdefs");
            $this->viewType = 'EditView';
        }
        $this->ev = $this->getEditView();
		$this->ev->view = $this->viewType;
		$this->ev->ss = new Sugar_Smarty();

		$bean = BeanFactory::getBean($module);
        if($bean && !empty($_REQUEST['record'])) {
            $bean->retrieve($_REQUEST['record']);
        }
		$this->ev->setup($module, $bean, $source);
		unset($bean);


		// Bug 49219 - Check empty before set defaults, or the settings from viewdefs above will be overridden.
        if (!isset($this->ev->defs['templateMeta']['form']['headerTpl']))
        {
            $this->ev->defs['templateMeta']['form']['headerTpl'] = 'include/EditView/header.tpl';
        }

		if (!isset($this->ev->defs['templateMeta']['form']['footerTpl']))
        {
            $this->ev->defs['templateMeta']['form']['footerTpl'] = 'include/EditView/footer.tpl';
        }
		// Comment below, breaks many out of the box viewdefs
		/*if (empty($this->ev->defs['templateMeta']['form']['buttons'])) $this->ev->defs['templateMeta']['form']['buttons'] = array('SUBPANELSAVE', 'SUBPANELCANCEL', 'SUBPANELFULLFORM');*/
		$this->ev->defs['templateMeta']['form']['buttons'] = array('SUBPANELSAVE', 'SUBPANELCANCEL', 'SUBPANELFULLFORM');

        //Load the parent view class if it exists.  Check for custom file first
        loadParentView('edit');

		$viewEditSource = SugarAutoLoader::existingCustomOne('modules/'.$module.'/views/view.edit.php');

		if(!empty($viewEditSource) && !$proccessOverride) {
            require_once $viewEditSource;
            $c = SugarAutoLoader::customClass($module . 'ViewEdit');

            if(class_exists($c)) {
	            $view = new $c;
	            if($view->useForSubpanel) {
	            	$this->defaultProcess = false;

	            	// Check if we should use the module's QuickCreate.tpl file.
	            	if($view->useModuleQuickCreateTemplate && SugarAutoLoader::fileExists('modules/'.$module.'/tpls/QuickCreate.tpl')) {
	            	   $this->ev->defs['templateMeta']['form']['headerTpl'] = 'modules/'.$module.'/tpls/QuickCreate.tpl';
	            	}

		            $view->ev = $this->ev;
		            $view->ss = $this->ev->ss;
		            $view->bean = BeanFactory::getBean($module);
					$this->ev->formName = 'form_Subpanel'.$this->ev->view .'_'.$module;
					$view->showTitle = false; // Do not show title since this is for subpanel
		            $view->display();
	            }
            }
		} //if

		if($this->defaultProcess && !$proccessOverride) {
		   $this->process($module);
		}
	}

	function process($module){
        if($_REQUEST['target_action'] == 'QuickCreate'){
            $this->ev->view = 'QuickCreate';
        }
        $form_name = 'form_Subpanel'.$this->ev->view .'_'.$module;
        $this->ev->formName = $form_name;
        $this->ev->process(true, $form_name);
		echo $this->ev->display(false, true);
	}

    /**
     * Get EditView object
     * @return EditView
     */
    protected function getEditView()
    {
        return new EditView();
    }


    /**
     * Finds and returns the best viewdefs to use:
     *  1. custom/module/quickcreatedefs.php
     *  2. module/quickcreatedefs.php
     *  3. custom/module/editviewdefs.php
     *  4. module/editviewdefs.php
     *
     * @param $module
     * @param $view
     * @return string The path to the viewdefs file to use
     */
    public function getModuleViewDefsSourceFile($module, $view)
    {
    	$source = SugarAutoLoader::existingCustomOne("modules/{$module}/metadata/".strtolower($view)."defs.php");
		if(!$source) {
            $source = SugarAutoLoader::loadWithMetafiles($module, "editviewdefs");
            $this->viewType = 'EditView';
        }

        return $source;
    }
}
