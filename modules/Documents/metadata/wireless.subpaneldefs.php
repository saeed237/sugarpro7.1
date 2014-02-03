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
		'quotes'=> array(
			'order' => 10,
			'module' => 'Quotes',
			'get_subpanel_data' => 'quotes',
			'title_key' => 'LBL_QUOTES_SUBPANEL_TITLE',
		),
		'cases'=> array(
			'order' => 20,
			'module' => 'Cases',
			'get_subpanel_data' => 'cases',
			'title_key' => 'LBL_CASES_SUBPANEL_TITLE',
		),
		'contacts'=> array(
			'order' => 30,
			'module' => 'Accounts',
			'get_subpanel_data' => 'contacts',
			'title_key' => 'LBL_CONTACTS_SUBPANEL_TITLE',
		),
		'opportunities'=> array(
			'order' => 40,
			'module' => 'Opportunities',
			'get_subpanel_data' => 'opportunities',
			'title_key' => 'LBL_OPPORTUNITIES_SUBPANEL_TITLE',
		),
		'accounts'=> array(
			'order' => 50,
			'module' => 'Accounts',
			'get_subpanel_data' => 'accounts',
			'title_key' => 'LBL_ACCOUNTS_SUBPANEL_TITLE',
		),
	),
);
?>