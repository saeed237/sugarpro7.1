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

$viewdefs ['Notes'] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
         
        array (
          'label' => '10',
          'field' => '30',
        ),
         
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
    ),
    'panels' => 
    array (
      'lbl_note_information' => 
      array (
         
        array (
           'contact_name',
           
          array (
            'name' => 'parent_name',
            'customLabel' => '{sugar_translate label=\'LBL_MODULE_NAME\' module=$fields.parent_type.value}',
          ),
        ),
         
        array (
          array (
            'name' => 'name',
            'label' => 'LBL_SUBJECT',
          ),
        ),
         
        array (
           
          array (
            'name' => 'filename',
          ),          
        ),
         
        array (
           
          array (
            'name' => 'description',
            'label' => 'LBL_NOTE_STATUS',
          ),
        ),
      ),

        'LBL_PANEL_ASSIGNMENT' => array(
	        array (
	          'assigned_user_name',
	          array (
	            'name' => 'date_modified',
	            'label' => 'LBL_DATE_MODIFIED',
	            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
	          )
	        ),
	        array (
			  'team_name',
			  array (
	            'name' => 'date_entered',
	            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
	          )
	        ),
        ),      
    ),
  ),
);
?>
