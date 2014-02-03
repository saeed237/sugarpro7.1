
(function(app) {

    _.extend(app, {"beforeEvent" : {
/**
         * Add a callback/hook to be fired before an action is taken. If that callback returns false,
         * the action will not be taken. The only action supported in the base component is render.
         *
         * @param event String event to trigger before
         * @param callback Function to be called
         * @param params Object to pass as the paramter to the callback
         * @param scope Object|Boolean If scope is an object, it will be assign to this when the callback is fired.
         * If scope is true, then params will be used as this for the callback.
         * @return {*}
         */
        before : function(event, callback, params, scope){
            var events = this._before = this._before || {};
            events[event] = events[event] || [];

            events[event].push({
                fn:callback,
                params:params,
                overrideContext:scope
            });

            return this;
        },

        /**
         * Trigger the before listener for an action.
         * @param String event the action to check before on
         * @param Object params parameter object to pass to the callbacks
         * @return {Boolean}
         */
        triggerBefore : function(event, params) {
            var stop = false;
            if (this._before && this._before[event]) {
                var calls = this._before[event];
                for (var i = 0; i < calls.length; i++) {
                    var c = calls[i];
                    var context = this;
                    if (c.overrideContext) {
                        if (c.overrideContext === true) {
                            context = c.params;
                        } else {
                            context = c.overrideContext;
                        }
                    }
                    var p = params;
                    if (params && c.params)
                        p = _.extend({}, params, c.params);
                    else
                        p = c.params || params;
                    if (c.fn) {
                        stop = stop || (c.fn.call(context, p) === false);
                    }
                }
            }

            return !stop;
        },

        /**
         * Removes listeners to the before events.
         * @param String event Event to remove the listeners for. If ommited all listeners to all event will be removed.
         * @param Function callback Optional callback to remove specifically for a given event.
         * @param Object scope optinal scope to use when determining which callback to remove
         * @return {Boolean}
         */
        offBefore : function(event, callback, scope) {
            //Remove all before listeners
            if (!event)
                return delete this._before;

            var events = this._before = this._before || {};

            //No event found
            if (!events[event])
                return false;
            //Delete all listeners for this before event
            if (!callback && !scope)
                return delete events[event];

            var calls = events[event];
            for (var i = calls.length - 1; i >= 0 ; i--) {
                var c = calls[i];
                var context = this;
                if (c.overrideContext) {
                    if (c.overrideContext === true) {
                        context = c.params;
                    } else {
                        context = c.overrideContext;
                    }
                }
                if (c.fn == callback && (!scope || scope == context))
                    calls.splice(i, 1);
            }
            return true;
        }

}});

})(SUGAR.App);
