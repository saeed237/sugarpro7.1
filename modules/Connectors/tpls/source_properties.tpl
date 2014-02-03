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

<br/>
{if !empty($connector_language.LBL_LICENSING_INFO)}
{$connector_language.LBL_LICENSING_INFO}
{/if}
<br/>
<table width="100%" border="0" cellspacing="1" cellpadding="0" >
{if !empty($properties)}
{foreach from=$properties key=name item=value}
<tr>
<td class="dataLabel" width="35%">
{$connector_language[$name]}:&nbsp;
{if isset($required_properties[$name])}
<span class="required">*</span>
{/if}
</td>
<td class="dataLabel" width="65%">
<input type="text" id="{$source_id}_{$name}" name="{$source_id}_{$name}" size="75" value="{$value}"></td>
</tr>
{/foreach}
{if $hasTestingEnabled}
<tr>
<td class="dataLabel" colspan="2">
<input id="{$source_id}_test_button" type="button" class="button" value="  {$mod.LBL_TEST_SOURCE}  " onclick="run_test('{$source_id}');">
</td>
</tr>
<tr>
<td class="dataLabel" colspan="2">
<span id="{$source_id}_result">&nbsp;</span>
</td>
</tr>
{/if}
{else}
<tr>
<td class="dataLabel" colspan="2">&nbsp;</td>
<td class="dataLabel" colspan="2">{$mod.LBL_NO_PROPERTIES}</td>
</tr>
{/if}
</table>

<script type="text/javascript">
{foreach from=$required_properties key=id item=label}
addToValidate("ModifyProperties", "{$source_id}_{$id}", "alpha", true, "{$label}");
{/foreach}
</script>