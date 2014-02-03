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



class SugarWidgetFieldDecimal extends SugarWidgetFieldInt
{
 function displayListPlain($layout_def)
 {
 	
     //Bug40995
	if($layout_def['precision']!='')
	 {
		return format_number(parent::displayListPlain($layout_def), $layout_def['precision'], $layout_def['precision']);
	 }
	 //Bug40995
	 else
	 {
		return format_number(parent::displayListPlain($layout_def), 2, 2);
	 }
 }
}

?>
