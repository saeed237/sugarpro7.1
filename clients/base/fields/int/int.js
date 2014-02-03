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
({unformat:function(value){return app.utils.unformatNumberStringLocale(value,true);},format:function(value){var numberGroupSeparator='',decimalSeparator='';if(!this.def.disable_num_format){numberGroupSeparator=app.user.getPreference('number_grouping_separator')||',';decimalSeparator=app.user.getPreference('decimal_separator')||'.';}
return app.utils.formatNumber(value,0,0,numberGroupSeparator,decimalSeparator);}})