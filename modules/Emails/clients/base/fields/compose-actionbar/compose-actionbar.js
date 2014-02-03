(/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Master Subscription
 * Agreement (""License"") which can be viewed at
 * http://www.sugarcrm.com/crm/master-subscription-agreement
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the ""Powered by SugarCRM"" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2012 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/
/**
 * Actionbar for the email compose view
 *
 * Def for this field includes an array called buttonSections
 * Each object in the array can have a type (corresponding to a field that extends from fieldset and includes an array of buttons)
 * Or if object contains no type, a button group is built by default using the buttons array in the section
 * Additional CSS can be added to the default button group using the css_class attribute
 */
{
    extendsFrom: 'FieldsetField',
    fields: null,

    events: {
        'click a:not(.dropdown-toggle)': 'handleButtonClick'
    },

    /**
     * Loop over the button sections and build placeholders for each
     *
     * @return {Handlebars.SafeString}
     */
    getPlaceholder: function() {
        var placeholder = app.view.invokeParent(this, {type: 'field', name: 'fieldset', method: 'getPlaceholder'});
        var $container = $(placeholder.toString());

        _.each(this.def.buttonSections, function(buttonSection) {
            var placeHolderString;
            if (!_.isUndefined(buttonSection.type)) {
                placeHolderString = this.buildTypedButtonSection(buttonSection);
            } else {
                placeHolderString = this.buildDefaultButtonSection(buttonSection);
            }
            $container.append(placeHolderString);
        }, this);

        return new Handlebars.SafeString($container.get(0).outerHTML);
    },

    /**
     * If a type was specified on the button section, use the def to build a field of that type
     *
     * @param def
     * @return {String}
     */
    buildTypedButtonSection: function(def) {
        var field = app.view.createField({
            def: def,
            view: this.view,
            viewName: this.options.viewName,
            model: this.model
        });
        this.fields.push(field);

        return field.getPlaceholder().toString();
    },

    /**
     * If button section has no type, build an actions btn-group
     *
     * @param def
     * @return {String}
     */
    buildDefaultButtonSection: function(def) {
        var $defaultSection = $('<div class="actions"></div>');

        if (def.css_class) {
            $defaultSection.addClass(def.css_class);
        }

        _.each(def.buttons, function(button) {
            var field = app.view.createField({
                def: button,
                view: this.view,
                viewName: this.options.viewName,
                model: this.model
            });
            this.fields.push(field);
            $defaultSection.append(field.getPlaceholder().toString());
        }, this);

        return $defaultSection.get(0).outerHTML;
    },

    /**
     * Fire an event when any of the buttons on the actionbar are clicked
     * Events could be set via the data-event attribute or an event is built using the button name
     *
     * @param evt
     */
    handleButtonClick: function(evt) {
        var triggerName, buttonName,
            $currentTarget = $(evt.currentTarget);
        if ($currentTarget.data('event')) {
            triggerName = $currentTarget.data('event');
        } else {
            buttonName = $currentTarget.attr('name') || 'button';
            triggerName = 'actionbar:' + buttonName + ':clicked';
        }
        this.view.context.trigger(triggerName);
    }
})
