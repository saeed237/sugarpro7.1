<?php
//FILE SUGARCRM flav=ent
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$viewdefs['Bugs']['portal']['view']['tutorial'] = array(
    'records' => array(
        'version' => 1,
        'intro' => 'LBL_PORTAL_TOUR_RECORDS_INTRO',
        'content' => array(
            array(
                'text' => 'LBL_PORTAL_TOUR_RECORDS_PAGE',
            ),
            array(
                'name' => '.dataTables_filter',
                'text' => 'LBL_PORTAL_TOUR_RECORDS_FILTER',
                'full' => true,
            ),
            array(
                'name' => '.dataTables_filter',
                'text' => 'LBL_PORTAL_TOUR_RECORDS_FILTER_EXAMPLE',
                'full' => true,
            ),
            array(
                'name' => '.btn-primary[name="create_button"]',
                'text' => 'LBL_PORTAL_TOUR_RECORDS_CREATE',
                'full' => true,
            ),
            array(
                'name' => '.routeLink.[data-route="#Bugs"]',
                'text' => 'LBL_PORTAL_TOUR_RECORDS_RETURN',
                'full' => true,
            ),
        )
    ),
);
