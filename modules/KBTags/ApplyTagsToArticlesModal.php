<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

    // Request object must have these property values:
    // Module: module name, this module should have a file called TreeData.php
    // Function: name of the function to be called in TreeData.php, the function
// will be called statically.
    // PARAM prefixed properties: array of these property/values will be passed
// to the function as parameter.

require_once('include/JSON.php');
require_once('include/entryPoint.php');
require_once('include/upload_file.php');
require_once('vendor/ytree/Tree.php');
require_once('vendor/ytree/Node.php');
require_once('modules/KBTags/TreeData.php');

$json = getJSONobj();
$tagArticleIds = $json->decode(html_entity_decode($_REQUEST['tagAndArticleIds']));
if (isset($tagArticleIds['jsonObject']) && $tagArticleIds['jsonObject'] != null) {
    $tagArticleIds = $tagArticleIds['jsonObject'];
}

/*
 * $articleIds = $json->decode(html_entity_decode($_REQUEST['articles']));
 * if(isset($articleIds['jsonObject']) && $articleIds['jsonObject'] != null){
 * $articleIds = $articleIds['jsonObject']; }
 * $GLOBALS['log']->fatal($articleIds);
 */
$deleted = 1;
$deletedNot = 0;

$KBTag = BeanFactory::getBean('KBTags');
$tagsCount = $tagArticleIds[0];
$articlesCount = $tagArticleIds[1];

for ($i = 0; $i < $tagsCount; $i++) {
    $tagId = $tagArticleIds[$i + 2];
    // fetch the existing documents
    $qdocs = 'SELECT kbdocument_id FROM kbdocuments_kbtags WHERE kbtag_id=\'' . $tagId .
         '\' and deleted = ' . $deletedNot . '';
    $results = $KBTag->db->query($qdocs);

    for ($j = 0; $j < $articlesCount; $j++) {
        // check if the article already exists in tag
        $articleExists = false;
        while (($rows = $GLOBALS['db']->fetchByAssoc($results)) != null) {
            if (!empty($rows['kbdocument_id'])) {
                if ($rows['kbdocument_id'] == $tagArticleIds[$j + 2 + $tagsCount]) {
                    $articleExists = true;
                    break;
                }
            }
        }
        if (!$articleExists) {
            $KBDocument = BeanFactory::getBean('KBDocuments', $tagArticleIds[$j + 2 + $tagsCount]);
            $doc_team_id = $KBDocument->team_id;
            $guid = create_guid();
            $qi = 'INSERT INTO kbdocuments_kbtags (id,kbtag_id,kbdocument_id,team_id) values(\'' .
                 $guid . '\',\'' . $tagId . '\',\'' . $tagArticleIds[$j + 2 + $tagsCount] . '\',\'' .
                 $doc_team_id . '\')';
            $KBTag->db->query($qi);
        }
    }
}
// new tree
$tagstree = new Tree('tagstree');
$tagstree->set_param('module', 'KBTags');
$tagstree->set_param('moduleview', 'admin');
$nodes = get_tags_nodes(false, true, null);
$root_node = new Node('All_Tags', $mod_strings['LBL_TAGS_ROOT_LABEL']);
foreach ($nodes as $node) {
    $root_node->add_node($node);
}
$root_node->expanded = true;
$tagstree->add_node($root_node);
$response = $tagstree->generate_nodes_array();
$response .= "<script>document.getElementById('selected_directory_children').innerHTML=''</script>";

if (!empty($response)) {
    echo $response;
    // return the parameters
}
sugar_cleanup(true);

