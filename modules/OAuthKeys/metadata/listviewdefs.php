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




$module_name = 'OAuthKeys';
$listViewDefs[$module_name] = array(
	'NAME' => array(
		'width' => '32',
		'label' => 'LBL_NAME',
		'default' => true,
        'link' => true,
    ),
	'C_KEY' => array(
		'width' => '40',
		'label' => 'LBL_CONSKEY',
        'default' => true),
    'OAUTH_TYPE' => array(
        'width' => '20',
        'label' => 'LBL_OAUTH_TYPE',
        'default' => true,
    ),
    'CLIENT_TYPE' => array(
        'width' => '20',
        'label' => 'LBL_CLIENT_TYPE',
        'default' => true,
    ),
);
