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

$dashletData['MyTasksDashlet']['searchFields'] = array('name'           => array('default' => ''),
													   'priority'       => array('default' => ''),
                                                       'status'         => array('default' => array('Not Started', 'In Progress', 'Pending Input')),
                                                       'date_entered'   => array('default' => ''),
                                                       'date_start'       => array('default' => ''),                                                          
                                                       'date_due'       => array('default' => ''),
                                                       'team_id'          => array('default' => '', 'label' => 'LBL_TEAMS'),
                                                       'assigned_user_id' => array('type'    => 'assigned_user_name',
																				   'label'   => 'LBL_ASSIGNED_TO', 
                                                                                   'default' => $current_user->name));
$dashletData['MyTasksDashlet']['columns'] = array('set_complete' => array('width'    => '1', 
                                                                          'label'    => 'LBL_LIST_CLOSE',
                                                                          'default'  => true,
                                                                          'sortable' => false),
                                                   'name' => array('width'   => '40', 
                                                                   'label'   => 'LBL_SUBJECT',
                                                                   'link'    => true,
                                                                   'default' => true),
                                                  'parent_name' => array('width' => '30', 
                                                                         'label' => 'LBL_LIST_RELATED_TO',
                                                                         'sortable' => false,
                                                                         'dynamic_module' => 'PARENT_TYPE',
                                                                         'link' => true,
                                                                         'id' => 'PARENT_ID',
                                                                         'ACLTag' => 'PARENT',
                                                                         'related_fields' => array('parent_id', 'parent_type'),
																		 'default' => true,
																		),
                                                   'priority' => array('width'   => '10',
                                                                       'label'   => 'LBL_PRIORITY',
                                                                       'default' => true),
													'status' => array('width'   => '8', 
                                                                     'label'   => 'LBL_STATUS',
																	 'default' => true),                                                               
                                                   'date_start' => array('width'   => '15', 
                                                                         'label'   => 'LBL_START_DATE',
                                                                         'default' => true),                                                                                                       
                                                   'time_start' => array('width'   => '15', 
                                                                         'label'   => 'LBL_START_TIME',
                                                                         'default' => false),
                                                   'date_due' => array('width'   => '15', 
                                                                       'label'   => 'LBL_DUE_DATE',
                                                                       'default' => true),                               
                                                                     
                                                   'date_entered' => array('width'   => '15', 
                                                                           'label'   => 'LBL_DATE_ENTERED'),
                                                   'date_modified' => array('width'   => '15', 
                                                                           'label'   => 'LBL_DATE_MODIFIED'),    
                                                   'created_by' => array('width'   => '8', 
                                                                         'label'   => $GLOBALS['app_strings']['LBL_CREATED'],
                                                                         'sortable' => false),
                                                   'assigned_user_name' => array('width'   => '8', 
                                                                                 'label'   => 'LBL_LIST_ASSIGNED_USER'),
                                                   'contact_name' => array('width'   => '8', 
                                                                           'label'   => 'LBL_LIST_CONTACT',
																		    'link' =>  true,
																		    'id' => 'CONTACT_ID',//bug # 38712 it gave error on clicking on contacts from
        																    'module' => 'Contacts',//my open tasks dashlet because some of the parameters were not set
        																    'ACLTag' => 'CONTACT',// like id, link etc.
        																    'related_fields' => array('contact_id')),
                                                   'team_name' => array('width'   => '15', 
                                                                        'label'   => 'LBL_LIST_TEAM', 
                                                                        'sortable' => false),
                                                                         );


?>
