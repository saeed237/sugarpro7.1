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
$dictionary['ProspectList'] = array(
    'favorites'        => true,
    'table'            => 'prospect_lists',
    'unified_search'   => true,
    'full_text_search' => true,
    'fields'           => array(
        'id'               => array(
            'name'       => 'id',
            'vname'      => 'LBL_ID',
            'type'       => 'id',
            'required'   => true,
            'reportable' => false,
        ),
        'name'             => array(
            'name'             => 'name',
            'vname'            => 'LBL_NAME',
            'type'             => 'name',
            'dbType' => 'varchar',
            'len'              => '50',
            'importable'       => 'required',
            'unified_search'   => true,
            'full_text_search' => array('boost' => 3),
            'required'         => true,
        ),
        'list_type'        => array(
            'name'       => 'list_type',
            'vname'      => 'LBL_TYPE',
            'type'       => 'enum',
            'options'    => 'prospect_list_type_dom',
            'len'        => 100,
            'importable' => 'required',
        ),
        'date_entered'     => array(
            'name'  => 'date_entered',
            'vname' => 'LBL_DATE_ENTERED',
            'type'  => 'datetime',
        ),
        'date_modified'    => array(
            'name'  => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type'  => 'datetime',
        ),
        'modified_user_id' => array(
            'name'       => 'modified_user_id',
            'rname'      => 'user_name',
            'id_name'    => 'modified_user_id',
            'vname'      => 'LBL_MODIFIED',
            'type'       => 'assigned_user_name',
            'table'      => 'modified_user_id_users',
            'isnull'     => 'false',
            'dbType'     => 'id',
            'reportable' => true,
        ),
        'modified_by_name' => array(
            'name'            => 'modified_by_name',
            'vname'           => 'LBL_MODIFIED',
            'type'            => 'relate',
            'reportable'      => false,
            'source'          => 'non-db',
            'table'           => 'users',
            'rname'           => 'name',
            'id_name'         => 'modified_user_id',
            'module'          => 'Users',
            'duplicate_merge' => 'disabled',
        ),
        'created_by'       => array(
            'name'    => 'created_by',
            'rname'   => 'user_name',
            'id_name' => 'created_by',
            'vname'   => 'LBL_CREATED',
            'type'    => 'assigned_user_name',
            'table'   => 'created_by_users',
            'isnull'  => 'false',
            'dbType'  => 'id',
        ),
        'created_by_name'  => array(
            'name'            => 'created_by_name',
            'vname'           => 'LBL_CREATED',
            'type'            => 'relate',
            'reportable'      => false,
            'source'          => 'non-db',
            'table'           => 'users',
            'rname'           => 'name',
            'id_name'         => 'created_by',
            'module'          => 'Users',
            'duplicate_merge' => 'disabled',
        ),
        'deleted'          => array(
            'name'       => 'deleted',
            'vname'      => 'LBL_CREATED_BY',
            'type'       => 'bool',
            'required'   => false,
            'reportable' => false,
        ),
        'description'      => array(
            'name'  => 'description',
            'vname' => 'LBL_DESCRIPTION',
            'type'  => 'text',
        ),
        'domain_name'      => array(
            'name'  => 'domain_name',
            'vname' => 'LBL_DOMAIN_NAME',
            'type'  => 'varchar',
            'len'   => '255',
        ),
        'entry_count'      => array(
            'name'   => 'entry_count',
            'type'   => 'int',
            'source' => 'non-db',
            'vname'  => 'LBL_LIST_ENTRIES',
        ),
        'prospects'        => array(
            'name'         => 'prospects',
            'type'         => 'link',
            'relationship' => 'prospect_list_prospects',
            'source'       => 'non-db',
        ),
        'contacts'         => array(
            'name'         => 'contacts',
            'type'         => 'link',
            'relationship' => 'prospect_list_contacts',
            'source'       => 'non-db',
        ),
        'leads'            => array(
            'name'         => 'leads',
            'type'         => 'link',
            'relationship' => 'prospect_list_leads',
            'source'       => 'non-db',
        ),
        'accounts'         => array(
            'name'         => 'accounts',
            'type'         => 'link',
            'relationship' => 'prospect_list_accounts',
            'source'       => 'non-db',
        ),
        'campaigns'        => array(
            'name'         => 'campaigns',
            'type'         => 'link',
            'relationship' => 'prospect_list_campaigns',
            'source'       => 'non-db',
        ),
        'users'            => array(
            'name'         => 'users',
            'type'         => 'link',
            'relationship' => 'prospect_list_users',
            'source'       => 'non-db',
        ),
        'email_marketing'  => array(
            'name'         => 'email_marketing',
            'type'         => 'link',
            'relationship' => 'email_marketing_prospect_lists',
            'source'       => 'non-db',
        ),
        'marketing_id'     => array(
            'name'   => 'marketing_id',
            'vname'  => 'LBL_MARKETING_ID',
            'type'   => 'varchar',
            'len'    => '36',
            'source' => 'non-db',
        ),
        'marketing_name'   => array(
            'name'   => 'marketing_name',
            'vname'  => 'LBL_MARKETING_NAME',
            'type'   => 'varchar',
            'len'    => '255',
            'source' => 'non-db',
        ),
    ),
    'indices'          => array(
        array(
            'name'   => 'prospectlistsspk',
            'type'   => 'primary',
            'fields' => array('id'),
        ),
        array(
            'name'   => 'idx_prospect_list_name',
            'type'   => 'index',
            'fields' => array('name'),
        ),
    ),
    'relationships'    => array(
        'prospectlists_assigned_user' => array(
            'lhs_module'        => 'Users',
            'lhs_table'         => 'users',
            'lhs_key'           => 'id',
            'rhs_module'        => 'prospectlists',
            'rhs_table'         => 'prospect_lists',
            'rhs_key'           => 'assigned_user_id',
            'relationship_type' => 'one-to-many',
        ),
    ),
);

VardefManager::createVardef(
    'ProspectLists',
    'ProspectList',
    array(
         'assignable',
         'team_security',
    )
);
