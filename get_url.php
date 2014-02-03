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

/**
 * Use this script to fetch linkedin js code.
 */

$url = '';
$type = !empty($_GET['type']) ? $_GET['type'] : '';
switch ($type)
{
    case 'linkedin' :
        require_once('include/connectors/formatters/FormatterFactory.php');
        $formatter = FormatterFactory::getInstance('ext_rest_linkedin');
        $url = $formatter->getComponent()->getSource()->getConfig();
        $url = $url['properties']['company_url'];
        break;
}

if ($url == '')
{
    return;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_TIMEOUT, '30');
curl_exec($ch);
curl_close($ch);
