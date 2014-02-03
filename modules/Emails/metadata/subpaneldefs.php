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

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 *********************************************************************************/



$layout_defs['Emails'] = array(
	// list of what Subpanels to show in the DetailView
	'subpanel_setup' => array(
		'notes' => array(
			'order' => 5,
			'sort_order' => 'asc',
			'sort_by'	=> 'name',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'notes',
			'title_key' => 'LBL_NOTES_SUBPANEL_TITLE',
			'module' => 'Notes',
			'top_buttons' => array(),
		),
        'accounts' => array(
			'order' => 10,
			'module' => 'Accounts',
			'sort_order' => 'asc',
			'sort_by' => 'name',
			'subpanel_name' => 'ForEmails',
			'get_subpanel_data' => 'accounts',
			'add_subpanel_data' => 'account_id',
			'title_key' => 'LBL_ACCOUNTS_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateButton'),
				array('widget_class' => 'SubPanelTopSelectButton', 'mode'=>'MultiSelect')
			),
		),
        'contacts' => array(
			'order' => 20,
			'module' => 'Contacts',
			'sort_order' => 'asc',
			'sort_by' => 'last_name, first_name',
			'subpanel_name' => 'ForEmails',
			'get_subpanel_data' => 'contacts',
			'add_subpanel_data' => 'contact_id',
			'title_key' => 'LBL_CONTACTS_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateButton'),
				array('widget_class' => 'SubPanelTopSelectButton', 'mode'=>'MultiSelect')
			),
		),
        'opportunities' => array(
			'order' => 25,
			'module' => 'Opportunities',
			'sort_order' => 'asc',
			'sort_by' => 'name',
			'subpanel_name' => 'ForEmails',
			'get_subpanel_data' => 'opportunities',
			'add_subpanel_data' => 'opportunity_id',
			'title_key' => 'LBL_OPPORTUNITY_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateButton'),
				array('widget_class' => 'SubPanelTopSelectButton', 'mode'=>'MultiSelect')
			),
		),
        'leads' => array(
			'order' => 30,
			'module' => 'Leads',
			'sort_order' => 'asc',
			'sort_by' => 'last_name, first_name',
			'subpanel_name' => 'ForEmails',
			'get_subpanel_data' => 'leads',
			'add_subpanel_data' => 'lead_id',
			'title_key' => 'LBL_LEADS_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateButton'),
				array('widget_class' => 'SubPanelTopSelectButton', 'mode'=>'MultiSelect')
			),
		),
        'cases' => array(
			'order' => 40,
			'module' => 'Cases',
			'sort_order' => 'desc',
			'sort_by' => 'case_number',
			'subpanel_name' => 'ForEmails',
			'get_subpanel_data' => 'cases',
			'add_subpanel_data' => 'case_id',
			'title_key' => 'LBL_CASES_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateButton'),
				array('widget_class' => 'SubPanelTopSelectButton', 'mode'=>'MultiSelect')
			),
		),
        'users' => array(
			'order' => 50,
			'module' => 'Users',
			'sort_order' => 'asc',
			'sort_by' => 'name',
			'subpanel_name' => 'ForEmails',
			'get_subpanel_data' => 'users',
			'add_subpanel_data' => 'user_id',
			'title_key' => 'LBL_USERS_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopSelectButton', 'mode'=>'MultiSelect')
			),
		),
        'bugs' => array(
			'order' => 60,
			'module' => 'Bugs',
			'sort_order' => 'desc',
			'sort_by' => 'bug_number',
			'subpanel_name' => 'ForEmails',
			'get_subpanel_data' => 'bugs',
			'add_subpanel_data' => 'bug_id',
			'title_key' => 'LBL_BUGS_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateButton'),
				array('widget_class' => 'SubPanelTopSelectButton', 'mode'=>'MultiSelect')
			),
		),

        'quotes' => array(
			'order' => 70,
			'module' => 'Quotes',
			'sort_order' => 'desc',
			'sort_by' => 'date_quote_expected_closed',
			'subpanel_name' => 'ForEmails',
			'get_subpanel_data' => 'quotes',
			'add_subpanel_data' => 'quote_id',
			'title_key' => 'LBL_QUOTES_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopCreateButton'),
				array('widget_class' => 'SubPanelTopSelectButton', 'mode'=>'MultiSelect')
			),
		),
		// SNIP
		'contacts_snip' => array(
            'order' => 20,
            'sort_order' => 'asc',
            'sort_by' => 'last_name, first_name',
            'title_key' => 'LBL_CONTACTS_SUBPANEL_TITLE_SNIP',
            'set_subpanel_data' => 'contacts',
            'module' => 'Contacts',
            'subpanel_name' => 'ForEmailsByAddr',
            'get_subpanel_data' => 'function:get_beans_by_email_addr',
            'generate_select'=>true,
			'function_parameters' => array('import_function_file' => 'modules/SNIP/utils.php', 'module'=>'Contacts'),
		    'top_buttons' => array(),
		),
		'meetings' => array(
            'order' => 1,
            'sort_order' => 'desc',
            'sort_by' => 'date_start',
            'title_key' => 'LBL_ACTIVITIES_SUBPANEL_TITLE',
            'module' => 'Meetings',
            'subpanel_name' => 'ForActivities',
            'get_subpanel_data' => 'meetings',
			'top_buttons' => array(),
		),

	),
);
