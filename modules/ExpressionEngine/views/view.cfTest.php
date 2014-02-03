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

class ViewCfTest extends SugarView
{
	function ViewCfTest(){
		$this->options['show_footer'] = true;
		$this->options['show_header'] = true;
 		parent::SugarView();
 	}
 	
 	function display() {
 		require_once("include/Expressions/Dependency.php");
 		require_once("include/TemplateHandler/TemplateHandler.php");
 		$th = new TemplateHandler();
 		$depScript = $th->createDependencyJavascript(array(
 			'phone_office' => array(
 				'calculated' => true, 
 				"formula" => 'add(strlen($name), $employees)',
 				"enforced" => true,
 		)),array(), "EditView");
 		$smarty = new Sugar_Smarty();
 		$smarty->assign("dependencies", $depScript);
 		$smarty->display('modules/ExpressionEngine/tpls/cfTest.tpl');
 	}
}