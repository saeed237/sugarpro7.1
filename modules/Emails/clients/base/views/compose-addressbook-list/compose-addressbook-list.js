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
({
    /**
     * @class View.ComposeAddressbookListView
     * @alias SUGAR.App.view.views.ComposeAddressbookListView
     * @extends View.FlexListView
     */
    extendsFrom: 'FlexListView',
    plugins: ['ListColumnEllipsis', 'ListRemoveLinks'],
    /**
     * Removes the event listeners that were added to the mass collection.
     */
    unbindData: function() {
        var massCollection = this.context.get('mass_collection');
        if (massCollection) {
            massCollection.off(null, null, this);
        }
        app.view.invokeParent(this, {type: 'view', name: 'flex-list', method: 'unbindData'});
    },
    /**
     * Override to inject field names into the request when fetching data for the list.
     *
     * @param module
     * @returns {Array}
     */
    getFieldNames: function(module) {
        // id and module always get returned, so name and email just need to be added
        return ['name', 'email'];
    },
    /**
     * Override to hook in additional triggers as the mass collection is updated (rows are checked on/off in
     * the actionmenu field). Also attempts to pre-check any rows when the list is refreshed and selected recipients
     * are found within the new result set (this behavior occurs when the user searches the address book).
     *
     * @private
     */
    _render: function() {
        app.view.invokeParent(this, {type: 'view', name: 'flex-list', method: '_render'});
        var massCollection              = this.context.get('mass_collection'),
            selectedRecipientsFieldName = 'compose_addressbook_selected_recipients';
        if (massCollection) {
            // get rid of any old event listeners on the mass collection
            massCollection.off(null, null, this);
            // add a new recipient to the selected recipients field as recipients are added to the mass collection
            massCollection.on('add', function(model) {
                var existingRecipients = this.model.get(selectedRecipientsFieldName);
                if (model.id && existingRecipients instanceof Backbone.Collection) {
                    existingRecipients.add(model);
                }
            }, this);
            // remove a recipient from the selected recipients field as recipients are removed from the mass collection
            massCollection.on('remove', function(model) {
                var existingRecipients = this.model.get(selectedRecipientsFieldName);
                if (model.id && existingRecipients instanceof Backbone.Collection) {
                    existingRecipients.remove(model);
                }
            }, this);
            // remove from the selected recipients field all recipients found in the current collection
            massCollection.on('reset', function() {
                var existingRecipients = this.model.get(selectedRecipientsFieldName);
                if (existingRecipients instanceof Backbone.Collection) {
                    existingRecipients.remove(this.collection.models);
                }
            }, this);
            // find any currently selected recipients and add them to mass_collection so the checkboxes on the
            // corresponding rows are pre-selected
            var existingRecipients = this.model.get(selectedRecipientsFieldName);
            if (existingRecipients instanceof Backbone.Collection && existingRecipients.length > 0) {
                // only bother with adding, to mass_collection, recipients that are visible in the list view
                var recipientsToPreselect = existingRecipients.filter(_.bind(function(recipient) {
                    return (this.collection.where({id: recipient.get('id')}).length > 0);
                }, this));
                if (recipientsToPreselect.length > 0) {
                    massCollection.add(recipientsToPreselect);
                }
            }
        }
    },
    /**
     * Override to force translation of the module names as columns are added to the list.
     *
     * @param field
     * @private
     */
    _renderField: function(field) {
        if (field.name == '_module') {
            field.model.set(field.name, app.lang.get('LBL_MODULE_NAME', field.model.get(field.name)));
        }
        app.view.invokeParent(this, {type: 'view', name: 'flex-list', method: '_renderField', args: [field]});
    }
})
