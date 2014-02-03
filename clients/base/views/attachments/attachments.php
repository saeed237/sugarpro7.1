<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$viewdefs['base']['view']['attachments'] = array(
	'dashlets' => array(
		array(
            'name' => 'LBL_DASHLET_ATTACHMENTS_NAME',
            'description' => 'LBL_DASHLET_ATTACHMENTS_DESCRIPTION',
            'config' => array(
                'auto_refresh' => '0',
                'module' => 'Notes',
                'link' => 'notes',
            ),
            'preview' => array(
                'module' => 'Notes',
                'link' => 'notes',
            ),
            'filter' => array(
                'module' => array(
                    'Accounts',
                    'Contacts',
                    'Opportunities',
                    'Leads',
                    'Bugs',
                    'Cases',
                ),
                'view' => 'record',
            ),
        ),
 	),
    'custom_toolbar' => array(
        'buttons' => array(
            array(
                'type' => 'actiondropdown',
                'icon' => 'icon-plus',
                'no_default_action' => true,
                'buttons' => array(
                    array(
                        'type' => 'dashletaction',
                        'css_class' => '',
                        'label' => 'LBL_CREATE_RELATED_RECORD',
                        'action' => 'openCreateDrawer',
                    ),
                    array(
                        'type' => 'dashletaction',
                        'css_class' => '',
                        'label' => 'LBL_ASSOC_RELATED_RECORD',
                        'action' => 'openSelectDrawer',
                    ),
                ),
            ),
            array(
                'dropdown_buttons' => array(
                    array(
                        'type' => 'dashletaction',
                        'action' => 'editClicked',
                        'label' => 'LBL_DASHLET_CONFIG_EDIT_LABEL',
                    ),
                    array(
                        'type' => 'dashletaction',
                        'action' => 'refreshClicked',
                        'label' => 'LBL_DASHLET_REFRESH_LABEL',
                    ),
                    array(
                        'type' => 'dashletaction',
                        'action' => 'toggleClicked',
                        'label' => 'LBL_DASHLET_MINIMIZE',
                        'event' => 'minimize',
                    ),
                    array(
                        'type' => 'dashletaction',
                        'action' => 'removeClicked',
                        'label' => 'LBL_DASHLET_REMOVE_LABEL',
                    ),
                )
            )
        )
    ),
    'rowactions' => array(
        array(
            'type' => 'rowaction',
            'icon' => 'icon-unlink',
            'css_class' => 'btn',
            'event' => 'attachment:unlinkrow:fire',
            'tooltip' => 'LBL_UNLINK_BUTTON',
            'acl_action' => 'edit',
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'limit',
                    'label' => 'Display Rows',
                    'type' => 'enum',
                    'options' => array(
                        5 => 5,
                        10 => 10,
                        15 => 15,
                        20 => 20
                    )
                ),
                array(
                    'name' => 'auto_refresh',
                    'label' => 'Auto Refresh',
                    'type' => 'enum',
                    'options' => 'sugar7_dashlet_auto_refresh_options',
                ),
            ),
        ),
    ),
	'supportedImageExtensions' => array(
        'image/jpeg' => 'JPG',
        'image/gif' => 'GIF',
        'image/png' => 'PNG',
	),
	'defaultType' => 'txt',
);
