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
     * User Locale wizard page for the FirstLoginWizard
     * @class View.Views.UserLocaleWizardPageView
     * @alias SUGAR.App.view.views.UserLocaleWizardPageView
     */
    extendsFrom: "UserWizardPageView",
    TIME_ZONE_KEY: 'timezone',
    TIME_PREF_KEY: 'timepref',
    DATE_PREF_KEY: 'datepref',
    NAME_FORMAT_KEY: 'default_locale_name_format',
    /**
     * @override
     * @param options
     */
    initialize: function(options) {
        var self = this;
        options.template = app.template.getView("wizard-page");
        app.view.invokeParent(self, {type: 'view', name: 'user-wizard-page', method: 'initialize', args:[options]});
        // Preset the user prefs for formats
        if (this.model) {
            this.model.set(this.TIME_ZONE_KEY, (app.user.getPreference(this.TIME_ZONE_KEY) || ''));
            this.model.set(this.TIME_PREF_KEY, (app.user.getPreference(this.TIME_PREF_KEY) || ''));
            this.model.set(this.DATE_PREF_KEY, (app.user.getPreference(this.DATE_PREF_KEY) || ''));
            this.model.set(this.NAME_FORMAT_KEY, (app.user.getPreference(this.NAME_FORMAT_KEY) || ''));
        }
    },
    _render: function(){
        var self = this;
        // Prepare the metadata so we can prefetch select2 locale options
        this._prepareFields(function() {
            if (!self.disposed) {
                self.fieldsToValidate = self._fieldsToValidate(self.meta);
                app.view.invokeParent(self, {type: 'view', name: 'user-wizard-page', method: '_render'});
            }
        });
    },
    _prepareFields: function(callback) {
        var self = this;
        app.user.loadLocale(function(localeOptions) {
            // Populate each field def of type enum with returned locale options and use user's pref as displayed
            _.each(self.meta.panels[0].fields, function(fieldDef) {
                var opts = localeOptions[fieldDef.name];
                if (opts) {
                    fieldDef.options = opts;
                }
            });
            callback();
        });
    },
    /**
     * Called before we allow user to proceed to next wizard page. Does the validation and locale update.
     * @param {Function} callback The callback to call once HTTP request is completed.
     * @override
     */
    beforeNext: function(callback) {
        this.getField("next_button").setDisabled(true);  //temporarily disable
        this.model.doValidate(this.fieldsToValidate,
            _.bind(function(isValid) {
                var self = this;
                if (isValid) {
                    var payload = this._prepareRequestPayload();
                    app.alert.show('wizardlocale', {
                        level: 'process',
                        title: app.lang.getAppString('LBL_LOADING'),
                        autoClose: false
                    });
                    // 'ut' is, historically, a special flag in user's preferences that is
                    // generally marked truthy upon timezone getting saved. It's also used
                    // to semantically represent "is the user's instance configured"
                    payload['ut'] = true;
                    app.user.updatePreferences(payload, function(err) {
                        app.alert.dismiss('wizardlocale');
                        self.updateButtons();  //re-enable buttons
                        if (err) {
                            app.logger.debug("Wizard locale update failed: " + err);
                            callback(false);
                        } else {
                            callback(true);
                        }
                    });
                } else {
                    callback(false);
                }
            }, this)
        );
    }

})
