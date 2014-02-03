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

/**
 * Define the before_save hook that will check to make sure that opportunity_name and account_name and product_name
 * are all empty before saving if their related_ids are empty
 */
$hook_array['before_save'][] = array(
    1,
    'checkRelatedName',
    'modules/ForecastWorksheets/ForecastWorksheetHooks.php',
    'ForecastWorksheetHooks',
    'checkRelatedName',
);
