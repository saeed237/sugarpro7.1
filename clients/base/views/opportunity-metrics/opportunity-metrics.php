<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

$viewdefs['base']['view']['opportunity-metrics'] = array(
    'dashlets' => array(
        array(
            'name' => 'LBL_DASHLET_OPPORTUNITY_NAME',
            'description' => 'LBL_DASHLET_OPPORTUNITY_DESCRIPTION',
            'filter' => array(
                'module' => array(
                    'Accounts',
                ),
                'view' => 'record'
            ),
            'config' => array(),
            'preview' => array(),
        ),
    ),
);
