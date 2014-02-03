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


function loadParentView($type)
{
    SugarAutoLoader::requireWithCustom('include/MVC/View/views/view.'.$type.'.php');
}


function getPrintLink()
{
//    if (isset($_REQUEST['action']) && $_REQUEST['action'] == "ajaxui")
//    {
//        return "javascript:SUGAR.ajaxUI.print();";
//    }
    return "javascript:void window.open('index.php?{$GLOBALS['request_string']}',"
         . "'printwin','menubar=1,status=0,resizable=1,scrollbars=1,toolbar=0,location=1')";
}

/**
 * @deprecated since 7.0
 * @return the $url given
 */
function ajaxLink($url)
{
    return $url;
    /*
    global $sugar_config;
    $match = array();
    $javascriptMatch = array();

    preg_match('/module=([^&]*)/i', $url, $match);
    preg_match('/^javascript/i', $url, $javascriptMatch);

    if(!empty($sugar_config['disableAjaxUI'])){
        return $url;
    }
    else if(isset($match[1]) && in_array($match[1], ajaxBannedModules())){
        return $url;
    }
    //Don't modify javascript calls.
    else if (isset($javascriptMatch[0])) {
    	return $url;
    }
    else
    {
        return "?action=ajaxui#ajaxUILoc=" . urlencode($url);
    }
    */
}

?>
