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
     * Base View class. Use {@link View.ViewManager} to create instances of views.
     *
     * @class View.View
     * @alias SUGAR.App.view.View
     */
    app.view.View = app.view.Component.extend({

        /**
         * TODO: add docs (describe options parameter, see Component class for an example).
         * @constructor
         * @param options
         */
        initialize: function(options) {
            app.plugins.attach(this, "view");
            app.view.Component.prototype.initialize.call(this, options);

            /**
             * Name of the view (required).
             * @cfg {String}
             */
            this.name = options.name;

            /**
             * Name of the action (optional).
             *
             * Used in acl checks for user permissions. By default, set to the view name.
             * @cfg {String}
             */
            this.action = options.meta && options.meta.action ? options.meta.action : this.name;

            /**
             * Template to render (optional).
             * @cfg {Function}
             */
            this.template = options.template ||
                this.getTemplateFromMeta(options) ||
                app.template.getView(this.name, this.module) ||
                app.template.getView(this.name) ||
                (options.meta && options.meta.type ? app.template.getView(options.meta.type) : null);

            /**
             * Dictionary of field widgets.
             *
             * - keys: field IDs (sfuuid)
             * - value: instances of `app.view.Field` class
             */
            this.fields = {};

            /**
             * A template to use for view fields if a field does not have a template defined for its parent view.
             * Defaults to `"default"`.
             *
             * For example, if you have a subview and don't want to define subview template for all field types,
             * you may choose to use existing templates like `detail` if your subview is in fact a detail view.
             *
             * @property {String}
             */
            this.fallbackFieldTemplate = this.fallbackFieldTemplate || "detail";

            /**
             * Reference to the parent layout instance.
             * @property {View.Layout}
             */
            this.layout = this.options.layout;

            /**
             * Flag indicating whether a view is primary or not.
             *
             * If the primary view is not rendered due to the access control,
             * a warning message will be displayed.
             *
             * @property {Boolean}
             */
            this.primary = options.primary;

            this._setLabels();

            app.events.on('app:locale:change', function() {
                this._setLabels();
            }, this);
        },

        /**
         * Used in `initialize` above to check if metadata has `template`. If so, will return the
         * "surrogate template" from that view.
         * @param  {Object} options The options passed through from `initialize`
         * @return {Object} The view template or null
         */
        getTemplateFromMeta: function(options) {
            if(options.meta && options.meta.template) {
                return app.template.getView(options.meta.template);
            }
            return null;
        },

        /**
         * Sets template option.
         *
         * If the given option already exists it is augmented by the value of the given `option` parameter.
         * See Handlebars.js documentation for details.
         * @param {String} key Option key.
         * @param {Object} option Option value.
         */
        setTemplateOption: function(key, option) {
            this.options = this.options || {};
            this.options.templateOptions = this.options.templateOptions || {};
            this.options.templateOptions[key] = _.extend({}, this.options.templateOptions[key], option);
        },

        /**
         * Renders a view onto the page.
         *
         * This method uses `ctx` parameter as the context for the view's Handlebars {@link View.View#template}
         * and view's `options.templateOptions` property as template options.
         *
         * If no `ctx` parameter is specified, `this` is passed as the context for the template.
         * If no `options` parameter is specified, `this.options.templateOptions` is used.
         *
         * You can override this method if you have custom rendering logic and don't use Handlebars templating
         * or if you need to pass different context object for the template.
         *
         * Note the following use of app.view.View.extend is deprecated in favor of putting these controllers in the
         * sugarcrm/clients/<platform> directory. Using that idiom, the metadata manager will declare these components
         * and take care of namespacing by platform for you (so MyCustomView will be stored internally as MyappMyCustomView).
         * If you do choose to use the following idiom please be forwarned that you will lose any namespacing benefits and
         * possibly encounter naming collisions!
         *
         * Example:
         * <pre><code>
         * // Note that using the following technique of defining custom views directly on the app.view.views object
         * // can result in naming collisions unless you ensure your name is unique. See note above.
         * app.view.views.CustomView = app.view.View.extend({
         *    _renderHtml: function() {
         *       var ctx = {
         *         // Your custom context for this view template
         *       };
         *       app.view.View.prototype._renderHtml.call(this, ctx);
         *    }
         * });
         *
         * // Or totally different logic that doesn't use this.template
         * app.view.views.AnotherCustomView = app.view.View.extend({
         *    _renderHtml: function() {
         *       // Never do this :)
         *       return "&lt;div&gt;Hello, world!&lt;/div&gt;";
         *    }
         * });
         *
         *
         * </code></pre>
         *
         * This method uses this view's {@link View.View#template} property to render itself.
         * @param ctx(optional) Template context.
         * @param options(optional) Template options.
         * <pre><code>
         * {
         *    helpers: helpers,
         *    partials: partials,
         *    data: data
         * }
         * </code></pre>
         * See Handlebars.js documentation for details.
         * @protected
         */
        _renderHtml: function(ctx, options) {
            if (this.template) {
                try {
                    this.$el.html(this.template(ctx || this, options || this.options.templateOptions));
                    // See the following resources
                    // https://github.com/documentcloud/backbone/issues/310
                    // http://tbranyen.com/post/missing-jquery-events-while-rendering
                    // http://stackoverflow.com/questions/5125958/backbone-js-views-delegateevents-do-not-get-bound-sometimes
                    this.delegateEvents();
                } catch (e) {
                    app.logger.error("Failed to render " + this + "\n" + e);
                    app.error.handleRenderError(this, '_renderHtml');
                }
            }
        },

        /**
         * Renders a field.
         *
         * This method sets field's view element and invokes render on the given field.
         * @param {View.Field} field The field to render
         * @protected
         */
        _renderField: function(field) {
            field.setElement(this.$("span[sfuuid='" + field.sfId + "']"));
            try {
                field.render();
            } catch (e) {
                app.logger.error("Failed to render " + field + " on " + this + "\n" + e);
                app.error.handleRenderError(this, '_renderField', field);
            }
        },

        /**
         * Renders a view onto the page.
         *
         * The method first renders this view by calling {@link View.View#_renderHtml}
         * and then for each field invokes {@link View.View#_renderField}.
         *
         * NOTE: Do not override this method, otherwise you will loose ACL check.
         * Consider overriding {@link View.View#_renderHtml} instead.
         *
         * @return {Object} Reference to this view.
         * @private
         */
        _render: function() {
            if (app.acl.hasAccessToModel(this.action, this.model)) {
                _.each(this.fields, function(field) {
                    field.dispose();
                });
                this.fields = {};

                this._renderHtml();
                // Render will create a placeholder for sugar fields. we now need to populate those fields
                _.each(this.fields, function(field) {
                    this._renderField(field);
                }, this);
            } else {

                app.logger.info("Current user does not have access to this module view. name: " + this.name + " module:"+this.module);
                // See Bug56941.
                // We suppress this warning from being presented to user in situations where we're trying
                // to display a view for a Linked module where the user does not have access.  If you clicked on
                // a Bug and you shouldn't get warnings about Notes, etc, if you didn't have access to those other modules.
                if(this.primary){
                    app.error.handleRenderError(this, 'view_render_denied');
                }
            }

            return this;
        },

        _setLabels: function() {
            /**
             * Pluralized i18n-ed module name.
             * @property {String}
             * @member View.View
             */
            this.modulePlural = app.lang.getAppListStrings("moduleList")[this.module] || this.module;

            /**
             * Singular i18n-ed module name.
             * @property {String}
             * @member View.View
             */
            this.moduleSingular = app.lang.getAppListStrings("moduleListSingular")[this.module] || this.modulePlural;
        },

        /**
         * Fetches data for view's model or collection.
         *
         * This method calls view's context {@link Core.Context#loadData} method
         * and sets context's `fields` property beforehand.
         *
         * Override this method to provide custom fetch algorithm.
         * @param options(optional) Options that are passed to collection/model's fetch method.
         * @params setFields(optional) Boolean if true, the view will update the set of fields used on the current context
         */
        loadData: function(options, setFields) {
            // See Bug56941.
            // Lets only load the data for views where user has read access.
            // Otherwise we generate REST API errors.
            if (app.acl.hasAccess("read", this.module)) {
                setFields = _.isUndefined(setFields) ? true : setFields;
                if (setFields){
                    this.context.set("fields", this.getFieldNames());
                }
                this.context.loadData(options);
            }
        },

        /**
         * Extracts the field names from the metadata for directly related views/panels.
         * @param {String} module(optional) Module name.
         * @return {Array} List of fields used on this view
         */
        getFieldNames: function(module) {
            var fields = [];
            module = module || this.context.get('module');

            if (this.meta && this.meta.panels) {
                fields = _.reduce(_.map(this.meta.panels, function(panel) {
                    var nestedFields = _.flatten(_.compact(_.pluck(panel.fields, "fields")));
                    return _.pluck(panel.fields, 'name').concat(
                        _.pluck(nestedFields, 'name')).concat(
                        _.flatten(_.compact(_.pluck(panel.fields, 'related_fields'))));
                }), function(memo, field) {
                    return memo.concat(field);
                }, []);
            }

            fields = _.compact(_.uniq(fields));

            var fieldMetadata = app.metadata.getModule(module, 'fields');
            if (fieldMetadata) {
                // Filter out all fields that are not actual bean fields
                fields = _.reject(fields, function(name) {
                    return _.isUndefined(fieldMetadata[name]);
                });

                // we need to find the relates and add the actual id fields
                var relates = [];
                _.each(fields, function(name) {
                    if (fieldMetadata[name].type == 'relate') {
                        relates.push(fieldMetadata[name].id_name);
                    }
                    else if (fieldMetadata[name].type == 'parent') {
                        relates.push(fieldMetadata[name].id_name);
                        relates.push(fieldMetadata[name].type_name);
                    }
                });

                fields = fields.concat(relates);
            }

            return fields;
        },


        /**
         * Gets a hash of fields that are currently displayed on this view.
         *
         * The hash has field names as keys and field definitions as values.
         * @param {String} module(optional) Module name.
         * @return {Object} The currently displayed fields.
         */
        getFields: function(module) {
            var fields = {};
            var fieldNames = this.getFieldNames(module);
            _.each(this.fields, function(field) {
                if (_.include(fieldNames, field.name)) {
                    fields[field.name] = field.def;
                }
            });
            return fields;
        },

        /**
         * Returns a field by name.
         * @param {String} name Field name.
         * @return {View.Field} Instance of the field widget.
         */
        getField: function(name) {
            return _.find(this.fields, function(field) {
                return field.name == name;
            });
        },

        /**
         * Disposes a view.
         *
         * This method disposes view fields and calls
         * {@link View.Component#_dispose} method of the base class.
         * @protected
         */
        _dispose: function() {
            app.plugins.detach(this, "view");
            _.each(this.fields, function(field) {
                field.dispose();
            });
            this.fields = {};
            app.view.Component.prototype._dispose.call(this);
        },

        /**
         * Gets a string representation of this view.
         * @return {String} String representation of this view.
         */
        toString: function() {
            return "view-" + this.name + "-" + app.view.Component.prototype.toString.call(this);
        },



        getFieldMeta : function(field) {
            var ret = _.find(_.flatten(_.pluck(this.meta.panels, "fields")), function(def){
                return def.name == field;
            });
            return ret;
        },

        setFieldMeta : function(field, meta) {
            _.each(this.meta.panels, function(panel){
                _.each(panel.fields, function(def, i){
                    if (def.name == field) {
                        panel.fields[i] = _.extend(def, meta);
                    }
                })
            });
        }

    });


})(SUGAR.App);
