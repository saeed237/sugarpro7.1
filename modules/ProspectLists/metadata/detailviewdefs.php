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

$viewdefs['ProspectLists']['DetailView'] = array(
'templateMeta' => array('form' => array('closeFormBeforeCustomButtons' => true,'buttons'=>array('EDIT', 'DUPLICATE', 'DELETE', 
array('customCode'=> '<input title="{$APP.LBL_EXPORT}"  class="button" type="button" name="opp_to_quote_button" id="export_button" value="{$APP.LBL_EXPORT}" onclick="document.location.href = \'index.php?entryPoint=export&module=ProspectLists&uid={$fields.id.value}&members=1\'">'),)),
				
						'maxColumns' => '2',
                        'widths' => array(
                                        array('label' => '10', 'field' => '30'),
                                        array('label' => '10', 'field' => '30')
                                        ),
                        ),
'panels' => array(
   'default' => array (
  	  array (
  	  	  'name',
  	  	  array('name'=>'entry_count','label'=>'LBL_ENTRIES'),
  	  ),
	  array (
	      'list_type',
	      'domain_name',
	  ),
	  array (
	      'description',
	  ),
	),
	'LBL_PANEL_ASSIGNMENT' => array(
		array (
		  'assigned_user_name',  
		  array (
		      'name' => 'date_modified',
		      'label' => 'LBL_DATE_MODIFIED',
		      'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
		  ),
		),	
		array (
		      'team_name',
			array (
		      'name' => 'date_entered',
		      'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
		  	),
		),
	)
)


);
?>