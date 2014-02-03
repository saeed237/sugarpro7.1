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
    initialize: function(options) {
        this.index = options.meta.index;
        app.view.Layout.prototype.initialize.call(this, options);
        //set current model draggable
        this.on("render", function() {
            this.model.trigger("applyDragAndDrop");
        }, this);
        this.context.on("dashboard:collapse:fire", this.collapse, this);
    },
    /**
     * {@inheritdoc}
     * Append dashlet toolbar view based on custom_toolbar definition
     *
     * @param {Array} list of component metadata
     */
    _addComponentsFromDef: function(components) {
        if (!(this.meta.preview || this.meta.empty)) {
            var dashletDef = _.first(components),
                dashletMeta,
                dashletModule,
                toolbar = {},
                pattern = /^(LBL|TPL|NTC|MSG)_(_|[a-zA-Z0-9])*$/,
                label = this.meta.label;
            //try to get the dashlet widget metadata
            if(dashletDef.view) {
                toolbar = dashletDef.view['custom_toolbar'] || {};
                dashletMeta = app.metadata.getView(dashletDef.view.module, dashletDef.view.name || dashletDef.view.type);
                dashletModule = dashletDef.view.module ? dashletDef.view.module : null;
            } else if (dashletDef.layout) {
                toolbar = dashletDef.view['custom_toolbar'] || {};
                dashletMeta = app.metadata.getLayout(dashletDef.layout.module, dashletDef.layout.name || dashletDef.layout.type);
                dashletModule = dashletDef.layout.module ? dashletDef.layout.module : null;
            }
            if (!dashletModule && dashletDef.context && dashletDef.context.module) {
                dashletModule = dashletDef.context.module;
            }
            if (pattern.test(this.meta.label)) {
                label = app.lang.get(label, dashletModule, dashletDef.view || dashletDef.layout);
            }
            //determine whether it contains custom_toolbar or not
            if (_.isEmpty(toolbar) && dashletMeta && dashletMeta['custom_toolbar']) {
                toolbar = dashletMeta['custom_toolbar'];
            }
            if(toolbar !== "no") {
                components.push({
                    view: {
                        type: 'dashlet-toolbar',
                        label: label,
                        toolbar: toolbar
                    }
                });
            }
        }
        if (this.meta.empty) {
            this.$el.html(app.template.empty(this));
        } else {
            this.$el.html(this.template(this));
        }

        var context = this.context.parent || this.context;
        app.view.Layout.prototype._addComponentsFromDef.call(this, components, context, context.get("module"));
    },
    /**
     * {@inheritDoc}
     * Set default skipFetch as false.
     * Able to get the custom title label from the dashlet component.
     */
    createComponentFromDef: function(def, context, module) {
        //pass the parent context only to the main dashlet component
        if (def.view && !_.isUndefined(def.view.toolbar)) {
            var dashlet = _.first(this._components);
            if (_.isFunction(dashlet.getLabel)) {
                def.view.label = dashlet.getLabel();
            }
            context = dashlet.context;
        }
        //set default skipFetch as false
        var skipFetch = def.view ? def.view.skipFetch : def.layout.skipFetch;
        if (def.context && skipFetch !== false) {
            def.context.skipFetch = true;
        }
        return app.view.Layout.prototype.createComponentFromDef.call(this, def, context, module);
    },
    /**
     * Set current dashlet as invisible
     */
    setInvisible: function() {
        if (this._invisible === true) {
            return;
        }
        var comp = _.first(this._components);
        this.model.on("setMode", this.setMode, this);
        this._invisible = true;
        this.$el.addClass('hide');
        this.listenTo(comp, "render", this.unsetInvisible, this);
    },
    /**
     * Set current dashlet back as visible
     */
    unsetInvisible: function() {
        if (this._invisible !== true) {
            return;
        }
        var comp = _.first(this._components);
        comp.trigger("show");
        this._invisible = false;
        this.model.off("setMode", null, this);
        this.$el.removeClass('hide');
        this.stopListening(comp, "render");
    },
    /**
     * {@inheritdoc}
     * Place the each component to the right location
     *
     * @param comp
     * @param def
     */
    _placeComponent: function(comp, def) {
        if(this.meta.empty) {
            //add-a-dashlet component
            this.$el.append(comp.el);
        } else if(this.meta.preview) {
            //preview mode
            this.$el.addClass("preview-data");
            this.$("[data-dashlet=widget]").append(comp.el);
        } else if(def.view && !_.isUndefined(def.view.toolbar)) {
            //toolbar view
            this.$("[data-dashlet=toolbar]").append(comp.el);
        } else {
            //main dashlet component

            if(comp.triggerBefore("render") === false) {
                this.setInvisible();
            }
            this.$("[data-dashlet=widget]").append(comp.el);
        }
    },
    /**
     * Convert the dashlet setting metadata into the dashboard model data
     *
     * @param {Object} setting metadata
     * @return {Object} component metadata
     */
    setDashletMetadata: function(meta) {
        var metadata = this.model.get("metadata"),
            component = this.getCurrentComponent(metadata, this.index);

        _.each(meta, function(value, key){
            this[key] = value;
        }, component);

        this.model.set("metadata", app.utils.deepCopy(metadata), {silent: true});
        this.model.trigger("change:layout");
        //auto save
        if(this.model.mode === 'view') {
            this.model.save(null, {
                silent: true,
                //Show alerts for this request
                showAlerts: true
            });
        }
        return component;
    },
    /**
     * Retrives the seperate component metadata from the whole dashboard components
     *
     * @param {Object} metadata for all dashboard componenets
     * @param {String} tree based trace key (each digit represents the index number of the each level)
     * @return {Object} component metadata
     */
    getCurrentComponent: function(metadata, tracekey) {
        var position = tracekey.split(''),
            component = metadata.components;
        _.each(position, function(index){
            component = component.rows ? component.rows[index] : component[index];
        }, this);

        return component;
    },
    /**
     * Append the dashlet component from the setting metadata
     *
     * @param {Object} setting metadata
     */
    addDashlet: function(meta) {
        var component = this.setDashletMetadata(meta);
        var def = component.view || component.layout || component;

        this.meta.empty = false;
        this.meta.label = def.label || def.name || "";
        //clear previous dashlet
        _.each(this._components, function(component) {
            component.layout = null;
            component.dispose();
        }, this);
        this._components = [];

        if(component.context) {
            _.extend(component.context, {
                forceNew: true
            })
        }
        this.meta.components = [component];
        this._addComponentsFromDef(this.meta.components);
        this.loadData();
        this.render();
    },
    /**
     * Remove the current attached dashlet component
     */
    removeDashlet: function() {
        var metadata = this.model.get("metadata"),
            component = this.getCurrentComponent(metadata, this.index);
        _.each(component, function(value, key){
            if(key!=='width') {
                delete component[key];
            }
        }, this);
        this.model.set("metadata", app.utils.deepCopy(metadata), {silent: true});
        this.model.trigger("change:layout");
        //auto save
        if(this.model.mode === 'view') {
            this.model.save(null, {
                //Show alerts for this request
                showAlerts: true
            });
        }
        this.meta.empty = true;
        //clear previous dashlet
        _.each(this._components, function(component) {
            component.layout = null;
            component.dispose();
        }, this);
        this._components = [];
        this._addComponentsFromDef([
            {
                view: 'dashlet-cell-empty',
                context: {
                    module: 'Home',
                    skipFetch: true
                }
            }
        ]);
        this.render();
    },
    addRow: function(columns) {
        this.layout.addRow(columns);
    },
    /**
     * Refresh the dashlet
     *
     * Call dashlet's loadData to refetch the remote data
     *
     * @param {Object} options
     */
    reloadDashlet: function(options) {
        var component = _.first(this._components),
            context = component.context;
        context.resetLoadFlag();
        component.loadData(options);
    },
    /**
     * Edit current dashlet's settings
     *
     * Convert the current componenet's metadata into setting metadata
     * and then it loads its dashlet's configuration view
     *
     * @param {Window.Event}
     */
    editDashlet: function(evt) {
        var self = this,
            meta = app.utils.deepCopy(_.first(this.meta.components)),
            type = meta.layout ? "layout" : "view";
        if(_.isString(meta[type])) {
            meta[type] = {name:meta[type], config:true};
        } else {
            meta[type].config = true;
        }
        meta[type] = _.extend({}, meta[type], meta.context);

        if(meta.context) {
            meta.context.skipFetch = true;
            delete meta.context.link;
        }

        app.drawer.open({
            layout: {
                name: 'dashletconfiguration',
                components: [meta]
            },
            context: {
                model: new app.Bean(),
                forceNew: true
            }
        }, function(model) {
            if(!model) return;

            var conf = model.toJSON(),
                dash = {
                    context: {
                        module: model.get("module") || (meta.context ? meta.context.module : null),
                        link: model.get("link") || null
                    }
                };
            delete conf.config;
            if(_.isEmpty(dash.context.module) && _.isEmpty(dash.context.link)) {
                delete dash.context;
            }
            dash[type] = conf;
            self.addDashlet(dash);
        });
    },
    /**
     * Fold/Unfold the widget
     *
     * @param {Boolean} true if it needs to be collapsed
     */
    collapse: function(collapsed) {
        this.$(".dashlet-toggle > i").toggleClass("icon-chevron-down", collapsed);
        this.$(".dashlet-toggle > i").toggleClass("icon-chevron-up", !collapsed);
        this.$(".thumbnail").toggleClass("collapsed", collapsed);
        this.$("[data-dashlet=widget]").toggleClass("hide", collapsed);
    },
    /**
     * Displays current invisible dashlet when current mode is on edit/drag
     *
     * @param {String} (edit|drag|view)
     */
    setMode: function(type) {
        if (!this._invisible) {
            return;
        }
        if (type === 'edit' || type === 'drag') {
            this.show();
        } else {
            this.hide();
        }
    },
    _dispose: function() {
        this.model.off("setMode", null, this);
        this.off("render");
        this.context.off("dashboard:collapse:fire", null, this);
        app.view.Layout.prototype._dispose.call(this);
    }
})
