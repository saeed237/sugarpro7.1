<?php
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

$module_name = '<module_name>';
$viewdefs[$module_name]['DetailView'] = array(
'templateMeta' => array('form' => array('buttons'=>array('EDIT', 'DUPLICATE', 'DELETE', 'FIND_DUPLICATES', 
                                                        ),
                                       ),
                        'useTabs' => true,
                        'maxColumns' => '2', 
                        'widths' => array(
                                        array('label' => '10', 'field' => '30'), 
                                        array('label' => '10', 'field' => '30')
                                        ),
                        ),
'panels' =>array (
  
  array (
    
    array (
      'name' => 'full_name',
	  'label' => 'LBL_NAME',
    ),
    
    //'full_name',
    array (
      'name' => 'phone_work',
    ),
  ),
  
  array (
    'title',
    
    array (
      'name' => 'phone_mobile',
    ),
  ),
  
  array (
	'department',
    
    array (
      'name' => 'phone_home',
      'label' => 'LBL_HOME_PHONE',
    ),
  ),
  
  array (
	NULL,
    array (
      'name' => 'phone_other',
      'label' => 'LBL_OTHER_PHONE',
    ),
  ),

  array (
	array (
      'name' => 'date_entered',
      'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
      'label' => 'LBL_DATE_ENTERED',
    ),
    array (
      'name' => 'phone_fax',
      'label' => 'LBL_FAX_PHONE',
    ),
  ),

  array (
     array (
      'name' => 'date_modified',
      'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
      'label' => 'LBL_DATE_MODIFIED',
    ),
    'do_not_call',
  ),
  array('assigned_user_name', ''),
  
  array( 
    'team_name',
    'email1'),

  array (
      array (
	      'name' => 'primary_address_street',
	      'label'=> 'LBL_PRIMARY_ADDRESS',
	      'type' => 'address',
	      'displayParams'=>array('key'=>'primary'),
      ),
      array (
	      'name' => 'alt_address_street',
	      'label'=> 'LBL_ALT_ADDRESS',
	      'type' => 'address',
	      'displayParams'=>array('key'=>'alt'),
      ),
  ),
  
  array (
    'description',
  ),

)
 
);
?>