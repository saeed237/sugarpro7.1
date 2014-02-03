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
SUGAR_callsInProgress=0;YAHOO.util.Connect.completeEvent.subscribe(function(event,data){SUGAR_callsInProgress--;if(data[0].conn&&data[0].conn.responseText&&SUGAR.util.isLoginPage(data[0].conn.responseText))
return false;});YAHOO.util.Connect.startEvent.subscribe(function(event,data)
{SUGAR_callsInProgress++;});