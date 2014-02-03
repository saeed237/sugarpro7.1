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

// These are required elements of app list strings. Supports being able to control
// which list items are allowed to be manipulated in the dropdown editor in 
// studio. The items in the required list map to the keys of the app list string
// list.
$app_list_strings_required = array(
    'sales_stage_dom' => array(
        'Closed Won',
        'Closed Lost',
    ),
    'sales_status_dom' => array(
        'Closed Won',
        'Closed Lost',
    ),
);
