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


$viewdefs['EmailTemplates']['base']['filter']['default'] = array(
    'default_filter' => 'all_email_type',
    'filters'        => array(
        array(
            'id'                => 'all_email_type',
            'name'              => 'LBL_FILTER_EMAIL_TYPE_TEMPLATES',
            'filter_definition' => array(
                '$or' => array(
                    array(
                        'type' => array('$is_null' => ''),
                    ),
                    array(
                        'type' => array('$equals' => ''),
                    ),
                    array(
                        'type' => array('$equals' => 'email'),
                    ),
                ),
            ),
            'editable'          => false,
        ),
    ),
);
