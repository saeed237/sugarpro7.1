/*
     * By installing or using this file, you are confirming on behalf of the entity
     * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
     * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
     * http://www.sugarcrm.com/master-subscription-agreement
     *
     * If Company is not bound by the MSA, then by installing or using this file
     * you are agreeing unconditionally that Company will be bound by the MSA and
     * certifying that you have authority to bind Company accordingly.
     *
     * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
     */
(function(app){app.events.on("app:init",function(){app.plugins.register('ListColumnEllipsis',['view'],{events:{'click [data-field-toggle]':'toggleColumn'},toggleColumn:function(event){var column=$(event.currentTarget).data('fieldToggle');if(this.isLastColumnVisible(column)){event.stopPropagation();return;}
this._toggleColumn(column);this.render();this._reopenFieldsDropdown(event);},_toggleColumn:function(column){this._fields.visible=[];this._fields.available=[];var changedColumn={};_.each(this._fields.options,function(fieldMeta){if(fieldMeta.name===column){fieldMeta.selected=!fieldMeta.selected;changedColumn=fieldMeta;}
if(fieldMeta.selected){this._fields.visible.push(fieldMeta);}else{this._fields.available.push(fieldMeta);}},this);if(this.visibleFieldsLastStateKey){app.user.lastState.set(this.visibleFieldsLastStateKey,_.pluck(this._fields.visible,'name'));}
this.trigger('list:toggle:column',column,changedColumn.selected,changedColumn);},isLastColumnVisible:function(column){var isLastColumnVisible=false;if(this._fields.visible.length===1){isLastColumnVisible=_.find(this._fields.visible,function(fmeta){return fmeta.name===column;});}
return isLastColumnVisible?true:false;},_reopenFieldsDropdown:function(event){this.$('[data-action="fields-toggle"]').dropdown('toggle');event.stopPropagation();},onAttach:function(component,plugin){this.before('render',function(){var lastActionColumn=_.last(this.rightColumns);if(lastActionColumn){lastActionColumn.isColumnDropdown=true;}},null,this);}});});})(SUGAR.App);