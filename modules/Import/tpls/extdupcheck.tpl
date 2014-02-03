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
{literal}
<style>
<!--
textarea { width: 20em }

#selected_indices
{
    padding-left:30px;
    padding-right:30px;
}
-->
</style>
{/literal}
<script type="text/javascript" src="{sugar_getjspath file='cache/include/javascript/sugar_grp_yui_widgets.js'}"></script>
<form enctype="multipart/form-data" real_id="importstepdup" id="importstepdup" name="importstepdup" method="POST" action="index.php">

{foreach from=$smarty.request key=k item=v}
    {if $k neq 'current_step'}
    <input type="hidden" name="{$k}" value="{$v}">
    {/if}
{/foreach}

<input type="hidden" name="module" value="Import">
<input type="hidden" name="import_type" value="{$smarty.request.import_type}">
<input type="hidden" name="type" value="{$smarty.request.type}">
<input type="hidden" name="file_name" value="{$smarty.request.tmp_file}">
<input type="hidden" name="source_id" value="{$SOURCE_ID}">
<input type="hidden" name="current_step" value="{$CURRENT_STEP}">
<input type="hidden" name="records_per_import" value="{$RECORDTHRESHOLD}">
<input type="hidden" name="offset" value="0">
<input type="hidden" name="to_pdf" value="1">
<input type="hidden" name="display_tabs_def">
<input type="hidden" id="enabled_dupes" name="enabled_dupes" value="">
<input type="hidden" id="disabled_dupes" name="disabled_dupes" value="">

    <br />
    <table border="0" cellpadding="30" id="importTable" style="width:60% !important;">
    <tr>
        <td scope="row" align="left" colspan="2" style="text-align: left;">{$MOD.LBL_VERIFY_DUPS}&nbsp;{sugar_help text=$MOD.LBL_VERIFY_DUPLCATES_HELP}</td>
    </tr>
    <tr>
        <td  width="40%" colspan="2">
           <table id="DupeCheck" class="themeSettings edit view" style='margin-bottom:0px;' border="0" cellspacing="10" cellpadding="0"  width = '100%'>
                <tr>
                    <td align="right">
                        <div id="enabled_div" class="enabled_tab_workarea"></div>
                    </td>
                    <td align="left">
                        <div id="disabled_div" class="disabled_tab_workarea"></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>

{$JAVASCRIPT_CHOOSER}

<br />
<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr>
    <td align="left">
        <input title="{$MOD.LBL_BACK}"  id="goback" class="button" type="submit" name="button" value="  {$MOD.LBL_BACK}  ">&nbsp;
        <input title="{$MOD.LBL_IMPORT_NOW}"  id="importnow" class="button" type="button" name="button" value="  {$MOD.LBL_IMPORT_NOW}  ">
    </td>
</tr>
</table>

</form>
{literal}
{/literal}
{$JAVASCRIPT}
{literal}
<script type="text/javascript" language="Javascript">
enableQS(false);
{/literal}{$getNameJs}{literal}
{/literal}{$getNumberJs}{literal}
{/literal}{$currencySymbolJs}{literal}
{/literal}{$confirmReassignJs}{literal}
</script>
{/literal}
