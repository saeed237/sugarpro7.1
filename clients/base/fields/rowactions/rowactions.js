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
({extendsFrom:'ActiondropdownField',_loadTemplate:function(){app.view.Field.prototype._loadTemplate.call(this);var template=app.template._getField(this.type,this.tplName,this.module,null,true)[1];if(template){this.$el.attr('class','');this.$el.html(template(this));}
if(this.view.action==='list'&&this.action==='edit'){this.$el.hide();}else{this.$el.show();}}})