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
    extendsFrom: 'ConvertResultsView',

    /**
     * Build a collection of associated models and re-render the view
     */
    populateResults: function() {
        var model;

        //only show related records if lead is converted
        if (!this.model.get('converted')) {
            return;
        }

        this.associatedModels.reset();

        model = this.buildAssociatedModel('Contacts', 'contact_id', 'contact_name');
        if (model) {
            this.associatedModels.push(model);
        }
        model = this.buildAssociatedModel('Accounts', 'account_id', 'account_name');
        if (model) {
            this.associatedModels.push(model);
        }
        model = this.buildAssociatedModel('Opportunities', 'opportunity_id', 'opportunity_name');
        if (model) {
            this.associatedModels.push(model);
        }
        app.view.View.prototype.render.call(this);
    },

    /**
     * Build an associated model based on given id & name fields on the Lead record
     *
     * @param moduleName
     * @param idField
     * @param nameField
     * @return {*} model or false if id field is not set on the lead
     */
    buildAssociatedModel: function(moduleName, idField, nameField) {
        var moduleSingular = app.lang.getAppListStrings("moduleListSingular"),
            rowTitle,
            model;

        if (_.isEmpty(this.model.get(idField))) {
            return false;
        }

        rowTitle = app.lang.get(
            'LBL_CONVERT_MODULE_ASSOCIATED',
            this.module,
            {'moduleName': moduleSingular[moduleName]}
        );

        model = app.data.createBean(moduleName, {
            id: this.model.get(idField),
            name: this.model.get(nameField),
            row_title: rowTitle,
            _module: moduleName,
            target_module: moduleName
        });
        model.module = moduleName;
        return model;
    }
})
