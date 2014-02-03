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



initmySugarCharts = function(){

SUGAR.mySugar.sugarCharts = function() {

var activeTab = activePage,
    charts = new Object();

	return {
		loadSugarCharts: function(activeTab) {
			var chartFound = false;

			for (id in charts[activeTab]){
				if(id != 'undefined'){
					chartFound = true;
				//alert(charts[activeTab][id]['chartType']);
					loadSugarChart(
											 charts[activeTab][id]['chartId'], 
											 charts[activeTab][id]['jsonFilename'],
											 charts[activeTab][id]['css'],
											 charts[activeTab][id]['chartConfig']
											 );
				}
			}
			//clear charts array
			charts = new Object();

		},

		addToChartsArrayJson: function(json,activeTab) {
			for (id in json) {
					if(json[id]['supported'] == "true") {
						SUGAR.mySugar.sugarCharts.addToChartsArray(
												 json[id]['chartId'], 
 												 json[id]['filename'],
												 json[id]['css'],
												 json[id]['chartConfig'],
												 activeTab);
					}
				}
		},
		addToChartsArray: function(chartId,jsonFilename,css,chartConfig,activeTab) {
			
			if (charts[activeTab] == null){
				charts[activeTab] = new Object();
			}
			charts[activeTab][chartId] = new Object();
			charts[activeTab][chartId]['chartId'] = chartId;
			charts[activeTab][chartId]['jsonFilename'] = jsonFilename;	
			charts[activeTab][chartId]['css'] = css;	
			charts[activeTab][chartId]['chartConfig'] = chartConfig;		
	
		}
	}
}();
};
