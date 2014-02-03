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

$chartsStrings = return_module_language($GLOBALS['current_language'], 'Charts');

$chartDefs = array(
	'pipeline_by_sales_stage_funnel'=>
		array(	'type' => 'code',
				'id' => 'Chart_pipeline_by_sales_stage',
				'label' => $chartsStrings['LBL_CHART_PIPELINE_BY_SALES_STAGE_FUNNEL'],
				'chartUnits' => $chartsStrings['LBL_OPP_SIZE'] . ' $1' . $chartsStrings['LBL_OPP_THOUSANDS'],
				'chartType' => 'funnel chart 3D',
				'groupBy' => array( 'sales_stage', 'user_name', ),
				'base_url'=>
					array( 	'module' => 'Opportunities',
							'action' => 'index',
							'query' => 'true',
							'searchFormTab' => 'advanced_search',
						 ),
				'url_params' => array( 'assigned_user_id', 'sales_stage', 'date_start', 'date_closed' ),
			 ),
	'pipeline_by_sales_stage'=>
		array( 	'type' => 'code',
				'id' => 'Chart_pipeline_by_sales_stage',
				'label' => $chartsStrings['LBL_CHART_PIPELINE_BY_SALES_STAGE'],
				'chartUnits' => $chartsStrings['LBL_OPP_SIZE'] . ' $1' . $chartsStrings['LBL_OPP_THOUSANDS'],
				'chartType' => 'horizontal group by chart',
				'groupBy' => array( 'sales_stage', 'user_name' ),
				'base_url'=>
					array( 	'module' => 'Opportunities',
							'action' => 'index',
							'query' => 'true',
							'searchFormTab' => 'advanced_search',
						 ),
				'url_params' => array( 'assigned_user_id', 'sales_stage', 'date_start', 'date_closed' ),
			),
	'lead_source_by_outcome'=>
		array(	'type' => 'code',
				'id' => 'Chart_lead_source_by_outcome',
				'label' => $chartsStrings['LBL_CHART_LEAD_SOURCE_BY_OUTCOME'],
				'chartUnits' => '',
				'chartType' => 'horizontal group by chart',
				'groupBy' => array( 'lead_source', 'sales_stage' ),
				'base_url'=>
					array( 	'module' => 'Opportunities',
							'action' => 'index',
							'query' => 'true',
							'searchFormTab' => 'advanced_search',
						 ),
				'url_params' => array( 'lead_source', 'sales_stage', 'date_start', 'date_closed' ),
			 ),
	'outcome_by_month'=>
		array(	'type' => 'code',
				'id' => 'Chart_outcome_by_month',
				'label' => $chartsStrings['LBL_CHART_OUTCOME_BY_MONTH'],
				'chartUnits' => $chartsStrings['LBL_OPP_SIZE'] . ' $1' . $chartsStrings['LBL_OPP_THOUSANDS'],
				'chartType' => 'stacked group by chart',
				'groupBy' => array( 'm', 'sales_stage', ),
				'base_url'=>
					array( 	'module' => 'Opportunities',
							'action' => 'index',
							'query' => 'true',
							'searchFormTab' => 'advanced_search',
						 ),
				'url_params' => array( 'sales_stage', 'date_closed' ),
			 ),
	'pipeline_by_lead_source'=>
		array(	'type' => 'code',
				'id' => 'Chart_pipeline_by_lead_source',
				'label' => $chartsStrings['LBL_CHART_PIPELINE_BY_LEAD_SOURCE'],
				'chartUnits' => $chartsStrings['LBL_OPP_SIZE'] . ' $1' . $chartsStrings['LBL_OPP_THOUSANDS'],
				'chartType' => 'pie chart',
				'groupBy' => array( 'lead_source', ),
				'base_url'=>
					array( 	'module' => 'Opportunities',
							'action' => 'index',
							'query' => 'true',
							'searchFormTab' => 'advanced_search',
						 ),
				'url_params' => array( 'lead_source', ),
			 ),
	'opportunities_this_quarter' =>
		array( 	'type' => 'code',
				'id' => 'opportunities_this_quarter',
				'label' => $chartsStrings['LBL_CHART_OPPORTUNITIES_THIS_QUARTER'],
				'chartType' => 'gauge chart',
				'chartUnits' => 'Number of Opportunities',
				'groupBy' => array( ),
				'gaugeTarget' => 200,
				'base_url'=>
					array( 	'module' => 'Opportunities',
							'action' => 'index',
							'query' => 'true',
							'searchFormTab' => 'advanced_search',
						 ),
		),

	'my_modules_used_last_30_days' =>
		array( 	'type' => 'code',
				'id' => 'my_modules_used_last_30_days',
				'label' => $chartsStrings['LBL_CHART_MY_MODULES_USED_30_DAYS'],
				'chartType' => 'horizontal bar chart',
				'chartUnits' => $chartsStrings['LBL_MY_MODULES_USED_SIZE'],
				'groupBy' => array( 'module_name'),
				'base_url'=>
					array( 	'module' => 'Trackers',
							'action' => 'index',
							'query' => 'true',
							'searchFormTab' => 'advanced_search',
						 ),

		),

	'my_team_modules_used_last_30_days' =>
		array( 	'type' => 'code',
				'id' => 'my_team_modules_used_last_30_days',
				'label' => $chartsStrings['LBL_CHART_MODULES_USED_DIRECT_REPORTS_30_DAYS'],
				'chartType' => 'horizontal group by chart',
				'chartUnits' => $chartsStrings['LBL_MY_MODULES_USED_SIZE'],
				'groupBy' => array('user_name', 'module_name'),
				'base_url'=>
					array( 	'module' => 'Trackers',
							'action' => 'index',
							'query' => 'true',
							'searchFormTab' => 'advanced_search',
						 ),
		),
);

if(SugarAutoLoader::existing('custom/Charts/chartDefs.ext.php')) {
	include_once('custom/Charts/chartDefs.ext.php');
}
