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


function run_test(source_id) {
		var callback =	{
			success: function(data) {
				var resultDiv = document.getElementById(source_id + '_result');
				resultDiv.innerHTML = '<b>' + data.responseText + '</b>';
			},
			failure: function(data) {
				var resultDiv = document.getElementById(source_id + '_result');
                resultDiv.innerHTML =  '<b>' + SUGAR.language.get('app_strings', 'ERROR_UNABLE_TO_RETRIEVE_DATA') + '</b>';
			},
			timeout: 300000
		}
		
		var resultDiv = document.getElementById(source_id + '_result');
		resultDiv.innerHTML = '<img src=themes/default/images/sqsWait.gif>';
		document.ModifyProperties.source_id.value = source_id;
		document.ModifyProperties.action.value = 'RunTest';
		YAHOO.util.Connect.setForm(document.ModifyProperties);
		var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php?module=Connectors', callback);
		document.ModifyProperties.action.value = 'SaveModifyProperties';
}

var widgetTimout;
function dswidget_open(elt){
	
	var wdiget_div = document.getElementById('dswidget_div');
	var objX = findPosX(elt);
  	var objY = findPosY(elt);

	wdiget_div.style.top = (objY+15) + 'px';
    wdiget_div.style.left = (objX) + 'px';
	
	wdiget_div.style.display = 'block';
}

function dswidget_close(){
	
	widgetTimout = setTimeout("hide_widget()", 500);
}

function hide_widget(){
	var wdiget_div = document.getElementById('dswidget_div');
	wdiget_div.style.display = 'none';
}

function clearButtonTimeout(){
	if(widgetTimout){
		clearTimeout(widgetTimout);
	}
}

function findPosX(obj)
{
    var curleft = 0;
    if (obj.offsetParent)
    {
        while (obj.offsetParent)
        {
            curleft += obj.offsetLeft;
            obj = obj.offsetParent;
        }
        if ( obj != null )
            curleft += obj.offsetLeft;
    }
    else if (obj.x)
        curleft += obj.x;
    return curleft;
}

function findPosY(obj)
{
    var curtop = 0;
    if (obj.offsetParent)
    {
        while (obj.offsetParent)
        {
            curtop += obj.offsetTop;
            obj = obj.offsetParent;
        }
        if ( obj != null )
            curtop += obj.offsetTop;
    }
    else if (obj.y)
        curtop += obj.y;
    return curtop;
}