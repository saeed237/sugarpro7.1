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

 

$layout_defs['ContractTypes'] = array( 
	// list of what Subpanels to show in the DetailView 
	'subpanel_setup' => array(
		'contract_documents' => array(
			'order' => 10,
			'module' => 'Documents',
			'sort_by' => 'document_name',
			'sort_order' => 'asc',			
			'subpanel_name' => 'ForContractType',
			'get_subpanel_data' => 'documents',
			'set_subpanel_data' => 'documents',
			'title_key' => 'LBL_DOCUMENTS_SUBPANEL_TITLE',
			'fill_in_additional_fields' => true,
			'refresh_page' => 1,			
			'top_buttons' => array(
	   			array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Documents')
			),
		),
	),
);	
?>