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


global $mod_strings;

$popupMeta = array('moduleMain' => 'Contact',
						'varName' => 'CONTACT',
						'orderBy' => 'contacts.first_name, contacts.last_name',
						'whereClauses' => 
							array('first_name' => 'contacts.first_name', 
									'last_name' => 'contacts.last_name',
									'account_name' => 'accounts.name',
									'account_id' => 'accounts.id'),
						'searchInputs' =>
							array('first_name', 'last_name', 'account_name'),
						'create' =>
							array('formBase' => 'ContactFormBase.php',
									'formBaseClass' => 'ContactFormBase',
									'getFormBodyParams' => array('','','ContactSave'),
									'createButton' => 'LNK_NEW_CONTACT'
								  ),
						'templateForm' => 'modules/Contacts/Email_picker.html',
						);
?>
