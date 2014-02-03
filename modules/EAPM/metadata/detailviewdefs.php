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

$module_name = 'EAPM';
$viewdefs[$module_name]['DetailView'] = array(
'templateMeta' => array('maxColumns' => '2',
                        'widths' => array(
                                        array('label' => '10', 'field' => '30'),
                                        array('label' => '10', 'field' => '30')
                                        ),
                            'form' => array(
                                'buttons' =>
                                array (
                                  0 => 'EDIT',
                                  array('customCode'=>'<input title="{$MOD.LBL_REAUTHENTICATE_LABEL}" class="button" onclick="window.open(\'index.php?module=EAPM&action=Reauthenticate&record={$fields.id.value}&closeWhenDone=1&refreshParentWindow=1\',\'EAPM\');" type="button" name="Reauthenticate" id="Reauthenticate" value="{$MOD.LBL_REAUTHENTICATE_LABEL}">',
                                      //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                                      'sugar_html' => array(
                                          'type' => 'button',
                                          'value' => '{$MOD.LBL_REAUTHENTICATE_LABEL}',
                                          'htmlOptions' => array(
                                              'title' => '{$MOD.LBL_REAUTHENTICATE_LABEL}',
                                              'class' => 'button',
                                              'onclick' => 'window.open(\'index.php?module=EAPM&action=Reauthenticate&record={$fields.id.value}&closeWhenDone=1&refreshParentWindow=1\',\'EAPM\');',
                                              'name' => 'Reauthenticate',
                                              'id' => 'Reauthenticate',
                                          ),
                                      ),
                                  ),
                                  array ('customCode' => '{if $bean->aclAccess("delete")}<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" onclick="this.form.return_module.value=\'Users\'; this.form.return_action.value=\'EditView\'; this.form.return_id.value=\'{$return_id}\'; this.form.action.value=\'Delete\'; return confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\');" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}">{/if}',
                                      //Bug#51778: The custom code will be replaced with sugar_html. customCode will be deplicated.
                                      'sugar_html' => array(
                                          'type' => 'submit',
                                          'value' => '{$APP.LBL_DELETE_BUTTON_LABEL}',
                                          'htmlOptions' => array(
                                              'title' => '{$APP.LBL_DELETE_BUTTON_TITLE}',
                                              'accessKey' => '{$APP.LBL_DELETE_BUTTON_KEY}',
                                              'class' => 'button',
                                              'onclick' => 'this.form.return_module.value=\'Users\'; this.form.return_action.value=\'EditView\'; this.form.return_id.value=\'{$return_id}\'; this.form.action.value=\'Delete\'; return confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\');',
                                              'name' => 'Delete',
                                          ),
                                          'template' => '{if $bean->aclAccess("delete")}[CONTENT]{/if}',
                                      ),

                                  ),
                                  ),
                                'footerTpl'=>'modules/EAPM/tpls/DetailViewFooter.tpl',),
                        ),

'panels' =>array (
    array('application', 'validated'),
    array('name',        'url'),

  array (
	array (
      'name' => 'date_entered',
      'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
      'label' => 'LBL_DATE_ENTERED',
    ),
    array (
      'name' => 'date_modified',
      'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
      'label' => 'LBL_DATE_MODIFIED',
    ),
  ),

)
);
?>
