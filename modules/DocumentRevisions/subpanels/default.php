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



$subpanel_layout = array(
	'top_buttons' => array(
        array('widget_class' => 'SubPanelTopCreateRevisionButton'),
	),

	'where' => '',


	'list_fields' => array(
		  'filename' => 
		  array (
		    'vname' => 'LBL_REV_LIST_FILENAME',
		    'widget_class' => 'SubPanelDetailViewLink',
		    'width' => '15%',
		    'default' => true,
		  ),
		  'revision' => 
		  array (
		    'vname' => 'LBL_REV_LIST_REVISION',
		    'width' => '5%',
		    'default' => true,
		  ),
		  'created_by_name' => 
		  array (
		    'vname' => 'LBL_REV_LIST_CREATED',
		    'width' => '25%',
		    'default' => true,
		  ),
		  'date_entered' => 
		  array (
		    'vname' => 'LBL_REV_LIST_ENTERED',
		    'width' => '10%',
		    'default' => true,
		  ),
		  'change_log' => 
		  array (
		    'vname' => 'LBL_REV_LIST_LOG',
		    'width' => '35%',
		    'default' => true,
		  ),
		  'del_button' => 
		  array (
		    'vname' => 'LBL_DELETE_BUTTON',
		    'widget_class' => 'SubPanelRemoveButton',
		    'width' => '5%',
		    'default' => true,
		  ),
		  'document_id' => 
		  array (
		    'usage' => 'query_only',
		  ),
		  'doc_type' => 
		  array (
		    'usage' => 'query_only',
		  ),
	),
);
?>