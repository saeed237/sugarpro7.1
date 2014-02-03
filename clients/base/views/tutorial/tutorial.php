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

$viewdefs['base']['view']['tutorial'] = array(
    'records' => array(
        'version' =>1,
        'intro' =>'LBL_TOUR_LIST_INTRO',
        'content' => array(
            array(
                'name' => '.drawerTrig',
                'text' => 'LBL_TOUR_LIST_INT_TOGGLE',
                'full' => true,
                'horizAdj' =>-11,
                'vertAdj' => -13,
            ),
            array(
                'name' => '.choice-related',
                'text' => 'LBL_TOUR_LIST_FILTER1',
                'full' => true,
                'vertAdj' => -15,
            ),
            array(
                'name' => '.choice-filter',
                'text' => 'LBL_TOUR_LIST_FILTER2',
                'full' => true,
                'vertAdj' => -15,
            ),
            array(
                'name' => '.filter-view .search-name',
                'text' => 'LBL_TOUR_LIST_FILTER_SEARCH',
                'full' => true,
                'vertAdj' => -15,
            ),
            array(
                'name' => '[data-view="activitystream"]',
                'text' => 'LBL_TOUR_LIST_ACTIVTYSTREAMLIST_TOGGLE',
                'full' => true,
                'horizAdj' =>5,
                'vertAdj' => -10,
            ),
            array(
                'name' => '[data-event="list:preview:fire"]',
                'text' => 'LBL_TOUR_LIST_FILTER_PREVIEW',
                'full' => true,
                'vertAdj' => -15,
            ),
        )
    ),
    'record' => array(
        'version' =>1,
        'intro' =>'LBL_TOUR_RECORD_INTRO',
        'content' => array(
            array(
                'name' => '[data-fieldname="first_name"]',
                'text' => 'LBL_TOUR_RECORD_INLINEEDIT',
                'full' => true,
                'horizAdj' =>-15,
                'vertAdj' => -13,
            ),
            array(
                'name' => '[data-fieldname="name"]',
                'text' => 'LBL_TOUR_RECORD_INLINEEDIT',
                'full' => true,
                'horizAdj' =>-11,
                'vertAdj' => -13,
            ),
            array(
                'name' => '[name="edit_button"]',
                'text' => 'LBL_TOUR_RECORD_ACTIONS',
                'full' => true,
                'horizAdj' =>-1,
                'vertAdj' => -13,
            ),
            array(
                'name' => '.record .record-cell',
                'text' => 'LBL_TOUR_RECORD_INLINEEDITRECORD',
                'full' => true,
                'horizAdj' =>-11,
                'vertAdj' => -13,
            ),
            array(
                'name' => '.show-hide-toggle',
                'text' => 'LBL_TOUR_RECORD_SHOWMORE',
                'full' => true,
                'horizAdj' =>-11,
                'vertAdj' => -13,
            ),
            array(
                'name' => '[data-view="subpanel"]',
                'text' => 'LBL_TOUR_RECORD_TOGGLEACTIVITIES',
                'full' => true,
                'horizAdj' =>-11,
                'vertAdj' => -13,
            ),
            array(
                'name' => '.preview-headerbar .dropdown-toggle',
                'text' => 'LBL_TOUR_RECORD_DASHBOARDNAME',
                'full' => true,
                'horizAdj' =>-11,
                'vertAdj' => -13,
            ),
            array(
                'name' => '.preview-headerbar .btn-toolbar',
                'text' => 'LBL_TOUR_RECORD_DASHBOARDACTIONS',
                'full' => true,
                'horizAdj' =>-11,
                'vertAdj' => -13,
            ),
            array(
                'name' => '.dashlet-cell .icon-cog',
                'text' => 'LBL_TOUR_RECORD_DASHLETCOG',
                'full' => true,
                'horizAdj' =>-18,
                'vertAdj' => -18,
            ),
        )
    ),
);
