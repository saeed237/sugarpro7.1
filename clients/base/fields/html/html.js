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
({fieldSelector:'.htmlareafield',initialize:function(options){options.def.readonly=true;app.view.Field.prototype.initialize.call(this,options);},_render:function(){app.view.Field.prototype._render.call(this);this._getFieldElement().attr('name',this.name);this.setViewContent();},setViewContent:function(){var value=this.value||this.def.default_value;var field=this._getFieldElement();if(field&&!_.isEmpty(field.get(0).contentDocument)){if(field.contents().find('body').length>0){field.contents().find('body').html(value);}}},_getFieldElement:function(){return this.$el.find(this.fieldSelector);}})