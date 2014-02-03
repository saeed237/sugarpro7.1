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



global $mod_strings;
global $current_language;

$focus = BeanFactory::getBean('Groups');
$where = ' users.users.is_group = 1 ';

$current_module_strings = return_module_language($current_language, 'Users');

$ListView = new ListView();
$ListView->initNewXTemplate('modules/Groups/ListView.html',$current_module_strings);
$ListView->setHeaderTitle($mod_strings['LBL_LIST_TITLE']);
$ListView->setQuery($where, "", "last_name, first_name", "USER");
$ListView->show_mass_update=false;
$ListView->processListView($focus, "main", "USER");
?>