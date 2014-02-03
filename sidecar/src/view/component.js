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

/**
 * Represents base view class for layouts, views, and fields.
 *
 * This is an abstract class.
 * @class View.Component
 * @alias SUGAR.app.view.Component
 */
(function(app) {

    app.view.Component = Backbone.View.extend({

        /**
         * Initializes a component.
         * @constructor
         * @param options
         *
         * - context
         * - meta
         * - module
         * - model
         * - collection
         *
         * `context` is the only required option.
         * @return {View.Component}
         */
        initialize: function(options) {

            /**
             * Reference to the context (required).
             * @property {Core.Context}
             */
            this.context = options.context || app.controller.context;

            /**
             * Component metadata (optional).
             * @property {Object}
             */
            this.meta = options.meta;

            /**
             * Module name (optional).
             * @property {String}
             */
            this.module = options.module || this.context.get("module");

            /**
             * Reference to the model this component is bound to.
             * @property {Data.Bean}
             */
            this.model = options.model || this.context.get("model");

            /**
             * Reference to the collection this component is bound to.
             * @property {Data.BeanCollection}
             */
            this.collection = options.collection || this.context.get("collection");

            // Adds classes to the component based on the metadata.
            if(this.meta && this.meta.css_class) {
                this.$el.addClass(this.meta.css_class);
            }

            // Register last state defaults
            app.user.lastState.register(this);
        },

        /**
         * Renders a component.
         *
         * Override this method to provide custom logic.
         * The default implementation does nothing.
         * See Backbone.View documentation for details.
         * @protected
         */
        _render: function() {
            // Do nothing. Override.
        },

        /**
         * Renders a component.
         *
         * IMPORTANT: Do not override this method.
         * Instead, override {@link View.Component#_render} to provide render logic.
         * @return {View.Component} Instance of this component.
         */
        render: function() {
            if (this.disposed === true) {
                app.logger.error("Unable to render component because it's disposed " + this + "\n");
                return false;
            }
            if(!this.triggerBefore("render"))
                return false;
            this._render();

            this.trigger("render");

            return this;
        },

        /**
         * Binds data changes to this component.
         *
         * This method should be overridden by derived views.
         */
        bindDataChange: function() {
            // Override this method to wire up model/collection events
        },

        /**
         * Removes this component's event handlers from model and collection.
         *
         * Performs the opposite of what {@link View.Component#bindDataChange} method does.
         * Override this method to provide custom logic.
         */
        unbindData: function() {
            if (this.model) this.model.off(null, null, this);
            if (this.collection) this.collection.off(null, null, this);
        },

        /**
         * Removes all event callbacks registered within this component
         * and undelegates Backbone events.
         *
         * Override this method to provide custom logic.
         */
        unbind: function() {
            this.off();
            this.offBefore();
            this.undelegateEvents();
            app.events.off(null, null, this);
            app.events.unregister(this);
            if (this.context) this.context.off(null, null, this);
            if (this.layout) this.layout.off(null, null, this);
        },

        /**
         * Fetches data for layout's model or collection.
         *
         * The default implementation does nothing.
         * See {@link View.Layout#loadData} and {@link View.View#loadData} methods.
         */
        loadData: function() {
            // Do nothing (view and layout will override)
        },

        /**
         * Disposes a component.
         *
         * This method:
         *
         * - unbinds the component from model and collection.
         * - removes all event callbacks registered within this component.
         * - removes the component from the DOM.
         *
         * Override this method to provide custom logic:
         * <pre><code>
         * app.view.views.MyView = app.view.View.extend({
         *      _dispose: function() {
         *          // Perform custom clean-up. For example, clear timeout handlers, etc.
         *          ...
         *          // Call super
         *          app.view.View.prototype._dispose.call(this);
         *      }
         * });
         * </code></pre>
         * @protected
         */
        _dispose: function() {
            this.unbindData();
            this.unbind();
            this.remove();
            this.model = null;
            this.collection = null;
            this.context = null;
            this.$el = null;
            this.el = null;
        },

        /**
         * Disposes a component.
         *
         * Once the component gets disposed it can not be rendered.
         * Do not override this method. Instead override {@link View.Component#_dispose} method
         * if you need custom disposal logic.
         */
        dispose: function() {
            if (this.disposed === true) return;
            this._dispose();
            this.disposed = true;
        },

        /**
         * Gets a string representation of this component.
         * @return {String} String representation of this component.
         */
        toString: function() {
            return this.cid +
                "-" + (this.$el && this.$el.id ? this.$el.id : "<no-id>") +
                "/" + this.module +
                "/" + this.model +
                "/" + this.collection;
        },

        /**
         * Pass through function to jQuery's show to show view.
         */
        show: function() {
            if(!this.isVisible()) {
                if (!this.triggerBefore("show")) {
                    return false;
                }

                this.$el.removeClass("hide").show();

                this.trigger('show');
            }
        },

        /**
         * Pass through function to jQuery's hide to hide view.
         */
        hide: function() {
            if(this.isVisible()) {
                if (!this.triggerBefore("hide")) {
                    return false;
                }

                this.$el.addClass("hide").hide();

                this.trigger('hide');
            }
        },

        /**
         *  Visibility Check
         */
        isVisible: function() {
            return this.$el.css('display') !== 'none';
        },

        /**
         *  _super is used to retrieve and invoke parent prototype functions.
         *  Requires a method paramter to function. The method called should be named the same as the function
         *  being called from.
         *
         * Examples:
         *
         * * Good:
         * <pre><code>
         * ({
         *     initialize: function(options) {
         *         //extend the base meta with some custom meta
         *         options.meta = _.extend({}, myMeta, options.meta || {});
         *         //Only call parent initialize from initialize
         *         this._super('initialize', [options]);
         * });
         * </code></pre>
         *
         * * Bad:
         * <pre><code>
         * ({
         *     initialize: function(options) {
         *         //extend the base meta with some custom meta
         *         options.meta = _.extend({}, myMeta, options.meta || {});
         *         //Calling a function like buildFoo from initialize is incorrect.
         *         this._super('buildFoo',[options]);
         * });
         * </code></pre>
         *
         * @param method {String} The name of the method to call e.g. 'initialize', '_renderHtml', etc. (required)
         * @param args {Array=} Arguments to pass to the parent method. Same syntax as .apply
         * @return {*}
         * @protected
         */
        _super : function(method, args) {
            //Must be used to invoke parent methods
            if (!method || !_.isString(method)) {
                return app.logger.error("tried to call _super without specifying a parent method in " + this.name);
            }

            var parent, resetSuper = null, thisProto = Object.getPrototypeOf(this);
            args = args || [];

            //_lastSuperClass is used to walk the prototype chain
            if (this._lastSuperClass) {
                resetSuper = this._lastSuperClass;
                parent = this._lastSuperClass = Object.getPrototypeOf(this._lastSuperClass);
            } else {
                parent = this._lastSuperClass = Object.getPrototypeOf(thisProto);
                this._lastSuperMethod = this._lastSuperMethod ? this._lastSuperMethod : method;
            }

            //_lastSuperMethod is used to ensure we don't stray from the chain
            if (this._lastSuperMethod && this._lastSuperMethod != method) {
                return app.logger.error("Attempt to call different parent method from child method in " + this.name);
            }

            //First verify that the method exists on the current object
            if (!thisProto[method]) {
                return app.logger.error("Unable to find method " + method + " on class " + this.name);
            }

            //Walk up the chain until we find a parent that overrode the method.
            while (thisProto[method] === parent[method] && parent !== app.view.Component.prototype) {
                thisProto = parent;
                parent =  Object.getPrototypeOf(parent);
            }

            //Verify that we found a valid parent that implements this method
            if (!parent || parent === app.view.Component.prototype) {
                return app.logger.error("Unable to find parent of compononent " + this.name);
            }
            if (!parent[method]) {
                return app.logger.error("Unable to find method " + method + " on parent class of " + this.name);
            }

            //Finally make the parent call
            var ret = parent[method].apply(this, args);

            //Reset the last parent to step down the prototype chain
            this._lastSuperClass = resetSuper;
            //When we reach the end of the chain, also remove the method name requirement
            if (!resetSuper) {
                this._lastSuperMethod = null;
            }

            return ret;
        }
    });

    //Mix in the beforeEvents
    _.extend(app.view.Component.prototype, app.beforeEvent);

})(SUGAR.App);
