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


global $current_user;

$dashletData['MyNotesDashlet']['searchFields'] = array('date_entered'     => array('default' => ''),
														'team_id'          => array('default' => '', 'label'=>'LBL_TEAMS'),
														'assigned_user_id' => array('type'    => 'assigned_user_name',
																					'label'   => 'LBL_ASSIGNED_TO', 
																					'default' => $current_user->name),
																					'name' => array( 'default'=>''),
														);
                                                                                           
$dashletData['MyNotesDashlet']['columns'] = array (
											  'name' => 
											  array (
											    'width' => '40%',
											    'label' => 'LBL_LIST_SUBJECT',
											    'link' => true,
											    'default' => true,
											  ),
											  'contact_name' => 
											  array (
											    'width' => '20%',
											    'label' => 'LBL_LIST_CONTACT',
											    'link' => true,
											    'id' => 'CONTACT_ID',
											    'module' => 'Contacts',
											    'default' => true,
											    'ACLTag' => 'CONTACT',
											    'related_fields' => 
											    array (
											      0 => 'contact_id',
											    ),
											  ),
											  'parent_name' => 
											  array (
											    'width' => '20%',
											    'label' => 'LBL_LIST_RELATED_TO',
											    'dynamic_module' => 'PARENT_TYPE',
											    'id' => 'PARENT_ID',
											    'link' => true,
											    'default' => true,
											    'sortable' => false,
											    'ACLTag' => 'PARENT',
											    'related_fields' => 
											    array (
											      0 => 'parent_id',
											      1 => 'parent_type',
											    ),
											  ),  
											  'doc_type' =>
											  array(
												'width' => '5%', 
											  	'label' => 'LBL_DOC_TYPE',
											    'link' => false,
											 	'default' => true,
											  ), 
											  'filename' => 
											  array (
											    'width' => '20%',
											    'label' => 'LBL_LIST_FILENAME',
											    'default' => true,
											    'type' => 'file',
											    'related_fields' => 
											    array (
											      0 => 'file_url',
											      1 => 'id',
											      2 => 'doc_id',
											      3 => 'doc_type',
											    ),
											    'displayParams' =>
											    array(
											      'module' => 'Notes',
											    ),
											  ),
											  'created_by_name' => 
											  array (
											    'type' => 'relate',
											    'label' => 'LBL_CREATED_BY',
											    'width' => '10%',
											    'default' => true,
											  ),
											  'date_entered' => 
											  array (
											    'type' => 'datetime',
											    'label' => 'LBL_DATE_ENTERED',
											    'width' => '10%',
											    'default' => false,
											  ),
											  'date_modified' => 
											  array (
											    'width' => '20%',
											    'label' => 'LBL_DATE_MODIFIED',
											    'link' => false,
											    'default' => false,
											  ),
											  'team_name' => array(
											    'width' => '2', 
											    'label' => 'LBL_LIST_TEAM',
											    'default' => false
											  ),        
											);
											?>
