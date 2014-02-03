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
        'click #tour': 'showTutorial',
        'click #feedback': 'feedback',
        'click #support': 'support',
        'click #help': 'help'
    },
    tagName: 'span',
    handleViewChange: function(layout, params) {
        var module = params && params.module ? params.module : null;
        if (app.tutorial.hasTutorial(layout, module)) {
            this.enableTourButton();
        } else {
            this.disableTourButton();
        }
    },
    handleRouteChange: function(route, params) {
        this.routeParams = {'route': route, 'params': params};
    },
    enableTourButton: function() {
        this.$('#tour').removeClass('disabled');
        this.events['click #tour'] = 'showTutorial';
        this.undelegateEvents();
        this.delegateEvents();
    },
    disableTourButton: function() {
        this.$('#tour').addClass('disabled');
        delete this.events['click #tour'];
        this.undelegateEvents();
        this.delegateEvents();
    },
    initialize: function(options) {

        app.view.View.prototype.initialize.call(this, options);
        app.events.on('app:view:change', this.handleViewChange, this);
        var self = this;
        app.utils.doWhen(function() {
            return !_.isUndefined(app.router)
        }, function() {
            self.listenTo(app.router, 'route', self.handleRouteChange);
        });

    },
    _renderHtml: function() {
        this.isAuthenticated = app.api.isAuthenticated();
        app.view.View.prototype._renderHtml.call(this);
    },
    feedback: function() {
        window.open('http://www.sugarcrm.com/sugar7survey', '_blank');
    },
    support: function() {
        window.open('http://support.sugarcrm.com', '_blank');
    },
    help: function() {
        var serverInfo = app.metadata.getServerInfo();
        var lang = app.lang.getLanguage();
        var module = app.controller.context.get('module');
        var route = this.routeParams.route;
        var url = 'http://www.sugarcrm.com/crm/product_doc.php?edition=' + serverInfo.flavor + '&version=' + serverInfo.version + '&lang=' + lang + '&module=' + module + '&route=' + route;
        if (route == 'bwc') {
            var action = window.location.hash.match(/#bwc.*action=(\w*)/i);
            if (action && !_.isUndefined(action[1])) {
                url += '&action=' + action[1];
            }
        }
        app.logger.info("help URL: " + url);
        window.open(url);
    },
    showTutorial: function() {
        app.tutorial.resetPrefs();
        app.tutorial.show(app.controller.context.get('layout'), {module: app.controller.context.get('module')});
    }
})

