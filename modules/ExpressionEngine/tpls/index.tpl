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
<script src="include/javascript/sugarwidgets/SugarYUILoader.js"></script>
{literal}
<script type="text/javascript">
var loader = new YAHOO.util.YUILoader({
    require : ["sugarwidgets"],
    loadOptional: true,
    skin: { base: 'blank', defaultSkin: '' },
	onSuccess: function(){console.log("loaded")},
    allowRollup: true,
    base: "include/javascript/yui/build/"
});
loader.addModule({
    name :"sugarwidgets",
    type : "js",
    fullpath: "include/javascript/sugarwidgets/SugarYUIWidgets.js",
    varName: "YAHOO.SUGAR",
    requires: ["datatable", "dragdrop", "treeview", "tabview"]
});
loader.insert();
var DDEditorWindow = false;
showEditor = function() {
    if (!DDEditorWindow)
        DDEditorWindow = new YAHOO.SUGAR.AsyncPanel('DDEditorWindow', {
            width: 256,
            draggable: true,
            close: true,
            constraintoviewport: true,
            fixedcenter: false,
            script: true,
            modal: true
        });
    var win = DDEditorWindow;
    win.setHeader("Dropdown Editor");
    win.setBody("loading...");
    win.render(document.body);
    win.params = {
        module:"ExpressionEngine",
        action:"editDepDropdown",
        loadExt:false,
        embed: true,
        view_module:"Accounts",
        field: 'sub_industry_c',
        package:"",
        to_pdf:1
    };
    win.load('index.php?' + SUGAR.util.paramsToUrl(win.params), null, function()
    {
        DDEditorWindow.center();
        SUGAR.util.evalScript(DDEditorWindow.body.innerHTML);
    });
    win.show();
    win.center();
}
</script>
{/literal}
<input class="button" type="button" onclick="showEditor()" value="Show"/>
<div id="editorDiv"></div>