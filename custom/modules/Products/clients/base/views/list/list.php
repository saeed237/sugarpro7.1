<?php
$viewdefs['Products'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'readonly' => true,
                'link' => true,
                'label' => 'LBL_NAME',
                'enabled' => true,
                'default' => true,
                'width' => '10%',
              ),
              1 => 
              array (
                'name' => 'quote_name',
                'link' => true,
                'label' => 'LBL_ASSOCIATED_QUOTE',
                'related_fields' => 
                array (
                  0 => 'quote_id',
                ),
                'enabled' => true,
                'default' => true,
                'width' => '10%',
              ),
              2 => 
              array (
                'name' => 'quantity',
                'label' => 'LBL_QUANTITY',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'account_name',
                'label' => 'LBL_ACCOUNT_NAME',
                'related_fields' => 
                array (
                  0 => 'account_id',
                ),
                'width' => '10%',
                'default' => false,
                'enabled' => true,
              ),
              4 => 
              array (
                'name' => 'status',
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'default' => false,
                'enabled' => true,
              ),
              5 => 
              array (
                'name' => 'discount_price',
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'discount_price',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'convertToBase' => true,
                'showTransactionalAmount' => true,
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
                'width' => '10%',
                'default' => false,
                'enabled' => true,
              ),
              6 => 
              array (
                'name' => 'cost_price',
                'readonly' => true,
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'cost_price',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'convertToBase' => true,
                'showTransactionalAmount' => true,
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
                'width' => '10%',
                'default' => false,
                'enabled' => true,
              ),
              7 => 
              array (
                'name' => 'discount_amount',
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'discount_amount',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'convertToBase' => true,
                'showTransactionalAmount' => true,
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
                'width' => '10%',
                'default' => false,
                'enabled' => true,
              ),
              8 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'width' => '10%',
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'insurance_picture',
                'label' => 'LBL_INSURANCE_PICTURE',
                'enabled' => true,
                'sortable' => false,
                'width' => '42%',
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'assigned_user_name',
                'sortable' => false,
                'width' => '10%',
                'default' => false,
                'enabled' => true,
              ),
              11 => 'quantity',
            ),
          ),
        ),
      ),
    ),
  ),
);
