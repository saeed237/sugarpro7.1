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

//include any group of products in these stages for the standard pdf template
//Does not need to be translated this is just for the keys
$in_total_group_stages =  $GLOBALS['app_list_strings']['in_total_group_stages'];
$pdf_group_subtotal = true;

if (SugarAutoLoader::existing('custom/modules/Quotes/config.php'))
{
	include_once('custom/modules/Quotes/config.php');
}
