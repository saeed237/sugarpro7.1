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

(function(app) {
    app.events.on("app:init", function() {
        var routes,
            homeOptions = {
                dashboard: 'dashboard',
                activities: 'activities'
            },
            getLastHomeKey = function() {
                return app.user.lastState.buildKey('last-home', 'app-header');
            };

        routes = [
            {
                name: "index",
                route: ""
            },
            {
                name: "logout",
                route: "logout/?clear=:clear"
            },
            {
                name: "logout",
                route: "logout"
            },
            {
                name: "forgotpassword",
                route: "forgotpassword",
                callback: function(){
                    app.controller.loadView({
                        module: "Forgotpassword",
                        layout: "forgotpassword",
                        create: true
                    });
                }
            },
            {
                name: "home",
                route: "Home",
                callback: function() {
                    var lastHomeKey = getLastHomeKey(),
                        lastHome = app.user.lastState.get(lastHomeKey);
                    if (lastHome === homeOptions.dashboard) {
                        app.router.list("Home");
                    } else if (lastHome === homeOptions.activities) {
                        app.router.navigate('#activities', {trigger: true});
                    }
                }
            },
            {
                name: 'about',
                route: 'about',
                callback: function() {
                    app.controller.loadView({
                        layout: 'about',
                        module: 'Home',
                        skipFetch: true
                    });
                }
            },
            {
                name: "activities",
                route: "activities",
                callback: function(){
                    //when visiting activity stream, save last state of activities
                    //so future Home routes go back to activities
                    var lastHomeKey = getLastHomeKey();
                    app.user.lastState.set(lastHomeKey, homeOptions.activities);

                    app.controller.loadView({
                        layout: "activities",
                        module: "Activities",
                        skipFetch: true
                    });
                }
            },
            {
                name: "bwc",
                route: "bwc/*url",
                callback: function(url) {
                    app.logger.debug("BWC: " + url);

                    var frame = $('#bwc-frame');
                    if (frame.length === 1 &&
                    		app.utils.rmIframeMark('index.php' + frame.get(0).contentWindow.location.search) === url
                        ) {
                        // update hash link only
                        return;
                    }

                    // if only index.php is given, redirect to Home
                    if (url === 'index.php') {
                        app.router.navigate('#Home', {trigger: true});
                        return;
                    }
                    var params = {
                        layout: 'bwc',
                        url: url
                    };
                    var module = /module=([^&]*)/.exec(url);

                    if (!_.isNull(module) && !_.isEmpty(module[1])) {
                        params.module = module[1];
                        // on BWC import we want to try and take the import module as the module
                        if (module[1] === 'Import') {
                            module = /import_module=([^&]*)/.exec(url);
                            if (!_.isNull(module) && !_.isEmpty(module[1])) {
                                params.module = module[1];
                            }
                        }
                    }

                    app.controller.loadView(params);
                }
            },
            {
                name: "sg_index",
                route: "Styleguide",
                callback: function() {
                    app.controller.loadView({
                        module: "Styleguide",
                        layout: "styleguide",
                        page_name: "home"
                    });
                }
            },
            {
                name: "sg_module",
                route: "Styleguide/:layout/:resource",
                callback: function(layout, resource) {
                    var page = '',
                        field = '';
                    if (layout === 'field') {
                        //route: "Styleguide/field/:field"
                        page = 'field';
                        field = resource;
                    } else if (layout === 'docs') {
                        //route: "Styleguide/docs/:page"
                        page = resource;
                    } else if (layout === 'layout') {
                        //route: "Styleguide/layout/records"
                        layout = resource;
                        page = 'module';
                    }
                    app.controller.loadView({
                        module: "Styleguide",
                        layout: layout,
                        page_name: page,
                        field_type: field,
                        skipFetch: true
                    });
                }
            },
            {
                name: "list",
                route: ":module"
            },
            {
                name: "create",
                route: ":module/create",
                callback: function(module) {
                    if (module === "Home") {
                        app.controller.loadView({
                            module: module,
                            layout: "record"
                        });

                        return;
                    }

                    var previousModule = app.controller.context.get("module"),
                        previousLayout = app.controller.context.get("layout");
                    if (!(previousModule === module && previousLayout === "records")) {
                        app.controller.loadView({
                            module: module,
                            layout: "records"
                        });
                    }

                    app.drawer.open({
                        layout: 'create-actions',
                        context: {
                            create: true
                        }
                    }, _.bind(function(context, model) {
                        var module = context.get("module") || model.module,
                            route = app.router.buildRoute(module);

                        app.router.navigate(route, {trigger: (model instanceof Backbone.Model)});
                    }, this));
                }
            },
            {
                name: "vcardImport",
                route: ":module/vcard-import",
                callback: function(module) {
                    app.controller.loadView({
                        module: module,
                        layout: "records"
                    });

                    app.drawer.open({
                        layout: 'vcard-import'
                    }, _.bind(function() {
                        //if drawer is closed (cancel), just put the URL back to default view for module
                        var route = app.router.buildRoute(module);
                        app.router.navigate(route, {replace: true});
                    }, this));
                }
            },
            {
                name: "layout",
                route: ":module/layout/:view"
            },
            {
                name: 'config',
                route: ':module/config',
                callback: function(module) {

                    // figure out where we need to go back to on cancel
                    var previousModule = app.controller.context.get("module"),
                        previousLayout = app.controller.context.get("layout");
                    if (!(previousModule === module && previousLayout === "records")) {
                        app.controller.loadView({
                            module: module,
                            layout: "records"
                        });
                    }

                    app.drawer.open({
                        layout: 'config',
                        context: {
                            module: module,
                            create: true
                        }
                    }, _.bind(function(context, model) {
                        var module = context.get("module") || model.module,
                            route = app.router.buildRoute(module);

                        app.router.navigate(route, {trigger: (model instanceof Backbone.Model)});
                    }, this));
                }
            },
            {
                name: "homeRecord",
                route: "Home/:id",
                callback: function(id) {
                    //when visiting a dashboard, save last state of dashboard
                    //so future Home routes go back to dashboard
                    var lastHomeKey = getLastHomeKey();
                    app.user.lastState.set(lastHomeKey, homeOptions.dashboard);

                    //then continue on with default record routing
                    app.router.record("Home", id);
                }
            },
            {
                name: "record",
                route: ":module/:id"
            },
            {
                name: "record",
                route: ":module/:id/:action"
            }
        ];

        app.routing.setRoutes(routes);
    });

    //check module access before navigating to certain routes
    //redirect to access denied page if user is lacking module access
    app.routing.before('route', function(options) {
        options = options || {};

        var checkAccessRoutes = {
                'list': 'list',
                'record': 'view',
                'create': 'create',
                'vcardImport': 'create'
            },
            route = options.route || '',
            args = options.args || [],
            module = args[0],
            accessCheck = checkAccessRoutes[route];

        if (accessCheck && !app.acl.hasAccess(accessCheck, module)) {
            app.controller.loadView({
                layout: 'access-denied'
            });
            return false;
        }

        // Check if first time login wizard should be shown
        var showWizard = false;
        if (app.user && app.user.has('show_wizard')) {
            showWizard = app.user.get('show_wizard');
            if (showWizard) {
                // If the license settings need to be input, don't show the wizard
                var system_config = app.metadata.getConfig();
                if (system_config.system_status
                    && system_config.system_status.level
                    && system_config.system_status.level == 'admin_only') {
                    showWizard = false;
                }
            }
        }
        if (showWizard) {
            var callbacks = {
                complete: function() {
                    window.location.reload(); //Reload when done
                }
            };
            app.controller.loadView({
                layout: 'first-login-wizard',
                module: 'Users',
                modelId: app.user.get('id'),
                callbacks: callbacks,
                wizardName: app.user.get('type')
            });
            $('#header').hide(); //Hide the header bar
        }
        return !showWizard;
    });

    //template language string for each page
    //i.e. records for listview, record for recordview
    var titles = {
            'records': 'TPL_BROWSER_SUGAR7_RECORDS_TITLE',
            'record': 'TPL_BROWSER_SUGAR7_RECORD_TITLE'
        },
        getTitle = function(model) {
            var context = app.controller.context,
                module = context.get("module"),
                template = Handlebars.compile(app.lang.get(titles[context.get("layout")], module) || ''),
                moduleString = app.lang.getAppListStrings('moduleList');

            //pass current translated module name and current page's model data
            return template(_.extend({
                module: moduleString[module],
                appId: app.config.appId
            }, model ? model.attributes : {}));
        },
        //set current document title with template format
        setTitle = function(model) {
            var title = getTitle(model);
            document.title = title || document.title;
        };
    //store previous view's model
    var prevModel;

    app.events.on("app:view:change", function() {
        var context = app.controller.context,
            module = context.get("module"),
            metadata = app.metadata.getModule(module),
            title;

        if (prevModel) {
            //if previous model is existed, clean out setTitle listener
            prevModel.off("change", setTitle);
        }

        if (_.isEmpty(metadata) || metadata.isBwcEnabled) {
            //For BWC module, current document title will be replaced with BWC title
            title = $('#bwc-frame').get(0) ? $('#bwc-frame').get(0).contentWindow.document.title : getTitle();
        } else {
            title = getTitle();
            if (!_.isEmpty(context.get("model"))) {
                //for record view, the title should be updated once model is fetched
                var currModel = context.get("model");
                currModel.on("change", setTitle, this);
                app.controller.layout.once("dispose", function() {
                    currModel.off("change", setTitle);
                });
                prevModel = currModel;
            }
        }
        document.title = title || document.title;
    }, this);

    var refreshExternalLogin = function() {
    	var config = app.metadata.getConfig();
        app.api.setExternalLogin(config && config['externalLogin']);
    }

    app.events.on("app:sync:complete", refreshExternalLogin, this);
    app.events.on("app:init", refreshExternalLogin, this);

    app.routing.before("route", function(o) {
        if (o && _.isArray(o.args) && o.args[0]) {
            var module = o.args[0],
                id = o.args[1],
                meta = app.metadata.getModule(module);
            if (meta && meta.isBwcEnabled) {
                var redirect = "bwc/index.php?module=" + module + "&action=index";
                if (o.route == "record" && id) {
                    redirect += "&action=DetailView&record=" + id;
                }
                app.router.navigate(redirect , {trigger: true, replace: true });
                return false;
            }
        }
        return true;
    });
})(SUGAR.App);
