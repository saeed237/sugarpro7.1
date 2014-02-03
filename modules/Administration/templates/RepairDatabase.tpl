{*
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

*}

<h3>{$MOD.LBL_REPAIR_DATABASE_DIFFERENCES}</h3>
<p>{$MOD.LBL_REPAIR_DATABASE_TEXT}</p>
<form name="RepairDatabaseForm" method="post">
<input type="hidden" name="module" value="Administration"/>
<input type="hidden" name="action" value="repairDatabase"/>
<input type="hidden" name="raction" value="execute"/>
<textarea name="sql" rows="24" cols="150" id="repairsql">{$qry_str}</textarea>
<br/>
<input type="button" class="button" value="{$MOD.LBL_REPAIR_DATABASE_EXECUTE}" onClick="document.RepairDatabaseForm.submit();"/> 
<input type="button" class="button" value="{$MOD.LBL_REPAIR_DATABASE_EXPORT}" onClick="document.RepairDatabaseForm.raction.value='export'; document.RepairDatabaseForm.submit();"/>