<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
$module_name = '<module_name>';
$viewdefs[$module_name]['base']['view']['record'] = array(
    'buttons' => array(
        array(
            'type' => 'button',
            'name' => 'cancel_button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'showOn' => 'edit',
        ),
        array(
            'type' => 'rowaction',
            'event' => 'button:save_button:click',
            'name' => 'save_button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'css_class' => 'btn btn-primary',
            'showOn' => 'edit',
            'acl_action' => 'edit',
        ),
        array(
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'primary' => true,
            'showOn' => 'view',
            'buttons' => array(
                array(
                    'type' => 'rowaction',
                    'event' => 'button:edit_button:click',
                    'name' => 'edit_button',
                    'label' => 'LBL_EDIT_BUTTON_LABEL',
                    'acl_action' => 'edit',
                ),
                array(
                    'type' => 'shareaction',
                    'name' => 'share',
                    'label' => 'LBL_RECORD_SHARE_BUTTON',
                    'acl_action' => 'view',
                ),
                array(
                    'type' => 'rowaction',
                    'event' => 'button:duplicate_button:click',
                    'name' => 'duplicate_button',
                    'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                    'acl_module' => $module_name,
                ),
                array(
                    'type' => 'rowaction',
                    'event' => 'button:delete_button:click',
                    'name' => 'delete_button',
                    'label' => 'LBL_DELETE_BUTTON_LABEL',
                    'acl_action' => 'delete',
                ),
                array(
                    'type'       => 'vcard',
                    'name'       => 'vcard_button',
                    'label'      => 'LBL_VCARD_DOWNLOAD',
                    'acl_action' => 'edit',
                ),
            ),
        ),
        array(
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_RECORD_HEADER',
            'header' => true,
            'fields' => array(
                array(
                    'name' => 'picture',
                    'type' => 'avatar',
                    'width' => 42,
                    'height' => 42,
                    'dismiss_label' => true,
                ),
                array(
                    'name' => 'full_name',
                    'label' => 'LBL_NAME',
                    'dismiss_label' => true,
                    'type' => 'fullname',
                    'fields' => array('salutation', 'first_name', 'last_name'),
                ),
                array(
                    'name' => 'favorite',
                    'label' => 'LBL_FAVORITE',
                    'type' => 'favorite',
                    'readonly' => true,
                    'dismiss_label' => true,
                ),
                array(
                    'name' => 'follow',
                    'label'=> 'LBL_FOLLOW',
                    'type' => 'follow',
                    'readonly' => true,
                    'dismiss_label' => true,
                ),
            ),
        ),
        array(
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                'title',
                'phone_mobile',
                'department',
                'do_not_call',
                array(
                    'name' => 'fieldset_address',
                    'type' => 'fieldset',
                    'css_class' => 'address',
                    'label' => 'LBL_PRIMARY_ADDRESS',
                    'fields' => array(
                        array(
                            'name' => 'primary_address_street',
                            'css_class' => 'address_street',
                            'placeholder' => 'LBL_PRIMARY_ADDRESS_STREET',
                        ),
                        array(
                            'name' => 'primary_address_city',
                            'css_class' => 'address_city',
                            'placeholder' => 'LBL_PRIMARY_ADDRESS_CITY',
                        ),
                        array(
                            'name' => 'primary_address_state',
                            'css_class' => 'address_state',
                            'placeholder' => 'LBL_PRIMARY_ADDRESS_STATE',
                        ),
                        array(
                            'name' => 'primary_address_postalcode',
                            'css_class' => 'address_zip',
                            'placeholder' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
                        ),
                        array(
                            'name' => 'primary_address_country',
                            'css_class' => 'address_country',
                            'placeholder' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
                        ),
                    ),
                ),
                array(
                    'name' => 'fieldset_alt_address',
                    'type' => 'fieldset',
                    'css_class' => 'address',
                    'label' => 'LBL_ALT_ADDRESS',
                    'fields' => array(
                        array(
                            'name' => 'alt_address_street',
                            'css_class' => 'address_street',
                            'placeholder' => 'LBL_ALT_ADDRESS_STREET',
                        ),
                        array(
                            'name' => 'alt_address_city',
                            'css_class' => 'address_city',
                            'placeholder' => 'LBL_ALT_ADDRESS_CITY',
                        ),
                        array(
                            'name' => 'alt_address_state',
                            'css_class' => 'address_state',
                            'placeholder' => 'LBL_ALT_ADDRESS_STATE',
                        ),
                        array(
                            'name' => 'alt_address_postalcode',
                            'css_class' => 'address_zip',
                            'placeholder' => 'LBL_ALT_ADDRESS_POSTALCODE',
                        ),
                        array(
                            'name' => 'alt_address_country',
                            'css_class' => 'address_country',
                            'placeholder' => 'LBL_ALT_ADDRESS_COUNTRY',
                        ),
                        array(
                            'name' => 'copy',
                            'label' => 'NTC_COPY_PRIMARY_ADDRESS',
                            'type' => 'copy',
                            'mapping' => array(
                                'primary_address_street' => 'alt_address_street',
                                'primary_address_city' => 'alt_address_city',
                                'primary_address_state' => 'alt_address_state',
                                'primary_address_postalcode' => 'alt_address_postalcode',
                                'primary_address_country' => 'alt_address_country',
                            ),
                        ),
                    ),
                ),
            ),
        ),
        array(
            'columns' => 2,
            'name' => 'panel_hidden',
            'label' => 'LBL_SHOW_MORE',
            'hide' => true,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                'twitter',
                array(
                    'name' => 'description',
                    'span' => 12,
                ),
                'phone_home',
                'phone_work',
                'phone_other',
                'email',
                'phone_fax',
                'assigned_user_name',
                'date_modified',
                'date_entered',
            ),
        ),
    ),
);
