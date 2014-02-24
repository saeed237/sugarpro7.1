<?php
$viewdefs['base']['view']['next-best-offer'] = array(
    'template' => 'list',
    'dashlets' => array(
        array(
            'name'        => 'LBL_NEXT_BEST_OFFER_DASHLET',
            'description' => 'LBL_NEXT_BEST_OFFER_DESCRIPTION_DASHLET',
            'config'      => array(
			    'module' => 'Products',
                'link' => 'next_best_offer',
			),
            'preview' => array(
                'module' => 'Products',
                'link' => 'next_best_offer',
                'display_columns' => array(
                    'description'
                ),
                'my_items'        => '0',
            ),
			'filter' => array(
                'module' => array(
					'Contacts',
                ),
                'view' => 'record',
            ),
        ),
    ),
    'custom_toolbar' => array(
        'buttons' => array(
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
    'panels'   => array(
        array(
            'name'         => 'dashlet_settings',
            'columns'      => 2,
            'labelsOnTop'  => true,
            'placeholders' => true,
            'fields'       => array(
                array(
                    'name'          => 'display_columns',
                    'label'         => 'LBL_COLUMNS',
                    'type'          => 'enum',
                    'isMultiSelect' => true,
                    'ordered'       => true,
                    'span'          => 12,
                    'hasBlank'      => true,
                    'options'       => array('' => ''),
                ),
                array(
                    'name'    => 'limit',
                    'label'   => 'LBL_DASHLET_CONFIGURE_DISPLAY_ROWS',
                    'type'    => 'enum',
                    'options' => 'dashlet_limit_options',
                ),
                array(
                    'name'    => 'auto_refresh',
                    'label'   => 'Auto Refresh',
                    'type'    => 'enum',
                    'options' => 'sugar7_dashlet_auto_refresh_options',
                ),
                array(
                    'name'    => 'my_items',
                    'label'   => 'LBL_DASHLET_CONFIGURE_MY_ITEMS_ONLY',
                    'type'    => 'enum',
                    'options' => 'list_visibility_options',
                ),
                array(
                    'name'    => 'favorites',
                    'label'   => 'LBL_DASHLET_CONFIGURE_MY_FAVORITES_ONLY',
                    'type'    => 'enum',
                    'options' => 'list_visibility_options',
                ),
            ),
        ),
    ),
);
