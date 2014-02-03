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



    $extensions = array(
        "actionviewmap" =>   array("section" => "action_view_map","extdir" => "ActionViewMap",  "file" => 'action_view_map.ext.php'),
        "actionfilemap" =>   array("section" => "action_file_map","extdir" => "ActionFileMap",  "file" => 'action_file_map.ext.php'),
        "actionremap" =>     array("section" => "action_remap",   "extdir" => "ActionReMap",    "file" => 'action_remap.ext.php'),
    	"administration" =>  array("section" => "administration", "extdir" => "Administration", "file" => 'administration.ext.php', "module" => "Administration"),
    	"dependencies" =>    array("section" => "dependencies",   "extdir" => "Dependencies",   "file" => 'deps.ext.php'),
    	"entrypoints" =>     array("section" => "entrypoints",	  "extdir" => "EntryPointRegistry",	"file" => 'entry_point_registry.ext.php', "module" => "application"),
    	"exts"         =>    array("section" => "extensions",	  "extdir" => "Extensions",		"file" => 'extensions.ext.php', "module" => "application"),
    	"file_access" =>     array("section" => "file_access",    "extdir" => "FileAccessControlMap", "file" => 'file_access_control_map.ext.php'),
    	"languages" =>       array("section" => "language",	      "extdir" => "Language",    	"file" => '' /* custom rebuild */),
    	"layoutdefs" =>      array("section" => "layoutdefs", 	  "extdir" => "Layoutdefs",     "file" => 'layoutdefs.ext.php'),
        "links" =>           array("section" => "linkdefs",       "extdir" => "GlobalLinks",    "file" => 'links.ext.php', "module" => "application"),
    	"logichooks" =>      array("section" => "hookdefs", 	  "extdir" => "LogicHooks",     "file" => 'logichooks.ext.php'),
        "menus" =>           array("section" => "menu",    	      "extdir" => "Menus",          "file" => "menu.ext.php"),
        "modules" =>         array("section" => "beans", 	      "extdir" => "Include", 	    "file" => 'modules.ext.php', "module" => "application"),
        "schedulers" =>      array("section" => "scheduledefs",	  "extdir" => "ScheduledTasks", "file" => 'scheduledtasks.ext.php', "module" => "Schedulers"),
        "userpage" =>        array("section" => "user_page",      "extdir" => "UserPage",       "file" => 'userpage.ext.php', "module" => "Users"),
        "utils" =>           array("section" => "utils",          "extdir" => "Utils",          "file" => 'custom_utils.ext.php', "module" => "application"),
    	"vardefs" =>         array("section" => "vardefs",	      "extdir" => "Vardefs",    	"file" => 'vardefs.ext.php'),
        "jsgroupings" =>     array("section" => "jsgroups",	      "extdir" => "JSGroupings",    "file" => 'jsgroups.ext.php'),
        "wireless_modules" => array("section" => "wireless_modules","extdir" => "WirelessModuleRegistry", "file" => 'wireless_module_registry.ext.php'),
        "wireless_subpanels" => array("section" => "wireless_subpanels", "extdir" => "WirelessLayoutdefs",     "file" => 'wireless.subpaneldefs.ext.php'),
        'tabledictionary' => array("section" => '', "extdir" => "TableDictionary", "file" => "tabledictionary.ext.php", "module" => "application"),

        // sidecar subpanel layouts
        "sidecarsubpanelbaselayout" => array("section"=>'sidecarsubpanelbaselayout', 'extdir' => 'clients/base/layouts/subpanels', 'file' => 'subpanels.ext.php'),


        "sidecarsubpanelmobilelayout" => array("section"=>'sidecarsubpanelmobilelayout', 'extdir' => 'clients/mobile/layouts/subpanels', 'file' => 'subpanels.ext.php'),

        "sidecarmenubaseheader" => array("section" => "sidecarmenubaseheader", "extdir" => "clients/base/menus/header", "file" => "header.ext.php"),


        "sidecarmenumobileheader" => array("section" => "sidecarmenumobileheader", "extdir" => "clients/mobile/menus/header", "file" => "header.ext.php"),
);
if(SugarAutoLoader::existing("custom/application/Ext/Extensions/extensions.ext.php")) {
    include("custom/application/Ext/Extensions/extensions.ext.php");
}


