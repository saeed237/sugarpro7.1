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

$sync_modules = array(
				array('name'=>'EditCustomFields', 'direction'=>'down','related'=>array(), 'exempt'=>true),
				array('name'=>'Teams', 'direction'=>'down', 'related'=>array() ,'exempt'=>true),
				array('name'=>'TeamMemberships', 'direction'=>'down', 'related'=>array()),
				array('name'=>'TeamSets', 'direction'=>'both', 'related'=>array('Teams')),
				array('name'=>'Roles', 'direction'=>'down', 'related'=>array()),
				array('name'=>'ACLActions', 'direction'=>'down', 'related'=>array(),'exempt'=>true),
				array('name'=>'ACLRoles', 'direction'=>'down', 'related'=>array('ACLActions', 'Users'), 'exempt'=>true) ,
				array('name'=>'ACLFields', 'direction'=>'down', 'related'=>array(), 'exempt'=>true) ,
				array('name'=>'Currencies', 'direction'=>'down', 'related'=>array()),
				array('name'=>'Versions', 'direction'=>'down', 'related'=>array()),
				 array('name'=>'Accounts', 'direction'=>'both','related'=>array('Accounts','Contacts', 'Leads', 'Opportunities', 'Products', 'Quotes', 'Notes','Tasks', 'Calls', 'Meetings', 'EmailAddresses')),
				 array('name'=>'Contacts', 'direction'=>'both', 'related'=>array('Contacts', 'Leads', 'Opportunities', 'Products', 'Quotes', 'Notes', 'Tasks', 'Calls', 'Meetings', 'EmailAddresses')),
				 array('name'=>'Leads', 'direction'=>'both', 'related'=>array('Tasks', 'Notes', 'Calls', 'Meetings', 'EmailAddresses')),
				 array('name'=>'Calls', 'direction'=>'both', 'related'=>array('Users')),
				 array('name'=>'Meetings', 'direction'=>'both', 'related'=>array('Users')),
				 array('name'=>'Tasks', 'direction'=>'both', 'related'=>array()),
				 array('name'=>'Quotes', 'direction'=>'both', 'related'=>array('Opportunities')),
				 array('name'=>'Opportunities', 'direction'=>'both', 'related'=>array()),
				 array('name'=>'Notes', 'direction'=>'both', 'related'=>array()),
				 array('name'=>'Products', 'direction'=>'both', 'related'=>array('Products')),
				 array('name'=>'ProductBundleNotes', 'direction'=>'both', 'related'=>array()),
				 array('name'=>'ProductTemplates', 'direction'=>'both', 'direction'=>'both', 'related'=>array()),
				 array('name'=>'ProductCategories', 'direction'=>'both', 'related'=>array()),
				 array('name'=>'ProductBundles', 'direction'=>'both', 'related'=>array('Quotes','Products','ProductBundleNotes' )),
				 array('name'=>'ProductTypes', 'direction'=>'both', 'related'=>array()),
				 array('name'=>'Manufacturers', 'direction'=>'both', 'related'=>array()),
				 array('name'=>'Shippers', 'direction'=>'down', 'related'=>array()),
				 array('name'=>'TaxRates', 'direction'=>'down', 'related'=>array()),
				array('name'=>'TimePeriods', 'direction'=>'both', 'related'=>array()),
				array('name'=>'Quotas', 'direction'=>'both', 'related'=>array()),
				array('name'=>'Currencies', 'direction'=>'both', 'related'=>array()),
				array('name'=>'Contracts', 'direction'=>'both', 'related'=>array()),
				array('name'=>'EmailAddresses', 'direction'=>'both', 'related'=>array()),
				 // A Special Sync is done for users array('name'=>'Users', 'related'=>array()),
			);
			
$moduleList =  array(
			     'Home',
				 'Calendar',
				 'Meetings',
                 'Calls',
                 'Notes',
                 'Tasks',
				 'Accounts',
				 'Contacts',
				 'Leads',
				 'Opportunities',
				 'Quotes',
				 'Products',
			);
			
$read_only_override = array(
	'Quotas',
	'Worksheet',
	'ProductBundles',
	'ProductBundleNotes',
	'TeamSets',
	'EmailAddresses',
);
global $soapclient, $soap_server;
$soap_server = $sugar_config['sync_site_url'] . '/soap.php';
require_once('vendor/nusoap//nusoap.php');  //must also have the nusoap code on the ClientSide.
$soapclient = new nusoapclient($soap_server);  //define the SOAP Client an			
$soapclient->response_timeout = 360;
if(!isset($_SESSION['soap_server_available'])){
	$_SESSION['soap_server_available'] = false;	
}
$soap_server_available  = $_SESSION['soap_server_available'];

if(!isset($global_control_links)){
 	$global_control_links = array();
	$sub_menu = array();
}

 




?>