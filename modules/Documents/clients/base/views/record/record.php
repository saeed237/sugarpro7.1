<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$viewdefs['Documents']['base']['view']['record'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'header' => true,
            'fields' => array(
                array(
                    'name'          => 'picture',
                    'type'          => 'avatar',
                    'width'         => 42,
                    'height'        => 42,
                    'dismiss_label' => true,
                    'readonly'      => true,
                ),
                array (
                    'name' => 'filename',
                    'displayParams' =>
                    array (
                      'link' => 'filename',
                      'id' => 'document_revision_id',
                    ),
                    'readonly' => true,
                    'span' => 12,
                    'label' => '',
                ),
                array(
                    'name' => 'favorite',
                    'label' => 'LBL_FAVORITE',
                    'type' => 'favorite',
                    'dismiss_label' => true,
                ),
                array(
                    'name' => 'follow',
                    'label'=> 'LBL_FOLLOW',
                    'type' => 'follow',
                    'readonly' => true,
                    'dismiss_label' => true,
                ),
            )
        ),
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                'document_name',
                'status',
                'revision',
                'template_type',
                'is_template',
                'active_date',
                'category_id',
                'exp_date',
                'subcategory_id',
                'description',
                'related_doc_name',
                'related_doc_rev_number',
                'assigned_user_name',
                'team_name',
            ),
        ),
        array(
            'name' => 'panel_hidden',
            'columns' => 2,
            'hide' => true,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                'last_rev_created_name',
                'last_rev_create_date',
            )
        )
    ),
);
