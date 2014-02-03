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

$dashletData['MyCasesDashlet']['searchFields'] = array('date_entered'     => array('default' => ''),
													   'priority'         => array('default' => ''),
                                                       'status'           => array('default' => array('Assigned', 'New', 'Pending Input')),
                                                       
													   'name'             => array('default' => ''),
												       'type'             => array('default' => ''),
                                                       //'date_modified'    => array('default' => ''),
                                                       'team_id'          => array('default' => '', 'label' => 'LBL_TEAMS'),
                                                       'assigned_user_id' => array('type'    => 'assigned_user_name',
																				   'label'   => 'LBL_ASSIGNED_TO',
                                                                                   'default' => $current_user->name));
$dashletData['MyCasesDashlet']['columns'] = array('case_number' => array('width'   => '6',
                                                                         'label'   => 'LBL_NUMBER',
                                                                         'default' => true),
                                                  'name' => array('width'    => '40', 
                                                                  'label'   => 'LBL_LIST_SUBJECT',
                                                                  'link'    => true,
                                                                  'default' => true), 
                                                  'account_name' => array('width' => '29',
                                                                          'link' => true,
                                                                          'module' => 'Accounts',
                                                                          'id' => 'ACCOUNT_ID',
                                                                          'ACLTag' => 'ACCOUNT', 
                                                                          'label' => 'LBL_ACCOUNT_NAME',
                                                                          'related_fields' => array('account_id')),
                                                  'priority' => array('width'   => '15', 
                                                                      'label'   => 'LBL_PRIORITY',
                                                                      'default' => true), 
                                                  'status' => array('width'   => '8', 
                                                                    'label'   => 'LBL_STATUS',
                                                                    'default' => true),                                            
                                                  'resolution' => array('width' => '8', 
                                                                        'label' => 'LBL_RESOLUTION'),
                                                  'date_entered' => array('width'   => '15', 
                                                                          'label'   => 'LBL_DATE_ENTERED'),
                                                  'date_modified' => array('width'   => '15', 
                                                                           'label'   => 'LBL_DATE_MODIFIED'),    
                                                  'created_by' => array('width'   => '8', 
                                                                        'label'   => 'LBL_CREATED'),
                                                  'assigned_user_name' => array('width'   => '8', 
                                                                                'label'   => 'LBL_LIST_ASSIGNED_USER'),
                                                  'team_name' => array('width'   => '15', 
                                                                       'label'   => 'LBL_LIST_TEAM'),
                                                 );
?>
