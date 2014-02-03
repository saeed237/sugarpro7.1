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

$viewdefs['ProspectLists']['EditView'] = array(
    'templateMeta' => array('form'=>array('hidden'=>array('<input type="hidden" name="campaign_id" value="{$smarty.request.campaign_id}">')),
                            'maxColumns' => '2', 
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'), 
                                            array('label' => '10', 'field' => '30')
                                            ),
 'javascript' => '<script type="text/javascript">
function toggle_domain_name(list_type)  {ldelim} 
    domain_name = document.getElementById(\'domain_name_div\');
    domain_label = document.getElementById(\'domain_label_div\');
    if (list_type.value == \'exempt_domain\')  {ldelim} 
        domain_name.style.display=\'block\'; 
        domain_label.style.display=\'block\';
     {rdelim}  else  {ldelim} 
        domain_name.style.display=\'none\';
        domain_label.style.display=\'none\';
     {rdelim} 
 {rdelim} 
</script>',
),
 'panels' =>array (
  'default' => 
  array (
    
    array (
      array('name'=>'name', 'displayParams'=>array('required'=>true)),
      array('name'=>'list_type', 'displayParams'=>array('required'=>true, 'javascript'=>'onchange="toggle_domain_name(this);"')),
    ),
    array (
      array('name'=>'description'),
      array('name' => 'domain_name', 
            'customLabel' => '<div {if $fields.list_type.value != "exempt_domain"} style=\'display:none\'{/if} id=\'domain_label_div\'>{$MOD.LBL_DOMAIN}</div>', 
            'customCode' =>  '<div {if $fields.list_type.value != "exempt_domain"} style=\'display:none\'{/if} id=\'domain_name_div\'><input name="domain_name" id="domain_name" maxlength="255" type="text" value="{$fields.domain_name.value}"></div>',),
    ),
    
  ),
  'LBL_PANEL_ASSIGNMENT' => 
      array (
        array (
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
          array(
		   	'name'=>'team_name', 
		    'displayParams'=>array('display'=>true),
          ),
        ),
      ),
)


);
?>