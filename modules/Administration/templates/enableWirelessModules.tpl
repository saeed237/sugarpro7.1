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
<script type="text/javascript" src="cache/include/javascript/sugar_grp_yui_widgets.js"></script>
<link rel="stylesheet" type="text/css" href="{sugar_getjspath file='modules/Connectors/tpls/tabs.css'}"/>
<form name="enableWirelessModules" method="POST">
	<input type="hidden" name="module" value="Administration">
	<input type="hidden" name="action" value="updateWirelessEnabledModules">
	<input type="hidden" name="enabled_modules" value="">
	
	<table border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td>
			<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" onclick="SUGAR.saveMobileSettings();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
			<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="document.enableWirelessModules.action.value='';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
	
	<div class='add_table' style='margin-bottom:5px'>
		<table id="enableWirelessModules" class="enableWirelessModules edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0" width="25%">
			<tr>
			    <td colspan="2">
			        <table>
                    {if $url}
                    <tr>
                        <td scope="row" nowrap="nowrap">
                            {sugar_translate module='Configurator' label='LBL_WIRELESS_SERVER_URL'}:
                            {sugar_help text=$MOD.LBL_WIRELESS_URL_HELP}
                        </td>
                        </td>
                        <td>
                            <a href="{$url}" target="_blank">{$url}</a>
                        </td>
                    </tr>
                    {/if}
                    <tr>
                        <td scope="row" nowrap="nowrap">{sugar_translate module='Configurator' label='LBL_WIRELESS_LIST_ENTRIES'}: <br><small>{sugar_translate label='LBL_WIRELESS_LEGACY_ONLY'}</small></td>
                        <td>
                            <input type='text' size='4' id="max_list" name='wl_list_max_entries_per_page' value='{$config.wl_list_max_entries_per_page}'>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" nowrap="nowrap">{sugar_translate module='Configurator' label='LBL_WIRELESS_SUBPANEL_LIST_ENTRIES'}: <br><small>{sugar_translate label='LBL_WIRELESS_LEGACY_ONLY'}</small></bt> </td>
                        <td>
                            <input type='text' size='4' id="max_subs" name='wl_list_max_entries_per_subpanel' value='{$config.wl_list_max_entries_per_subpanel}'>
                        </td>
                    </tr>
                     <tr>
                        <td colspan="2" white-space="wrap" style="font-style: italic;"><span>{sugar_translate label='LBL_WIRELESS_MODULES_ENABLE_DESC2'}</span></td>
                    </tr>
                </td>
            </tr>
		    <tr>
				<td width='1%'>
					<div id="enabled_div"></div>	
				</td>
				<td>
					<div id="disabled_div"></div>
				</td>
			</tr>
		</table>
	</div>
	
	<table border="0" cellspacing="1" cellpadding="1">
	   <tr>
	       <td colspan="2">{sugar_translate module='Configurator' label='LBL_MOBILE_MOD_REPORTS_RESTRICTION2'}</td>
       </tr>
        <tr>
           <td colspan="2">{sugar_translate label='LBL_WIRELESS_SUPPORTED_MODULES2'}</td>
       </tr>
		<tr>
			<td>
				<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" class="button primary" onclick="SUGAR.saveMobileSettings();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
				<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" class="button" onclick="document.enableWirelessModules.action.value='';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
</form>

<script type="text/javascript">
(function(){ldelim}
    var Connect = YAHOO.util.Connect;
	Connect.url = 'index.php';
    Connect.method = 'POST';
    Connect.timeout = 300000;
	var get = YAHOO.util.Dom.get;

	var enabled_modules = {$enabled_modules};
	var disabled_modules = {$disabled_modules};
	var lblEnabled = '{sugar_translate label="LBL_ACTIVE_MODULES"}';
	var lblDisabled = '{sugar_translate label="LBL_DISABLED_MODULES"}';
	{literal}
	SUGAR.mobileEnabledTable = new YAHOO.SUGAR.DragDropTable(
		"enabled_div",
		[{key:"label",  label: lblEnabled, width: 200, sortable: false},
		 {key:"module", label: lblEnabled, hidden:true}],
		new YAHOO.util.LocalDataSource(enabled_modules, {
			responseSchema: {fields : [{key : "module"}, {key : "label"}]}
		}),  
		{height: "300px"}
	);
	SUGAR.mobileDisabledTable = new YAHOO.SUGAR.DragDropTable(
		"disabled_div",
		[{key:"label",  label: lblDisabled, width: 200, sortable: false},
		 {key:"module", label: lblDisabled, hidden:true}],
		new YAHOO.util.LocalDataSource(disabled_modules, {
			responseSchema: {fields : [{key : "module"}, {key : "label"}]}
		}),
		{height: "300px"}
	);
	SUGAR.mobileEnabledTable.disableEmptyRows = true;
	SUGAR.mobileDisabledTable.disableEmptyRows = true;
	SUGAR.mobileEnabledTable.addRow({module: "", label: ""});
	SUGAR.mobileDisabledTable.addRow({module: "", label: ""});
	SUGAR.mobileEnabledTable.render();
	SUGAR.mobileDisabledTable.render();
	
	SUGAR.saveMobileSettings = function()
	{
		var enabledTable = SUGAR.mobileEnabledTable;
		var modules = "";
		for(var i=0; i < enabledTable.getRecordSet().getLength(); i++){
			var data = enabledTable.getRecord(i).getData();
			if (data.module && data.module != '')
			    modules += "," + data.module;
		}
		modules = modules == "" ? modules : modules.substr(1);
		
		ajaxStatus.showStatus(SUGAR.language.get('Administration', 'LBL_SAVING'));
		Connect.asyncRequest(
            Connect.method, 
            Connect.url, 
            {success: SUGAR.saveCallBack},
			SUGAR.util.paramsToUrl({
				module: "Administration",
				action: "updateWirelessEnabledModules",
				enabled_modules: modules,
				wl_list_max_entries_per_page : get('max_list').value,
				wl_list_max_entries_per_subpanel : get('max_subs').value
			}) + "to_pdf=1"
        );
		
		return true;
	}
	SUGAR.saveCallBack = function(o)
	{
	   ajaxStatus.flashStatus(SUGAR.language.get('app_strings', 'LBL_DONE'));
	   if (o.responseText == "true")
	   {
	       window.location.assign('index.php?module=Administration&action=index');
	   } 
	   else 
	   {
	       YAHOO.SUGAR.MessageBox.show({msg:o.responseText});
	   }
	}	
})();
{/literal}
</script>