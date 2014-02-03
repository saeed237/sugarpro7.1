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

 


function start_sync()
{
	height = 30;
	window.open("index.php?action=Popup&check_available=1&module=Sync&clean_sync=0","sync","width=300,height="+ height+",resizable=1,scrollbars=1");
}

function work_online()
{
	document.location.href = "index.php?action=index&module=Sync&go_online=1&check_available=1";
}
