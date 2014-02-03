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

<form id='StudioWizard' name='StudioWizard'>
<input type='hidden' name='module' value='ModuleBuilder'>
<input type='hidden' name='action' value='portalsyncsync'>
<table class='tabform' width='100%' cellpadding=4>
<tr>
<td colspan='2'>{$welcome}</td>
</tr>
<tr>
<td colspan='2' nowrap>
{$mod.LBL_PORTALSITE}
<input name='portalURL' id='portalURL' value='{$options}' size=60>
<input type='button' class='button' id='gobutton' value='{$mod.LBL_PORTAL_GO}'>
</td>
</tr>
<tr>
<td colspan='2'>
    {if strcmp($options, 'https://') != 0 || strcmp($options, 'http://') != 0 && $options != 'https://'}
		<iframe title='{$options}' style='border:0' id='portal_iframe' height='250' scrolling='auto'></iframe>
	{/if}
</td>
</tr>

</table>
</form>

{literal}
<script>
ModuleBuilder.helpSetup('portalSync','default');
</script>

<script language='javascript'>
function handleKeyDown(event) {
	e = getEvent(event);
	eL = getEventElement(e);
	if ((kc = e["keyCode"])) { 
        if(kc == 13) {
           retrieve_portal_page();
		   freezeEvent(e);
		}
	}
}//handleKeyDown()

function getEvent(event) {
	return (event ? event : window.event);
}//getEvent

function getEventElement(e) {
	return (e.srcElement ? e.srcElement: (e.target ? e.target : e.currentTarget));
}//getEventElement

function freezeEvent(e) {
	if (e.preventDefault) e.preventDefault();
	e.returnValue = false;
	e.cancelBubble = true;
	if (e.stopPropagation) e.stopPropagation();
	return false;
}//freezeEvent

function retrieve_portal_page() {
	ModuleBuilder.getContent("module=ModuleBuilder&action=portalsyncsync&portalURL=" + document.StudioWizard.portalURL.value)
}

function load_portal_url() {
    var url = document.getElementById('portalURL').value + '/portal_sync.php';
    if(/http(s)?:\/\/\/portal_sync.php/.test(url)) {
       return;
    }
    
	var iframe = document.getElementById('portal_iframe');
	try {
	  iframe.src=url;
	} catch(e) {

	}
}

document.getElementById('portalURL').onkeydown = handleKeyDown;
document.getElementById('gobutton').onclick = retrieve_portal_page;
load_portal_url();
</script>
{/literal}