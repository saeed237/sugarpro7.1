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
<h3>{sugar_translate label="LBL_REMOVE_CUSTOM"}</h3>
<form name="remove_custom">
<input type="hidden" name="module" value="ModuleBuilder">
<input type="hidden" name="action" value="resetmodule">
<input type="hidden" name="view_module" value="{$module}">
<input type="hidden" name="handle" value="execute">
<ul id="repair_actions">
{foreach from=$actions item='action'}
<li>
    <input type="checkbox" name="{$action.name}" value="{$action.name}" checked="checked" />
    {$action.label}
</li> 
{/foreach}
</ul>
</form>
<button id="execute_repair" onclick="this.disabled = true;
ajaxStatus.showStatus(SUGAR.language.get('ModuleBuilder', 'LBL_AJAX_LOADING'));
ModuleBuilder.submitForm('remove_custom')">{sugar_translate label="LBL_RESET"}</button>
