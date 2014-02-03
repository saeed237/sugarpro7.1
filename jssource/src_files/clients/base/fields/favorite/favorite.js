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
     * {@inheritDoc}
     *
     * This field doesn't support `showNoData`.
     */
    showNoData: false,

    'events': {
        'click .icon-favorite': 'toggle'
    },
    plugins: ['Tooltip'],
    /**
     * {@inheritdoc}
     *
     * The favorite is always a readonly field.
     */
    initialize: function(options) {
        options.def.readonly = true;
        app.view.Field.prototype.initialize.call(this, options);
    },

    /**
     * Check first if the module has favoritesEnabled before rendering it.
     *
     * @private
     */
    _render: function() {
        // can't favorite something without an id
        if (!this.model.get('id')) {
            return null;
        }
        if (!app.metadata.getModule(this.model.module).favoritesEnabled) {
            app.logger.error("Trying to use favorite field on a module that doesn't support it: '" + this.model.module + "'.");
            return null;
        }
        return app.view.Field.prototype._render.call(this);
    },

    /**
     * Function called for each click on the star icon (normally acts as toggle
     * function).
     *
     * If the star is checked, copy all the source fields to target ones
     * based on the mapping definition of this field. Otherwise, restore all the
     * values of the modified fields by this copy widget.
     *
     * @param {Event} evt
     *   The event (expecting click event) that triggered the checkbox status
     *   change.
     */
    toggle: function(evt) {
        var self = this,
            star = $(evt.currentTarget);

        var options = {
            silent: true,
            alerts: false
        };
        //when we toggle favorite icon on list view we need to update the view to actually see the changes
        if (self.view && self.view.action === 'list') {
            options.success = function() {
                self._refreshListView();
            };
        }

        if (this.model.favorite(!this.model.isFavorite(), options) === false) {
            app.logger.error("Unable to set '" + this.model.module + "' record '" + this.model.id + "' as favorite");
            return;
        }
        if (this.model.isFavorite()) {
            star.addClass('active');
            this.model.trigger("favorite:active");
        }
        else {
            star.removeClass('active');
        }
    },

    /**
     * {@inheritdoc}
     *
     * @return {Boolean}
     */
    format: function() {
        return this.model.isFavorite();
    },

    /**
     * On model save success, this function gets called to refresh the list view
     * @see BaseEditablelistbuttonField is using about the same method
     * @private
     */
    _refreshListView: function() {
        var filterPanelLayout = this.view;
        //Try to find the filterpanel layout
        while (filterPanelLayout && filterPanelLayout.name !== 'filterpanel') {
            filterPanelLayout = filterPanelLayout.layout;
        }
        //If filterpanel layout found and not disposed, then pick the value from the quicksearch input and
        //trigger the filtering
        if (filterPanelLayout && !filterPanelLayout.disposed && this.collection) {
            filterPanelLayout.applyLastFilter(this.collection, 'favorite');
        }
    }
})
