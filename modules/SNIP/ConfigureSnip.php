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

require_once 'modules/SNIP/SugarSNIP.php';
if (!is_admin($current_user)) {
    sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
}
global $sugar_config;

$enable_snip = '';
$disable_snip = '';

$snip = SugarSNIP::getInstance();
$title = getClassicModuleTitle('Administration', array(
	"<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
	translate('LBL_CONFIGURE_SNIP')), false);
$sugar_smarty = new Sugar_Smarty();

$sugar_smarty->assign('APP', $GLOBALS['app_strings']);
$sugar_smarty->assign('MOD', $GLOBALS['mod_strings']);

$extra_error='';

if ($_POST && isset($_POST['snipaction'])) {
	if ($_POST['snipaction']=='enable_snip') {
		$enable_snip = $snip->registerSnip();
		if (!$enable_snip || $enable_snip->result!='ok') {
		    if(!empty($enable_snip->message)) {
		        $message = $enable_snip->message;
		    } else {
		        $message = $snip->getLastError();
		    }
		    if(empty($message)) {
	    		$extra_error = '<b>'.$GLOBALS['mod_strings']['LBL_SNIP_ERROR_ENABLING'].'</b>. '.$GLOBALS['mod_strings']['LBL_CONTACT_SUPPORT'];
		    } else {
			    $extra_error = '<b>'.$GLOBALS['mod_strings']['LBL_SNIP_ERROR_ENABLING'].'</b>: '.$message.'. <br>'.$GLOBALS['mod_strings']['LBL_CONTACT_SUPPORT'];
		    }
		}
	} else if ($_POST['snipaction']=='disable_snip') {
		$disable_snip = $snip->unregisterSnip();
		if (!$disable_snip || $disable_snip->result!='ok') {
		    if(!empty($disable_snip->message)) {
		        $message = $disable_snip->message;
		    } else {
		        $message = $snip->getLastError();
		    }
		    if(empty($message)) {
    			$extra_error = '<b>'.$GLOBALS['mod_strings']['LBL_SNIP_ERROR_DISABLING'].'</b>. '.$GLOBALS['mod_strings']['LBL_CONTACT_SUPPORT'];
	    	} else {
			    $extra_error = '<b>'.$GLOBALS['mod_strings']['LBL_SNIP_ERROR_DISABLING'].'</b>: '.$message.'. <br>'.$GLOBALS['mod_strings']['LBL_CONTACT_SUPPORT'];
		    }
		}
	}
}

$status=$snip->getStatus();

$message=$status['message'];
$status=$status['status'];

if ($status=='pingfailed'){
	$status='notpurchased';
	$extra_error=$GLOBALS['mod_strings']['LBL_SNIP_STATUS_PINGBACK_FAIL_SUMMARY'];
}

if ($message=='' && $status != 'notpurchased') {
	if (isset ($GLOBALS['mod_strings']['LBL_SNIP_GENERIC_ERROR']))
		$message = $GLOBALS['mod_strings']['LBL_SNIP_GENERIC_ERROR'];
}

if ($status=='purchased_error')
	$sugar_smarty->assign('SNIP_ERROR_MESSAGE',$message);

require_once("install/install_utils.php");

$sugar_smarty->assign('TITLE',$title);
$sugar_smarty->assign('SNIP_STATUS',$status);
$sugar_smarty->assign('EXTRA_ERROR',$extra_error);
$sugar_smarty->assign('SNIP_EMAIL',$snip->getSnipEmail());
$sugar_smarty->assign('SNIP_URL',$snip->getSnipURL());
$sugar_smarty->assign('SUGAR_URL',$snip->getURL());
$sugar_smarty->assign('LICENSE',nl2br(trim(getLicenseContents("LICENSE.txt"))));

echo $sugar_smarty->fetch('modules/SNIP/ConfigureSnip.tpl');