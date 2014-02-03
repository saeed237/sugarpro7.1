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

if(ob_get_level() < 1)
	ob_start();
ob_implicit_flush(1);

// load the generated persistence file if found
$persistence = array();
if(file_exists($persist = sugar_cached('/modules/UpgradeWizard/_persistence.php'))) {
	require_once $persist;
}
require_once('modules/UpgradeWizard/uw_utils.php');

switch($_REQUEST['systemCheckStep']) {
	case 'find_all_files':
		ob_end_flush();
		$persistence['files_to_check'] = getFilesForPermsCheck();
        break;

	case 'check_found_files':
		if(empty($persistence['files_to_check'])) {
			logThis('*** ERROR: could not find persistent array of files to check');
			echo $mod_strings['ERR_UW_NO_FILES'];
		} else {
			ob_end_flush();
			$persistence = checkFiles($persistence['files_to_check'], true);
		}
	break;

	case 'check_files_status':
		$ret = ($persistence['filesNotWritable']) ? 'true' : 'false';
		echo $ret;
	break;
}

write_array_to_file('persistence', $persistence, $persist);
