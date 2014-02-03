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
    collapseDivId: 'forecast-config-accordion',

    timeperiodsTitle: '',
    timeperiodsText: '',
    scenariosTitle: '',
    scenariosText: '',
    rangesTitle: '',
    rangesText: '',
    forecastByTitle: '',
    forecastByText: '',
    wkstColumnsTitle: '',
    wkstColumnsText: '',

    selectedPanel: '',

    events: {
        'click .accordion-toggle': 'onAccordionToggleClicked'
    },

    /**
     * {@inheritdoc}
     */
    initialize: function(options) {
        app.view.Layout.prototype.initialize.call(this, options);
        var appLang = app.lang,
            forecastBy = app.metadata.getModule('Forecasts', 'config').forecast_by,
            forecastByLabels = {
                forecastByModule: appLang.getAppListStrings('moduleList')[forecastBy],
                forecastByModuleSingular: appLang.getAppListStrings('moduleListSingular')[forecastBy]
            };

        this.timeperiodsTitle = appLang.get('LBL_FORECASTS_CONFIG_TITLE_TIMEPERIODS', 'Forecasts');
        this.timeperiodsText = appLang.get('LBL_FORECASTS_CONFIG_HELP_TIMEPERIODS', 'Forecasts');
        this.scenariosTitle = appLang.get('LBL_FORECASTS_CONFIG_TITLE_SCENARIOS', 'Forecasts');
        this.scenariosText = appLang.get('LBL_FORECASTS_CONFIG_HELP_SCENARIOS', 'Forecasts', forecastByLabels);
        this.rangesTitle = appLang.get('LBL_FORECASTS_CONFIG_TITLE_RANGES', 'Forecasts');
        this.rangesText = appLang.get('LBL_FORECASTS_CONFIG_HELP_RANGES', 'Forecasts', forecastByLabels);
        this.forecastByTitle = appLang.get('LBL_FORECASTS_CONFIG_HOWTO_TITLE_FORECAST_BY', 'Forecasts');
        this.forecastByText = appLang.get('LBL_FORECASTS_CONFIG_HELP_FORECAST_BY', 'Forecasts');
        this.wkstColumnsTitle = appLang.get('LBL_FORECASTS_CONFIG_TITLE_WORKSHEET_COLUMNS', 'Forecasts');
        this.wkstColumnsText = appLang.get('LBL_FORECASTS_CONFIG_HELP_WORKSHEET_COLUMNS', 'Forecasts');

        // if this is the first time forecasts is being set up, add the flag to the model
        // so we can handle routing after save
        if(this.context.get('model').get('is_setup') == 0) {
            this.context.get('model').set({first_time: 1});
        }
    },

    /**
     * {@inheritdoc}
     */
    _render: function () {
        app.view.Layout.prototype._render.call(this);

        //This is because backbone injects a wrapper element.
        this.$el.addClass('accordion');
        this.$el.attr('id', this.collapseDivId);

        //apply the accordion to this layout
        this.$('.collapse').collapse({toggle:false, parent:'#' + this.collapseDivId});
        // select the first panel in metadata
        this.selectPanel(_.first(this.meta.components).view);
    },

    /**
     * Used to select a specific panel by name
     * Correct names can be found in the specific view's hbs
     * Specifically found in the id attribute of '.accordion-heading a'
     *
     * @param {String} pName
     */
    selectPanel: function(panelName) {
        this.selectedPanel = panelName;
        this.$el.find('#' + panelName + 'Collapse').collapse('show');
        // manually trigger the accordion to toggle but dont pass event so it uses the selectedPanel name
        this.onAccordionToggleClicked();
    },

    /**
     * Event handler for 'click .accordion-toggle' event
     *
     * @param {jQuery.Event|undefined} evt
     */
    onAccordionToggleClicked: function(evt) {
        var helpId = (evt) ? $(evt.currentTarget).data('help-id') : this.selectedPanel,
            data = {};

        switch(helpId) {
            case 'forecastsConfigTimeperiods':
                data.title = this.timeperiodsTitle;
                data.text = this.timeperiodsText;
                break;

            case 'forecastsConfigScenarios':
                data.title = this.scenariosTitle;
                data.text = this.scenariosText;
                break;

            case 'forecastsConfigRanges':
                data.title = this.rangesTitle;
                data.text = this.rangesText;
                break;

            case 'forecastsConfigForecastBy':
                data.title = this.forecastByTitle;
                data.text = this.forecastByText;
                break;

            case 'forecastsConfigWorksheetColumns':
                data.title = this.wkstColumnsTitle;
                data.text = this.wkstColumnsText;
                break;

        }

        this.context.set({howtoData: data});
    }
})
