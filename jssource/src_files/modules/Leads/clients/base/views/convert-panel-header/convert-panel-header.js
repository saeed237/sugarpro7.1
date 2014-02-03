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
        'click .toggle-link': 'handleToggleClick'
    },

    initialize:function (options) {
        options.meta.buttons = this.getButtons(options);
        app.view.View.prototype.initialize.call(this, options);
        this.layout.on('toggle:change', this.handleToggleChange, this);
        this.layout.on('lead:convert-dupecheck:pending', this.setDupeCheckPending, this);
        this.layout.on('lead:convert-dupecheck:complete', this.setDupeCheckResults, this);
        this.layout.on('lead:convert-panel:complete', this.handlePanelComplete, this);
        this.layout.on('lead:convert-panel:reset', this.handlePanelReset, this);
        this.layout.on('lead:convert:duplicate-selection:change', this.setAssociateButtonState, this);
        this.context.on('lead:convert:'+this.meta.module+':shown', this.handlePanelShown, this);
        this.context.on('lead:convert:'+this.meta.module+':hidden', this.handlePanelHidden, this);
        this.initializeSubTemplates();
    },

    /**
     * Return the metadata for the Associate/Reset buttons to be added to the convert panel header
     * @param options
     * @returns {Array}
     */
    getButtons: function(options) {
        return [
            {
                name: 'associate_button',
                type: 'button',
                label: this.getLabel(
                    'LBL_CONVERT_ASSOCIATE_MODULE',
                    {'moduleName': options.meta.moduleSingular}
                ),
                css_class: 'btn-primary disabled'
            },
            {
                name: 'reset_button',
                type: 'button',
                label: 'LBL_CONVERT_RESET_PANEL',
                css_class: 'btn-invisible btn-link'
            }
        ];
    },

    _render:function () {
        app.view.View.prototype._render.call(this);
        this.getField('reset_button').hide(); //initialize the Reset button to be hidden
    },

    /**
     * Compile data from the convert panel layout with some of the metadata to be used when rendering sub-templates
     * @returns {Object}
     */
    getCurrentState: function() {
        var currentState = _.extend({}, this.layout.currentState, {
            create: (this.layout.currentToggle === this.layout.TOGGLE_CREATE),
            labelModule: this.module,
            moduleInfo: {'moduleName': this.meta.moduleSingular},
            required: this.meta.required
        });

        if (_.isNumber(currentState.dupeCount)) {
            currentState.duplicateCheckResult = {'duplicateCount': currentState.dupeCount};
        }

        return currentState;
    },

    /**
     * Pull in the sub-templates to be used to render & re-render pieces of the convert header
     * Pieces of the convert header change based on various states the panel is in
     */
    initializeSubTemplates: function() {
        this.tpls = {};
        this.initial = {};

        this.tpls.title = app.template.getView(this.name + '.title', this.module);
        this.initial.title = this.tpls.title(this.getCurrentState());

        this.tpls.dupecheckPending = app.template.getView(this.name + '.dupecheck-pending', this.module);
        this.tpls.dupecheckResults = app.template.getView(this.name + '.dupecheck-results', this.module);
    },

    /**
     * Toggle the subviews based on which link was clicked
     * @param event
     */
    handleToggleClick: function(event) {
        var nextToggle = this.$(event.target).data('next-toggle');
        this.layout.trigger('toggle:showcomponent', nextToggle);
        event.stopPropagation();
    },

    /**
     * When switching between sub-views, change the appropriate header components:
     * - Title changes to reflect New vs. Select (showing New ModuleName or just ModuleName)
     * - Dupe check results are shown/hidden based on whether dupe view is shown
     * - Change the toggle link to allow the user to toggle back to the other one
     * - Enable Associate button when on create view - Enable/Disable button based on whether dupe selected on dupe view
     * @param toggle which view is now being displayed
     */
    handleToggleChange: function(toggle) {
        this.renderTitle();
        this.toggleDupeCheckResults(toggle === this.layout.TOGGLE_DUPECHECK);
        this.setSubViewToggle(toggle);
        this.setAssociateButtonState();
    },

    /**
     * When opening a panel, change the appropriate header components:
     * - Activate the header
     * - Display the subview toggle link
     * - Enable Associate button when on create view - Enable/Disable button based on whether dupe selected on dupe view
     * - Mark active indicator pointing up
     */
    handlePanelShown: function() {
        this.$('.accordion-heading').addClass('active');
        this.toggleSubViewToggle(true);
        this.setAssociateButtonState();
        this.toggleActiveIndicator(true);
    },

    /**
     * When hiding a panel, change the appropriate header components:
     * - Deactivate the header
     * - Hide the subview toggle link
     * - Disable the Associate button
     * - Mark active indicator pointing down
     */
    handlePanelHidden: function() {
        this.$('.accordion-heading').removeClass('active');
        this.toggleSubViewToggle(false);
        this.setAssociateButtonState(false);
        this.toggleActiveIndicator(false);
    },

    /**
     * When a panel has been marked complete, change the appropriate header components:
     * - Mark the step circle as check box
     * - Title changes to show the record associated
     * - Hide duplicate check results
     * - Hide the subview toggle link
     * - Switch to Reset button
     */
    handlePanelComplete: function() {
        this.setStepCircle(true);
        this.renderTitle();
        this.toggleDupeCheckResults(false);
        this.toggleSubViewToggle(false);
        this.toggleButtons(true);
    },

    /**
     * When a panel has been reset, change the appropriate header components:
     * - Mark the step circle back to step number
     * - Title changes back to incomplete (showing New ModuleName or just ModuleName)
     * - Show duplicate check count (if any found)
     * - Switch to back to Associate button
     * - Enable Associate button when on create view - Enable/Disable button based on whether dupe selected on dupe view
     */
    handlePanelReset: function() {
        this.setStepCircle(false);
        this.renderTitle();
        this.toggleDupeCheckResults(true);
        this.toggleButtons(false);
        this.setAssociateButtonState();
    },

    /**
     * Switch between check mark and step number
     * @param complete
     */
    setStepCircle: function(complete) {
        var $stepCircle = this.$('.step-circle');
        if (complete) {
            $stepCircle.addClass('complete');
        } else {
            $stepCircle.removeClass('complete');
        }
    },

    /**
     * Render the title based on current state Create vs DupeCheck and Complete vs. Incomplete
     */
    renderTitle: function() {
        this.$('.title').html(this.tpls.title(this.getCurrentState()));
    },

    /**
     * Put up "Searching for duplicates" message
     */
    setDupeCheckPending: function() {
        this.renderDupeCheckResults('pending');
    },

    /**
     * Display duplicate results (if any found) or hide subview links if none found
     * @param duplicateCount
     */
    setDupeCheckResults: function(duplicateCount) {
        if (duplicateCount > 0) {
            this.renderDupeCheckResults('results');
        } else {
            this.renderDupeCheckResults('clear');
            this.toggleSubViewLink('dupecheck', false);
            this.toggleSubViewLink('create', false);
        }
    },

    /**
     * Render either dupe check results or pending (or empty if no dupes found)
     * @param type
     */
    renderDupeCheckResults: function(type) {
        var results = '';
        if (type === 'results') {
            results = this.tpls.dupecheckResults(this.getCurrentState());
        } else if (type === 'pending') {
            results = this.tpls.dupecheckPending(this.getCurrentState())
        }
        this.$('.dupecheck-results').text(results);
    },

    /**
     * Show/hide dupe check results
     * @param show
     */
    toggleDupeCheckResults: function(show) {
        this.$('.dupecheck-results').toggle(show);
    },

    /**
     * Show/hide the subview toggle links altogether
     * @param show
     */
    toggleSubViewToggle: function(show) {
        //if panel is complete - don't show the subview toggle
        if (this.layout.currentState.complete) {
            show = false
        }
        this.$('.subview-toggle').toggleClass('hide', !show);
    },

    /**
     * Show/hide appropriate toggle link for the subview being displayed
     * @param nextToggle
     */
    setSubViewToggle: function(nextToggle) {
        _.each(['dupecheck', 'create'], function(currentToggle) {
            this.toggleSubViewLink(currentToggle, (nextToggle === currentToggle));
        }, this);
    },

    /**
     * Show/hide a single subview toggle link
     * @param currentToggle
     * @param show
     */
    toggleSubViewLink: function(currentToggle, show) {
        this.$('.subview-toggle .' + currentToggle).toggle(show);
    },

    /**
     * Toggle between Associate and Reset buttons
     * @param complete
     */
    toggleButtons: function(complete) {
        var associateButton = 'associate_button',
            resetButton = 'reset_button'
        if (complete) {
            this.getField(associateButton).hide();
            this.getField(resetButton).show();
        } else {
            this.getField(associateButton).show();
            this.getField(resetButton).hide();
        }
    },

    /**
     * Activate/Deactivate the Associate button based on which subview is active
     * and whether the panel itself is active (keep disabled when panel not active)
     * @param activate
     */
    setAssociateButtonState: function(activate) {
        var $associateButton = this.$('[name="associate_button"]'),
            panelActive = this.$('.accordion-heading').hasClass('active');

        //use current state to determine activate if not explicit in call
        if (_.isUndefined(activate)) {
            if (this.layout.currentToggle === this.layout.TOGGLE_CREATE) {
                activate = true;
            } else {
                activate = this.layout.currentState.dupeSelected;
            }
        }

        //only activate if current panel is active
        if (activate && panelActive) {
            $associateButton.removeClass('disabled');
        } else {
            $associateButton.addClass('disabled');
        }
    },

    /**
     * Toggle the active indicator up/down
     * @param active
     */
    toggleActiveIndicator: function(active) {
        var $activeIndicator = this.$('.active-indicator i');
        $activeIndicator.toggleClass('icon-chevron-up', active);
        $activeIndicator.toggleClass('icon-chevron-down', !active);
    },

    /**
     * Get translated strings from the Leads module language file
     * @param key
     * @param context
     * @returns {*}
     */
    getLabel: function(key, context) {
        return app.lang.get(key, 'Leads', context);
    }
})
