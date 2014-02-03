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
    // Key prefix used to identify metadata in the local storage.
    var _keyPrefix = "meta:";

    // Metadata memory cache
    var _metadata = {};

    //History of md types we have loaded
    var _mdLoaded = {};

    //Used to keep track if we are currently updating the metadata and prevent premature metadata validation from
    //interval functions.
    var _syncing = false;

    function _setHash(data, isPublic) {
        var pKey = isPublic ? "public:" : "";
        app.cache.set(_keyPrefix + pKey + "hash", data._hash);
    }

    function _cacheMeta(data) {
        app.cache.set(_keyPrefix + "data", data);
    }

    function _getCachedMeta() {
        return app.cache.get(_keyPrefix + "data");
    }

    // Adds the language strings to the server metadata object.
    // - serverMetadata Metadata from /metadata GET (public or not).
    // ** Note we take advantage of pass be reference thus no return
    // - labels Object which contains our language strings.
    function _injectLabels(serverMetadata, labels) {
        _.each(labels, function(value, key) {
            if (key !== '_hash') {
                serverMetadata[key] = labels[key];
            }
        });
        // meta.labels longer needed; don't want it in _metadata or cache!
        delete serverMetadata.labels;
    }

    // Parses the labels property of metadata which contains
    // URL to a JSON file with our language strings.
    // - metadata Metadata returned from /metadata GET
    function _fetchLabels(metadata, options) {
        var labels, currentLanguage, langStringsUrl,
            userLang = app.user.getLanguage();

        // Grab the lang strings
        labels = metadata.labels;
        // Since, at this stage, we may or may not have obtained our language yet,
        // the labels property contains a 'default' property which we can use as a fallback.
        currentLanguage = app.lang.currentLanguage = options.language ||
            (labels[userLang] ? userLang : labels['default']);

        langStringsUrl  = app.utils.buildUrl(labels[currentLanguage]);

        $.ajax( {
            url: langStringsUrl,
            timeout: options.timeout || app.api.timeout,
            success: function(labelsData) {
                // In case server is not set up to serve mime-type correctly on .json files,
                // e.g. honey-b seems to be misconfigured (probably a "popular misconfiguration")
                try {
                    labelsData = _.isString(labelsData) ? JSON.parse(labelsData) : labelsData;
                }
                catch (ex) {
                    app.logger.fatal("Failed to parse labels data: " + ex);
                    options.error({
                        code: "sync_failed",
                        label: "ERR_SYNC_FAILED"
                    });
                    return;
                }

                options.success(labelsData);
            },
            error: function(xhr, textStatus, errorThrown) {
                options.error(new SUGAR.Api.HttpError(
                    {
                        xhr: xhr,
                        params: { url: langStringsUrl }
                    },
                    textStatus,
                    errorThrown
                ));
            }
        });
    }

    // Initializes custom layouts/views templates and controllers
    function _initCustomComponents(module, moduleName) {
        var self = this,
            platforms = (app.config.platform !== 'base') ? ['base', app.config.platform] : ['base'];

        _.each({"layout": "layout", "view": "view", "fieldTemplate": "field"}, function(type, key) {

            // Order and initialize controllers. If this metadata is separated by platform, we need to
            // sort each extended type, but, also take in to consideration the "platform weighting" of
            // said type (hence, 'base' is always first platform!). Controllers are now only sent via jssource.
            if (self._metaTypeIsSeparatedByPlatform(module, key, platforms)) {
                _.each(platforms, function(platform) {
                    var components = module[key+'s'][platform];
                    self._sortAndDeclareComponents(components, type, moduleName, platform);
                });
            }

            // Next pull any templates
            _.each(module[key + 's'], function(def, name) {
                if (type === "view" && def.templates) {
                    _.each(def.templates, function(tplSource, tplName) {
                        tplName = (name === tplName) ? tplName : name + "." + tplName;
                        app.template.setView(tplName, moduleName, tplSource, true);
                    });
                }
                if (type === "layout" && def.templates) {
                    _.each(def.templates, function(tplSource, key) {
                        key = (name === key) ? key : name + "." + key;
                        app.template.setLayout(key, moduleName, tplSource, true);
                    });
                }
                if (type === "field" && def.templates) {
                    _.each(def.templates, function(template, view) {
                        app.template.setField(name, view, moduleName, template, true);
                    });
                }
            });
        }, this);
    }

    /**
     * The metadata manager is responsible for parsing and returning various metadata to components that request it.
     * @class Core.MetadataManager
     * @singleton
     * @alias SUGAR.App.metadata
     */
    app.augment("metadata", {

        /**
         * Map of fields types.
         *
         * Specifies correspondence between field types and field widget types.
         */
        fieldTypeMap: {
            varchar: "text",
            datetime: 'datetimecombo',
            multienum: "enum",
            text: "textarea",
            decimal: "float"
        },

        /**
         * Patches view fields' definitions.
         * @param moduleName Module name
         * @param module Module definition
         * @private
         */
        _patchMetadata: function(moduleName, module) {

            if (!module || module._patched === true) {
                return module;
            }

            _.each(module.views, function(view) {
                if (view.meta) {
                    _.each(view.meta.panels, function(panel) {
                        panel.fields = this._patchFields(moduleName, module, panel.fields);
                    }, this);
                }
            }, this);

            module._patched = true;
            return module;
        },

        _patchFields: function(moduleName, module, fields) {
            var self = this;
            _.each(fields, function(field, fieldIndex) {
                var name = _.isString(field) ? field : field.name;
                var fieldDef = module.fields[name];

                if (field.fields) {
                    field.fields = self._patchFields(moduleName, module, field.fields);
                    return;
                }

                if (!_.isEmpty(fieldDef)) {
                    // Create a definition if it doesn't exist
                    if (_.isString(field)) {
                        field = { name: field };
                    }

                    // Flatten out the viewdef, i.e. put 'displayParams' onto the viewdef
                    // TODO: This should be done on the server-side on my opinion

                    if (_.isObject(field.displayParams)) {
                        _.extend(field, field.displayParams);
                        delete field.displayParams;
                    }

                    // Assign type
                    field.type = field.type || fieldDef.custom_type || fieldDef.type;
                    // Patch type
                    field.type = self.fieldTypeMap[field.type] || field.type;
                    // Patch label
                    field.label = field.label || fieldDef.vname || field.name;

                    fields[fieldIndex] = field;
                }
                else {
                    // patch filler string fields to empty base fields of detail view
                    if (field === "") {
                        field = {
                            view: 'detail'
                        };
                        fields[fieldIndex] = field;
                    }
                    // Ignore view fields that don't have module field definition
                    //app.logger.warn("Field #" + fieldIndex + " '" + name + "' in " + viewName + " view of module " + moduleName + " has no vardef");
                }

            }, this);
            return fields;
        },

        /**
         * Sorts components in the order they should be declared as classes. This is required since a parent
         * widget class must likewise be declared before a child that depends on it.
         * @param {String} type Metadata type e.g. field, view. layout
         * @param  {Array} components List of modules
         * @param  {String} module Module name
         * @return {Array} Sorted components
         */
        _sortControllers : function(type, components, module) {
            var updated = {}, nameMap = {}, entries = {},
                updateWeights = function(entry){
                    var controller = entry.controller;

                    // Here we decrement the weight of any extended components. Note, that if sorting platform
                    // specific components (e.g. portal), and one "extends from" a base component, that parent
                    // will have already been declared since _sortControllers first gets called with base components
                    if (_.isObject(controller) && _.isString(controller.extendsFrom) &&
                        entries[controller.extendsFrom] && !updated[controller.extendsFrom])
                    {
                        // Negative weights as we want to load those first
                        entries[controller.extendsFrom].weight--;
                        updated[controller.extendsFrom] = true;
                        updateWeights(entries[controller.extendsFrom]);
                    }
                };

            // Start by creating a mapping from short name to final class name and precompiling all the controllers that are strings
            _.each(components, function(entry, name) {
                if (entry.controller) {
                    var controller = entry.controller,
                        className  = (module || "") + app.utils.capitalizeHyphenated(name) + app.utils.capitalize(type);

                    nameMap[className] = name;

                    if (_.isString(controller)) {
                        try {
                            controller = eval("[" + controller + "][0]");
                        } catch (e) {
                            app.logger.error("Failed to eval view controller for " + className + ": " + e + ":\n" + entry.controller);
                        }
                    }
                    entries[className] = {
                        type : name,
                        controller : controller,
                        weight: 0
                    };
                }
            });

            //Next calculate all the weights
            _.each(entries, function(entry){
                updated = {};
                updateWeights(entry);
            });

            return _.sortBy(entries, "weight");
        },

        /**
         * Helper to sort and declare components.
         * @param  {Array} components
         * @param  {String} type Type of component e.g. view, field, etc.
         * @param  {String} moduleName Name of module
         * @param  {String} platform Platform
         */
        _sortAndDeclareComponents: function(components, type, moduleName, platform) {
            var entries, self = this;

            if (!_.isUndefined(components) && components) {
                entries = self._sortControllers(type, components, moduleName);
                _.each(entries, function(entry){
                    app.view.declareComponent(type, entry.type, moduleName, entry.controller, true, platform);
                });
            }
        },
        /**
         * Helper to determine if the metadata type is separated by platforms e.g. <DATAOBJ>.views.portal.record.controller
         * @param  {Object} data The object to check.
         * @param  {String} type 'view', 'field', 'layout', etc.; will be pluralized internally
         * @param  {Array} platforms List of currently loaded platforms e.g. ['base','portal']
         * @return {Boolean} Indicating whether or not this meta type is separated by platform type
         */
        _metaTypeIsSeparatedByPlatform: function(data, type, platforms) {
            if (!_.isUndefined(data[type+'s'])) {
                // Iterate all possible platforms searching if meta type has a platform key
                for (var i=0; i<platforms.length; i++) {
                    if (!_.isUndefined(data[type+'s'][platforms[i]])) {
                        // Edge case: we have a field.base and might eventually have view.base etc.
                        // (the field is actually named 'base'!) we're instead looking for: fields.base.x.controller
                        if (_.isUndefined(data[type+'s'][platforms[i]].controller)) {
                            return true;
                        }
                    }
                }
            }
            return false;
        },
        /**
         *
         * @param data
         * @private
         */
        _declareClasses : function(data){
            // Base components are always loaded first (so ordering of the following array matters!).
            var self = this,
                platforms = (app.config.platform !== 'base') ? ['base', app.config.platform] : ['base'];

            // Our root level metadata views/fields/layouts do not have separate platforms (whereas our
            // generated jssource controllers are separated by platform). Today, only jssource has controllers.
            // Declare field, view, layout classes that have custom controllers
            _.each(["field", "view", "layout"], function(type){
                var components;

                // Our root level metadata views/fields/layouts are not separated by platforms (whereas the
                // "generated jssource controllers" are). Today, only jssource has controllers.
                if (self._metaTypeIsSeparatedByPlatform(data, type, platforms)) {
                    // Components of each platform are sorted amongst themselves. Base MUST be first (as defined in
                    // our platforms list above). This way, all base components are guaranteed to be initialized first.
                    _.each(platforms, function(platform){
                        components = data[type+'s'][platform];
                        self._sortAndDeclareComponents(components, type, null, platform);
                    }, this);
                }
            }, this);

            // Patch module metadata, compile templates, and declare components for custom layouts and views
            _.each(data.modules, function(entry, module) {
                _initCustomComponents.call(this, entry, module);
            }, this);
        },

        /**
         * Gets metadata for all modules.
         * @return {Object} Metadata for all modules.
         */
        getModules: function() {
            return _metadata.modules;
        },

        /**
         * Gets list of module names that need to be hidden in subpanels
         * @return {Object} Collection of module names that are hidden in subpanels
         */
        getHiddenSubpanels: function(){
            return _metadata.hidden_subpanels;
        },

        /**
         * Gets module metadata.
         * @param {String} module Module name.
         * @param {String} type (optional) Metadata type.
         * @return {Object} Module metadata of specific type if type is specified. Otherwise, module's overall metadata.
         */
        getModule: function(module, type) {
            var metadata = this.getModules();
            if (metadata) metadata = metadata[module];
            if (metadata && type) metadata = metadata[type];
            return metadata;
        },

        /**
         * Gets a relationship definition.
         * @param {String} name Relationship name.
         * @return {Object} Relationship metadata or nothing if not found.
         */
        getRelationship: function(name) {
            return _metadata.relationships ? _metadata.relationships[name] : null;
        },

        /**
         * Gets field widget metadata.
         * @param {Object} type Field type.
         * @return {Object} Metadata for the specified field type (falls back to `base` field).
         */
        getField: function(type) {
            // Fall back to the base field
            var metadata = _metadata.fields ? (_metadata.fields[type] || _metadata.base) : null;
            return metadata ? app.metadata.copy(metadata, { field: type }) : metadata;
        },

        /**
         * Gets view metadata.
         * @param {String} module Module name.
         * @param {String} view (optional) View name.
         * @return {Object} View metadata if view name is specified. Otherwise, metadata for all views of the given module.
         * If the optional view parameter is provided we instead return null if view for module not found.
         */
        getView: function(module, view) {
            var metadata = module ? this.getModule(module, "views") : _metadata['views'];
            if (view) {
                if (metadata && metadata[view]) {
                    metadata = metadata[view].meta;
                } else if (_metadata.views && _metadata.views[view]) {
                    metadata = _metadata.views[view].meta;
                } else {
                    metadata = null;
                }
            }
            return metadata ? app.metadata.copy(metadata, { module: module, view: view }) : metadata;
        },

        /**
         * Gets layout metadata.
         * @param {String} module Module name.
         * @param {String} layout (optional) Layout name.
         * @return {Object} Layout metadata if layout name is specified. Otherwise, metadata for all layouts of the given module.
         * If the optional layout parameter is provided we instead return null if layout for module not found.
         */
        getLayout: function(module, layout) {
            var metadata = this.getModule(module, "layouts");

            // Check to see if there is a module layout
            if (layout) {
                if (metadata && metadata[layout]) {
                    metadata = metadata[layout].meta;
                }
                else if (_metadata.layouts && _metadata.layouts[layout]) { // Look for a module non-specific layout
                    metadata = _metadata.layouts[layout].meta;
                } else {
                    metadata = null;
                }
            }
            return metadata ? app.metadata.copy(metadata, { module: module, layout: layout }) : metadata;
        },

        /**
         * Gets an array of module names.
         * @param {Boolean} visible (optional) Flag indicating if only visible modules must be included in the array.
         * @param {String} access (optional) Include only modules names the user has permission to perform this action on.
         * @return {Array} Array of module names.
         */
        getModuleNames: function(visible, access) {
            var a = (_.isObject(app.user.get('module_list')))? _.toArray(app.user.get('module_list')):[];
            if ((visible === true) && app.config && app.config.displayModules) {
                a = _.intersection(a, app.config.displayModules);
            }

            if (access) {
                a = _.filter(a, function(module) {
                    return app.acl.hasAccess(access, module);
                });
            }
            return a;
        },

        /**
         * Gets language strings for a given type.
         * @param {String} type Type of string pack: `app_strings`, `app_list_strings`, `mod_strings`.
         * @return Dictionary of strings.
         */
        getStrings: function(type) {
            return _metadata[type] || {};
        },

        /**
         * Gets FullModuleList
         * @return Full module list.
         */
        getFullModuleList: function() {
            return _metadata.full_module_list || {};
        },

        /**
         * Gets Config.
         *
         * @return Dictionary of Configs.
         */
        getConfig: function() {
            return _metadata.config || {};
        },

        /**
         * Gets the
         * @return {String}
         */
        getBaseCurrencyId: function() {
            // TODO this should be set on the _metadata
            return '-99';
        },

        /**
         * Gets a currency
         *
         * @param {String} currencyId
         * @return {Object} currency object
         */
        getCurrency: function(currencyId) {
            return this.getCurrencies()[currencyId];
        },

        /**
         * Gets currencies.
         * @return {Object} Currency dictionary.
         */
        getCurrencies: function() {
            return _metadata.currencies || {};
        },

        /**
         * Gets company logo url
         * @returns {string} logo url
         */
        getLogoUrl: function() {
            return _metadata.logo_url;
        },

        /**
         * Gets server information.
         * @return {Object} Server information.
         */
        getServerInfo: function() {
            return _metadata.server_info || {};
        },

        /**
         * Gets the module tab mapping for megamenu
         * @return {Object} Mapping of module: mappedModule
         */
        getModuleTabMap: function() {
            return _metadata.module_tab_map || {};
        },

        /**
         * Gets the mapped module name for a menu item if one exists. Otherwise
         * gets the module that was passed in.
         * @param  {String} module The module to get the mapped module for
         * @return {String}
         */
        getTabMappedModule: function(module) {
            var map = this.getModuleTabMap();
            return map[module] || module;
        },

        /**
         * Copies a metadata fragment.
         *
         * The default implementation performs deep copy. Client apps may override this behavior.
         * @param {Object} meta Metadata object to be copied.
         * @param {Object} options(optional) Options that describe the type of metadata to copy.
         * The default implementation does not use them as it always performs deep copy regardless of metadata type.
         * @returns {Object} Deep copy of metadata.
         */
        copy: function(meta, options) {
            return app.utils.deepCopy(meta);
        },

        /**
         * Sets the metadata.
         *
         * By default this function is used by MetadataManager to translate server responses into metadata
         * usable internally. The currently set metadata is preserved and extended by new metadata unless
         * `reset` parameter equals to `true`.
         * @param {Object} data Metadata payload returned by the server.
         * @param {Boolean} isPublic Flag indicating if the public metadata must be fetched.
         * @param {Boolean} reset Flag indicating if the the current metadata must be deleted.
         */
        set: function(data, isPublic, reset) {

            // Patch module metadata, compile templates, and declare components for custom layouts and views
            _.each(data.modules, function(entry, module) {
                this._patchMetadata(module, entry);
            }, this);

            this._declareClasses(data);

            // Update application configuration
            app.config = _.extend(app.config || {}, data.config);

            // Compile templates if metadata has been changed
            app.template.set(data, (data._hash && data._hash != this.getHash(isPublic)));

            if (!_.isEmpty(data._hash))
                _setHash(data, isPublic);

            if (!reset) {
                var overrideKeys = data._override_values || [];
                delete(data._override_values);
                // Keep whatever we have and extend it with new stuff
                _.each(data, function(value, key) {
                    _metadata[key] = (_.isObject(value) && !_.contains(overrideKeys, key)) ?
                        _.extend(_metadata[key] || {}, value) :
                        value;
                });
            }
            else {
                _metadata = data;
            }

            if (app.config.cacheMeta && !isPublic) {
                _cacheMeta(_metadata);
            }

            if (app.config.env != "prod") this._dev_data = _metadata;
        },

        /**
         * Gets metadata hash.
         * @param {Boolean} isPublic Flag indicating if the hash public metadata is requested (`true`).
         * @return {String} Metadata hash tag.
         */
        getHash: function(isPublic) {
            var key = isPublic ? (_keyPrefix + "public:hash") : (_keyPrefix + "hash");
            return app.cache.get(key) || _metadata._hash || "";
        },

        /**
         * Syncs metadata from the server. Saves the metadata to the local cache.
         * @param {Function} callback (optional) Callback function to be executed after sync completes.
         * @param {Object} options (optional) Sync call options currently supports public:true to get public metadata.
         */
        sync: function(callback, options) {
            _syncing = true;
            options = options || {};
            var self = this,
                metadataTypes = options.metadataTypes || (options.getPublic ? app.config.publicMetadataTypes : app.config.metadataTypes) || [],
                errorCallback = function(error) {
                    app.logger.debug("Failed fetching metadata");
                    app.error.handleHttpError(error);
                    callback.call(self, error);
                },
                cb = callback;

            //Force _syncing to be false no matter how we exit this function
            callback = function(p){
                _syncing = false;
                if (_.isFunction(cb)) cb(p);
            };

            app.api.getMetadata(self.getHash(options.getPublic), metadataTypes, [], {
                success: function(metadata) {
                    var  compatible;
                    options = options || {};

                    if (!_.isEmpty(metadata)) {
                        app.logger.debug("Updating metadata");
                        if (_mdLoaded[options.getPublic ? "public:md" : "md"] && self.getHash(options.getPublic) == metadata._hash && !options.forceRefresh){
                            app.logger.debug("Skipping update as metadata hash matches");
                            return callback.call(self);
                            return true;
                        }

                        //If the response contains server_info, we need to run a compatibility check
                        if (_.isEmpty(metadataTypes) || _.include(metadataTypes, 'server_info') && !options.getPublic) {
                            compatible = app.isServerCompatible(metadata.server_info);
                            //If compatible wasn't true, it will be set to an error string and we need to bomb out
                            if (compatible !== true){
                                return callback(compatible);
                            }
                        }

                        _mdLoaded[options.getPublic ? "public:md" : "md"] = true;

                        if (metadata.jssource) {
                           self._loadJSSource(metadata, options, callback, errorCallback, self);
                        }
                        else {
                            // Some clients may not want jssource (e.g. Nomad)
                            if (metadata.labels) {
                                _fetchLabels(metadata, {
                                    language:options.language,
                                    success:function (labelsData) {
                                        _injectLabels(metadata, labelsData);
                                        self.set(metadata, options.getPublic);
                                        callback.call(self);
                                    },
                                    error:errorCallback
                                });
                            } else {
                                callback.call(self);
                            }
                        }
                    }
                    else {
                        callback.call(self, {
                            code: "sync_failed",
                            label: "ERR_SYNC_FAILED"
                        });
                    }
                },
                error: errorCallback
            }, options);
        },

        /**
         * Used to check if a metadata sync is currently in progress.
         * @return {Boolean} true if a sync is in progress.
         */
        isSyncing : function(){
            return _syncing;
        },

        _loadJSSource : function(metadata, options, callback, errorCallback, self){
           var scriptEl;
           SUGAR.jssource = false;
           scriptEl = document.createElement("script");
           scriptEl.src = app.utils.buildUrl(metadata.jssource);
           document.head.appendChild(scriptEl);

            _fetchLabels(metadata, {
                language: options.language,
                success: function(labelsData) {
                    // Injects lang strings in server metadata. Must do this before the call to self.set in 
                    // case it's overridden by a client (bad!) which expects all meta properties in metadata.
                    _injectLabels(metadata, labelsData);
                    self.set(metadata, options.getPublic);

                    app.utils.doWhen("SUGAR.jssource", function(){
                        self._declareClasses(SUGAR.jssource);
                        if (callback) {
                            callback.call(self);
                        }
                    });
                },
                error: errorCallback
            });
        },

        init: function() {
            var self = this,
                _intervalFunc = function(){
                    if(!_syncing && ((self.getHash() != _metadata._hash && _mdLoaded["md"]) ||
                        (app.api.getUserprefHash() && app.user.get("_hash")
                            && app.api.getUserprefHash() != app.user.get("_hash")
                        )
                    )) {
                        _syncing = true;
                        window.clearInterval(self._validateMDInterval);
                        this._validateMDInterval = null;
                        //Wait an extra 500 to allow the window that did the refresh to more fully load before bogging down the client with a possible large number of background tab resyncs.
                        window.setTimeout(function(){
                            _mdLoaded["md"] = false;
                            app.sync({
                                getPublic: !app.api.isAuthenticated(),
                                callback:function(){
                                self._validateMDInterval = window.setInterval(_intervalFunc, 100);
                            }});
                        }, 500);
                    }
                };
            // Load metadata from local storage upon app initialization
            if (app.config.cacheMeta) {
                var data = _getCachedMeta();
                if (data) this.set(data, false);
            }
            //Setup an interval to recheck if the metadata in memory is out of date.
            //(Cross tab communication via local storage)
            //If it is, resync this tab
            this._validateMDInterval = window.setInterval(_intervalFunc, 100);
        },

        /**
         * Purges metadata from the persistent cache.
         */
        clearCache: function() {
            app.cache.cut(_keyPrefix + "public:hash");
            app.cache.cut(_keyPrefix + "hash");
            app.cache.cut(_keyPrefix + "data");
        },

        /**
         * Resets internal memory cache and clears persistent storage.
         */
        reset: function() {
            _metadata = {};
            this.clearCache();
        }

    }, false);

})(SUGAR.App);
