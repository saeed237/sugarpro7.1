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
/**
 * Layout that provides basic functionality for toggling visibility of sub-layouts & views
 * @class View.Layouts.ToggleLayout
 */
({
    /**
     * Components to be toggled
     * Key is the name of the layout or view
     * Value is an object with icon/label if toggle buttons are to be displayed, empty object otherwise
     */
    availableToggles: {},

    /**
     * Default component to show when this layout is initialized
     */
    defaultToggle: null,

    initialize: function(options) {
        this.toggleComponents = [];
        this.componentsList = {};
        this.availableToggles = this.options.meta.available_toggles || this.availableToggles;
        this.defaultToggle = this.options.meta.default_toggle || this.defaultToggle;

        app.view.Layout.prototype.initialize.call(this, options);

        if (this.defaultToggle) {
            this.showComponent(this.defaultToggle);
        }

        this.on('toggle:showcomponent', this.showComponent, this);
    },

    /**
     * Defer rendering/appending of toggle-able components and render/append the rest
     * @param component
     */
    _placeComponent: function(component) {
        if (!_.isUndefined(this.availableToggles[component.name])) {
            this.toggleComponents.push(component);
            this.componentsList[component.name] = component;
            this._components.splice(this._components.indexOf(component), 1);
        } else {
            component.render();
            this.getContainer(component).append(component.el);
        }
    },

    /**
     * Container where the content should be placed (topmost layout element by default)
     * Override for a different container
     * @param component useful if the container is dependent on the component - not used in base implementation
     */
    getContainer: function(component) {
        return this.$el;
    },

    /**
     * Show the given component and hide the other toggle-able components
     * @param name
     */
    showComponent: function(name) {
        var oldToggle = this.currentToggle;
        if (this.componentsList[name]) {
            this.componentsList[name].render();
            this._components.push(this.componentsList[name]);
            this.getContainer(this.componentsList[name]).append(this.componentsList[name].el);
            this.componentsList[name] = null;
        }

        _.each(this.toggleComponents, function(component) {
            if (component.name === name) {
                component.show();
            } else {
                component.hide();
            }
        }, this);
        this.currentToggle = name;
        this.trigger('toggle:change', name, oldToggle);
    },

    /**
     * Clean up any components that were never rendered and added to _components
     * @private
     */
    _dispose: function() {
        _.each(this.componentsList, function(component) {
            if (component) {
                component.dispose();
            }
        });
        this.componentsList = {};
        this.toggleComponents = null;
        app.view.Layout.prototype._dispose.call(this);
    }

})
