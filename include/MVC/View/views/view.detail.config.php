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


$view_config = array(
    'actions' => array(
        'detailview' => array(
            'show_header' => true,
            'show_footer' => true,
            'view_print'  => false,
            'show_title' => true,
            'show_subpanels' => true,
            'show_javascript' => true,
            'show_search' => true,
            'json_output' => false,
        ),
    ),
    'req_params' => array(
        'ajax_load' => array(
            'param_value' => true,
            'config' => array(
                'show_header' => false,
                'show_footer' => false,
                'view_print'  => false,
                'show_title' => true,
                'show_subpanels' => true,
                'show_javascript' => false,
                'show_search' => true,
                'json_output' => true,
            )
        ),
    ),
);
?>