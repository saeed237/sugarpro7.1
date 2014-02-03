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

$listViewDefs['ProductCategories'] = array(
    'name' => array(
        'label' => 'LBL_LIST_NAME',
        'width' => '25',
        'link' => true,
        'default' => true,
    ),
    'parent_name' => array(
        'label' => 'LBL_PARENT_CATEGORY',
        'width' => '25',
        'link' => true,
        'default' => true,
    ),
    'description' => array(
        'label' => 'LBL_DESCRIPTION',
        'width' => '50',
        'default' => true,
    ),
    'list_order' => array(
        'label' => 'LBL_LIST_ORDER',
        'width' => '4',
        'default' => true,
    ),
);
