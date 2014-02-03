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


require_once('include/connectors/sources/default/source.php');

/**
 * REST generic connector
 * @api
 */
abstract class ext_rest extends source{

	protected $_url;

 	protected function fetchUrl($url){
 		$data = '';
 		$data = @file_get_contents($url);
 		if(empty($data)) {
 		   $GLOBALS['log']->error("Unable to retrieve contents from url:[{$url}]");
 		}
 		return $data;
 	}

 	public function getUrl(){
 		return $this->_url;
 	}

 	public function setUrl($url){
 		$this->_url = $url;
 	}
}
?>