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




$GLOBALS['ldapConfig'] = array(
'users'=>
		array(
			'fields'=>
						array(
							"givenName"=>'first_name',
							"sn"=>'last_name',
							"mail"=>'email1',
							"telephoneNumber"=>'phone_work',
							"facsimileTelephoneNumber"=>'phone_fax',
							"mobile"=>'phone_mobile',
							"street"=>'address_street',
							"l"=>'address_city',
							"st"=>'address_state',
							"postalCode"=>'address_postalcode',
							"c"=>'address_country'
							
							
							
						)
		),
'system'=>
		array('overwriteSugarUserInfo'=>true,),
			


);


?>
