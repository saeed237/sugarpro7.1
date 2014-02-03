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

$viewdefs['Documents']['mobile']['view']['list'] = array(
    'panels' => array (
        array (
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                array(
                    'name' => 'name',
                    'label' => 'LBL_DOC_NAME',
                    'default' => true,
                    'enabled' => true,
                    'width' => '10%',
                ),
                array(
                    'name' => 'active_date',
                    'label' => 'LBL_DATE',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'category_id',
                    'label' => 'LBL_CATEGORY',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
            ),
    	),
	),
);