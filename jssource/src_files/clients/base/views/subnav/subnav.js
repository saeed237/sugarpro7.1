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
    events: {
        'click [name=save_button]': 'save',
        'click [name=cancel_button]': 'cancel',
        'click [name=edit_button]': 'edit'
    },

    /**
     * Initialize the view and prepare the model with default button metadata
     * for the current layout.
     */
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);
        this.context.set('subnavModel', new Backbone.Model());
        this.subnavModel = this.context.get('subnavModel');

        $(window).on("resize.subnav", _.bind(this.resize, this));
        if (this.meta && this.meta.label) {
            this.title = app.lang.get(this.meta.label, this.context.module);
        }
        this.context.on("subnav:set:title",function(title){
            this.title = title;
            this.render();
        }, this);
    },
    /**
     * Render and push down the view below
     * @private
     */
    _render: function() {
        var next, newMarginTop;

        app.view.View.prototype._render.call(this);

        //push down the view below by the subnav height
        next = this.$el.next();
        newMarginTop = parseInt(next.css('margin-top'), 10) + this.$el.find('.subnav').height();
        next.css('margin-top', newMarginTop + 'px');
    },

    /**
     * Handle click on the save button
     */
    save: function() {
        this.context.trigger("subnav:save");
    },

    /**
     * Handle click on the cancel button
     */
    cancel: function() {
        window.history.back();
    },

    /**
     * Handle click on the edit button
     */
    edit: function() {
        app.navigate(this.context, this.model, "edit", {trigger:true});
    },

    /**
     * Only re-render the view. Do not push down the view below.
     */
    bindDataChange: function() {
        var self = this;
        if (this.meta.field) {
            this.model.on(
                "change:"+this.meta.field,
                function() {
                    self.title = self.model.get(this.meta.field);
                    self.render();
                },
                this
          );
        }
    },
    _renderHtml: function() {
        app.view.View.prototype._renderHtml.call(this);
        this.resize();
    },
    resize: function() {
        var self = this;
        //The resize event is fired many times during the resize process. We want to be sure the user has finished
        //resizing the window that's why we set a timer so the code should be executed only once
        if (self.resizeDetectTimer) {
            clearTimeout(this.resizeDetectTimer);
        }
        self.resizeDetectTimer = setTimeout(function() {
            var $el = self.$('h1');
            //Checks if the element has ellipsis
            if ($el[0].offsetWidth < $el[0].scrollWidth) {
                $el.attr({'data-original-title':$el.text(),'rel':'tooltip'}).tooltip({placement: "bottom"});
            }
            else {
                $el.removeAttr('data-original-title rel');
            }
        }, 250);
    },
    _dispose: function() {
        $(window).off("resize.subnav");
        app.view.View.prototype._dispose.call(this);
    }
})
