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
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
/**
 * @class Field.ActionMenuField
 * @alias SUGAR.App.view.views.ActionMenuField
 */
({
    events: {
        'click .checkall': 'checkAll',
        'click input[name="check"]': 'check',
        'change [data-toggle=dropdownmenu]' : 'dropdownSelected'
    },
    plugins: ['Tooltip'],
    fields: null, //action button fields
    actionDropDownTag: ".dropdown-toggle",
    fieldTag: "input[name=check]",
    initialize: function(options) {
        app.view.Field.prototype.initialize.call(this, options);
        var massCollection = this.context.get('mass_collection');
        if (!massCollection) {
            var MassCollection = app.BeanCollection.extend({
                reset: function() {
                    this.filterDef = null;
                    this.entire = false;
                    Backbone.Collection.prototype.reset.call(this);
                }
            });
            massCollection = new MassCollection();
            this.context.set('mass_collection', massCollection);
        }
        this.def.disable_select_all_alert = !!this.def.disable_select_all_alert;
    },
    check: function (evt) {
        this.toggleSelect(this.$(this.fieldTag).is(":checked"));
    },
    checkAll: function (evt) {
        var checkbox = this.$(this.fieldTag);

        if (checkbox && evt.currentTarget == evt.target) {
            checkbox.attr("checked", !checkbox.is(":checked"));
            this.toggleSelect(checkbox.is(':checked'));
        }
    },
    dropdownSelected: function(evt) {
        var $el = this.$(evt.currentTarget),
            selectedIndex = $el.val();
        if (!selectedIndex) {
            return;
        }
        this.fields[selectedIndex].getFieldElement().trigger("click");
        $el.blur();
        evt.currentTarget.selectedIndex = 0;
    },
    toggleSelect: function (check) {
        var massCollection = this.context.get('mass_collection');
        if (massCollection) {
            if (check) { //if checkbox is selected
                if (this.model.id) { //each selection
                    massCollection.add(this.model);
                } else {
                    //entire selection
                    massCollection.reset();
                    massCollection.add(this.collection.models);
                    massCollection.filterDef = this.collection.filterDef;
                }
            } else { //if checkbox is unchecked
                if (this.model.id) { //each selection
                    if (massCollection.entire) {
                        massCollection.reset();
                        massCollection.add(this.collection.models);
                        massCollection.remove(this.model);
                    } else {
                        massCollection.remove(this.model);
                    }
                } else { //entire selection
                    massCollection.reset();
                }
            }
        }
    },
    bindDataChange: function () {
        var self = this,
            massCollection = this.context.get('mass_collection');
        if (massCollection && this.model.id) { //listeners for each record selection
            var modelId = this.model.cid;
            massCollection.on("add", function (model) {
                if (self.model && model.id == self.model.id) {
                    self.$(self.fieldTag).attr("checked", true);
                }
            }, modelId);
            massCollection.on("remove", function (model) {
                if (self.model && model.id == self.model.id) {
                    self.$(self.fieldTag).attr("checked", false);
                }
            }, modelId);
            massCollection.on("reset", function () {
                self.$(self.fieldTag).attr("checked", false);
            }, modelId);
            if (massCollection.get(this.model) || massCollection.entire) {
                this.$(self.fieldTag).attr("checked", true);
                this.selected = true;
            } else {
                delete this.selected;
            }
        } else if (massCollection) { //listeners for entire selection
            var cid = this.view.cid;
            if (this.collection) {
                this.collection.on("reset", function () {
                    if (massCollection.entire) {
                        massCollection.reset();
                    }
                }, this);
            }

            this.on("render", this.toggleSelectAll, this);

            massCollection.on("add", function (model) {
                if (massCollection.length > 0) {
                    self.$(self.actionDropDownTag).removeClass("disabled");
                    self.$(".dropdown-menu-select").removeClass("hide");
                }
                if (massCollection.length === self.collection.length) {
                    self.$(self.fieldTag).attr("checked", true);
                }
                self.toggleSelectAll();
            }, cid);
            massCollection.on("remove reset", function (model) {
                if (massCollection.length === 0) {
                    self.$(self.actionDropDownTag).addClass("disabled");
                    self.$(".dropdown-menu-select").addClass("hide");
                }
                self.$(self.fieldTag).attr("checked", false);
                self.toggleSelectAll();
            }, cid);
            this.action_enabled = (massCollection.length > 0);
            this.selected = (massCollection.entire);
        }
    },

    /**
     * Fetch api to retrieve the entire filtered set.
     */
    getTotalRecords: function() {
        var massCollection = (this.context) ? this.context.get('mass_collection') : null,
            filterDef = massCollection.filterDef;

        if (!_.isArray(filterDef)) {
            filterDef = [filterDef];
        }

        var url = app.api.buildURL(this.module, null, null, {
                fields: 'id',
                //FIXME: max_num should be configurable
                //FIXME: once app.config returns max_mass_update.
                max_num: 1000,
                filter: filterDef
            });

        app.alert.show('totalrecord', {
            level: 'process',
            title: app.lang.getAppString('LBL_LOADING'),
            autoClose: false
        });

        massCollection.trigger('massupdate:estimate');

        app.api.call('read', url, null, {
            success: _.bind(function(data) {
                if (this.disposed) {
                    return;
                }
                app.alert.dismiss('totalrecord');
                this._processTotalRecords(data.records);
                this._alertTotalRecords(data.next_offset);
            }, this)
        });
    },

    /**
     * Update total record set from api request.
     *
     * @param {Object[]} collection JSON formatted list of model ids.
     * @private
     */
    _processTotalRecords: function(collection) {
        var massCollection = (this.context) ? this.context.get('mass_collection') : null;
        if (!massCollection) {
            return;
        }
        massCollection.add(collection, {silent: true});
        massCollection.entire = false;
        massCollection.trigger('massupdate:estimate');
    },

    /**
     * Alert the message for total record set.
     *
     * @param {Number} offset Next pagination offset.
     * @private
     */
    _alertTotalRecords: function(offset) {
        var massCollection = (this.context) ? this.context.get('mass_collection') : null;
        if (!massCollection) {
            return;
        }
        //if filtered size is more than maximum allow, it will execute with the first set.
        var label = (offset >= 0) ?
                'TPL_LISTVIEW_SELECTED_FIRST_OFFSET' :
                'TPL_LISTVIEW_SELECTED_ALL',
            message = app.lang.get(label, this.module, {
                num: massCollection.length
            }),
            allSelected = $('<div>').html(message);
        allSelected.find('a').on('click', function(evt) {
            massCollection.reset();
        });
        this.view.layout.trigger('list:alert:show', allSelected);
    },

    /**
     * Toggles the actionmenu buttons when the min or max rows have been selected. Prevents the "select all" alert from
     * being shown if the alert is disabled.
     */
    toggleSelectAll: function() {
        var self = this,
            massCollection = (this.context) ? this.context.get('mass_collection') : null;
        /**
         * Builds the DOM alert with an event for resetting the mass collection.
         * @return {HTMLElement}
         */
        var buildAlertForReset = function() {
            var alert = $('<div>').html(app.lang.get('TPL_LISTVIEW_SELECTED_ALL'));
            alert.find('a').on('click', function() {
                massCollection.reset();
            });
            return alert;
        };
        /**
         * Builds the DOM alert with event for selecting all records.
         * @return {HTMLElement}
         */
        var buildAlertForEntire = function() {
            var alert = selectAll = $('<div>').html(
                app.lang.get('TPL_LISTVIEW_SELECT_ALL_RECORDS', this.module, {
                    num: massCollection.length
                })
            );
            alert.find('a').on('click', function() {
                massCollection.entire = true;
                self.getTotalRecords();
                $(this).off('click');
            });
            return alert;
        };
        /**
         * Shows or hides the appropriate alert based on the state of the mass collection.
         */
        var showAlert = function() {
            var alert;
            if (massCollection && self.collection.next_offset > 0) {
                //only if the collection contains more records
                if (massCollection.entire) {
                    alert = buildAlertForReset();
                } else if (massCollection.length === self.collection.length) {
                    alert = buildAlertForEntire();
                }
            }
            if (alert) {
                self.view.layout.trigger('list:alert:show', alert);
            } else {
                self.view.layout.trigger('list:alert:hide');
            }
        };
        /**
         * Toggles the actionmenu buttons based on the state of the mass collection.
         * @param {Object[]} fields List of the view's fields.
         */
        var setButtonsDisabled = function (fields) {
            _.each(fields, function (field) {
                if (field.def.minSelection || field.def.maxSelection) {
                    var min = field.def.minSelection || 0,
                        max = field.def.maxSelection || massCollection.length;
                    if (massCollection.length < min || massCollection.length > max) {
                        field.setDisabled(true);
                    } else {
                        field.setDisabled(false);
                    }
                }
            }, self);
        };
        if (!this.def.disable_select_all_alert) {
            showAlert();
        }
        setButtonsDisabled(this.fields);
    },
    getPlaceholder: function () {
        var self = this,
            viewName = this.options.viewName || this.view.name;

        if (!this.fields && viewName == 'list-header') {
            this.fields = [];
            var actionMenu = '<ul class="dropdown-menu">';
            _.each(this.def.buttons, function (fieldDef) {
                var field = app.view.createField({
                    def: fieldDef,
                    view: self.view,
                    viewName: self.options.viewName,
                    model: self.model
                });
                field.on("show hide", self.setPlaceholder, self);
                self.fields.push(field);
                field.parent = self;
                actionMenu += '<li>' + field.getPlaceholder() + '</li>';

            });
            actionMenu += "</ul>";
            var caret = '';
            if (app.utils.isTouchDevice()) {
                caret += '<select data-toggle="dropdownmenu" class="hide dropdown-menu-select"></select>';
            }
            self.actionPlaceHolder = new Handlebars.SafeString(caret + actionMenu);
        }
        return app.view.Field.prototype.getPlaceholder.call(this);
    },
    _loadTemplate: function () {
        app.view.Field.prototype._loadTemplate.call(this);
        if (this.view.action === 'list' && this.action === 'edit') {
            this.template = app.template.empty;
        }
    },
    setPlaceholder: function () {
        var index = 0,
            selectEl = this.$(".dropdown-menu-select"),
            html = '<option></option>';

        _.each(this.fields, function (field, idx) {
            var fieldPlaceholder = this.$("span[sfuuid='" + field.sfId + "']");
            if (!field.isVisible()) {
                fieldPlaceholder.toggleClass('hide', true);
                this.$el.append(fieldPlaceholder);
            } else {
                fieldPlaceholder.toggleClass('hide', false);
                this.$(".dropdown-menu").append($('<li>').append(fieldPlaceholder));
                html += '<option value=' + idx + '>' + field.label + '</option>';
                index++;
            }
        }, this);


        if (index < 1) {
            this.$(".dropdown-toggle").hide();
        } else {
            this.$(".dropdown-toggle").show();
        }
        this.$(".dropdown-menu").children("li").each(function (index, el) {
            if ($(el).html() === '') {
                $(el).remove();
            }
        });
        if (app.utils.isTouchDevice()) {
            selectEl.html(html);
        }
    },
    unbindData: function() {
        var collection = this.context.get('mass_collection');
        if (collection) {
            var modelId = this.model.cid,
                cid = this.view.cid;
            collection.off(null, null, this);
            if (modelId) {
                collection.off(null, null, modelId);
            }
            if (cid) {
                collection.off(null, null, cid);
            }
        }
        if (this.collection) {
            this.collection.off("reset", null, this);
        }
        this.off("render", null, this);
        app.view.Field.prototype.unbindData.call(this);
    },
    _dispose: function() {
        _.each(this.fields, function(field) {
            field.parent = null;
            field.dispose();
        });
        this.fields = null;
        app.view.Field.prototype._dispose.call(this);
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
     * No need to unbind DOM changes to a model.
     */
    unbindDom: function () {
    }
})
