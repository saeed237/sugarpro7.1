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
     * The Layout Object is a definition of views and their placement on a certain 'page'.
     *
     * Use {@link View.ViewManager} to create instances of layouts.
     *
     * ###A Quick Guide for Creating a Layout Definition###
     *
     * Creating Layouts is easy, all it takes is adding the appropriate metadata file. Let's create a
     * layout called **`SampleLayout`**.
     *
     * ####The Layout File and Directory Structure####
     * Layouts are located in the **`modules/MODULE/metadata/layouts`** folder. Add a file
     * called **`SampleLayout.php`** in the folder and it should be picked up in the next
     * metadata sync call.
     *
     * ####The Metadata####
     * <pre><code>
     * $viewdefs['MODULE']['PLATFORM (portal / mobile / base)']['layout']['samplelayout'] = array(
     *     'type' => 'columns',
     *     'components' => array(
     *         0 => array(
     *             'layout' => array(
     *             'type' => 'column',
     *             'components' => array(
     *                 array(
     *                     'view' => 'list',
     *                 ),
     *                 array(
     *                     'view' => 'list',
     *                     'context' => array(
     *                         'module' => 'Leads',
     *                     ),
     *                 ),
     *             ),
     *         ),
     *     ),
     * );
     * </code></pre>
     *
     * As you can see we are defining a column style layout with two subcomponents: A normal list view
     * of the MODULE, and also a list view of Leads.
     *
     * ####Accessing the New Layout####
     * The last step is to add a route in the Router to display the new layout. // TODO: Custom routes?
     *
     *
     * @class View.Layout
     * @alias SUGAR.App.view.Layout
     * @extends View.Component
     */
    app.view.Layout = app.view.Component.extend({

        /**
         * TODO docs (describe constructor options, see Component class for an example).
         *
         * @constructor
         * @param options
         */
        initialize: function(options) {
            app.plugins.attach(this, "layout");
            app.view.Component.prototype.initialize.call(this, options);

            this._components = [];

            if (!this.meta) return;

            this.type = this.meta.type || this.options.type;
            /**
             * Layout Name.
             * @type {*|string}
             */
            this.name = this.meta.name || this.options.name || this.type || "";

            /**
             * Layout Label.
             * @type {*|string}
             */
            if (this.meta.label) {
                this.label = this.meta.label;
            } else if (this.options.def && this.options.def.label) {
                this.label = this.options.def.label;
            } else if (this.options.label) {
                this.label = this.options.label;
            } else {
                this.label = '';
            }

            this.template = app.template.getLayout(this.name, this.module) ||
                            app.template.getLayout(this.type, this.module) ||
                            app.template.getLayout(this.name) ||
                            app.template.getLayout(this.type);
            if (this.template) {
                this.$el.html(this.template(this, options));
            }

            /**
             * Reference to the parent layout instance.
             * @property {View.Layout}
             */
            this.layout = this.options.layout;

            this._addComponentsFromDef(this.meta.components);
            this.trigger("init");

            app.events.on('app:locale:change', function() {
                this.render();
            }, this);
        },

        /**
         *
         * @param def array metadata defining this component
         * @param context default context to pass to the new component (unless overriden by the metadata)
         * @param module defualt module to create this component from (unless overriden by the metadata)
         * @return {*}
         */
        createComponentFromDef: function(def, context, module){
            context = context || this.context;
            module = module || this.module;

            // Switch context if necessary
            if (def.context) {
                if (def.context instanceof app.Context){
                    context = def.context;
                }
                else {
                    context = context.getChildContext(def.context);
                    context.prepare();
                }
                module = context.get("module");
            }

            // Layouts/Views can either by referenced by name or have metadata defined inline
            if (def.view) {
                if (_.isString(def.view)) {
                    return app.view.createView({
                        context:context,
                        name:def.view,
                        module:module,
                        primary:def.primary,
                        layout:this
                    });
                } else if (_.isObject(def.view)) {
                    //Inline definition of a sublayout
                    return app.view.createView({
                        context:context,
                        module:module,
                        meta:def.view.meta || def.view,
                        name:def.view.name || def.view.type || "",
                        primary:def.view.primary,
                        layout:this
                    });
                }
            }
            else if (def.layout) {
                if (_.isString(def.layout)) {
                    return app.view.createLayout({
                        context: context,
                        name: def.layout,
                        def: def,
                        module: module,
                        layout: this
                    });
                } else if (_.isObject(def.layout)) {
                    //Inline definition of a sublayout
                    return app.view.createLayout({
                        context: context,
                        module: module,
                        meta: def.layout.meta || def.layout,
                        name: def.layout.name || def.layout.type || "",
                        def: def,
                        layout: this
                    });
                }
            }
            else {
                app.logger.warn("Invalid layout definition:\n" + def.layout);
            }
        },

        _addComponentsFromDef: function(components, context, module) {
            _.each(components || {}, function(def) {
                if (def.view || def.layout) {
                    this.addComponent(this.createComponentFromDef(def, context, module), def);
                }
            }, this);
        },

        /**
         * Adds a component to this layout.
         * @param {View.Layout/View.View} component Component (view or layout) to add
         * @param {Object} def Metadata definition
         */
        addComponent: function(component, def) {
            if (!component.layout) component.layout = this;
            this._components.push(component);
            this._placeComponent(component, def); // Some implementations of placeComponent require a def
        },

        /**
         * Places layout component in the DOM.
         *
         * Default implementation just appends all the components to itself.
         * Override this method to support custom placement of components.
         *
         * @param {View.View/View.Layout} component View or layout component.
         * @protected
         */
        _placeComponent: function(component) {
            this.$el.append(component.el);
        },

        /**
         * Removes a component from this layout.

         * If component is an index, remove the component at that index. Otherwise see if component is in the array.
         * @param {View.Layout/View.View/Number} component The layout or view to remove.
         */
        removeComponent: function(component) {
            var i = _.isNumber(component) ? component : this._components.indexOf(component);

            if (i > -1) {
                var removed = this._components.splice(i, 1);
                removed[0].layout = null;
            }
        },

        /**
         * Gets a component by name.
         * @param {String} name Component name.
         * @return {View.View/View.Layout} Component with the given name.
         */
        getComponent: function (name) {
            return _.find(this._components, function(component) {
                return component.name === name;
            });
        },

        /**
         * Renders all the components.
         */
        _render: function() {
            if (this._components && this._components.length > 0) {
                //default layout will pass render container divs and pass down to all its views.
                _.each(this._components, function(component) {
                    component.render();
                }, this);
            } else {
                app.logger.info("Can't render anything because the layout has no components: " + this.toString() + "\n" +
                    "Either supply metadata or override Layout.render method");
            }
            return this;
        },

        /**
         * Fetches data for layout's model or collection.
         *
         * The default implementation first calls the {@link Core.Context#loadData} method for the layout's context
         * and then iterates through the components and calls their {@link View.Component#loadData} method.
         * This method sets context's `fields` property beforehand.
         *
         * Override this method to provide custom fetch algorithm.
         * @param options(optional) Options that are passed to collection/model's fetch method.
         * * @params setFields(optional) Boolean if true, the layout will update the set of fields used on the current context
         */
        loadData: function(options, setFields) {
            setFields = _.isUndefined(setFields) ? true : setFields;
            if (setFields){
                this.context.set("fields", this.getFieldNames());
            }
            this.context.loadData(options);
            _.each(this._components, function(component) {
                component.loadData(options, component.context != this.context);
            }, this);
        },

        /**
         * Gets a list of all fields used on this layout and its sub layouts/views.
         *
         * @param {String} module(optional) Module name.
         * @return {Array} The list of fields used by this layout.
         */
        getFieldNames: function(module) {
            var fields = [];
            module = module || this.module;
            _.each(this._components, function(component) {
                if (component.module == module) {
                    fields = _.union(fields, component.getFieldNames());
                }
            }, this);

            return fields;
        },

        /**
         * Gets a hash of fields that are currently displayed on this layout.
         *
         * The hash has field names as keys and field definitions as values.
         * @param {String} module(optional) Module name.
         * @return {Object} The currently displayed fields.
         */
        getFields: function(module) {
            var fields = {};
            _.each(this._components, function(component) {
                _.extend(fields, component.getFields(module));
            });
            return fields;
        },

        /**
         * Disposes a layout.
         *
         * Disposes each of this layout's components and calls
         * {@link View.Component#_dispose} method of the base class.
         * @protected
         */
        _dispose: function() {
            app.plugins.detach(this, "layout");
            _.each(this._components, function(component) {
                component.dispose();
            });
            this._components = [];
            app.view.Component.prototype._dispose.call(this);
        },

        /**
         * Gets a string representation of this layout.
         * @return {String} String representation of this layout.
         */
        toString: function() {
            return "layout-" + (this.options.type || this.options.name) + "-" +
                app.view.Component.prototype.toString.call(this);
        }
    });

})(SUGAR.App);
