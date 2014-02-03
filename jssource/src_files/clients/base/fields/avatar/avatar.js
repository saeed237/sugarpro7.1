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
({
    extendsFrom: 'ImageField',
    plugins: ['File','Tooltip'],
    /**
     * @override
     * @private
     */
    _render: function() {
        var template;
        app.view.invokeParent(this, {type: 'field', name: 'image', method: '_render'});
        if (this.action !== 'edit') {
            if (_.isEmpty(this.value)) {
                // replace the image field with the module icon when there is no avatar to display
                // load the module icon template
                template = app.template.getField(this.type, 'module-icon', this.module);
                if (template) {
                    this.$('.image_field').replaceWith(template({module: this.module}));
                }
            } else {
                // add the image_rounded class to the image_field div when there is an avatar to display
                this.$('.image_field').addClass('image_rounded');
            }
        }
        return this;
    },
    /**
     * To inherit templates from the image field, we want to tell sidecar to load the templates from the image field's
     * directory. To do this, we must change this.type to "image" temporarily. We want to restore this.type before
     * exiting, however, so that we don't really change the field's attributes.
     *
     * Beware that this causes sidecar to never automatically load any templates found in the avatar field's directory.
     * Sidecar will always look for templates in the image field's directory, by default.
     *
     * @override
     * @private
     */
    _loadTemplate: function() {
        this.type = 'image';
        app.view.invokeParent(this, {type: 'field', name: 'image', method: '_loadTemplate'});
        this.type = this.def.type;
    }
})
