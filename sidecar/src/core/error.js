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

     /**
     * Error handling module.
     * @class Core.Error
     * @singleton
     */
    var module = {

        init: function() {
            this.initialize();
        },
        
        /**
         * Setups the params for error module
         * @param opts
         */
        initialize: function(opts) {
            opts = opts || {};

            /**
             * Set to true to enable remote logging to server [NOT IMPLEMENTED]
             * @cfg {Boolean}
             */
            this.remoteLogging = opts.remoteLogging || false;

            /**
             * Inject a hash of status code handlers to override defaults
             * @cfg {Object}
             */
            this.statusCodes = (opts.statusCodes) ? _.extend(this.statusCodes, opts.statusCodes) : this.statusCodes;

            /**
             * Set to true to disable onError overloading
             * @cfg {Boolean} disableOnError
             */
            if (!opts.disableOnError) {
                this.enableOnError();
            }
        },

        // This attempts to call function fn (which may not exist), otherwise,
        // falls back to handleStatusCodesFallback.
        _callCustomHandler: function(error, fn) {
            if (fn) {
                fn.call(this, error);
            } else {
                this.handleStatusCodesFallback(error);
            }
        },
    
        /**
         * Authentication error.
         *
         * OAuth2 uses 400 as a sort of catch all; see:
         * http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-5.2
         *
         * Provide the following custom handlers:
         *
         * **handleInvalidGrantError**
         *
         * The provided authorization grant is invalid, expired, revoked, does
         * not match the redirection URI used in the authorization request, or
         * was issued to another client. Note that the server implementation
         * will override invalid_grant as needs_login as a special case (see below).
         *
         * **handleNeedLoginError**
         *
         * The server shall use this in place of invalid_grant to tell client to handle 
         * error specifically as caused due to invalid credentials being supplied. The 
         * reason server needs to use this is because an invalid_grant oauth error may 
         * also be caused by invalid or expired token. Using needs_login allows all 
         * clients to provide proper messaging to end user without the need for extra logic.
         *
         * **handleInvalidClientError**
         *
         * Client authentication failed (e.g. unknown client, no client
         * authentication included, multiple client authentications included,
         * or unsupported authentication method).
         *
         * **handleInvalidRequestError**
         *
         * The request is missing a required parameter, includes an unsupported
         * parameter or parameter value, repeats a parameter, includes multiple
         * credentials, utilizes more than one mechanism for authenticating the
         * client, or is otherwise malformed.
         *
         * **handleUnauthorizedClientError**
         *
         * The authenticated client is not authorized to use this authorization grant type.
         *
         * **handleUnsupportedGrantTypeError**
         *
         * The authorization grant type is not supported by the authorization server.
         *
         * **handleInvalidScopeError**
         *
         * The requested scope is invalid, unknown, malformed, or exceeds the scope granted by the resource owner.
         *
         *
         * @param {SUGAR.HttpError} error HTTP error.
         * @param {Function} alternativeCallback(optional) If this does not match an expected oauth error than this callback will be
         * called (if provided). 
         * @method
         * @private
         */
        _handleFineGrainedError: function(error, alternativeCallback) {
            var handlerName = "handle" + app.utils.classify(error.code) + "Error";
            (this[handlerName] || alternativeCallback || this.handleStatusCodesFallback).call(this, error);
        },

        /**
         * An object of status code error handlers. If custom handler is defined by extending
         * module, corresponding status code handler will attemp to use that, otherwise,
         * handleStatusCodesFallback is used as a fallback just logging the error.
         * @class Core.Error.statusCodes
         * @singleton
         * @member Core.Error
         */
        statusCodes: {

            "0": function(error) {
                if(error.textStatus === 'timeout') {
                    this._callCustomHandler(error, this.handleTimeoutError);
                } else {
                    // TODO: Need invalid url, and any other possible status: 0 conditions
                    this.handleStatusCodesFallback(error);
                }
            },
            
            /**
             * Authentication error.
             *
             * Since oauth server implementation might throw 401 (as well as 400)
             * we route this to the {@link Core.Error#_handleFineGrainedError}. If no match for oauth error
             * than handleOAuthError will try to use handleUnauthorizedError if 
             * supplied.
             *
             * Provide custom `handleUnauthorizedError` handler.
             * @method
             */
            "400": function(error) {
                this._handleFineGrainedError(error);
            },

            /**
             * Unauthorized.
             *
             * Since oauth server implementation might throw 401 (as well as 400)
             * we route this to the {@link Core.Error#_handleFineGrainedError}. If no match for oauth error
             * than handleOAuthError will try to use handleUnauthorizedError if 
             * supplied.
             *
             * Provide custom `handleUnauthorizedError` handler.
             * @method
             */
            "401": function(error) {
                this._handleFineGrainedError(error, this.handleUnauthorizedError);
            },

            /**
             * Forbidden.
             *
             * Provide custom `handleForbiddenError` handler.
             * @method
             */
            "403": function(error) {
                this._callCustomHandler(error, this.handleForbiddenError);
            },

            /**
             * Not found.
             *
             * Provide custom `handleNotFoundError` handler.
             * @method
             */
            "404": function(error) {
                this._callCustomHandler(error, this.handleNotFoundError);
            },

            /**
             * Method not allowed.
             *
             * Provide custom `handleMethodNotAllowedError` handler.
             * @method
             */
            "405": function(error) {
                this._callCustomHandler(error, this.handleMethodNotAllowedError);
            },
            /**
             * Method not allowed.
             *
             * Provide custom `handleMethodNotAllowedError` handler.
             * @method
             */
            "412": function(error) {
                this._callCustomHandler(error, this.handleHeaderPreconditionFailed);
            },

            /**
             * Precondition failure.
             *
             * Clients can optionally sniff the error property in JSON for finer grained 
             * determination; the following values may be:
             * missing_parameter, invalid_parameter, request_failure
             *
             * Provide custom `handleMethodFailureError` handler.
             * @method
             */
            "422": function(error) {
                this._callCustomHandler(error, this.handleMethodFailureError);
            },

            /**
             * Unprocessable Entity.
             *
             * Validation errors handled automatically.
             * @method
             */
            "424": function(error, model) {
                error.model = model;
                this._callCustomHandler(error, this.handleValidationError);
            },

            /**
             * Internal server error.
             *
             * Provide custom `handleServerError` handler.
             * @method
             */
            "500": function(error) {
                this._callCustomHandler(error, this.handleServerError);
            },
            
            /**
             * Internal server error.
             *
             * Provide custom `handleServerError` handler.
             * @method
             */
            "503": function(error) {
                this._callCustomHandler(error, this.handleServerError);
            }
        },

        remoteLogging: false,

        /**
         * Maps validator names to error labels.
         * @member Core.Error
         */
        errorName2Keys: {
            "maxValue":"ERROR_MAXVALUE",
            "minValue":"ERROR_MINVALUE",
            "maxLength":"ERROR_MAX_FIELD_LENGTH",
            "minLength":"ERROR_MIN_FIELD_LENGTH",
            "datetime":"ERROR_DATETIME",
            "required":"ERROR_FIELD_REQUIRED",
            "email":"ERROR_EMAIL",
            "primaryEmail":"ERROR_PRIMARY_EMAIL",
            "duplicateEmail":"ERROR_DUPLICATE_EMAIL",
            "number":"ERROR_NUMBER",
            "isBefore":"ERROR_IS_BEFORE",
            "isAfter":"ERROR_IS_AFTER"
         },

        /**
         * Returns error strings given a error key and context
         * @param errorKey
         * @param context
         * @member Core.Error
         */
        getErrorString: function(errorKey, context) {
            var module = context.module || '';
            return app.lang.get(this.errorName2Keys[errorKey] || errorKey, module, context);
        },

        /**
         * Handles validation errors. By default this just pipes the error to the
         * error logger.
         * @param {SUGAR.HttpError} error AJAX error.
         * @member Core.Error
         */
        handleValidationError: function(error) {
            var errors = error.responseText;
            var model = error.model;
            
            // TODO: Right now doesn't stringify the error, add it in when we finalize the
            // structure of the error.

            // TODO: Likely, we'll have a 'Saving...' alert, etc., and so we just dismiss all
            // since we don't know the alert key. Ostensibly, validation errors will show
            // field by field; so feedback will be provided as appropriate.
            app.alert.dismissAll();

            _.each(errors, function(fieldError, key) {
                var errorMsg = '';
                if (_.isObject(fieldError)) {
                    _.each(fieldError, function(result, fieldName) {
                        errorMsg +=  "(Message) " + this.getErrorString(fieldName, result) + "\n";
                    }, this);
                } else {
                    errorMsg = fieldError;
                }
                app.logger.debug("validation failed for field `" + key + "`:\n" + errorMsg);
            }, this);
        },

        /**
         * Handles http errors returned from AJAX calls.
         * @param {SUGAR.HttpError} error AJAX error.
         * @param {Backbone.Model} model(optional) Instance of the model for which the request was made.
         * @member Core.Error
         */
        handleHttpError: function(error, model) {
            // If we have a handler defined for this status code
            // The context may not be correct for the handler so use app.error instead of this.
            if (app.error.statusCodes[error.status]) {
                app.error.statusCodes[error.status].call(app.error, error, model);
            } else {
                // TODO: Default catch all error code handler
                // Temporarily going to the handleStatusCodesFallback handler but will probably need
                // to go to a sensible "all other errors" type of handler.
                app.error.handleStatusCodesFallback(error);
            }
        },

        /**
         * Handles unhandled javascript exceptions which are reported via `window.onerror` event.
         *
         * The default implementation logs the error with level `FATAL`.
         * Consider such exceptions as fatal application errors that should never happen :)
         * @param {String} message Error message
         * @param {String} url URL of script
         * @param {String} line Line number of script
         * @member Core.Error
         */
        handleUnhandledError: function(message, url, line) {
            app.logger.fatal(message + " at " + url + " on line " + line);
        },
        
        /**
         * This is the fallback error handler if custom status code specific handler
         * not provided in application specific error handler. To define custom error
         * handlers, you should include your script from index page and do something like:
         * <pre><code>
         * (function(app) {
         *
         *     app.error = _.extend(app.error, {
         *        // put your custom handlers here.
         *        handleUnauthorizedError: function(error) {
         *        },
         *
         *        ...
         *     });
         *
         * })(SUGAR.App);
         * </pre></code>
         * 
         * @param {String} error Ajax error.
         * @member Core.Error
         */
        handleStatusCodesFallback: function(error) {
            app.logger.error(error.toString());
        },
        
        /**
         * Handles render related errors.
         * @param {String} component The reference to calling view's this
         * @param {String} method The method that caught the error e.g. _renderHtml
         * @param {String} additionalInfo(optional) Any additional information required for the particular method that called. E.g. the field for _renderField.
         * @member Core.Error
         */
        handleRenderError: function(component, method, additionalInfo) {
            var id = 'render_error_'+ component.module + '_'+ component.name;
            var level = "error"; //Default message level
            var title, messages;
            // TODO: Add corresponding language agnostic app strings for title/message and use that instead.
            switch(method) {
                case '_renderHtml':
                    title = app.lang.getAppString('ERR_RENDER_FAILED_TITLE');
                    messages = [app.lang.getAppString('ERR_RENDER_FAILED_MSG'), 
                                app.lang.getAppString('ERR_CONTACT_TECH_SUPPORT')];
                    break;
                case '_renderField':
                    title = app.lang.getAppString('ERR_RENDER_FIELD_FAILED_TITLE');
                    messages = [app.utils.formatString(app.lang.getAppString('ERR_RENDER_FIELD_FAILED_MSG'),
                        [additionalInfo.name]), app.lang.getAppString('ERR_CONTACT_TECH_SUPPORT')];
                    break;
                case 'view_render_denied':
                    title = app.lang.getAppString('ERR_NO_VIEW_ACCESS_TITLE');
                    level = "warning";  // This isn't an application error, this is ACL enforcement.
                    messages = [app.utils.formatString(app.lang.getAppString('ERR_NO_VIEW_ACCESS_MSG'),[component.module])];
                    break;
                case 'layout_render':
                    title = app.lang.getAppString('ERR_LAYOUT_RENDER_TITLE');
                    messages = [app.lang.getAppString('ERR_LAYOUT_RENDER_MSG')];
                    break;
                default:
                    // This shouldn't happen
                    title = app.lang.getAppString('ERR_GENERIC_TITLE');
                    messages = [app.lang.getAppString('ERR_INTERNAL_ERR_MSG'), 
                                app.lang.getAppString('ERR_CONTACT_TECH_SUPPORT')];
                    app.logger.error('handleRenderError called for render error caught in ' + method +', but we have no corresponding handler!');
                    break;
            }

            app.alert.show(id, {
                level: level,
                title: title,
                messages: messages,
                autoClose: true
            });

        },
        
        /**
         * Overloads the window.onerror catch all function. Calls the original if any while
         * adding the framework's custom error handling logic. Pass in a custom callback to
         * add additional error handling.
         * @param {Function} handler Callback function to call on error.
         * @param {Object} context Scope of the callback
         * @return {Boolean} False if onerror has already been overloaded.
         * @member Core.Error
         */
        enableOnError: function(handler, context) {
            var originalHandler,
                self = this;

            if (this.overloaded) {
                return false;
            }

            originalHandler = window.onerror;

            window.onerror = function(mesg, url, line) {
                if (handler) {
                    handler.call(context);
                } else {
                    self.handleUnhandledError(mesg, url, line);
                }

                if (originalHandler) {
                    originalHandler();
                }
            };

            this.overloaded = true;

            return true;
        }
    };

    // We don't want to initialize error handling immediately,
    // because the handler may use code that have not been initialized yet
    app.augment("error", module, false);

})(SUGAR.App);
