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


require_once('include/Dashlets/Dashlet.php');


class InvadersDashlet extends Dashlet {
    var $savedText; // users's saved text
    var $height = '100'; // height of the pad

    /**
     * Constructor
     *
     * @global string current language
     * @param guid $id id for the current dashlet (assigned from Home module)
     * @param array $def options saved for this dashlet
     */
    function InvadersDashlet($id, $def) {
        $this->loadLanguage('InvadersDashlet'); // load the language strings here

        if(!empty($def['height'])) // set a default height if none is set
            $this->height = $def['height'];

        parent::Dashlet($id); // call parent constructor

        $this->isConfigurable = false; // dashlet is configurable
        $this->hasScript = true;  // dashlet has javascript attached to it

        // if no custom title, use default
        if(empty($def['title'])) $this->title = $this->dashletStrings['LBL_TITLE'];
        else $this->title = $def['title'];
    }

    /**
     * Displays the dashlet
     *
     * @return string html to display dashlet
     */
    function display() {
        $ss = new Sugar_Smarty();
        $ss->assign('id', $this->id);
        $ss->assign('height', $this->height);
        $ss->assign('dashletStrings', $this->dashletStrings);

        $str = $ss->fetch('modules/Home/Dashlets/InvadersDashlet/InvadersDashlet.tpl');
        return parent::display($this->dashletStrings['LBL_DBLCLICK_HELP']) . $str . '<br />'; // return parent::display for title and such
    }

    /**
     * Displays the javascript for the dashlet
     *
     * @return string javascript to use with this dashlet
     */
    function displayScript() {
        $ss = new Sugar_Smarty();
        $ss->assign('id', $this->id);
        $ss->assign('dashletStrings', $this->dashletStrings);

        $str = $ss->fetch('modules/Home/Dashlets/InvadersDashlet/InvadersDashletScript.tpl');
        return $str; // return parent::display for title and such
    }

    /**
     * Displays the configuration form for the dashlet
     *
     * @return string html to display form
     */
    function displayOptions() {
        global $app_strings;

        $ss = new Sugar_Smarty();
        $ss->assign('titleLbl', $this->dashletStrings['LBL_CONFIGURE_TITLE']);
        $ss->assign('heightLbl', $this->dashletStrings['LBL_CONFIGURE_HEIGHT']);
        $ss->assign('saveLbl', $app_strings['LBL_SAVE_BUTTON_LABEL']);
        $ss->assign('clearLbl', $app_strings['LBL_CLEAR_BUTTON_LABEL']);
        $ss->assign('title', $this->title);
        $ss->assign('height', $this->height);
        $ss->assign('id', $this->id);

        return parent::displayOptions() . $ss->fetch('modules/Home/Dashlets/InvadersDashlet/InvadersOptions.tpl');
    }

    /**
     * called to filter out $_REQUEST object when the user submits the configure dropdown
     *
     * @param array $req $_REQUEST
     * @return array filtered options to save
     */
    function saveOptions($req) {
        global $sugar_config, $timedate, $current_user, $theme;
        $options = array();
        $options['title'] = $_REQUEST['title'];
        if(is_numeric($_REQUEST['height'])) {
            if($_REQUEST['height'] > 0 && $_REQUEST['height'] <= 300) $options['height'] = $_REQUEST['height'];
            elseif($_REQUEST['height'] > 300) $options['height'] = '300';
            else $options['height'] = '100';
        }

//        $options['savedText'] = br2nl($this->savedText);
        $options['savedText'] = $this->savedText;

        return $options;
    }

    /**
     * Used to save text on textarea blur. Accessed via Home/CallMethodDashlet.php
     * This is an example of how to to call a custom method via ajax
     */
    function saveText() {
        if(isset($_REQUEST['savedText'])) {
            $optionsArray = $this->loadOptions();
//            _pp($_REQUEST['savedText']);
            $optionsArray['savedText'] = nl2br($_REQUEST['savedText']);
            $this->storeOptions($optionsArray);

        }
        else {
            $optionsArray['savedText'] = '';
        }
        $json = getJSONobj();
        echo 'result = ' . $json->encode(array('id' => $_REQUEST['id'],
                                       'savedText' => $optionsArray['savedText']));
    }
}

?>
