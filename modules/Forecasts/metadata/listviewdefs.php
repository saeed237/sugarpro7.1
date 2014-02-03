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



$listViewDefs['ForecastOpportunities'] = array(
    'NAME' => array(
        'width' => '25%',
        'label' => 'LBL_OW_OPPORTUNITIES',
        'tablename' => 'opportunities',
    ),
    'REVENUE' => array(
        'width' => '10%',
        'label' => 'LBL_OW_REVENUE',
    ),
    'PROBABILITY' => array(
        'width' => '5%',
        'label' => 'LBL_OW_PROBABILITY',
        'tablename' => 'opportunities',
    ),
    'WEIGHTED_VALUE' => array(
        'width' => '15%',
        'label' => 'LBL_OW_WEIGHTED',
    ),
    'WK_BEST_CASE' => array(
        'width' => '15%',
        'label' => 'LBL_FDR_WK_BEST_CASE',
        'edit' => true,
        'sortable' => false,
    ),
    'WK_LIKELY_CASE' => array(
        'width' => '15%',
        'label' => 'LBL_FDR_WK_LIKELY_CASE',
        'edit' => true,
        'sortable' => false,
    ),
    'WK_WORST_CASE' => array(
        'width' => '15%',
        'label' => 'LBL_FDR_WK_WORST_CASE',
        'edit' => true,
        'sortable' => false,
    ),
    //not visible in the list view.
    'ACCOUNT_NAME' => array(
        'label' => 'LBL_OW_ACCOUNTNAME',
        'hidden' => true,
        'width' => '0'
    ),
    'NEXT_STEP' => array(
        'label' => 'LBL_OW_NEXT_STEP',
        'hidden' => true,
        'width' => '0'
    ),
    'OPPORTUNITY_TYPE' => array(
        'label' => 'LBL_OW_TYPE',
        'hidden' => true,
        'width' => '0'
    ),
    'DESCRIPTION' => array(
        'label' => 'LBL_OW_DESCRIPTION',
        'hidden' => true,
        'width' => '0'
    )
);

$listViewDefs['ForecastDirectReports'] = array(
	'USER_NAME' => array(
		'width' => '16%', 		
		'label' => 'LBL_FDR_USER_NAME',
        'tablename'=>'users',
		), 
	'BEST_CASE' => array(
		'width' => '12%', 
		'label' => 'LBL_FDR_C_BEST_CASE',
        'sortable'  => false,
    ),
	'LIKELY_CASE' => array(
		'width' => '12%', 
		'label' => 'LBL_FDR_C_LIKELY_CASE',
        'sortable'  => false,
    ),
	'WORST_CASE' => array(
		'width' => '12%', 
		'label' => 'LBL_FDR_C_WORST_CASE',
        'sortable'  => false,
    ),		
	'DATE_COMMITTED' => array(
		'width' => '12%', 
		'label' => 'LBL_FDR_DATE_COMMIT',
        'sortable'  => false,
    ),
	'WK_BEST_CASE' => array(
		'width' => '12%', 
		'label' => 'LBL_FDR_WK_BEST_CASE',		
		'edit' => true,
        'sortable'  => false,
    ),
	'WK_LIKELY_CASE' => array(
		'width' => '12%', 
		'label' => 'LBL_FDR_WK_LIKELY_CASE',		
		'edit' => true,
        'sortable'  => false,
    ),
	'WK_WORST_CASE' => array(
		'width' => '12%', 
		'label' => 'LBL_FDR_WK_WORST_CASE',		
		'edit' => true,
        'sortable'  => false,
    ),		
//fields not visible in the list view.
    'OPP_COUNT' => array(
        'hidden' => true,    
        'width' => '0%', 
        'label' => 'LBL_FDR_OPPORTUNITIES'), 
    'OPP_WEIGH_VALUE' => array(
        'hidden' => true,
        'width' => '0%', 
        'label' => 'LBL_FDR_WEIGH'), 
	'FORECAST_TYPE' => array(
		'width' => '0%', 
		'label' => 'LBL_FDR_ADJ_AMOUNT',		
		'hidden' => true,),
    'DATE_ENTERED' => array(
        'width' => '0%', 
        'label' => 'LBL_FDR_DATE_COMMIT',
        'hidden' => true,
    ),

);
?>
