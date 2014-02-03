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
<!--FIXME no longer needed-->
<script type="text/javascript" src="{sugar_getjspath file='cache/include/javascript/sugar_grp_yui_widgets.js'}"></script>
<form name="ConfigureAjaxUI" method="POST"  method="POST" action="index.php">
	<input type="hidden" name="module" value="Administration">
	<input type="hidden" name="action" value="UpdateAjaxUI">
	<input type="hidden" id="enabled_modules" name="enabled_modules" value="">
	<input type="hidden" id="disabled_modules" name="disabled_modules" value="">
	<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
	<input type="hidden" name="return_action" value="{$RETURN_ACTION}">

	{$title}<br/>
        <p>{sugar_translate label="LBL_CONFIG_AJAX_DESC"}</p><br/>
	<p>{sugar_translate label="LBL_CONFIG_AJAX_HELP"}</p><br/>
	<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary"
		   onclick="SUGAR.saveConfigureTabs();" type="submit" name="saveButton"
		   value="{$APP.LBL_SAVE_BUTTON_LABEL}" />
	<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button"
		   onclick="this.form.action.value='index'; this.form.module.value='Administration';" type="submit" name="CancelButton"
		   value="{$APP.LBL_CANCEL_BUTTON_LABEL}"/>
	<div class='add_table' style='margin-bottom:5px'>
		<table id="ConfigureTabs" class="themeSettings edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0">
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
</form>

<script type="text/javascript">
	var enabled_modules = {$enabled_mods};
	var disabled_modules = {$disabled_mods};
	var lblEnabled = '{sugar_translate label="LBL_ACTIVE_MODULES"}';
	var lblDisabled = '{sugar_translate label="LBL_DISABLED_MODULES"}';
	{literal}
	
	SUGAR.enabledModsTable = new YAHOO.SUGAR.DragDropTable(
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
	SUGAR.disabledModsTable = new YAHOO.SUGAR.DragDropTable(
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
	SUGAR.enabledModsTable.disableEmptyRows = true;
    SUGAR.disabledModsTable.disableEmptyRows = true;
    SUGAR.enabledModsTable.addRow({module: "", label: ""});
    SUGAR.disabledModsTable.addRow({module: "", label: ""});
	SUGAR.enabledModsTable.render();
	SUGAR.disabledModsTable.render();

	SUGAR.saveConfigureTabs = function()
	{
		var disabledTable = SUGAR.disabledModsTable;
		var modules = [];
		for(var i=0; i < disabledTable.getRecordSet().getLength(); i++){
			var data = disabledTable.getRecord(i).getData();
			if (data.module && data.module != '')
			    modules[i] = data.module;
		}
		YAHOO.util.Dom.get('disabled_modules').value = YAHOO.lang.JSON.stringify(modules);
	}
{/literal}
</script>
*}
