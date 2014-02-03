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

/*********************************************************************************

 * Description:  Contains field arrays that are used for caching
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
$fields_array['Forecast'] = array ('column_fields' => 
	array('id'
		,'timeperiod_id'
		,'user_id'
		,'forecast_type'
		,'opp_count'
		,'opp_weigh_value'
		,'date_entered'
		,'date_modified'
        ,'currency_id'
		,'best_case'
		,'likely_case'
		,'worst_case'
		),
        'list_fields' =>  array('id', 'timeperiod_id', 'user_id', 'cascade_hierarchy', 
								'forecast_start_date', 'status','user_name','cascade_hierarchy_checked',
								'best_case','likely_case','worst_case'),
);
$fields_array['ForecastOpportunities'] = array ('column_fields' => 
	array('id'
		,'name'
		,'probability'
		,'revenue'
		,'weighted_value'
		,'wk_likely_case'
		,'wk_best_case'
		,'wk_worst_case'
		, 'worksheet_id'
		),
        'list_fields' =>  array('id', 'name','revenue','date_entered', 'weighted_value', 
								'account_name','probability','wk_likely_case',
								'wk_best_case','wk_worst_case', 'worksheet_id'),
);
$fields_array['ForecastDirectReports'] = array ('column_fields' => 
	array('id'
		,'name'
		,'probability'
		,'revenue'
		,'weighted_value'
		,'user_id'
		,'commit_value'
		,'forecast_type'
		,'likely_case'
		,'best_case'
		,'worst_case'
		,'wk_likely_case'
		,'wk_best_case'
		,'wk_worst_case'				
		),
        'list_fields' =>  array('id', 'name','revenue','date_entered', 'weighted_value', 
								'account_name','probability','forecast_type','likely_case',
								'best_case','worst_case','wk_likely_case','wk_best_case','wk_worst_case'),
);
$fields_array['Worksheet'] = array ('column_fields' => array(
		'id'
		, 'user_id'
		,'timeperiod_d'
		,'forecast_type' 
		,'related_id'
        ,'currency_id'
		,'best_case_value'
		,'likely_value'
		,'worst_case_value'
		,'related_forecast_type'
        ,'date_modified'
        ,'modified_user_id'
		),
        'list_fields' =>  array('id','user_id','timeperiod_d','related_id','forecast_type',
								'best_case','likely_case','worst_case','related_forecast_type','date_modified','modified_user_id'),
);

?>