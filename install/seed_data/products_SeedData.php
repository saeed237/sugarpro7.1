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

///include some fake products and categories as arrays
///for now we will just use the account and contact name info


//set parameters

$tree_depth = "3";		//how many levels deep is the tree
$tree_branches = "3";	//how many categories per level

$branch_leafs = "3";	//Products per category

//3 x 3 x 3 will produce 39 categories and 117 products		total nodes:156			
//3 x 5 x 5 will produce 155 categories and 775 products	total nodes:930			
//8 x 2 x 3 will produce 510 categories	and 1538 products	total nodes:2048		
//3 x 5 x 10 will product 155 catgories and 1550 products	total nodes:1705
//4 x 5 x 5 will produce 780 categories and 3900 products	total nodes:4680
//5 x 5 x 5 will product 3905 categories and 19525 products	total nodes:23430

$depth_flag = "1";

traverse_tree("", $depth_flag, $tree_depth, $tree_branches, $branch_leafs);


function traverse_tree($parent_id, $depth_flag, &$tree_depth, &$tree_branches, &$branch_leafs){
	//control how deep the tree goes
	$depth_flag = $depth_flag + 1;


	//loop through categories at each level
	for($i = 0; $i < $tree_branches; $i++){
	//echo "looping through level $i categories PARENT ID: $parent_id<br>";
		$last_id = create_category($parent_id);
		
		//loop through how many products per category
		for($j = 0; $j < $branch_leafs; $j++){
		
		
			create_product($last_id);
			
		//echo "looping through level $j products LAST ID: $last_id<br>";
		//end foreach create product
		}
		
		

		//echo "<BR>1. DEPTH FLAG: $depth_flag PRIOR TO checking depth flag value<BR>";
		if($depth_flag<="$tree_depth"){
		
			//echo "<BR>2. DEPTH FLAG: $depth_flag TREE DEPTH: $tree_depth<BR>";
		
			traverse_tree($last_id, $depth_flag, $tree_depth, $tree_branches, $branch_leafs);
		
			//echo "<BR> 3. DEPTH FLAG: $depth_flag AFTER recursive traverse <BR>";
			
		//end if to traverse deeper
		}
		
		
	//end foreach categories at each level
	}


//end function traverse_tree
}



function create_category($parent_id){
global $sugar_demodata;
$last_name_array = $sugar_demodata['last_name_array'];
$last_name_count = count($sugar_demodata['last_name_array']);


$last_name_max = $last_name_count - 1;
	
	$category = new ProductCategory();
	$category->name = $last_name_array[mt_rand(0,$last_name_max)] .$sugar_demodata['category_ext_name'];
	$category->parent_id = $parent_id;
    $key = array_rand($sugar_demodata['users']);
    $category->assigned_user_id = $sugar_demodata['users'][$key]['id'];
	$category->save();
	$cat_id = $category->id;
	unset($category);
	return $cat_id;
	

//end function create_category
}


function create_product($category_id)
{
    global $sugar_demodata;
    $first_name_array = $sugar_demodata['first_name_array'];
    $first_name_count = count($sugar_demodata['first_name_array']);
    $company_name_array = $sugar_demodata['company_name_array'];
    $company_name_count = count($sugar_demodata['company_name_array']);
    global $dollar_id;
    if (empty($dollar_id)) {
        $dollar_id = '-99';
    }
    global $manufacturer_id_arr;
    $first_name_max = $first_name_count - 1;

    $cost = rand(300, 600);
    $list = rand(700, 1000);
    $discount = rand($list - 200, $list - 50);

    $template = new ProductTemplate();
    $template->name = $first_name_array[mt_rand(0, $first_name_max)] . $sugar_demodata['product_ext_name'];
    $template->tax_class = "Taxable";
    $template->manufacturer_id = $manufacturer_id_arr[0];
    $template->currency_id = $dollar_id;
    $template->cost_price = $cost;
    $template->cost_usdollar = $cost;
    $template->list_price = $list;
    $template->list_usdollar = $list;
    $template->discount_price = $discount;
    $template->discount_usdollar = $discount;
    $template->pricing_formula = "IsList";
    $template->mft_part_num = $company_name_array[mt_rand(0, $company_name_count - 1)] . ' ' . mt_rand(
            1,
            1000000
        ) . "XYZ987";
    $template->pricing_factor = "1";
    $template->status = "Available";
    $template->weight = rand(10, 40);
    $template->date_available = "2004-10-15";
    $template->qty_in_stock = rand(0, 150);
    $template->category_id = $category_id;
    $template->save();

    unset($template);

//end function create_product
}
