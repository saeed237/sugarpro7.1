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
     * User Profile wizard page for the FirstLoginWizard
     * @class View.Views.UserWizardPageView
     * @alias SUGAR.App.view.views.UserWizardPageView
     */
    extendsFrom: "WizardPageView",
    /**
     * @override
     * @param options
     */
    initialize: function(options){
        //Load the default wizard page template, if you want to.
        options.template = app.template.getView("wizard-page");
        app.view.invokeParent(this, {type: 'view', name: 'wizard-page', method: 'initialize', args:[options]});
        this.fieldsToValidate = this._fieldsToValidate(this.options.meta);
    },
    /**
     * @override
     * @returns {boolean}
     */
    isPageComplete: function(){
        return this.areAllRequiredFieldsNonEmpty;
    },
    /**
     * Prepares HTTP payload
     * @return {Object} Payload with fields we want to update
     * @protected
     */
    _prepareRequestPayload: function() {
        var payload = {},
            self = this,
            fields = _.keys(this.fieldsToValidate);
        _.each(fields, function(key) {
            payload[key] = self.model.get(key);
        });
        return payload;
    },
    /**
     * Called before we allow user to proceed to next wizard page. Does the validation and profile update.
     * @param {Function} callback The callback to call once HTTP request is completed.
     * @override
     */
    beforeNext: function(callback) {
        var self = this;
        this.getField("next_button").setDisabled(true); // temporarily disable
        this.model.doValidate(this.fieldsToValidate,
            _.bind(function(isValid) {
                var self = this;
                if (isValid) {
                    var payload = self._prepareRequestPayload();
                    app.alert.show('wizardprofile', {level: 'process', title: app.lang.getAppString('LBL_LOADING'), autoClose: false});
                    app.user.updateProfile(payload, function(err) {
                        app.alert.dismiss('wizardprofile');
                        self.updateButtons(); //re-enable buttons
                        if (err) {
                            app.logger.debug("Wizard profile update failed: " + err);
                            callback(false);
                        } else {
                            callback(true);
                        }
                    });
                } else {
                    callback(false);
                }
            }, self)
        );
    }

})
