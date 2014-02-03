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

(function(app) {
    /**
     * Events proxy object. For inter-component communications, please register your events and please subscribe
     * your events from the events hub. This allows components to not depend on each other in a tightly coupled capacity.
     *
     * <pre><code>
     * (function(app) {
     *   var foo = {
     *     initialize: function() {
     *         // Register the event with the events hub.
     *         app.events.register("mynamespaced:event", this);
     *     },
     *     action: function() {
     *         // Broadcast you revent to the events hub.
     *         // The events hub will then broadcast this event to all its subscribers.
     *         this.trigger("mynamespaced:event");
     *     }
     *   }
     *
     *   var bar = {
     *     initialize: function() {
     *         // Call a callback when the event is received.
     *         app.events.on("mynamespaced:event", function() {
     *             alert("Event!");
     *         });
     *     }
     *   }
     *
     * })(SUGAR.App);
     * </pre></code>
     * @class Core.Events
     * @singleton
     * @alias SUGAR.App.events
     */
    app.augment("events", _.extend({

        /**
         * Registers an event with the event proxy.
         *
         * @param {String} event The name of the event.
         * A good practice is to namespace your events with a colon. For example: `"app:start"`
         * @param {Backbone.Events} context The object that will trigger the event.
         * @method
         */
        register: function(event, context) {
            context.on(event, function() {
                var args = [].slice.call(arguments, 0);
                args.unshift(event);
                this.trigger.apply(this, args);
            }, this);
        },

        /**
         * Unregisters an event from the event proxy.
         *
         * @param {Object} context Source to be cleared from
         * @param {String} event(optional) Event name to be cleared
         * @method
         */
        unregister: function(context, event) {
            context.off(event);
        },

        /**
         * Subscribe to global ajax events.
         */
        registerAjaxEvents: function() {
            var self = this;

            // First unbind then rebind
            $(document).off("ajaxStop");
            $(document).off("ajaxStart");

            $(document).on("ajaxStart", function(args) {
                self.trigger("ajaxStart", args);
            });

            $(document).on("ajaxStop", function(args) {
                self.trigger("ajaxStop", args);
            });
        }
    }, Backbone.Events));
    
})(SUGAR.App);
