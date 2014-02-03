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

$viewdefs['base']['layout']['dupecheck'] = array(
    'components' =>
    array(
        array(
            'layout' => array(
                'type' => 'filterpanel',
                'span' => 12,
                'components' => array(
                    array(
                        'layout' => 'dupecheck-filter',
                        'name' => 'filter',
                        'targetEl' => '.filter',
                        'position' => 'prepend',
                        'components' => array(
                            array(
                                'view' => 'filter-quicksearch'
                            ),
                        )
                    ),
                    array(
                        'view' => 'filter-actions',
                        'targetEl' => '.filter-options'
                    ),
                    array(
                        'view' => 'filter-rows',
                        'targetEl' => '.filter-options'
                    ),
                )
            ),
            'name' => 'filterpanel'
        ),
        array(
            'name' => 'dupecheck-list',
            'view' => 'dupecheck-list',
            'primary' => true,
        ),
        array(
            'view' => 'list-bottom',
        ),
    ),
    'type' => 'dupecheck',
    'span' => 12,
);
