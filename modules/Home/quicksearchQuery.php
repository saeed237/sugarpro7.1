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


SugarAutoLoader::requireWithCustom('modules/Home/QuickSearch.php');
if(class_exists('quicksearchQueryCustom')) {
    $quicksearchQuery = new quicksearchQueryCustom();
}
else
{
    $quicksearchQuery = new quicksearchQuery();
}

$json = getJSONobj();
$data = $json->decode(html_entity_decode($_REQUEST['data']));
if(isset($_REQUEST['query']) && !empty($_REQUEST['query'])){
    foreach($data['conditions'] as $k=>$v){
        if (empty($data['conditions'][$k]['value']) && ($data['conditions'][$k]['op'] != quicksearchQuery::CONDITION_EQUAL))
        {
            $data['conditions'][$k]['value']=$_REQUEST['query'];
        }
    }
}

$method = !empty($data['method']) ? $data['method'] : 'query';
if(method_exists($quicksearchQuery, $method)) {
   echo $quicksearchQuery->$method($data);
}
