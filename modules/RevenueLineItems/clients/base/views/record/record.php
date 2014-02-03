<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

// PRO/CORP only fields
$fields = array(
    array(
        'name' => 'product_template_name',
        'required' => true,
    ),
    array(
        'name' => 'spacer', // we need this for when forecasts is not setup and we also need to remove the spacer
        'span' => 6,
        'readonly' => true
    ),
    'account_name',
    'status',
    'quantity',
    array(
        'name' => 'cost_price',
        'type' => 'currency',
        'related_fields' => array(
            'currency_id',
            'base_rate',
        ),
        'convertToBase' => true,
        'currency_field' => 'currency_id',
        'base_rate_field' => 'base_rate',
    ),
    array(
        'name' => 'list_price',
        'type' => 'currency',
        'related_fields' => array(
            'currency_id',
            'base_rate',
        ),
        'convertToBase' => true,
        'currency_field' => 'currency_id',
        'base_rate_field' => 'base_rate',
    ),
    array(
        'name' => 'discount_price',
        'type' => 'currency',
        'related_fields' => array(
            'discount_price',
            'currency_id',
            'base_rate',
        ),
        'convertToBase' => true,
        'showTransactionalAmount' => true,
        'currency_field' => 'currency_id',
        'base_rate_field' => 'base_rate',
    ),
    array(
        'name' => 'discount_amount',
        'type' => 'currency',
        'related_fields' => array(
            'discount_amount',
            'currency_id',
            'base_rate',
        ),
        'convertToBase' => true,
        'showTransactionalAmount' => true,
        'currency_field' => 'currency_id',
        'base_rate_field' => 'base_rate',
    ),
    array(
        'name' => 'discount_rate_percent',
        'readonly' => true,
    ),
);

$fieldsHidden = array(
    'serial_number',
    'contact_name',
    'asset_number',
    'date_purchased',
    array(
        'name' => 'book_value',
        'type' => 'currency',
        'related_fields' => array(
            'book_value',
            'currency_id',
            'base_rate',
        ),
        'convertToBase' => true,
        'showTransactionalAmount' => true,
        'currency_field' => 'currency_id',
        'base_rate_field' => 'base_rate',
    ),
    'date_support_starts',
    'book_value_date',
    'date_support_expires',
    'website',
    'tax_class',
    'manufacturer_name',
    'weight',
    'mft_part_num',
    array(
        'name' => 'category_name',
        'type' => 'productCategoriesRelate',
        'label' => 'LBL_CATEGORY',
        'readonly' => true
    ),
    'vendor_part_num',
    'product_type',
    array(
        'name' => 'description',
        'span' => 12,
    ),
    'support_name',
    'support_contact',
    'support_description',
    'support_term',
    array(
        'name' => 'date_entered_by',
        'readonly' => true,
        'type' => 'fieldset',
        'label' => 'LBL_DATE_ENTERED',
        'fields' => array(
            array(
                'name' => 'date_entered',
            ),
            array(
                'type' => 'label',
                'default_value' => 'LBL_BY',
            ),
            array(
                'name' => 'created_by_name',
            ),
        ),
    ),
    array(
        'name' => 'date_modified_by',
        'readonly' => true,
        'type' => 'fieldset',
        'label' => 'LBL_DATE_MODIFIED',
        'fields' => array(
            array(
                'name' => 'date_modified',
            ),
            array(
                'type' => 'label',
                'default_value' => 'LBL_BY',
            ),
            array(
                'name' => 'modified_by_name',
            ),
        ),
    ),
);


$viewdefs['RevenueLineItems']['base']['view']['record'] = array(
    'buttons' => array(
        array(
            'type' => 'button',
            'event' => 'button:cancel_button:click',
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
                    'primary' => true,
                    'acl_action' => 'edit',
                ),
                array(
                    'type' => 'shareaction',
                    'name' => 'share',
                    'label' => 'LBL_RECORD_SHARE_BUTTON',
                    'acl_action' => 'view',
                ),
                array(
                    'type' => 'pdfaction',
                    'name' => 'download-pdf',
                    'label' => 'LBL_PDF_VIEW',
                    'action' => 'download',
                    'acl_action' => 'view',
                ),
                array(
                    'type' => 'pdfaction',
                    'name' => 'email-pdf',
                    'label' => 'LBL_PDF_EMAIL',
                    'action' => 'email',
                    'acl_action' => 'view',
                ),
                array(
                    'type' => 'divider',
                ),
                array(
                    'type' => 'rowaction',
                    'event' => 'button:find_duplicates_button:click',
                    'name' => 'find_duplicates_button',
                    'label' => 'LBL_DUP_MERGE',
                    'acl_action' => 'edit',
                ),
                array(
                    'type' => 'rowaction',
                    'event' => 'button:duplicate_button:click',
                    'name' => 'duplicate_button',
                    'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                    'acl_action' => 'create',
                ),
                array(
                    'type' => 'rowaction',
                    'event' => 'button:audit_button:click',
                    'name' => 'audit_button',
                    'label' => 'LNK_VIEW_CHANGE_LOG',
                    'acl_action' => 'view',
                ),
                array(
                    'type' => 'divider',
                ),
                array(
                    'type' => 'rowaction',
                    'event' => 'button:delete_button:click',
                    'name' => 'delete_button',
                    'label' => 'LBL_DELETE_BUTTON_LABEL',
                    'acl_action' => 'delete',
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
                array(
                    'name' => 'name',
                    'required' => true,
                    'label' => 'LBL_MODULE_NAME_SINGULAR'
                ),
                array(
                    'name' => 'favorite',
                    'label' => 'LBL_FAVORITE',
                    'type' => 'favorite',
                    'dismiss_label' => true,
                ),
                array(
                    'type' => 'badge',
                    'name' => 'badge',
                    'readonly' => true,
                    'related_fields' => array(
                        'quote_id',
                    ),
                ),
                array(
                    'name' => 'follow',
                    'label' => 'LBL_FOLLOW',
                    'type' => 'follow',
                    'readonly' => true,
                    'dismiss_label' => true,
                ),
            ),
        ),
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'labels' => true,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => $fields,
        ),
        array(
            'name' => 'panel_hidden',
            'hide' => true,
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => $fieldsHidden,
        ),
    ),
);
