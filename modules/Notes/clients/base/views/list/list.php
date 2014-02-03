<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$viewdefs['Notes']['base']['view']['list'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array (
                    'name' => 'name',
                    'width' => '40%',
                    'label' => 'LBL_LIST_SUBJECT',
                    'link' => true,
                    'enabled' => true,
                    'default' => true,
                ),
                array (
                    'name' => 'contact_name',
                    'width' => '20%',
                    'label' => 'LBL_LIST_CONTACT',
                    'link' => true,
                    'id' => 'CONTACT_ID',
                    'module' => 'Contacts',
                    'enabled' => true,
                    'default' => true,
                    'sortable' => false,
                    'ACLTag' => 'CONTACT',
                    'related_fields' =>
                    array (
                        'contact_id',
                    ),
                ),
                array (
                    'name' => 'parent_name',
                    'width' => '20%',
                    'label' => 'LBL_LIST_RELATED_TO',
                    'dynamic_module' => 'PARENT_TYPE',
                    'id' => 'PARENT_ID',
                    'link' => true,
                    'enabled' => true,
                    'default' => true,
                    'sortable' => false,
                    'ACLTag' => 'PARENT',
                    'related_fields' =>
                    array (
                        'parent_id',
                        'parent_type',
                    ),
                ),
                array (
                    'name' => 'filename',
                    'width' => '20%',
                    'label' => 'LBL_LIST_FILENAME',
                    'enabled' => true,
                    'default' => true,
                    'type' => 'file',
                    'related_fields' =>
                    array (
                        'file_url',
                        'id',
                        'file_mime_type',
                    ),
                    'displayParams' =>
                    array(
                        'module' => 'Notes',
                    ),
                ),
                array (
                    'name' => 'created_by_name',
                    'type' => 'relate',
                    'label' => 'LBL_CREATED_BY',
                    'width' => '10%',
                    'enabled' => true,
                    'default' => true,
                    'sortable' => false,
                    'related_fields' =>  array ( 'created_by' ),
                ),
            ),

        ),
    ),
);
