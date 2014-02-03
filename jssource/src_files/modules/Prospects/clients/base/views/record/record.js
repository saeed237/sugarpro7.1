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

({
    extendsFrom: 'RecordView',

    delegateButtonEvents: function() {
        this.context.on('button:convert_button:click', this.convertProspectClicked, this);
        app.view.invokeParent(this, {type: 'view', name: 'record', method: 'delegateButtonEvents'});
    },

    convertProspectClicked: function() {
        var prefill = app.data.createBean('Leads');

        prefill.copy(this.model);
        app.drawer.open({
            layout: 'create-actions',
            context: {
                create: true,
                model: prefill,
                module: 'Leads',
                prospect_id: this.model.get('id')
            }
        }, _.bind(function(context, model) {
            //if lead is created, grab the new relationship to the target so the convert-results will refresh
            if (model && model.id && !this.disposed) {
                this.model.fetch();
            }
        }, this));
    }
})
