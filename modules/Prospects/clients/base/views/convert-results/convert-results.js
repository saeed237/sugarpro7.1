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
({extendsFrom:'ConvertResultsView',populateResults:function(){if(!_.isEmpty(this.model.get('lead_id'))){var leads=app.data.createBean('Leads',{id:this.model.get('lead_id')});leads.fetch({success:_.bind(this.populateLeadCallback,this),error:function(){app.logger.error.log("error");}});}},populateLeadCallback:function(leadModel){var rowTitle;this.associatedModels.reset();rowTitle=app.lang.get('LBL_CONVERTED_LEAD',this.module);leadModel.set('row_title',rowTitle);this.associatedModels.push(leadModel);app.view.View.prototype.render.call(this);}})