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







global $app_strings;
global $app_list_strings;
global $current_language;
$current_module_strings = return_module_language($current_language, 'Leads');

$ListView = new ListView();
$seedLeads = BeanFactory::getBean('Leads');
$header_text = '';
if(is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])){	
		$header_text = "&nbsp;<a href='index.php?action=index&module=DynamicLayout&from_action=MyLeads&from_module=Leads'>".SugarThemeRegistry::current()->getImage("EditLayout","border='0' alt='Edit Layout' align='bottom'",null,null,'.gif',$mod_strings['LBL_EDITLAYOUT'])."</a>";
}
$where = "assigned_user_id='". $current_user->id ."' and (leads.status is NULL or (leads.status!='Converted' and leads.status!='Dead' and leads.status!='recycled')) ";
$ListView->initNewXTemplate( 'modules/Leads/MyLeads.html',$current_module_strings);
$ListView->setHeaderTitle($current_module_strings['LBL_LIST_MY_LEADS'] . $header_text);
$ListView->setQuery($where, "", "leads.date_entered desc", "LEAD");
$ListView->processListView($seedLeads, "main", "LEAD");
?>