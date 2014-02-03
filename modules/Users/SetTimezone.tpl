<!--
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

/*********************************************************************************

 ********************************************************************************/
-->
<!-- BEGIN: main -->
<div class="dashletPanelMenu" style="width: 500px; margin: 20px auto;">
<div class="hd"><div class="tl"></div><div class="hd-center"></div><div class="tr"></div></div>
<div class="bd" style="padding-top: 0px; padding-bottom: 0;">
<div class="ml"></div>
<div class="bd-center">
<form name="EditView" method="POST" action="index.php?module=Users&action=SaveTimezone&SaveTimezone=True">
	<input type="hidden" value="{$USER_ID}" name="record">
	<input type="hidden" name="module" value="Users">
	<input type="hidden" name="action" value="SaveTimezone">
	<input type="hidden" name="SaveTimezone" value="true">

<table class="subMenuTD" style="padding: 8px; border: 2px solid #999; background-color: #fff;" cellpadding="0" cellspacing="2" border="0" align="center" width="440">
	<tr>
		<td colspan="2" width="100%"></td>
	</tr>
	<tr>
		<td colspan="2" width="100%" style="font-size: 12px; padding-bottom: 5px;">
			<table width="100%" border="0">
			<tr>
				<td colspan="2"><slot>{$MOD.LBL_PICK_TZ_DESCRIPTION}</slot></td>
			</tr>
			</table>
			<br><br>
			<slot><select tabindex='3' name='timezone'>{html_options options=$TIMEZONEOPTIONS selected=$TIMEZONE_CURRENT}</select></slot>
			<input	title="{$APP.LBL_SAVE_BUTTON_TITLE}"
					accessKey="{$APP.LBL_SAVE_BUTTON_KEY}"
					class="button primary"
					type="submit"
					name="button"
					value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " ><br />
			{* <span class="dateFormat">{$MOD.LBL_DST_INSTRUCTIONS}</span> *}
		</td>
	</tr>
</table>
</form>
</div>
<div class="mr"></div>
</div>
<div class="ft"><div class="bl"></div><div class="ft-center"></div><div class="br"></div></div>
</div>
{literal}
<script type="text/javascript" language="JavaScript">
<!--
lookupTimezone = function() {
    var success = function(data) {
        eval(data.responseText);
        if(typeof userTimezone != 'undefined') {
            document.EditView.timezone.value = userTimezone;
        }
    }

    var now = new Date();
    now = new Date(now.toString()); // reset milliseconds
    var nowGMTString = now.toGMTString();
    var nowGMT = new Date(nowGMTString.substring(0, nowGMTString.lastIndexOf(' ')));
    offset = ((now - nowGMT) / (1000 * 60));
    url = 'index.php?module=Users&action=SetTimezone&to_pdf=1&userOffset=' + offset;
    var cObj = YAHOO.util.Connect.asyncRequest('GET', url, {success: success, failure: success});
}
YAHOO.util.Event.addListener(window, 'load', lookupTimezone);
-->
</script>
{/literal}