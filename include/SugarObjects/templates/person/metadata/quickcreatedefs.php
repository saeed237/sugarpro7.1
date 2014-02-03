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
$viewdefs[$module_name]['QuickCreate'] = array(
    'templateMeta' => array('maxColumns' => '2', 
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'), 
                                            array('label' => '10', 'field' => '30'),
                                        ),
),
 'panels' =>array (
  'lbl_contact_information' => 
  array (
    
    array (
      array (
        'name' => 'first_name',
        'customCode' => '{html_options name="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
      ),
  	'assigned_user_name',
    ),
    
    array (
      array('name'=>'last_name', 'displayParams'=>array('required'=>true)),
      array('name'=>'team_name', 'displayParams'=>array('display'=>true)),
    ),
    
    array (
		'title',
		 'phone_work',
    ),
    
    array (
		'department',
		 'phone_mobile',
    ),
    
    array (
      	'phone_fax',
		'',
    ),    
  ),
  'lbl_email_addresses'=>array(
  	array('email1')
  ),

)


);
