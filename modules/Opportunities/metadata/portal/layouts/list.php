<?php
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


$viewdefs['Opportunities']['portal']['layout']['list'] = array(
    'type' => 'simple',
    'components' =>
    array(
        1 => array(
            'layout' => array(
                'type' => 'fluid',
                'components' => array(
                    array(
                        "size" => 2,
                        "layout" => array(
                            'type' => 'rows',
                            'components' => array(
                                array(
                                    'view' => 'tree',
                                )
                            )
                        )
                    ),
                    array(
                        "size" => 10,
                        "view" => "grid"
                    )
                )
            )
        ),
    ),
);