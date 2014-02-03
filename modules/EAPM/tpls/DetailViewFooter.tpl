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
<script type="text/javascript" src="modules/EAPM/EAPMEdit.js"></script>
<script type="text/javascript" src="cache/include/externalAPI.cache.js?s={$SUGAR_VERSION}&c={$JS_CUSTOM_VERSION}"></script>
<input type="hidden" name="application_raw" id="application_raw" value="{$fields.application.value}">
<script type="text/javascript">
EAPMFormName = 'DetailView';
EAPMChange();
</script>