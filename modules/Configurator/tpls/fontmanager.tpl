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
<script type="text/javascript" src='{sugar_getjspath file ='cache/include/javascript/sugar_grp_yui_widgets.js'}'></script>
<script type="text/javascript" src='{sugar_getjspath file ='include/javascript/yui/build/paginator/paginator-min.js'}'></script>
{literal}
<style type="text/css">
    .yui-pg-container {
        background: none;
    }
</style>
{/literal}
<p>
{$MODULE_TITLE}
</p>
<form enctype="multipart/form-data" name="fontmanager" method="POST" action="index.php" id="fontmanager">
<input type="hidden" name="module" value="Configurator">
<input type="hidden" name="action" value="FontManager">
<input type="hidden" name="action_type" value="">
<input type="hidden" name="filename" value="">
<input type="hidden" name='return_action' value="{$RETURN_ACTION}">
<span class='error'>{$error}</span>
<br>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="left">
            <input title="{$MOD.LBL_BACK}"  class="button" type="button" name="gobackbutton" value="  {$MOD.LBL_BACK}  " id="gobackbutton">&nbsp;
            <input title="{$MOD.LBL_ADD_FONT}" class="button" type="button" name="addFontbutton" value="  {$MOD.LBL_ADD_FONT}  " id="addFontbutton">
        </td>
    </tr>
</table>

<br>
<div id="YuiListMarkup"></div>
<br>

</form>
{literal}
<script type="text/javascript">
var removeFormatter = function (el, oRecord, oColumn, oData) {
    if(oRecord._oData.type != "{/literal}{$MOD.LBL_FONT_TYPE_CORE}{literal}" && oRecord._oData.fontpath != "{/literal}{$K_PATH_FONTS}{literal}"){
        el.innerHTML = '<a href="#" name="deleteButton" onclick="return false;">{sugar_getimage name="delete_inline" ext=".gif" alt=$mod_strings.LBL_DELETE other_attributes='align="absmiddle" border="0" '}{/literal} {$MOD.LBL_REMOVE}{literal}<\/a>';
    }
};
YAHOO.util.Event.onDOMReady(function() {
{/literal}
	var fontColumnDefs = {$COLUMNDEFS};
    var fontData = {$DATASOURCE};
{literal}
	var fontDataSource = new YAHOO.util.DataSource(fontData);
	fontDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    fontDataSource.responseSchema = {/literal}{$RESPONSESCHEMA}{literal};
    var oConfigs = {
        paginator: new YAHOO.widget.Paginator({
            rowsPerPage:15
        })
    };
    var fontDataTable = new YAHOO.widget.DataTable("YuiListMarkup", fontColumnDefs, fontDataSource, oConfigs);

    fontDataTable.subscribe("linkClickEvent", function(oArgs){
        if(oArgs.target.name == "deleteButton"){
            if(confirm('{/literal}{$MOD.LBL_JS_CONFIRM_DELETE_FONT}{literal}')){
            	   document.getElementById("fontmanager").action.value = "deleteFont";
            	   document.getElementById("fontmanager").filename.value = this.getRecord(oArgs.target)._oData.filename;
            	   document.getElementById("fontmanager").submit();
            }
        }
    });
    
    document.getElementById('gobackbutton').onclick=function(){
        if(document.getElementById("fontmanager").return_action.value != ""){
        	document.location.href='index.php?module=Configurator&action=' + document.getElementById("fontmanager").return_action.value;
        }else{
        	document.location.href='index.php?module=Configurator&action=SugarpdfSettings';
        }
    };
    document.getElementById('addFontbutton').onclick=function(){
    	document.location.href='index.php?module=Configurator&action=addFontView';
    };
    
});
{/literal}
</script>
