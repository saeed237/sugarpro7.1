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

$viewdefs['Notifications']['base']['view']['raw'] = array(
    'panels' => array(
        array(
            'fields' => array(
                array(
                    'name' => 'severity',
                    'type' => 'severity',
                    'css_class' => 'level',
                ),
                array(
                    'name' => 'name',
                    'css_class' => 'name',
                ),
                array(
                    'name' => 'date_entered',
                    'css_class' => 'pull-right date',
                ),
                // FIXME: this should be uncommented when SC-1143 gets done
                //  array(
                //  'type' => 'rowaction',
                //  'tooltip' => 'LBL_PREVIEW',
                //  'event' => 'list:preview:fire',
                //  'icon' => 'icon-eye-open',
                //  'acl_action' => 'view',
                //  ),
            ),
        ),
    ),
);
