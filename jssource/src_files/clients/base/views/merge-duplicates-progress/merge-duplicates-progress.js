/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ('Company') that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ('MSA'), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

/**
 * @class View.MergeDuplicatesProgressView
 * @alias SUGAR.App.view.views.MergeDuplicatesProgressView
 * @extends View.MassupdateProgressView
 */
({
    extendsFrom: 'MassupdateProgressView',

    plugins: ['editable'],

    /**
     * {@inheritDoc}
     */
    _labelSet: {
        TITLE: 'LBL_MERGE_DUPLICATES_TITLE',
        PROGRESS_STATUS: 'TPL_MERGE_DUPLICATES_PROGRESS_STATUS',
        FAIL_TO_ATTEMPT: 'TPL_MERGE_DUPLICATES_FAIL_TO_ATTEMPT',
        FAIL: 'TPL_MERGE_DUPLICATES_FAIL'
    },

    /**
     * @property {Number} processedCount Number of processed elements.
     */
    processedCount: 0,

    /**
     * @property {Number} failsCount Number of fails.
     */
    failsCount: 0,

    /**
     * {@inheritDoc}
     */
    initLabels: function() {
        this.LABELSET = this._labelSet;
    },

    /**
     * Reset view parameters.
     */
    reset: function() {
        this.processedCount = 0;
        this.failsCount = 0;
        this.totalRecord = 0;
    },

    /**
     * {@inheritDoc}
     *
     * There are no conditions to check.
     */
    checkAvailable: function() {
        return true;
    },

    /**
     * {@inheritDoc}
     *
     * No estimate used.
     */
    getEstimate: function() {
        return 0;
    },

    /**
     * Set number of total elements for progress.
     *
     * @param {Number} total Number of total records.
     */
    setTotalRecords: function(total) {
        this.totalRecord = total;
    },

    /**
     * {@inheritDoc}
     */
    getTotalRecords: function() {
        return this.totalRecord;
    },

    /**
     * {@inheritDoc}
     */
    getRemainder: function() {
        return '';
    },

    /**
     * Setup count of processed elements.
     *
     * @param {Number} count Count of processed elements.
     */
    setProgressSize: function(count) {
        this.processedCount;
    },

    /**
     * Increments count of processed elements.
     */
    incrementProgressSize: function() {
        this.processedCount = this.processedCount + 1;
    },

    /**
     * {@inheritDoc}
     */
    getProgressSize: function() {
        return this.processedCount;
    },

    /**
     * {@inheritDoc}
     *
     * @param {Object} context Object to check errors.
     */
    checkError: function(context) {
        if (_.isUndefined(context) || _.isUndefined(context.attempt)) {
            return;
        }

        if (context.attempt === 0 ||
            context.attempt > (context.maxAllowAttempt || 3)
        ) {
            return;
        }

        app.alert.dismiss('check_error_message');
        app.alert.show('check_error_message', {
            level: 'warning',
            messages: app.lang.get(this.LABELSET['FAIL_TO_ATTEMPT'], this.module, {
                objectName: context.objectName || '',
                num: context.attempt,
                total: (context.maxAllowAttempt || 3)
            }),
            autoClose: true,
            autoCloseDelay: 8000
        });
    },

    /**
     * Handler for drawer `reset` event.
     * @return {boolean}
     */
    _onDrawerReset: function() {
        this.showProgress();
        return false;
    },

    /**
     * {@inheritDoc}
     *
     * Setup handler for drawer to prevent closing it.
     * We need it b/ the operation an be too long and in this time
     * token can be expired.
     */
    showProgress: function() {
        app.drawer.before('reset', this._onDrawerReset, this, true);
        this._super('showProgress');
    },

    /**
     * Update the progress view when the job is paused.
     * Triggers `massupdate:pause:completed` event on model.
     */
    pauseProgress: function() {
        var stopButton = this.getField('btn-stop');
        if (stopButton) {
            stopButton.setDisabled(true);
        }
        this.$holders.bar.removeClass('active');
        this.model.trigger('massupdate:pause:completed');
    },

    /**
     * Update the progress view when the job is resumed.
     * Triggers `massupdate:resume:completed` event on model.
     */
    resumeProgress: function() {
        var stopButton = this.getField('btn-stop');
        if (stopButton) {
            stopButton.setDisabled(false);
        }
        this.model.trigger('massupdate:resume:completed');
    },

    /**
     * Update the progress view when the job is stopped.
     * Triggers `massupdate:stop:completed` event on model.
     */
    stopProgress: function() {
        this.model.trigger('massupdate:stop:completed');
    },

    /**
     * {@inheritDoc}
     *
     * Dismiss alerts:
     * 1. `stop_confirmation` - confirmation on pause
     * 2. `check_error_message` - check errors status alert
     * Triggers `massupdate:end:completed` event on model.
     * Removes handler for drawer.
     */
    hideProgress: function() {
        app.drawer.offBefore('reset', this._onDrawerReset, this);
        this.hide();
        app.alert.dismiss('stop_confirmation');
        app.alert.dismiss('check_error_message');
        this.model.trigger('massupdate:end:completed');
    },

    /**
     * Called with new item is processed.
     *
     * Increments number of processed elements and
     * calls {@link View.MergeDuplicatesProgressView#updateProgress}.
     * Triggers `massupdate:item:processed:completed` event on model.
     */
    onItemProcessed: function() {
        this.incrementProgressSize();
        this.updateProgress();
        this.model.trigger('massupdate:item:processed:completed');
    },

    /**
     * Called when item go to next attemp.
     * Triggers `massupdate:item:attempt:completed` event on model.
     *
     * @param {Object} context Object that triggered event.
     */
    onNextAttept: function(context) {
        this.checkError(context);
        this.model.trigger('massupdate:item:attempt:completed');
    },

    /**
     * Called when item cannot be processed after a few attemps.
     *
     * Shows error message.
     * Triggers `massupdate:item:fail:completed` event on model.
     *
     * @param {Object} context Object that triggered event.
     */
    onItemFail: function(context) {
        this.failsCount = this.failsCount + 1;
        this.$holders.bar
            .removeClass('progress-info')
            .addClass('progress-danger');

        app.alert.dismiss('fail_message');
        app.alert.show('fail_message', {
            level: 'error',
            messages: app.lang.get(this.LABELSET['FAIL'], this.module, {
                objectName: context.objectName || ''
            }),
            autoClose: true,
            autoCloseDelay: 8000
        });
        this.model.trigger('massupdate:item:fail:completed');
    },

    /**
     * {@inheritDoc}
     *
     * Use model to listen events insted of collection.
     */
    bindDataChange: function() {
        if (!this.model) {
            return;
        }
        this.on('render', this.initHolders, this);
        this.before('start', this.checkAvailable, this, true);
        this.model.on('massupdate:always', this.updateProgress, this);
        this.model.on('massupdate:start', this.showProgress, this);
        this.model.on('massupdate:end', this.hideProgress, this);
        this.model.on('massupdate:fail', this.checkError, this);
        this.model.on('massupdate:resume', this.resumeProgress, this);
        this.model.on('massupdate:pause', this.pauseProgress, this);
        this.model.on('massupdate:stop', this.stopProgress, this);
        this.model.on('massupdate:item:processed', this.onItemProcessed, this);
        this.model.on('massupdate:item:attempt', this.onNextAttept, this);
        this.model.on('massupdate:item:fail', this.onItemFail, this);
    }
})
