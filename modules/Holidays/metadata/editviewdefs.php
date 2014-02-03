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

$viewdefs['Holidays']['EditView'] = array(
    'templateMeta' => array('maxColumns' => '2', 
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'), 
                                            array('label' => '10', 'field' => '30')
                                            ),
    ),
 'panels' =>array (
  'default' => 
  array (
    
    array (
      
      array (
        'name' => 'holiday_date',
      ),
      '',
    ),
    
    array (
      
      array (
        'name' => 'description',
      ),
    ),
    
    array (
    	array (
    		'name' => 'resource_name',
    		'displayParams'=>array('required'=>true),
    		'customCode' => '{if $PROJECT}<select name="person_type" id="person_type" onChange="showResourceSelect();">' .
							'<option value="">{$MOD.LBL_SELECT_RESOURCE_TYPE}</option>' .
							'<option value="Users">{$MOD.LBL_USER}</option>' .
							'<option value="Contacts">{$MOD.LBL_CONTACT}</option>' .
							'</select>' .
							'<span id="resourceSelector"></span>{/if}',
		),
	),
  ),
)


);
?>