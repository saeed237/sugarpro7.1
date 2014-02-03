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
require_once('vendor/nusoap//nusoap.php');

/**
 * ext_soap
 * This class is the soap implementation for the connector framework.
 * Connectors that use SOAP calls should subclass this class and provide
 * a getList and getItem method override to return results from the connector
 * @api
 */
abstract class ext_soap extends source {

	protected $_client;

 	/**
 	 * obj2array
 	 * Given an object, returns the object as an Array
 	 *
 	 * @param $obj Object to convert to an array
 	 * @return $out Array reflecting the object's properties
 	 */
 	public function obj2array($obj) {
	  $out = array();
	  if(empty($obj)) {
	     return $out;
	  }

	  foreach ($obj as $key => $val) {
	    switch(true) {
	      case is_object($val):
	         $out[$key] = $this->obj2array($val);
	         break;
	      case is_array($val):
	         $out[$key] = $this->obj2array($val);
	         break;
	      default:
	        $out[$key] = $val;
	    }
	  }
  	  return $out;
	}
}
