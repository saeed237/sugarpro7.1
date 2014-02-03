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

echo getClassicModuleTitle('Administration', array($mod_strings['LBL_REBUILD_SCHEDULERS_TITLE']), false);

if(isset($_REQUEST['perform_rebuild']) && $_REQUEST['perform_rebuild'] == 'true') {
	
	require_once('install/install_utils.php');
	$focus = BeanFactory::getBean('Schedulers');
	$focus->rebuildDefaultSchedulers();
	
$admin_mod_strings = return_module_language($current_language, 'Administration');	
?>
<table cellspacing="{CELLSPACING}" class="otherview">
	<tr> 
		<td scope="row" width="35%"><?php echo $admin_mod_strings['LBL_REBUILD_SCHEDULERS_DESC_SUCCESS']; ?></td>
		<td><a href="index.php?module=Administration&action=Upgrade"><?php echo $admin_mod_strings['LBL_RETURN']; ?></a></td>
	</tr>
</table>
<?php
} else {
?>	
<p>
<form name="RebuildSchedulers" method="post" action="index.php">
<input type="hidden" name="module" value="Administration">
<input type="hidden" name="action" value="RebuildSchedulers">
<input type="hidden" name="return_module" value="Administration">
<input type="hidden" name="return_action" value="Upgrade">
<input type="hidden" name="perform_rebuild" value="true">
<table cellspacing="{CELLSPACING}" class="other view">
	<tr>
	    <td scope="row" width="15%"><?php echo $mod_strings['LBL_REBUILD_SCHEDULERS_TITLE']; ?></td>
	    <td><input type="submit" name="button" value="<?php echo $mod_strings['LBL_REBUILD']; ?>"></td>
	</tr>
	<tr> 
		<td colspan="2" scope="row"><?php echo $mod_strings['LBL_REBUILD_SCHEDULERS_DESC']; ?></td>
	</tr>
</table>
</form>
</p>
<?php
}
?>