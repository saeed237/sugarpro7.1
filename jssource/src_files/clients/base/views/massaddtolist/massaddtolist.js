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
    /**
     * @class View.MassaddtolistView
     * @alias SUGAR.App.view.views.MassaddtolistView
     * @extends View.MassupdateView
     */
    extendsFrom: 'MassupdateView',
    addToListFieldName: 'prospect_lists',
    listModule: 'ProspectLists',
    massUpdateViewName: 'massaddtolist-progress',

    initialize: function(options) {
        var additionalEvents = {};
        additionalEvents['click .btn[name=create_button]'] = 'createAndSelectNewList';
        this.events = _.extend({}, this.events, additionalEvents);
        app.view.invokeParent(this, {type: 'view', name: 'massupdate', method: 'initialize', args:[options]});
    },

    /**
     * Listen for just the massaddtolist event from the list view
     */
    delegateListFireEvents: function() {
        this.layout.on("list:massaddtolist:fire", this.show, this);
        this.layout.on("list:massaction:hide", this.hide, this);
    },

    /**
     * Pull out the target list link field from the field list and treat it like a relate field for later rendering
     * @param options
     */
    setMetadata: function(options) {
        var moduleMetadata = app.metadata.getModule(options.module);

        var addToListField = _.find(moduleMetadata.fields, function(field) {
            return field.name === this.addToListFieldName;
        }, this);

        if (addToListField) {
            addToListField = app.utils.deepCopy(addToListField);
            addToListField.id_name = this.addToListFieldName + '_id';
            addToListField.name = this.addToListFieldName + '_name';
            addToListField.label = addToListField.label || addToListField.vname;
            addToListField.type = 'relate';
            addToListField.required = true;
            this.addToListField = addToListField;
        }
    },

    /**
     * Hide the view if we were not able to find the appropriate list field and somehow render is triggered
     */
    _render: function() {
        var result = app.view.invokeParent(this, {type: 'view', name: 'massupdate', method: '_render'});

        if(_.isUndefined(this.addToListField)) {
            this.hide();
        }
        return result;
    },

    /**
     * There is only one field for this view, so it is the default as well
     */
    setDefault: function() {
        this.defaultOption = this.addToListField;
    },

    /**
     * When adding to a target list, the API is expecting an array of IDs
     */
    getAttributes: function() {
        var attributes = {};
        attributes[this.addToListFieldName] = [
            this.model.get(this.addToListField.id_name)
        ];
        return attributes;
    },

    /**
     * Build dynamic success messages to be displayed if the API call is successful
     * Overridden to build different success messages from massupdate
     *
     * @param massUpdateModel - contains the attributes of what records are being updated
     */
    buildSaveSuccessMessages: function(massUpdateModel) {
        var doneLabel = 'TPL_MASS_ADD_TO_LIST_SUCCESS',
            queuedLabel = 'TPL_MASS_ADD_TO_LIST_QUEUED',
            listName = this.model.get(this.addToListField.name),
            listId = this.model.get(this.addToListField.id_name),
            listUrl = '#' + app.router.buildRoute(this.listModule, listId);

        return {
            done: app.lang.get(doneLabel, null, {
                listName: listName,
                listUrl: listUrl
            }),
            queued: app.lang.get(queuedLabel, null, {
                listName: listName,
                listUrl: listUrl
            })
        };
    },

    /**
     * Create a new target list and select it in the list
     */
    createAndSelectNewList: function() {
        app.drawer.open({
            layout: 'create-nodupecheck',
            context: {
                create: true,
                module: this.listModule
            }
        }, _.bind(this.selectNewlyCreatedList, this));
    },

    /**
     * Callback for create new target list - sets relate field with newly created list
     * @param context
     * @param model newly created target list model
     */
    selectNewlyCreatedList: function(context, model) {
        var relateField = this.getField('prospect_lists_name');
        if (relateField) {
            model.value = model.get('name');
            relateField.setValue(model);
        }
    }
})
