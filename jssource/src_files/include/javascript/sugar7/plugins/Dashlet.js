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

(function (app) {
    app.events.on("app:init", function () {
        var sync = function (method, model, options) {
                options = app.data.parseOptionsForSync(method, model, options);
                var callbacks = app.data.getSyncCallbacks(method, model, options),
                    path = (this.dashboardModule === 'Home' || model.id) ? this.apiModule : this.apiModule + '/' + this.dashboardModule;
                app.api.records(method, path, model.attributes, options.params, callbacks);
            },
            Dashlet = app.Bean.extend({
                sync: sync,
                apiModule: 'Dashboards',
                module: 'Home'
            });

        app.plugins.register('Dashlet', 'view', {

            /**
             * Is used to generate max-height for dashlets.
             */
            rowHeight: 42,

            /**
             * Override this property if there's a need to provide custom
             * target element for max height appliance.
             *
             * @property {HTMLElement} Target element.
             */
            maxHeightTarget: '',

            onAttach: function () {
                this.on("init", function () {
                    this.dashletConfig = app.metadata.getView(this.module, this.name);
                    this.dashModel = this.layout.context.get("model");

                    var settings = _.extend({}, this.meta),
                        viewName = 'main',
                        buildGrid = false;
                    delete settings.panels;
                    delete settings.type;
                    delete settings.action;
                    delete settings.dependencies;
                    this.settings = new Dashlet(settings);
                    if (settings.module) {
                        this.model = this.context.parent.get("model");
                    }
                    if (this.meta && this.meta.config) {
                        viewName = 'config';
                        this.createMode = true;
                        this.action = 'edit';
                        this.model = this.context.parent.get("model");
                        //needed to allow the record hbs to render our settings rather than the context model
                        this.dashModel.set(settings);
                        this.dashModel.set("componentType", (this instanceof app.view.Layout) ? "layout" : "view");

                        this.settings.on("change", function(model) {
                            this.dashModel.set(model.changed);
                        }, this);
                        this.model.isNotEmpty = true;

                        this.meta.panels = this.dashletConfig.panels;
                        var templateName = this.name + '.dashlet-config';
                        this.template = app.template.getView(templateName, this.module) ||
                            app.template.getView(templateName);
                        if (!this.template) {
                            this.template = app.template.getView('dashletconfiguration-edit') || app.template.empty;
                            var originalPlugins = this.plugins;
                            this.plugins = ['GridBuilder'];
                            app.plugins.attach(this, 'view');
                            this.plugins = _.union(this.plugins, originalPlugins);
                            buildGrid = true;
                        }
                    } else if (this.meta && this.meta.preview) {
                        viewName = 'preview';
                        this.settings.module = this.module;
                        var templateName = this.name + '.dashlet-preview';
                        this.template = app.template.getView(templateName, this.module) ||
                            app.template.getView(templateName) ||
                            this.template;
                    } else {
                        this.settings.module = this.module;
                    }
                    if (this.initDashlet && _.isFunction(this.initDashlet)) {
                        this.initDashlet(viewName);
                        var height = this.calculateMaxHeight();
                        if (_.isNumber(height)) {
                            var $target = this.$(this.maxHeightTarget || this.$el);
                            $target.css('max-height', height + 'px');
                        }
                    }
                    if (buildGrid) {
                        this._buildGridsFromPanelsMetadata();
                    }
                });
            },
            /**
             * Build grid panel metadata based on panel span size
             */
            _buildGridsFromPanelsMetadata: function() {
                _.each(this.meta.panels, function (panel) {
                    // it is assumed that a field is an object but it can also be a string
                    // while working with the fields, might as well take the opportunity to check the user's ACLs for the field
                    _.each(panel.fields, function (field, index) {
                        if (_.isString(field)) {
                            panel.fields[index] = field = {name: field};
                        }
                    }, this);

                    // labels: visibility for the label
                    if (_.isUndefined(panel.labels)) {
                        panel.labels = true;
                    }

                    if (_.isFunction(this.getGridBuilder)) {
                        var options = {
                            fields:      panel.fields,
                            columns:     panel.columns,
                            labels:      panel.labels,
                            labelsOnTop: panel.labelsOnTop,
                            tabIndex:    0
                        },
                            gridResults = this.getGridBuilder(options).build();

                        panel.grid   = gridResults.grid;
                    }
                }, this);
            },

            /**
             * Default max-height is 466 and placed in css.
             *
             * @returns {Number/False/Undefined}
             */
            calculateMaxHeight: function() {
                if (!this.triggerBefore('calculateMaxHeight')) {
                    return false;
                }

                if (!this.meta.config && this.settings.has('limit')) {
                    return this.settings.get('limit') * this.rowHeight;
                }
            },
            onDetach: function() {
                this.settings.off();
                delete this.dashletConfig;
                delete this.dashModel;
            }
        });
    });
})(SUGAR.App);
