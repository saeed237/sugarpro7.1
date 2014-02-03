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


class ChartsDashlet extends Dashlet {
    var $width = '400';
    var $height = '480';
    var $report_id;

    /**
     * Constructor
     *
     * @global string current language
     * @param guid $id id for the current dashlet (assigned from Home module)
	 * @param report_id $report_id id of the saved report
     * @param array $def options saved for this dashlet
     */
    function ChartsDashlet($id, $report_id, $def) {
    	$this->report_id = $report_id;

        $this->loadLanguage('ChartsDashlet'); // load the language strings here

        parent::Dashlet($id); // call parent constructor

        $this->searchFields = array();
        $this->isConfigurable = true; // dashlet is configurable
        $this->hasScript = true;  // dashlet has javascript attached to it
    }

    /**
     * Displays the dashlet
     *
     * @return string html to display dashlet
     */
    function display() {
    	require_once("modules/Reports/Report.php");

		$chartReport = BeanFactory::getBean('Reports', $this->report_id, array("encode" => false));

		if (!empty($chartReport)){
			$title = getReportNameTranslation($chartReport->name);
	        $this->title = $title;

			$reporter = new Report($chartReport->content);
			$reporter->is_saved_report = true;
			$reporter->saved_report_id = $chartReport->id;
            $reporter->get_total_header_row();
			$reporter->run_chart_queries();

			ob_start();
            require_once("include/SugarCharts/ChartDisplay.php");
            $chartDisplay = new ChartDisplay();
            $chartDisplay->setReporter($reporter);
            echo $chartDisplay->legacyDisplay($this->id, true);

			$str = ob_get_contents();
			ob_end_clean();

			$xmlFile = $chartDisplay->get_cache_file_name($reporter);

			$html = parent::display() . "<div align='center'>" . $str . "</div>" . "<br />"; // return parent::display for title and such

			$ss = new Sugar_Smarty();
	        $ss->assign('chartName', $this->id);
	        $ss->assign('chartXMLFile', $xmlFile);
	        $script = $ss->fetch('modules/Home/Dashlets/ChartsDashlet/ChartsDashletScript.tpl');
			$json = getJSONobj();

	        return parent::display() . "<div align='center'>" . $str . "</div>" . "<br />"; // return parent::display for title and such
		}
    }

    /**
     * Displays the javascript for the dashlet
     *
     * @return string javascript to use with this dashlet
     */
    function displayScript() {
    	require_once("modules/Reports/Report.php");
        require_once("include/SugarCharts/ChartDisplay.php");

        $chartReport = BeanFactory::getBean('Reports', $this->report_id, array("encode" => false));

		if (!empty($chartReport)){
	        $this->title = $chartReport->name;

			require_once("modules/Reports/templates/templates_chart.php");
			require_once('include/SugarCharts/SugarChartFactory.php');

			$sugarChart = SugarChartFactory::getInstance();


			$reporter = new Report($chartReport->content);
			$reporter->is_saved_report = true;
			$reporter->saved_report_id = $chartReport->id;

            // Bug #57213 : Reports with data series removed render charts inconsistently
            if ( $reporter && !$reporter->has_summary_columns() )
            {
                return '';
            }

            $chartDisplay = new ChartDisplay();

			$xmlFile = $chartDisplay->get_cache_file_name($reporter);

	        $str = $sugarChart->getDashletScript($this->id,$xmlFile);
	        return $str;
		}
    }

    /**
     * Displays the configuration form for the dashlet
     *
     * @return string html to display form
     */
    function displayOptions() {
    }

    /**
     * called to filter out $_REQUEST object when the user submits the configure dropdown
     *
     * @param array $req $_REQUEST
     * @return array filtered options to save
     */
    function saveOptions($req) {
    }

    function setConfigureIcon(){


        if($this->isConfigurable)
            $additionalTitle = '<td nowrap width="1%" style="padding-right: 0px;"><div class="dashletToolSet"><a href="index.php?module=Reports&record=' . $this->report_id . '&action=ReportCriteriaResults&page=report">'
                               . SugarThemeRegistry::current()->getImage('dashlet-header-edit','title="' . translate('LBL_DASHLET_EDIT', 'Home') . '" border="0"  align="absmiddle"', null,null,'.gif',translate('LBL_DASHLET_EDIT', 'Home')).'</a>'

                               . '';
        else
            $additionalTitle = '<td nowrap width="1%" style="padding-right: 0px;"><div class="dashletToolSet">';

    	return $additionalTitle;
    }

    function setRefreshIcon(){


    	$additionalTitle = '';
        if($this->isRefreshable)
            $additionalTitle .= '<a href="#" onclick="SUGAR.mySugar.retrieveDashlet(\'' 
                                . $this->id . '\', \'chart\'); return false;"><!--not_in_theme!--><img border="0"  title="' . translate('LBL_DASHLET_REFRESH', 'Home') . '" alt="' . translate('LBL_DASHLET_REFRESH', 'Home') . '" src="'

                                . SugarThemeRegistry::current()->getImageURL('dashlet-header-refresh.png') .'" /></a>';
        return $additionalTitle;
    }

}
