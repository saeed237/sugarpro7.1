<?php
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

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sugar_getscript} function plugin
 *
 * Type:     function<br>
 * Name:     sugar_getscript<br>
 * Purpose:  Creates script tag for filename with caching string
 *
 * @param array
 * @param Smarty
 */
function smarty_function_sugar_getscript($params, &$smarty)
{
	if(!isset($params['file'])) {
		   $smarty->trigger_error($GLOBALS['app_strings']['ERR_MISSING_REQUIRED_FIELDS'] . 'file');
	}
 	return getVersionedScript($params['file']);
}
?>