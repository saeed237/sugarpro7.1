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


{if $helpFileExists}
<html {$langHeader}>
<head>
<title>{$title}</title>
{$styleSheet}
<meta http-equiv="Content-Type" content="text/html; charset={$charset}">
</head>
<body onLoad='window.focus();'>
<table width='100%'>
<tr>
    <td align='right'>
        <a href='javascript:window.print()'>{$MOD.LBL_HELP_PRINT}</a> - 
        <a href='mailto:?subject="{$MOD.LBL_SUGARCRM_HELP}&body={$currentURL}'>{$MOD.LBL_HELP_EMAIL}</a> - 
        <a href='#' onmousedown="createBookmarkLink('{$MOD.LBL_SUGARCRM_HELP} - {$moduleName}', '{$currentURL|escape:url}')">{$MOD.LBL_HELP_BOOKMARK}</a>
    </td>
</tr>
</table>
<table class='edit view'>
<tr>
    <td>{include file="$helpPath"}</td>
</tr>
</table>
{literal}
<script type="text/javascript" language="JavaScript">
<!--
function createBookmarkLink(title, url){
    if (document.all)
        window.external.AddFavorite(url, title);
    else if (window.sidebar)
        window.sidebar.addPanel(title, url, "")
}
-->
</script>
{/literal}
</body>
</html>	
{else}
<IFRAME frameborder="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF" SRC="{$iframeURL}" TITLE="{$iframeURL}" NAME="SUGARIFRAME" ID="SUGARIFRAME" WIDTH="100%" height="1000"></IFRAME>
{/if}