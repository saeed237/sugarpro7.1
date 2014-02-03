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


$dictionary['Styleguide'] = array(
    'table' => 'styleguide',
    'fields' => array (
        'parent_type' => array(
            'name'=>'parent_type',
            'vname'=>'LBL_PARENT_TYPE',
            'type' =>'parent_type',
            'dbType' => 'varchar',
            'group'=>'parent_name',
            'options'=> 'parent_type_display',
            'len'=> '255',
            'studio' => array('wirelesslistview'=>false),
            'comment' => 'Sugar module the Note is associated with',
        ),
        'parent_id' => array(
            'name'=>'parent_id',
            'vname'=>'LBL_PARENT_ID',
            'type'=>'id',
            'required'=>false,
            'reportable'=>true,
            'comment' => 'The ID of the Sugar item specified in parent_type',
        ),
        'description' => array (
            'name' => 'description',
            'vname' => 'LBL_NOTE_STATUS',
            'type' => 'text',
            'comment' => 'Full text of the note',
        ),
        'parent_name' => array(
            'name'=> 'parent_name',
            'parent_type'=>'record_type_display' ,
            'type_name'=>'parent_type',
            'id_name'=>'parent_id', 'vname'=>'LBL_RELATED_TO',
            'type'=>'parent',
            'source'=>'non-db',
            'options'=> 'record_type_display_notes',
            'studio' => true,
        ),
        'file_mime_type' => array (
            'name' => 'file_mime_type',
            'vname' => 'LBL_FILE_MIME_TYPE',
            'type' => 'varchar',
            'len' => '100',
            'comment' => 'Attachment MIME type',
            'importable' => false,
        ),
        'file_url'=> array(
            'name'=>'file_url',
            'vname' => 'LBL_FILE_URL',
            'type'=>'varchar',
            'source'=>'non-db',
            'reportable'=>false,
            'comment' => 'Path to file (can be URL)',
            'importable' => false,
        ),
        'filename' => array (
            'name' => 'filename',
            'vname' => 'LBL_FILENAME',
            'type' => 'file',
            'dbType' => 'varchar',
            'len' => '255',
            'reportable'=>true,
            'comment' => 'File name associated with the note (attachment)',
            'importable' => false,
        ),
        'currency_id' => array(
            'name' => 'currency_id',
            'dbType' => 'id',
            'vname' => 'LBL_CURRENCY_ID',
            'type' => 'currency_id',
            'function' => array('name' => 'getCurrencyDropDown', 'returns' => 'html'),
            'required' => false,
            'reportable' => false,
            'default'=>'-99',
            'comment' => 'Currency of the product',
        ),
        'list_price' =>  array(
            'name' => 'list_price',
            'vname' => 'LBL_LIST_PRICE',
            'type' => 'currency',
            'len' => '26,6',
            'audited' => true,
            'comment' => 'List price of product ("List" in Quote)',
        ),
    ),
    'indices' => array (

    ),
    'relationships' => array (

    ),
    'acls' => array(
        'SugarACLAdminOnly' => true,
    ),
);

if (!class_exists('VardefManager')){
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('Styleguide','Styleguide', array('person', 'default', 'assignable'));
