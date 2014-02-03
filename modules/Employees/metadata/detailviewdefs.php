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

$viewdefs['Employees']['DetailView'] = array(
'templateMeta' => array('form' => array('buttons'=>array(
    array('customCode'=>'{if $DISPLAY_EDIT}<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button" onclick="this.form.return_module.value=\'{$module}\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'EditView\'" type="submit" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}">{/if}',
        //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
        'sugar_html' => array(
            'type' => 'submit',
            'value' => '{$APP.LBL_EDIT_BUTTON_LABEL}',
            'htmlOptions' => array(
                'title' => '{$APP.LBL_EDIT_BUTTON_TITLE}',
                'accessKey' => '{$APP.LBL_EDIT_BUTTON_KEY}',
                'class' => 'button',
                'onclick' => 'this.form.return_module.value=\'{$module}\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'EditView\';',
                'id' => 'edit_button',
                'name' => 'Edit'
            ),
            'template' => '{if $DISPLAY_EDIT}[CONTENT]{/if}',
        ),
    ),
    array('customCode'=>'{if $DISPLAY_DUPLICATE}<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" onclick="this.form.return_module.value=\'{$module}\'     ; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.isDuplicate.value=true; this.form.action.value=\'EditView\'" type="submit" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}" id="duplicate_button">{/if}',
        //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
        'sugar_html' => array(
            'type' => 'submit',
            'value' => '{$APP.LBL_DUPLICATE_BUTTON_LABEL}',
            'htmlOptions' => array(
                'title' => '{$APP.LBL_DUPLICATE_BUTTON_TITLE}',
                'accessKey' => '{$APP.LBL_DUPLICATE_BUTTON_KEY}',
                'class' => 'button',
                'onclick' => 'this.form.return_module.value=\'{$module}\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$id}\'; this.form.isDuplicate.value=true; this.form.action.value=\'EditView\';',
                'name' => 'Duplicate',
                'id' => 'duplicate_button'
            ),
            'template' => '{if $DISPLAY_DUPLICATE}[CONTENT]{/if}'
        ),
    ),
    
    array('customCode'=>'{if $DISPLAY_DELETE}<input title="{$APP.LBL_DELETE_BUTTON_LABEL}" accessKey="{$APP.LBL_DELETE_BUTTON_LABEL}" class="button" onclick="if( confirm(\'{$DELETE_WARNING}\') ) {ldelim} this.form.return_module.value=\'{$module}\'; this.form.return_action.value=\'index\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'delete\'; this.form.submit();{rdelim}" type="button" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}" id="delete_button">{/if}',
        //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
        'sugar_html' => array(
            'type' => 'button',
            'value' => '{$APP.LBL_DELETE_BUTTON_LABEL}',
                'htmlOptions' => array(
                    'title' => '{$APP.LBL_DELETE_BUTTON_LABEL}',
                    'accessKey' => '{$APP.LBL_DELETE_BUTTON_LABEL}',
                    'class' => 'button',
                    'onclick' => 'if( confirm(\'{$DELETE_WARNING}\') ) {ldelim} this.form.return_module.value=\'{$module}\'; this.form.return_action.value=\'index\'; this.form.return_id.value=\'{$id}\'; this.form.action.value=\'delete\'; this.form.submit();{rdelim}',
                    'name' => 'Delete',
                    'id' => 'delete_button',
                ),
            'template' => '{if $DISPLAY_DELETE}[CONTENT]{/if}'
        ),
    ),
                                                         )
                        ),
                        'maxColumns' => '2', 
                        'widths' => array(
                                        array('label' => '10', 'field' => '30'), 
                                        array('label' => '10', 'field' => '30')
                                        ),
                        ),
'panels' =>array (

  array (
	'employee_status',
	  array (
	    'name'=>'picture',
	    'label' =>'LBL_PICTURE_FILE',      
	  ),
  ),
  
  array (
    array (
      'name' => 'first_name',
      'customCode' => '{$fields.full_name.value}',
      'label' => 'LBL_NAME',
    ),
  ),
  
  array (
    
    array (
      'name' => 'title',
      'label' => 'LBL_TITLE',
    ),
    
    array (
      'name' => 'phone_work',
      'label' => 'LBL_OFFICE_PHONE',
    ),
  ),
  
  array (
    
    array (
      'name' => 'department',
      'label' => 'LBL_DEPARTMENT',
    ),
    
    array (
      'name' => 'phone_mobile',
      'label' => 'LBL_MOBILE_PHONE',
    ),
  ),
  
  array (
    
    array (
      'name' => 'reports_to_name',
      'customCode' => '<a href="index.php?module=Employees&action=DetailView&record={$fields.reports_to_id.value}">{$fields.reports_to_name.value}</a>',
      'label' => 'LBL_REPORTS_TO_NAME',
    ),
    
    array (
      'name' => 'phone_other',
      'label' => 'LBL_OTHER',
    ),
  ),
  
  array (
    '',
    array (
      'name' => 'phone_fax',
      'label' => 'LBL_FAX',
    ),
  ),
  
  array (
    
    '',
    
    array (
      'name' => 'phone_home',
      'label' => 'LBL_HOME_PHONE',
    ),
  ),
  
  array (
    
    array (
      'name' => 'messenger_type',
      'label' => 'LBL_MESSENGER_TYPE',
    ),
  ),
  
  array (
    
    array (
      'name' => 'messenger_id',
      'label' => 'LBL_MESSENGER_ID',
    ),
  ),
  
  array (
    
    array (
      'name' => 'address_country',
      'customCode' => '{$fields.address_street.value}<br>{$fields.address_city.value} {$fields.address_state.value}&nbsp;&nbsp;{$fields.address_postalcode.value}<br>{$fields.address_country.value}',
      'label' => 'LBL_ADDRESS',
    ),
  ),
  
  array (
    
    array (
      'name' => 'description',
      'label' => 'LBL_NOTES',
    ),
  ),
  array(
  array (
      'name' => 'email1',
      'label' => 'LBL_EMAIL',
    ),
  ),

)


   
);
?>