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
$viewdefs["base"]["view"]["dashlet-toolbar"] = array(
    "buttons" => array(
        array(
            "type" => "dashletaction",
            "css_class" => "dashlet-toggle btn btn-invisible minify",
            "icon" => "icon-chevron-up",
            "action" => "toggleMinify",
            "tooltip" => "LBL_DASHLET_MINIMIZE",
        ),
        array(
            "dropdown_buttons" => array(
                array(
                    "type" => "dashletaction",
                    "action" => "editClicked",
                    "label" => "LBL_DASHLET_CONFIG_EDIT_LABEL",
                ),
                array(
                    "type" => "dashletaction",
                    "action" => "refreshClicked",
                    "label" => "LBL_DASHLET_REFRESH_LABEL",
                ),
                array(
                    "type" => "dashletaction",
                    "action" => "removeClicked",
                    "label" => "LBL_DASHLET_REMOVE_LABEL",
                ),
            )
        )
    )
);
