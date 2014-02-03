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

/*********************************************************************************

 ********************************************************************************/
if (!$GLOBALS['current_user']->isAdminForModule('Users')) sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);

global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user;
$GLOBALS['displayListView'] = true; 
$header_text = '';
$focus = BeanFactory::getBean('TeamNotices');
//$is_edit = true;

$GLOBALS['log']->info("TeamNotice list view");

echo getClassicModuleTitle('TeamNotices', array($mod_strings['LBL_MODULE_NAME']), true);

$ListView = new ListView();
$ListView->initNewXTemplate( 'modules/TeamNotices/ListView.html',$mod_strings);
$ListView->xTemplateAssign("DELETE_INLINE_PNG",  SugarThemeRegistry::current()->getImage('delete_inline','align="absmiddle" border="0"',null,null,'.gif',$app_strings['LNK_DELETE']));
$ListView->setQuery('', "", "team_notices.name", "TEAMNOTICE");
$ListView->processListView($focus, "main", "TEAMNOTICE");