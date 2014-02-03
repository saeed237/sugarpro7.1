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
({className:'error-page',initialize:function(options){app.metadata.set(this._metadata);app.data.declareModels();app.controller.context.prepare(true);this.options.meta=this._metadata.modules[this.options.module].views[this.options.name].meta;app.view.View.prototype.initialize.call(this,options);},_render:function(){if(this.context.get('errorType')){var attributes=this.getErrorAttributes();this.model.set(attributes);}
app.view.View.prototype._render.call(this);},getErrorAttributes:function(){var attributes={};if(this.context.get('errorType')==='404'){attributes={title:'ERR_HTTP_404_TITLE',type:'ERR_HTTP_404_TYPE',message:'ERR_HTTP_404_TEXT'};}else if(this.context.get('errorType')==='500'){attributes={title:'ERR_HTTP_500_TITLE',type:'ERR_HTTP_500_TYPE',message:'ERR_HTTP_500_TEXT'};}else{var error=this.context.get('error')||{};var title=null;if(error.status&&error.errorThrown){title='HTTP: '+error.status+' '+error.errorThrown;}
attributes={title:title||'ERR_HTTP_DEFAULT_TITLE',type:error.status||'ERR_HTTP_DEFAULT_TYPE',message:error.message||'ERR_HTTP_DEFAULT_TEXT'};}
return attributes;},_metadata:{"modules":{"Error":{"views":{"error":{"meta":{}}},"layouts":{"error":{"meta":{"type":"simple","components":[{view:"error"}]}}}}}}})