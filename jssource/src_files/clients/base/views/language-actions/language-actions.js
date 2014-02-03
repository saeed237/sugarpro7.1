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
        'click #languageList .dropdown-menu a' : 'setLanguage'
    },
    tagName: "span",
    initialize: function(options) {
        app.events.on("app:sync:complete", this.render, this);
        app.events.on("app:login:success", this.render, this);
        app.events.on("app:logout", this.render, this);
        app.view.View.prototype.initialize.call(this, options);

        // Format the list of languages for the template
        var languages = app.lang.getAppListStrings('available_language_dom');
        this.languageList = [];
        for (var languageKey in languages) {
            if (languageKey !== "")
                this.languageList.push({
                    key: languageKey,
                    value: languages[languageKey]
                })
        }
    },
    _renderHtml: function() {
        this.isAuthenticated = app.api.isAuthenticated();
        this.currentLang = app.lang.getLanguage() || "en_us";
        app.view.View.prototype._renderHtml.call(this);
        this.$('[data-toggle="dropdown"]').dropdown();
    },
    setLanguage: function(e) {
        var $li = this.$(e.currentTarget),
            langKey = $li.data("lang-key");
        app.alert.show('language', {level: 'warning', title: app.lang.getAppString('LBL_LOADING_LANGUAGE'), autoclose: false});
        app.lang.setLanguage(langKey, function() {
            app.alert.dismiss('language');
        });
    }
})
