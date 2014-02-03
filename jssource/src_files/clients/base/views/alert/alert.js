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
     * extendsFrom: This needs to be app.view.AlertView since it's extending a Sidecar specific view class.  This is a
     * special case, as the normal method is for it to be a string.
     */
        extendsFrom: app.view.AlertView,

        className: 'alert-wrapper', //override default class

        events: {
            'click [data-action=cancel]': 'cancelClicked',
            'click [data-action=confirm]': 'confirmClicked',
            'click a': 'linkClick'
        },

        LEVEL: {
            PROCESS: 'process',
            SUCCESS: 'success',
            WARNING: 'warning',
            INFO: 'info',
            ERROR: 'error',
            CONFIRMATION: 'confirmation'
        },

        initialize: function(options) {
            this.onConfirm = options.onConfirm;
            this.onCancel = options.onCancel;
            this.onLinkClick = options.onLinkClick;
            this.alertLevel = options.level;
            this.templateOptions = options.templateOptions;
            this.name = 'alert';
        },

        render: function(options) {
            if(_.isUndefined(options)) {
                return this;
            }
            var template = this.getAlertTemplate(options.level, options.messages, options.title, this.templateOptions);
            this.$el.html(template);
            this.$el.after('<br>');

            this.show(options.level);
        },

        show: function(level) {
            this.$el.show();
        },

        close: function() {
            this.$el.fadeOut().remove();
        },

        cancel: function() {
            app.alert.dismiss(this.key);
        },

        /**
         * Executes assigned handlers when user clicks `cancel`.
         */
        cancelClicked: function() {
            if (_.isFunction(this.onCancel)) {
                this.onCancel();
            }
            this.cancel();
        },

        /**
         * Executes assigned handlers when user clicks `confirm`.
         */
        confirmClicked: function() {
            if (_.isFunction(this.onConfirm)) {
                this.onConfirm();
            }
            this.cancel();
        },

        linkClick: function(event) {
            if (_.isFunction(this.onLinkClick)) {
                this.onLinkClick(event);
            }
        },

        /**
         * Get the HTML string for alert given alert level
         * @param level
         * @param messages
         * @param title (optional)
         * @param templateOptions (optional) additional custom options passed to template function
         * @return {String}
         */
        getAlertTemplate: function(level, messages, title, templateOptions) {
            var template,
                alertClasses = this.getAlertClasses(level);

            title = title ? title : this.getDefaultTitle(level);

            switch (level) {
                case this.LEVEL.PROCESS:
                    //Cut ellipsis at the end of the string
                    title = title.substr(-3)==='...' ? title.substr(0, title.length-3) : title;
                    template = app.template.getView(this.name + '.process');
                    break;
                case this.LEVEL.SUCCESS:
                case this.LEVEL.WARNING:
                case this.LEVEL.INFO:
                case this.LEVEL.ERROR:
                    template = app.template.getView(this.name + '.error');
                    break;
                case this.LEVEL.CONFIRMATION:
                    template = app.template.getView(this.name + '.confirmation');
                    break;
                default:
                    template = app.template.empty;
            }
            var seed = _.extend({}, {
                alertClass: alertClasses,
                title: this.getTranslatedLabels(title),
                messages: this.getTranslatedLabels(messages)
            }, templateOptions);
            return template(seed);
        },

        /**
         * Get CSS classes given alert level
         * @param level
         * @return {String}
         */
        getAlertClasses: function(level) {
            switch (level) {
                case this.LEVEL.PROCESS:
                    return 'alert-process';
                case this.LEVEL.SUCCESS:
                    return 'alert-success';
                case this.LEVEL.WARNING:
                    return 'alert-warning';
                case this.LEVEL.INFO:
                    return 'alert-info';
                case this.LEVEL.ERROR:
                    return 'alert-danger';
                case this.LEVEL.CONFIRMATION:
                    return 'alert-warning';
                default:
                    return '';
            }
        },

        /**
         * Get the default title given alert level
         * @param level
         * @return {String}
         */
        getDefaultTitle: function(level) {
            switch (level) {
                case this.LEVEL.PROCESS:
                    return 'LBL_ALERT_TITLE_LOADING';
                case this.LEVEL.SUCCESS:
                    return 'LBL_ALERT_TITLE_SUCCESS';
                case this.LEVEL.WARNING:
                    return 'LBL_ALERT_TITLE_WARNING';
                case this.LEVEL.INFO:
                    return 'LBL_ALERT_TITLE_NOTICE';
                case this.LEVEL.ERROR:
                    return 'LBL_ALERT_TITLE_ERROR';
                case this.LEVEL.CONFIRMATION:
                    return 'LBL_ALERT_TITLE_WARNING';
                default:
                    return '';
            }
        },

    /**
     * Return translated text, given a string or an array of strings.
     * @param stringOrArray
     * @return {*}
     */
    getTranslatedLabels: function(stringOrArray) {
        var result;

        if (_.isArray(stringOrArray)) {
            result = _.map(stringOrArray, function(text) {
                return app.lang.getAppString(text);
            });
        } else {
            result = app.lang.getAppString(stringOrArray);
        }

        return result;
    },

    /**
     * Remove br tags after alerts which are needed to stack alerts vertically.
     */
    close: function(){
        this.$el.next('br').remove();
        this._super('close');
    },

    bindDataChange : function() {}
})
