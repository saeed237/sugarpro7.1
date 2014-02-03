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

$dashletData['MyCallsDashlet']['searchFields'] = array(
													   
                                                       'name'        => array('default' => ''),
                                                       'status'           => array('default' => array('Planned')),
                                                       'date_entered'       => array('default' => ''),
                                                       'date_start'             => array('default' => ''),
                                                       
                                                       'team_id'          => array('default' => '', 'label'=>'LBL_TEAMS'),
                                                       'assigned_user_id' => array('type'    => 'assigned_user_name',
                   																   'label'   => 'LBL_ASSIGNED_TO', 
                                                                                   'default' => $current_user->name));
$dashletData['MyCallsDashlet']['columns'] = array('set_complete' => array('width' => '5', 
                                                                          'label' => 'LBL_LIST_CLOSE',
                                                                          'default' => true,
                                                                          'sortable' => false,
                                                                          'related_fields' => array('status','recurring_source')),
                                                  'name' => array('width'   => '40', 
                                                                  'label'   => 'LBL_SUBJECT',
                                                                  'link'    => true,
                                                                  'default' => true),
                                                  'parent_name' => array('width' => '29', 
                                                                         'label' => 'LBL_LIST_RELATED_TO',
                                                                         'sortable' => false,
                                                                         'dynamic_module' => 'PARENT_TYPE',
                                                                         'link' => true,
                                                                         'id' => 'PARENT_ID',
                                                                         'ACLTag' => 'PARENT',
                                                                         'related_fields' => array('parent_id', 'parent_type'),
																		 'default' => true,
																		),
                                                  
                                                  'duration' => array('width'    => '10', 
                                                                      'label'    => 'LBL_DURATION',
                                                                      'sortable' => false,
                                                                      'related_fields' => array('duration_hours', 'duration_minutes')),
                                                  'direction' => array('width'   => '10', 
                                                                       'label'   => 'LBL_DIRECTION'),  
                                                  'date_start' => array('width'   => '15', 
                                                                        'label'   => 'LBL_DATE',
                                                                        'default' => true,
                                                                        'related_fields' => array('time_start')),
											'set_accept_links'=> array('width'    => '10', 
																	   'label'    => translate('LBL_ACCEPT_THIS', 'Meetings'),
																	   'sortable' => false,
																	    'related_fields' => array('status'),
																		'default' => true),
                                                  'status' => array('width'   => '8', 
                                                                    'label'   => 'LBL_STATUS',
																	'default'  => true),
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
