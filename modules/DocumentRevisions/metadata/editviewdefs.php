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

$viewdefs['DocumentRevisions']['EditView'] = array(
    'templateMeta' => array('form' => array('enctype'=>'multipart/form-data',
                                            'hidden'=>array('<input type="hidden" name="return_id" value="{$smarty.request.return_id}">'),
                                ),       
                            'maxColumns' => '2', 
                            'widths' => array(
                                array('label' => '10', 'field' => '30'), 
                                array('label' => '10', 'field' => '30')
                                ),
                            'javascript' => '{sugar_getscript file="include/javascript/popup_parent_helper.js"}
{sugar_getscript file="cache/include/javascript/sugar_grp_jsolait.js"}
{sugar_getscript file="modules/Documents/documents.js"}',
        ),
    'panels' =>array (
        '' => 
        array (
            array (
                array ( 'name' => 'document_name', 'type' => 'readonly' ),
                array ( 'name' => 'latest_revision', 'type' => 'readonly' ),
            ),
            array (
                'revision',
            ),
            
            array (
                'filename',
                'doc_type',
            ),
            
            array (
                array ( 'name' => 'change_log', 'size' => '126', 'maxlength' => '255' ),
            ),

        ),
    ),
);
