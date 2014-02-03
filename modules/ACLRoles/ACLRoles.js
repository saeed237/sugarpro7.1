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
var aclviewer=function(){var lastDisplay='';return{view:function(role_id,role_module){YAHOO.util.Connect.asyncRequest('POST','index.php',{'success':aclviewer.display,'failure':aclviewer.failed},'module=ACLRoles&action=EditRole&record='+role_id+'&category_name='+role_module);ajaxStatus.showStatus(SUGAR.language.get('app_strings','LBL_REQUEST_PROCESSED'));},save:function(form_name){var formObject=document.getElementById(form_name);YAHOO.util.Connect.setForm(formObject);YAHOO.util.Connect.asyncRequest('POST','index.php',{'success':aclviewer.postSave,'failure':aclviewer.failed});ajaxStatus.showStatus(SUGAR.language.get('app_strings','LBL_SAVING'));},postSave:function(o){eval(o.responseText);aclviewer.view(result['role_id'],result['module']);if(!_.isUndefined(window.parent.SUGAR)&&!_.isUndefined(window.parent.SUGAR.App.view)){window.parent.SUGAR.App.controller.layout.getComponent('bwc').revertBwcModel();}},display:function(o){aclviewer.lastDisplay='';ajaxStatus.flashStatus(SUGAR.language.get('ACLRoles','LBL_DONE'));document.getElementById('category_data').innerHTML=o.responseText;},failed:function(){ajax.flashStatus(SUGAR.language.get('ACLRoles','LBL_COULD_NOT_CONNECT'));},toggleDisplay:function(id){if(aclviewer.lastDisplay!=''&&typeof(aclviewer.lastDisplay)!='undefined'){aclviewer.hideDisplay(aclviewer.lastDisplay);}
if(aclviewer.lastDisplay!=id){aclviewer.showDisplay(id);aclviewer.lastDisplay=id;}else{aclviewer.lastDisplay='';}},hideDisplay:function(id){document.getElementById(id).style.display='none';document.getElementById(id+'link').style.display='';},showDisplay:function(id){document.getElementById(id).style.display='';document.getElementById(id+'link').style.display='none';}};}();