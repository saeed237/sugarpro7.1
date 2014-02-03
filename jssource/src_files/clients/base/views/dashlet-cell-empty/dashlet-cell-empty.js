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
        'click .widget.empty' : 'addClicked'
    },
    originalTemplate: null,
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);
        //use the dashboard model rather than the current page's
        this.model = this.layout.context.get("model");

        this.model.on("setMode", this.setMode, this);
        this.originalTemplate = this.template;
        this.setMode(this.model.mode);
    },
    addClicked: function(evt) {
        var self = this;
        app.drawer.open({
            layout: 'dashletselect',
            context: this.layout.context
        }, function(model) {
            if(!model) return;
            var conf = model.toJSON(),
                dash = {
                    context: {
                        module: model.get("module"),
                        link: model.get("link")
                    }
                },
                type = conf.componentType;
            delete conf.config;
            delete conf.componentType;
            if(_.isEmpty(dash.context.module) && _.isEmpty(dash.context.link)) {
                delete dash.context;
            }
            dash[type] = conf;
            self.layout.addDashlet(dash);
        });
    },
    setMode: function(type) {
        if(type === 'edit') {
            this.template = this.originalTemplate;
        } else if(type === 'drag') {
            this.template = app.template.getView(this.name + '.drop') || this.originalTemplate;
        } else {
            this.template = app.template.getView(this.name + '.empty') || app.template.empty;
        }
        this.render();
    },
    _dispose: function() {
        this.model.off("setMode", null, this);
        app.view.View.prototype._dispose.call(this);
    }
})
