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




global $current_user, $app_strings;

$dashletData['MyEmailsDashlet']['searchFields'] = array(
												 	   'date_sent'  => array('default' => ''),
                                                       'name'  => array('default' => ''),
													   //'from_addr_name' => array('default' => ''),
                                                       //'team_id'          => array('default' => '', 'label'=>'LBL_TEAMS'),
                                                       'assigned_user_id'   => array('default' => ''),
                                                       );
$dashletData['MyEmailsDashlet']['columns'] = array(
                                                   'from_addr' => array('width'   => '15',
                                                                       'label'   => 'LBL_FROM',
                                                                       'default' => true),
												   'name' => array('width'   => '40',
                                                                   'label'   => 'LBL_SUBJECT',
                                                                   'link'    => true,
                                                                   'default' => true),
                                                   'to_addrs' => array('width'   => '15',
                                                                         'label'   => 'LBL_TO_ADDRS',
                                                                         'default' => false),
                                                   'assigned_user_name' => array('width'   => '15',
                                                                         'label'   => 'LBL_LIST_ASSIGNED',
                                                                         'default' => false),

                                                   'team_name' => array('width'   => '15',
                                                                        'label'   => 'LBL_LIST_TEAM',
                                                                        'sortable' => false),
                                                   'date_sent' => array('width'   => '15',
                                                                         'label'   => 'LBL_DATE_SENT',
                                                                         'default' => true,
                                                                         'defaultOrderColumn' => array('sortOrder' => 'ASC')
                                                                         ),
                                                  'date_entered' => array('width'   => '15',
                                                                          'label'   => 'LBL_DATE_ENTERED'),
                                                  'date_modified' => array('width'   => '15',
                                                                           'label'   => 'LBL_DATE_MODIFIED'),
                                                  'quick_reply' => array('width'   => '15',
                                                                        'label'   => '',
                                                                        'sortable' => false,
                                                                        'default' => true),
                                                   'create_related' => array('width'   => '25',
                                                                        'label'   => '',
                                                                        'sortable' => false,
                                                                        'default' => true),
                                                                        );

?>
