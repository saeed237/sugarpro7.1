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
({className:'widget-header',cssIconDefault:'icon-cog',cssIconRefresh:'icon-refresh icon-spin',defaultActions:{'dashlet:edit:clicked':'editClicked','dashlet:refresh:clicked':'refreshClicked','dashlet:delete:clicked':'removeClicked','dashlet:toggle:clicked':'toggleMinify'},plugins:['Tooltip'],initialize:function(options){_.extend(options.meta,app.metadata.getView(null,'dashlet-toolbar'),options.meta.toolbar);app.view.View.prototype.initialize.call(this,options);},refreshClicked:function(){var $el=this.$("[data-action=loading]"),self=this,options={};if($el.length>0){$el.removeClass(this.cssIconDefault).addClass(this.cssIconRefresh);options.complete=function(){if(self.disposed){return;}
$el.removeClass(self.cssIconRefresh).addClass(self.cssIconDefault);};}
this.layout.reloadDashlet(options);},removeClicked:function(evt){this.layout.removeDashlet();},editClicked:function(evt){this.layout.editDashlet();},toggleClicked:function(evt){var $btn=$(evt.currentTarget),expanded=_.isUndefined($btn.data('expanded'))?true:$btn.data('expanded'),label=expanded?'LBL_DASHLET_MAXIMIZE':'LBL_DASHLET_MINIMIZE';$btn.html(app.lang.get(label,this.module));this.layout.collapse(expanded);$btn.data('expanded',!expanded);},toggleMinify:function(evt){var $el=this.$('.dashlet-toggle > i'),collapsed=$el.is('.icon-chevron-up');this.layout.collapse(collapsed);}})