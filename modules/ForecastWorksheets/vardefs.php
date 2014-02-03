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
$dictionary['ForecastWorksheet'] = array(
    'table' => 'forecast_worksheets',
    'studio' => false,
    'acls' => array('SugarACLForecastWorksheets' => true, 'SugarACLStatic' => true),
    'fields' => array(
        'parent_id' =>
        array(
            'name' => 'parent_id',
            'vname' => 'LBL_PARENT_ACCOUNT_ID',
            'type' => 'id',
            'group'=>'parent_name',
            'required' => false,
            'reportable' => false,
            'audited' => false,
            'comment' => 'Account ID of the parent of this account',
            'studio' => false
        ),
        'parent_type' =>
        array(
            'name' => 'parent_type',
            'vname' => 'LBL_PARENT_TYPE',
            'type' => 'parent_type',
            'dbType' => 'varchar',
            'group' => 'parent_name',
            'options' => 'parent_type_display',
            'len' => '255',
            'comment' => 'Sugar module the Worksheet is associated with',
            'studio' => false
        ),
        'parent_name' =>
        array(
            'name' => 'parent_name',
            'parent_type' => 'record_type_display',
            'type_name' => 'parent_type',
            'id_name' => 'parent_id',
            'vname' => 'LBL_NAME',
            'type' => 'parent',
            'group' => 'parent_name',
            'source' => 'non-db',
            'options' => 'parent_type_display',
            'studio' => true,
            'sortable' => true,
            'related_fields' => array(
                'parent_id',
                'parent_type',
                'parent_deleted',
                'name',
            )
        ),
        'opportunity_id' =>
        array(
            'name' => 'opportunity_id',
            'vname' => 'LBL_OPPORTUNITY_ID',
            'type' => 'id',
            'audited' => false,
            'studio' => false,
            'link' => 'opportunity',
        ),
        'opportunity_name' =>
        array(
            'name' => 'opportunity_name',
            'id_name' => 'opportunity_id',
            'module' => 'Opportunities',
            'vname' => 'LBL_OPPORTUNITY_NAME',
            'type' => 'relate',
            'dbType' => 'varchar',
            'len' => '255',
            'studio' => false,
            'sortable' => true,
            'related_fields' => array(
                'opportunity_id',
            ),
            'rname' => 'name',
            'link' => 'opportunity',
        ),
        'account_name' =>
        array(
            'name' => 'account_name',
            'id_name' => 'account_id',
            'module' => 'Accounts',
            'vname' => 'LBL_ACCOUNT_NAME',
            'type' => 'relate',
            'dbType' => 'varchar',
            'len' => '255',
            'studio' => false,
            'sortable' => true,
            'related_fields' => array(
                'account_id',
            ),
            'rname' => 'name',
            'link' => 'accounts',
        ),
        'account_id' =>
        array(
            'name' => 'account_id',
            'vname' => 'LBL_ACCOUNT_ID',
            'type' => 'id',
            'audited' => false,
            'studio' => false
        ),
        'campaign_id' => array(
            'name' => 'campaign_id',
            'vname' => 'LBL_CAMPAIGN_ID',
            'type' => 'id',
            'audited' => false,
            'studio' => false
        ),
        'campaign_name' => array(
            'name' => 'campaign_name',
            'id_name' => 'campaign_id',
            'rname' => 'name',
            'vname' => 'LBL_CAMPAIGN',
            'type' => 'relate',
            'dbType' => 'varchar',
            'len' => '255',
            'module' => 'Campaigns',
            'sortable' => true,
            'related_fields' => array(
                'campaign_id',
            )
        ),
        'product_template_id' => array(
            'name' => 'product_template_id',
            'vname' => 'LBL_PRODUCT_TEMPLATE_ID',
            'type' => 'id',
            'audited' => false,
            'studio' => false
        ),
        'product_template_name' => array(
            'name' => 'product_template_name',
            'id_name' => 'product_template_id',
            'rname' => 'name',
            'vname' => 'LBL_PRODUCT',
            'type' => 'relate',
            'dbType' => 'varchar',
            'len' => '255',
            'module' => 'ProductTemplates',
            'sortable' => true,
            'related_fields' => array(
                'product_template_id',
            )
        ),
        'category_id' =>  array(
            'name' => 'category_id',
            'vname' => 'LBL_CATEGORY',
            'type' => 'id',
            'required' => false,
            'reportable' => true,
        ),
        'category_name' =>  array(
            'name' => 'category_name',
            'id_name' => 'category_id',
            'rname' => 'name',
            'vname' => 'LBL_CATEGORY_NAME',
            'type' => 'relate',
            'module' => 'ProductCategories',
            'dbType' => 'varchar',
            'len' => '255',
            'sortable' => true,
            'related_fields' => array(
                'category_id'
            )
        ),
        'sales_status' => array(
            'name' => 'sales_status',
            'vname' => 'LBL_SALES_STATUS',
            'type' => 'enum',
            'options' => 'sales_status_dom',
            'len' => '255',
            'sortable' => true,
            'audited' => true,
        ),
        'likely_case' =>
        array(
            'name' => 'likely_case',
            'vname' => 'LBL_LIKELY',
            'dbType' => 'currency',
            'type' => 'currency',
            'len' => '26,6',
            'validation' => array('type' => 'range', 'min' => 0),
            'audited' => false,
            'studio' => false,
            'align' => 'right',
            'sortable' => true,
            'related_fields' => array(
                'base_rate',
                'currency_id',
                'best_case',
                'worst_case'
            ),
            'convertToBase' => true
        ),
        'best_case' =>
        array(
            'name' => 'best_case',
            'vname' => 'LBL_BEST',
            'dbType' => 'currency',
            'type' => 'currency',
            'len' => '26,6',
            'validation' => array('type' => 'range', 'min' => 0),
            'audited' => false,
            'studio' => false,
            'align' => 'right',
            'sortable' => true,
            'related_fields' => array(
                'base_rate',
                'currency_id'
            ),
            'convertToBase' => true
        ),
        'worst_case' =>
        array(
            'name' => 'worst_case',
            'vname' => 'LBL_WORST',
            'dbType' => 'currency',
            'type' => 'currency',
            'len' => '26,6',
            'validation' => array('type' => 'range', 'min' => 0),
            'audited' => false,
            'studio' => false,
            'align' => 'right',
            'sortable' => true,
            'related_fields' => array(
                'base_rate',
                'currency_id'
            ),
            'convertToBase' => true
        ),
        'base_rate' =>
        array(
            'name' => 'base_rate',
            'vname' => 'LBL_BASE_RATE',
            'type' => 'decimal',
            'len' => '26,6',
            'required' => true,
            'studio' => false
        ),
        'currency_id' =>
        array(
            'name' => 'currency_id',
            'type' => 'currency_id',
            'dbType' => 'id',
            'group' => 'currency_id',
            'vname' => 'LBL_CURRENCY',
            'function' => array('name' => 'getCurrencyDropDown', 'returns' => 'html'),
            'reportable' => false,
            'comment' => 'Currency used for display purposes',
            'studio' => false
        ),
        'currency_name' =>
        array(
            'name' => 'currency_name',
            'rname' => 'name',
            'id_name' => 'currency_id',
            'vname' => 'LBL_CURRENCY_NAME',
            'type' => 'relate',
            'isnull' => 'true',
            'table' => 'currencies',
            'module' => 'Currencies',
            'source' => 'non-db',
            'function' => array('name' => 'getCurrencyNameDropDown', 'returns' => 'html'),
            'studio' => false,
            'duplicate_merge' => 'disabled',
        ),
        'currency_symbol' =>
        array(
            'name' => 'currency_symbol',
            'rname' => 'symbol',
            'id_name' => 'currency_id',
            'vname' => 'LBL_CURRENCY_SYMBOL',
            'type' => 'relate',
            'isnull' => 'true',
            'table' => 'currencies',
            'module' => 'Currencies',
            'source' => 'non-db',
            'function' => array('name' => 'getCurrencySymbolDropDown', 'returns' => 'html'),
            'studio' => false,
            'duplicate_merge' => 'disabled',
        ),
        'date_closed' =>
        array(
            'name' => 'date_closed',
            'vname' => 'LBL_DATE_CLOSED',
            'type' => 'date',
            'audited' => false,
            'comment' => 'Expected or actual date the oppportunity will close',
            'importable' => 'required',
            'required' => true,
            'enable_range_search' => true,
            'sortable' => true,
            'options' => 'date_range_search_dom',
            'studio' => false,
            'related_fields' => array(
                'date_closed_timestamp'
            )
        ),
        'date_closed_timestamp' =>
        array(
            'name' => 'date_closed_timestamp',
            'vname' => 'LBL_DATE_CLOSED_TIMESTAMP',
            'type' => 'int',
            'studio' => false
        ),
        'sales_stage' =>
        array(
            'name' => 'sales_stage',
            'vname' => 'LBL_SALES_STAGE',
            'type' => 'enum',
            'options' => 'sales_stage_dom',
            'len' => '255',
            'audited' => false,
            'comment' => 'Indication of progression towards closure',
            'merge_filter' => 'enabled',
            'importable' => 'required',
            'sortable' => true,
            'required' => true,
            'studio' => false
        ),
        'probability' =>
        array(
            'name' => 'probability',
            'vname' => 'LBL_OW_PROBABILITY',
            'type' => 'int',
            'dbType' => 'double',
            'audited' => false,
            'comment' => 'The probability of closure',
            'validation' => array('type' => 'range', 'min' => 0, 'max' => 100),
            'merge_filter' => 'enabled',
            'sortable' => true,
            'studio' => false
        ),
        'commit_stage' =>
        array(
            'name' => 'commit_stage',
            'vname' => 'LBL_FORECAST',
            'type' => 'enum',
            'len' => '50',
            'comment' => 'Forecast commit ranges: Include, Likely, Omit etc.',
            'sortable' => true,
            'studio' => false
        ),
        'draft' =>
        array(
            'name' => 'draft',
            'vname' => 'LBL_DRAFT',
            'default' => 0,
            'type' => 'int',
            'comment' => 'Is A Draft Version',
            'studio' => false
        ),
        'next_step' => array(
            'name' => 'next_step',
            'vname' => 'LBL_NEXT_STEP',
            'type' => 'varchar',
            'len' => '100',
            'comment' => 'The next step in the sales process',
            'merge_filter' => 'enabled',
        ),
        'lead_source' => array(
            'name' => 'lead_source',
            'vname' => 'LBL_LEAD_SOURCE',
            'type' => 'enum',
            'options' => 'lead_source_dom',
            'len' => '50',
            'comment' => 'Source of the product',
            'sortable' => true,
            'merge_filter' => 'enabled',
        ),
        'product_type' => array(
            'name' => 'product_type',
            'vname' => 'LBL_TYPE',
            'type' => 'enum',
            'options' => 'opportunity_type_dom',
            'len' => '255',
            'audited' => true,
            'comment' => 'Type of product ( from opportunities opportunity_type ex: Existing, New)',
            'merge_filter' => 'enabled',
        ),
        'list_price' =>  array(
            'name' => 'list_price',
            'vname' => 'LBL_LIST_PRICE',
            'type' => 'currency',
            'len' => '26,6',
            'audited' => true,
            'sortable' => true,
            'comment' => 'List price of product ("List" in Quote)'
        ),
        'cost_price' =>  array(
            'name' => 'cost_price',
            'vname' => 'LBL_COST_PRICE',
            'type' => 'currency',
            'len' => '26,6',
            'audited' => true,
            'sortable' => true,
            'comment' => 'Product cost ("Cost" in Quote)'
        ),
        'discount_price' =>  array(
            'name' => 'discount_price',
            'vname' => 'LBL_DISCOUNT_PRICE',
            'type' => 'currency',
            'len' => '26,6',
            'audited' => true,
            'sortable' => true,
            'comment' => 'Discounted price ("Unit Price" in Quote)'
        ),
        'discount_amount' =>  array(
            'name' => 'discount_amount',
            'vname' => 'LBL_TOTAL_DISCOUNT_AMOUNT',
            'type' => 'currency',
            'options' => 'discount_amount_class_dom',
            'len' => '26,6',
            'precision' => 6,
            'sortable' => true,
            'comment' => 'Discounted amount'
        ),
        'quantity' =>  array(
            'name' => 'quantity',
            'vname' => 'LBL_QUANTITY',
            'type' => 'int',
            'len' => 5,
            'comment' => 'Quantity in use',
            'sortable' => true,
            'default' => 1
        ),
        'total_amount' => array(
            'name' => 'total_amount',
            'vname' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
            'reportable' => false,
            'sortable' => true,
            'type' => 'currency'
        ),
        'parent_deleted' =>
        array(
            'name' => 'parent_deleted',
            'default' => 0,
            'type' => 'int',
            'comment' => 'Is Parent Deleted',
            'studio' => false,
            'source' => 'non-db'
        ),
        'opportunity' =>
        array(
            'name' => 'opportunity',
            'type' => 'link',
            'relationship' => 'forecastworksheets_opportunities',
            'source' => 'non-db',
            'vname' => 'LBL_OPPORTUNITY',
        ),
        'accounts' =>
        array(
            'name' => 'accounts',
            'type' => 'link',
            'relationship' => 'forecastworksheets_accounts',
            'source' => 'non-db',
            'vname' => 'LBL_ACCOUNTS',
        ),
        'product' =>
        array(
            'name' => 'product',
            'type' => 'link',
            'relationship' => 'products_worksheets',
            'source' => 'non-db',
            'vname' => 'LBL_PRODUCT',
        )
    ),
    'indices' => array(
        array('name' => 'idx_worksheets_parent', 'type' => 'index', 'fields' => array('parent_id', 'parent_type')),
        array(
            'name' => 'idx_worksheets_assigned_del',
            'type' => 'index',
            'fields' => array('deleted', 'assigned_user_id')
        ),
        array(
            'name' => 'idx_worksheets_assigned_del_time_draft_parent_type',
            'type' => 'index',
            'fields' => array('deleted','assigned_user_id', 'draft', 'date_closed_timestamp', 'parent_type')
        ),
    ),
    'relationships' => array(
        'forecastworksheets_accounts' =>  array(
            'lhs_module' => 'Accounts',
            'lhs_table' => 'accounts',
            'lhs_key' => 'id',
            'rhs_module' => 'ForecastWorksheets',
            'rhs_table' => 'forecast_worksheets',
            'rhs_key' => 'account_id',
            'relationship_type' => 'one-to-many'
        ),
        'forecastworksheets_opportunities' =>  array(
            'lhs_module' => 'Opportunities',
            'lhs_table' => 'opportunities',
            'lhs_key' => 'id',
            'rhs_module' => 'ForecastWorksheets',
            'rhs_table' => 'forecast_worksheets',
            'rhs_key' => 'opportunity_id',
            'relationship_type' => 'one-to-many'
        ),
    )
);

VardefManager::createVardef(
    'ForecastWorksheets',
    'ForecastWorksheet',
    array(
        'default',
        'assignable',
        'team_security',
    )
);
