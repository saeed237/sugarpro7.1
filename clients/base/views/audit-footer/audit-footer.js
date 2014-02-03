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
({initialize:function(options){this._super('initialize',[options]);if(this.context.parent){var baseModule=this.context.parent.get('module');this.auditedFields=this._getAuditedFields(baseModule);}},_getAuditedFields:function(baseModule){return _.chain(app.metadata.getModule(baseModule,'fields')).filter(function(o){return o.audited;}).map(function(o){return app.lang.get(o.vname,baseModule);}).value();}})