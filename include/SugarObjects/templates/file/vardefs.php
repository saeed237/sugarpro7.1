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

/*********************************************************************************

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
 $vardefs=array(
  'fields' => array (

  'document_name' =>
  array (
    'name' => 'document_name',
    'vname' => 'LBL_NAME',
    'type' => 'name',
  	'link' => true, // bug 39288 
	'dbType' => 'varchar',
    'len' => '255',
    'required'=>true,
    'unified_search' => true,
    'full_text_search' => array('boost' => 3),
    'duplicate_on_record_copy' => 'always',
  ),

'name'=>
  array(
	'name'=>'name',
    'vname' => 'LBL_NAME',
	'source'=>'non-db',
	'type'=>'varchar',
	'db_concat_fields'=> array(0=>'document_name'),
    'duplicate_on_record_copy' => 'always',
	),

'filename' =>
  array (
    'name' => 'filename',
    'vname' => 'LBL_FILENAME',
    'type' => 'varchar',
    'required'=>true,
	'importable' => 'required',
    'len' => '255',
    'studio' => 'false',
    'duplicate_on_record_copy' => 'always',
  ),
  'file_ext' =>
  array (
    'name' => 'file_ext',
    'vname' => 'LBL_FILE_EXTENSION',
    'type' => 'varchar',
    'len' => 100,
    'duplicate_on_record_copy' => 'always',
  ),
  'file_mime_type' =>
  array (
    'name' => 'file_mime_type',
    'vname' => 'LBL_MIME',
    'type' => 'varchar',
    'len' => '100',
    'duplicate_on_record_copy' => 'always',
  ),


'uploadfile' =>
  array (
     'name'=>'uploadfile',
     'vname' => 'LBL_FILE_UPLOAD',
     'type' => 'file',
     'source' => 'non-db',
     'duplicate_on_record_copy' => 'always',
    //'noChange' => true,
    // jwhitcraft BUG44657 - Take this out as it was causing the remove button not to show up on custom modules
  ),

'active_date' =>
  array (
    'name' => 'active_date',
    'vname' => 'LBL_DOC_ACTIVE_DATE',
    'type' => 'date',
	'required'=>true,
    'importable' => 'required',
    'display_default' => 'now',
    'duplicate_on_record_copy' => 'always',
  ),

'exp_date' =>
  array (
    'name' => 'exp_date',
    'vname' => 'LBL_DOC_EXP_DATE',
    'type' => 'date',
    'duplicate_on_record_copy' => 'always',
  ),

  'category_id' =>
  array (
    'name' => 'category_id',
    'vname' => 'LBL_SF_CATEGORY',
    'type' => 'enum',
    'len' => 100,
    'options' => 'document_category_dom',
    'reportable'=>false,
    'duplicate_on_record_copy' => 'always',
  ),

  'subcategory_id' =>
  array (
    'name' => 'subcategory_id',
    'vname' => 'LBL_SF_SUBCATEGORY',
    'type' => 'enum',
    'len' => 100,
    'options' => 'document_subcategory_dom',
    'reportable'=>false,
    'duplicate_on_record_copy' => 'always',
  ),

  'status_id' =>
  array (
    'name' => 'status_id',
    'vname' => 'LBL_DOC_STATUS',
    'type' => 'enum',
    'len' => 100,
    'options' => 'document_status_dom',
    'reportable'=>false,
    'duplicate_on_record_copy' => 'always',
  ),

  'status' =>
  array (
    'name' => 'status',
    'vname' => 'LBL_DOC_STATUS',
    'type' => 'varchar',
    'source' => 'non-db',
    'duplicate_on_record_copy' => 'always',
    'Comment' => 'Document status for Meta-Data framework',
  ),
 )
);

