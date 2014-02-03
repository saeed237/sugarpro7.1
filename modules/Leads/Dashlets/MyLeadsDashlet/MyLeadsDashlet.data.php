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
$dashletData['MyLeadsDashlet']['searchFields'] = array('date_entered'     => array('default' => ''),
													   'title' => array('default' => ''),
													   'primary_address_country' => array('default' => ''),
                                                       //'status'           => array('default' => array('New', 'Assigned', 'In Process')), 
                                                       'team_id'          => array('default' => '', 'label'=>'LBL_TEAMS'),
													   'assigned_user_id' => array('type'    => 'assigned_user_name',
																				   'label'   => 'LBL_ASSIGNED_TO',
                                                                                   'default' => $current_user->name));
 
$dashletData['MyLeadsDashlet']['columns'] = array('name' => array('width'          => '30', 
                                                                  'label'          => 'LBL_NAME',
                                                                  'link'           => true,
                                                                  'default'        => true,
                                                                  'related_fields' => array('first_name', 'last_name', 'salutation')), 
                                                  'title' => array('width' => '20',
                                                                   'label' => 'LBL_TITLE',
																   'default' => true),
                                                  'lead_source' => array('width' => '10',
                                                                         'label' => 'LBL_LEAD_SOURCE'),
                                                  'status' => array('width' => '10',
                                                                    'label' => 'LBL_STATUS'),
                                                  'phone_work' => array('width'   => '20',
                                                                        'label'   => 'LBL_OFFICE_PHONE',
                                                                        'default' => true),
                                                  'email1' => array('width' => '30',
                                                                    'label' => 'LBL_EMAIL_ADDRESS',
                                                                    'sortable' => false,
                                                                    'customCode' => '{$EMAIL1_LINK}{$EMAIL1}</a>',
																	'default' => true),
                                                  'account_name' => array('width' => '40', 
												  						  'label' => 'LBL_ACCOUNT_NAME'),
                                                  'phone_home' => array('width' => '10',
                                                                        'label' => 'LBL_HOME_PHONE'),
                                                  'phone_mobile' => array('width' => '10',
                                                                          'label' => 'LBL_MOBILE_PHONE'),
                                                  'phone_other' => array('width' => '10',
                                                                         'label' => 'LBL_OTHER_PHONE'),
                                                  'date_entered' => array('width'   => '15', 
                                                                          'label'   => 'LBL_LIST_DATE_ENTERED'),
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
