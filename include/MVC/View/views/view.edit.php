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


require_once('include/EditView/EditView2.php');
class ViewEdit extends SugarView
{
 	var $ev;
 	var $type ='edit';
 	var $useForSubpanel = false;  //boolean variable to determine whether view can be used for subpanel creates
 	var $useModuleQuickCreateTemplate = false; //boolean variable to determine whether or not SubpanelQuickCreate has a separate display function
 	var $showTitle = true;

    /**
     * Constructor
     *
     * @see SugarView::SugarView()
     */
    public function __construct($bean = null, $view_object_map = array())
    {
        parent::__construct($bean, $view_object_map);
    }

    /**
     * Constructor
     * @deprecated Use the PHP 5.x style __construct instead
     * @see SugarView::SugarView()
     */
    public function ViewEdit($bean = null, $view_object_map = array())
    {
        parent::SugarView($bean, $view_object_map);
    }

    /**
     * @see SugarView::preDisplay()
     */
    public function preDisplay()
    {
        $metadataFile = $this->getMetaDataFile();
        $this->ev = $this->getEditView();
        $this->ev->ss = $this->ss;
        $this->ev->setup($this->module, $this->bean, $metadataFile, SugarAutoLoader::existingCustomOne('include/EditView/EditView.tpl'));
    }

 	function display(){
		$this->ev->process();
		echo $this->ev->display($this->showTitle);
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

