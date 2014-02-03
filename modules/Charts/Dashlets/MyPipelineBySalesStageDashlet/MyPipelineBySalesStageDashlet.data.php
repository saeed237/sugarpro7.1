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




$dashletData['MyPipelineBySalesStageDashlet']['searchFields'] = array(
        'mypbss_date_start' => array(
                'name'  => 'mypbss_date_start',
                'vname' => 'LBL_CLOSE_DATE_START',
                'type'  => 'datepicker',
            ),
        'mypbss_chart_type' => array(
                'name'  => 'mypbss_chart_type',
                'vname' => 'LBL_CHART_TYPE',
                'type'  => 'singleenum',
            ),
        'mypbss_date_end' => array(
                'name'  => 'mypbss_date_end',
                'vname' => 'LBL_CLOSE_DATE_END',
                'type'  => 'datepicker',
            ),
        'mypbss_sales_stages' => array(
                'name'  => 'mypbss_sales_stages',
                'vname' => 'LBL_SALES_STAGES',
                'type'  => 'enum',
            ),
        
        );
?>
