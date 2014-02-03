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


$viewdefs['KBDocuments']['portal']['view']['list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                 array (
                    'name' => 'kbdocument_name',
                    'width' => '45%',
                    'label' => 'LBL_NAME',
                    'link' => true,
                    'bwcLink' => false,
                    'enabled' => true,
                    'default' => true,
                ),
                array (
                    'name' => 'active_date',
                    'label' => 'LBL_DOC_ACTIVE_DATE',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array (
                    'name' => 'exp_date',
                    'label' => 'LBL_DOC_EXP_DATE',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array (
                    'name' => 'date_entered',
                    'label' => 'LBL_DATE_ENTERED',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                    'readonly' => true,
                ),
                array (
                    'name' => 'kbdocument_revision_number',
                    'label' => 'LBL_KBDOCUMENT_REVISION_NUMBER',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
            ),
        ),
    ),
);
