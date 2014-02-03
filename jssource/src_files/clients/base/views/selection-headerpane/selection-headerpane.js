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
    extendsFrom: 'HeaderpaneView',

    initialize: function(options) {
        var moduleMeta = app.metadata.getModule(options.module),
            isBwcEnabled = (moduleMeta && moduleMeta.isBwcEnabled),
            additionalEvents = {};

        if (isBwcEnabled) {
            options = this._removeCreateButton(options);
        } else {
            additionalEvents['click .btn[name=create_button]'] = 'createAndSelect';
            this.events = _.extend({}, this.events, additionalEvents);
        }
        app.view.invokeParent(this, {type: 'view', name: 'headerpane', method: 'initialize', args:[options]});
    },

    _renderHtml: function() {
        var titleTemplate = Handlebars.compile(app.lang.getAppString("LBL_SEARCH_AND_SELECT")),
            moduleName = app.lang.get("LBL_MODULE_NAME", this.module);
        this.title = titleTemplate({module: moduleName});
        app.view.invokeParent(this, {type: 'view', name: 'headerpane', method: '_renderHtml'});

        this.layout.on('selection:closedrawer:fire', function() {
            app.drawer.close();
        }, this);
    },

    /**
     * Open create inline modal with no dupe check
     * On save, set the selection model which will close the selection-list inline modal
     */
    createAndSelect: function() {
        app.drawer.open({
            layout: 'create-nodupecheck',
            context: {
                module: this.module,
                create: true
            }
        }, _.bind(function (context, model) {
            if (model) {
                this.context.trigger('selection-list:select', model);
            }
        }, this));
    },

    /**
     * Remove the create button from the options metadata
     *
     * @param options
     * @returns {*}
     * @private
     */
    _removeCreateButton: function(options) {
        if (options && options.meta && options.meta.buttons) {
            options.meta.buttons = _.filter(options.meta.buttons, function(button) {
                return (button.name !== 'create_button');
            });
        }

        return options;
    }
})
