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

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$module_name = '<module_name>';
$_object_name = '<_object_name>';
$viewdefs[$module_name]['DetailView'] = array(
'templateMeta' => array('maxColumns' => '2',
                        'form' => array(),
                        'widths' => array(
                                        array('label' => '10', 'field' => '30'),
                                        array('label' => '10', 'field' => '30')
                                        ),
                        ),
'panels' =>array (

  array (

    array (
      'name' => 'document_name',
      'label' => 'LBL_DOC_NAME',
    ),
     array (
      'name' => 'uploadfile',
      'displayParams' => array('link'=>'uploadfile', 'id'=>'id'),
    ),


  ),
  array (
      'category_id',
      'subcategory_id',
  ),

  array (

	  'status',

  ),
  array (
      'active_date',
      'exp_date',
  ),

  array (
	  'team_name',
    array('name'=>'assigned_user_name', 'label'=>'LBL_ASSIGNED_TO'),
  ),

  array (

    array (
      'name' => 'description',
      'label' => 'LBL_DOC_DESCRIPTION',
    ),
  ),

)
);

