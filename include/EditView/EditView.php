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

/**
 * Old EditView
 * @deprecated
 */
class EditView {
    /**
     * smarty object
     * @var object
     */
    var $ss;
    /**
     * location of template to use
     * @var string
     */
    var $template;
    /**
     * Module to use
     * @var string
     */
    var $module;

    /**
     *
     * @param string $module module to use
     * @param string $template template of the form to retreive
     */
    function EditView($module, $template) {
        $this->module = $module;
        $this->template = $template;
        $this->ss = new Sugar_Smarty();
    }

    /**
     * Processes / setups the template
     * assigns all things to the template like mod_srings and app_strings
     *
     */
    function process() {
        global $current_language, $app_strings, $sugar_version, $sugar_config, $timedate, $theme;;
        $module_strings = return_module_language($current_language, $this->module);

        $this->ss->assign('SUGAR_VERSION', $sugar_version);
        $this->ss->assign('JS_CUSTOM_VERSION', $sugar_config['js_custom_version']);
        $this->ss->assign('VERSION_MARK', getVersionedPath(''));
        $this->ss->assign('THEME', $theme);
        $this->ss->assign('APP', $app_strings);
        $this->ss->assign('MOD', $module_strings);
    }


    /**
     * Displays the template
     *
     * @return string HTML of parsed template
     */
    function display() {
        return $this->ss->fetch($this->template);
    }

}
?>