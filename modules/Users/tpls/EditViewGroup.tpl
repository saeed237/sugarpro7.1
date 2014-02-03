{{*
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

*}}
Hello Group!
{{include file="include/EditView/EditView.tpl"}}
Goodbye Group!
{{*
{{include file=$headerTpl}}
{sugar_include include=$includes}
<div id="{{$form_name}}_tabs"
{{if $useTabs}}
class="yui-navset"
{{/if}}
>

<div id="Default_{$module}_Subpanel">

Hello Group!

</div></div>
{{include file=$footerTpl}}
{{if $useTabs}}
{sugar_getscript file="cache/include/javascript/sugar_grp_yui_widgets.js"}
<script type="text/javascript">
var {{$form_name}}_tabs = new YAHOO.widget.TabView("{{$form_name}}_tabs");
{{$form_name}}_tabs.selectTab(0);
</script>
{{/if}}
<script type="text/javascript">
YAHOO.util.Event.onContentReady("{{$form_name}}",
    function () {ldelim} initEditView(document.forms.{{$form_name}}) {rdelim});
//window.setTimeout(, 100);
window.onbeforeunload = function () {ldelim} return onUnloadEditView(); {rdelim};
</script>
*}}
