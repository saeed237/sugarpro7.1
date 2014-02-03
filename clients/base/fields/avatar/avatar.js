/*
     * By installing or using this file, you are confirming on behalf of the entity
     * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
     * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
     * http://www.sugarcrm.com/master-subscription-agreement
     *
     * If Company is not bound by the MSA, then by installing or using this file
     * you are agreeing unconditionally that Company will be bound by the MSA and
     * certifying that you have authority to bind Company accordingly.
     *
     * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
     */
({extendsFrom:'ImageField',plugins:['File','Tooltip'],_render:function(){var template;app.view.invokeParent(this,{type:'field',name:'image',method:'_render'});if(this.action!=='edit'){if(_.isEmpty(this.value)){template=app.template.getField(this.type,'module-icon',this.module);if(template){this.$('.image_field').replaceWith(template({module:this.module}));}}else{this.$('.image_field').addClass('image_rounded');}}
return this;},_loadTemplate:function(){this.type='image';app.view.invokeParent(this,{type:'field',name:'image',method:'_loadTemplate'});this.type=this.def.type;}})