{*
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

*}

{if !$error}
<script type="text/javascript">
	{literal}
	SUGAR.util.doWhen(
		"((SUGAR && SUGAR.mySugar && SUGAR.mySugar.sugarCharts)   || (SUGAR.loadChart && typeof loadSugarChart == 'function')  || document.getElementById('showHideChartButton') != null) && typeof(loadSugarChart) != undefined",
		function(){
			{/literal}
			var css = new Array();
			var chartConfig = new Array();
			{foreach from=$css key=selector item=property}
				css["{$selector}"] = '{$property}';
			{/foreach}
			{foreach from=$config key=name item=value}
				chartConfig["{$name}"] = '{$value}';
			{/foreach}
			{if $height > 480}
				chartConfig["scroll"] = true;
			{/if}
			loadCustomChartForReports = function(){ldelim}
				loadSugarChart('{$chartId}','{$filename}',css,chartConfig);
			{rdelim};
			// bug51857: fixed issue on report running in a loop when clicking on hide chart then run report in IE8 only
			// When hide chart button is clicked, the value of element showHideChartButton is set to $showchart.
			// Don't need to call the loadCustomChartForReports() function when hiding the chart.
			{if !isset($showchart)}
				loadCustomChartForReports();
			{else}
			     if($('#showHideChartButton').attr('value') != '{$showchart}')
			        loadCustomChartForReports();
			{/if}
			{literal}
		}
	);
	{/literal}
</script>

<div class="chartContainer">
	<div id="sb{$chartId}" class="scrollBars">
    <div id="{$chartId}" class="chartCanvas" style="width: {$width}; height: {$height}px;"></div>  
    </div>
	<div id="legend{$chartId}" class="legend"></div>
</div>
<div class="clear"></div>
{else}

{$error}
{/if}