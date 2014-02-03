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
</form>

{{if $externalJSFile}}
	require_once("'".$externalJSFile."'");
{{/if}}

{$set_focus_block}

{{if isset($scriptBlocks)}}
	<!-- Begin Meta-Data Javascript -->
	{{$scriptBlocks}}
	<!-- End Meta-Data Javascript -->
{{/if}}

<div class="h3Row" id="scheduler"></div>

<div>
<h3>{$MOD.LBL_RECURRENCE}</h3>
{include file='modules/Calendar/tpls/repeat.tpl'}
{sugar_getscript file='modules/Meetings/recurrence.js'}
<script type="text/javascript">
{literal}
SUGAR.util.doWhen(function() {
    return typeof CAL != "undefined";
}, function () {
    CAL.fillRepeatForm({/literal}{$repeatData}{literal});
});
{/literal}
</script>
</div>
  
<script type="text/javascript">
{literal}
SUGAR.meetings = {};
var meetingsLoader = new YAHOO.util.YUILoader({
    require : ["sugar_grp_jsolait"],
    // Bug #48940 Skin always must be blank
    skin: {
        base: 'blank',
        defaultSkin: ''
    },
    onSuccess: function(){
		SUGAR.meetings.fill_invitees = function() {
			if (typeof(GLOBAL_REGISTRY) != 'undefined')  {
				SugarWidgetScheduler.fill_invitees(document.EditView);
			}
		}
		var root_div = document.getElementById('scheduler');
		var sugarContainer_instance = new SugarContainer(document.getElementById('scheduler'));
		sugarContainer_instance.start(SugarWidgetScheduler);
		if ( document.getElementById('save_and_continue') ) {
			var oldclick = document.getElementById('save_and_continue').attributes['onclick'].nodeValue;
			document.getElementById('save_and_continue').onclick = function(){
				SUGAR.meetings.fill_invitees();
				eval(oldclick);
			}
		}
	}
});
meetingsLoader.addModule({
    name :"sugar_grp_jsolait",
    type : "js",
    fullpath: "cache/include/javascript/sugar_grp_jsolait.js",
    varName: "global_rpcClient",
    requires: []
});
meetingsLoader.insert();
YAHOO.util.Event.onContentReady("{/literal}{{$form_name}}{literal}",function() {
    var durationHours = document.getElementById('duration_hours');
    if (durationHours) {
        document.getElementById('duration_minutes').tabIndex = durationHours.tabIndex;
    }

    var reminderChecked = document.getElementsByName('reminder_checked');
    for(i=0;i<reminderChecked.length;i++) {
        if (reminderChecked[i].type == 'checkbox' && document.getElementById('reminder_list')) {
            YAHOO.util.Dom.getFirstChild('reminder_list').tabIndex = reminderChecked[i].tabIndex;
        }
    }
});
{/literal}
</script>
</form>
<div class="buttons">
{{if !empty($form) && !empty($form.buttons_footer)}}
   {{foreach from=$form.buttons_footer key=val item=button}}
      {{sugar_button module="$module" id="$button" location="FOOTER" view="$view"}}
   {{/foreach}}
{{else}}
	{{sugar_button module="$module" id="SAVE" view="$view"}}
	{{sugar_button module="$module" id="CANCEL" view="$view"}}
{{/if}}

{{sugar_button module="$module" id="Audit" view="$view"}}
</div> 
