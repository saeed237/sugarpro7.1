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




SUGAR.dashlets = function() {
	return {
		/**
		 * Generic javascript method to use post a form 
		 * 
		 * @param object theForm pointer to the form object
		 * @param function callback function to call after for form is sent
		 *
		 * @return bool false
		 */ 
		postForm: function(theForm, callback) {	
			var success = function(data) {
				if(data) {
					callback(data.responseText);
				}
			}
			YAHOO.util.Connect.setForm(theForm); 
			var cObj = YAHOO.util.Connect.asyncRequest('POST', 'index.php', {success: success, failure: success});
			return false;
		},
		/**
		 * Generic javascript method to use Dashlet methods
		 * 
		 * @param string dashletId Id of the dashlet being call
		 * @param string methodName method to be called (function in the dashlet class)
		 * @param string postData data to send (eg foo=bar&foo2=bar2...)
		 * @param bool refreshAfter refreash the dashlet after sending data
		 * @param function callback function to be called after dashlet is refreshed (or not refresed) 
		 */ 
		callMethod: function(dashletId, methodName, postData, refreshAfter, callback) {
        	ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_SAVING'));
        	response = function(data) {
        		ajaxStatus.hideStatus();
				if(refreshAfter) SUGAR.mySugar.retrieveDashlet(dashletId);
				if(callback) {
					callback(data.responseText);
				}
        	}
	    	post = 'to_pdf=1&module=Home&action=CallMethodDashlet&method=' + methodName + '&id=' + dashletId + '&' + postData;
			var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php', 
							  {success: response, failure: response}, post);
		}
	 };
}();

if(SUGAR.util.isTouchScreen() && typeof iScroll == 'undefined') {

	with (document.getElementsByTagName("head")[0].appendChild(document.createElement("script")))
	{
		setAttribute("id", "newScript", 0);
		setAttribute("type", "text/javascript", 0);
		setAttribute("src", "include/javascript/iscroll.js", 0);
	}

}