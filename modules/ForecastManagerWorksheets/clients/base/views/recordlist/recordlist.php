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
$viewdefs['ForecastManagerWorksheets']['base']['view']['recordlist'] = array(
    'css_class' => 'forecast-manager-worksheet',
    'favorite' => false,
    'selection' => array(),
    'rowactions' => array(
        'actions' => array(
            /*array(
                'type' => 'rowaction',
                'css_class' => 'btn disabled',
                'tooltip' => 'LBL_PREVIEW',
                'event' => 'list:preview:fire',
                'icon' => 'icon-eye-open',
                'acl_action' => 'view',
            ),*/
            array(
                'type' => 'rowaction',
                'css_class' => 'btn',
                'tooltip' => 'LBL_HISTORY_LOG',
                'event' => 'list:history_log:fire',
                'icon' => 'icon-exclamation-sign',
                'acl_action' => 'view',
            ),
        ),
    ),
);
