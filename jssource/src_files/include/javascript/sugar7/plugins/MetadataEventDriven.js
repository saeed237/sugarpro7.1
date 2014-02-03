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
 * Plugin provide way for fields to handle events specified in metadata.
 * You can specify those events in metadata as:
 *
 * <pre><code>
 * events: {
 *     handler: "fire:some:event";
 * }
 * </code></pre>
 *
 * The default behavior triggers event on `this.view.context` and
 * `this.view.layout` if they exist.
 */
(function(app) {
    app.events.on('app:init', function() {
        app.plugins.register('MetadataEventDriven', ['field'], {
            /**
             * Triggers event.
             * @param {Event} domEvent Original DOM event.
             * @param {String} metadataEvent Name of event to trigger.
             */
            triggerMetadataEvent: function(domEvent, metadataEvent) {
                if (this.view.context) {
                    this.view.context.trigger(metadataEvent);
                }
                if (this.view.layout) {
                    this.view.layout.trigger(metadataEvent);
                }
            }
        });
    });
})(SUGAR.App);
