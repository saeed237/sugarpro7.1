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


{*
<table class="edit view" id="convertLayoutExtraData"><tr>
<td scope="row">Required:</td>
<td><input type="checkbox" onclick="document.getElementById('convertRequired').value = this.checked" {if $required}checked="checked"{/if}/></td>
<td scope="row">Copy Data:</td>
<td><input type="checkbox"  onclick="document.getElementById('convertCopy').value = this.checked" {if $copyData}checked="checked"{/if}/></td>
<td scope="row">Allow Selection:</td>
<td>
<select>
    <option value="none" label="No">No</option>
    {if $relationships.length == 1}
        <option value="{$relationships.0.name}" label="Yes">Yes</option>
    {else}
	    {foreach from=$relationships item=rel}
	    <option value="{$rel.name}" label="{$rel.label}" {if $rel.selected}selected="selected"{/if}>{$rel.label}</option>
	    {/foreach}
    {/if}
</select>
</td></tr>
</table>
<div style="display:none" id="convertDataForSave">
<input type="hidden" name="convertRequired" id="convertRequired" value="{$required}">
<input type="hidden" name="convertCopy" id="convertCopy" value="{$copyData}">
<input type="hidden" name="convertSelection" id="convertSelection" value="{$select}">
</div> *}
{if !empty($warningMessage)}
<p class="error">{$warningMessage}</p>
{/if}
<script type="text/javascript">
//This script will be invoked by ModuleBuilder after the HTML is already on the page
//YAHOO.util.Dom.insertAfter("convertLayoutExtraData", "layoutEditorButtons");
//YAHOO.util.Dom.insertBefore("convertDataForSave", document.getElementById("prepareForSave").firstChild);
document.forms.prepareForSave.module.value = "Leads";
</script>