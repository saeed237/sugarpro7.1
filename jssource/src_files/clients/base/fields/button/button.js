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
    tagName: "span",
    fieldTag: "a",

    plugins: ['Tooltip', 'MetadataEventDriven'],

    initialize: function(options) {
        var self = this;
        this.events = _.extend({}, this.events, options.def.events, {
            'click .disabled' : 'preventClick'
        });

        app.view.Field.prototype.initialize.call(this, options);

        // take advantage of this hook to do the acl check
        // we use this wrapper because our spec
        // requires us to set the button.isHidden = true
        // if we don't render it.
        this.before("render", function() {
            if (self.hasAccess()) {
                this._show();
                return true;
            }
            else {
                this.hide();
                return false;
            }
        });
    },
    _render:function(){
        this.fullRoute = _.isString(this.def.route) ? this.def.route : null;

        app.view.Field.prototype._render.call(this);
    },
    getFieldElement: function() {
        return this.$(this.fieldTag);
    },
    setDisabled: function(disable) {
        disable = _.isUndefined(disable) ? true : disable;
        //Preserve the original css definition to restore later
        var orig_css = this.def.css_class || '';
        this.def.css_class = orig_css;
        var css_class = this.def.css_class.split(' ');
        if(disable) {
            css_class.push('disabled');
        } else {
            css_class = _.without(css_class, 'disabled');
        }
        this.def.css_class = _.unique(_.compact(css_class)).join(' ');
        app.view.Field.prototype.setDisabled.call(this, disable);
        //Restore original css
        this.def.css_class = orig_css;
    },
    preventClick: function(evt) {
        if(this.isDisabled()) {
            return false;
        }
    },
    /**
     * Handles the jquery showing and event throwing
     * of the button. does no access checks.
     * @protected
     */
    _show: function() {
        if (this.isHidden !== false) {
            if (!this.triggerBefore("show")) {
                return false;
            }

            this.getFieldElement().removeClass("hide").show();
            this.isHidden = false;
            this.trigger('show');
        }
    },
    show: function() {
        if(this.hasAccess()) {
            this._show();
        } else {
            this.isHidden = true;
        }
    },
    hide: function() {
        if (this.isHidden !== true) {
            if (!this.triggerBefore("hide")) {
                return false;
            }

            this.getFieldElement().addClass("hide").hide();
            this.isHidden = true;
            this.trigger('hide');
        }
    },
    /**
     * Track using the flag that is set on the hide and show from above.
     *
     * It should check the visivility by isHidden instead of DOM visibility testing
     * since actiondropdown renders its dropdown lazy
     *
     * @returns {boolean}
     */
    isVisible: function() {
        return !this.isHidden;
    },
    /**
     * {@inheritdoc}
     *
     * No data changes to bind.
     */
    bindDomChange: function () {
    },
    /**
     * {@inheritdoc}
     *
     * No need to bind DOM changes to a model.
     */
    bindDataChange: function () {
    },
    /**
     * Determine if ACLs or other properties (for example, "allow_bwc") allow for the button to show
     * @return {Boolean} true if allow access, false otherwise
     */
    hasAccess: function() {
        // buttons use the acl_action and acl_module properties in metadata to denote their action for acls
        var acl_module = this.def.acl_module,
            acl_action = this.def.acl_action;
        //Need to test BWC status
        if(_.isBoolean(this.def.allow_bwc) && !this.def.allow_bwc){
            var isBwc = app.metadata.getModule(acl_module || this.module).isBwcEnabled;
            if(isBwc){
                return false; //Action not allowed for BWC module
            }
        }
        // Finally check ACLs
        if (!acl_module) {
            return app.acl.hasAccessToModel(acl_action, this.model, this);
        } else {
            return app.acl.hasAccess(acl_action, acl_module);
        }
    }
})
