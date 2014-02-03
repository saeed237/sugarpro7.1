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
({showNoData:false,'events':{'click .icon-favorite':'toggle'},plugins:['Tooltip'],initialize:function(options){options.def.readonly=true;app.view.Field.prototype.initialize.call(this,options);},_render:function(){if(!this.model.get('id')){return null;}
if(!app.metadata.getModule(this.model.module).favoritesEnabled){app.logger.error("Trying to use favorite field on a module that doesn't support it: '"+this.model.module+"'.");return null;}
return app.view.Field.prototype._render.call(this);},toggle:function(evt){var self=this,star=$(evt.currentTarget);var options={silent:true,alerts:false};if(self.view&&self.view.action==='list'){options.success=function(){self._refreshListView();};}
if(this.model.favorite(!this.model.isFavorite(),options)===false){app.logger.error("Unable to set '"+this.model.module+"' record '"+this.model.id+"' as favorite");return;}
if(this.model.isFavorite()){star.addClass('active');this.model.trigger("favorite:active");}
else{star.removeClass('active');}},format:function(){return this.model.isFavorite();},_refreshListView:function(){var filterPanelLayout=this.view;while(filterPanelLayout&&filterPanelLayout.name!=='filterpanel'){filterPanelLayout=filterPanelLayout.layout;}
if(filterPanelLayout&&!filterPanelLayout.disposed&&this.collection){filterPanelLayout.applyLastFilter(this.collection,'favorite');}}})