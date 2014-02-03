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




global $current_user;

$dashletData['MyOpportunitiesDashlet']['searchFields'] = array('date_entered'     => array('default' => ''),
                                                               'opportunity_type' => array('default' => ''),
                                                               'team_id'          => array('default' => '', 'label'=>'LBL_TEAMS'),
                                                               'sales_stage'      => array('default' => 
                                                                    array('Prospecting', 'Qualification', 'Needs Analysis', 'Value Proposition', 'Id. Decision Makers', 'Perception Analysis', 'Proposal/Price Quote', 'Negotiation/Review')),
                                                               'assigned_user_id' => array('type'    => 'assigned_user_name',
                                                                     					   'label'   => 'LBL_ASSIGNED_TO', 
                                                                                           'default' => $current_user->name));
                                                                                           
$dashletData['MyOpportunitiesDashlet']['columns'] = array('name' => array('width'   => '35', 
                                                                          'label'   => 'LBL_OPPORTUNITY_NAME',
                                                                          'link'    => true,
                                                                          'default' => true 
                                                                          ), 
                                                          'account_name' => array('width'  => '35', 
                                                                                  'label'   => 'LBL_ACCOUNT_NAME',
                                                                                  'default' => true,
                                                                                  'link' => false,
                                                                                  'id' => 'account_id',
                                                                                  'ACLTag' => 'ACCOUNT'),
                                                          'amount_usdollar' => array('width'   => '15', 
                                                                            'label'   => 'LBL_AMOUNT_USDOLLAR',
                                                                            'default' => true,
                                                                            'currency_format' => true),
                                                          'date_closed' => array('width'   => '15', 
                                                                                 'label'   => 'LBL_DATE_CLOSED',
                                                                                 'default'        => true,
                                                                                 'defaultOrderColumn' => array('sortOrder' => 'ASC')),  
                                                          'opportunity_type' => array('width'   => '15', 
                                                                                      'label'   => 'LBL_TYPE'),
                                                          'lead_source' => array('width'   => '15', 
                                                                                 'label'   => 'LBL_LEAD_SOURCE'),
                                                          'sales_stage' => array('width'   => '15', 
                                                                                 'label'   => 'LBL_SALES_STAGE'),
                                                          'probability' => array('width'   => '15', 
                                                                                  'label'   => 'LBL_PROBABILITY'),
                                                          'date_entered' => array('width'   => '15', 
                                                                                  'label'   => 'LBL_DATE_ENTERED'),
                                                          'date_modified' => array('width'   => '15', 
                                                                                   'label'   => 'LBL_DATE_MODIFIED'),    
                                                          'created_by' => array('width'   => '8', 
                                                                                'label'   => 'LBL_CREATED'),
                                                          'assigned_user_name' => array('width'   => '8', 
                                                                                        'label'   => 'LBL_LIST_ASSIGNED_USER'),
														  'next_step' => array('width' => '10', 
														        'label' => 'LBL_NEXT_STEP'),                                                                         
                                                          'team_name' => array('width'   => '15', 
                                                                               'label'   => 'LBL_LIST_TEAM'),
                                                           );
?>
