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
({
    /**
     * Who is my parent
     */
    extendsFrom: 'HeaderpaneView',
    initialize: function(options) {
        app.view.invokeParent(this, {type: 'view', name: 'headerpane', method: 'initialize', args: [options]});

        this.on('render', function() {
            this.getField('save_draft_button').setDisabled();
            // this is a hacky way to add the class but it needs to be done for proper spacing
            this.getField('save_draft_button').$el.addClass('btn-group');
            this.getField('commit_button').setDisabled();
        }, this);
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this.context.on('change:selectedUser', function(model, changed) {
            //if(_.isUndefined(model.previous('selectedUser')) || model.previous('selectedUser').id !== changed.id) {
                this.title = changed.full_name;
                if (!this.disposed) this.render();
            //}
        }, this);

        this.context.on('button:print_button:click', function() {
            window.print();
        }, this);

        this.context.on('forecasts:worksheet:is_dirty', function(worksheet_type, is_dirty) {
            this.getField('save_draft_button').setDisabled(!is_dirty);
            this.getField('commit_button').setDisabled(!is_dirty);
        }, this);

        this.context.on('button:commit_button:click button:save_draft_button:click', function() {
            this.getField('save_draft_button').setDisabled(true);
            this.getField('commit_button').setDisabled(true);
        }, this);

        this.context.on('forecasts:worksheet:saved', function(totalSaved, worksheet_type, wasDraft){
            if(wasDraft === true) {
                // re-enable the commit button if we only saved a draft
                this.getField('commit_button').setDisabled(false);
            }
        }, this);

        this.context.on('forecasts:worksheet:needs_commit', function(worksheet_type) {
            this.getField('commit_button').setDisabled(false);
        }, this);

        app.view.invokeParent(this, {type: 'view', name: 'headerpane', method: 'bindDataChange'});
    },

    _renderHtml: function() {
        var user = this.context.get('selectedUser') || app.user.toJSON();
        this.title = this.title || user.full_name;

        app.view.invokeParent(this, {type: 'view', name: 'headerpane', method: '_renderHtml'});
    }
})
