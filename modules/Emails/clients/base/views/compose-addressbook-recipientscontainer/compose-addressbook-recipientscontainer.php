<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

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

/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$viewdefs["Emails"]["base"]["view"]["compose-addressbook-recipientscontainer"] = array(
    'template' => 'record',
    "panels" => array(
        array(
            "name"         => "selected_recipients",
            "columns"      => 1,
            "labels"       => true,
            "labelsOnTop"  => true,
            "placeholders" => true,
            "fields"       => array(
                array(
                    "name"                => "compose_addressbook_selected_recipients",
                    "type"                => "recipients",
                    "label"               => "LBL_SELECTED_RECIPIENTS",
                    "css_class_container" => "controls-one btn-fit",
                    'readonly'            => true,
                    "span"                => 12,
                ),
            ),
        ),
    ),
);

