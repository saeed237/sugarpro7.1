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
logThis('-----------------------------------------------------------------------------');
logThis('Upgrade started. At start.php');

//set the upgrade progress status.
set_upgrade_progress('start','in_progress');

unlinkUWTempFiles();
resetUwSession();

if(isset($_REQUEST['showUpdateWizardMessage']) && $_REQUEST['showUpdateWizardMessage'] == true) {
	// set a flag to skip the upload screen
	$_SESSION['skip_zip_upload'] = true;

	$newUWMsg =<<<eoq
	<table cellspacing="0" cellpadding="3" border="0">
		<tr>
			<th>
				{$mod_strings['LBL_UW_START_UPGRADED_UW_TITLE']}
			</th>
		</tr>
		<tr>
			<td>
				{$mod_strings['LBL_UW_START_UPGRADED_UW_DESC']}
			</td>
		</tr>
	</table>
eoq;
	echo $newUWMsg;
}


$uwMain =<<<eoq
<table cellpadding="3" cellspacing="0" border="0">
	<tr>
		<th align="left">
			{$mod_strings['LBL_UW_TITLE_START']}
		</th>
	</tr>
	<tr>
		<td align="left">
			<p>
		    {$mod_strings['LBL_UW_START_DESC']}
			</p>
			<BR>
			<p>
			<span class="error">
			{$mod_strings['LBL_UW_START_DESC2']}
			</span>
			</p>
			<BR>
			<p>
			{$mod_strings['LBL_UW_START_DESC3']}
			</p>
			</td>
	</tr>
</table>
<div id="upgradeDiv" style="display:none">
    <table cellspacing="0" cellpadding="0" border="0">
        <tr><td>
           <p><!--not_in_theme!--><img src='modules/UpgradeWizard/processing.gif' alt='Processing'> <br></p>
        </td></tr>
     </table>
 </div>
eoq;

$showBack		= false;
$showCancel		= true;
$showRecheck	= false;
$showNext		= true;

$stepBack		= 0;
$stepNext		= 1;
$stepCancel	= 0;
$stepRecheck	= 0;

?>
