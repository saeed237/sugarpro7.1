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


// Hack for ActivityStream. MetadataManager does not supporrt submodules yet.

$viewdefs['Activities']['base']['filter']['activity'] = array(
    'create'               => false,
    'quicksearch_field'    => array(),
    'quicksearch_priority' => 2,
    'filters'              => array(
        array(
            'id'                => 'all_records',
            'name'              => 'LBL_LISTVIEW_FILTER_ALL',
            'filter_definition' => array(),
            'editable'          => false
        ),
        array(
            'id'                => 'messages_for_create',
            'name'              => 'LBL_ACTIVITY_CREATE',
            'filter_definition' => array(
                '$or' => array(
                    array('activity_type' => 'create'),
                    array('activity_type' => 'attach'),
                ),
            ),
            'editable'          => false
        ),
        array(
            'id'                => 'messages_for_update',
            'name'              => 'LBL_ACTIVITY_UPDATE',
            'filter_definition' => array(
                'activity_type' => 'update',
            ),
            'editable'          => false
        ),
        array(
            'id'                => 'messages_for_link',
            'name'              => 'LBL_ACTIVITY_LINK',
            'filter_definition' => array(
                'activity_type' => 'link',
            ),
            'editable'          => false
        ),
        array(
            'id'                => 'messages_for_unlink',
            'name'              => 'LBL_ACTIVITY_UNLINK',
            'filter_definition' => array(
                'activity_type' => 'unlink',
            ),
            'editable'          => false
        ),
        array(
            'id'                => 'messages_for_post',
            'name'              => 'LBL_ACTIVITY_POST',
            'filter_definition' => array(
                'activity_type' => 'post',
            ),
            'editable'          => false
        ),
    ),
);
