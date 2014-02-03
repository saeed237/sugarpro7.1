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
<link rel="stylesheet" type="text/css" href="include/javascript/yui-old/assets/container.css" />
<script type="text/javascript" src='{sugar_getjspath file="include/SugarFields/Fields/Collection/SugarFieldCollection.js"}'></script>
<script type="text/javascript">
    var collection = (typeof collection == 'undefined') ? new Array() : collection;
    collection['{$displayParams.formName}_{$vardef.name}'] = new SUGAR.collection('{$displayParams.formName}', '{$vardef.name}', '{$module}', '{$displayParams.popupData}');
</script>
<input type="hidden" id="update_fields_{$displayParams.formName}_{$vardef.name}_collection" name="update_fields_{$displayParams.formName}_{$vardef.name}_collection" value="">
<input type="hidden" id="{$displayParams.formName}_{$vardef.name}_new_on_update" name="{$displayParams.formName}_{$vardef.name}_new_on_update" value="{$displayParams.new_on_update}">
<input type="hidden" id="{$displayParams.formName}_{$vardef.name}_allow_update" name="{$displayParams.formName}_{$vardef.name}_allow_update" value="{$displayParams.allow_update}">
<input type="hidden" id="{$displayParams.formName}_{$vardef.name}_allow_new" name="{$displayParams.formName}_{$vardef.name}_allow_new" value="{$displayParams.allow_new}">

{if !empty($vardef.required)}
<input type="hidden" id="{$vardef.name}_field" name="{$vardef.name}_field" value="{$vardef.name}_table">
{/if}
<table name='{$displayParams.formName}_{$vardef.name}_table' id='{$displayParams.formName}_{$vardef.name}_table' style="border-spacing: 0pt;">
        {include file=$cacheRowFile}
        <td valign='top'>
        </td>
<!-- BEGIN Remove and Radio -->
        <td valign='top'>
        	{capture assign=attr}id="remove_{$vardef.name}_collection_0" name="remove_{$vardef.name}_collection_0" onclick="collection['{$displayParams.formName}_{$vardef.name}'].remove('lineFields_{$displayParams.formName}_{$vardef.name}_0');"{/capture}
        	{sugar_getimage name="delete_inline" ext=".gif" attr=$attr}
            {if !empty($displayParams.allowNewValue) }
            <input type="hidden" name="allow_new_value_{$vardef.name}_collection_0" id="allow_new_value_{$vardef.name}_collection_0" value="true">
            {/if}
        </td>
        <td valign='top' align="center">
            <input id="primary_{$vardef.name}_collection_0" type="radio" class="radio" checked="checked" value="0" name="primary_{$vardef.name}_collection" style="{if empty($values.role_field)};display:none;{/if}" onclick="collection['{$displayParams.formName}_{$vardef.name}'].changePrimary(true);" />
        </td>
<!-- END Remove and Radio -->
    </tr>


</table>
<table name='{$displayParams.formName}_{$vardef.name}_add_table' id='{$displayParams.formName}_{$vardef.name}_add_table'>
    <tr>
        <td>
            <a href="javascript:collection['{$displayParams.formName}_{$vardef.name}'].add();">
            {capture assign="attr"}class="img" id="add_{$displayParams.formName}_{$vardef.name}_image" border="0" style="margin-top: 3px;"{/capture}
            [sugar_getimage name="plus_inline" ext=".gif" attr=$attr width="10" height="10"}
            </a>
            <a href="javascript:collection['{$displayParams.formName}_{$vardef.name}'].add();"> Add </a>
        </td>
    </tr>
</table>
{if !empty($values.secondaries)}
            {foreach item=secondary_field from=$values.secondaries key=key}
                <script type="text/javascript">
                    var temp_array = new Array();
                    temp_array['name'] = '{$secondary_field.name}';
                    temp_array['id'] = '{$secondary_field.id}';
                    collection['{$displayParams.formName}_{$vardef.name}'].secondaries_values.push(temp_array);
                </script>
            {/foreach}
{/if}
<script type="text/javascript">
(function() {ldelim}
    var field_id = '{$displayParams.formName}_{$vardef.name}';
    YAHOO.util.Event.onContentReady(field_id + "_table", function(){ldelim}
        collection[field_id].add_secondaries(collection[field_id].secondaries_values});
    {rdelim});
{rdelim})();
 	document.getElementById("id_{$displayParams.formName}_{$vardef.name}_collection_0").value = "{$values.primary.id}";
    document.getElementById("{$displayParams.formName}_{$vardef.name}_collection_0").value = "{$values.primary.name}";
</script>
{/literal}
{$quickSearchCode}