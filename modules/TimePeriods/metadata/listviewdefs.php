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




$listViewDefs['TimePeriods'] = array(
    'NAME' => array(
        'width' => '30', 
        'label' => 'LBL_TP_NAME', 
        'link' => true,
        'default' => true),
    'START_DATE' => array(
        'width' => '30', 
        'label' => 'LBL_TP_START_DATE', 
        'default' => true),
    'END_DATE' => array(
        'width' => '20', 
        'label' => 'LBL_TP_END_DATE', 
        'default' => true),
    'IS_FISCAL_YEAR' => array(
        'width' => '20', 
        'label' => 'LBL_TP_IS_FISCAL_YEAR', 
        'default' => true),
);
