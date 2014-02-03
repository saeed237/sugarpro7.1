{*

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




*}
<input type="hidden" id="{$dashletId}_offset" name="{$dashletId}_offset" value="0">
<input type="hidden" id="{$dashletId}_interval" name="{$dashletId}_interval" value="{$dashletRefreshInterval}">
<script type='text/javascript'>
<!--
document.getElementById("{$dashletId}_offset").value = "{$dashletOffset}";
document.getElementById("{$dashletId}_interval").value = "{$dashletRefreshInterval}";
if (typeof autoRefreshProcId{$strippedDashletId} != 'undefined') {ldelim}
    clearInterval(autoRefreshProcId{$strippedDashletId});
{rdelim}
if(document.getElementById("{$dashletId}_interval").value > 0) {ldelim}
    if (typeof refreshDashlet{$strippedDashletId} == 'undefined') {ldelim}
        function refreshDashlet{$strippedDashletId}() 
        {ldelim}
            //refresh only if offset is 0
            if (SUGAR.mySugar && document.getElementById("{$dashletId}_offset").value == '0' ) {ldelim}
                SUGAR.mySugar.retrieveDashlet("{$dashletId}","{$url}");
            {rdelim}
        {rdelim}
    {rdelim}
    autoRefreshProcId{$strippedDashletId} = setInterval('refreshDashlet{$strippedDashletId}()', document.getElementById("{$dashletId}_interval").value);
{rdelim}
-->
</script>