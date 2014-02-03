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

/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/formbase.php');
require_once('modules/Quotes/config.php');
require_once('include/SugarFields/SugarFieldHandler.php');
Activity::disable();
$focus = BeanFactory::getBean('Quotes');
$focus = populateFromPost('', $focus);

if(!$focus->ACLAccess('Save')){
	ACLController::displayNoAccess(true);
	sugar_cleanup(true);
}

//we have to commit the teams here in order to obtain the team_set_id for use with products and product bundles.
if(empty($focus->teams)){
	$focus->load_relationship('teams');
}
$focus->teams->save();
//bug: 35297 - set the teams to have not been saved, so workflow can update if necessary
$focus->teams->setSaved(false);

if (!empty($_POST['assigned_user_id']) && ($focus->assigned_user_id != $_POST['assigned_user_id']) && ($_POST['assigned_user_id'] != $current_user->id)) {
	$check_notify = TRUE;
}
else {
	$check_notify = FALSE;
}

//bug55337 - Inline edit to different stage, cause total amount to display 0
if(!isset($_REQUEST['from_dcmenu']))
{
    $focus->tax = 0;
    $focus->total = 0;
    $focus->subtotal = 0;
    $focus->deal_tot = 0;
    $focus->new_sub = 0;
    $focus->shipping = 0;
    $focus->tax_usdollar = 0;
    $focus->total_usdollar = 0;
    $focus->subtotal_usdollar = 0;
    $focus->shipping_usdollar = 0;
}

if(empty($_REQUEST['calc_grand_total'])){
	$focus->calc_grand_total = 0;
}else{
	$focus->calc_grand_total = 1;
}
if(empty($_REQUEST['show_line_nums'])){
	$focus->show_line_nums = 0;
}else{
	$focus->show_line_nums = 1;
}

if(empty($focus->id)) {
	//bug 14323, add this to create products firsts, and create the quotes at last, so the workflow can manipulate the products.
    $focus->id = create_guid();
    $focus->new_with_id = true;
}

