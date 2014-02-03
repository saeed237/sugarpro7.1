<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$dictionary['users_password_link'] = array(
    'table' => 'users_password_link',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
        ) ,
        'username' => array(
            'name' => 'username',
            'vname' => 'LBL_USERNAME',
            'type' => 'varchar',
            'len' => 36,
        ) ,
        'date_generated' => array(
            'name' => 'date_generated',
            'vname' => 'LBL_DATE_ENTERED',
            'type' => 'datetime',
        ) ,
        'deleted' => array(
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'required' => false,
            'reportable' => false,
        ) ,
    ) ,
    'indices' => array(
        array(
            'name' => 'users_password_link_pk',
            'type' => 'primary',
            'fields' => array(
                'id'
            )
        ) ,
        array(
            'name' => 'idx_username',
            'type' => 'index',
            'fields' => array(
                'username'
            )
        )
    ) ,
);

?>