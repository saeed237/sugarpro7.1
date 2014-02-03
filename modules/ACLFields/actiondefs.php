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

// Be sure to include the base ACL's as well
require_once 'modules/ACLActions/actiondefs.php';

 if(!defined('ACL_READ_ONLY')){   
 	define('ACL_READ_ONLY', 50);
 	define('ACL_READ_WRITE', 99);
 	define('ACL_OWNER_READ_WRITE', 40);
 	define('ACL_READ_OWNER_WRITE', 60);
 	 if(!defined('ACL_ALLOW_NONE')){  
 	 	define('ACL_ALLOW_NONE', -99);
 	 	define('ACL_ALLOW_DEFAULT', 0);
 	 }
 	 define('ACL_FIELD_DEFAULT', 99);
 }
 
 $GLOBALS['aclFieldOptions'] = array(
 					ACL_ALLOW_DEFAULT=>'LBL_DEFAULT',
 					ACL_READ_WRITE=>'LBL_READ_WRITE',
 					ACL_READ_OWNER_WRITE=>'LBL_READ_OWNER_WRITE',
 			 		ACL_READ_ONLY=>'LBL_READ_ONLY',
 			 		ACL_OWNER_READ_WRITE=>'LBL_OWNER_READ_WRITE',
 					ACL_ALLOW_NONE=>'LBL_ALLOW_NONE',
 					);

 




?>