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

 * Description:  
 ********************************************************************************/

global $mod_strings;

$module_menu = Array(
	Array("index.php?module=Forecasts&action=ListView", $mod_strings['LNK_FORECAST_HISTORY'],"Forecasts"),
	Array("index.php?module=Forecasts&action=index&submodule=Worksheet", $mod_strings['LNK_UPD_FORECAST'],"ForecastWorksheet"),
	Array("index.php?module=Quotas&action=index", $mod_strings['LNK_QUOTA'],"ForecastWorksheet")
);

?>
