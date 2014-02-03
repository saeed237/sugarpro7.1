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
({_currentIndex:0,_placeComponent:function(component){if(component==this._components[this._currentIndex]){this.$el.append(component.el);}},addComponent:function(component,def){component=this._addButtonsForComponent(component);if(component.showPage()){app.view.Layout.prototype.addComponent.call(this,component,def);}},_addButtonsForComponent:function(component){var buttons=[];component.meta=component.meta||{};_.each(this.meta.components,function(comp,i){if(comp.view===component.name){if(i===0){buttons.push(this.meta.buttons[1]);}else if(i===this.meta.components.length-1){buttons.push(this.meta.buttons[0]);buttons.push(this.meta.buttons[2]);}else{buttons.push(this.meta.buttons[0]);buttons.push(this.meta.buttons[1]);}}},this);component.meta.buttons=buttons;return component;},setPage:function(newIndex){if(newIndex!==this._currentIndex&&(newIndex>=0&&newIndex<this._components.length)){this._components[this._currentIndex].$el.detach();this._currentIndex=newIndex;this.$el.append(this._components[this._currentIndex].el);this._components[this._currentIndex].render();}
return this.getProgress();},_render:function(){if(this._components){this._components[this._currentIndex].render();}},getProgress:function(){return{page:this._currentIndex+1,lastPage:this._components.length};},previousPage:function(){return this.setPage(this._currentIndex-1);},nextPage:function(){return this.setPage(this._currentIndex+1);},finished:function(){var callbacks=this.context.get("callbacks");this.dispose();if(callbacks&&callbacks.complete){callbacks.complete();}}})