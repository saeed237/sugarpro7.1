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




require_once("include/SugarCharts/JsChart.php");

class Jit extends JsChart {
	
	var $supports_image_export = true;
	var $print_html_legend_pdf = true;
	
	function __construct() {
		parent::__construct();
	}
	
	function getChartResources() {
		return '
		<!--[if lt IE 9]>
		<script type="text/javascript" src="'.getJSPath('include/SugarCharts/Jit/FlashCanvas/flashcanvas.js').'"></script>
		<![endif]-->
		<script language="javascript" type="text/javascript" src="'.getJSPath('include/SugarCharts/Jit/js/Jit/jit.js').'"></script>
		<script language="javascript" type="text/javascript" src="'.getJSPath('include/SugarCharts/Jit/js/sugarCharts.js').'"></script>
		';
	}
	
	function getMySugarChartResources() {
		return '
		<script language="javascript" type="text/javascript" src="'.getJSPath('include/SugarCharts/Jit/js/mySugarCharts.js').'"></script>
		';
	}
	

	function display($name, $xmlFile, $width='320', $height='480', $resize=false) {
	
		parent::display($name, $xmlFile, $width, $height, $resize);

		return $this->ss->fetch('include/SugarCharts/Jit/tpls/chart.tpl');	
	}
	

	function getDashletScript($id,$xmlFile="") {
		
		parent::getDashletScript($id,$xmlFile);
		return $this->ss->fetch('include/SugarCharts/Jit/tpls/DashletGenericChartScript.tpl');
	}
	
	

	
}

?>