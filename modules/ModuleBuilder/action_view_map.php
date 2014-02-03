<?php
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

/*
 * Created on May 14, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 //format '<action_name>' => '<view_name>',
 $action_view_map = array(
 						'index' => 'main',
 						'module'=>'module',
 						'modulefields'=>'modulefields',
 						'modulelabels'=>'modulelabels',
 						'relationships'=>'relationships',
 						'relationship'=>'relationship',
                        'resetmodule'=>'resetmodule',
 						'modulefield'=>'modulefield',
 						'displaydeploy'=>'displaydeploy',
 						'package'=>'package',
 						'dropdown'=>'dropdown',
 						'dropdowns'=>'dropdowns',
 						'detailview' => 'detail',
 						'editview' => 'edit',
 						'popup' => 'popup',
 						'home'=>'home',
                        'visibilityeditor' => 'visibilityeditor',
 						'exportcustomizations'=>'exportcustomizations',
                        'depdropdown' => 'depdropdown',

 					);
    // add those we need from the global action_view_map
    $action_view_map['dc'] = 'dc';
    $action_view_map['dcajax'] = 'dcajax';
    $action_view_map['quick'] = 'quick';
    $action_view_map['quickcreate'] = 'quickcreate';
    $action_view_map['spot'] = 'spot';
    $action_view_map['inlinefield'] = 'inlinefield';
    $action_view_map['inlinefieldsave'] = 'inlinefieldsave';
    $action_view_map['pluginlist'] = 'plugins';
    $action_view_map['downloadplugin'] = 'downloadplugin';
?>
