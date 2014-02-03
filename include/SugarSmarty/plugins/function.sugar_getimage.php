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
 * Smarty {sugar_getimage} function plugin
 *
 * Type:     function
 * Name:     sugar_getimage
 * Purpose:  Returns HTML image or sprite
 * 
 * @author Aamir Mansoor (amansoor@sugarcrm.com) 
 * @author Cam McKinnon (cmckinnon@sugarcrm.com)
 * @param array
 * @param Smarty
 */

function smarty_function_sugar_getimage($params, &$smarty) {

	// error checking for required parameters
	if(!isset($params['name'])) 
		$smarty->trigger_error($GLOBALS['app_strings']['ERR_MISSING_REQUIRED_FIELDS'] . 'name');

	// temp hack to deprecate the use of other_attributes
	if(isset($params['other_attributes']))
		$params['attr'] = $params['other_attributes'];

	// set defaults
	if(!isset($params['attr']))
		$params['attr'] = '';
	if(!isset($params['width']))
		$params['width'] = null;
	if(!isset($params['height']))
		$params['height'] = null;
	if(!isset($params['alt'])) 
		$params['alt'] = '';

	// deprecated ?
	if(!isset($params['ext']))
		$params['ext'] = null;

	return SugarThemeRegistry::current()->getImage($params['name'], $params['attr'], $params['width'], $params['height'], $params['ext'], $params['alt']);	
}
?>
