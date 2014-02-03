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
 * Manages plugins
 *
 * This code shows how to define plugin.
 *
 * <pre><code>
 * (function(app) {
 *
 *      app.plugins.register('fast-click-highlight', ['view', 'field'], {
 *          color : "red",
 *
 *          events: {
 *              'click .fast-click-highlighted': 'onClickItem'
 *          },
 *
 *          onClickItem: function(e) {
 *              alert(1)
 *          },
 *
 *
 *          //The onAttach function will be called every time the plugin is attached to a new
 *          //component. It will be executed from the scope of the component being attached to.
 *          //Applied after the plugin has been mixed into the component
 *          onAttach: function(component, plugin) {
 *              this.on('render', function(){
 *                  this.$el.css('color', this.color); //same as plugin.color and component.$el.css
 *              });
 *          }
 *      });
 *
 * })(SUGAR.App);
 * </code></pre>
 *
 * If you want to use current plugin for view, you have to declare plugin in it.
 *
 * <pre><code>
 *    var MyView = app.view.View.extend({
 *
 *      initialize: function(options) {},
 *
 *      plugins: ['fast-click-highlight'],
 *      ...
 *
 *      or
 *
 *      $plugins: [{
 *          'fast-click-highlight': {
 *              events:{
 *                  'click article' : 'onClickItem'
 *              }
 *          }
 *      }],
 *
 *      onClickItem : function() {
 *          alert(2)
 *      }
 * </code></pre>
 *
 *
 * If you want to disable plugin, you have to use disabledPlugins property as in following example:
 *
 * <pre><code>
 *    var MyView = app.view.View.extend({
 *
 *      initialize: function(options) {},
 *
 *      disabledPlugins: ['fast-click-highlight'],
 *
 *      ...
 * </code></pre>
 *
 */
(function(app) {

    var _pluginManager = {

        plugins: {
            view : {},
            field : {},
            layout : {}
        },

        /**
         * Get plugin by name.
         * @param name String Plugin name
         * @param type String component type. (view, layout, or field)
         * @private
         */
        _get: function(name, type) {
            if (this.plugins[type] && this.plugins[type][name]) {
                return this.plugins[type][name];
            }
        },

        /**
         * Attach plugin to view.
         * @param component Component object (View, Field, or Layout)
         * @public
         */
        attach: function(component, type) {
            _.each(component.plugins, function(pluginName, o) {
                var prop = null;
                if (_.isObject(pluginName)) {
                    var n = _.keys(pluginName)[0];
                    prop = pluginName[n];
                    pluginName = n;
                }

                var p = this._get(pluginName, type);
                if (p && !this._isPluginDisabled(component, pluginName)) {
                    var events = _.extend({}, (_.isFunction(component.events)) ? component.events() : component.events, p.events);

                    _.extend(component, p);

                    if (prop) {
                        _.extend(component, prop);

                        if (prop.events) {
                            _.extend(events, prop.events);
                        }
                    }

                    component.events = events;

                    //If a plugin has an onAttach function, call it now so that the plugin can initialize
                    if (_.isFunction(p.onAttach)){
                        p.onAttach.call(component, component, p);
                    }
                }

            }, this);
        },

        /**
         * Detach plugins and call onDetach method
         * @param component Component object (View, Field, or Layout)
         * @param type ('field', 'view', or 'layout')
         * @public
         */
        detach: function(component, type) {
            _.each(component.plugins, function(name) {
                var plugin = this._get(name, type);
                if (plugin && _.isFunction(plugin.onDetach)) {
                    plugin.onDetach.call(component, component, plugin);
                }
            }, this);
        },

        /**
         * Check plugin is disabled.
         * @param component Component object
         * @param pluginName Plugin name
         * @private
         */
        _isPluginDisabled: function(component, pluginName) {
            return !!_.find(component.disabledPlugins, function(name) {
                return name === pluginName;
            });
        },

        /**
         * Register plugin.
         * @param name String Plugin name
         * @param validTypes String|Array list of component types this plugin can be applied to (view, field, layout)
         * @param plugin String Plugin object
         * @public
         */
        register: function(name, validTypes, plugin) {
            if (!_.isArray(validTypes)) {
                validTypes = [validTypes];
            }

            _.each(validTypes , function(type){
                this.plugins[type] = this.plugins[type] || {};
                this.plugins[type][name] = plugin;
            }, this);
        }
    };

    app.augment("plugins", _pluginManager, false);

})(SUGAR.App);
