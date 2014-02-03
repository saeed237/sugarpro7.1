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

/**
 * View manager is used to create views, layouts, and fields based on optional metadata inputs.
 *
 * The view manager's factory methods (`createView`, `createLayout`, and `createField`) first checks
 * `views`, `layouts`, and `fields` hashes respectively for custom class declaration before falling back the base class.
 *
 * Note the following is deprecated in favor of putting these controllers in the sugarcrm/clients/<platform> directory, or
 * using one of the appropriate factories like `createView`, `createField`, or `createLayout`. Using either of these idioms,
 * your components will be internally namespaced by platform for you. If you do choose to use the following idiom of defining
 * your controller directly on app.view.<type>, please be forwarned that you will lose any automatic namespacing benefits and
 * possibly encounter naming collisions if you're controller names are not unique. If you must define directly, you may choose
 * to prefix your controller name by your application or platform e.g. MyappMyCustom<Type> where 'Myapp' is the platform prefix.
 *
 * Put declarations of your custom views, layouts, fields in the corresponding hash (see note above; this is deprecated):
 * <pre><code>
 * app.view.views.MyappMyCustomView = app.view.View.extend({
 *  // Put your custom logic here
 * });
 *
 * app.view.layouts.MyappMyCustomLayout = app.view.Layout.extend({
 *  // Put your custom logic here
 * });
 *
 * app.view.fields.MyappMyCustomField = app.view.Field.extend({
 *  // Put your custom logic here
 * });
 *
 * </code></pre>
 *
 *
 * @class View.ViewManager
 * @alias SUGAR.App.view
 * @singleton
 */
