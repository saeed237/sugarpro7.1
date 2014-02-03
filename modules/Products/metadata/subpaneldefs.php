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

 


$layout_defs['Products'] = array(
	// list of what Subpanels to show in the DetailView 
	'subpanel_setup' => array(
		'products' => array(
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Products'),
			),
			'order' => 10,
			'module' => 'Products',
			'sort_order' => 'desc',
			'sort_by' => 'date_purchased',
			'subpanel_name' => 'ForProducts',
			'get_subpanel_data' => 'related_products',
			'add_subpanel_data' => 'product_id',
			'title_key' => 'LBL_RELATED_PRODUCTS_TITLE',
			'get_distinct_data'=> true,
		),
		
		'notes' => array(
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateButton'),
			),
			'order' => 20,
			'sort_order' => 'desc',
			'sort_by' => 'date_modified',
			'module' => 'Notes',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'notes',
			'add_subpanel_data' => 'note_id',
			'title_key' => 'LBL_NOTES_SUBPANEL_TITLE',
		),
		
        'documents' => array(
            'order' => 25,
            'module' => 'Documents',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_DOCUMENTS_SUBPANEL_TITLE',
            'get_subpanel_data' => 'documents',
            'top_buttons' => 
            array (
                0 => 
                array (
                    'widget_class' => 'SubPanelTopButtonQuickCreate',
                    ),
                1 => 
                array (
                    'widget_class' => 'SubPanelTopSelectButton',
                    'mode' => 'MultiSelect',
                    ),
                ),
        ),

		'contracts' => array(
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Contracts'),
			),
			'order' => 30,
			'sort_order' => 'desc',
			'sort_by' => 'date_modified',
			'module' => 'Contracts',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'contracts',
			'add_subpanel_data' => 'contract_id',
			'title_key' => 'LBL_CONTRACTS_SUBPANEL_TITLE',
		),		
	),
);
?>