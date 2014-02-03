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


function open_contact_popup(module_name, width, height, initial_filter, close_popup, hide_clear_button, popup_request_data, popup_mode, create, metadata)
{
	// set the variables that the popup will pull from
	window.document.popup_request_data = popup_request_data;
	window.document.close_popup = close_popup;

	// launch the popup
	URL = 'index.php?mode=MultiSelect&'
		+ 'module=' + module_name
		+ '&action=ContactAddressPopup';
	
	if(initial_filter != '')
	{
		URL += '&query=true' + initial_filter;
	}
	
	if(hide_clear_button)
	{
		URL += '&hide_clear_button=true';
	}
	
	windowName = 'popup_window';
	
	windowFeatures = 'width=' + width
		+ ',height=' + height
		+ ',resizable=1,scrollbars=1';

	if (popup_mode == '' && popup_mode == 'undefined') {
		popup_mode='single';		
	}
	URL+='&mode='+popup_mode;
	if (create == '' && create == 'undefined') {
		create = 'false';
	}
	URL+='&create='+create;

	if (metadata != '' && metadata != 'undefined') {
		URL+='&metadata='+metadata;	
	}

	win = window.open(URL, windowName, windowFeatures);

	if(window.focus)
	{
		// put the focus on the popup if the browser supports the focus() method
		win.focus();
	}

	return win;
}

function set_focus(){
	document.getElementById('name').focus();
}