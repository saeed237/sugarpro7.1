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






$dictionary['KBContent'] = array(
	'table' => 'kbcontents',
	'audited' => true,
	'engine' => 'MyISAM',
	'comment' => 'A content represents information about document',
	'fields' => array (
		'id' => array (
			'name' => 'id',
			'type' => 'id',
			'vname' => 'LBL_ID',
			'required' => true,
			'reportable' => true,
			'comment' => 'Unique identifer'
		),
		
		'kbdocument_body' => array (
			'name' => 'kbdocument_body',
			'vname' => 'LBL_TEXT_BODY',
			'type' => 'longtext',
			'comment' => 'Article body',
		),		
		'document_revision_id' => array (
			'name' => 'document_revision_id',
			'vname' => 'LBL_DOCUMENT_REVISION_ID',
			'type' => 'id',
			'audited' => true,
			'reportable' => false,
			'comment' => 'The document revision id to which this content is associated'
		),
		
		'created_by_link' => array (
			'name' => 'created_by_link',
			'type' => 'link',
			'relationship' => 'contents_created_by',
			'vname' => 'LBL_CREATED_BY_USER',
			'link_type' => 'one',
			'module' => 'Users',
			'bean_name' => 'User',
			'source' => 'non-db',
		),
		'date_entered' => array (
			'name' => 'date_entered',
			'vname' => 'LBL_DATE_ENTERED',
			'type' => 'datetime',
			'comment' => 'Date record created'
		),
		'date_modified' => array (
			'name' => 'date_modified',
			'vname' => 'LBL_DATE_MODIFIED',
			'type' => 'datetime',
			'comment' => 'Date record last modified'
		),
		'deleted' => array (
			'name' => 'deleted',
			'vname' => 'LBL_DELETED',
			'type' => 'bool',
			'default' => 0,
			'reportable' => false,
			'comment' => 'Record deletion indicator'
		),
		'modified_user_id' => array (
			'name' => 'modified_user_id',
			'rname' => 'user_name',
			'id_name' => 'modified_user_id',
			'vname' => 'LBL_MODIFIED',
			'type' => 'assigned_user_name',
			'table' => 'users',
			'isnull' => false,
			'reportable' => true,
			'dbType' => 'id'
		), 
		'modified_user_link' => array (
			'name' => 'modified_user_link',
			'type' => 'link',
			'relationship' => 'contents_modified_user',
			'vname' => 'LBL_MODIFIED_BY_USER',
			'link_type' => 'one',
			'module' => 'Users',
			'bean_name' => 'User',
			'source' => 'non-db',
		),
	    'kb_index' => array (
			'name' => 'kb_index',
			'vname' => 'LBL_NUMBER',
			'type' => 'int',
			'len' => 11,
			'required' => true,
			'auto_increment' => true,
			'readonly' => true,
			'comment' => 'Currently used only by instances using sql server.',
			'duplicate_merge' => 'disabled',
		),		
	),
	'indices' => array (
       array('name' =>'kbcontentspk', 'type' =>'primary', 'fields'=>array('id')), 
       array('name' =>'fts_unique_idx', 'type' =>'unique', 'fields'=>array('kb_index')),
       array('name' =>'kbcontentsftk', 'type' =>'fulltext','fields'=>array('kbdocument_body'), 'db'=>'mysql'),
       array('name' =>'kbcontentsftk', 'type' =>'fulltext','fields'=>array('kbdocument_body'), 'db'=>'ibm_db2','options'=>'UPDATE FREQUENCY D(*) H(*) M(0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55) UPDATE MINIMUM 1','message_locale' =>'en_US'), // Update the TS index every 5 minutes if only 1 record was updated
       array('name' =>'kbcontentsftk', 'type' =>'fulltext','fields'=>array('kbdocument_body'), 'db'=>'oci8','indextype'=>'CTXSYS.CONTEXT','parameters' =>'sync (on commit)'),
       array('name' =>'kbcontentsftk', 'type' =>'fulltext','fields'=>array('kbdocument_body'), 'db'=>'mssql','key_index'=>'fts_unique_idx','change_tracking' =>'AUTO', 'language' => 1033,'catalog'=>'default'),
    ),
);

VardefManager::createVardef('KBContents','KBContent', array(
'team_security',
));
?>