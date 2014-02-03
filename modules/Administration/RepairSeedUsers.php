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

global $current_user, $mod_strings;

if(is_admin($current_user)){
    if(count($_POST)){
    	if(!empty($_POST['activate'])){

    		$status = '';
    		if($_POST['activate'] == 'false'){
    			$status = 'Inactive';
    		}else{
    			$status = 'Active';
    		}
    	}
    	$query = "UPDATE users SET status = '$status' WHERE id LIKE 'seed%'";
   		$GLOBALS['db']->query($query);
    }
    	$query = "SELECT status FROM users WHERE id LIKE 'seed%'";
    	$result = $GLOBALS['db']->query($query);
		$row = $GLOBALS['db']->fetchByAssoc($result);
		if(!empty($row['status'])){
			$activate = 'false';
			if($row['status'] == 'Inactive'){
				$activate = 'true';
			}
			?>
				<p>
				<form name="RepairSeedUsers" method="post" action="index.php">
				<input type="hidden" name="module" value="Administration">
				<input type="hidden" name="action" value="RepairSeedUsers">
				<input type="hidden" name="return_module" value="Administration">
				<input type="hidden" name="return_action" value="Upgrade">
				<input type="hidden" name="activate" value="<?php echo $activate; ?>">
				<table cellspacing="{CELLSPACING}" class="otherview">
					<tr>
					    <td scope="row" width="30%"><?php echo $mod_strings['LBL_REPAIR_SEED_USERS_TITLE']; ?></td>
					    <td><input type="submit" name="button" value="<?php if($row['status'] == 'Inactive'){echo $mod_strings['LBL_REPAIR_SEED_USERS_ACTIVATE'];}else{echo $mod_strings['LBL_REPAIR_SEED_USERS_DECACTIVATE'];} ?>"></td>
					</tr>
				</table>
				</form>
				</p>
			<?php

		}else{
			echo $mod_strings['LBL_REPAIR_SEED_USERS_NO_USER'];
		}
}
else{
	sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
}
?>