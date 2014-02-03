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


global $mod_strings;

$popupMeta = array('moduleMain' => 'ProspectList',
						'varName' => 'PROSPECTLIST',
						'orderBy' => 'name',
						'whereClauses' => 
							array('name' => 'prospect_lists.name',
									'list_type' => 'prospect_lists.list_type'),
						'searchInputs' =>
							array('name', 'list_type'),
						'selectDoms' =>
							array('LIST_OPTIONS' => 
											array('dom' => 'prospect_list_type_dom', 'searchInput' => 'list_type'),
								  ),
						'create' =>
							array('formBase' => 'ProspectListFormBase.php',
									'formBaseClass' => 'ProspectListFormBase',
									'getFormBodyParams' => array('','','ProspectListSave'),
									'createButton' => 'LNK_NEW_PROSPECT_LIST'
								  ),
						'listviewdefs' => array(
							'NAME' => array(
								'width' => '25', 
								'label' => 'LBL_LIST_PROSPECT_LIST_NAME', 
								'link' => true,
								'default' => true),
							'LIST_TYPE' => array(
								'width' => '15', 
								'label' => 'LBL_LIST_TYPE_LIST_NAME', 
								'default' => true),
							'DESCRIPTION' => array(
								'width' => '50', 
								'label' => 'LBL_LIST_DESCRIPTION', 
								'default' => true),
							'ASSIGNED_USER_NAME' => array(
								'width' => '10', 
								'label' => 'LBL_LIST_ASSIGNED_USER',
								'module' => 'Employees',
								'default' => true),
							),

						);


?>
 
 