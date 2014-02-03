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
<div id="dccontent" style="width:880px; height:400px; z-index:2;"></div>
<script type='text/javascript'>
{literal}
function closeEmailOverlay() {
	lastLoadedMenu=undefined; 

	if(typeof SUGAR.quickCompose.parentPanel != 'undefined' && SUGAR.quickCompose.parentPanel != null) {
       if(tinyMCE) {
    	  tinyMCE.execCommand('mceRemoveControl', false, 'htmleditor0'); 
       }
       SUGAR.quickCompose.parentPanel.hide();
       SUGAR.quickCompose.parentPanel = null;
	}
	
	DCMenu.closeOverlay();
}
{/literal}   
 
SUGAR.quickCompose.init({$json_output});

{literal}

YAHOO.util.Event.onAvailable('dcmenu_close_link', function() {
	document.getElementById('dcmenu_close_link').href = 'javascript:closeEmailOverlay();'; 
}, this);

//override the action here so we know to close the menu when email is sent
action_sugar_grp1 = 'quickcreate';

{/literal}
</script>