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

 


$layout_defs['Documents'] = array(
	// list of what Subpanels to show in the DetailView 
	'subpanel_setup' => array(
		'therevisions' => array(
			'order' => 10,
			'sort_order' => 'desc',
			'sort_by' => 'revision',			
			'module' => 'DocumentRevisions',
			'subpanel_name' => 'default',
			'title_key' => 'LBL_DOC_REV_HEADER',
			'get_subpanel_data' => 'revisions',
			'fill_in_additional_fields'=>true,
		),
		'contracts' => array(
			'order' => 20,
			'sort_order' => 'desc',
			'sort_by' => 'name',
			'module' => 'Contracts',
			'subpanel_name' => 'ForDocuments',
			'get_subpanel_data' => 'contracts',
			'add_subpanel_data' => 'contract_id',
			'title_key' => 'LBL_CONTRACTS_SUBPANEL_TITLE',
			'top_buttons' => array(),	
		),
        'accounts' => array(
            'order' => 30,
            'module' => 'Accounts',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_ACCOUNTS_SUBPANEL_TITLE',
            'get_subpanel_data' => 'accounts',
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
        'contacts' => array(
            'order' => 40,
            'module' => 'Contacts',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_CONTACTS_SUBPANEL_TITLE',
            'get_subpanel_data' => 'contacts',
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
        'opportunities' => array(
            'order' => 40,
            'module' => 'Opportunities',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_OPPORTUNITIES_SUBPANEL_TITLE',
            'get_subpanel_data' => 'opportunities',
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
        'cases' => array(
            'order' => 50,
            'module' => 'Cases',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_CASES_SUBPANEL_TITLE',
            'get_subpanel_data' => 'cases',
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
        'bugs' => array(
            'order' => 60,
            'module' => 'Bugs',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_BUGS_SUBPANEL_TITLE',
            'get_subpanel_data' => 'bugs',
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
        'quotes' => array(
            'order' => 70,
            'module' => 'Quotes',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_QUOTES_SUBPANEL_TITLE',
            'get_subpanel_data' => 'quotes',
            'top_buttons' => 
            array (
                0 => 
                array (
                    'widget_class' => 'SubPanelTopSelectButton',
                    'mode' => 'MultiSelect',
                    ),
                ),
        ),
        'revenuelineitems' => array(
            'order' => 80,
            'module' => 'RevenueLineItems',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_RLI_SUBPANEL_TITLE',
            'get_subpanel_data' => 'revenuelineitems',
            'top_buttons' => 
            array (
                0 => 
                array (
                    'widget_class' => 'SubPanelTopSelectButton',
                    'mode' => 'MultiSelect',
                    ),
                ),
        ),    
	),
);
?>