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


$dictionary['UserSignature'] = array(
    'table'   => 'users_signatures',
    'fields'  => array(
        'id'             => array(
            'name'     => 'id',
            'vname'    => 'LBL_ID',
            'type'     => 'id',
            'required' => true,
        ),
        'date_entered'   => array(
            'name'     => 'date_entered',
            'vname'    => 'LBL_DATE_ENTERED',
            'type'     => 'datetime',
            'required' => true,
        ),
        'date_modified'  => array(
            'name'     => 'date_modified',
            'vname'    => 'LBL_DATE_MODIFIED',
            'type'     => 'datetime',
            'required' => true,
        ),
        'deleted'        => array(
            'name'       => 'deleted',
            'vname'      => 'LBL_DELETED',
            'type'       => 'bool',
            'required'   => false,
            'reportable' => false,
        ),
        'user_id'        => array(
            'name'  => 'user_id',
            'vname' => 'LBL_USER_ID',
            'type'  => 'varchar',
            'len'   => 36,
        ),
        'name'           => array(
            'name'     => 'name',
            'vname'    => 'LBL_SUBJECT',
            'type'     => 'varchar',
            'required' => false,
            'len'      => '255',
        ),
        'signature'      => array(
            'name'       => 'signature',
            'vname'      => 'LBL_SIGNATURE',
            'type'       => 'text',
            'reportable' => false,
        ),
        'signature_html' => array(
            'name'       => 'signature_html',
            'vname'      => 'LBL_SIGNATURE_HTML',
            'type'       => 'text',
            'reportable' => false,
        ),
        'created_by' => array(
            'name'             => 'created_by',
            'vname'            => 'LBL_CREATED',
            'type'             => 'name',
            'studio'           => false,
            'source'           => 'non-db',
            'fields'           => array('user_id'),
            'db_concat_fields' => array('user_id'),
        ),
    ),
    'indices' => array(
        array(
            'name'   => 'users_signaturespk',
            'type'   => 'primary',
            'fields' => array('id')
        ),
        array(
            'name'   => 'idx_usersig_uid',
            'type'   => 'index',
            'fields' => array('user_id')
        )
    ),
);
