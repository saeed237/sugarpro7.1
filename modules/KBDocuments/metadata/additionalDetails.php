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


function additionalDetailsKBDocument($fields,$full=false) {
    static $mod_strings;
    static $app_list_strings;
    if(empty($mod_strings)) {
        global $current_language;
        $mod_strings = return_module_language($current_language, 'KBDocuments');
    }
    if(empty($app_list_strings)) {
        global $current_language;
        $app_list_strings = return_app_list_strings_language($current_language);
    }

global $theme;
global $sugar_config;

    //if full parameter is specified, then we are expecting the preview with content info
//    if($full){
            $overlib_string = "<div  STYLE='width: 545px; height: 300px; overflow: auto;'><table width='100%' border='0'>";
        //check to see if we have field info to process
        if(!empty($fields['ID'])){
            //process fields if they are not empty
            if(!empty($fields['DOCUMENT_NAME'])) $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_NAME'] . '</b> </td><td>' . $fields['DOCUMENT_NAME'] . ' </td></tr>';
            if(!empty($fields['DESCRIPTION'])) $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_DESCRIPTION'] . '</b> ' . $fields['DESCRIPTION'] . '<br>';
            if(!empty($fields['CREATED_BY_NAME'])) $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_ARTICLE_AUTHOR'] . '</b> ' . $fields['CREATED_BY_NAME'] . '<br>';
            if(!empty($fields['ASSIGNED_TO_NAME'])) $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_KBDOC_APPROVED_BY'] . '</b> ' . $fields['ASSIGNED_TO_NAME'] . '<br>';
            if(!empty($fields['ACTIVE_DATE'])) $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_DOC_ACTIVE_DATE'] . '</b> ' . $fields['ACTIVE_DATE'] . '<br>';
            if(!empty($fields['EXP_DATE'])) $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_DOC_EXP_DATE'] . '</b> ' . $fields['EXP_DATE'] . '<br>';
            if(!empty($fields['IS_EXTERNAL_ARTICLE'])) $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_IS_EXTERNAL_ARTICLE'] . '</b> ' . $app_list_strings['dom_int_bool'][$fields['IS_EXTERNAL_ARTICLE']] . '<br>';

            //query for content
            $content_query = "Select kbdocument_body from kbcontents where id in";
            $content_query .= "(select kbcontent_id from kbdocument_revisions where ";
            $content_query .= "kbdocument_id = '" . $fields['ID'] . "' and latest = '1')";

            $result = $GLOBALS['db']->query($content_query);
            $row=$GLOBALS['db']->fetchByAssoc($result);

            //display content if it exists
            if(!isset($row) || empty($row)){
                $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_DESCRIPTION'] . '</b> </td><td>'.$mod_strings['LBL_ARTICLE_PREVEW_UNAVAILABLE_NO_CONTENT'].'</td></tr>';
            }else{

                if(!empty($row['kbdocument_body'])){
                    $contentBody = from_html($row['kbdocument_body']);
                    $contentBody = str_replace('/cache/images/',$sugar_config['site_url'].'/cache/images/',$contentBody);
                    $overlib_string .= '<tr><td colspan=2 nowrap>'. $contentBody . '</td></tr>';
                }else{
                 //output not found text in html
                    $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_DESCRIPTION'] . '</b> </td><td>'.$mod_strings['LBL_ARTICLE_PREVEW_UNAVAILABLE_NO_CONTENT'].'</td></tr>';
                }
            }

        }else{
         //output not found text in html
            $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_DESCRIPTION'] . '</b> </td><td>'.$mod_strings['LBL_ARTICLE_PREVEW_UNAVAILABLE_NO_DOCUMENT'].'</td></tr>';
        }

            $overlib_string .= "</table ></div>";



                return array('fieldToAddTo' => 'NAME',
                         'string' => $overlib_string,
                         );

   /* }else{

        //normal additional details
        $overlib_string = '';
        if(!empty($fields['KBDOCUMENT_NAME'])) $overlib_string .= '<b>' . $mod_strings['LBL_NAME'] . '</b> ' . $fields['KBDOCUMENT_NAME'] . '<br>';
        if(!empty($fields['DESCRIPTION'])) $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_DESCRIPTION'] . '</b> ' . $fields['DESCRIPTION'] . '<br>';
        if(!empty($fields['KBDOC_APPROVER_NAME'])) $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_KBDOC_APPROVED_BY'] . '</b> ' . $fields['KBDOC_APPROVER_NAME'] . '<br>';
        if(!empty($fields['ACTIVE_DATE'])) $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_DOC_ACTIVE_DATE'] . '</b> ' . $fields['ACTIVE_DATE'] . '<br>';
        if(!empty($fields['EXP_DATE'])) $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_DOC_EXP_DATE'] . '</b> ' . $fields['EXP_DATE'] . '<br>';
        if(!empty($fields['IS_EXTERNAL_ARTICLE'])) $overlib_string .= '<tr><td nowrap><b>'. $mod_strings['LBL_IS_EXTERNAL_ARTICLE'] . '</b> ' . $app_list_strings['dom_int_bool'][$fields['IS_EXTERNAL_ARTICLE']] . '<br>';

    return array('fieldToAddTo' => 'NAME',
                 'string' => $overlib_string,
                 'editLink' => "index.php?action=EditView&module=KBDocuments&return_module=KBDocuments&record={$fields['ID']}",
                 'viewLink' => "index.php?action=DetailView&module=KBDocuments&return_module=KBDocuments&record={$fields['ID']}");

    }*/
}

 ?>

