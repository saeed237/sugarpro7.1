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


$viewdefs['<module_name>']['base']['filter']['basic'] = array(
    'create'               => true,
    'quicksearch_field'    => array('name'),
    'quicksearch_priority' => 1,
    'filters'              => array(
        array(
            'id'                => 'all_records',
            'name'              => 'LBL_LISTVIEW_FILTER_ALL',
            'filter_definition' => array(),
            'editable'          => false
        ),
        array(
            'id'                => 'assigned_to_me',
            'name'              => 'LBL_ASSIGNED_TO_ME',
            'filter_definition' => array(
                '$owner' => '',
            ),
            'editable'          => false
        ),
        array(
            'id'                => 'favorites',
            'name'              => 'LBL_FAVORITES',
            'filter_definition' => array(
                '$favorite' => '',
            ),
            'editable'          => false
        ),
        array(
            'id'                => 'recently_viewed',
            'name'              => 'LBL_RECENTLY_VIEWED',
            'filter_definition' => array(
                '$tracker' => '-7 DAY',
            ),
            'editable'          => false
        ),
        array(
            'id'                => 'recently_created',
            'name'              => 'LBL_NEW_RECORDS',
            'filter_definition' => array(
                'date_entered' => array(
                    '$dateRange' => 'last_7_days',
                ),
            ),
            'editable'          => false
        ),
    ),
);
