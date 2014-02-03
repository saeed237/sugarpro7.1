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
({filterOpened:false,events:{'click [data-action="show-more"]':'showMoreRecords'},initialize:function(opts){opts.meta=_.extend({},{showMoreLabel:"LBL_SHOW_MORE_MODULE"},opts.meta||{});app.view.View.prototype.initialize.call(this,opts);this.showMoreLabel=app.lang.get(this.options.meta.showMoreLabel,this.module,{module:app.lang.get('LBL_MODULE_NAME',this.module).toLowerCase()});},_renderHtml:function(){if(this.context.get('limit')){this.limit=this.context.get('limit');}
app.view.View.prototype._renderHtml.call(this);this.layout.off("list:filter:toggled",null,this);this.layout.on("list:filter:toggled",this.filterToggled,this);},filterToggled:function(isOpened){this.context.set('filterOpened',isOpened);},showMoreRecords:function(evt){var self=this,options;_.each(this.collection.models,function(model){model.old=true;});var screenPosition=$('html').offset().top;options=this.context.get('filterOpened')?self.getSearchOptions():{};options.showAlerts=true;options.add=true;options.success=function(){self.layout.trigger("list:paginate:success");if(!self.disposed){self.render();window.scrollTo(0,-1*screenPosition);self.layout.$('tr.new').animate({opacity:1},500,function(){$(this).removeAttr('style class');});}};if(this.limit){options.limit=this.limit;}
options=_.extend({},this.context.get('collectionOptions'),options);this.collection.paginate(options);},getSearchOptions:function(){var collection,options,previousTerms,term='';collection=this.context.get('collection');if(app.cache.has('previousTerms')){previousTerms=app.cache.get('previousTerms');if(previousTerms){term=previousTerms[this.module];}}
options={params:{q:term},fields:collection.fields?collection.fields:this.collection};return options;},bindDataChange:function(){if(this.collection){this.collection.on("reset sync",function(){this.render();},this);}}})