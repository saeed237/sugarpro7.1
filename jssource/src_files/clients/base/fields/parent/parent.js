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
    minChars: 1,
    extendsFrom: 'RelateField',
    fieldTag: 'input.select2[name=parent_name]',
    typeFieldTag: 'select.select2[name=parent_type]',
    _render: function() {
        var result, self = this;
        app.view.invokeParent(this, {type: 'field', name: 'relate', method: '_render'});
        if(this.tplName === 'edit') {
            this.checkAcl('access', this.model.get('parent_type'));

            var inList = (this.view.name === 'recordlist') ? true : false;

            this.$(this.typeFieldTag).select2({
                dropdownCssClass: inList?'select2-narrow':'',
                containerCssClass: inList?'select2-narrow':'',
                width: inList?'off':'100%',
                minimumResultsForSearch: 5
            }).on("change", function(e) {
                var module = e.val;
                self.checkAcl.call(self, 'edit', module);
                self.setValue({
                    id: '',
                    value: '',
                    module: module
                });
            });


            if(this.model.get(this.def.type_name) !== this.$(this.typeFieldTag).val()) {
                this.model.set(this.def.type_name, this.$(this.typeFieldTag).val());
            }

            if(app.acl.hasAccessToModel('edit', this.model, this.name) === false) {
                this.$(this.typeFieldTag).select2("disable");
            } else {
                this.$(this.typeFieldTag).select2("enable");
            }
        } else if(this.tplName === 'disabled'){
            this.$(this.typeFieldTag).select2('disable');
        }
        return result;
    },
    _getRelateId: function() {
        return this.model.get("parent_id");
    },
    format: function(value) {
        this.def.module = this.getSearchModule();
        var moduleString = app.lang.getAppListStrings('moduleListSingular'),
            module;
        if(this.getSearchModule()) {
            if (!moduleString[this.getSearchModule()]) {
                app.logger.error("Module '" + this.getSearchModule() + "' doesn't have singular translation.");
                // graceful fallback
                module = this.getSearchModule();
            } else {
                module = moduleString[this.getSearchModule()];
            }
        }

        this.context.set("record_label", {
            field: this.name,
            label: (this.tplName === 'detail') ? module : app.lang.get(this.def.label, this.module)
        });
        this._buildRoute();

        return value;
    },
    checkAcl: function(action, module) {
        if(app.acl.hasAccess(action, module) === false) {
            this.$(this.typeFieldTag).select2("disable");
        } else {
            this.$(this.typeFieldTag).select2("enable");
        }
    },
    setValue: function(model) {
        if (model) {
            var silent = model.silent || false;
            if(app.acl.hasAccess(this.action, this.model.module, this.model.get('assigned_user_id'), this.name)) {
                if(model.module) {
                    this.model.set('parent_type', model.module, {silent: silent});
                }
                this.model.set('parent_id', model.id, {silent: silent});
                this.model.set('parent_name', model.value, {silent: silent});
            }
        }
    },
    getSearchModule: function() {
        return this.model.get('parent_type') || this.$(this.typeFieldTag).val();
    },
    getPlaceHolder: function() {
        return  app.lang.get('LBL_SEARCH_SELECT', this.module);
    },
    unbindDom: function() {
        this.$(this.typeFieldTag).select2('destroy');
        app.view.invokeParent(this, {type: 'field', name: 'relate', method: 'unbindDom'});
    }

})
