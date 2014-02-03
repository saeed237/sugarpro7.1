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

{if $hideLevel < 5 && $show_fts}
<tr>
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_FTS"}:</td>
    <td>
        {if empty($vardef.full_text_search) || empty($vardef.full_text_search.boost)}
            {html_options name="full_text_search[boost]" id="full_text_search" selected="0" options=$fts_options}
        {else}
            {html_options name="full_text_search[boost]" id="full_text_search" selected=$vardef.full_text_search.boost options=$fts_options}
        {/if}
        <img border="0" class="inlineHelpTip" alt="Information" src="themes/Sugar/images/helpInline.png" onclick="return SUGAR.util.showHelpTips(this,'{$mod_strings.LBL_POPHELP_SEARCHABLE}','','' );">
    </td>
</tr>
{/if}

{include file='modules/DynamicFields/templates/Fields/Forms/coreDependent.tpl'}

{if $vardef.type != 'bool'}
<tr ><td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_REQUIRED_OPTION"}:</td><td><input type="checkbox" name="required" value="1" {if !empty($vardef.required)}CHECKED{/if} {if $hideLevel > 5}disabled{/if}/>{if $hideLevel > 5}<input type="hidden" name="required" value="{$vardef.required}">{/if}</td></tr>
{/if}
<tr>
{if !$hideReportable}
<td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_REPORTABLE"}:</td>
<td>
	<input type="checkbox" name="reportableCheckbox" value="1" {if !empty($vardef.reportable)}CHECKED{/if} {if $hideLevel > 5}disabled{/if} 
	onClick="if(this.checked) document.getElementById('reportable').value=1; else document.getElementById('reportable').value=0;"/>
	<input type="hidden" name="reportable" id="reportable" value="{if !empty($vardef.reportable)}{$vardef.reportable}{else}0{/if}">
</td>
</tr>
{/if}
<tr><td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_AUDIT"}:</td><td><input type="checkbox" name="audited" value="1" {if !empty($vardef.audited) }CHECKED{/if} {if $hideLevel > 5}disabled{/if}/>{if $hideLevel > 5}<input type="hidden" name="audited" value="{$vardef.audited}">{/if}</td></tr>


{if !$hideImportable}
<tr><td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_IMPORTABLE"}:</td><td>
    {if $hideLevel < 5}
        {html_options name="importable" id="importable" selected=$vardef.importable options=$importable_options}
        {sugar_help text=$mod_strings.LBL_POPHELP_IMPORTABLE FIXX=250 FIXY=80}
    {else}
        {if isset($vardef.importable)}{$importable_options[$vardef.importable]}
        {else}{$importable_options.true}{/if}
    {/if}
</td></tr>
{/if}
{if !$hideDuplicatable}
<tr><td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DUPLICATE_MERGE"}:</td><td>
{if $hideLevel < 5}
    {html_options name="duplicate_merge" id="duplicate_merge" selected=$vardef.duplicate_merge_dom_value options=$duplicate_merge_options}
    {sugar_help text=$mod_strings.LBL_POPHELP_DUPLICATE_MERGE FIXX=250 FIXY=80}
{else}
    {if isset($vardef.duplicate_merge_dom_value)}{$vardef.duplicate_merge_dom_value}
    {else}{$duplicate_merge_options[0]}{/if}
{/if}
</td></tr>
{/if}
</table>

{if !empty($vardef.group)}
    <input type="hidden" name="group" value="{$vardef.group}">
{/if}