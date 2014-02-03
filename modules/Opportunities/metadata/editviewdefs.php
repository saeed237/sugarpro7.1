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

$viewdefs['Opportunities']['EditView'] = array(
    'templateMeta' => array('maxColumns' => '2', 
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'), 
                                            array('label' => '10', 'field' => '30')
                                            ),
    'javascript' => '{$PROBABILITY_SCRIPT}',
),
 'panels' =>array (
  'default' => 
  array (
    
    array (
      array('name'=>'name'),
      'account_name',
    ),
    array(
    	array('name'=>'currency_id','label'=>'LBL_CURRENCY'),
    	array('name'=>'date_closed'),
    ),
    array (
      array( 'name'=>'amount'),
      'opportunity_type',
    ),

    array(
        'best_case',
        'worst_case',
    ),

    array (
      'sales_stage',
      'lead_source',
    ),
    array (      
		'probability',
      	'campaign_name',
    ),
    array (
      	'next_step',
    ),
    array (
      'description',
    ),
  ),
  
  'LBL_PANEL_ASSIGNMENT' => array(
    array(
	    'assigned_user_name',
	    array('name'=>'team_name'),
    ),
  ),
)


);
?>