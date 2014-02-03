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

//The SUGAR namespace must be defined
SUGAR = SUGAR || {};
(function(S) {
    S.util = S.util || {};
    var oldFunction = S.util.ajaxCallInProgress;
    /**
     * SUGAR.util.ajaxCallInProgress will return true when a ajax call is pending
     * to allow tools to detect when a given page has truely finished loading.
     */
    S.util.ajaxCallInProgress = function(){
        //Call the previous version of ajaxCallInProgress if it exists
        //This would mean we are running sidecar in sugar, so a call can come from either
        if (oldFunction && oldFunction())
            return true;

        return SUGAR.Api.getCallsInProgressCount() > 0;
    };
})(SUGAR);