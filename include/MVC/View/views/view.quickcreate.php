<?php
//FILE SUGARCRM flav=pro
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


require_once('include/MVC/View/views/view.ajax.php');
require_once('include/EditView/EditView2.php');

class ViewQuickcreate extends ViewAjax
{
	protected $_isDCForm = false;

	/**
	 * @var EditView object
	 */
	protected $ev;

    /**
     * @var headerTpl String variable of the Smarty template file used to render the header portion
     */
    protected $headerTpl = 'include/EditView/header.tpl';

    /**
     * @var footerTpl String variable of the Smarty template file used to render the footer portion
     */
    protected $footerTpl = 'include/EditView/footer.tpl';


    /**
     * @var defaultButtons Array of default buttons assigned to the form (see function.sugar_button.php)
     */
    protected $defaultButtons = array('DCMENUSAVE', 'DCMENUCANCEL', 'DCMENUFULLFORM');

    /**
     * @see SugarView::preDisplay()
     */
    public function preDisplay()
    {
    	if(!empty($_REQUEST['source_module']) && $_REQUEST['source_module'] != 'undefined' && !empty($_REQUEST['record'])) {
			$this->bean = BeanFactory::getBean($_REQUEST['source_module']);
			if ( $this->bean instanceOf SugarBean
			        && !in_array($this->bean->object_name,array('EmailMan')) ) {
                $this->bean->retrieve($_REQUEST['record']);
                if(!empty($this->bean->id))$_REQUEST['parent_id'] = $this->bean->id;
                if(!empty($this->bean->module_dir))$_REQUEST['parent_type'] = $this->bean->module_dir;
                if(!empty($this->bean->name))$_REQUEST['parent_name'] = $this->bean->name;
                if(!empty($this->bean->id))$_REQUEST['return_id'] = $this->bean->id;
                if(!empty($this->bean->module_dir))$_REQUEST['return_module'] = $this->bean->module_dir;

                //Now preload any related fields
			    if(isset($_REQUEST['module'])) {
                	$target_bean = BeanFactory::getBean($_REQUEST['module']);
	                foreach($target_bean->field_defs as $fields) {
	                	if($fields['type'] == 'relate' && isset($fields['module']) && $fields['module'] == $_REQUEST['source_module'] && isset($fields['rname'])) {
	                	   $rel_name = $fields['rname'];
	                	   if(isset($this->bean->$rel_name)) {
	                	   	  $_REQUEST[$fields['name']] = $this->bean->$rel_name;
	                	   }
	                	 	if(!empty($_REQUEST['record']) && !empty($fields['id_name'])) {
	                	 		$_REQUEST[$fields['id_name']] = $_REQUEST['record'];
	                	   }
	                	}
	                }
                }
            }
            $this->_isDCForm = true;
    	}
    }

    /**
     * @see SugarView::display()
     */
    public function display()
    {
    	$view = (!empty($_REQUEST['target_view']))?$_REQUEST['target_view']: 'QuickCreate';
		$module = $_REQUEST['module'];

		// locate the best viewdefs to use: 1. custom/module/quickcreatedefs.php 2. module/quickcreatedefs.php 3. custom/module/editviewdefs.php 4. module/editviewdefs.php
		$base = 'modules/' . $module . '/metadata/';
		$source = SugarAutoLoader::existingCustomOne($base . strtolower($view) . 'defs.php');
		if(!$source) {
		    //if our view does not exist default to EditView
		    $view = 'EditView';
		    $source = SugarAutoLoader::existingCustomOne($base . 'editviewdefs.php');
		}

        $this->ev = $this->getEditView();
		$this->ev->view = $view;
		$this->ev->ss = new Sugar_Smarty();

		$this->ev->ss->assign('isDCForm', $this->_isDCForm);
		//$_REQUEST['return_action'] = 'SubPanelViewer';
		$this->ev->setup($module, null, $source);
		$this->ev->showSectionPanelsTitles = false;
	    $this->ev->defs['templateMeta']['form']['headerTpl'] = $this->headerTpl;
		$this->ev->defs['templateMeta']['form']['footerTpl'] = $this->footerTpl;
		$this->ev->defs['templateMeta']['form']['buttons'] = $this->defaultButtons;
		$this->ev->defs['templateMeta']['form']['button_location'] = 'bottom';
		$this->ev->defs['templateMeta']['form']['hidden'] = '<input type="hidden" name="is_ajax_call" value="1" />';
		$this->ev->defs['templateMeta']['form']['hidden'] .= '<input type="hidden" name="from_dcmenu" value="1" />';
		$defaultProcess = true;

        //Load the parent view class if it exists.  Check for custom file first
        loadParentView('edit');

		if(file_exists('modules/'.$module.'/views/view.edit.php')) {
            include('modules/'.$module.'/views/view.edit.php');

            $c = $module . 'ViewEdit';

            if(class_exists($c)) {
	            $view = new $c;
	            if($view->useForSubpanel) {
	            	$defaultProcess = false;

	            	//Check if we shold use the module's QuickCreate.tpl file
	            	if($view->useModuleQuickCreateTemplate && file_exists('modules/'.$module.'/tpls/QuickCreate.tpl')) {
	            	   $this->ev->defs['templateMeta']['form']['headerTpl'] = 'modules/'.$module.'/tpls/QuickCreate.tpl';
	            	}

		            $view->ev = $this->ev;
		            $view->ss = $this->ev->ss;
		            $view->bean = BeanFactory::getBean($module);
					$view->ev->formName = 'form_DC'.$view->ev->view .'_'.$module;
					$view->showTitle = false; // Do not show title since this is for subpanel
		            $view->display();
	            }
            }
		} //if

		if($defaultProcess) {
		   $form_name = 'form_DC'.$this->ev->view .'_'.$module;
		   $this->ev->formName = $form_name;
		   $this->ev->process(true, $form_name);
		   echo $this->ev->display(false, true);
		}
	}

    /**
     * Get EditView object
     * @return EditView
     */
    protected function getEditView()
    {
        return new EditView();
    }
}