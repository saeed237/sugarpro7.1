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
    extendsFrom:'BaseeditmodalView',
    fallbackFieldTemplate: 'edit',
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on("app:view:activity:editmodal", function() {
                this.context.set('createModel',
                    app.data.createRelatedBean(app.controller.context.get('model'), null, "notes", {})
                );
                this.render();
                this.$('.modal').modal({backdrop: "static"});
                this.$('.modal').modal('show');
                this.context.get('createModel').on("error:validation", function() {
                    this.resetButton();
                }, this);
            }, this);
        }
        this.bindDataChange();
    }
  })
