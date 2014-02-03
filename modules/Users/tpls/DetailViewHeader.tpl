<!--
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

-->
<script type='text/javascript' src='{sugar_getjspath file='modules/Users/DetailView.js'}'></script>
<script type="text/javascript" src="{sugar_getjspath file='cache/include/javascript/sugar_grp_yui_widgets.js'}"></script>
<script type='text/javascript'>
var LBL_NEW_USER_PASSWORD = '{$MOD.LBL_NEW_USER_PASSWORD_2}';
{if !empty($ERRORS)}
{literal}
YAHOO.SUGAR.MessageBox.show({title: '{/literal}{$ERROR_MESSAGE}{literal}', msg: '{/literal}{$ERRORS}{literal}'} );
{/literal}
{/if}
</script>

<script type="text/javascript">
var user_detailview_tabs = new YAHOO.widget.TabView("user_detailview_tabs");

{literal}
user_detailview_tabs.on('contentReady', function(e){
{/literal}
{if $EDIT_SELF && $SHOW_DOWNLOADS_TAB}
{literal}
    user_detailview_tabs.addTab( new YAHOO.widget.Tab({
        label: '{/literal}{$MOD.LBL_DOWNLOADS}{literal}',
        dataSrc: 'index.php?to_pdf=1&module=Home&action=pluginList',
        content: '<div style="text-align:center; width: 100%">{/literal}{sugar_image name="loading"}{literal}</div>',
        cacheData: true
    }));
    user_detailview_tabs.getTab(3).getElementsByTagName('a')[0].id = 'tab4';
{/literal}
{/if}
});
{literal}
$(document).ready(function(){
        $("ul.clickMenu").each(function(index, node){
            $(node).sugarActionMenu();
        });
    });
{/literal}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="actionsContainer">
<tr>
<td width="20%">

<form action="index.php" method="post" name="DetailView" id="form">
    <input type="hidden" name="module" value="Users">
    <input type="hidden" name="record" value="{$ID}">
    <input type="hidden" name="isDuplicate" value=false>
    <input type="hidden" name="action">
    <input type="hidden" name="user_name" value="{$USER_NAME}">
    <input type="hidden" id="user_type" name="user_type" value="{$UserType}">
    <input type="hidden" name="password_generate">
    <input type="hidden" name="old_password">
    <input type="hidden" name="new_password">
    <input type="hidden" name="return_module">
    <input type="hidden" name="return_action">
    <input type="hidden" name="return_id">
<table width="100%" cellpadding="0" cellspacing="0" border="0">

    <tr><td colspan='2' width="100%" nowrap>

            {sugar_action_menu id="detail_header_action_menu" class="clickMenu fancymenu" buttons=$EDITBUTTONS}

    </td></tr>
</table>
</form>

</td>
<td width="100%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
{$PAGINATION}
</table>
</td>
</tr>
</table>
<div id="user_detailview_tabs" class="yui-navset detailview_tabs">
    <ul class="yui-nav">
        <li class="selected"><a id="tab1" href="#tab1"><em>{$MOD.LBL_USER_INFORMATION}</em></a></li>
        <li {if $IS_GROUP_OR_PORTAL}style="display: none;"{/if}><a id="tab2" href="#tab2"><em>{$MOD.LBL_ADVANCED}</em></a></li>
        {if $SHOW_ROLES}
        <li><a id="tab3" href="#tab3"><em>{$MOD.LBL_USER_ACCESS}</em></a></li>
        {/if}
    </ul>
    <div class="yui-content">
        <div>
