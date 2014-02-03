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

 $viewdefs[$module_name]['EditView'] = array(
    'templateMeta' => array('form' => array('enctype'=>'multipart/form-data',
                                            'hidden'=>array()),

                            'maxColumns' => '2',
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'),
                                            array('label' => '10', 'field' => '30')
                                            ),
'javascript' =>
	'{sugar_getscript file="include/javascript/popup_parent_helper.js"}
	{sugar_getscript file="cache/include/javascript/sugar_grp_jsolait.js"}
	{sugar_getscript file="modules/Documents/documents.js"}',
),
 'panels' =>array (
  'default' =>
  array (

    array (
      'document_name',
      array(
      		'name'=>'uploadfile',
            'displayParams' => array('onchangeSetFileNameTo' => 'document_name'),
      ),

	),

    array (
       'category_id',
       'subcategory_id',
    ),

    array (
      'assigned_user_name',
      array('name'=>'team_name','displayParams'=>array('required'=>true)),
    ),

    array (
      'active_date',
      'exp_date',
    ),

	array('status_id'),
    array (

      array('name'=>'description'),

    ),
  ),
)
);

