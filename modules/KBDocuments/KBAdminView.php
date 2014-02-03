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

 * Description: TODO:  To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/



require_once('vendor/ytree/Tree.php');
require_once('vendor/ytree/Node.php');
require_once('modules/KBTags/TreeData.php');
require_once('modules/KBDocuments/Forms.php');
require_once('modules/KBDocuments/SearchUtils.php');

global $app_strings;
global $app_list_strings;
global $mod_strings;
global $current_user;
global $sugar_version;
global $sugar_config;

if(!$current_user->isAdminForModule('KBDocuments') ){
	die($mod_strings['LBL_NOT_AN_ADMIN_USER']);
}

$params = array();
$params[] = $mod_strings['LBL_KNOWLEDGE_BASE_ADMIN'];

echo getClassicModuleTitle("KBDocuments", $params, true);

$xtpl=new XTemplate ('modules/KBDocuments/KBAdminView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);

$tag = BeanFactory::getBean('KBTags');
$xtpl->assign("TAG_NAME", $tag->tag_name);
 //tree header.
        $tagstree=new Tree('tagstree');
        $tagstree->set_param('module','KBTags');
        $tagstree->set_param('moduleview','admin');

        $nodes=get_tags_nodes(false,true,null);
        $root_node = new Node('All_Tags', $mod_strings['LBL_TAGS_ROOT_LABEL']);  
        $root_node->expanded = true;
        $href_string = "javascript:handler:SUGAR.kb.adminClick()";
        $root_node->set_property("href",$href_string);                
        
        foreach ($nodes as $node) {                                         
          $root_node->add_node($node);                        
        }
        $tagstree->add_node($root_node); 
                       
        $xtpl->assign("TAGSTREEINSTANCE",$tagstree->generate_nodes_array());
//set the site_url variable.
        global $sugar_config;
        $sugar_config['site_url'] = preg_replace('/^http(s)?\:\/\/[^\/]+/',"http$1://".$_SERVER['HTTP_HOST'],$sugar_config['site_url']);
        if(!empty($_SERVER['SERVER_PORT']) &&$_SERVER['SERVER_PORT'] == '443') {
            $sugar_config['site_url'] = preg_replace('/^http\:/','https:',$sugar_config['site_url']);
        }
        $site_data = "<script> var site_url= {\"site_url\":\"".$sugar_config['site_url']."\"};</script>\n";

        $xtpl->assign("SITEURL",$site_data);

    echo'<script> var site_url= {"site_url":"'.$sugar_config['site_url'].'"};</script>';

        $tagstreeModal=new Tree('tagstreeMoveDocsModal');
        $tagstreeModal->set_param('module','KBTags');
        $tagstreeModal->set_param('moduleview','modalMoveDocs');

        $nodes=get_tags_modal_nodes(null,false);
        //$nodes = get_tag_nodes_for_browsing();
        //_pp($nodes);
        foreach ($nodes as $node) {
            $tagstreeModal->add_node($node);
        }

        $xtpl->assign("TAGSTREEMOVEDOCSMODAL",$tagstreeModal->generate_nodes_array());

        $tagstreeApply=new Tree('tagstreeApplyTags');
        $tagstreeApply->set_param('module','KBTags');
        $tagstreeApply->set_param('moduleview','applyTags');

        $nodes=get_tags_modal_nodes(null,true);
        //$nodes = get_tag_nodes_for_browsing();

        foreach ($nodes as $node) {
            $tagstreeApply->add_node($node);
        }


   //$xtpl->assign("TAGSTREEAPPLYOCSMODAL",$tagstreeApply->generate_nodes_array());


   $xtpl->assign("ADMIN_ACTIONS", get_select_options_with_id($app_list_strings['kbadmin_actions_dom'], ''));
 
$xtpl->parse("main.pro");


$xtpl->parse("main");
$xtpl->out("main");


$savedSearch = BeanFactory::getBean('SavedSearch');
$json = getJSONobj();
$savedSearchSelects = $json->encode(array($GLOBALS['app_strings']['LBL_SAVED_SEARCH_SHORTCUT'] . '<br>' . $savedSearch->getSelect('KBDocuments')));
$str = "<script>
YAHOO.util.Event.addListener(window, 'load', SUGAR.util.fillShortcuts, $savedSearchSelects);
</script>";
echo $str;

?>