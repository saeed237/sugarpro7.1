<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$viewdefs['Meetings']['mobile']['view']['edit'] = array(
    'templateMeta' => array(
        'maxColumns' => '1',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                array(
                    'name' => 'name',
                    'displayParams' => array(
                        'required' => true,
                        'wireless_edit_only' => true,)),
                'date_start',
                'status',
                array(
                    'name' => 'duration',
                    'type' => 'fieldset',
                    'related_fields' => array('duration_hours', 'duration_minutes'),
                    'label' => "LBL_DURATION",
                    'fields' => array(
                        array(
                            'name' => 'duration_hours',
                            'displayParams' => array('required' => true),
                        ),
                        array(
                            'name' => 'duration_minutes',
                            'type' => 'enum',
                            'options' => 'duration_intervals',
                            'displayParams' => array('required' => true),  
                        ),
                    ),
                ),
                array(
                    'name' => 'reminder',
                    'type' => 'fieldset',
                    'orientation' => 'horizontal',
                    'related_fields' => array('reminder_checked', 'reminder_time'),
                    'label' => "LBL_REMINDER",
                    'fields' => array(
                        array(
                            'name' => 'reminder_checked',
                        ),
                        array(
                            'name' => 'reminder_time',
                            'type' => 'enum',
                            'options' => 'reminder_time_options'
                        ),
                    ),
                ),
                array(
                    'name' => 'email_reminder',
                    'type' => 'fieldset',
                    'orientation' => 'horizontal',
                    'related_fields' => array('email_reminder_checked', 'email_reminder_time'),
                    'label' => "LBL_EMAIL_REMINDER",
                    'fields' => array(
                        array(
                            'name' => 'email_reminder_checked',
                        ),
                        array(
                            'name' => 'email_reminder_time',
                            'type' => 'enum',
                            'options' => 'reminder_time_options'
                        ),
                    ),
                ),
                'description',
                'parent_name',
                'assigned_user_name',
                'team_name',
            )
        )
    ),
);
?>