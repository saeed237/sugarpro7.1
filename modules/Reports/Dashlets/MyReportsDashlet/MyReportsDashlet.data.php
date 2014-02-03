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

$dashletData['MyReportsDashlet']['searchFields'] = array();
                                                                                           
$dashletData['MyReportsDashlet']['columns'] = array('name' => array('width'   => '40', 
                                                                          'label'   => 'LBL_REPORT_NAME',
                                                                          'customCode'    => '<span id="obj_{$ID}"><a  href="index.php?action=ReportCriteriaResults&module=Reports&page=report&id={$ID}">{$NAME}</a></span>',
                                                                          'default' => true 
                                                                          ), 
                                                          'module' => array('width'  => '30', 
                                                                            'label'   => 'LBL_MODULE',
                                                                             'default' => true),
                                                          'report_type_trans' => array(
                                                                'width' => '30',
                                                                'label' => 'LBL_REPORT_TYPE',
                                                                'default' => true,
                                                                'orderBy' => 'report_type',
                                                                'related_fields' => array('report_type'),
                                                                ),
                                                         /*
                                                          'team_name' => array('width'   => '15', 
                                                                               'label'   => 'LBL_LIST_TEAM',
                                                                               'default' => true,
                                                                               'related_fields' => array('team_id'),
                                                                               'orderBy' => 'team_id'),
                                                          'assigned_user_name' => array('width'   => '8', 
                                                                                        'label'   => 'LBL_LIST_ASSIGNED_USER',
                                                                                        'default' => true,
                                                                                        
                                                                                        'orderBy' => 'assigned_user_id'),
                                                           */
                                                           );
?>
