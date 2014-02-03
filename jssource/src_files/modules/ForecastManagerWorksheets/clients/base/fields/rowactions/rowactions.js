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
 * Override the Rowactions Fields to display both next to each other, vs one being in a dropdown.
 *
 * ** Note **
 * This might go away later depending on what UIUX has to say
 */
({
    extendsFrom: 'RowactionsField',

    /**
     * {@inheritDoc}
     */
    initialize: function(options) {
        app.view.invokeParent(this, {type: 'field', name: 'rowactions', method: 'initialize', args: [options]});
        this.setPlaceholder = _.throttle(this.customSetPlaceholder, 100);
    },

    /**
     * {@inheritDoc}
     */
    getPlaceholder: function() {
        var placeholder = app.view.Field.prototype.getPlaceholder.call(this),
            $container = $(placeholder.toString()),
            $caret = $('<a class="btn dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="icon-caret-down"></i></a>'),
            $dropdown = $('<ul class="dropdown-menu"></ul>');

        if(this.def.primary) {
            $caret.addClass('btn-primary');
        }

        _.each(this.def.buttons, function(fieldDef, index, list) {
            var field = app.view.createField({
                def: fieldDef,
                view: this.view,
                viewName: this.options.viewName,
                model: this.model
            });
            this.fields.push(field);
            field.on('show hide', this.setPlaceholder, this);
            field.parent = this;
            if(index == 0) {
                $container.append(field.getPlaceholder().toString());
            } else {
                if(index == 1) {
                    $container.addClass('actions btn-group');

                    if(list.length > 2) {
                        $container.append($caret)
                            .append($dropdown);
                    }
                }
                if(list.length > 2) {
                    $dropdown.append('<li>' + field.getPlaceholder().toString() + '</li>');
                } else {
                    $container.append(field.getPlaceholder().toString());
                }
            }

        }, this);
        return new Handlebars.SafeString($container.get(0).outerHTML);
    },

    /**
     * This function will be needed when we implement SFA-165 where there is a preview button
     * and the history icon both in the same table cell
     *
     * todo-sfa clean up this function when we do SFA-165
     */
    customSetPlaceholder: function() {
        if(this.$el) {
            var index = 0;
            _.each(this.fields, function(field, idx, list){
                var fieldPlaceholder = this.$("span[sfuuid='" + field.sfId + "']");
                if(field.isHidden) {
                    fieldPlaceholder.toggleClass('hide', true);
                    //Drop this field out of the dropdown
                    this.$el.append(fieldPlaceholder);
                } else {
                    fieldPlaceholder.toggleClass('hide', false);
                    if(index == 0 || list.length == 2) {
                        field.getFieldElement().addClass("btn");
                        if(this.def.primary) {
                            field.getFieldElement().addClass("btn-primary");
                        }
                        //The first field needs to be out of the dropdown
                        if(index == 0) {
                            this.$el.prepend(fieldPlaceholder);
                        } else {
                            this.$el.append(fieldPlaceholder);
                        }
                    } else {
                        field.getFieldElement().removeClass("btn btn-primary");
                        //Append field into the dropdown
                        this.$(".dropdown-menu").append($('<li>').html(fieldPlaceholder));
                    }
                    index++;
                }
            }, this);

            if(index <= 1) {
                this.$(".dropdown-toggle").hide();
                this.$el.removeClass('btn-group');
            } else {
                this.$(".dropdown-toggle").show();
                this.$el.addClass('btn-group');
            }
            this.$(".dropdown-menu").children("li").each(function(index, el){
                if($(el).html() === '') {
                    $(el).remove();
                }
            });
        }
    }
})
