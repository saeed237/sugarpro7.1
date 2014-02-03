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

require_once('modules/Trackers/TrackerReporter.php');

class TrackerDashlet extends Dashlet {
    var $savedText; // users's saved text
    var $height = '300'; // height of the pad
	var $tReporter;
	var $column_widths = array('item_id'=>210,
	                           'module_name'=>125);
    /**
     * Constructor
     *
     * @global string current language
     * @param guid $id id for the current dashlet (assigned from Home module)
     * @param array $def options saved for this dashlet
     */
    function TrackerDashlet($id, $def) {
        $this->loadLanguage('TrackerDashlet', 'modules/Trackers/Dashlets/'); // load the language strings here

        if(!empty($def['height'])) // set a default height if none is set
            $this->height = $def['height'];

        parent::Dashlet($id); // call parent constructor

        $this->isConfigurable = true; // dashlet is configurable
        $this->hasScript = true;  // dashlet has javascript attached to it

        // if no custom title, use default
        if(empty($def['title'])) $this->title = $this->dashletStrings['LBL_TITLE'];
        else $this->title = $def['title'];
        if(isset($def['autoRefresh'])) $this->autoRefresh = $def['autoRefresh'];

        $this->tReporter = new TrackerReporter();
    }

    /**
     * Displays the dashlet
     *
     * @return string html to display dashlet
     */
    function display() {
        $ss = new Sugar_Smarty();
        $ss->assign('savedText', $this->savedText);
        $ss->assign('saving', $this->dashletStrings['LBL_SAVING']);
        $ss->assign('saved', $this->dashletStrings['LBL_SAVED']);
        $ss->assign('id', $this->id);
        $ss->assign('height', $this->height);
        $str = $ss->fetch('modules/Trackers/Dashlets/TrackerDashlet/TrackerDashlet.tpl');
        return parent::display() . $str . '<br />'; // return parent::display for title and such
    }

    /**
     * Displays the javascript for the dashlet
     *
     * @return string javascript to use with this dashlet
     */
    function displayScript() {
        $ss = new Sugar_Smarty();
        $ss->assign('saving', $this->dashletStrings['LBL_SAVING']);
        $ss->assign('saved', $this->dashletStrings['LBL_SAVED']);
        $ss->assign('id', $this->id);
        $ss->assign('height', $this->height);
        $ss->assign('clearLbl', $this->dashletStrings['LBL_CLEAR']);
        $ss->assign('clearToolTipLbl', $this->dashletStrings['LBL_CLEAR_TOOLTIP']);
        $ss->assign('runLbl', $this->dashletStrings['LBL_FILTER']);
        $ss->assign('runToolTipLbl', $this->dashletStrings['LBL_FILTER_TOOLTIP']);
        $ss->assign('sinceLbl', $this->dashletStrings['LBL_SINCE']);
        $ss->assign('selectQueryLbl', $this->dashletStrings['LBL_SELECT_QUERY']);
        $ss->assign('chooseDateTooltip', $this->dashletStrings['LBL_CHOOSE_DATE_TOOLTIP']);
        $comboData = $this->tReporter->getComboData();
        $dateDependentQueries =  $this->tReporter->getDateDependentQueries();
        $json = getJSONobj();
        $ss->assign('comboData',  $json->encode($comboData));
        $ss->assign('dateDependentQueries',  $json->encode($dateDependentQueries));
        $str = $ss->fetch('modules/Trackers/Dashlets/TrackerDashlet/TrackerDashletScript.tpl');
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
        if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}

        return parent::displayOptions() . $ss->fetch('modules/Trackers/Dashlets/TrackerDashlet/TrackerDashletOptions.tpl');
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
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];

        return $options;
    }

    public function hasAccess(){
    	return ACLController::checkAccess('Trackers', 'view', false, 'Tracker');
    }

	public function __call($method, $args){
		$json = getJSONobj();
		if(!empty($_REQUEST['date_selected'])){
			$args = $_REQUEST['date_selected'];
		}

		$result = $this->tReporter->$method($args);

		//get the headers
		$col_headers = array();
		$column_labels = array();
		$col_widths = array();
		if($result != null && count($result) > 0){
			$mstrings = return_module_language($GLOBALS['current_language'], 'Trackers');
			$col_headers = array_keys($result[0]);
			foreach($col_headers as $column) {
			   $col_widths[] = isset($this->column_widths[$column]) ? $this->column_widths[$column] : 150;
			   $column_labels[] = !empty($mstrings[$column]) ? $mstrings[$column] : $column;
			}
		}
		$sortType = !empty($this->tReporter->sort_types[$method]) ? $this->tReporter->sort_types[$method] : array();
		echo 'result = ' . $json->encode(array('col_labels' => $column_labels, 'col_headers' => $col_headers, 'col_widths' => $col_widths, 'data' => $result, 'sort_types'=>$sortType));
	}
}

?>
