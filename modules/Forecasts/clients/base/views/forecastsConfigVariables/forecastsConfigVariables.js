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
({events:{'click .resetLink':'onResetLinkClicked'},initialize:function(options){app.view.View.prototype.initialize.call(this,options);},onResetLinkClicked:function(evt){evt.preventDefault();evt.stopImmediatePropagation();},_renderField:function(field){if(field.def.multi){field=this._setUpMultiselectField(field);}
app.view.View.prototype._renderField.call(this,field);field.$el.find('.chzn-container').css("width","100%");field.$el.find('.chzn-drop').css("width","100%");},_setUpMultiselectField:function(field){field.def.value=this.model.get(field.name);field.events=_.extend({"change select":"_updateSelections"},field.events);field.bindDomChange=function(){};field._updateSelections=function(event,input){var fieldValue=this.model.get(this.name);var id;if(_.has(input,"selected")){id=input.selected;if(!_.contains(fieldValue,id)){fieldValue=_.union(fieldValue,id);}}else if(_.has(input,"deselected")){id=input.deselected;if(_.contains(fieldValue,id)){fieldValue=_.without(fieldValue,id);}}
this.def.value=fieldValue;this.model.set(this.name,fieldValue);};return field;}})