<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ('Company') that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

$viewdefs['base']['view']['planned-activities'] = array(
    'dashlets' => array(
        array(
            'name' => 'LBL_PLANNED_ACTIVITIES_DASHLET',
            'description' => 'LBL_PLANNED_ACTIVITIES_DASHLET_DESCRIPTION',
            'config' => array(
                'limit' => '10',
                'date' => 'today',
                'visibility' => 'user',
            ),
            'preview' => array(
                'limit' => '10',
                'date' => 'today',
                'visibility' => 'user',
            ),
            'filter' => array(
                'module' => array(
                    'Accounts',
                    'Bugs',
                    'Cases',
                    'Contacts',
                    'Home',
                    'Leads',
                    'Opportunities',
                    'Prospects',
                ),
                'view' => 'record',
            ),
        ),
    ),
    'custom_toolbar' => array(
        'buttons' => array(
            array(
                'type' => 'actiondropdown',
                'no_default_action' => true,
                'icon' => 'icon-plus',
                'buttons' => array(
                    array(
                        'type' => 'dashletaction',
                        'action' => 'createRecord',
                        'params' => array(
                            'link' => 'meetings',
                            'module' => 'Meetings',
                        ),
                        'label' => 'LBL_SCHEDULE_MEETING',
                        'acl_action' => 'create',
                        'acl_module' => 'Meetings',
                    ),
                    array(
                        'type' => 'dashletaction',
                        'action' => 'createRecord',
                        'params' => array(
                            'link' => 'calls',
                            'module' => 'Calls',
                        ),
                        'label' => 'LBL_SCHEDULE_CALL',
                        'acl_action' => 'create',
                        'acl_module' => 'Calls',
                    ),
                ),
            ),
            array(
                'dropdown_buttons' => array(
                    array(
                        'type' => 'dashletaction',
                        'action' => 'editClicked',
                        'label' => 'LBL_DASHLET_CONFIG_EDIT_LABEL',
                    ),
                    array(
                        'type' => 'dashletaction',
                        'action' => 'refreshClicked',
                        'label' => 'LBL_DASHLET_REFRESH_LABEL',
                    ),
                    array(
                        'type' => 'dashletaction',
                        'action' => 'toggleClicked',
                        'label' => 'LBL_DASHLET_MINIMIZE',
                        'event' => 'minimize',
                    ),
                    array(
                        'type' => 'dashletaction',
                        'action' => 'removeClicked',
                        'label' => 'LBL_DASHLET_REMOVE_LABEL',
                    ),
                ),
            ),
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'date',
                    'label' => 'LBL_DASHLET_CONFIGURE_FILTERS',
                    'type' => 'enum',
                    'options' => 'planned_activities_filter_options',
                ),
                array(
                    'name' => 'visibility',
                    'label' => 'LBL_DASHLET_CONFIGURE_MY_ITEMS_ONLY',
                    'type' => 'enum',
                    'options' => 'planned_activities_visibility_options',
                ),
                array(
                    'name' => 'limit',
                    'label' => 'LBL_DASHLET_CONFIGURE_DISPLAY_ROWS',
                    'type' => 'enum',
                    'options' => 'planned_activities_limit_options',
                )
            ),
        ),
    ),
    'tabs' => array(
        array(
            'active' => true,
            'filter_applied_to' => 'date_start',
            'filters' => array(
                'status' => array('$not_equals' => 'Held'),
            ),
            'link' => 'meetings',
            'module' => 'Meetings',
            'order_by' => 'date_start:asc',
            'record_date' => 'date_start',
            'include_child_items' => true,
            'invitation_actions' => array(
                'name' => 'accept_status_users',
                'type' => 'invitation-actions',
            ),
            'overdue_badge' => array(
                'name' => 'date_start',
                'type' => 'overdue-badge',
            ),
        ),
        array(
            'filter_applied_to' => 'date_start',
            'filters' => array(
                'status' => array('$not_equals' => 'Held'),
            ),
            'link' => 'calls',
            'module' => 'Calls',
            'order_by' => 'date_start:asc',
            'record_date' => 'date_start',
            'include_child_items' => true,
            'invitation_actions' => array(
                'name' => 'accept_status_users',
                'type' => 'invitation-actions',
            ),
            'overdue_badge' => array(
                'name' => 'date_start',
                'type' => 'overdue-badge',
            ),
        ),
    ),
);
