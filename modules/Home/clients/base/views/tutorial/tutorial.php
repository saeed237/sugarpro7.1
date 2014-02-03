<?php
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

$viewdefs['Home']['base']['view']['tutorial'] = array(
    'record' => array(
        'version' =>1,
        'intro' => 'LBL_TOUR_INTRO',
        'content' => array(
            array(
                'name' => '[href=#Home]',
                'text' => 'LBL_TOUR_CUBE',
                'full' => true,
            ),
            array(
                'name' => '.routeLink.[data-route="#Accounts"]',
                'text' => 'LBL_TOUR_NAV_BAR',
                'full' => true,
            ),
            array(
                'name' => '.search-query',
                'text' => 'LBL_TOUR_SEARCH',
                'full' => true,
            ),
            array(
                'name' => '#notificationDrop',
                'text' => 'LBL_TOUR_NOTIFICATIONS',
                'full' => true,
                'horizAdj'=> -15,
                'vertAdj'=> -5,
            ),
            array(
                'name' => '#userActions',
                'text' => 'LBL_TOUR_AVATAR',
                'full' => true,
            ),
            array(
                'name' => '#createList',
                'text' => 'LBL_TOUR_ADD',
                'full' => true,
            ),
            array(
                'name' => '#tour',
                'text' => 'LBL_TOUR_TOUR',
                'full' => true,
            ),
        )
    ),
);
