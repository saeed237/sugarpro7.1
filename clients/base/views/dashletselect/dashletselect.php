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
$viewdefs['base']['view']['dashletselect'] = array(
    'template' => 'filtered-list',
    'panels' => array(
        array(
            'fields' => array(
                array(
                    'label' => 'LBL_DASHLET_CONFIGURE_TITLE',
                    'name' => 'title',
                    'type' => 'text',
                    'filter' => 'startsWith',
                    'sortable' => true,
                ),
                array(
                    'label' => 'LBL_DESCRIPTION',
                    'name' => 'description',
                    'type' => 'text',
                    'filter' => 'contains',
                    'sortable' => true,
                ),
                array(
                    'type' => 'rowaction',
                    'name' => 'select_and_edit',
                    'label' => 'LBL_LISTVIEW_SELECT_AND_EDIT',
                    'event' => 'dashletlist:select-and-edit',
                    'css_class' => 'btn-invisible btn-link',
                    'width' => '10%',
                    'sortable' => false,
                ),
                array(
                    'type' => 'rowaction',
                    'tooltip' => 'LBL_PREVIEW',
                    'event' => 'dashletlist:preview:fire',
                    'css_class' => 'btn',
                    'icon' => 'icon-eye-open',
                    'width' => '7%',
                    'sortable' => false,
                ),
            ),
        ),
    ),
);
