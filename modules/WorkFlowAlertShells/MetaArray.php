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


$process_dictionary['AlertShellDetailView'] = Array('elements'=> array(

'Email' => array(
'module_title' => 'LBL_MODULE_TITLE',
'sub_panel_title' => 'LBL_MODULE_NAME',
'statement_title' => 'LBL_LIST_STATEMENT',
'include_components' => array(	'current_user',
								'rel_user',
								'rel_user_custom',
								'trig_user_custom',
								'specific_user',
								'specific_team',
								'specific_role',
								'login_user',
								),
				//End element E-mail
				),
				
'Invite' => array(
				'module_title' => 'LBL_MODULE_TITLE_INVITE',
				'sub_panel_title' => 'LBL_MODULE_NAME_INVITE',
				'statement_title' => 'LBL_LIST_STATEMENT_INVITE',
				'include_components' => array(	'current_user',
								'rel_user',
								'rel_user_custom',
								'trig_user_custom',
								'specific_user',
								'specific_team',
								'specific_role',
								'login_user',
								),
				//End element Invite
				),
	
	//end elements array			
	),
);


?>