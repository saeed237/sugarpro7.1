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

$viewdefs['DocumentRevisions']['DetailView'] = array(
    'templateMeta' => array('maxColumns' => '2',
                            'form' => array(
                                'buttons' => array(),
                                'hidden'=>array('<input type="hidden" name="old_id" value="{$fields.document_revision_id.value}">')), 
                            'widths' => array(
                                array('label' => '10', 'field' => '30'), 
                                array('label' => '10', 'field' => '30')
                                ),
        ),
    'panels' => 
    array (
        '' => 
        array (
            array (
                'document_name',
                'latest_revision',
            ),
            
            array (
                'revision',
            ),
            
            array (
                'filename',
                'doc_type',
            ),
            
            array (
                array (
                    'name' => 'date_entered',
                    'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                ),
            ),

            array (
                'change_log',
            ),
        ),
    ),
);