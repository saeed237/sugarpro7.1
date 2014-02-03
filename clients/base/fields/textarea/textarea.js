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
({fieldTag:"textarea",maxDisplayLength:450,isTruncated:false,lastMode:null,plugins:['EllipsisInline'],events:{'click .show-more-text':'toggleMoreText'},format:function(value){return this.value||value||'';},_render:function(){this.def.css_class=this.def.css_class||'textarea-text';var value=this.model.get(this.name);if((!_.isUndefined(value))&&(value.length>this.maxDisplayLength)){this.isTooLong=true;}else{this.isTooLong=false;this.lastMode=null;this.value=value;}
if(this.lastMode&&this.tplName==='edit'){if(this.lastMode==='more'){this.showMore();return;}
this.showLess();return;}
app.view.Field.prototype._render.call(this);this.$el.addClass(this.def.css_class);if(this._notListView()){if(this.tplName!=='edit'){if(this.isTooLong){this.showLess();}
if(this.tplName==='disabled'){this.$(this.fieldTag).attr("disabled","disabled");}}else{this.value=value;app.view.Field.prototype._render.call(this);}}},_notListView:function(){if(this.view.name!=='list'||(this.view.meta&&this.view.meta.type!=='list')){return true;}
return false;},toggleMoreText:function(){if(this.isTruncated){this.showMore();}else{this.showLess();}},showMore:function(){this._toggleTextLength('more');},showLess:function(){this._toggleTextLength('less');},_toggleTextLength:function(mode){var displayValue,newLinkLabel,originalValue;originalValue=this.model.get(this.name);if(mode==="more"){displayValue=originalValue.trim()+'...';this.isTruncated=false;newLinkLabel=app.lang.get('LBL_LESS',this.module).toLocaleLowerCase();}else{displayValue=originalValue.substring(0,this.maxDisplayLength).trim()+'...';this.isTruncated=true;newLinkLabel=app.lang.get('LBL_MORE',this.module).toLocaleLowerCase();}
this.value=displayValue;this.$el.empty();app.view.Field.prototype._render.call(this);this.$('.show-more-text').text(newLinkLabel);this.lastMode=mode;}})