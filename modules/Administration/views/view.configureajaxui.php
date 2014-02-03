<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

// FIXME will we need this file to update the modules that are sidecar enabled?
//class ViewConfigureAjaxUI extends SugarView
//{
//    /**
//     * @see SugarView::_getModuleTitleParams()
//     */
//    protected function _getModuleTitleParams($browserTitle = false)
//    {
//        return array(
//            "<a href='index.php?module=Administration&action=index'>" . translate('LBL_MODULE_NAME') . "</a>",
//            translate('LBL_CONFIG_AJAX')
//        );
//    }
//
//    /**
//     * @see SugarView::preDisplay()
//     */
//    public function preDisplay()
//    {
//        global $current_user;
//
//        if (!is_admin($current_user))
//        {
//            sugar_die("Unauthorized access to administration.");
//        }
//    }
//
//    /**
//     * @see SugarView::display()
//     */
//    public function display()
//    {
//        global $sugar_config, $moduleList;
//        //create array of subpanels to show, used to create Drag and Drop widget
//        $enabled = array();
//        $disabled = array();
//        $banned = ajaxBannedModules();
//
//        foreach($moduleList as $module)
//        {
//            if (!in_array($module, $banned))
//            {
//                $enabled[] = array("module" => $module, 'label' => translate($module));
//            }
//        }
//        if (!empty($sugar_config['addAjaxBannedModules']))
//        {
//            foreach( $sugar_config['addAjaxBannedModules'] as $module)
//            {
//                $disabled[] = array("module" => $module, 'label' => translate($module));
//            }
//        }
//
//        $this->ss->assign('enabled_mods', json_encode($enabled));
//        $this->ss->assign('disabled_mods', json_encode($disabled));
//        $this->ss->assign('title',$this->getModuleTitle(false));
//
//        echo $this->ss->fetch('modules/Administration/templates/ConfigureAjaxUI.tpl');
//    }
//}
