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

(function(app) {
    app.events.on('app:init', function() {
        app.plugins.register('File', ['field'], {
            /**
             * Asynchronously uploads files on toggle.
             *
             * @param {Object} component
             * @param {Object} plugin
             * @return {void}
             */
            onAttach: function(component, plugin) {
                this.before('toggleField', function(viewName) {
                    if (this.action === 'edit') {
                        app.file.checkFileFieldsAndProcessUpload(this, null, {deleteIfFails: false}, true);
                    }
                    return true;
                }, null, this);
            },
            /**
             * TODO: Empty function shouldn't be needed when SC-1576 is fixed.
             *
             * {@inheritDoc}
             * @return {void}
             */
            bindKeyDown: function() {},
            /**
             * TODO: Empty function shouldn't be needed when SC-1576 is fixed.
             *
             * {@inheritDoc}
             * @return {void}
             */
            bindDocumentMouseDown: function() {}
        });
    });
})(SUGAR.App);
