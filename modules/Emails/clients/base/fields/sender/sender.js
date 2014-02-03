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
    fieldTag: 'input.select2',

    initialize: function(options) {
        _.bindAll(this);
        app.view.Field.prototype.initialize.call(this, options);
        this.endpoint = this.def.endpoint;
    },

    _render: function() {
        var result = app.view.Field.prototype._render.call(this);

        if (this.tplName === 'edit') {
            var action = (this.endpoint.action) ? this.endpoint.action : null,
                attributes = (this.endpoint.attributes) ? this.endpoint.attributes : null,
                params = (this.endpoint.params) ? this.endpoint.params : null,
                myURL = app.api.buildURL(this.endpoint.module, action, attributes, params);

            app.api.call('GET', myURL, null, {
                success: this.populateValues,
                error:   function(error) {
                    app.alert.show("server-error", {
                        level: "error",
                        messages: "ERR_GENERIC_SERVER_ERROR",
                        autoClose: false
                    });
                    app.error.handleHttpError(error);
                }
            });
        }

        return result;
    },

    populateValues: function(results) {
        var self = this,
            defaultResult,
            defaultValue = {};

        if (this.disposed === true) {
            return; //if field is already disposed, bail out
        }

        //sets the default value
        if (!_.isEmpty(results)) {
            defaultResult = _.find(results, function(result) {
                return result.default;
            });

            defaultValue = (defaultResult) ? defaultResult : results[0];

            if (!this.model.has(this.name)) {
                this.model.set(this.name, defaultValue.id);
            }
        } else {
            app.drawer.close();
            app.alert.show("no-email-configurations", {
                level: "warning",
                messages: app.lang.get('WARNING_SETTINGS_NOT_CONF', this.module),
                autoClose: false
            });
        }

        var format = function(item) {
            return item.display;
        };

        this.$(this.fieldTag).select2({
            data:{ results: results, text: 'display' },
            formatSelection: format,
            formatResult: format,
            width: '100%',
            placeholder: app.lang.get('LBL_SELECT_FROM_SENDER', this.module),
            initSelection: function(el, callback) {
                if (!_.isEmpty(defaultValue)) {
                      callback(defaultValue);
                }
            }
        }).on("change", function(e) {
            if (self.model.get(self.name) !== e.val) {
                self.model.set(self.name, e.val, {silent: true});
            }
        });

        this.$(".select2-container").addClass("tleft");
    },

    /**
     * {@inheritdoc}
     *
     * We need this empty so it won't affect refresh the select2 plugin
     */
    bindDomChange: function() {
    }
})
