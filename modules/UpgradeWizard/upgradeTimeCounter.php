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


session_start();
$GLOBALS['installing'] = true;


require_once('include/JSON.php');

require_once('include/utils/db_utils.php');

require_once('include/utils/zip_utils.php');

require_once('modules/UpgradeWizard/uw_utils.php');



$json = getJSONobj();
/*
$upgradeStepTime = $json->decode(html_entity_decode($_REQUEST['upgradeStepTime']));
if(isset($tagdata['jsonObject']) && $tagdata['jsonObject'] != null){
	$upgradeStepTime = $upgradeStepTime['jsonObject'];
 }

 if(!isset($_SESSION['totalUpgradeTime'])){
   $_SESSION['totalUpgradeTime'] = 0;
 }
*/

 $_SESSION['totalUpgradeTime'] = $_SESSION['totalUpgradeTime']+$_REQUEST['upgradeStepTime'];
 $response = $_SESSION['totalUpgradeTime'];

$GLOBALS['log']->fatal('TOTAL TIME .....'.$_SESSION['totalUpgradeTime']);
 //$uptime = $uptime+$_REQUEST['upgradeStepTime'];
 $GLOBALS['log']->fatal($response);


 if (!empty($response)) {
    $json = getJSONobj();
	print $json->encode($response);
 }

sugar_cleanup();
exit();

?>
