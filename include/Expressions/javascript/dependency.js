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
(function(){if(typeof(SUGAR.forms)=='undefined')SUGAR.forms={};if(typeof(SUGAR.forms.animation)=='undefined')SUGAR.forms.animation={};var Dom=YAHOO.util.Dom;var AH=SUGAR.forms.AssignmentHandler=function(){}
AH.ANIMATE=true;AH.COLLECTIONS_MAP={};AH.AFTER_LOAD_COMPLETE=new YAHOO.util.CustomEvent("AFTER_LOAD_COMPLETE");AH.VARIABLE_MAP={};AH.LISTENERS={};AH.LINKS={};AH.LOCKS={};AH.QUEUEDDEPS=[];AH.register=function(variable,view){if(!view)view=AH.lastView;if(typeof(AH.VARIABLE_MAP[view])=="undefined")
AH.VARIABLE_MAP[view]={};if(variable instanceof Array){for(var i=0;i<variable.length;i++){AH.VARIABLE_MAP[view][variable[i]]=document.getElementById(variable[i]);}}else{AH.VARIABLE_MAP[view][variable]=document.getElementById(variable);}}
AH.registerFields=function(flds){if(typeof(flds)!='object')return;var form=document.forms[flds.form];var names=flds.fields;if(typeof(AH.VARIABLE_MAP[flds.form])=="undefined")
AH.VARIABLE_MAP[flds.form]={};if(typeof(form)=='undefined')return;for(var i=0;i<names.length;i++){var el=form[names[i]];if(el!=null){AH.VARIABLE_MAP[flds.form][el.id]=el;AH.updateListeners(el.id,flds.form,el);}}}
AH.registerForm=function(f,formEl){var form=formEl||document.forms[f];if(typeof(AH.VARIABLE_MAP[f])=="undefined")
AH.VARIABLE_MAP[f]={};AH.COLLECTIONS_MAP[f]={};if(typeof(form)=='undefined')return;for(var i=0;i<form.length;i++){var el=form[i];if(el!=null&&el.value!=null&&el.id!=null&&el.id!="")
{if(el.type&&el.type=="text"&&Dom.getAncestorByClassName(el,"emailaddresses"))
{var span=Dom.getAncestorByTagName(el,"span");sId=span.id;fieldName=sId.substring(0,sId.length-5);if(!AH.VARIABLE_MAP[f][fieldName]||!Dom.isAncestor(span,AH.VARIABLE_MAP[f][fieldName])){AH.VARIABLE_MAP[f][fieldName]=el;AH.updateListeners(fieldName,f,el);}}else if(el.type&&el.type=="radio"){if(!AH.COLLECTIONS_MAP[f][el.name]){AH.COLLECTIONS_MAP[f][el.name]=[];}
AH.COLLECTIONS_MAP[f][el.name].push(el);}
AH.VARIABLE_MAP[f][el.id]=el;AH.updateListeners(el.id,f,el);}
else if(el!=null&&el.value&&el.type=="hidden"){AH.VARIABLE_MAP[f][el.name]=el;AH.updateListeners(el.name,f,el);}}}
AH.registerView=function(view,startEl){var Dom=YAHOO.util.Dom;AH.lastView=view;if(typeof(AH.VARIABLE_MAP[view])=="undefined")
AH.VARIABLE_MAP[view]={};if(Dom.get(view)!=null&&Dom.get(view).tagName=="FORM"){return AH.registerForm(view);}
var form=Dom.get("form");if(form&&form.name==view)
{AH.registerForm(view,form);}
var nodes=YAHOO.util.Selector.query("span.sugar_field",startEl);for(var i in nodes){if(nodes[i].id!="")
AH.VARIABLE_MAP[view][nodes[i].id]=nodes[i];AH.updateListeners(nodes[i].id,view,nodes[i]);}}
AH.registerField=function(formname,field){AH.registerFields({form:formname,fields:new Array(field)});}
AH.getValue=function(variable,view,ignoreLinks){if(!view)view=AH.lastView;if(AH.LINKS[view][variable]&&!ignoreLinks)
return variable;var field=AH.getElement(variable,view);if(field==null||field.tagName==null)return null;if(field.children.length==1&&field.children[0].tagName.toLowerCase()=="input")
field=field.children[0];if(field.tagName.toLowerCase()=="select"){if(field.selectedIndex==-1){return null;}else{return field.options[field.selectedIndex].value;}}
if(field.tagName.toLowerCase()=="input"&&field.type.toLowerCase()=="checkbox"){return field.checked?SUGAR.expressions.Expression.TRUE:SUGAR.expressions.Expression.FALSE;}
if(field.tagName.toLowerCase()=='input'&&field.type.toLowerCase()=='radio'){var form=field.form;var radioButtons=form[field.name];for(var rbi=0;rbi<radioButtons.length;rbi++){var button=radioButtons[rbi];if(button.checked){return button.value;}}}
if(field.className&&(field.className=="DateTimeCombo"||field.className=="Date")){return SUGAR.util.DateUtils.parse(field.value,"user");}
if(field.tagName.toLowerCase()=="span")
{if(field.hasAttribute("data-id-value"))
{return field.getAttribute("data-id-value");}
return document.all?trim(field.innerText):trim(field.textContent);}
if(field.value!==null&&typeof(field.value)!="undefined")
{var asNum=SUGAR.expressions.unFormatNumber(field.value);if((/^(\-)?[0-9]+(\.[0-9]+)?$/).exec(asNum)!=null){return parseFloat(asNum);}
return field.value;}
return YAHOO.lang.trim(field.innerText);}
AH.getLink=function(variable,view){if(!view)view=AH.lastView;if(AH.LINKS[view][variable])
return AH.LINKS[view][variable];}
AH.cacheRelatedField=function(link,ftype,value,view)
{if(!view)view=AH.lastView;if(!AH.LINKS[view][link])
return false;if(typeof(AH.LINKS[view][link][ftype])=="object"&&typeof(value=="object"))
{for(var i in value)
{AH.LINKS[view][link][ftype][i]=value[i];}}
else
AH.LINKS[view][link][ftype]=value;return true;}
AH.getCachedRelatedField=function(link,ftype,view)
{if(!view)view=AH.lastView;if(!AH.LINKS[view][link]||AH.LINKS[view][link][ftype])
return null;return AH.LINKS[view][link][ftype];}
AH.getCollection=function(variable,view){if(!view)view=AH.lastView;var field=AH.COLLECTIONS_MAP[view][variable];return field;}
AH.getElement=function(variable,view){if(!view)view=AH.lastView;var field=AH.VARIABLE_MAP[view][variable];if(field==null)
field=YAHOO.util.Dom.get(variable);return field;}
AH.assign=function(variable,value,flash)
{var Dom=YAHOO.util.Dom;if(typeof flash=="undefined")
flash=true;var field=AH.getElement(variable);if(field==null)
return null;if(AH.LOCKS[variable]!=null){throw("Circular Reference Detected");}
if(Dom.hasClass(field,"imageUploader"))
{var img=Dom.get("img_"+field.id);img.src=value;img.style.visibility="";}
else if(field.type=="checkbox"){field.checked=value==SUGAR.expressions.Expression.TRUE||value===true;}
else if(field.type=="radio"){var radioButtons=field.form[field.id];for(var rbi=0;rbi<radiobuttons.length;rbi++){var button=radioButtons[rbi];if(button.value==value){button.checked=true;}else{button.checked=false;}}}
else if(value instanceof Date)
{if(Dom.hasClass(field,"date_input"))
field.value=SUGAR.util.DateUtils.formatDate(value);else{if(Dom.hasClass(field,"DateTimeCombo"))
AH.setDateTimeField(field,value);field.value=SUGAR.util.DateUtils.formatDate(value,true);}}
else{var fieldForm=field.form.attributes.name.value;var fieldType='text';if(typeof(validate[fieldForm])=="object"){for(var idx in validate[fieldForm]){if(validate[fieldForm][idx][0]==field.name){fieldType=validate[fieldForm][idx][1];break;}}}
if(fieldType=='decimal'||fieldType=='currency'||fieldType=='int'){var localPrecision=2;if(fieldType=='int'){localPrecision=0;}else{if(typeof(precision)!='undefined'){localPrecision=precision;}}
if(value!=''){value=formatNumber(value,num_grp_sep,dec_sep,localPrecision,localPrecision);}}
field.value=value;}
if(AH.ANIMATE&&flash){try{SUGAR.forms.FlashField(field);}catch(e){}}
AH.LOCKS[variable]=true;SUGAR.util.callOnChangeListers(field);AH.LOCKS[variable]=null;}
var attachListener=function(el,callback,scope,view)
{scope=scope||this;if(el.type&&el.type.toUpperCase()=="CHECKBOX")
{return YAHOO.util.Event.addListener(el,"click",callback,scope,true);}
else if(el.type&&el.type.toUpperCase()=="RADIO"){var radioButtons=el.form[el.id];for(var radioButtonIndex=0;radioButtonIndex<radioButtons.length;radioButtonIndex++){var button=radioButtons[radioButtonIndex];YAHOO.util.Event.addListener(button,"click",callback,scope,true);}}
else{return YAHOO.util.Event.addListener(el,"change",callback,scope,true);}}
AH.addListener=function(varname,callback,scope,view)
{if(!view)view=AH.lastView;if(!AH.LISTENERS[view])AH.LISTENERS[view]={};if(!AH.LISTENERS[view][varname])AH.LISTENERS[view][varname]=[];var el=AH.getElement(varname,view);AH.LISTENERS[view][varname].push({el:el,callback:callback,scope:scope});if(!el)return false;attachListener(el,callback,scope,view);}
AH.updateListeners=function(varname,view,el)
{if(!view)view=AH.lastView;if(!AH.LISTENERS[view]||!AH.LISTENERS[view][varname]){return;}
var l=AH.LISTENERS[view][varname],el=el||AH.getElement(varname,view);for(var i=0;i<l.length;i++)
{var oldEl=l[i].el;if(oldEl!=el)
{if(oldEl.type&&oldEl.type.toUpperCase()=="CHECKBOX")
{YAHOO.util.Event.removeListener(oldEl,"click",l[i].callback);}
else{YAHOO.util.Event.removeListener(oldEl,"change",l[i].callback);}
attachListener(el,l[i].callback,l[i].scope,view);AH.LISTENERS[view][varname][i]={el:el,callback:l[i].callback,scope:l[i].scope};}}}
AH.setDateTimeField=function(field,value)
{var Dom=YAHOO.util.Dom,SDU=SUGAR.util.DateUtils,id=field.id,date=Dom.get(id+"_date"),hours=Dom.get(id+"_hours"),min=Dom.get(id+"_minutes"),mer=Dom.get(id+"_meridiem");value=SDU.roundTime(value);date.value=SDU.formatDate(value);if(mer){var h=SDU.formatDate(value,true,"h");var m=SDU.formatDate(value,true,"i");var a=SUGAR.expressions.userPrefs.timef.indexOf("A")!=-1?SDU.formatDate(value,true,"A"):SDU.formatDate(value,true,"a");AH.setSelectedOption(hours,h);AH.setSelectedOption(min,m);AH.setSelectedOption(mer,a);}else{var h=SDU.formatDate(value,true,"H");var m=SDU.formatDate(value,true,"i");AH.setSelectedOption(hours,h);AH.setSelectedOption(min,m);}}
AH.setSelectedOption=function(field,value)
{for(var i=0;i<field.options.length;i++)
{if(field.options[i].value==value)
{field.options[i].selected=true;break;}}
return;}
AH.showError=function(variable,error)
{var field=AH.getElement(variable);if(field==null)
return null;add_error_style(field.form.name,field,error,false);}
AH.clearError=function(variable)
{var field=AH.getElement(variable);if(field==null)
return;for(var i in inputsWithErrors)
{if(inputsWithErrors[i]==field)
{if(field.parentNode.className.indexOf('x-form-field-wrap')!=-1)
{field.parentNode.parentNode.removeChild(field.parentNode.parentNode.lastChild);}
else
{field.parentNode.removeChild(field.parentNode.lastChild);}
delete inputsWithErrors[i];return;}}}
AH.fireOnLoad=function(dep)
{AH.QUEUEDDEPS.push(dep);}
AH.loadComplete=function()
{var fields=[];for(var i=0;i<AH.QUEUEDDEPS.length;i++)
{fields=$.merge(fields,AH.QUEUEDDEPS[i].getRelatedFields());}
AH.getRelatedFieldValues(fields);for(var i=0;i<AH.QUEUEDDEPS.length;i++)
{SUGAR.forms.Trigger.fire.call(AH.QUEUEDDEPS[i].trigger);}
AH.AFTER_LOAD_COMPLETE.fire();}
AH.setRelatedFields=function(fields){for(var link in fields)
{for(var type in fields[link])
{AH.cacheRelatedField(link,type,fields[link][type]);}}}
AH.getRelatedFieldValues=function(fields,module,record)
{if(fields.length>0){module=module||SUGAR.forms.AssignmentHandler.getValue("module")||DCMenu.module;record=record||SUGAR.forms.AssignmentHandler.getValue("record")||DCMenu.record;for(var i=0;i<fields.length;i++)
{if(fields[i].type=="related")
{var linkDef=SUGAR.forms.AssignmentHandler.getLink(fields[i].link);if(linkDef&&linkDef.id_name&&linkDef.module){var idField=document.getElementById(linkDef.id_name);if(idField&&(idField.tagName=="INPUT"||idField.hasAttribute("data-id-value")))
{fields[i].relId=SUGAR.forms.AssignmentHandler.getValue(linkDef.id_name,false,true);fields[i].relModule=linkDef.module;}}}}
var r=http_fetch_sync("index.php",SUGAR.util.paramsToUrl({module:"ExpressionEngine",action:"getRelatedValues",record_id:record,tmodule:module,fields:YAHOO.lang.JSON.stringify(fields),to_pdf:1}));try{var ret=YAHOO.lang.JSON.parse(r.responseText);AH.setRelatedFields(ret);return ret;}catch(e){}}
return null;}
AH.getRelatedField=function(link,ftype,field,view){if(!view)
view=AH.lastView;else
AH.lastView=view;if(!AH.LINKS[view][link])
return null;var linkDef=SUGAR.forms.AssignmentHandler.getLink(link);var currId;if(linkDef.id_name)
{currId=SUGAR.forms.AssignmentHandler.getValue(linkDef.id_name,false,true);}
if(typeof(linkDef[ftype])=="undefined"||(field&&typeof(linkDef[ftype][field])=="undefined")||(ftype=="related"&&(linkDef.relId||!_.isUndefined(currId))&&linkDef.relId!=currId)){var params={link:link,type:ftype};if(field)
params.relate=field;AH.getRelatedFieldValues([params]);linkDef=SUGAR.forms.AssignmentHandler.getLink(link);}
if(typeof(linkDef[ftype])=="undefined")
return null;if(field){if(typeof(linkDef[ftype][field])=="undefined")
return null;else
return linkDef[ftype][field];}
return linkDef[ftype];}
AH.clearRelatedFieldCache=function(link,view){if(!view)view=AH.lastView;if(!AH.LINKS[view][link])
return false;delete(AH.LINKS[view][link]["relId"]);delete(AH.LINKS[view][link]["related"]);return true;}
AH.setStyle=function(variable,styles)
{var field=AH.getElement(variable);if(field==null)return null;for(var property in styles){YAHOO.util.Dom.setStyle(field,property+"",styles[property]);}}
AH.reset=function(){AH.VARIABLE_MAP={};AH.LISTENERS={};AH.LINKS={};AH.LOCKS={};}
SUGAR.forms.FormExpressionContext=function(formName)
{this.formName=formName;if(typeof(AH.VARIABLE_MAP[formName])=="undefined")
AH.registerView(formName);}
SUGAR.util.extend(SUGAR.forms.FormExpressionContext,SUGAR.expressions.ExpressionContext,{getValue:function(varname)
{var SE=SUGAR.expressions,toConst=SE.ExpressionParser.prototype.toConstant;var value="";if(AH.LINKS[this.formName][varname])
value=varname;else
value=AH.getValue(varname,this.formName);if(typeof(value)=='number')
{return toConst(value);}
else if(typeof(value)=="string")
{value=value.replace(/\n/g,"");if((/^(\s*)$/).exec(value)!=null||value==="")
{return toConst('""')}
else if(SE.isNumeric(value)){return toConst(SE.unFormatNumber(value));}
else{return toConst('"'+value+'"');}}else if(typeof(value)=="object"&&value!=null&&value.getTime){var d=new SUGAR.DateExpression("");d.evaluate=function(){return this.value};d.value=value;return d;}
return toConst('""');},setValue:function(varname,value)
{AH.assign(varname,value,true);},getLink:function(varname)
{if(AH.LINKS[this.formName][varname])
return AH.LINKS[this.formName][varname];return false;},addListener:function(varname,callback,scope)
{AH.addListener(varname,callback,scope,this.formName);},getRelatedField:function(link,ftype,field){if(ftype=='related')
{var module=AH.getValue("module");var record=AH.getValue("record");var linkDef=AH.getLink(link);var linkId=false,url="index.php?";if(linkDef&&linkDef.id_name&&linkDef.module){var idField=document.getElementById(linkDef.id_name);if(idField&&idField.tagName=="INPUT")
{linkId=AH.getValue(linkDef.id_name,false,true);module=linkDef.module;}
if(linkDef.relId&&linkDef.relId!=linkId)
AH.clearRelatedFieldCache(link);}}
return AH.getRelatedField(link,ftype,field);},getAppListStrings:function(list){return SUGAR.language.get('app_list_strings',list);},parseDate:function(date,type){return SUGAR.util.DateUtils.parse(date,type);},getElement:function(variable){return AH.getElement(variable,this.formName);}});SUGAR.forms.DefaultExpressionParser=new SUGAR.expressions.ExpressionParser();SUGAR.forms.evalVariableExpression=function(expression,varmap,view)
{return SUGAR.forms.DefaultExpressionParser.evaluate(expression,new SUGAR.forms.FormExpressionContext(view));if(!view)view=AH.lastView;var SE=SUGAR.expressions;expression=SUGAR.forms._performRangeReplace(expression);var handler=AH;if(typeof(varmap)=='undefined')
{varmap=new Array();for(v in AH.VARIABLE_MAP[view]){if(v!=""){varmap[varmap.length]=v;}}}
if(expression==SE.Expression.TRUE||expression==SE.Expression.FALSE)
var vars=SUGAR.forms.getFieldsFromExpression(expression);for(var i in vars)
{var v=vars[i];var value=AH.getValue(v);if(value==null){continue;}
var regex=new RegExp("\\$"+v,"g");if(value===null)
{value="";}
if(typeof(value)=="string")
{value=value.replace(/\n/g,"");if((/^(\s*)$/).exec(value)!=null||value==="")
{expression=expression.replace(regex,'""');}
else if(SE.isNumeric(value)){expression=expression.replace(regex,SE.unFormatNumber(value));}
else{expression=expression.replace(regex,'"'+value+'"');}}else if(typeof(value)=="object"&&value.getTime){value="date("+value.getTime()+")";expression=expression.replace(regex,value);}}
return SUGAR.forms.DefaultExpressionParser.evaluate(expression);}
SUGAR.forms._performRangeReplace=function(expression)
{this.generateRange=function(prefix,start,end){var str="";var i=parseInt(start);if(typeof(end)=='undefined')
while(AH.getElement(prefix+''+i)!=null)
str+='$'+prefix+''+(i++)+',';else
for(;i<=end;i++){var t=prefix+''+i;if(AH.getElement(t)!=null)
str+='$'+t+',';}
return str.substring(0,str.length-1);}
this.valueReplace=function(val){if(!(/^\$.*$/).test(val))return val;return AH.getValue(val.substring(1));}
var isInQuotes=false;var prev;var inRange;for(var i=0;;i++){if(i==expression.length)break;var ch=expression.charAt(i);if(ch=='"'&&prev!='\\')isInQuotes=!isInQuotes;if(!isInQuotes&&ch=='%'){inRange=true;var loc_start=expression.indexOf('[',i+1);var loc_comma=expression.indexOf(',',loc_start);var loc_end=expression.indexOf(']',loc_start);if(loc_start<0||loc_end<0)throw("Invalid range syntax");var prefix=expression.substring(i+1,loc_start);var start,end;if(loc_comma>-1&&loc_comma<loc_end){start=expression.substring(loc_start+1,loc_comma);end=expression.substring(loc_comma+1,loc_end);}else{start=expression.substring(loc_start+1,loc_end);}
if(loc_comma>-1&&loc_comma<loc_end)end=expression.substring(loc_comma+1,loc_end);var result=this.generateRange(prefix,this.valueReplace(start),this.valueReplace(end));if(typeof(end)=='undefined')
expression=expression.replace('%'+prefix+'['+start+']',result);else
expression=expression.replace('%'+prefix+'['+start+','+end+']',result);i=i+result.length-1;}
prev=ch;}
return expression;}
SUGAR.forms.getFieldsFromExpression=function(expression)
{var re=/[^$]*?\$(\w+)[^$]*?/g,matches=[],result;while(result=re.exec(expression))
{matches.push(result[result.length-1]);}
return matches;}
SUGAR.forms.Dependency=function(trigger,actions,falseActions,testOnLoad,form)
{if(typeof(form)!="string")
if(AH.lastView)
form=AH.lastView;else
form="EditView";this.actions=actions;this.falseActions=falseActions;this.context=new SUGAR.forms.FormExpressionContext(form);trigger.setContext(this.context);trigger.setDependency(this);SUGAR.lastDep=this;this.trigger=trigger;if(testOnLoad){AH.fireOnLoad(this);}}
SUGAR.forms.Dependency.prototype.fire=function(undo)
{try{var actions=this.actions;if(undo&&this.falseActions!=null)
actions=this.falseActions;if(actions instanceof SUGAR.forms.AbstractAction){actions.setContext(this.context);actions.exec();}else{for(var i in actions){var action=actions[i];if(typeof action.exec=="function"){action.setContext(this.context);action.exec();}}}}catch(e){if(!SUGAR.isIE&&console&&console.log){console.log('ERROR: '+e);}
return;}};SUGAR.forms.Dependency.prototype.getRelatedFields=function(){var parser=SUGAR.forms.DefaultExpressionParser,fields=parser.getRelatedFieldsFromFormula(this.trigger.condition);var parse=function(actions){if(actions instanceof SUGAR.forms.AbstractAction){actions=[actions];}
for(var i in actions){var action=actions[i];if(typeof action.exec=="function"){for(var p in action){if(typeof action[p]=="string")
fields=$.merge(fields,parser.getRelatedFieldsFromFormula(action[p]));}}}}
parse(this.actions);parse(this.falseActions);return fields;}
SUGAR.forms.AbstractAction=function(target){this.target=target;};SUGAR.forms.AbstractAction.prototype.exec=function(){}
SUGAR.forms.AbstractAction.prototype.setContext=function(context){this.context=context;}
SUGAR.forms.AbstractAction.prototype.evalExpression=function(exp,context){return SUGAR.forms.DefaultExpressionParser.evaluate(exp,context).evaluate();}
SUGAR.forms.Trigger=function(variables,condition){this.variables=variables;this.condition=condition;this.dependency={};this._attachListeners();}
SUGAR.forms.Trigger.prototype._attachListeners=function(){var handler=AH;if(!(this.variables instanceof Array)){this.variables=[this.variables];}
for(var i=0;i<this.variables.length;i++){var el=handler.getCollection(this.variables[i]);if(!el){var el=handler.getElement(this.variables[i]);}
if(!el)continue;if(el.type&&el.type.toUpperCase()=="CHECKBOX"){YAHOO.util.Event.addListener(el,"click",SUGAR.forms.Trigger.fire,this,true);}else{YAHOO.util.Event.addListener(el,"change",SUGAR.forms.Trigger.fire,this,true);}}}
SUGAR.forms.Trigger.prototype.setDependency=function(dep){this.dependency=dep;}
SUGAR.forms.Trigger.prototype.setContext=function(context){this.context=context;}
SUGAR.forms.Trigger.fire=function(){var eval;var val;try{eval=SUGAR.forms.DefaultExpressionParser.evaluate(this.condition,this.context);}catch(e){if(!SUGAR.isIE&&console&&console.log){console.log('ERROR:'+e+"; in Condition: "+this.condition);}}
if(typeof(eval)!='undefined')
val=eval.evaluate();if(val==SUGAR.expressions.Expression.TRUE){if(this.dependency instanceof SUGAR.forms.Dependency){this.dependency.fire(false);return;}}else if(val==SUGAR.expressions.Expression.FALSE){if(this.dependency instanceof SUGAR.forms.Dependency){this.dependency.fire(true);return;}}}
SUGAR.forms.flashInProgress={};SUGAR.forms.FlashField=function(field,to_color){if(typeof(field)=='undefined')return;if(SUGAR.forms.flashInProgress[field.id])
return;SUGAR.forms.flashInProgress[field.id]=true;var original=field.style.backgroundColor;if(typeof(original)=='undefined'||original==''){original='#FFFFFF';}
if(typeof(to_color)=='undefined')
var to_color='#FF8F8F';var oButtonAnim=new YAHOO.util.ColorAnim(field,{backgroundColor:{to:to_color}},0.2);oButtonAnim.onComplete.subscribe(function(){if(this.attributes.backgroundColor.to==to_color){this.attributes.backgroundColor.to=original;this.animate();}else{field.style.backgroundColor=original;SUGAR.forms.flashInProgress[field.id]=false;}});var tabsId=field.form.getAttribute("name")+"_tabs";if(typeof(window[tabsId])!="undefined"){var tabView=window[tabsId];var parentDiv=YAHOO.util.Dom.getAncestorByTagName(field,"div");if(tabView.get){var tabs=tabView.get("tabs");for(var i in tabs){if(i!=tabView.get("activeIndex")&&(tabs[i].get("contentEl")==parentDiv||YAHOO.util.Dom.isAncestor(tabs[i].get("contentEl"),field))){var label=tabs[i].get("labelEl");if(SUGAR.forms.flashInProgress[label.parentNode.id])
return;var tabAnim=new YAHOO.util.ColorAnim(label,{color:{to:'#F00'}},0.2);tabAnim.origColor=Dom.getStyle(label,"color");tabAnim.onComplete.subscribe(function(){if(this.attributes.color.to=='#F00'){this.attributes.color.to=this.origColor;this.animate();}else{SUGAR.forms.flashInProgress[label.parentNode.id]=false;}});SUGAR.forms.flashInProgress[label.parentNode.id]=true;tabAnim.animate();}}}}
oButtonAnim.animate();}})();