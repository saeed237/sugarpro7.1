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
({initialize:function(options){app.view.Layout.prototype.initialize.call(this,options);this.on("header:update:route",this.resize,this);app.events.on("app:sync:complete",this.resize,this);app.events.on("app:view:change",this.resize,this);var resize=_.bind(this.resize,this);$(window).off("resize",resize).on("resize",resize);},_placeComponent:function(component){this.$el.find('.nav-collapse').append(component.$el);},resize:function(){var totalWidth=0,modulelist,maxMenuWidth,componentElement,container=this.$('.navbar-inner');_.each(this._components,function(component){componentElement=component.$el.children().first();if(component.name!=='modulelist'){if(componentElement.is(':visible')){totalWidth+=component.$el.outerWidth(true);}}else{modulelist=component.$el;}});maxMenuWidth=container.parent('.navbar-fixed-top').width();this.trigger('view:resize',maxMenuWidth-totalWidth);},_render:function(){var result=app.view.Layout.prototype._render.call(this);if(app.api.isAuthenticated()){this.$el.show();this.resize();}else{this.$el.hide();return this;}
return result;}})