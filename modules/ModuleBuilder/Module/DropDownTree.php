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


require_once('modules/ModuleBuilder/MB/MBPackageTree.php');
require_once('modules/ModuleBuilder/Module/DropDownBrowser.php');

class DropDownTree extends MBPackageTree{
	function DropDownTree(){
		$this->tree = new Tree('package_tree');
		$this->tree->id = 'package_tree';
		$this->mb = new DropDownBrowser();
		$this->populateTree($this->mb->getNodes(), $this->tree);
	}
	
	function getName(){
		return translate('LBL_SECTION_PACKAGES');
	}
}
?>