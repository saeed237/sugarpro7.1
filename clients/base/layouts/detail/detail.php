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

$viewdefs['base']['layout']['detail'] = array(
    'type' => 'simple',
    'components' =>
    array(
        array(
            'view' => 'subnavdetail',
        ),
        array(
            'layout' =>
            array(
                'type' => 'fluid',
                'components' =>
                array(
                    array(
                        'layout' =>
                        array(
                            'type' => 'simple',
                            'span' => 7,
                            'components' =>
                            array(
                                array(
                                    'view' => 'detail',
                                ),
                                array(
                                    'view' => 'activity',
                                    'context' =>
                                    array(
                                        'link' => 'notes',
                                    ),
                                ),
                                array(
                                    'view' => 'editmodal',
                                    'context' =>
                                    array(
                                        'link' => 'notes',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    array(
                        'layout' =>
                        array(
                            'type' => 'simple',
                            'span' => 5,
                            'components' =>
                            array(
                                array(
                                    'view' => 'subdetail',
                                    'context' =>
                                    array(
                                        'link' => 'notes',
                                    ),
                                ),
                                array(
                                    'view' => 'subdetail',
                                    'context' =>
                                    array(
                                        'link' => 'contacts',
                                    ),
                                ),
                                array(
                                    'view' => 'subdetail',
                                    'context' =>
                                    array(
                                        'link' => 'accounts',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
