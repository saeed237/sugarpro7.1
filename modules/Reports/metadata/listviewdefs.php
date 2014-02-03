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




$listViewDefs['Reports'] = array(
    'NAME' => array(
        'width' => '40', 
        'label' => 'LBL_REPORT_NAME', 
        'customCode' => '<span id="obj_{$ID}"><a  href="index.php?action=ReportCriteriaResults&module=Reports&page=report&id={$ID}">{$NAME}</a></span>',
        'default' => true), 
    'MODULE' => array(
        'width' => '15',
        'label' => 'LBL_MODULE',
        'default' => true),
    'REPORT_TYPE_TRANS' => array(
        'width' => '15', 
        'label' => 'LBL_REPORT_TYPE',
        'default' => true,
        'orderBy' => 'report_type',
        'related_fields' => array('report_type'),
    ),
    'TEAM_NAME' => array(
        'width' => '2', 
        'label' => 'LBL_LIST_TEAM',
        'default' => false,
        'related_fields' => array('team_id'),
        'orderBy' => 'team_id'
        ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '2', 
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
        ),
        
     'IS_SCHEDULED' => array(
        'width' => '10',
        'label' => 'LBL_SCHEDULE_REPORT',
        'default' => true,
        'related_fields' => array('active', 'schedule_id'),
        'sortable' => false
      ),
    'LAST_RUN_DATE' => array(
        'width' => '15', 
        'label' => 'LBL_REPORT_LAST_RUN_DATE',
        'default' => true,
        'sortable' => true,
        'related_fields' => array('active', 'report_cache.date_modified'),
    ),
    'DATE_ENTERED' => array(
        'width' => '14',
        'orderBy' => 'saved_reports.date_entered',
        'sortOrder' => 'desc',
        'label' => 'LBL_DATE_ENTERED',
        'default' => true),

/*    'IS_PUBLISHED' => array(
        'width' => '2',
        'label' => 'LBL_LIST_PUBLISHED',
        'align'   => 'right',
        'default' => true),*/
);
?>
