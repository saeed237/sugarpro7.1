{*
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
*}
<script type="text/javascript" src="cache/include/javascript/sugar_grp_yui_widgets.js"></script>

<link rel="stylesheet" type="text/css" href="{sugar_getjspath file='modules/Connectors/tpls/tabs.css'}"/>
<style>.yui-dt-scrollable .yui-dt-bd {ldelim}overflow-x: hidden;{rdelim}</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr><td colspan='100'><h2>{$title}</h2></td></tr>
    <tr><td><i class="info">{$msg}</i></td></tr>
    <tr><td colspan='100'>
        {if empty($msg)}
            <form name="ConfigureShortcutBar" method="POST" action="index.php">
                <input type="hidden" name="module" value="Administration">
                <input type="hidden" name="action" value="ConfigureShortcutBar">
                <input type="hidden" id="enabled_modules" name="enabled_modules" value="">
                <input type="hidden" name="return_module" value="{$RETURN_MODULE}">
                <input type="hidden" name="return_action" value="{$RETURN_ACTION}">
                <br>
                <p>{$MOD.LBL_CONFIGURE_SHORTCUT_BAR_HELP}</p>
                <br>
                <table border="0" cellspacing="1" cellpadding="1">
                    <tr>
                        <td>
                            <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="SUGAR.saveShortcutBar();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" >
                            <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="parent.SUGAR.App.router.navigate(parent.SUGAR.App.router.buildRoute('{$RETURN_MODULE}'), {literal}{trigger: true}{/literal}); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
                        </td>
                    </tr>
                </table>
                <div class='add_table' style='margin-bottom:5px'>
                    <table id="ConfigureTabs" class="themeSettings edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width='1%'><div id="enabled_div"></div></td>
                            <td><div id="disabled_div"></div></td>
                        </tr>
                    </table>
                </div>
                <table border="0" cellspacing="1" cellpadding="1">
                    <tr>
                        <td>
                            <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" onclick="SUGAR.saveShortcutBar();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" >
                            <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="parent.SUGAR.App.router.navigate(parent.SUGAR.App.router.buildRoute('{$RETURN_MODULE}'), {literal}{trigger: true}{/literal}); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
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

                var enabled_modules = {$enabled_modules};
                var disabled_modules = {$disabled_modules};
                var lblEnabled = '{sugar_translate label="LBL_ACTIVE_MODULES"}';
                var lblDisabled = '{sugar_translate label="LBL_DISABLED_MODULES"}';
                {literal}
                SUGAR.prodEnabledTable = new YAHOO.SUGAR.DragDropTable(
                        "enabled_div",
                        [
                            {key: "label", label: lblEnabled, width: 200, sortable: false},
                            {key: "module", label: lblEnabled, hidden: true}
                        ],
                        new YAHOO.util.LocalDataSource(enabled_modules, {
                            responseSchema: {
                                resultsList: "modules",
                                fields: [
                                    {key: "module"},
                                    {key: "label"}
                                ]
                            }
                        }),
                        {height: "300px"}
                );
                SUGAR.prodDisabledTable = new YAHOO.SUGAR.DragDropTable(
                        "disabled_div",
                        [
                            {key: "label", label: lblDisabled, width: 200, sortable: false},
                            {key: "module", label: lblDisabled, hidden: true}
                        ],
                        new YAHOO.util.LocalDataSource(disabled_modules, {
                            responseSchema: {
                                resultsList: "modules",
                                fields: [
                                    {key: "module"},
                                    {key: "label"}
                                ]
                            }
                        }),
                        {height: "300px"}
                );
                SUGAR.prodEnabledTable.disableEmptyRows = true;
                SUGAR.prodDisabledTable.disableEmptyRows = true;
                SUGAR.prodEnabledTable.addRow({module: "", label: ""});
                SUGAR.prodDisabledTable.addRow({module: "", label: ""});
                SUGAR.prodEnabledTable.render();
                SUGAR.prodDisabledTable.render();

                SUGAR.saveShortcutBar = function() {
                    var enabledTable = SUGAR.prodEnabledTable;
                    var modules = [];
                    if (enabledTable.getRecordSet().getLength() > 11) //Max 10 + empty line
                    {
                        alert('{/literal}{sugar_translate label="LBL_ERROR_PROD_BAR_NUM_MODULES"}{literal}');
                        return false;
                    }
                    for (var i = 0; i < enabledTable.getRecordSet().getLength(); i++) {
                        var data = enabledTable.getRecord(i).getData();
                        if (data.module && data.module != '')
                            modules[i] = data.module;
                    }

                    ajaxStatus.showStatus(SUGAR.language.get('Administration', 'LBL_SAVING'));
                    //YAHOO.SUGAR.MessageBox.show({title:"saving",msg:"Saving",close:false})
                    Connect.asyncRequest(
                            Connect.method,
                            Connect.url,
                            {success: SUGAR.saveCallBack},
                            'to_pdf=1&module=Administration&action=ConfigureShortcutBar&enabled_modules=' + YAHOO.lang.JSON.stringify(modules)
                    );

                    return true;
                }
                SUGAR.saveCallBack = function(o) {
                    ajaxStatus.flashStatus(SUGAR.language.get('app_strings', 'LBL_DONE'));
                    if (o.responseText == "true") {
                        parent.window.location.reload();
                    }
                    else {
                        YAHOO.SUGAR.MessageBox.show({msg: o.responseText});
                    }
                }
            })();
            {/literal}
        </script>
        {/if}
    </td></tr>
