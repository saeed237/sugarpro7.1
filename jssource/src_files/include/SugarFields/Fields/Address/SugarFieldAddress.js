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

(function(){
    var Dom = YAHOO.util.Dom,
        Event = YAHOO.util.Event;

    SUGAR.AddressField = function(checkId, fromKey, toKey){
        this.fromKey = fromKey;
        this.toKey = toKey;
        Event.onAvailable(checkId, this.testCheckboxReady, this);
    }

    SUGAR.AddressField.prototype = {
        elems  : ["address_street", "address_city", "address_state", "address_postalcode", "address_country"],
        tHasText : false,
        syncAddressCheckbox : true,
        originalBgColor : '#FFFFFF',
        testCheckboxReady : function (obj) {
            for(var x in obj.elems) {
                var f = obj.fromKey + "_" +obj.elems[x];
                var t = obj.toKey + "_" + obj.elems[x];

                var e1 = Dom.get(t);
                var e2 = Dom.get(f);

                if(e1 != null && typeof e1 != "undefined" && e2 != null && typeof e2 != "undefined") {

                    if(!obj.tHasText && YAHOO.lang.trim(e1.value) != "") {
                       obj.tHasText = true;
                    }

                    if(e1.value != e2.value)
                    {
                       obj.syncAddressCheckbox = false;
                       break;
                    }
                    obj.originalBgColor = e1.style.backgroundColor;
                }
            }

            if(obj.tHasText && obj.syncAddressCheckbox)
            {
               Dom.get(this.id).checked = true;
               obj.syncFields();
            }
        },
        writeToSyncField : function(e) {
            var fromEl = Event.getTarget(e, true);
            if(typeof fromEl != "undefined") {
                var toEl = Dom.get(fromEl.id.replace(this.fromKey, this.toKey));
                var update = toEl.value != fromEl.value;
                toEl.value = fromEl.value;
                if (update) SUGAR.util.callOnChangeListers(toEl);
            }
        },
        syncFields : function (fromKey, toKey) {
            var fk = this.fromKey, tk = this.toKey;
            for(var x in this.elems) {
                var f = fk + "_" + this.elems[x];
                var e2 = Dom.get(f);
                var t = tk + "_" + this.elems[x];
                var e1 = Dom.get(t);
                if(e1 != null && typeof e1 != "undefined" && e2 != null && typeof e2 != "undefined") {
                    if(!Dom.get(tk + '_checkbox').checked) {
                        Dom.setStyle(e1,'backgroundColor',this.originalBgColor);
                        e1.removeAttribute('readOnly');
                        Event.removeListener(e2, 'change', this.writeToSyncField);
                    } else {
                        var update = e1.value != e2.value;
                        e1.value = e2.value;
                        if (update) SUGAR.util.callOnChangeListers(e1);
                        Dom.setStyle(e1,'backgroundColor','#DCDCDC');
                        e1.setAttribute('readOnly', true);
                        
                        Event.addListener(e2, 'change', this.writeToSyncField, this, true);
                    }
                }
            }
        }
    };
})();

