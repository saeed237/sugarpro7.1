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

$viewdefs['WebLogicHooks']['base']['layout']['record'] = array(
    'components' => array(
        array(
            'layout' => array(
                'components' => array(
                    array(
                        'layout' => array(
                            'components' => array(
                                array(
                                    'view' => 'record',
                                    'primary' => true,
                                ),
                                array(
                                    'layout' => 'extra-info',
                                ),
                            ),
                            'type' => 'simple',
                            'name' => 'main-pane',
                            'span' => 8,
                        ),
                    ),
                    array(
                        'layout' => array(
                            'components' => array(
                                array(
                                    'layout' => 'sidebar',
                                ),
                            ),
                            'type' => 'simple',
                            'name' => 'side-pane',
                            'span' => 4,
                        ),
                    ),
                    array(
                        'layout' => array(
                            'components' => array(
                                array(
                                    'layout' => 'dashboard',
                                    'context' => array(
                                        'forceNew' => true,
                                        'module' => 'Home',
                                    ),
                                ),
                            ),
                            'type' => 'simple',
                            'name' => 'dashboard-pane',
                            'span' => 4,
                        ),
                    ),
                    array(
                        'layout' => array(
                            'components' => array(
                                array(
                                    'layout' => 'preview',
                                ),
                            ),
                            'type' => 'simple',
                            'name' => 'preview-pane',
                            'span' => 8,
                        ),
                    ),
                ),
                'type' => 'default',
                'name' => 'sidebar',
                'span' => 12,
            ),
        ),
    ),
    'type' => 'simple',
    'name' => 'base',
    'span' => 12,
);
