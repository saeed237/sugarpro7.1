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

$searchFields['Employees'] = 
	array (
		'first_name' => array( 'query_type'=>'default'),
		'last_name'=> array('query_type'=>'default'),	
		'search_name'=> array('query_type'=>'default','db_field'=>array('first_name','last_name'),'force_unifiedsearch'=>true),
        'email'=> array(
			'query_type' => 'default',
			'operator' => 'subquery',
			'subquery' => 'SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 and ea.email_address LIKE',
			'db_field' => array(
				'id',
			)
		),
        'phone'=> array(
            'query_type' => 'default',
            'operator' => 'subquery',
            'subquery' => array('SELECT id FROM users where phone_home LIKE ',
                'SELECT id FROM users where phone_fax LIKE',
                'SELECT id FROM users where phone_other LIKE',
                'SELECT id FROM users where phone_work LIKE',
                'SELECT id FROM users where phone_mobile LIKE',
                'OR' =>true              
            ),
            'db_field' => array(
                'id',
            )
        ),
        // This is named so awkwardly because it's the only way we could get it to be a "proper" checkbox and not throw the basic search all out of wack.
		'open_only_active_users'=> array('query_type'=>'default','db_field'=>array('employee_status'), 'vname' => 'LBL_ONLY_ACTIVE', 'type' => 'bool'),

		      
		'employee_status'=> array('query_type'=>'default', 'options' => 'employee_status_dom', 'template_var' => 'STATUS_OPTIONS', 'options_add_blank' => true)
	);
?>
