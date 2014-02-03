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



require_once 'include/MVC/View/views/view.edit.php';

class PdfManagerViewEdit extends ViewEdit
{
    public function PdfManagerViewEdit()
    {
        parent::ViewEdit();
    }

    public function display()
    {
    
        // Disable VCR Control
        $this->ev->showVCRControl = false;

        // Default Team as Global
        if ((empty($this->bean->id))  && !$this->ev->isDuplicate) {
            $this->bean->team_id = 1;
            $this->bean->team_set_id = 1;
        }
    
        // Load TinyMCE
        require_once 'include/SugarTinyMCE.php';
        $tiny = new SugarTinyMCE();
        $tiny->defaultConfig['apply_source_formatting']=true;
        $tiny->defaultConfig['cleanup_on_startup']=true;
        $tiny->defaultConfig['relative_urls']=false;
        $tiny->defaultConfig['convert_urls']=false;
        $ed = $tiny->getInstance('body_html');
        $this->ss->assign('tiny_script', $ed);

        // Load Fields for main module
        if (empty($this->bean->base_module)) {
            $modulesList = PdfManagerHelper::getAvailableModules();
            $this->bean->base_module = key($modulesList);
        }
        $fieldsForSelectedModule = PdfManagerHelper::getFields($this->bean->base_module, true);

        $this->ss->assign('fieldsForSelectedModule', $fieldsForSelectedModule);

        parent::display();
    }
}
