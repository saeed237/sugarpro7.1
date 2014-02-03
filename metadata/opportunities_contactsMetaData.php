<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$dictionary['opportunities_contacts'] = array(
    'table' => 'opportunities_contacts',
    'fields' => array(
        array('name' => 'id',               'type' => 'varchar', 'len' => '36'),
        array('name' => 'contact_id',       'type' => 'varchar', 'len' => '36'),
        array('name' => 'opportunity_id',   'type' => 'varchar', 'len' => '36'),
        array('name' => 'contact_role',     'type' => 'varchar', 'len' => '50'),
        array('name' => 'date_modified',    'type' => 'datetime'),
        array('name' => 'deleted',          'type' => 'bool',    'len' => '1', 'default' => '0', 'required' => false)
    ),
    'indices' => array(
        array('name' => 'opportunities_contactspk', 'type' => 'primary', 'fields' => array('id')),
        array('name' => 'idx_con_opp_con', 'type' => 'index', 'fields' => array('contact_id')),
        array('name' => 'idx_con_opp_opp', 'type' => 'index', 'fields' => array('opportunity_id')),
        array('name' => 'idx_opportunities_contacts', 'type' => 'alternate_key', 'fields' => array('opportunity_id', 'contact_id'))


    ),
    'relationships' => array(
        'opportunities_contacts' => array(
            'lhs_module' => 'Opportunities',
            'lhs_table' => 'opportunities',
            'lhs_key' => 'id',
            'rhs_module' => 'Contacts',
            'rhs_table' => 'contacts',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'opportunities_contacts',
            'join_key_lhs' => 'opportunity_id',
            'join_key_rhs' => 'contact_id',
        )
    )
)



?>
