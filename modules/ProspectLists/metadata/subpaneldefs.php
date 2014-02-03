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

 

	
$layout_defs['ProspectLists'] = array(
	// list of what Subpanels to show in the DetailView 
	'subpanel_setup' => array(
        'prospects' => array(
			'order' => 10,
			'sort_by' => 'last_name',
			'sort_order' => 'asc',
			'module' => 'Prospects',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'prospects',
			'title_key' => 'LBL_PROSPECTS_SUBPANEL_TITLE',
			'top_buttons' => array(
			    array('widget_class' => 'SubPanelTopButtonQuickCreate'),
				array('widget_class'=>'SubPanelTopSelectButton','mode'=>'MultiSelect'),
				array('widget_class'=>'SubPanelTopSelectFromReportButton'),
			),
		),
        'contacts' => array(
			'order' => 20,
			'module' => 'Contacts',
			'sort_by' => 'last_name, first_name',
			'sort_order' => 'asc',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'contacts',
			'title_key' => 'LBL_CONTACTS_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class' => 'SubPanelTopButtonQuickCreate'),
				array('widget_class'=>'SubPanelTopSelectButton','mode'=>'MultiSelect'),
				array('widget_class'=>'SubPanelTopSelectFromReportButton'),
			),
		),
        'leads' => array(
			'order' => 30,
			'module' => 'Leads',
			'sort_by' => 'last_name, first_name',
			'sort_order' => 'asc',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'leads',
			'title_key' => 'LBL_LEADS_SUBPANEL_TITLE',
			'top_buttons' => array(
			    array('widget_class' => 'SubPanelTopButtonQuickCreate'),
				array('widget_class'=>'SubPanelTopSelectButton','mode'=>'MultiSelect'),
				array('widget_class'=>'SubPanelTopSelectFromReportButton'),
			),
		),        
		'users' => array(
			'order' => 40,
			'module' => 'Users',
			'sort_by' => 'name',
			'sort_order' => 'asc',
			'subpanel_name' => 'ForProspectLists',
			'get_subpanel_data' => 'users',
			'title_key' => 'LBL_USERS_SUBPANEL_TITLE',
			'top_buttons' => array(
				array('widget_class'=>'SubPanelTopSelectButton','mode'=>'MultiSelect'),
				array('widget_class'=>'SubPanelTopSelectFromReportButton'),
			),
		),		
        'accounts' => array(
			'order' => 40,
			'module' => 'Accounts',
			'sort_order' => 'asc',
			'sort_by' => 'name',
			'subpanel_name' => 'ForProspectLists',
			'get_subpanel_data' => 'accounts',
			'add_subpanel_data' => 'account_id',
			'title_key' => 'LBL_ACCOUNTS_SUBPANEL_TITLE',
            'top_buttons' => array(
                array('widget_class' => 'SubPanelTopButtonQuickCreate'),
				array('widget_class'=>'SubPanelTopSelectButton','mode'=>'MultiSelect'),
				array('widget_class'=>'SubPanelTopSelectFromReportButton'),
            ),
		),
	),
);
?>