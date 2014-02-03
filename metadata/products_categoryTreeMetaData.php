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

$dictionary['products_category_tree'] =
        array('table' => 'category_tree',
                'fields' => array(
                    array('name' => 'self_id',
                          'type' => 'varchar',
                          'len' => '36'
                    ),
                    array('name' => 'node_id',
                          'type' => 'int',
                          'auto_increment' => true,
                          'required' => true,
                          'isnull' => false         // Making sure it's not NULLABLE since it is the primary key.
                    ),
                    array('name' => 'parent_node_id',
                          'type' => 'int',
                          'default' => '0'
                    ),
                    array('name' => 'type',
                          'type' => 'varchar',
                          'len' => '36'
                    )
                ),
                'indices' => array(
                    array('name' => 'categorytreepk', 'type' => 'primary', 'fields' => array('node_id')),
                    array('name' => 'idx_categorytree', 'type' => 'index', 'fields' => array('self_id'))
                )
        );
