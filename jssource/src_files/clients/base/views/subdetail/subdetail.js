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
 * View that displays a model pulled from the activities stream.
 * @class View.Views.SubdetailView
 * @alias SUGAR.App.layout.SubdetailView
 * @extends View.View
 */
({
    fallbackFieldTemplate: 'detail',
    events: {
        'click [data-toggle=tab]': 'closeSubdetail'
    },
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);
    },
    render: function() {
        //avoid to have an empty detail view
    },
    bindDataChange: function() {
        if (this.model) {
            this.model.on("change", function() {
                    this._render();
                }, this
            );
        }
    },
    // Delegate events
    closeSubdetail: function() {
        this.model.clear();
        $('.nav-tabs').find('li').removeClass('on');
        this.$el.empty();
    }
})
