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

global $dictionary;
if(empty($dictionary['User'])){
	include('modules/Users/vardefs.php');
}
$dictionary['Employee']=$dictionary['User'];
//users of employees modules are not allowed to change the employee/user status.
$dictionary['Employee']['fields']['status']['massupdate']=false;
$dictionary['Employee']['fields']['is_admin']['massupdate']=false;
//begin bug 48033
$dictionary['Employee']['fields']['UserType']['massupdate']=false;
$dictionary['Employee']['fields']['messenger_type']['massupdate']=false;
$dictionary['Employee']['fields']['email_link_type']['massupdate']=false;
//end bug 48033
$dictionary['Employee']['fields']['email']['required']=false;
$dictionary['Employee']['fields']['email_addresses']['required']=false;
$dictionary['Employee']['fields']['email_addresses_primary']['required']=false;
// bugs 47553 & 49716
$dictionary['Employee']['fields']['status']['studio']=false;
$dictionary['Employee']['fields']['status']['required']=false;
?>
