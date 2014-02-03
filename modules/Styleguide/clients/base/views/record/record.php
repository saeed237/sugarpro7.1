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

$viewdefs['Styleguide']['base']['view']['record'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'header' => true,
            'fields' => array(
                array(
                    'name' => 'picture',
                    'type' => 'image',
                    'width' => 42,
                    'height' => 42,
                    'dismiss_label' => true,
                ),
                array(
                    'name' => 'full_name',
                    'type' => 'fieldset-with-labels',
                    'fields' => array('salutation', 'first_name', 'last_name'),
                ),
                array(
                    'type' => 'favorite',
                    'readonly' => true,
                ),
                array(
                    'type' => 'follow',
                    'readonly' => true,
                ),
            ),
        ),
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'title',
                    'label' => 'Base',
                ),
                array(
                    'name' => 'do_not_call',
                    'label' => 'bool',
                ),
                array(
                    'name' => 'parent_name',
                    'label' => 'Parent',
                    'sortable' => false,
                ),
                array(
                    'name' => 'email',
                    'label' => 'email',
                    'sortable' => false,
                ),
                array (
                    'name' => 'assigned_user_name',
                    'width' => '10%',
                    'label' => 'Relate',
                    'id' => 'ASSIGNED_USER_ID',
                    'default' => true,
                    'sortable' => false,
                ),
            ),
        ),
        array(
            'columns' => 2,
            'name' => 'panel_hidden',
            'hide' => true,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
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
                        array(
                            'name' => 'list_price',
                            'label' => 'currency',
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
                array(
                    'name' => 'team_name',
                    'label' => 'Teamset',
                    'type' => 'teamset',
                    'module' => 'Teams',
                ),
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
            ),
        ),
    ),
);
