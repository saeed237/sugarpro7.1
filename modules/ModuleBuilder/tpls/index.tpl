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
<iframe id="yui-history-iframe" src="index.php?entryPoint=getImage&imageName=sugar-yui-sprites-grey.png" title="index.php?entryPoint=getImage&imageName=sugar-yui-sprites-grey.png"></iframe>
<input id="yui-history-field" type="hidden"> 
<div class='ytheme-gray' id='mblayout' style="position:relative; height:0px; overflow:visible;">
</div>
<div id='mbcenter'>
<div id='mbtabs'></div>
{$CENTER}
</div>

<div id='mbeast' class="x-layout-inactive-content">
{$PROPERTIES}
</div>
<div id='mbeast2' class="x-layout-inactive-content">
</div>
<div id='mbhelp' class="x-hidden"></div>
<div id='mbwest' class="x-hidden">
<div id='package_tree' class="x-hidden"></div>
{$TREE}
</div>
<div id='mbsouth' class="x-hidden">
</div>
{$tiny}
<script>
ModuleBuilder.setMode('{$TYPE}');
closeMenus();
{literal}
//document.getElementById('HideHandle').parentNode.style.display = 'none';
var MBLoader = new YAHOO.util.YUILoader({
    require : ["layout", "element", "tabview", "treeview", "history", "cookie", "sugarwidgets"],
    loadOptional: true,
    skin: { base: 'blank', defaultSkin: '' },
	onSuccess: ModuleBuilder.init,
    allowRollup: true,
    base: "include/javascript/yui/build/"
});
MBLoader.addModule({
    name :"sugarwidgets",
    type : "js",
    fullpath: "include/javascript/sugarwidgets/SugarYUIWidgets.js",
    varName: "YAHOO.SUGAR",
    requires: ["datatable", "dragdrop", "treeview", "tabview"]
});
MBLoader.insert();
{/literal}
</script>
<div id="footerHTML" class="y-hidden">
    <table width="100%" cellpadding="0" cellspacing="0"><tr><td nowrap="nowrap">
    <input type="button" class="button" value="{$mod.LBL_HOME}" onclick="ModuleBuilder.main('home');">
    {if $TEST_STUDIO == true}
    <input type="button" class="button" value="{$mod.LBL_STUDIO}" onclick="ModuleBuilder.main('studio');">
    {/if}
    {if $ADMIN == true}
    <input type="button" class="button" value="{$mod.LBL_MODULEBUILDER}" onclick="ModuleBuilder.main('mb');">
    {/if}
    <input type="button" class="button" value="{$mod.LBL_DROPDOWNEDITOR}" onclick="ModuleBuilder.main('dropdowns');">
    </td><td align="left">
    <a href="http://www.sugarcrm.com" target="_blank">
        <img height="25" width="83" class="img" src="include/images/poweredby_sugarcrm_65.png" border="0" align="absmiddle"/>
    </a>
     </td></tr></table>
</div>
{include file='modules/ModuleBuilder/tpls/assistantJavascript.tpl'}
