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

require_once('vendor/ytree/Node.php');

//function returns an array of objects of Node type.
function get_node_data($params,$get_array=false) {
    $click_level=$params['TREE']['depth'];
    $parent_id=$params['NODES'][$click_level]['id'];
	$ret = array();
	
	$nodes=get_categories_and_products($parent_id);
	foreach ($nodes as $node) {
		$ret['nodes'][]=$node->get_definition();
	}
	$json = new JSON(JSON_LOOSE_TYPE);
	$str=$json->encode($ret);
	return $str;
}

/*
 * Constructs the nodes give parent node id, if the parent node_id is null
 * top level nodes will be returned. function will return both product categories
 * and product.
 *
 * $open_nodes_ids is an hierachical list of nodes that should be open when the tree in rendered.
 * node at index 0 represents the topmost level node. This fuction calls itself recursively to build
 * open nodes.
 */
function get_categories_and_products($parent_id) {
    $href_string = "javascript:set_return('productcatalog')";
    $nodes=array();

    if ($parent_id=='' or empty($parent_id)) {
        $query="select id, name , 'category' type from product_categories where (parent_id is null or parent_id='') and deleted=0";
        $query.=" union select id, name , 'product' type from product_templates where (category_id is null or category_id='') and deleted=0";
        
    } else {
        $query="select id, name , 'category' type from product_categories where parent_id ='$parent_id' and deleted=0";
        $query.=" union select id, name , 'product' type from product_templates where category_id ='$parent_id' and deleted=0";
    }

    $result=$GLOBALS['db']->query($query);
    while (($row=$GLOBALS['db']->fetchByAssoc($result))!= null) {
        $node = new Node($row['id'], $row['name']); 
        $node->set_property("href", $href_string);
        $node->set_property("type", $row['type']);
        if ($row['type']=='product') {
            $node->expanded = false;
            $node->dynamic_load = false;
        } else {
            $node->expanded = false;
            $node->dynamic_load = true;        
        }
        $nodes[]=$node;
    }
    return $nodes;
}
?>