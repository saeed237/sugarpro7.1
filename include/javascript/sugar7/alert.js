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
(function(app){app.events.on('app:sync',function(){app.alert.show('app:sync',{level:'process',title:app.lang.getAppString('LBL_LOADING')});});app.events.on('app:sync:complete',function(){app.alert.dismiss('app:sync');});app.events.on('app:sync:error',function(){app.alert.dismiss('app:sync');});var _contextProto=_.clone(app.Context.prototype);app.Context.prototype.loadData=function(options){if(!this.parent){options=options||{};options.showAlerts=true;}
_contextProto.loadData.call(this,options);};var numActiveProcessAlerts=0;app.events.on('data:sync:start',function(method,model,options){options=options||{};if(!options.showAlerts){return;}
if(options.showAlerts.process===false){return;}
var alertOpts={level:'process'};if(method==='read'){alertOpts.title=app.lang.getAppString('LBL_LOADING');}
else if(method==='delete'){alertOpts.title=options.relate?app.lang.getAppString('LBL_UNLINKING'):app.lang.getAppString('LBL_DELETING');}
else{alertOpts.title=app.lang.getAppString('LBL_SAVING');}
if(_.isObject(options.showAlerts.process)){_.extend(alertOpts,options.showAlerts.process);}
numActiveProcessAlerts++;app.alert.show('data:sync:process',alertOpts);});var syncCompleteHandler=function(type,messages,method,model,options){var alertOpts={level:type,messages:messages,autoClose:true};options=options||{};if(!options.showAlerts)return;if(options.showAlerts.process!==false){numActiveProcessAlerts--;if(numActiveProcessAlerts<1){numActiveProcessAlerts=0;app.alert.dismiss('data:sync:process');}}
if(method==='read')return;if(options.showAlerts[type]===false)return;if(_.isObject(options.showAlerts[type])){_.extend(alertOpts,options.showAlerts[type]);}
app.alert.show('data:sync:'+type,alertOpts);};app.events.on('data:sync:success',function(method,model,options){var messages;if(method==='delete'){messages=options.relate?'LBL_UNLINKED':'LBL_DELETED';}
else{messages='LBL_SAVED';}
syncCompleteHandler('success',messages,method,model,options);});app.events.on('data:sync:error',function(method,model,options,error){if(!error||error.status!=412){syncCompleteHandler('error','ERR_GENERIC_SERVER_ERROR',method,model,options);}else{app.alert.dismiss("data:sync:process");}});})(SUGAR.App);