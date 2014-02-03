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
$dictionary['ProductCategory'] = array(
    'favorites' => false,
    'table' => 'product_categories',
    'unified_search' => true,
    'full_text_search' => true,
    'unified_search_default_enabled' => true,
    'comment' => 'Used to categorize products in the product catalog',
    'fields' => array(
        'id' =>
        array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => true,
            'comment' => 'Unique identifier'
        ),
        'deleted' =>
        array(
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'required' => false,
            'default' => '0',
            'reportable' => false,
            'comment' => 'Record deletion indicator'
        ),
        'date_entered' =>
        array(
            'name' => 'date_entered',
            'vname' => 'LBL_DATE_ENTERED',
            'type' => 'datetime',
            'group' => 'created_by_name',
            'comment' => 'Date record created',
            'enable_range_search' => true,
            'options' => 'date_range_search_dom',
            'studio' => array(
                'portaleditview' => false, // Bug58408 - hide from Portal edit layout
            ),
        ),
        'date_modified' =>
        array(
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type' => 'datetime',
            'group' => 'modified_by_name',
            'comment' => 'Date record last modified',
            'enable_range_search' => true,
            'studio' => array(
                'portaleditview' => false, // Bug58408 - hide from Portal edit layout
            ),
            'options' => 'date_range_search_dom',
        ),
        'modified_user_id' =>
        array(
            'name' => 'modified_user_id',
            'rname' => 'user_name',
            'id_name' => 'modified_user_id',
            'vname' => 'LBL_MODIFIED',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'group' => 'modified_by_name',
            'dbType' => 'id',
            'reportable' => true,
            'comment' => 'User who last modified record',
            'massupdate' => false,
        ),
        'modified_by_name' =>
        array(
            'name' => 'modified_by_name',
            'vname' => 'LBL_MODIFIED_NAME',
            'type' => 'relate',
            'reportable' => false,
            'source' => 'non-db',
            'rname' => 'full_name',
            'table' => 'users',
            'id_name' => 'modified_user_id',
            'module' => 'Users',
            'link' => 'modified_user_link',
            'duplicate_merge' => 'disabled',
            'massupdate' => false,
        ),
        'created_by' =>
        array(
            'name' => 'created_by',
            'rname' => 'user_name',
            'id_name' => 'modified_user_id',
            'vname' => 'LBL_CREATED',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'dbType' => 'id',
            'group' => 'created_by_name',
            'comment' => 'User who created record',
            'massupdate' => false,
        ),
        'created_by_name' =>
        array(
            'name' => 'created_by_name',
            'vname' => 'LBL_CREATED',
            'type' => 'relate',
            'reportable' => false,
            'link' => 'created_by_link',
            'rname' => 'full_name',
            'source' => 'non-db',
            'table' => 'users',
            'id_name' => 'created_by',
            'module' => 'Users',
            'duplicate_merge' => 'disabled',
            'importable' => 'false',
            'massupdate' => false,
        ),
        'name' =>
        array(
            'name' => 'name',
            'vname' => 'LBL_LIST_NAME',
            'type' => 'name',
            'dbType' => 'varchar',
            'len' => '50',
            'comment' => 'Name of the product category',
            'importable' => 'required',
            'unified_search' => true,
            'full_text_search' => array('boost' => 3),
        ),
        'list_order' =>
        array(
            'name' => 'list_order',
            'vname' => 'LBL_LIST_ORDER',
            'type' => 'int',
            'len' => '4',
            'comment' => 'Order within list',
            'importable' => 'required',
        ),
        'description' =>
        array(
            'name' => 'description',
            'vname' => 'LBL_DESCRIPTION',
            'type' => 'text',
            'comment' => 'Full description of the category'
        ),
        'assigned_user_id' =>
        array(
            'name' => 'assigned_user_id',
            'vname' => 'LBL_ASSIGNED_USER_NAME',
            'type' => 'varchar',
            'len' => '36',
            'comment' => 'The id of the user who owns the product category',
            'reportable' => true
        ),
        'parent_id' =>
        array(
            'name' => 'parent_id',
            'vname' => 'LBL_PARENT_NAME',
            'type' => 'id',
            'comment' => 'Parent category of this item; used for multi-tiered categorization',
            'reportable' => true
        ),
        'categories' =>
        array(
            'name' => 'categories',
            'type' => 'link',
            'relationship' => 'member_categories',
            'module' => 'ProductCategories',
            'bean_name' => 'ProductCategory',
            'source' => 'non-db',
            'vname' => 'LBL_CATEGORIES',
        ),
        'parent_name' =>
        array(
            'name' => 'parent_name',
            'rname' => 'name',
            'id_name' => 'parent_id',
            'vname' => 'LBL_PARENT_CATEGORY',
            'type' => 'relate',
            'isnull' => 'true',
            'module' => 'ProductCategories',
            'table' => 'product_categories',
            'massupdate' => false,
            'source' => 'non-db',
            'len' => 36,
            'link' => 'member_categories',
            'unified_search' => true,
            'importable' => 'true',
        ),
        'type' =>
        array(
            'name' => 'type',
            'type' => 'varchar',
            'source' => 'non-db'
        ),

    ),
    'acls' => array('SugarACLAdminOnly' => array('adminFor' => 'Products', 'allowUserRead' => true)),
    'indices' =>
    array(
        array('name' => 'product_categoriespk', 'type' => 'primary', 'fields' => array('id')),
        array('name' => 'idx_productcategories', 'type' => 'index', 'fields' => array('name', 'deleted')),
    ),
    'relationships' => array(
        'member_categories' => array(
            'lhs_module' => 'ProductCategories',
            'lhs_table' => 'product_categories',
            'lhs_key' => 'id',
            'rhs_module' => 'ProductCategories',
            'rhs_table' => 'product_categories',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many'
        )
    )
);

