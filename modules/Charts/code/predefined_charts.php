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

$predefined_charts = array(
	'Chart_pipeline_by_sales_stage'=>
	array('type'=>'code','id'=>'Chart_pipeline_by_sales_stage','label'=>$chartsStrings['LBL_CHART_PIPELINE_BY_SALES_STAGE'],'chartType'=>'horizontal group by chart',),
	'Chart_lead_source_by_outcome'=>
	array('type'=>'code','id'=>'Chart_lead_source_by_outcome','label'=>$chartsStrings['LBL_CHART_LEAD_SOURCE_BY_OUTCOME'],'chartType'=>'horizontal group by chart',),
	'Chart_outcome_by_month'=>
	array('type'=>'code','id'=>'Chart_outcome_by_month','label'=>$chartsStrings['LBL_CHART_OUTCOME_BY_MONTH'],'chartType'=>'stacked group by chart',),
	'Chart_pipeline_by_lead_source'=>
	array('type'=>'code','id'=>'Chart_pipeline_by_lead_source','label'=>$chartsStrings['LBL_CHART_PIPELINE_BY_LEAD_SOURCE'],'chartType'=>'pie chart',),
	'Chart_my_pipeline_by_sales_stage'=>
	array('type'=>'code','id'=>'Chart_pipeline_by_sales_stage','label'=>$chartsStrings['LBL_CHART_MY_PIPELINE_BY_SALES_STAGE'],'chartType'=>'funnel chart',),
);