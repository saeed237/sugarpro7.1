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
{if !$displayParams.nolink}
<a href="index.php?module={$module}&action=DetailView&record={$values.primary.id}">
{/if}
{$values.primary.name}
{if !$displayParams.nolink}
</a>

{if !empty($values.secondaries)}
    <a href="javascript:collection['{$vardef.name}'].js_more_detail('{$values.primary.id}')" id='more_{$values.primary.id}' class="utilsLink">{sugar_getimage name="advanced_search" ext=".gif" width="8" height="8" alt=$app_strings.LBL_HIDE_SHOW other_attributes='border="0" id="more_img_{$values.primary.id}" '}</a>
    <div id='more_div_{$values.primary.id}' style="display:none">
    {foreach item=secondary_field from=$values.secondaries}
        <br><a href="index.php?module={$module}&action=DetailView&record={$secondary_field.id}">
        {$secondary_field.name}
        </a>
    {foreachelse}
    {/foreach}
    </div>
<script type="text/javascript" src='{sugar_getjspath file="include/SugarFields/Fields/Collection/SugarFieldCollection.js"}'></script>
<script type="text/javascript">
    var collection = (typeof collection == 'undefined') ? new Array() : collection;
    collection['{$vardef.name}'] = new SUGAR.collection('{$displayParams.formName}', '{$vardef.name}', '{$module}', '{$displayParams.popupData}');
</script>
{/if}
{/if}