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

$viewdefs['Documents']['QuickCreate'] = array(
    'templateMeta' => array('form' => array('enctype'=>'multipart/form-data',
                                            'hidden'=>array('<input type="hidden" name="old_id" value="{$fields.document_revision_id.value}">',
                                                            '<input type="hidden" name="parent_id" value="{$smarty.request.parent_id}">',
                                                            '<input type="hidden" name="parent_type" value="{$smarty.request.parent_type}">',)),
                                            
                            'maxColumns' => '2', 
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'), 
                                            array('label' => '10', 'field' => '30')
                                            ),
                            'includes' => 
                              array (
                                array('file' => 'include/javascript/popup_parent_helper.js'),
                                array('file' => 'cache/include/javascript/sugar_grp_jsolait.js'),
                                array('file' => 'modules/Documents/documents.js'),
                              ),
),
 'panels' =>array (
  'default' => 
  array (
    
    array (
      'doc_type', 
      'status_id',
    ),
    array (
      array('name'=>'filename', 
            'displayParams'=>array('required'=>true, 'onchangeSetFileNameTo' => 'document_name'),
            ),
    ),
    
    array (
      'document_name',
       array('name'=>'revision',
            'customCode' => '<input name="revision" type="text" value="{$fields.revision.value}" {$DISABLED}>'
           ),
    ),    
    
    array (
       array('name'=>'active_date','displayParams'=>array('required'=>true)),
       'category_id',
    ),
    
    array (
      array('name'=>'assigned_user_name',),
      array('name'=>'team_name','displayParams'=>array('required'=>true)),
    ),

    array (
      array('name'=>'description', 'displayParams'=>array('rows'=>10, 'cols'=>120)),
    ),
  ),
)

);
?>
