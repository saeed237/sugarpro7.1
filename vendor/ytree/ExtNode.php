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

//node the tree view. no need to add a root node,a invisible root node will be added to the
//tree by default.
//predefined properties for a node are  id, label, target and href. label is required property.
//set the target and href property for cases where target is an iframe.
class ExtNode {
	//predefined node properties.
	var $_label;		//this is the only required property for a node.
	var $_href;
	var $id;
	
	//ad-hoc collection of node properties
	var $_properties=array();
	//collection of parmeter properties;
	var $_params=array();
	
	//sent to the javascript.
	var $uid; 		//unique id for the node.

	var $nodes=array();
	var $dynamic_load=false; //false means child records are pre-loaded.
	var $dynamicloadfunction='loadDataForNode'; //default script to load node data (children)
	var $expanded=false;  //show node expanded during initial load.
	 
	function ExtNode($id,$label,$show_expanded=true) {
		$this->_label=$label;
		$this->id = $id;	
		$this->_properties['text']=$label;
		$this->uid=microtime();
		$this->set_property('id',$id);
        $this->expanded = $show_expanded;
	}

	//properties set here will be accessible via
	//node.data object in javascript.
	//users can add a collection of paramaters that will
	//be passed to objects responding to tree events
 	function set_property($name, $value, $is_param=false) {
 		if(!empty($name) && ($value === 0 || !empty($value))) {
 			if ($is_param==false) {
 				$this->_properties[$name]=$value;
 			} else {
 				$this->_params[$name]=$value;
 			}	
 		}
 	}
 	
	//add a child node.
 	function add_node($node) {
  		$this->nodes[$node->uid]=$node;
  	}

	//return definition of the node. the definition is a multi-dimension array and has 3 parts.
	// data-> definition of the current node.
	// attributes=> collection of additional attributes such as style class etc..
	// nodes: definition of children nodes. 	
 	function get_definition() {
 		$ret=array();

 		$ret = $this->_properties; 
 		if (!empty($this->_params)) {
 			$ret[] = $this->_params;	
 		}		
 		
		$ret['dynamicload']=$this->dynamic_load;
		$ret['dynamicloadfunction']=$this->dynamicloadfunction;
		$ret['expanded']=$this->expanded;
		$ret['children'] = array();
		$ret['type'] = 1;
						 	
 		foreach ($this->nodes as $node) {
 			$ret['children'][]=$node->get_definition();
 		}
		//$ret['leaf'] = empty($ret['children']);
		return $ret;		
 	}
}
?>