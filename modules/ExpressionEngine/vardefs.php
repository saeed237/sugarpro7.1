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


$dictionary['Formula'] = array(
    'table' => 'formulas',
    'comment' => 'Stored formulas that can be re-used ansd referenced in SugarLogic',
    'fields' => array(
        'target_module' => array(
            'name' => 'target_module',
            'vname' => 'LBL_TARGET_MODULE',
            'type' => 'varchar',
            'len' => '255',
            'comment' => 'The target module for this formula',
            'required' => true,
        ),
        'formula' => array(
            'name' => 'formula',
            'vname' => 'LBL_FORMULA',
            'type' => 'varchar',
            'len' => '255',
            'required' => true,
        ),
        'return_type' => array(
            'name' => 'return_type',
            'vname' => 'LBL_RETURN_TYPE',
            'type' => 'varchar',
            'len' => '255',
            'required' => true,
        ),
    ),
);

VardefManager::createVardef('ExpressionEngine','Formula', array('default', 'basic'));
