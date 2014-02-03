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
     * Stores the historical log of the Forecast entries
     */
    commitLog: [],

    /**
     * Previous committed date value to display in the view
     */
    previousDateEntered: '',

    initialize: function(options) {
        app.view.Field.prototype.initialize.call(this, options);

        this.on('show', function() {
            if (!this.disposed) {
                this.render();
            }
        }, this);
    },

    bindDataChange: function() {
        this.collection.on('reset', function() {
            this.hide();
            this.buildCommitLog();
        }, this);

        this.context.on('forecast:commit_log:trigger', function() {
            if(!this.isVisible()) {
                this.show();
            } else {
                this.hide();
            }
        }, this);
    },

    /**
     * Does the heavy lifting of looping through models to build the commit history
     */
    buildCommitLog: function() {
        //Reset the history log
        this.commitLog = [];

        if(_.isEmpty(this.collection.models)) {
            return;
        }

        // get the first model so we can get the previous date entered
        var previousModel = _.first(this.collection.models);

        // parse out the previous date entered
        var dateEntered = new Date(Date.parse(previousModel.get('date_modified')));
        if (dateEntered == 'Invalid Date') {
            dateEntered = previousModel.get('date_modified');
        }
        // set the previous date entered in the users format
        this.previousDateEntered = app.date.format(dateEntered, app.user.getPreference('datepref') + ' ' + app.user.getPreference('timepref'));

        //loop through from oldest to newest to build the log correctly
        var loopPreviousModel = '';
        var models = _.clone(this.collection.models).reverse();
        _.each(models, function(model) {
            this.commitLog.push(app.utils.createHistoryLog(loopPreviousModel, model));
            loopPreviousModel = model;
        }, this);

        //reset the order of the history log for display
        this.commitLog.reverse();
    }
})
