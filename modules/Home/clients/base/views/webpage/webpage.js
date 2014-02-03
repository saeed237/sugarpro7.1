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
({plugins:['Dashlet'],_defaultOptions:{limit:10,},bindDataChange:function(){if(!this.meta.config){this.model.on("change",this.render,this);}},_render:function(){if(!this.meta.config){this.dashletConfig.view_panel[0].height=this.settings.get('limit')*this.rowHeight;}
app.view.View.prototype._render.call(this);},initDashlet:function(view){this.viewName=view;var settings=_.extend({},this._defaultOptions,this.settings.attributes);this.settings.set(settings);},loadData:function(options){if(options&&options.complete){options.complete();}}})