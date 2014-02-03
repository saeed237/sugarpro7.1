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

(function(app) {
    /**
     * Controller manages the loading and unloading of layouts within the app.
     *
     * **Extending controller**
     *
     * Application may choose to extend the controller to provide custom implementation.
     * Your custom controller class name should be capiltalized {@link Config#appId} followed by `Controller` word.
     * <pre><code>
     * (function(app) {
     *
     *     app.PortalController = app.Controller.extend({
     *
     *         loadView: function(params) {
     *            // Custom implementation of loadView
     *
     *            // Should you need to call super method:
     *            app.Controller.prototype.loadView.call(this, params);
     *         }
     *
     *     });
     *
     * })(SUGAR.App);
     * </code></pre>
     *
     * @class Core.Controller
     * @singleton
     * @alias SUGAR.App.controller
     */
    var Controller = Backbone.View.extend({
        /**
         * Initializes this controller.
         * @private
         * @constructor
         * @ignore
         */
        initialize: function() {
            /**
             * The primary context of the app.
             * This context is associated with the root layout.
             * @property {Core.Context}
             */
            this.context = app.context.getContext();

            app.events.on("app:sync:complete", function() {
                _.each(app.additionalComponents, function(component) {
                    if (component && _.isFunction(component._setLabels)) {
                        component._setLabels();
                    }
                    component.render();
                });
                app.router.start();
            });

            app.events.on("app:login:success", function() {
                app.sync();
            });
        },

        /**
         * Loads a view (layout).
         *
         * This method is called by the router when the route is changed.
         *
         * @param {Object} params Options that determine the current context and the view to load.

         * - id: ID of the record to load (optional)
         * - module: module name
         * - layout: Name of the layout to .oad
         */
        loadView: function(params) {

            var oldLayout =  this.layout;

            // Reset context and initialize it with new params
            this.context.clear({silent: true});
            this.context.set(params);

            // Prepare model and collection
            this.context.prepare();
            // Create an instance of the layout and bind it to the data instance
            this.layout = app.view.createLayout({
                name: params.layout,
                module: params.module,
                context: this.context
            });

            if (oldLayout) {
                // Take out the previous layout element from the content container,
                // and then keep it in the document fragment
                // in order to destroy jQuery plugin safe.
                var oldLayoutEl = document.createDocumentFragment();
                oldLayoutEl.appendChild(oldLayout.el);
            }

            // Render the layout to the main element
            // Since the previous element is already gone,
            // .append is better way because .html requires
            // additional cost for .empty().
            app.$contentEl.append(this.layout.$el);

            // Fetch the data, the layout will be rendered when fetch completes
            if(!params || (params && !params.skipFetch)) {
                this.layout.loadData();
            }

            // Render the layout with empty data
            this.layout.render();

            if (oldLayout) {
                oldLayout.dispose();
            }

            app.trigger("app:view:change", params.layout, params);
        },

        /**
         * Creates, renders, and registers within the app additional components.
         */
        loadAdditionalComponents: function(components) {
            // Unload components that may be loaded previously
            _.each(app.additionalComponents, function(component) {
                if (component) {
                    component.remove();
                    component.dispose();
                }
            });
            app.additionalComponents = {};
            _.each(components, function(component, name) {
                if(component.target) {
                    if(component.layout) {
                        app.additionalComponents[name] = app.view.createLayout({
                            context: this.context,
                            name: component.layout,
                            el: this.$(component.target)
                        });
                    } else {
                        app.additionalComponents[name] = app.view.createView({
                            name: component.view || name,
                            context: this.context,
                            el: this.$(component.target)
                        });
                    }
                    app.additionalComponents[name].render();
                } else {
                    app.logger.error("Unable to create Additional Component '" + name + "'; No target specified.");
                }
            });
        }
    });

    app.augment("Controller", Controller, false);

    app.events.on("app:init", function(app) {
        app.controller.setElement(app.$rootEl);
    }, app.controller).on("app:start", function(app) {
        app.controller.loadAdditionalComponents(app.config.additionalComponents);
    });

})(SUGAR.App);
