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

$viewdefs['Documents']['DetailView'] = array(
'templateMeta' => array('maxColumns' => '2',
                        'form' => array('hidden'=>array('<input type="hidden" name="old_id" value="{$fields.document_revision_id.value}">')), 
                        'widths' => array(
                                        array('label' => '10', 'field' => '30'), 
                                        array('label' => '10', 'field' => '30')
                                        ),
                        ),
'panels' => 
    array (
      'lbl_document_information' => 
      array (
        array (
          array (
            'name' => 'filename',
            'displayParams' => 
            array (
              'link' => 'filename',
              'id' => 'document_revision_id',
            ),
          ),
          'status',
        ),

        array (
          array (
            'name' => 'document_name',
            'label' => 'LBL_DOC_NAME',
          ),
          array (
            'name' => 'revision',
            'label' => 'LBL_DOC_VERSION',
          ),
        ),

        array (
          array (
            'name' => 'template_type',
            'label' => 'LBL_DET_TEMPLATE_TYPE',
          ),
          array (
            'name' => 'is_template',
            'label' => 'LBL_DET_IS_TEMPLATE',
          ),
        ),

        array (
          'active_date',
          'category_id',
        ),
 
        array (
          'exp_date',
          'subcategory_id',
        ),

        array (
          array (
            'name' => 'description',
            'label' => 'LBL_DOC_DESCRIPTION',
          ),
        ),
	    
	    array (
	       'related_doc_name',
	       'related_doc_rev_number',
	    ),

       array (
        array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            ),

        array (
	      'name' => 'team_name',
          'label' => 'LBL_TEAM',
	    ),
        ),
      ),
      'LBL_REVISIONS_PANEL' => 
      array (
        array (
          0 => 'last_rev_created_name',
          1 => array(
              'name' => 'last_rev_create_date',
              'type' => 'date'
          ),
        ),
      ),
    )
   
);

?>