//remove the relate id element if this is a duplicate
if(isset($_REQUEST['duplicateSave']) && isset($_REQUEST['relate_id'])){
	//this is a 'create duplicate' quote, keeping the relate_id in focus will assign the quote product bundles 
	//to the original quote, not the new duplicate one, so we will unset the element
	unset($_REQUEST['relate_id']);
}

	global $beanFiles;
	require_once($beanFiles['Product']);
	$GLOBALS['log']->debug("Saving associated products");

	$i = 0;

	if(isset($_POST['product_count'])){
		$product_count = $_POST['product_count'];
	}
	//totals keys is a list of tables for the products bundles
	if(isset($_REQUEST['total'])){
	    $total_keys = array_keys($_REQUEST['total']);
	}else{
		$total_keys = array();
	}
	$product_bundels = array();
	for($k = 0; $k < sizeof($total_keys); $k++){
		$pb = BeanFactory::getBean('ProductBundles');

		if(substr_count($total_keys[$k], 'group_') == 0){
				$pb->id = $total_keys[$k];
		}

		$pb->team_id = $focus->team_id;
        $pb->team_set_id = $focus->team_set_id;

		$pb->tax = unformat_number($_REQUEST['tax'][$total_keys[$k]]);
		$pb->shipping = unformat_number($_REQUEST['shipping'][$total_keys[$k]]);
		$pb->subtotal = unformat_number($_REQUEST['subtotal'][$total_keys[$k]]);
		$pb->deal_tot = unformat_number($_REQUEST['deal_tot'][$total_keys[$k]]);
		$pb->new_sub = unformat_number($_REQUEST['new_sub'][$total_keys[$k]]);
		$pb->total = unformat_number($_REQUEST['total'][$total_keys[$k]]);
		$pb->currency_id = $focus->currency_id;
		$pb->bundle_stage = $_REQUEST['bundle_stage'][$total_keys[$k]];
		$pb->name = $_REQUEST['bundle_name'][$total_keys[$k]];

            // Bug 54931. Grand Total for custom groups too.
			$focus->tax += $pb->tax;
			$focus->shipping += $pb->shipping;
			$focus->subtotal += $pb->subtotal;
			$focus->deal_tot += $pb->deal_tot;
			$focus->new_sub += $pb->new_sub;
			$focus->total += $pb->total;

		$product_bundels[$total_keys[$k]] = $pb->save();
		if(substr_count($total_keys[$k], 'group_') > 0){
            $pb->set_productbundle_quote_relationship($focus->id, $pb->id, $k);
		}

		//clear the old relationships out
		$pb->clear_productbundle_product_relationship($product_bundels[$total_keys[$k]]);
		$pb->clear_product_bundle_note_relationship($product_bundels[$total_keys[$k]]);
	}

	$pb = BeanFactory::getBean('ProductBundles');
	$deletedGroups = array();
	if(isset($_POST['delete_table'])){
	foreach($_POST['delete_table'] as $todelete){
		if($todelete != 1){
			$pb->mark_deleted($todelete);
			$deletedGroups[$todelete] = $todelete;
		}
	}
	}
	//Fix bug 25509
	$focus->process_save_dates = true;

	$pb = BeanFactory::getBean('ProductBundles');
	for($i = 0; $i < $product_count; $i++) {

		if((isset($_POST['delete'][$i]) && $_POST['delete'][$i] != '1')){
			$product = BeanFactory::getBean('Products');
			$GLOBALS['log']->debug("deleting product id ".$_POST['delete'][$i]);
			$product->mark_deleted($_POST['delete'][$i]);
		// delete a comment row
		} else if (isset($_POST['comment_delete'][$i]) && $_POST['comment_delete'][$i] != '1' && !isset($_REQUEST['duplicateSave'])) {
			$product_bundle_note = BeanFactory::getBean('ProductBundleNotes');
			$GLOBALS['log']->debug("Deleting Product Bundle Note Id: ".$_POST['comment_delete'][$i]);
			$product_bundle_note->mark_deleted($_POST['comment_delete'][$i]);
		}
		// insert/update a product into products table
		else if (!empty($_POST['product_name'][$i]) && !empty($_POST['parent_group'][$i])) {
		$product = BeanFactory::getBean('Products');
		$the_product_template_id = '-1';
		if (!empty($_POST['product_id'][$i])) {
			$product->retrieve($_POST['product_id'][$i]);
			$the_product_template_id = $product->product_template_id;
		}
		$GLOBALS['log']->debug("product id is $product->id");
		$GLOBALS['log']->debug("product template id is $product->product_template_id");

		foreach($product->column_fields as $field)
		{
			if ($field == 'name') $j = 'product_name';
			elseif ($field == 'description') $j = 'product_description';
			else $j = $field;
			if(isset($_POST[$j]) && is_array($_POST[$j]) && isset($_POST[$j][$i]))
			{
				$value = $_POST[$j][$i];
                if ( isset($product->field_defs[$field]['type']) ) {
                    $sugarField = SugarFieldHandler::getSugarField($product->field_defs[$field]['type']);
                    $sugarField->save($product,array($field=>$value),$field,$product->field_defs[$field]);
                } else {
                    $product->$field = $value;
                }
			}
		}
		$product->currency_id = $focus->currency_id;

		$product->team_id = $focus->team_id;
		$product->team_set_id = $focus->team_set_id;

		$product->quote_id=$focus->id;
        $product->account_id=$focus->billing_account_id;  
        $product->contact_id=$focus->billing_contact_id;
		//SM: removed as per Bug 15305 $product->status=$focus->quote_type;
		// if ($focus->quote_stage == 'Closed Accepted') $product->status='Orders';
            $product->ignoreQuoteSave = true;
    		$product->save();
    		$pb->set_productbundle_product_relationship($product->id,$_POST['parent_group_position'][$i], $product_bundels[$_REQUEST['parent_group'][$i]] );
		}

		// insert comment row
		else if (!empty($_POST['comment_index'][$i]) && !empty($_POST['parent_group'][$i])) {
			$product_bundle_note = BeanFactory::getBean('ProductBundleNotes');
			if (!empty($_POST['comment_id'][$i]) && !isset($_REQUEST['duplicateSave'])) {
				$product_bundle_note->id = $_POST['comment_id'][$i];
			}
			$product_bundle_note->description = $_POST['comment_description'][$i];
			$product_bundle_note->save();
			$pb->set_product_bundle_note_relationship($_POST['parent_group_position'][$i], $product_bundle_note->id, $product_bundels[$_REQUEST['parent_group'][$i]]);
	}
}

if (isset($GLOBALS['check_notify'])) {
	$check_notify = $GLOBALS['check_notify'];
}
else {
	$check_notify = FALSE;
}
$focus->save($check_notify);

$return_id = $focus->id;

$GLOBALS['log']->debug("Saved record with id of ".$return_id);
$return_module = 'Quotes';
if (!empty($_REQUEST['return_module']))
{
	$return_module = $_REQUEST['return_module'];
}
handleRedirect($return_id,$return_module);


?>
