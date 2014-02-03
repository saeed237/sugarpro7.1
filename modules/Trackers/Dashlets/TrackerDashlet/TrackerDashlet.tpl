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
<div class='ytheme-gray' id="datepicker" style="z-index: 9999; position:absolute; width:50px;"></div>
<div id='trackercontent_div_{$id}'></div>
{literal}
<script type="text/javascript">
var tracker_dashlet;

function onLoadDoInit() {
{/literal}
tracker_dashlet = new TrackerDashlet();
tracker_dashlet.init('{$id}', {$height});
tracker_dashlet.comboChanged();
{literal}
}

YAHOO.util.Event.onDOMReady(function(){            
var reportLoader = new YAHOO.util.YUILoader({
	require : ["layout","element"],
	loadOptional: true,
    // Bug #48940 Skin always must be blank
    skin: {
        base: 'blank',
        defaultSkin: ''
    },
	onSuccess : onLoadDoInit,
	base : "include/javascript/yui/build/"
});
reportLoader.addModule({
    name: "sugarwidgets",
    type: "js",
    fullpath: "include/javascript/sugarwidgets/SugarYUIWidgets.js",
    varName: "YAHOO.SUGAR",
    requires: ["datatable", "dragdrop", "treeview", "tabview", "button", "autocomplete", "container"]
});
reportLoader.insert();
});
</script>
{/literal}
