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

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 * *******************************************************************************/
logThis('[At cancel.php]');
logThis('cleaning up files and session.  goodbye.');


//Check the current step.

if(isset($_SESSION['install_file']) && file_exists(isset($_SESSION['install_file']))){
	@unlink(isset($_SESSION['install_file']));
}
unlinkUWTempFiles();
unlinkUploadFiles();
resetUwSession();

$uwMain =<<<eoq
<table cellpadding="3" cellspacing="0" border="0">
	<tr>
		<td align="left">
			<p>
			{$mod_strings['LBL_UW_CANCEL_DESC']}
			</p>
		</td>
	</tr>
	<tr>
		<th align="left">
			<input	title		= "{$mod_strings['LBL_BUTTON_RESTART']}"
					class		= "button"
					onclick		= "window.location.href ='{$sugar_config['site_url']}/index.php?module=UpgradeWizard&action=index';"
					type		= "submit"
					value		= "  {$mod_strings['LBL_BUTTON_RESTART']}  "
					id			= "restart_button" >
		</th>
	</tr>
</table>
eoq;


$showBack		= false;
$showCancel		= false;
$showRecheck	= false;
$showNext		= false;
$showExit       = true;

$stepBack		= $_REQUEST['step'] - 1;
$stepNext		= $_REQUEST['step'] + 1;
$stepCancel		= -1;
$stepRecheck	= $_REQUEST['step'];

?>
