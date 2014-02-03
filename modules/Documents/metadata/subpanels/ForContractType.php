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
       array('widget_class' => 'SubPanelTopCreateButton'),
	   array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Documents','field_to_name_array'=>array('document_revision_id'=>'REL_ATTRIBUTE_document_revision_id')),
	),

	'where' => '',
	
	

    'list_fields'=> array(
      'document_name'=> array(
	    	'name' => 'document_name',
	 		'vname' => 'LBL_LIST_DOCUMENT_NAME',
			'widget_class' => 'SubPanelDetailViewLink',
			'width' => '40%',
	   ),
       'is_template'=>array(
 	    	'name' => 'is_template',
	 	    'vname' => 'LBL_LIST_IS_TEMPLATE',
		    'width' => '15%',
		    'widget_type'=>'checkbox',
		),
       'template_type'=>array(
 	    	'name' => 'template_types',
	 	    'vname' => 'LBL_LIST_TEMPLATE_TYPE',
		    'width' => '20%',
		),		
       'latest_revision'=>array(
 	    	'name' => 'latest_revision',
	 	    'vname' => 'LBL_LATEST_REVISION',
		    'width' => '15%',
            'sortable' => false
		),
		'edit_button'=>array(
			'vname' => 'LBL_EDIT_BUTTON',
			'widget_class' => 'SubPanelEditButton',
		 	'module' => 'Documents',
			'width' => '5%',
		),
		'remove_button'=>array(
			'vname' => 'LBL_REMOVE',
			'widget_class' => 'SubPanelRemoveButton',
		 	'module' => 'Documents',
			'width' => '5%',
		),		
		'document_revision_id'=>array(
			'usage'=>'query_only'
		),
	),
);
?>