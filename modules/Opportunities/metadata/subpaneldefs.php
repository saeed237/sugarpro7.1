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




$layout_defs['Opportunities'] = array(
	// list of what Subpanels to show in the DetailView
	'subpanel_setup' => array(
        'activities' => array(
			'order' => 10,
			'sort_order' => 'desc',
			'sort_by' => 'date_start',
			'title_key' => 'LBL_ACTIVITIES_SUBPANEL_TITLE',
			'type' => 'collection',
			'subpanel_name' => 'activities',   //this values is not associated with a physical file.
			'module'=>'Activities',

			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateTaskButton'),
				array('widget_class' => 'SubPanelTopScheduleMeetingButton'),
				array('widget_class' => 'SubPanelTopScheduleCallButton'),
				array('widget_class' => 'SubPanelTopComposeEmailButton'),
			),

			'collection_list' => array(
				'meetings' => array(
					'module' => 'Meetings',
					'subpanel_name' => 'ForActivities',
					'get_subpanel_data' => 'meetings',
				),
				'tasks' => array(
					'module' => 'Tasks',
					'subpanel_name' => 'ForActivities',
					'get_subpanel_data' => 'tasks',
				),
				'calls' => array(
					'module' => 'Calls',
					'subpanel_name' => 'ForActivities',
					'get_subpanel_data' => 'calls',
				),
			)
		),

		'history' => array(
			'order' => 20,
			'sort_order' => 'desc',
			'sort_by' => 'date_entered',
			'title_key' => 'LBL_HISTORY_SUBPANEL_TITLE',
			'type' => 'collection',
			'subpanel_name' => 'history',   //this values is not associated with a physical file.
			'module'=>'History',

			'top_buttons' => array(
			array('widget_class' => 'SubPanelTopCreateNoteButton'),
			array('widget_class' => 'SubPanelTopArchiveEmailButton'),
            array('widget_class' => 'SubPanelTopSummaryButton'),
			),

			'collection_list' => array(
				'meetings' => array(
					'module' => 'Meetings',
					'subpanel_name' => 'ForHistory',
					'get_subpanel_data' => 'meetings',
				),
				'tasks' => array(
					'module' => 'Tasks',
					'subpanel_name' => 'ForHistory',
					'get_subpanel_data' => 'tasks',
				),
				'calls' => array(
					'module' => 'Calls',
					'subpanel_name' => 'ForHistory',
					'get_subpanel_data' => 'calls',
				),
				'notes' => array(
					'module' => 'Notes',
					'subpanel_name' => 'ForHistory',
					'get_subpanel_data' => 'notes',
				),
				'emails' => array(
					'module' => 'Emails',
					'subpanel_name' => 'ForUnlinkedEmailHistory',
            		'get_subpanel_data' => 'function:get_emails_by_assign_or_link',
          			'function_parameters' => array('import_function_file' => 'include/utils.php', 'link' => 'contacts'),
                    'generate_select'=>true,
				),
			)
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
        'leads' => array(
			'order' => 50,
			'module' => 'Leads',
			'sort_order' => 'asc',
			'sort_by' => 'last_name, first_name',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'leads',
			'add_subpanel_data' => 'lead_id',
			'title_key' => 'LBL_LEADS_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateLeadNameButton'),
				array('widget_class' => 'SubPanelTopSelectButton',
					'popup_module' => 'Opportunities',
					'mode' => 'MultiSelect',
				),
			),
		),
        'contacts' => array(
			'order' => 30,
			'module' => 'Contacts',
			'sort_order' => 'asc',
			'sort_by' => 'last_name, first_name',
			'subpanel_name' => 'ForOpportunities',
			'get_subpanel_data' => 'contacts',
			'add_subpanel_data' => 'contact_id',
			'title_key' => 'LBL_CONTACTS_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateAccountNameButton'),
				array('widget_class' => 'SubPanelTopSelectButton',
					'popup_module' => 'Opportunities',
					'mode' => 'MultiSelect',
					'initial_filter_fields' => array('account_id' => 'account_id', 'account_name' => 'account_name'),
				),
			),
		),
		'quotes' => array(
			'order' => 40,
			'module' => 'Quotes',
			'sort_order' => 'desc',
			'sort_by' => 'date_quote_expected_closed',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'quotes',
			'add_subpanel_data' => 'quote_id',
			'title_key' => 'LBL_QUOTES_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateButton'),
				array('widget_class' => 'SubPanelTopSelectButton', 'mode'=>'MultiSelect')
			),
		),
        'revenuelineitems' => array(
            'order' => 60,
            'module' => 'RevenueLineItems',
            'subpanel_name' => 'ForOpportunities',
            'sort_order' => 'desc',
            'sort_by' => 'date_purchased',
            'title_key' => 'LBL_RLI_SUBPANEL_TITLE',
            'get_subpanel_data' => 'revenuelineitems',
            'top_buttons' => array(
                array(
                    'widget_class' => 'SubPanelTopButtonQuickCreate',
                ),
                array(
                    'widget_class' => 'SubPanelTopSelectButton',
                    'mode' => 'MultiSelect',
                ),
            ),

        ),

		'contracts' => array(
			'order' => 60,
			'module' => 'Contracts',
			'sort_order' => 'desc',
			'sort_by' => 'end_date',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'contracts',
			'add_subpanel_data' => 'contract_id',
			'title_key' => 'LBL_CONTRACTS_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopButtonQuickCreate'),
				array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Contracts','mode'=>'MultiSelect',
						'initial_filter_fields'=>array('account_id'=>'account_id','account_name'=>'account_name')),
				)
		),
	),
);
?>
