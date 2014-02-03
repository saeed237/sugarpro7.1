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

$viewdefs['Emails']['base']['view']['compose'] = array(
    'template' => 'record',
    'buttons' => array(
        array(
            'type'      => 'button',
            'name'      => 'cancel_button',
            'label'     => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
        ),
        array(
            'type'    => 'actiondropdown',
            'name'    => 'main_dropdown',
            'primary' => true,
            'buttons' => array(
                array(
                    'name'  => 'send_button',
                    'type'  => 'rowaction',
                    'label' => 'LBL_SEND_BUTTON_LABEL',
                ),
                array(
                    'name'  => 'draft_button',
                    'type'  => 'rowaction',
                    'label' => 'LBL_SAVE_AS_DRAFT_BUTTON_LABEL',
                ),
            ),
        ),
        array(
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
        ),
    ),
    'panels'  => array(
        array(
            'name'         => 'panel_body',
            'label'        => 'LBL_PANEL_2',
            'columns'      => 1,
            'labels'       => true,
            'labelsOnTop'  => false,
            'placeholders' => true,
            'fields'       => array(
                array(
                    'name'            => 'email_config',
                    'label'           => 'LBL_FROM',
                    'type'            => 'sender',
                    'span'            => 12,
                    'css_class'       => 'inherit-width',
                    'label_css_class' => 'begin-fieldgroup',
                    'endpoint'        => array(
                        'module' => 'OutboundEmailConfiguration',
                        'action' => 'list',
                    )
                ),
                array(
                    'name'           => 'to_addresses',
                    'type'           => 'recipients',
                    'label'          => 'LBL_TO_ADDRS',
                    'span'           => 12,
                    'cell_css_class' => 'controls-one btn-fit',
                    'required'       => true,
                ),
                array(
                    'name'           => 'cc_addresses',
                    'type'           => 'recipients',
                    'label'          => 'LBL_CC',
                    'span'           => 12,
                    'cell_css_class' => 'controls-one btn-fit',
                ),
                array(
                    'name'           => 'bcc_addresses',
                    'type'           => 'recipients',
                    'label'          => 'LBL_BCC',
                    'span'           => 12,
                    'cell_css_class' => 'controls-one btn-fit',
                ),
                array(
                    'name'            => 'subject',
                    'label'           => 'LBL_SUBJECT',
                    'span'            => 12,
                    'label_css_class' => 'end-fieldgroup',
                ),
                array(
                    'name'        => 'attachments',
                    'label'       => 'LBL_ATTACHMENTS',
                    'type'        => 'attachments',
                    'uploadEvent' => 'actionbar:upload_new_button:clicked',
                ),
                array(
                    'name'           => 'actionbar',
                    'type'           => 'compose-actionbar',
                    'span'           => 12,
                    'dismiss_label'  => true,
                    'buttonSections' => array(
                        array(
                            'name'      => 'attachments_dropdown',
                            'css_class' => 'btn-group',
                            'type'      => 'actiondropdown',
                            'buttons'   => array(
                                array(
                                    'name'  => 'upload_new_button',
                                    'type'  => 'button',
                                    'icon'  => 'icon-paper-clip',
                                    'label' => 'LBL_ATTACHMENT',
                                ),
                                array(
                                    'name'  => 'attach_sugardoc_button',
                                    'type'  => 'rowaction',
                                    'label' => 'LBL_ATTACH_SUGAR_DOC',
                                ),
                            ),
                        ),
                        array(
                            'name'      => 'other_actions',
                            'css_class' => 'pull-right',
                            'buttons'   => array(
                                array(
                                    'name'  => 'signature_button',
                                    'type'  => 'button',
                                    'icon'  => 'icon-edit',
                                    'label' => 'LBL_EMAIL_SIGNATURES',
                                ),
                                array(
                                    'name'  => 'template_button',
                                    'type'  => 'button',
                                    'icon'  => 'icon-file-alt',
                                    'label' => 'LBL_EMAIL_TEMPLATES',
                                ),
                            ),
                        ),
                    ),
                ),
                array(
                    'name'          => 'html_body',
                    'type'          => 'htmleditable_tinymce',
                    'dismiss_label' => true,
                    'span'          => 12,
                    'tinyConfig'    => array(
                        // Location of TinyMCE script
                        'script_url'                        => 'include/javascript/tiny_mce/tiny_mce.js',
                        'height'                            => '100%',
                        'width'                             => '100%',
                        // General options
                        'theme'                             => 'advanced',
                        'skin'                              => 'sugar7',
                        'plugins'                           => 'style,paste,inlinepopups',
                        'entity_encoding'                   => 'raw',
                        'forced_root_block'                 => false,
                        // Theme options
                        'theme_advanced_buttons1'           => "code,separator,bold,italic,underline,strikethrough,separator,bullist,numlist,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,forecolor,backcolor,separator,fontsizeselect",
                        'theme_advanced_toolbar_location'   => "top",
                        'theme_advanced_toolbar_align'      => "left",
                        'theme_advanced_statusbar_location' => "none",
                        'theme_advanced_resizing'           => false,
                        'schema'                            => 'html5',
                        'template_external_list_url'        => 'lists/template_list.js',
                        'external_link_list_url'            => 'lists/link_list.js',
                        'external_image_list_url'           => 'lists/image_list.js',
                        'media_external_list_url'           => 'lists/media_list.js',
                        'theme_advanced_path'               => false,
                        'theme_advanced_source_editor_width'=> 500,
                        'theme_advanced_source_editor_height'=> 400,
                        'inlinepopups_skin'                 => 'sugar7modal',

                        //Url options for links
                        'relative_urls'                     => false,
                        'remove_script_host'                => false,
                    ),
                ),
            ),
        ),
        array(
            'name'         => 'panel_hidden',
            'hide'         => true,
            'columns'      => 1,
            'labelsOnTop'  => false,
            'placeholders' => true,
            'fields'       => array(
                array(
                    'type' => 'teamset',
                    'name' => 'team_name',
                    'span' => 12,
                ),
                array(
                    'label'   => 'LBL_LIST_RELATED_TO',
                    'type'    => 'parent',
                    'name'    => 'parent_name',
                    'options' => 'parent_type_display',
                    'span'    => 12,
                ),
            ),
        ),
    ),
);
