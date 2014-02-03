<?php
 if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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


$viewdefs['base']['view']['interactionschart'] = array(
    'dashlets' => array(
        array(
            'name' => 'Interactions Chart',
            'description' => 'Displays Account interactions on chart.',
            'config' => array(
            ),
            'preview' => array(
            ),
            'filter' => array(
                'module' => array(
                    // Changed to 'Documents' for SugarCon 2013 since we don't
                    // want this chart visible in Sugar 7 Preview.
                    'Documents',
                    /*'Accounts',
                    'Contacts',
                    'Leads',
                    'Opportunities',*/
                ),
                'view' => 'record'
            )
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'filter_duration',
                    'label' => 'Filter',
                    'type' => 'enum',
                    'options' => 'interactions_options'
                ),
            ),
        ),
    ),
    'ui' => array(
        'colors' => array(
            'default' => '#085f94',
            'calls' => '#cce8f6',
            'emailsSent' => '#0092d1',
            'emailsRecv' => '#085f94',
            'meetings' => '#0d3d66',
        ),
    ),
    'filter_duration' => array(
        array(
            'name' => 'filter_duration',
            'label' => 'Filter',
            'type' => 'enum',
            'options' => 'interactions_options'
        ),
    )
);
