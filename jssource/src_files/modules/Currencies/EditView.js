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

function isoUpdate( formElem ) {
    if ( typeof(js_iso4217[formElem.value]) == 'undefined' ) {
        return false;
    }

    var thisForm = formElem.form;
    var thisCurr = js_iso4217[formElem.value];
    
    if ( thisForm.name.value == '' ) {
        thisForm.name.value = thisCurr.name;
    }
    if ( thisForm.symbol.value == '' ) {
        thisForm.symbol.value = '';
        for ( var i = 0 ; i < thisCurr.unicode.length ; i++ ) {
            thisForm.symbol.value = thisForm.symbol.value + String.fromCharCode(thisCurr.unicode[i]);
        }
    }
    
    return true;
}
