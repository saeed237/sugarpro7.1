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
$_object_name = '<_object_name>';
$viewdefs[$module_name]['EditView'] = array(
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
        'name' => $_object_name . '_number',
        'type' => 'readonly',
      ),
      'assigned_user_name',
    ),
    
    array (
      'priority',
      array('name'=>'team_name', 'displayParams'=>array('display'=>true)),
    ),
    
    array (
      'resolution',
      'status',
    ),

    array (
      array('name'=>'name', 'displayParams'=>array('size'=>60)),
    ),
    
    array (
      'description',
    ),
    
    
    array (
      'work_log',
    ),
  ),
                                                    
),
                        
);
?>