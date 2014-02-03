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


$layout_defs['Schedulers'] = array(
	// list of what Subpanels to show in the DetailView 
	'subpanel_setup' => array( 
        'times' => array(
			'order' => 20,
			'module' => 'SchedulersJobs',
			'sort_by' => 'execute_time',
			'sort_order' => 'desc',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'schedulers_times',
			'add_subpanel_data' => 'scheduler_id',
			'title_key' => 'LBL_JOBS_SUBPANEL_TITLE',
			'top_buttons' => array(
			),
		),
	),
);
 
?>