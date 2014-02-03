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
    tagName: "ul",
    className: "dashlets row-fluid",
    bindDataChange: function() {
        if(this.model) {
            this.model.on("change:metadata", this.setMetadata, this);
            this.model.on("change:layout", this.setWidth, this);
            this.model.on("applyDragAndDrop", this.applyDragAndDrop, this);
            this.model.on("setMode", function(mode) {
                this.model._previousMode = this.model.mode;
                this.model.mode = mode;
            }, this);
            this.model.trigger('setMode', this.context.get("create") ? 'edit' : 'view');
        }
    },
    /**
     * Relace all components based on the dashboard metadata value
     */
    setMetadata: function() {
        if(!this.model.get("metadata")) return;
        //Clean all components
        _.each(this._components, function(component) {
            component.dispose();
        }, this);
        this._components = [];
        this.$el.children().remove();

        var components = app.utils.deepCopy(this.model.get("metadata")).components;
        _.each(components, function(component, index) {
            this._addComponentsFromDef([{
                layout: {
                    type: 'dashlet-row',
                    width: component.width,
                    components: component.rows,
                    index: index + ''
                }
            }]);
        } , this);
        this.loadData();
        this.render();
    },
    /**
     * Set current main layout's width proportion
     */
    setWidth: function() {
        var metadata = this.model.get("metadata"),
            $el = this.$el.children();

        _.each(metadata.components, function(component, index){
            $el.get(index).className = $el.get(index).className.replace(/span\d+\s*/, '');
            $($el.get(index)).addClass("span" + component.width);
        }, this);
    },
    /**
     * Set all appended dashlets drag-and-droppable
     */
    applyDragAndDrop: function() {
        var self = this;
        this.$('.widget:not(.empty)').draggable({
            revert: 'invalid',
            handle: 'h4',
            scroll: true,
            scrollSensitivity: 100, //pixel
            appendTo: this.$el,
            start: function(event, ui) {
                $(this).css({visibility: 'hidden'});
                self.model.trigger("setMode", "drag");
            },
            stop: function() {
                self.model.trigger("setMode", self.model._previousMode);
                self.$(".widget.ui-draggable").attr("style", "");
            },
            helper: function() {
                var $clone = $(this).clone();
                $clone
                    .addClass('helper')
                    .css({opacity: 0.8})
                    .width($(this).width());
                $clone.find('.btn-toolbar').remove();
                return $clone;
            }
        });

        this.$('.widget-container').droppable({
            activeClass: 'ui-droppable-active',
            hoverClass: 'active',
            tolerance: 'pointer',
            accept: function($el) {
                return !$el.hasClass("sortable") && self.$(this).find('.widget[data-action=droppable]').length === 1;
            },
            drop: function(event, ui) {
                var sourceIndex = ui.draggable.parents(".widget-container:first").data('index')(),
                    targetIndex = self.$(this).data('index')();
                self.switchComponent(targetIndex, sourceIndex);
            }
        });
    },
    /**
     * Retrives the seperate component metadata from the whole dashboard components
     *
     * @param {Object} metadata for all dashboard componenets
     * @param {String} tree based trace key (each digit represents the index number of the each level)
     * @return {Object} component metadata and its dashlet frame layout
     */
    getCurrentComponent: function(metadata, tracekey) {
        var position = tracekey.split(''),
            component = metadata.components;
        _.each(position, function(index){
            component = component.rows ? component.rows[index] : component[index];
        }, this);

        var layout = this;
        _.each(position, function(index){
            layout = layout._components[index];
        }, this);
        return {
            metadata: component,
            layout: layout
        };
    },
    /**
     * Switch the between two components
     *
     * @param {String} target key
     * @param {String} source key
     */
    switchComponent: function(target, source) {
        if (target === source) {
            return;
        }
        var metadata = this.model.get("metadata");
        var targetComponent = this.getCurrentComponent(metadata, target),
            sourceComponent = this.getCurrentComponent(metadata, source);

        //Swap the metadata except 'width' property since it's previous size
        var cloneMeta = app.utils.deepCopy(targetComponent.metadata);
        _.each(targetComponent.metadata, function(value, key) {
            if(key !== 'width') {
                delete targetComponent.metadata[key];
            }
        }, this);
        _.each(sourceComponent.metadata, function(value, key) {
            if(key !== 'width') {
                targetComponent.metadata[key] = value;
                delete sourceComponent.metadata[key];
            }
        }, this);
        _.each(cloneMeta, function(value, key) {
            if(key !== 'width') {
                sourceComponent.metadata[key] = value;
            }
        }, this);

        this.model.set("metadata", app.utils.deepCopy(metadata), {silent: true});
        this.model.trigger("change:layout");
        if(this.model._previousMode === 'view') {
            //Autosave for view mode
            this.model.save(null, {
                //Show alerts for this request
                showAlerts: true
            });
        }
        //Swap the view components
        var targetDashlet = targetComponent.layout._components.splice(0),
            sourceDashlet = sourceComponent.layout._components.splice(0);

        //switch the metadata
        var targetMeta = app.utils.deepCopy(targetComponent.layout.meta),
            sourceMeta = app.utils.deepCopy(sourceComponent.layout.meta);
        targetComponent.layout.meta = sourceMeta;
        sourceComponent.layout.meta = targetMeta;

        _.each(targetDashlet, function(comp) {
            sourceComponent.layout._components.push(comp);
            comp.layout = sourceComponent.layout;
        }, this);
        _.each(sourceDashlet, function(comp) {
            targetComponent.layout._components.push(comp);
            comp.layout = targetComponent.layout;
        }, this);
        //switch invisibility
        var targetInvisible = targetComponent.layout._invisible,
            sourceInvisible = sourceComponent.layout._invisible;
        if(targetInvisible) {
            sourceComponent.layout.setInvisible();
        } else {
            sourceComponent.layout.unsetInvisible();
        }
        if(sourceInvisible) {
            targetComponent.layout.setInvisible();
        } else {
            targetComponent.layout.unsetInvisible();
        }

        //Swap the DOM
        var cloneEl = targetComponent.layout.$el.children(":first").get(0);
        targetComponent.layout.$el.append(sourceComponent.layout.$el.children(":not(.helper)").get(0));
        sourceComponent.layout.$el.append(cloneEl);

    },
    _dispose: function() {
        this.$('.widget').draggable('destroy');
        this.$('.widget-container').droppable('destroy');
        app.view.Layout.prototype._dispose.call(this);
    }
})
