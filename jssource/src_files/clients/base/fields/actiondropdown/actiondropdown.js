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
 * Create a dropdown button that contains multiple rowaction fields
 * array(
 *     'type' => 'actiondropdown',
 *     'primary' => true,
 *     'switch_on_click' => true,
 *     'no_default_action' => false,
 *     'icon' => 'icon-cog',
 *     'buttons' => array(
 *         ...
 *     )
 * )
 *     primary: @param {Boolean} true if the entire dropdown group shows as primary.
 *     icon: @param {String} css icon that places on dropdown caret.
 *     switch_on_click: @param {Boolean} true if the selected action needs
 *          to switch against the default action.
 *     no_default_action: @param {Boolean} true if the default action should be empty
 *          and all buttons place under the dropdown action.
 *     buttons: @params {Array} list of actions.
 *          First action goes to the default action (unless no_default_action set as true)
 *
 */
({
    extendsFrom: 'FieldsetField',
    fields: null,
    dropdownFields: null,
    events: {
        'click [data-toggle=dropdown]' : 'renderDropdown',
        'change [data-toggle=dropdownmenu]' : 'dropdownSelected',
        //SC-1993: Dropdown is hidden in touch device by dropdownmenu element,
        // so ontouch dropdownmenu should follow the handler for onclick dropdown
        'touchstart [data-toggle=dropdownmenu]' : 'renderDropdown'
    },
    plugins: ['Tooltip'],

    /**
     * {@inheritDoc}
     *
     * This field doesn't support `showNoData`.
     */
    showNoData: false,

    initialize: function(options) {
        app.view.invokeParent(this, {type: 'field', name: 'fieldset', method: 'initialize', args: [options]});
        this.dropdownFields = [];

        //Throttle the setPlaceholder function per instance of this field.
        // TODO: Calling "across controllers" considered harmful .. please consider using a plugin instead.
        var actiondropdownField = app.view._getController({type: 'field', name: 'actiondropdown'});
        this.setPlaceholder = _.throttle(actiondropdownField.prototype.setPlaceholder, 100);
    },
    renderDropdown: function() {
        if (_.isEmpty(this.dropdownFields) || this.isDisabled()) {
            return;
        }
        _.each(this.dropdownFields, function(field) {
            this.view.fields[field.sfId] = field;
            field.setElement(this.$('span[sfuuid="' + field.sfId + '"]'));
            if (this.def['switch_on_click'] && !this.def['no_default_action']) {
                field.$el.on('click.' + this.cid, _.bind(this.switchButton, this));
            }
            field.render();
        }, this);
        this.dropdownFields = null;

        if (!this.def['switch_on_click'] || this.def['no_default_action']) {
            return;
        }
        var firstField = _.first(this.fields);
        firstField.$el.on('click.' + this.cid, _.bind(this.switchButton, this));
    },
    switchButton: function(evt) {
        var sfId = parseInt(this.$(evt.currentTarget).attr('sfuuid'), 10),
            index = -1;
        _.some(this.fields, function(field, idx) {
            if (field.sfId === sfId) {
                index = idx;
                return true;
            }
            return false;
        }, this);
        if (index <= 0) {
            return;
        }
        //switch the selected button against the first button
        var firstField = this.fields.shift(),
            selectedField = this.fields.splice(index - 1, 1, firstField).pop();
        this.fields.splice(0, 0, selectedField);
        this.setPlaceholder();
    },
    dropdownSelected: function(evt) {
        if (this.isDisabled()) {
            return;
        }
        var $el = this.$(evt.currentTarget),
            selectedIndex = $el.val();
        if (!selectedIndex) {
            return;
        }
        this.fields[selectedIndex].getFieldElement().trigger('click');
        $el.blur();
        this.setPlaceholder();
    },
    getPlaceholder: function() {
        // Covers the use case where you have an actiondropdown field on listview right column,
        // and ListColumnEllipsis plugin is disabled.
        // Actiondropdown will be rendered empty if viewName equals to list-header.
        if (this.options.viewName === 'list-header') return app.view.Field.prototype.getPlaceholder.call(this);

        var caretCss = 'btn dropdown-toggle';
        if (this.def['no_default_action']) {
            caretCss += ' btn-invisible';
        } else if (this.def['primary']) {
            caretCss += ' btn-primary';
        }
        var cssClass = [],
            container = '',
            caretIcon = this.def['icon'] ? this.def['icon'] : 'icon-caret-down',
            caret = '<a class="' + caretCss + '" data-toggle="dropdown" href="javascript:void(0);" data-placement="bottom" rel="tooltip" title="'+app.lang.get('LBL_LISTVIEW_ACTIONS')+'">' +
                '<span class="' + caretIcon + '"></span>' +
                '</a>',
            dropdown = '<ul class="dropdown-menu">';
        if (app.utils.isTouchDevice()) {
            caret += '<select data-toggle="dropdownmenu" class="hide dropdown-menu-select"></select>';
        }
        //Since zero-index points to the default action placeholder,
        //assigning the beginning index to one will skip the default action placeholder
        var index = this.def['no_default_action'] ? 1 : 0;
        _.each(this.def.buttons, function(fieldDef) {
            var field = app.view.createField({
                def: fieldDef,
                view: this.view,
                viewName: this.options.viewName,
                model: this.model
            });
            this.fields.push(field);
            field.on('show hide', this.setPlaceholder, this);
            field.parent = this;
            if (fieldDef.type === 'divider') {
                return;
            }
            if (index == 0) {
                container += field.getPlaceholder();
            } else {
                //first time, unbind the dropdown button fields from the field's list
                //these fields are will be bound once the dropdown toggle is clicked
                delete this.view.fields[field.sfId];
                this.dropdownFields.push(field);

                if (index == 1) {
                    cssClass.push('actions', 'btn-group');
                    container += caret;
                    container += dropdown;
                }
                container += '<li>' + field.getPlaceholder() + '</li>';
            }
            index++;
        }, this);
        var cssName = cssClass.join(' '),
            placeholder = '<span sfuuid="' + this.sfId + '" class="' + cssName + '">' + container;
        placeholder += (_.size(this.def.buttons) > 0) ? '</ul></span>' : '</span>';
        return new Handlebars.SafeString(placeholder);

    },

    _render: function() {
        app.view.invokeParent(this, {type: 'field', name: 'fieldset', method: '_render'});
        this.setPlaceholder();
        this._updateCaret();
    },
    /**
     * Enable or disable caret depending on if there are any enabled actions in the dropdown list
     * @private
     */
    _updateCaret: function() {
        if (_.isEmpty(this.dropdownFields)) {
            return;
        }
        var caretEnabled = _.some(this.dropdownFields, function(field) {
            if (field.hasAccess()) {
                if (field.def.css_class.indexOf('disabled') > -1) { //If action disabled in metadata
                    return false;
                } else if (field.isDisabled()) { //Or disabled via field controller
                    return false;
                } else {
                    return true;
                }
            }
            return false;
        });
        if (!caretEnabled) {
            this.$('.icon-caret-down').closest('a').addClass('disabled');
        }
    },
    setPlaceholder: function() {
        if (this.disposed) {
            return;
        }
        //Since zero-index points to the default action placeholder,
        //assigning the beginning index to one will skip the default action placeholder
        var index = this.def['no_default_action'] ? 1 : 0,
            //Using document fragment to reduce calculating dom tree
            visibleEl = document.createDocumentFragment(),
            hiddenEl = document.createDocumentFragment(),
            selectEl = this.$('.dropdown-menu-select'),
            html = '<option></option>';
        _.each(this.fields, function(field, idx) {
            var cssClass = _.unique(field.def.css_class ? field.def.css_class.split(' ') : []),
                fieldPlaceholder = this.$('span[sfuuid="' + field.sfId + '"]');
            if (field.type === 'divider') {
                //Divider is only attached the below the first dropdown action.
                if (index <= 1) {
                    return;
                }
                var dividerEl = document.createElement('li');
                dividerEl.className = 'divider';
                visibleEl.appendChild(dividerEl);
                return;
            }
            if (field.isVisible() && field.hasAccess()) {
                cssClass = _.without(cssClass, 'hide');
                fieldPlaceholder.toggleClass('hide', false);
                if (index == 0) {
                    cssClass.push('btn');
                    field.getFieldElement().addClass('btn');
                    if (this.def.primary) {
                        cssClass.push('btn-primary');
                        field.getFieldElement().addClass('btn-primary');
                    }
                    //The first field needs to be out of the dropdown
                    this.$el.prepend(fieldPlaceholder);
                } else {
                    cssClass = _.without(cssClass, 'btn', 'btn-primary');
                    field.getFieldElement().removeClass('btn btn-primary');
                    //Append field into the dropdown
                    var dropdownEl = document.createElement('li');
                    dropdownEl.appendChild(fieldPlaceholder.get(0));
                    visibleEl.appendChild(dropdownEl);

                    html += '<option value=' + idx + '>' + field.label + '</option>';
                }
                index++;
            } else {
                cssClass.push('hide');
                fieldPlaceholder.toggleClass('hide', true);
                //Drop hidden field out of the dropdown
                hiddenEl.appendChild(fieldPlaceholder.get(0));
            }
            cssClass = _.unique(cssClass);
            field.def.css_class = cssClass.join(' ');
        }, this);

        if (index <= 1) {
            this.$('.dropdown-toggle').hide();
            selectEl.addClass('hide');
            this.$el.removeClass('btn-group');
        } else {
            this.$('.dropdown-toggle').show();
            selectEl.removeClass('hide');
            this.$el.addClass('btn-group');
        }
        //remove all previous built dropdown tree
        this.$('.dropdown-menu').children('li').remove();
        //and then set the dropdown list with new button list set
        this.$('.dropdown-menu').append(visibleEl);
        this.$el.append(hiddenEl);

        if (app.utils.isTouchDevice()) {
            selectEl.html(html);
        }

        //if the first button is hidden due to the acl,
        //it will build all other dropdown button and set it use dropdown button set
        var firstButton = _.first(this.fields);
        if (firstButton && !firstButton.isVisible()) {
            this.renderDropdown();
        }
    },
    setDisabled: function(disable) {
        app.view.invokeParent(this, {type: 'field', name: 'fieldset', method: 'setDisabled', args: [disable]});
        disable = _.isUndefined(disable) ? true : disable;
        if (disable) {
            this.$('.dropdown-toggle').addClass('disabled');
        } else {
            this.$('.dropdown-toggle').removeClass('disabled');
        }
    },

    _dispose: function() {
        _.each(this.fields, function(field) {
            field.$el.off('click.' + this.cid);
            field.off('show hide', this.setPlaceholder, this);
        }, this);
        this.dropdownFields = null;
        app.view.invokeParent(this, {type: 'field', name: 'fieldset', method: '_dispose'});
    },

    /**
     *  Visibility Check
     */
    isVisible: function() {
        return !this.getFieldElement().is(':hidden');
    }
})
