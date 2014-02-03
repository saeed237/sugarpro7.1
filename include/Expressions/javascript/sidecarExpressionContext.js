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
(function(){SUGAR.forms=SUGAR.forms||{};SUGAR.forms.animation=SUGAR.forms.animation||{};var SE=SUGAR.expressions,SEC=SE.SidecarExpressionContext=function(view){this.view=view;}
SUGAR.util.extend(SEC,SE.ExpressionContext,{getValue:function(varname)
{var value=this.view.context.get("model").get(varname),def=this.view.context.get("model").fields[varname],result;if(def.type=="link")
value=varname;if(typeof(value)=="string")
{value=value.replace(/\n/g,"");if((/^(\s*)$/).exec(value)!=null||value==="")
{result=SEC.parser.toConstant('""');}
else if(SE.isNumeric(value)){result=SEC.parser.toConstant(SE.unFormatNumber(value));}
else{result=SEC.parser.toConstant('"'+value+'"');}}else if(typeof(value)=="object"&&value!=null&&value.getTime){var d=new SE.DateExpression("");d.evaluate=function(){return this.value};d.value=value;result=d;}else if(typeof(value)=="number"){result=SEC.parser.toConstant(""+value);}else{result=SEC.parser.toConstant('""');}
return result;},setValue:function(varname,value)
{this.lockedFields=this.lockedFields||[];if(!this.lockedFields[varname])
{this.lockedFields[varname]=true;var el=this.getElement(varname);if(el){SUGAR.forms.FlashField($(el).parents('[data-fieldname="'+varname+'"]'),null,varname);}
var ret=this.view.context.get("model").set(varname,value);this.lockedFields=[];return ret;}},addListener:function(varname,callback,scope)
{var model=this.view.context.get("model");model.off("change:"+varname,callback,scope);model.on("change:"+varname,callback,scope);},getElement:function(varname){var field=this.view.getField(varname);if(field&&field.el)
return field.el;},addClass:function(varname,css_class,includeLabel){var def=this.view.getFieldMeta(varname),props=includeLabel?["css_class","cell_css"]:["css_class"],el=this.getElement(varname),parent=$(el).closest('div.record-cell');_.each(props,function(prop){if(!def[prop]){def[prop]=css_class;}else if(def[prop].indexOf(css_class)==-1){def[prop]+=" "+css_class;}});this.view.setFieldMeta(varname,def);$(el).addClass(css_class);if(includeLabel&&parent){parent.addClass(css_class);}},removeClass:function(varname,css_class,includeLabel){var def=this.view.getFieldMeta(varname),field=this.view.getField(varname),props=includeLabel?["css_class","cell_css"]:["css_class"],el=this.getElement(varname),parent=$(el).closest('div.record-cell');_.each([field.def,def],function(d){_.each(props,function(prop){if(d[prop]&&d[prop].indexOf(css_class)!=-1){d[prop]=$.trim((" "+d[prop]+" ").replace(new RegExp(' '+css_class+' '),""));}});});this.view.setFieldMeta(varname,def);$(el).removeClass(css_class);if(includeLabel&&parent){parent.removeClass(css_class);parent.find("."+css_class).removeClass(css_class);}},setFieldDisabled:function(variable,disable){var set=disable!==false,field=this.view.getField(variable);if(field){field.setDisabled(set);}},getLink:function(variable){var model=this.view.context.get("model");if(model&&model.fields&&model.fields[variable])
return model.fields[variable];},showError:function(variable,error)
{},clearError:function(variable)
{},setStyle:function(variable,styles)
{},setRelatedFields:function(fields){var model=this.view.context.get("model");for(var link in fields)
{var currValue=model.get(link),forceChangeEvent=!!currValue,value=currValue||{};_.each(fields[link],function(values,type){value[type]=_.extend(value[type]||{},values);});}
model.set(link,value);if(forceChangeEvent)
model.trigger("change:"+link);},getRelatedFieldValues:function(fields,module,record)
{var self=this,api=App.api;if(fields.length>0){module=module||this.view.context.get("module");record=record||this.view.context.get("model").get("id");for(var i=0;i<fields.length;i++)
{if(fields[i].type=="related")
{var linkDef=SUGAR.forms.AssignmentHandler.getLink(fields[i].link);if(linkDef&&linkDef.id_name&&linkDef.module){var idField=document.getElementById(linkDef.id_name);if(idField&&idField.tagName=="INPUT")
{fields[i].relId=SUGAR.forms.AssignmentHandler.getValue(linkDef.id_name,false,true);fields[i].relModule=linkDef.module;}}}}
var data={id:record,action:"related"},params={module:module,fields:JSON.stringify(fields)};api.call("read",api.buildURL("ExpressionEngine","related",data,params),data,params,{success:function(resp){self.setRelatedFields(resp);return resp;}});}
return null;},getRelatedField:function(link,ftype,field){var linkDef=_.extend({},this.getLink(link)),linkValues=this.view.model.get(link)||{},currId;if(!this.view.model.get("id")){return"";}
if(ftype=="related"){return this._handleRelateExpression(link,field);}
else{if(typeof(linkValues[ftype])=="undefined"||typeof(linkValues[ftype][field])=="undefined")
{var params={link:link,type:ftype};if(field)
params.relate=field;this.getRelatedFieldValues([params]);}else{return linkValues[ftype][field];}}
if(typeof(linkValues[ftype])=="undefined")
return"";return linkValues[ftype];},_handleRelateExpression:function(link,field){var relContext=this.view.context.getChildContext({link:link});relContext.prepare();var col=relContext.get("collection"),fields=relContext.get('fields')||[],self=this,rField=_.find(this.view.model.fields,function(def){return(def.type&&def.type=="relate"&&def.id_name&&def.link&&def.link==link)});if(rField&&(this.view.model.get(rField.id_name)==""||(relContext.get("model")&&relContext.get("model").get("id")!=this.view.model.get(rField.id_name)))){fields=[];relContext.set({fields:fields,model:null});if(this.view.model.get(rField.id_name)=="")
return"";}
if(field&&!_.contains(fields,field)){fields.push(field);this._loadRelatedData(link,fields,relContext,rField);}
else if(rField&&relContext.get("model")){return relContext.get("model").get(field);}
else if(context.isDataFetched()&&col.page>0){if(col.length>0){return col.models[0].get(field);}}else{SUGAR.App.utils.doWhen(function(){return col.page>0},function(){self.view.model.trigger("change:"+link);});}
return"";},_loadRelatedData:function(link,fields,relContext,rField){var self=this;if(rField&&this.view.model.get(rField.id_name)){var modelId=this.view.model.get(rField.id_name),model=relContext.get("model")||SUGAR.App.data.createRelatedBean(this.view.model,this.view.model.get(rField.id_name),link);relContext.set({modelId:modelId,model:model});}else{if(_.isEmpty(this.view.model.get("id")))
return"";}
relContext.prepare();relContext.set({'fields':fields,skipFetch:false});if(relContext.isDataFetched()){relContext.resetLoadFlag();}
if(rField)relContext.attributes.link=null;relContext.loadData({success:function(){self.view.model.trigger("change:"+link);}});if(rField)relContext.attributes.link=link;},fireOnLoad:function(dep){},getAppListStrings:function(list){return SUGAR.App.lang.getAppListStrings(list);},parseDate:function(date,type){return SUGAR.App.date.parse(date);}});SEC.parser=new SUGAR.expressions.ExpressionParser();SEC.evalVariableExpression=function(expression,view)
{return SEC.parser.evaluate(expression,new SEC(view));}
SUGAR.forms.Dependency=function(trigger,actions,falseActions,testOnLoad,context)
{this.actions=actions;this.falseActions=falseActions;this.context=context;this.testOnLoad=testOnLoad;trigger.setContext(this.context);trigger.setDependency(this);this.trigger=trigger;if(testOnLoad){context.fireOnLoad(this);}}
SUGAR.forms.Dependency.fromMeta=function(meta,context){var condition=meta.trigger||"true",triggerFields=meta.triggerFields||SEC.parser.getFieldsFromExpression(condition),actions=meta.actions||[],falseActions=meta.notActions||[],onLoad=meta.onload||false,actionObjects=[],falseActionObjects=[];if(_.isEmpty(triggerFields))
return null;if(_.isEmpty(actions)&&_.isEmpty(falseActions))
return null;_.each(actions,function(actionDef)
{if(!actionDef.action||!SUGAR.forms[actionDef.action+"Action"])
return;actionObjects.push(new SUGAR.forms[actionDef.action+"Action"](actionDef.params));});_.each(falseActions,function(actionDef)
{if(!actionDef.action||!SUGAR.forms[actionDef.action+"Action"])
return;falseActionObjects.push(new SUGAR.forms[actionDef.action+"Action"](actionDef.params));});return new SUGAR.forms.Dependency(new SUGAR.forms.Trigger(triggerFields,condition,context),actionObjects,falseActionObjects,onLoad,context);}
SUGAR.forms.Dependency.prototype.fire=function(undo)
{try{var model=this.context.view.context.get("model");this.lastTriggeredActions=this.lastTriggeredActions||[];if(model.inSync&&!this.testOnLoad){return;}
var actions=this.actions;if(undo&&this.falseActions!=null)
actions=this.falseActions;_.each(this.lastTriggeredActions,function(action){this.context.view.off(null,null,action);},this);if(actions instanceof SUGAR.forms.AbstractAction)
actions=[actions];for(var i in actions){var action=actions[i];if(typeof action.exec=="function"){action.setContext(this.context);action.exec();if(this.testOnLoad&&action.afterRender){this.context.view.on('render',action.exec,action);}}}
this.lastTriggeredActions=actions;}catch(e){if(!SUGAR.isIE&&console&&console.log){console.log('ERROR: '+e);}
return;}};SUGAR.forms.Dependency.prototype.getRelatedFields=function(){var parser=SEC.parser,fields=parser.getRelatedFieldsFromFormula(this.trigger.condition);var parse=function(actions){if(actions instanceof SUGAR.forms.AbstractAction){actions=[actions];}
for(var i in actions){var action=actions[i];if(typeof action.exec=="function"){for(var p in action){if(typeof action[p]=="string")
fields=$.merge(fields,parser.getRelatedFieldsFromFormula(action[p]));}}}}
parse(this.actions);parse(this.falseActions);return fields;}
SUGAR.forms.AbstractAction=function(target){this.target=target;};SUGAR.forms.AbstractAction.prototype.exec=function(){}
SUGAR.forms.AbstractAction.prototype.setContext=function(context){this.context=context;}
SUGAR.forms.AbstractAction.prototype.evalExpression=function(exp,context){context=context||this.context;return SEC.parser.evaluate(exp,context).evaluate();}
SUGAR.forms.Trigger=function(variables,condition,context){this.variables=variables;this.condition=condition;this.context=context;this.dependency={};this._attachListeners();}
SUGAR.forms.Trigger.prototype._attachListeners=function(){if(!(this.variables instanceof Array)){this.variables=[this.variables];}
for(var i=0;i<this.variables.length;i++){this.context.addListener(this.variables[i],SUGAR.forms.Trigger.fire,this,true);}}
SUGAR.forms.Trigger.prototype.setDependency=function(dep){this.dependency=dep;}
SUGAR.forms.Trigger.prototype.setContext=function(context){this.context=context;}
SUGAR.forms.Trigger.fire=function(){var eval,val;try{eval=SEC.parser.evaluate(this.condition,this.context);}catch(e){if(!SUGAR.isIE&&console&&console.log){console.log('ERROR:'+e+"; in Condition: "+this.condition);}}
if(typeof(eval)!='undefined')
val=eval.evaluate();if(val==SUGAR.expressions.Expression.TRUE){if(this.dependency instanceof SUGAR.forms.Dependency){this.dependency.fire(false);return;}}else if(val==SUGAR.expressions.Expression.FALSE){if(this.dependency instanceof SUGAR.forms.Dependency){this.dependency.fire(true);return;}}}
SUGAR.forms.flashInProgress={};SUGAR.forms.FlashField=function(field,to_color,key){if(typeof(field)=='undefined'||(!key&&!field.id))
return;key=key||field.id;if(SUGAR.forms.flashInProgress[key])
return;SUGAR.forms.flashInProgress[key]=true;to_color=to_color||'#FF8F8F';var original=field.style&&field.style.backgroundColor?field.style.backgroundColor:'#FFFFFF';$(field).animate({backgroundColor:to_color},200,function(){$(field).animate({backgroundColor:original},200,function(){delete SUGAR.forms.flashInProgress[key];});});};if(SUGAR.App&&SUGAR.App.plugins){SUGAR.App.plugins.register('SugarLogic','view',{onAttach:function(){this.on("init",function(){this.deps=[];var slContext=new SUGAR.expressions.SidecarExpressionContext(this),meta=_.extend({},this.meta,this.options.meta);_.each(meta.dependencies,function(dep){var newDep=SUGAR.forms.Dependency.fromMeta(dep,slContext);if(newDep){this.deps.push(newDep);if(this.context.isCreate()){SUGAR.forms.Trigger.fire.apply(newDep.trigger);}}},this);});}});}else if(console.error){console.error("unable to find the plugin manager");}})();