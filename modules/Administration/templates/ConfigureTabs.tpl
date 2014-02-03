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
<link rel="stylesheet" type="text/css" href="{sugar_getjspath file='modules/Connectors/tpls/tabs.css'}"/>
<script type="text/javascript" src="cache/include/javascript/sugar_grp_yui_widgets.js"></script>

<form name="ConfigureTabs" method="POST"  method="POST" action="index.php">
<input type="hidden" name="module" value="Administration">
<input type="hidden" name="action" value="SaveTabs">
<input type="hidden" id="enabled_tabs" name="enabled_tabs" value="">
<input type="hidden" id="disabled_tabs" name="disabled_tabs" value="">
<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
<input type="hidden" name="return_action" value="{$RETURN_ACTION}">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td colspan='100'><h2>{$title}</h2></td></tr>
<tr><td colspan='100'>{$MOD.LBL_CONFIG_TABS_DESC}</td></tr>
<tr><td><br></td></tr>
<tr><td colspan='100'>
	<table border="0" cellspacing="1" cellpadding="1" class="actionsContainer">
		<tr>
			<td>
				<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="SUGAR.saveConfigureTabs();this.form.action.value='SaveTabs'; " type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" > 
				<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value='index'; this.form.module.value='Administration';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
	
	<div class='add_table' style='margin-bottom:5px'>
		<table id="ConfigureTabs" class="themeSettings edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="2">
				    <input type='checkbox' name='user_edit_tabs' value=1 class='checkbox' {if !empty($user_can_edit)}CHECKED{/if}>&nbsp;
				    <b onclick='document.EditView.user_edit_tabs.checked= !document.EditView.user_edit_tabs.checked' style='cursor:default'>{$MOD.LBL_ALLOW_USER_TABS}</b>
				    &nbsp;{sugar_help text=$MOD.LBL_CONFIG_TABS_ALLOW_USERS_HIDE_TABS_HELP}
				</td>
			</tr>
			<tr>
				<td width='1%'>
					<div id="enabled_div" class="enabled_tab_workarea">
					</div>
				</td>
				<td>
					<div id="disabled_div" class="disabled_tab_workarea">
					</div>
				</td>
			</tr>
		</table>
	</div>
	
	<div class='add_subpanels' style='margin-bottom:5px'>
		<table id="ConfigureSubPanels" class="themeSettings edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width='1%'>
					<div id="enabled_subpanels_div"></div>	
				</td>
				<td>
					<div id="disabled_subpanels_div"></div>
				</td>
			</tr>
		</table>
	</div>
	
	<table border="0" cellspacing="1" cellpadding="1" class="actionsContainer">
		<tr>
			<td>
				<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" onclick="SUGAR.saveConfigureTabs();this.form.action.value='SaveTabs'; " type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" >
				<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" class="button" onclick="this.form.action.value='index'; this.form.module.value='Administration';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
</td></tr>
</table>	
</form>

<script type="text/javascript">
	var enabled_modules = {$enabled_tabs};
	var disabled_modules = {$disabled_tabs};
	var lblEnabled = '{sugar_translate label="LBL_VISIBLE_TABS"}';
	var lblDisabled = '{sugar_translate label="LBL_HIDDEN_TABS"}';
	{literal}
	
	SUGAR.enabledTabsTable = new YAHOO.SUGAR.DragDropTable(
		"enabled_div",
		[{key:"label",  label: lblEnabled, width: 200, sortable: false},
		 {key:"module", label: lblEnabled, hidden:true}],
		new YAHOO.util.LocalDataSource(enabled_modules, {
			responseSchema: {
			   resultsList : "modules",
			   fields : [{key : "module"}, {key : "label"}]
			}
		}), 
		{
			height: "300px",
			group: ["enabled_div", "disabled_div"]
		}
	);
	SUGAR.disabledTabsTable = new YAHOO.SUGAR.DragDropTable(
		"disabled_div",
		[{key:"label",  label: lblDisabled, width: 200, sortable: false},
		 {key:"module", label: lblDisabled, hidden:true}],
		new YAHOO.util.LocalDataSource(disabled_modules, {
			responseSchema: {
			   resultsList : "modules",
			   fields : [{key : "module"}, {key : "label"}]
			}
		}),
		{
			height: "300px",
		 	group: ["enabled_div", "disabled_div"]
		 }
	);
	SUGAR.enabledTabsTable.disableEmptyRows = true;
    SUGAR.disabledTabsTable.disableEmptyRows = true;
    SUGAR.enabledTabsTable.addRow({module: "", label: ""});
    SUGAR.disabledTabsTable.addRow({module: "", label: ""});
	SUGAR.enabledTabsTable.render();
	SUGAR.disabledTabsTable.render();
	{/literal}
	var sub_enabled_modules = {$enabled_panels};
	var sub_disabled_modules = {$disabled_panels};
	var lblSubEnabled = '{sugar_translate label="LBL_VISIBLE_PANELS"}';
	var lblSubDisabled = '{sugar_translate label="LBL_HIDDEN_PANELS"}';
	{literal}
	SUGAR.subEnabledTable = new YAHOO.SUGAR.DragDropTable(
		"enabled_subpanels_div",
		[{key:"label",  label: lblSubEnabled, width: 200, sortable: false},
		 {key:"module", label: lblSubEnabled, hidden:true}],
		new YAHOO.util.LocalDataSource(sub_enabled_modules, {
			responseSchema: {
			   fields : [{key : "module"}, {key : "label"}]
			}
		}),  
		{
		 	height: "300px",
		 	group: ["enabled_subpanels_div", "disabled_subpanels_div"]
		}
	);
	SUGAR.subDisabledTable = new YAHOO.SUGAR.DragDropTable(
		"disabled_subpanels_div",
		[{key:"label",  label: lblSubDisabled, width: 200, sortable: false},
		 {key:"module", label: lblSubDisabled, hidden:true}],
		new YAHOO.util.LocalDataSource(sub_disabled_modules, {
			responseSchema: {
			   fields : [{key : "module"}, {key : "label"}]
			}
		}),
		{
		 	height: "300px",
		 	group: ["enabled_subpanels_div", "disabled_subpanels_div"]
		}
	);
	SUGAR.subEnabledTable.disableEmptyRows = true;
	SUGAR.subDisabledTable.disableEmptyRows = true;
	SUGAR.subEnabledTable.addRow({module: "", label: ""});
	SUGAR.subDisabledTable.addRow({module: "", label: ""});
	SUGAR.subEnabledTable.render();
	SUGAR.subDisabledTable.render();
	
	SUGAR.saveConfigureTabs = function()
	{
		var enabledTable = SUGAR.enabledTabsTable;
		var modules = [];
		for(var i=0; i < enabledTable.getRecordSet().getLength(); i++){
			var data = enabledTable.getRecord(i).getData();
			if (data.module && data.module != '')
			    modules[i] = data.module;
		}
		YAHOO.util.Dom.get('enabled_tabs').value = YAHOO.lang.JSON.stringify(modules);
		
		var disabledTable = SUGAR.subDisabledTable;
		var modules = [];
		for(var i=0; i < disabledTable.getRecordSet().getLength(); i++){
			var data = disabledTable.getRecord(i).getData();
			if (data.module && data.module != '')
			    modules[i] = data.module;
		}
		YAHOO.util.Dom.get('disabled_tabs').value = YAHOO.lang.JSON.stringify(modules);
	}

    // ping sidecar everytime this page is loaded to check for possible http 412 codes (refreshes the menu)
    var app = parent.SUGAR.App;
    app.api.call('read', app.api.buildURL('ping'));
{/literal}
</script>
