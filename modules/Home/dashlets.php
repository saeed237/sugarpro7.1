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

$defaultDashlets = array(
						'MyCallsDashlet'=>'Calls',
						'MyMeetingsDashlet'=>'Meetings',
						'MyOpportunitiesDashlet'=>'Opportunities',
						'MyAccountsDashlet'=>'Accounts',
						'MyLeadsDashlet'=>'Leads',
						 );

$defaultSalesChartDashlets = array( translate('DEFAULT_REPORT_TITLE_6', 'Reports') => 'Opportunities',
	                     );    

$defaultSalesDashlets = array('MyPipelineBySalesStageDashlet'=>'Opportunities', 
							  'MyOpportunitiesGaugeDashlet'=>'Opportunities', 
							  'MyOpportunitiesDashlet'=>'Opportunities',
                              'MyClosedOpportunitiesDashlet'=>'Opportunities',		  
						 );   								  
						 
//Split up because of default ordering (35430)						 
$defaultSalesDashlets2 = array('MyForecastingChartDashlet'=>'Forecasts');						 
						 
$defaultMarketingChartDashlets = array( translate('DEFAULT_REPORT_TITLE_18', 'Reports')=>'Leads', // Leads By Lead Source
									  );
									  
$defaultMarketingDashlets = array(  'CampaignROIChartDashlet' => 'Campaigns',
                                    'MyLeadsDashlet'=>'Leads',  
									'TopCampaignsDashlet' => 'Campaigns');
									  
$defaultSupportDashlets = array( 'MyCasesDashlet'=>'Cases',
								 'MyBugsDashlet' =>'Bugs', 
								  );

$defaultSupportChartDashlets = array(   //translate('DEFAULT_REPORT_TITLE_10', 'Reports')=>'Cases', // New Cases By Month
										translate('DEFAULT_REPORT_TITLE_7', 'Reports')=>'Cases', // Open Cases By User By Status
										translate('DEFAULT_REPORT_TITLE_8', 'Reports')=>'Cases', // Open Cases By Month By User
										//translate('DEFAULT_REPORT_TITLE_9', 'Reports')=>'Cases', // Open Cases By Priority By User
									  );								  
								  
$defaultTrackingDashlets = array('TrackerDashlet'=>'Trackers', 
								 'MyModulesUsedChartDashlet'=>'Trackers', 
								 'MyTeamModulesUsedChartDashlet'=>'Trackers',
							    );
							    
$defaultTrackingReportDashlets =  array(translate('DEFAULT_REPORT_TITLE_27', 'Reports')=>'Trackers');


if (SugarAutoLoader::fileExists('custom/modules/Home/dashlets.php')) include_once('custom/modules/Home/dashlets.php');
