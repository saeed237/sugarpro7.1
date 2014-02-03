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


/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r53865 - 2010-01-19 21:51:54 -0800 (Tue, 19 Jan 2010) - lam - updated styles for button slider

r53792 - 2010-01-18 13:37:35 -0800 (Mon, 18 Jan 2010) - roger - adding code to support slider buttons.


*/


/**
 * smarty_function_sugar_button
 * This is the constructor for the Smarty plugin.
 *
 * @param $params The runtime Smarty key/value arguments
 * @param $smarty The reference to the Smarty object used in this invocation
 */
function smarty_function_sugar_button_slider($params, &$smarty)
{
   if(empty($params['module'])) {
   	  $smarty->trigger_error("sugar_button_slider: missing required param (module)");
   } else if(empty($params['buttons'])) {
   	  $smarty->trigger_error("sugar_button_slider: missing required param (buttons)");
   } else if(empty($params['view'])) {
   	  $smarty->trigger_error("sugar_button_slider: missing required param (view)");
   }
	$module = $params['module'];
   	$view = $params['view'];
   	$buttons = $params['buttons'];
   	$str = '';
   if(is_array($buttons)) {
   	  if(count($buttons) <= 2){
   	  	foreach($buttons as $val => $button){
   	  		$str .= smarty_function_sugar_button(array('module' => $module, 'id' => $button, 'view' => $view), $smarty);
   	  	}
   	  }else{
   	  	$str  = '<div id="buttonSlide" class="yui-module">';
   	  	$str .= '<table border="0">';
   	  	$str .='<tr><td>';
   	  	$str .='<div class="yui-hd">';
   	  	for($i = 0; $i < 2; $i++){
   	  		$button = $buttons[$i];
   	  		$str .= smarty_function_sugar_button(array('module' => $module, 'id' => $button, 'view' => $view), $smarty);
   	  		$str .= ' ';
   	  	}
   	  	$str .= '</div></td>';
   	  	$str .='<td align="right"> <div class="yui-bd">';
   	 	for($i = 2; $i < count($buttons); $i++){
   	  		$button = $buttons[$i];
   	  		$str .= smarty_function_sugar_button(array('module' => $module, 'id' => $button, 'view' => $view), $smarty);
   	  		$str .= ' ';
   	 	}
   	  	$str .='</div></td>';
   	  	$str .='</tr></table>';
   	  }
   }
	return $str;
}

?>
