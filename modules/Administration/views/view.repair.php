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
require_once('modules/Administration/QuickRepairAndRebuild.php');

class ViewRepair extends SugarView
{
    /**
	 * @see SugarView::display()
	 */
	public function display()
	{
	    $randc = new RepairAndClear();
        $actions = array();
        $actions[] = 'clearAll';
        $randc->repairAndClearAll($actions, array(translate('LBL_ALL_MODULES')), false,true);
        
        echo <<<EOHTML
<br /><br /><a href="index.php?module=Administration&action=index">{$GLOBALS['mod_strings']['LBL_DIAGNOSTIC_DELETE_RETURN']}</a>
EOHTML;
	}
}