(function(app) {

    // Ever incrementing field ID
    var _sfId = 0;
    // A list of classes declared by _extendClass method
    var _classes = [];
    // Creates a new subclass of the given super class based on the controller definition passed.
    var _extendClass = function(cache, base, className, controller, platformNamespace) {
        var klass = null, evaledController = null;
        if (_.isObject(controller)) {
            base = _.isObject(controller.extendsFrom) ?
                controller.extendsFrom :
                    cache[platformNamespace + controller.extendsFrom] ||
                    cache[controller.extendsFrom] ||
                    base;
            klass = cache[className] = base.extend(controller);
        } else{
            klass = cache[className] = base;
        }
        _classes.push(className);

        return klass;
    };

    var _viewManager = {

        /**
         * Resets class declarations of custom components.
         */
        reset: function() {
            var className;
            for(var i = 0; i < _classes.length; ++i) {
                className = _classes[i];
                delete this.layouts[className];
                delete this.views[className];
                delete this.fields[className];
            }
            _classes = [];
        },

        /**
         * Gets ID of the last created field.
         * @return {Number} ID of the last created field.
         */
        getFieldId: function() {
            return _sfId;
        },

        /**
         * Hash of view classes.
         */
        views: {},
        /**
         * Hash of layout classes.
         */
        layouts: {},
        /**
         * Hash of field classes.
         */
        fields: {},

        /**
         * Creates an instance of a component and binds data changes to it.
         *
         * @param type Component type (`layout`, `view`, `field`).
         * @param name Component name.
         * @param params Parameters to pass to the Component's class constructor.
         * @return {View.Component} New instance of a component.
         * @private
         */
        _createComponent: function(type, name, params) {
            var Klass = this.declareComponent(type, params.type || name, params.module, params.controller, false, this._getPlatform(params));
            var component = new Klass(params);
            component.trigger("init");
            component.bindDataChange();

            return component;
        },

        /**
         * Creates an instance of a view.
         *
         * Parameters define creation rules as well as view properties.
         * The `params` hash must contain at least `name` property which is the view name.
         * Other parameters may be:
         *
         * - context: context to associate the newly created view with
         * - module: module name
         * - meta: custom metadata
         *
         * If context is not specified the controller's current context is assigned to the view (`SUGAR.App.controller.context`).
         *
         * Examples:
         *
         * * Create a list view. The view manager will use metadata for the view named 'list' defined in Contacts module.
         * The controller's current context will be set on the new view instance.
         * <pre><code>
         * var listView = app.view.createView({
         *    name: 'list',
         *    module: 'Contacts'
         * });
         * </code></pre>
         *
         * * Create a custom view class.
         *
         * Note the following is deprecated in favor of putting these controllers in the sugarcrm/clients/<platform> directory, or
         * using one of the appropriate factories like `createView`, `createField`, or `createLayout`. Using that idiom, the metadata
         * manager will declare these components and take care of namespacing by platform for you. If you do choose to use the following
         * idiom please be forwarned that you will lose any namespacing benefits and possibly encounter naming collisions!
         * <pre><code>
         * // Declare your custom view class.
         * app.view.views.MyCustomView = app.view.View.extend({  //might cause collisions if another MyCustomView!
         *  // Put your custom logic here
         * });
         * // if you must define directly on app.view.views, you may instead prefer to do:
         * app.view.views.<YOUR_PLATFORM>MyCustomView = app.view.View.extend({
         *  // Put your custom logic here
         * });
         *
         * var myCustomView = app.view.createView({
         *    name: 'myCustom'
         * });
         * </code></pre>
         *
         * * Create a view with custom metadata payload.
         * <pre><code>
         * var view = app.view.createView({
         *     name: 'detail',
         *     meta: { ... your custom metadata ... }
         * });
         * </code></pre>
         *
         * * Create a view via metadata
         * <pre><code>
         * $viewdefs['myplatform']['view']['my-record'] = array(
         *     'type' => 'record',
         *     // ... omitted for brevity
         * );
         * </code></pre>
         * In the above example, the `type` property is being used to specify to the Sidecar framework that the base record
         * view should be used as a complete "surrogate view" for the `my-record` view. Please note that this should only be
         * done if the view for which the metadata is being defined (in this case `my-record`) does not, itself, have a controller
         * defined. For example, if we had in the same directory a `my-record.js` view controller, defining the `type` property
         * would not make sense. If this property is set in said metadata, the type will be set here before creating the component.
         *
         * Please note that related to the `type` discussion above, there is a `template` property that may be used if all you need
         * is a "surrogate template" (not a fully different type). For example, if you have a controller, and metadata, but no corresponding
         * `.hbs` template file, you may wish to utilize an existing template in your viewdef using the following metadata property:
         * <pre><code>
         *     'template' => 'record',
         * </code></pre>
         * @see View.View
         * Look at {@link View.View} Particularly, the View.View#initialize and View.View#getTemplateFromMeta for more information on
         * how the `meta.template` property can be used.
         *
         * @param params view parameters
         * @return {View.View} new instance of view.
         */
        createView: function(params) {
            // context is always defined on the controller
            params.context = params.context || app.controller.context;
            params.module = params.module || params.context.get("module");
            params.meta = params.meta || app.metadata.getView(params.module, params.name);
            params.type = params.type || (params.meta && params.meta.type ? params.meta.type : (params.name || null));

            return this._createComponent("view", params.name, params);
        },

        /**
         * Creates an instance of a layout.
         *
         * Parameters define creation rules as well as layout properties.
         * The factory needs either layout name or type.
         * The layout type is retrieved either from `params` hash or layout metadata.
         *
         * Parameters may be:
         *
         * - name: layout name (list, simple, complex, etc.)
         * - context: context to associate the newly created layout with
         * - module: module name
         * - meta: custom metadata
         * - type: layout type (fluid, columns, etc.). If not specified, it is retrieved from metadata definition.
         *
         * If context is not specified the controller's current context is assigned to the layout (`SUGAR.App.controller.context`).
         *
         * Examples:
         *
         * * Create a list layout. The view manager will use metadata for the layout named 'list' defined in Contacts module.
         * The controller's current context will be set on the new layout instance.
         * <pre><code>
         * var listLayout = app.view.createLayout({
         *    name: 'list',
         *    module: 'Contacts'
         * });
         * </code></pre>
         *
         * * Create a custom layout class.
         * ** Note that following is deprecated in favor of using the `createLayout` factory or placing controller in
         * sugarcrm/clients/<platform>/layouts in which case the metadata manager will take care of namespacing your
         * controller by platform name for you (e.g. MyCustomLayout becomes app.view.layouts.MyappMyCustomLayout)
         * <pre><code>
         * // Declare your custom layout class.
         * app.view.layouts.MyCustomLayout = app.view.Layout.extend({ //might cause collisions if already a MyCustomLayout!
         *  // Put your custom logic here
         * });
         * // if you must define directly on app.view.layouts, you may instead prefer to do:
         * app.view.layouts.<YOUR_PLATFORM>MyCustomLayout = app.view.Layout.extend({
         *  // Put your custom logic here
         * });
         *
         * var myCustomLayout = app.view.createLayout({
         *    name: 'myCustom'
         * });
         * </code></pre>
         *
         * * Create a layout with custom metadata payload.
         * <pre><code>
         * var layout = app.view.createLayout({
         *     name: 'detail',
         *     meta: { ... your custom metadata ... }
         * });
         * </code></pre>
         *
         * @param params layout parameters
         * @return {View.Layout} New instance of the layout.
         */
        createLayout: function(params) {
            params.context = params.context || app.controller.context;
            params.module  = params.module || params.context.get("module");
            params.meta    = params.meta || app.metadata.getLayout(params.module, params.name);
            params.type    = params.type || (params.meta ? params.meta.type : null);

            return this._createComponent("layout", params.name || params.type, params);
        },

        /**
         * Creates an instance of a field and registers it with the parent view (`params.view`).
         *
         * The parameters define creation rules as well as field properties.
         *
         * The `params` hash must contain `def` property which is the field definition and `view`
         * property which is the reference to the parent view. For example,
         * <pre>
         * var params = {
         *    view: new Backbone.View,
         *    def: {
         *      type: 'text',
         *      name: 'first_name',
         *      label: 'LBL_FIRST_NAME'
         *    },
         *    context: optional context (if not specified, app.controller.context is used)
         *    model: optional model (if not specified, the model which is set on the context is used)
         *    meta: optional custom metadata
         *    viewName: optional view name to determine the field template (if not specified, view.name is used)
         * }
         * </pre>
         *
         * View manager queries metadata manager for field type specific metadata (templates and JS controller) unless custom metadata
         * is passed in the `params` hash.
         *
         * Note the following is deprecated in favor of placing custom field controllers in:
         * sugarcrm/clients/<platform>/fields or using the `createField` factory.
         * To create instances of custom fields, first declare its class in `app.view.fields` hash:
         * <pre><code>
         * app.view.fields.MyCustomField = app.view.Field.extend({ //might cause collision if MyCustomField already exists!
         *  // Put your custom logic here
         * });
         * // if you must define directly on app.view.fields, you may instead prefer to do:
         * app.view.fields.<YOUR_PLATFORM>MyCustomField = app.view.Field.extend({ ...
         *
         * var myCustomField = app.view.createField({
         *   view: someView,
         *   def: {
         *      type: 'myCustom',
         *      name: 'my_custom'
         *   }
         * });
         * </code></pre>
         *
         * @param params field parameters.
         * @return {View.Field} a new instance of field.
         */
        createField: function(params) {
            var type       = params.def.type;
            params.context = params.context || params.view.context || app.controller.context;
            params.model   = params.model || params.context.get("model");
            params.module  = params.module || (params.model && params.model.module ? params.model.module : params.context.get('module')) || "";
            params.meta    = params.meta || app.metadata.getField(type, params.module);
            if(params.meta && params.meta.controller) params.controller = params.meta.controller;
            params.sfId = ++_sfId;

            var field = this._createComponent("field", type, params);
            // Register new field within its parent view.
            params.view.fields[field.sfId] = field;
            return field;
        },
        _getPlatform: function(params) {
            return params.platform || (app.config && app.config.platform ? app.config.platform : 'base');
        },
         /**
         * Gets a app.view.<TYPE> controller of type field, layout, or view.
         * @param {Object} params An object literal with the following properties:
         * - type: one of: 'layout', 'view', or 'field' (required)
         * - name: the filename of the controller as a String (e.g. 'flex-list', 'record', etc.) (required)
         * - platform: the platform e.g. 'portal' will first attempt to fallback to app.config.platform then 'base' (optional)
         * - module: the module name (optional)
         * @return {Object} The controller or null if not found
         */
        _getController: function(params) {
            var c = this._getBaseComponent(params.type, params.name, params.module, params.platform);
            //Check to see if we have the module specific class; if so return that
            if(c.cache[c.moduleBasedClassName]) {
                return c.cache[c.moduleBasedClassName];
            }
            return c.baseClass;
        },
         /**
         *
         * @deprecated Please use app.view.Component._super instead.
         *
         * Wrapper around _getController that calls the specified method on controller's prototype method. Please note that it
         * is advised to only use this to call a "parent controller" from a controller that has extended the parent. If you want
         * to call "across controllers", please consider using the PluginManager instead. Although we currently support calling
         * across controllers for backwards compatibility, we will likely deprecate this functionality in the future (so any code
         * relying on this functionality will not be "future proof"!).
         * <pre>
         *     app.view.invokeParent(this, {type: 'view', name: 'flex-list', method: '_render', args:[foo,bar]});
         * </pre>
         * @param {Object} context The context to be used when we apply the method.
         * @param {Object} params An object literal with the following properties:
         * - type One of: 'layout', 'view', or 'field' (required)
         * - name The filename of the controller (e.g. 'flex-list', 'record', etc.) (required)
         * - method The name of the method to call e.g. 'initialize', '_renderHtml', etc. (required)
         * - module: the module name (optional)
         * - args: an Array of arguments to be passed through to the method being called. If not provided it will be
         * assumed that you are not passing any arguments to the method. If not supplied no arguments is assumed (optional)
         * - platform: optional platform e.g. 'portal' will first attempt to fallback to app.config.platform then 'base' (optional)
         * @return {Array/String/Object/Boolean} returns whatever is returned by the method being invoked
         */
        invokeParent: function(context, params) {
            var controller, ret, lastSuper;
            params = params || {};
            if (!context || !params.type || !params.name || !params.method || params.args && !_.isArray(params.args)) {
                app.logger.error("view-manager's invoke method requires a context, params.type, params.name, params.method; if params.args is supplied it must be of type array.");
            }
            controller = this._getController(params);
            if (!controller) {
                return app.logger.error("invokeParent: Unable to load controller for " + params.type + ":" + params.name);
            }
            //Maintain compatability with _super
            lastSuper = context._lastSuperClass;
            context._lastSuperClass = controller.prototype;
            ret =  controller.prototype[params.method].apply(context, params.args);
            context._lastSuperClass = lastSuper;
            return ret;
        },

        /**
         * This function is used to verify if a given
         *
         * @param params {Object} set of parameters passed to function. Can contain the following values:
         * - type {String} type of component to check. Must be one of 'layout', 'view', or 'field' (required).
         * - name {String} name of component to check (required).
         * - plugin {String} name of plugin to check (required).
         * - module {String=} name of module to check for custom components in (optional).
         *
         * @return {bool|null}
         */
        componentHasPlugin : function(params) {
            var controller;
            if (!params.type || !params.name || !params.plugin) {
                app.logger.error("componentHasPlugin requires type, name, and plugin parameters");
                return null;
            }
            controller = this._getController(params);
            return controller && controller.prototype
                && _.contains(controller.prototype.plugins, params.plugin);
        },
        /**
         * Retrieves class declaration for a component or creates a new component class.
         *
         * This method creates a subclass of the base class if controller parameter is not null
         * and such subclass hasn't been created yet.
         * Otherwise, the method tries to retrieve the most appropriate class by searching in the following order:
         *
         * - Custom class name: `<module><component-name><component-type>`.
         * For example, for Contacts module one could have:
         * `ContactsDetailLayout`, `ContactsFluidLayout`, `ContactsListView`.
         *
         * - Class name: `<component-name><component-type>`.
         * For example: `ListLayout`, `ColumnsLayout`, `DetailView`, `IntField`.
         *
         * - Custom base class: `<capitalized-appId><component-type>`
         * For example, if `app.config.appId == 'portal'`, custom base classes would be:
         * `PortalLayout`, `PortalView`, `PortalField`.
         * Declarations of such classes must be in app.view namespace.
         * There are use cases when an app has some common component code.
         * In such cases, using custom base classes is beneficial. For example, any app may need
         * to override validation error handling for fields:
         * <pre>
         * // Assuming app.config.appId === 'portal':
         * app.view.PortalField = app.view.Field.extend({
         *      initialize: function(options) {
         *         // Call super
         *         app.view.Field.prototype.initialize.call(this, options);
         *         // Custom initialization code...
         *      },
         *
         *      handleValidationError: function (errors) {
         *        // Custom validation logic
         *      }
         * });
         * </pre>
         * Above declaration will make all field controllers extend `app.view.PortalField` instead of `app.view.Field`.
         *
         * - Base class: `<component-type>` - `Layout`, `View`, `Field`.
         *
         * Note 1. Although the view manager supports module specific fields like `ContactsIntField`,
         * the server does not provide such customization.
         *
         * Note 2. The layouts is a special case because their class name is built both from layout name
         * and layout type. One could have `ListLayout` or `ColumnsLayout` including their
         * module specific counterparts like `ContactsListView` and `ContactsColumnsLayout`.
         * The "named" class name is checked first.
         *
         * @param {String} type Lower-cased component type: layout, view, or field.
         * @param {String} name Lower-cased component name. For example, list (layout or view), bool (field).
         * @param {String} module(optional) Module name.
         * @param {String} controller(optional) Controller source code string.
         * @param {String} layoutType(optional) Layout type. For example, fluid, rows, columns.
         * @param {Boolean} overwrite(optional) Will overwrite if duplicate custom class or layout is cached. Note,
         * if no controller passed, overwrite is ignored since we can't create a meaningful component without a controller.
         * @param {String} platform The platform e.g. 'base', 'portal', etc.
         * @return {Function} Component class.
         */
        declareComponent: function(type, name, module, controller, overwrite, platform) {
            var c = this._getBaseComponent(type, name, module, platform);
            if(overwrite && controller) {
                if(c.cache[c.moduleBasedClassName]) delete c.cache[c.moduleBasedClassName];
            }
            return  c.cache[c.moduleBasedClassName] ||
                    _extendClass(c.cache, c.baseClass, c.moduleBasedClassName, controller, c.platformNamespace) ||
                    c.baseClass;
        },
        /**
         * Internal helper function for getting a component (controller). Do not call directly and instead use
         * `declareComponent` or `invokeParent`, etc., depending on your needs.
         * @param {String} type Lower-cased component type: layout, view, or field.
         * @param {String} name Lower-cased component name. For example, list (layout or view), bool (field).
         * @param {String} module(optional) Module name.
         * @param {String} platform The platform e.g. 'base', 'portal', etc.
         * @return {Object} An object literal containing cache, platform namespace, module based class name, and base class.
         * @private
         */
        _getBaseComponent: function(type, name, module, platform) {
            platform = this._getPlatform({platform:platform});
                // The type e.g. View, Field, Layout
            var ucType               = app.utils.capitalize(type),
                // The platform e.g. Base, Portal, etc.
                platformNamespace    = app.utils.capitalize(platform),
                // The component name and type concatenated e.g. ListView
                className            = app.utils.capitalizeHyphenated(name) + ucType,
                // The combination of platform, optional module, and className e.g. BaseAccountsListView
                moduleBasedClassName = platformNamespace + (module || "") + className,
                cache                = app.view[type + "s"],
                // App id and type fallback
                customBaseClassName  = app.utils.capitalize(app.config.appId) + ucType,
                // Components are now namespaced by <platform> so we must prefix className to find in cache
                // if we don't find platform-specific, than we next look in Base<className> and so on
                baseClass            = cache[platformNamespace + className] ||
                                       cache["Base" + className] ||
                                       // For backwards compatability, if they define app.view.views.MyView we should still find
                                       cache[className] ||
                                       cache["BaseBase" + ucType] ||
                                       app.view[customBaseClassName] ||
                                       app.view[ucType];
            return {
                cache: cache,
                platformNamespace: platformNamespace,
                moduleBasedClassName: moduleBasedClassName,
                baseClass: baseClass
            };
        }
    };

    app.augment("view", _viewManager, false);

})(SUGAR.App);
