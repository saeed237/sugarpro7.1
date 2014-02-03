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

/*********************************************************************************

 * Description: view handler for undo step of the import process
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/

require_once('modules/Import/views/ImportView.php');
        
class ImportViewUndo extends ImportView 
{	

    protected $pageTitleKey = 'LBL_UNDO_LAST_IMPORT';
    
 	/** 
     * @see SugarView::display()
     */
 	public function display()
    {
        global $mod_strings, $current_user, $current_language;
        
        $this->ss->assign("IMPORT_MODULE", $_REQUEST['import_module']);
        // lookup this module's $mod_strings to get the correct module name
        $old_mod_strings = $mod_strings;
        $module_mod_strings = 
            return_module_language($current_language, $_REQUEST['import_module']);
        $this->ss->assign("MODULENAME",$module_mod_strings['LBL_MODULE_NAME']);
        $this->ss->assign("MODULE_TITLE", $this->getModuleTitle(false), ENT_NOQUOTES);
        // reset old ones afterwards
        $mod_strings = $old_mod_strings;
        
        $last_import = BeanFactory::getBean('Import_2');
        $this->ss->assign('UNDO_SUCCESS',$last_import->undo($_REQUEST['import_module']));
        $this->ss->assign("JAVASCRIPT", $this->_getJS());
        $content = $this->ss->fetch('modules/Import/tpls/undo.tpl');
        $this->ss->assign("CONTENT",$content);
        $this->ss->display('modules/Import/tpls/wizardWrapper.tpl');
    }
    
    /**
     * Returns JS used in this view
     */
    private function _getJS()
    {
        return <<<EOJAVASCRIPT

document.getElementById('finished').onclick = function() {
    var form = $(this).closest('form'),
        module = form.find('input[name=import_module]').val(),
        action = 'index';
    form.find('input[name=module]').val(module);
    form.find('input[name=action]').val(action);

    parent.SUGAR.App.metadata.getModule(module).isBwcEnabled ?
        form.submit() :
        parent.SUGAR.App.router.navigate(module, {trigger: true});
};
EOJAVASCRIPT;
    }
}
