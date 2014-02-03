/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright 2004-2013 SugarCRM Inc. All rights reserved.
 */

(function(app) {
    app.events.on('app:init', function() {
        app.plugins.register('LinkedModel', ['view', 'field'], {

            /**
             * Create a new linked Bean model which is related to the parent
             * bean model. It populates related fields from the parent bean
             * if it's already fetched.
             * All related fields are defined in the relationship metadata.
             * If the related field contains the auto-populated fields,
             * it also copies the auto-populate fields.
             *
             * @param {Object} parentModel Parent Bean Model.
             * @param {String} link Name of relationship link.
             * @return {Object} A new instance of the related or regular bean.
             */
            createLinkModel: function(parentModel, link) {
                if (this.context && this.context.parent && this.context.parent.isCreate())
                {
                    return app.data.createBean(app.data.getRelatedModule(parentModel.module, link));
                }

                var model = app.data.createRelatedBean(parentModel, null, link),
                    relatedFields = app.data.getRelateFields(parentModel.module, link);

                if (!_.isEmpty(relatedFields)) {
                    model.relatedAttributes = model.relatedAttributes || {};
                    _.each(relatedFields, function(field) {
                        var parentValue = parentModel.get(field.rname);
                        if (!parentValue && parentModel.fields[field.rname]
                            && parentModel.fields[field.rname].type == "fullname"
                        ) {
                            parentValue =  parentModel.get("full_name");
                        }
                        model.set(field.name, parentValue);
                        model.set(field.id_name, parentModel.get('id'));
                        model.relatedAttributes[field.name] = parentModel.get(field.rname);
                        model.relatedAttributes[field.id_name] = parentModel.get('id');

                        if (field.populate_list) {
                            _.each(field.populate_list, function(target, source) {
                                source = _.isNumber(source) ? target : source;
                                if (
                                    !_.isUndefined(parentModel.get(source)) &&
                                    app.acl.hasAccessToModel('edit', model, target)
                                ) {
                                    model.set(target, parentModel.get(source));
                                    model.relatedAttributes[target] = parentModel.get(source);
                                }
                            }, this);
                        }
                    }, this);
                }
                this.populateParentFields(model, parentModel);

                return model;
            },

            /**
             * Event handler for the create button that launches UI for
             * creating a related record.
             * For sidecar modules, this means a drawer is opened with the
             * create dialog inside.
             * For BWC modules, this means we trigger a create route to enter
             * BWC mode.
             *
             * @param {String} module Module name.
             */
            createRelatedRecord: function(module, link) {
                var bwcExceptions = ['Emails'],
                    moduleMeta = app.metadata.getModule(module);

                if (moduleMeta && moduleMeta.isBwcEnabled && !_.contains(bwcExceptions, module)) {
                    this.routeToBwcCreate(module);
                } else {
                    this.openCreateDrawer(module, link);
                }
            },

            /**
             * Route to Create Related record UI for a BWC module.
             *
             * @param {String} module Module name.
             */
            routeToBwcCreate: function(module) {
                var proto = Object.getPrototypeOf(this);
                if (_.isFunction(proto.routeToBwcCreate)) {
                    return proto.routeToBwcCreate.call(this, module);
                }
                var parentModel = this.context.parent.get('model'),
                    link = this.context.get('link');
                app.bwc.createRelatedRecord(module, parentModel, link);
            },

            /**
             * For sidecar modules, we create new records by launching
             * a create drawer UI.
             *
             * @param {String} module Module name.
             */
            openCreateDrawer: function(module, link) {
                var proto = Object.getPrototypeOf(this);
                if (_.isFunction(proto.openCreateDrawer)) {
                    return proto.openCreateDrawer.call(this, module);
                }
                link = link || this.context.get('link');
                var context = this.context.parent || this.context;
                var parentModel = context.get('model'),
                    model = this.createLinkModel(parentModel, link),
                    self = this;
                app.drawer.open({
                    layout: 'create-actions',
                    context: {
                        create: true,
                        module: model.module,
                        model: model
                    }
                }, function(context, model) {
                    if (!model) {
                        return;
                    }

                    self.context.resetLoadFlag();
                    self.context.set('skipFetch', false);
                    if (_.isFunction(self.loadData)) {
                        self.loadData();
                    } else {
                        self.context.loadData();
                    }
                });
            },

            //If this is being created through a subpanel or dashlet as a child of another record
            //default to populating the parent field as that record
            populateParentFields: function(model, parentModel) {
                var parentModule = parentModel.module || parentModel.get("module") || parentModel.get("_module");
                _.each(model.fields, function(def, name) {
                    if (def.type && def.type == "parent") {
                        if (app.lang.getAppListStrings(def.options)[parentModule]) {
                            model.set(def.type_name, parentModule);
                            if (parentModel.get("id")) {
                                model.set(def.id_name, parentModel.get("id"));
                                //parent_name is hard coded server side to map to these three name fields
                                model.set(def.name,
                                    parentModel.get("full_name")
                                        || parentModel.get("document_name")
                                        || parentModel.get("name")
                                        || ""
                                );
                            }
                        }
                    }
                });

                //Special case for contacts. Notes should attach to the account rather than the contact
                if (parentModule == "Contacts" && parentModel.get("account_id") && model.get("contact_id")) {
                    model.set({
                        parent_type : "Accounts",
                        parent_id : parentModel.get("account_id"),
                        parent_name : parentModel.get("account_name")/*,
                        contact_id : parentModel.get("id"),
                        contact_name : parentModel.get("full_name")*/
                    });
                }
            }
        });
    });
})(SUGAR.App);
