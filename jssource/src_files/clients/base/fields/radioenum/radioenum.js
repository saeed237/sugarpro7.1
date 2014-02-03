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
    // On list-edit template,
    // we want the radio buttons to be replaced by a select so each method must call the EnumField method instead.
    extendsFrom: 'ListeditableField',
    _render: function(){
        // TODO: Calling "across controllers" considered harmful .. please consider using a plugin instead.
        app.view.invokeParent(this, {type: 'field', name: 'enum', method: 'loadEnumOptions', args: [false,
            function() {
                if(!this.disposed){
                    this.render();
                }
            }]
        });
        app.view.Field.prototype._render.call(this);
        if(this.tplName === 'list-edit') {
            // TODO: Calling "across controllers" considered harmful .. please consider using a plugin instead.
            app.view.invokeParent(this, {type: 'field', name: 'enum', method: '_render'});
        }
    },
    bindDomChange: function() {
        if (this.tplName === 'list-edit') {
            // TODO: Calling "across controllers" considered harmful .. please consider using a plugin instead.
            app.view.invokeParent(this, {type: 'field', name: 'enum', method: 'bindDomChange'});
        } else {
            if (!(this.model instanceof Backbone.Model)) return;
            var self = this;
            var el = this.$el.find(this.fieldTag);
            el.on("change", function() {
                self.model.set(self.name, self.unformat(self.$(self.fieldTag+":radio:checked").val()));
            });
        }
    },
    format: function(value) {
        if (this.tplName === 'list-edit') {
            // TODO: Calling "across controllers" considered harmful .. please consider using a plugin instead.
            return app.view.invokeParent(this, {type: 'field', name: 'enum', method: 'format', args: [value]});
        } else {
            return app.view.Field.prototype.format.call(this, value);
        }
    },
    unformat: function(value) {
        if (this.tplName === 'list-edit') {
            // TODO: Calling "across controllers" considered harmful .. please consider using a plugin instead.
            return app.view.invokeParent(this, {type: 'field', name: 'enum', method: 'unformat', args: [value]});
        } else {
            return app.view.Field.prototype.unformat.call(this, value);
        }
    },
    _loadTemplate: function() {
        app.view.invokeParent(this, {type: 'field', name: 'listeditable', method: '_loadTemplate'});
    },
    /**
     * Load select2 options for radioenum list-edit mode
     * @param {Array} optionKeys Collection of option keys
     * @returns {*}
     */
    getSelect2Options: function(optionKeys){
        // TODO: Calling "across controllers" considered harmful .. please consider using a plugin instead.
        return app.view.invokeParent(this, {type: 'field', name: 'enum', method: 'getSelect2Options', args: [optionKeys]});
    },
    /**
     * Select2 function, needed to support radioenum list-edit mode
     * @param {Object} query Select2 query object
     * @returns {*} Select2 query results
     * @private
     */
    _query: function(query){
        // TODO: Calling "across controllers" considered harmful .. please consider using a plugin instead.
        return app.view.invokeParent(this, {type: 'field', name: 'enum', method: '_query', args: [query]});
    },
    /**
     * Select2 function, needed to support radioenum list-edit mode
     * @param {Selector} $ele Select2 element selector
     * @param {Function} callback Select2 callback
     * @private
     */
    _initSelection: function($ele, callback){
        // TODO: Calling "across controllers" considered harmful .. please consider using a plugin instead.
        app.view.invokeParent(this, {type: 'field', name: 'enum', method: '_initSelection', args: [$ele, callback]});
    },
    decorateError: function(errors) {
        if (this.tplName === 'list-edit') {
            return app.view.invokeParent(this, {type: 'field', name: 'enum', method: 'decorateError', args: [errors]});
        } else {

            var errorMessages = [],
                $tooltip;

            // Add error styling
            this.$el.closest('.record-cell').addClass('error');
            this.$el.addClass('error');
            // For each error add to error help block
            _.each(errors, function(errorContext, errorName) {
                errorMessages.push(app.error.getErrorString(errorName, errorContext));
            });
            this.$(this.fieldTag).last().closest('p').append(this.exclamationMarkTemplate(errorMessages));
            $tooltip = this.$('.error-tooltip');
            if (_.isFunction($tooltip.tooltip)) {
                var tooltipOpts = { container: 'body', placement: 'top', trigger: 'click' };
                $tooltip.tooltip(tooltipOpts);
            }
        }
    },
    clearErrorDecoration: function() {
        if (this.tplName === 'list-edit') {
            // TODO: Calling "across controllers" considered harmful .. please consider using a plugin instead.
            return app.view.invokeParent(this, {type: 'field', name: 'enum', method: 'clearErrorDecoration'});
        } else {
            var ftag = this.fieldTag || '';
            // Remove previous exclamation then add back.
            this.$('.add-on').remove();
            this.$el.removeClass(ftag);
            this.$el.removeClass("error");
            this.$el.closest('.record-cell').removeClass("error");
        }
    },
    unbindDom: function() {
        this.$(this.fieldTag).select2('destroy');
        app.view.Field.prototype.unbindDom.call(this);
    }
})