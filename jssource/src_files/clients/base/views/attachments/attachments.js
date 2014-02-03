/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
/**
 * Attachment dashlet displays Notes and Attachments records that is related to the LHS record.
 * The following items are configurable.
 *
 * - {Integer} limit Limit imposed to the number of records pulled.
 * - {Integer} auto_refresh How often (minutes) should refresh the data collection.
 *
 * @class View.Views.BaseAttachmentsView
 */
({
    plugins: ['LinkedModel', 'Dashlet', 'Timeago'],
    events: {
        'click [name=show_more_button]' : 'showMore',
        'click [data-event=create_button]': 'createRelatedNote',
        'click [data-event=select_button]': 'openSelectDrawer'
    },

    /**
     * Default options used when none are supplied through metadata.
     *
     * Supported options:
     * - timer: How often (minutes) should refresh the data collection.
     * - limit: Limit imposed to the number of records pulled.
     *
     * @property {Object}
     * @protected
     */
    _defaultOptions: {
        limit: 5,
        timer: 0
    },

    /**
     * {@inheritDoc}
     *
     * @param {String} viewName view name.
     */
    initDashlet: function(viewName) {
        this._initOptions();
        if (!this.meta.config && this.context.get('collection')) {
            this.context.set('skipFetch', false);
            this.context.set('limit', this.limit);
        }
        if (!this.meta.config && !this.meta.preview) {
            this.context.on('attachment:view:fire', this.previewRecord, this);
            this.context.on('attachment:unlinkrow:fire', this.unlinkClicked, this);
            if (this.timer > 0) {
                //disabled previous interval
                this._disableAutoRefresh();
                this._enableAutoRefresh(this.timer);
            }
        }
    },

    /**
     * Initialize options, default options are used when none are supplied
     * through metadata.
     *
     * @return {Backbone.View} Instance of this view.
     * @protected
     */
    _initOptions: function() {
        var options = _.extend(this._defaultOptions, this.settings.attributes || {});
        this.timer = parseInt(options['auto_refresh'], 10) * 60 * 1000;
        this.limit = options.limit;
        return this;
    },

    /**
     * Disable activated refresh interval
     * @protected
     */
    _disableAutoRefresh: function() {
        if (this.timerId) {
            clearInterval(this.timerId);
            this.timerId = null;
        }
        return this;
    },

    /**
     * Activate auto refresh data fetch.
     *
     * @param {Integer} msec Interval time in milli seconds(msec > 0).
     * @protected
     */
    _enableAutoRefresh: function(msec) {
        if (msec <= 0) {
            app.logger.error('Invalid interval timer: ' + msec);
            return this;
        }

        if (!_.isEmpty(this.timerId)) {
            app.logger.error('Trying to enable an already enabled auto-refresh dashlet.');
            return this;
        }

        this.timerId = setInterval(_.bind(function() {
            this.context.resetLoadFlag();
            this.layout.loadData();
        }, this), msec);
        return this;
    },

    /**
     * {@inheritDoc}
     *
     * Apply svg icon plugin.
     * @protected
     */
    _renderHtml: function() {
        var self = this,
            svgIconTemplate = app.template.get('attachments.svg-icon', this.module) ||
                app.template.get('attachments.svg-icon');
        app.view.View.prototype._renderHtml.call(this);
        this.$('[data-mime]').each(function() {
            var mimeType = $(this).data('mime'),
                filetype = self.dashletConfig.supportedImageExtensions[mimeType] || self._getFileType(mimeType);
            $(this).attr('data-filetype', filetype).html(svgIconTemplate());
        });
        return this;
    },

    /**
     * Convert file mime type to file format
     *
     * @param {String} mimeType file mime type.
     * @return {String} file type.
     * @private
     */
    _getFileType: function(mimeType) {
        var filetype = mimeType.substr(mimeType.lastIndexOf('/') + 1).toUpperCase();
        return filetype ? filetype : this.dashletConfig.defaultType.toUpperCase();
    },

    /**
     * {@inheritDoc}
     *
     * Once collection is reset, the view should be refreshed.
     */
    bindDataChange: function() {
        if (this.collection) {
            this.collection.on('reset', this.render, this);
        }
    },

    /**
     * Show next offset records.
     */
    showMore: function() {
        this.collection.paginate({
            add: true,
            limit: this.limit,
            success: _.bind(function() {
                if (this.disposed) {
                    return;
                }
                this.render();
            }, this)
        });
    },

    /**
     * Choose the attachment from the existing module list
     */
    openSelectDrawer: function() {
        var parentModel = this.context.get('parentModel'),
            linkModule = this.context.get('module'),
            link = this.context.get('link'),
            self = this;

        app.drawer.open({
            layout: 'link-selection',
            context: {
                module: linkModule
            }
        }, function(model) {
            if (!model) {
                return;
            }
            var relatedModel = app.data.createRelatedBean(parentModel, model.id, link),
                options = {
                    //Show alerts for this request
                    showAlerts: true,
                    relate: true,
                    success: function(model) {
                        self.context.resetLoadFlag();
                        self.context.set('skipFetch', false);
                        self.context.loadData();
                    },
                    error: function(error) {
                        app.alert.show('server-error', {
                            level: 'error',
                            messages: 'ERR_GENERIC_SERVER_ERROR',
                            autoClose: false
                        });
                    }
                };
            relatedModel.save(null, options);
        });
    },

    /**
     * Create new attachment record
     */
    createRelatedNote: function() {
        var link =  this.context.get('link'),
            parentModel = this.context.get('parentModel');
        this.createRelatedRecord(app.data.getRelatedModule(parentModel.module, link), link);
    },

    /**
     * Unlinks (removes) the selected model from the list view's collection.
     *
     * We trigger reset after removing the model in order to update html as well.
     *
     * @param {Data.Bean} model Selected model.
     */
    unlinkClicked: function(model) {
        var self = this;
        app.alert.show('unlink_confirmation', {
            level: 'confirmation',
            messages: app.lang.get('NTC_UNLINK_CONFIRMATION'),
            onConfirm: function() {
                model.destroy({
                    //Show alerts for this request
                    showAlerts: true,
                    relate: true,
                    success: function() {
                        if (self.disposed) {
                            return;
                        }
                        // We trigger reset after removing the model so that
                        // the view will re-render and update the list.
                        self.collection.remove(model).trigger('reset');
                        self.render();
                    }
                });
            }
        });
    },

    /**
     * {@inheritDoc}
     *
     * Dispose the interval timer as well.
     */
    _dispose: function() {
        this._disableAutoRefresh();
        app.view.View.prototype._dispose.call(this);
    }
})
