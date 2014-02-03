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

    /**
     * Listens to the app:view:change event and show or hide the subnav
     */
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);
        this.context.set('subnavModel', new Backbone.Model());
        this.subnavModel = this.context.get('subnavModel');
    },
    /**
     * For KBDocuments, we need to pull name from kbdocument_name when name field does not exist.
     * @private
     */
    _render: function(){
        var model = this.context.get("model");
        this.kbdocument_title = model.get("name") ? model.get("name") : model.get("kbdocument_name");
        app.view.View.prototype._render.call(this);

    },
    bindDataChange: function() {
        if (this.subnavModel) {
            this.subnavModel.on("change", this.render, this);
        }
    }

})
