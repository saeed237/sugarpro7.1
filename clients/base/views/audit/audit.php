<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
$viewdefs['base']['view']['audit'] = array(
    'template' => 'filtered-list',
    'panels' =>
    array(
        array(
            'fields' => array(
                array(
                    'type' => 'fieldtype',
                    'name' => 'field_name',
                    'label' => 'LBL_FIELD_NAME',
                    'sortable' => true,
                    'filter' => 'startsWith',
                ),
                array(
                    'type' => 'base',
                    'name' => 'before',
                    'label' => 'LBL_OLD_NAME',
                    'sortable' => false,
                    'filter' => 'contains',
                ),
                array(
                    'type' => 'base',
                    'name' => 'after',
                    'label' => 'LBL_NEW_VALUE',
                    'sortable' => false,
                    'filter' => 'contains',
                ),
                array(
                    'type' => 'base',
                    'name' => 'created_by_username',
                    'label' => 'LBL_CREATED_BY',
                    'sortable' => true,
                    ),
                array(
                    'type' => 'datetimecombo',
                    'name' => 'date_created',
                    'label' => 'LBL_LIST_DATE',
                    'options' => 'date_range_search_dom',
                    'sortable' => true,
                ),
            ),
        ),
    ),
);
