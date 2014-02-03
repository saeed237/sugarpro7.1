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



$subpanel_layout = array(
	'top_buttons' => array(
		array('widget_class' => 'SubPanelTopCreateButton'),
		array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Accounts'),
	),

	'where' => '',
	
	'list_fields' => array (
	  'name' => 
	  array (
	    'vname' => 'LBL_LIST_ACCOUNT_NAME',
	    'widget_class' => 'SubPanelDetailViewLink',
	    'width' => '45%',
	    'default' => true,
	  ),
	  'billing_address_city' => 
	  array (
	    'vname' => 'LBL_LIST_CITY',
	    'width' => '20%',
	    'default' => true,
	  ),
	  'billing_address_country' => 
	  array (
	    'type' => 'varchar',
	    'vname' => 'LBL_BILLING_ADDRESS_COUNTRY',
	    'width' => '7%',
	    'default' => true,
	  ),
	  'phone_office' => 
	  array (
	    'vname' => 'LBL_LIST_PHONE',
	    'width' => '20%',
	    'default' => true,
	  ),
	  'edit_button' => 
	  array (
	    'vname' => 'LBL_EDIT_BUTTON',
	    'widget_class' => 'SubPanelEditButton',
	    'width' => '4%',
	    'default' => true,
	  ),
	  'remove_button' => 
	  array (
	    'vname' => 'LBL_REMOVE',
	    'widget_class' => 'SubPanelRemoveButtonAccount',
	    'width' => '4%',
	    'default' => true,
	  ),
   )	
);
?>
