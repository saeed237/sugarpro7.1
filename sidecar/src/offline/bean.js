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

    var _updateProperty = function(bean, prop, attr, obj) {
        //"use strict";
        if (prop in obj) {
            bean[attr] = obj[prop];
            obj[prop] = undefined;
            // TODO: delete doesn't work because the obj is frozen
            // https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Object/getOwnPropertyDescriptor
            //delete obj[prop];
        }
        return false;
    };

    app.Offline.Bean = app.Bean.extend({

        initialize: function(attrs) {
            this.syncState = null;
            this.modifiedAt = null;
            return app.Bean.prototype.initialize.call(this, attrs);
        },

        set: function(attrs, options) {
            // I want to handle syncState and modifiedAt separately from the attrs hash
            // TODO: Am I overcomplicating things?
            if (attrs) {
                _updateProperty(this, '_sync_state', 'syncState', attrs);
                _updateProperty(this, '_modified_at', 'modifiedAt', attrs);
            }
            return app.Bean.prototype.set.call(this, attrs, options);
        },

        toString: function() {
            return app.Bean.prototype.toString.call(this) + " [" + this.syncState + "/" + this.modifiedAt + "]";
        }

    });

})(SUGAR.App);