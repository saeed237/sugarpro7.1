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

/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


global $current_user;

if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

$focus = BeanFactory::getBean('Administration');

// filter for relevant POST data and update config table
foreach ($_POST as $key => $val) {
	$prefix = $focus->get_config_prefix($key);
	if (in_array($prefix[0], $focus->config_categories)) {
        if ( $prefix[0] == "license" )
        {
        	if ( $prefix[1] == "expire_date" )
        	{
        		global $timedate;
            	$val = $timedate->swap_formats( $val, $timedate->get_date_format(), $timedate->dbDayFormat );
        	}
        	else
        	if ( $prefix[1] == "key" )
        	{
        		$val = trim($val); // bug 16860 tyoung - trim whitespace from the start and end of the licence key value	
        	}
        }

        $focus->saveSetting($prefix[0], $prefix[1], $val); 
	}
}


if(isset($_POST['license_key'])){
	
	
	loadLicense(true);
	check_now(get_sugarbeat());
	
}






unset($_SESSION['license_seats_needed']);
unset($_SESSION['LICENSE_EXPIRES_IN']);
unset($_SESSION['VALIDATION_EXPIRES_IN']);
unset($_SESSION['HomeOnly']);


apiLoadSystemStatus(true);
header("Location: index.php?action={$_POST['return_action']}&module={$_POST['return_module']}");
?>
