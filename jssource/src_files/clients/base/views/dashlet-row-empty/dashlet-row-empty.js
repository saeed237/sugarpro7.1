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
        'click .add-dashlet' : 'layoutClicked',
        'click .add-row.empty' : 'addClicked'
    },
    originalTemplate: null,
    columnOptions: [],
    initialize: function(options) {
        app.view.View.prototype.initialize.call(this, options);
        this.model = this.layout.context.get("model");

        this.model.on("setMode", this.setMode, this);
        this.originalTemplate = this.template;
        this.setMode(this.model.mode);
        this.columnOptions = [];
        _.times(this.model.maxRowColumns, function(index) {
            var n = index + 1;
            this.columnOptions.push({
                index: n,
                label: (n > 1) ?
                    app.lang.get('LBL_DASHBOARD_ADD_' + n + '_COLUMNS', this.module) :
                    app.lang.get('LBL_DASHBOARD_ADD_' + n + '_COLUMN', this.module)
            });
        }, this);
    },
    addClicked: function(evt) {
        var self = this;
        this._addRowTimer = setTimeout(function() {
            self.addRow(1);
        }, 100);
    },
    layoutClicked: function(evt) {
        var columns = $(evt.currentTarget).data('value');
        var addRow = _.bind(this.addRow, this);
        _.delay(addRow, 0, columns);
    },
    addRow: function(columns) {
        this.layout.addRow(columns);
        if(this._addRowTimer) {
            clearTimeout(this._addRowTimer);
        }
    },
    setMode: function(model) {
        if(model === 'edit') {
            this.template = this.originalTemplate;
        } else {
            this.template = app.template.empty;
        }
        this.render();
    },
    _dispose: function() {
        this.model.off("setMode", null, this);
        app.view.View.prototype._dispose.call(this);
    }
})
