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

/**
 * Generic formatter
 * @api
 */
class default_formatter {

   protected $_ss;
   protected $_component;
   protected $_tplFileName;
   protected $_module;
   protected $_hoverField;

   public function __construct() {}

   public function getDetailViewFormat()
   {
   	  $source = $this->_component->getSource();
   	  $class = get_class($source);
   	  $dir = str_replace('_', '/', $class);
   	  $config = $source->getConfig();
   	  $this->_ss->assign('config', $config);
   	  $this->_ss->assign('source', $class);
   	  $this->_ss->assign('module', $this->_module);
   	  $mapping = $source->getMapping();
   	  $mapping = !empty($mapping['beans'][$this->_module]) ? implode(',', array_values($mapping['beans'][$this->_module])) : '';
   	  $this->_ss->assign('mapping', $mapping);

   	  $tpl = SugarAutoLoader::existingCustomOne("modules/Connectors/connectors/formatters/{$dir}/tpls/default.tpl",
   	      "modules/Connectors/connectors/formatters/{$dir}/tpls/{$this->_module}.tpl");
   	  if(!empty($tpl)) {
   	  	return  $this->_ss->fetch($tpl);
   	  }

   	  if(strpos('_soap_', $class) !== false) {
      	 return $this->_ss->fetch("include/connectors/formatters/ext/soap/tpls/default.tpl");
      } else {
      	 return $this->_ss->fetch("include/connectors/formatters/ext/rest/tpls/default.tpl");
      }
   }

   public function getEditViewFormat() {
   	  return '';
   }

   public function getListViewFormat() {
   	  return '';
   }

   public function getSearchFormFormat() {
   	  return '';
   }

   protected function fetchSmarty()
   {
   	  $source = $this->_component->getSource();
   	  $class = get_class($source);
   	  $dir = str_replace('_', '/', $class);
   	  $config = $source->getConfig();
   	  $this->_ss->assign('config', $config);
	  $this->_ss->assign('source', $class);
	  $this->_ss->assign('module', $this->_module);

	  $tpl = SugarAutoLoader::existingCustomOne("modules/Connectors/connectors/formatters/{$dir}/tpls/default.tpl",
	      "modules/Connectors/connectors/formatters/{$dir}/tpls/{$this->_module}.tpl");
	  if(!empty($tpl)) {
	  	return $this->_ss->fetch($tpl);
	  }

	  return $this->_ss->fetch("modules/Connectors/connectors/formatters/{$dir}/tpls/default.tpl");
   }

   public function getSourceMapping(){
   	  $source = $this->_component->getSource();
      $mapping = $source->getMapping();
      return $mapping;
   }

   public function setSmarty($smarty) {
   	   $this->_ss = $smarty;
   }

   public function getSmarty() {
   	   return $this->_ss;
   }

   public function setComponent($component) {
   	   $this->_component = $component;
   }

   public function getComponent() {
   	   return $this->_component;
   }

   public function getTplFileName(){
   		return $this->tplFileName;
   }

   public function setTplFileName($tplFileName){
   		$this->tplFileName = $tplFileName;
   }

   public function setModule($module) {
   	    $this->_module = $module;
   }

   public function getModule() {
   	    return $this->_module;
   }

   public function getIconFilePath() {
   	    return '';
   }
}
?>