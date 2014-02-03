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

class FieldViewer{
	public function FieldViewer(){
        self::__construct();
    }
    public function __construct() {
		$this->ss = new Sugar_Smarty();
	}
	function getLayout($vardef){

		if(empty($vardef['type']))$vardef['type'] = 'varchar';
		$mod = return_module_language($GLOBALS['current_language'], 'DynamicFields');
		$this->ss->assign('vardef', $vardef);
		$this->ss->assign('MOD', $mod);
		$this->ss->assign('APP', $GLOBALS['app_strings']);
		//Only display range search option if in Studio, not ModuleBuilder
		$this->ss->assign('range_search_option_enabled', empty($_REQUEST['view_package']));

		$GLOBALS['log']->debug('FieldViewer.php->getLayout() = '.$vardef['type']);
		switch($vardef['type']){
			case 'address':
                return $this->ss->fetch('modules/DynamicFields/templates/Fields/Forms/address.tpl');
			case 'bool':
				return $this->ss->fetch('modules/DynamicFields/templates/Fields/Forms/bool.tpl');
			case 'int':
				return $this->ss->fetch('modules/DynamicFields/templates/Fields/Forms/int.tpl');
			case 'float':
				return $this->ss->fetch('modules/DynamicFields/templates/Fields/Forms/float.tpl');
			case 'decimal':
				return $this->ss->fetch('modules/DynamicFields/templates/Fields/Forms/float.tpl');
			case 'date':
			    require_once('modules/DynamicFields/templates/Fields/Forms/date.php');
				return get_body($this->ss, $vardef);
			case 'datetimecombo':
			case 'datetime':
			    require_once('modules/DynamicFields/templates/Fields/Forms/datetimecombo.php');
				return get_body($this->ss, $vardef);
			case 'enum':
				require_once('modules/DynamicFields/templates/Fields/Forms/enum2.php');
				return get_body($this->ss, $vardef);
			case 'multienum':
				require_once('modules/DynamicFields/templates/Fields/Forms/multienum.php');
				return get_body($this->ss, $vardef);
			case 'radioenum':
				require_once('modules/DynamicFields/templates/Fields/Forms/radioenum.php');
				return get_body($this->ss, $vardef);
			case 'html':
				require_once('modules/DynamicFields/templates/Fields/Forms/html.php');
				return get_body($this->ss, $vardef);
			case 'currency':
				return $this->ss->fetch('modules/DynamicFields/templates/Fields/Forms/currency.tpl');
			case 'relate':
				require_once('modules/DynamicFields/templates/Fields/Forms/relate.php');
				return get_body($this->ss, $vardef);
			case 'parent':
				require_once('modules/DynamicFields/templates/Fields/Forms/parent.php');
				return get_body($this->ss, $vardef);
			case 'text':
				return $this->ss->fetch('modules/DynamicFields/templates/Fields/Forms/text.tpl');
			case 'encrypt':
				require_once('modules/DynamicFields/templates/Fields/Forms/encrypt.php');
				return get_body($this->ss, $vardef);
			case 'iframe':
				require_once('modules/DynamicFields/templates/Fields/Forms/iframe.php');
				return get_body($this->ss, $vardef);
			case 'url':
				require_once('modules/DynamicFields/templates/Fields/Forms/url.php');
				return get_body($this->ss, $vardef);
			case 'phone':
				require_once('modules/DynamicFields/templates/Fields/Forms/phone.php');
				return get_body($this->ss, $vardef);
			default:
			    if(SugarAutoLoader::requireWithCustom('modules/DynamicFields/templates/Fields/Forms/'. $vardef['type'] . '.php')) {
					return get_body($this->ss, $vardef);
				}else{
					return $this->ss->fetch('modules/DynamicFields/templates/Fields/Forms/varchar.tpl');
				}
		}
	}

}