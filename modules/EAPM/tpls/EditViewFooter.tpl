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
<script type="text/javascript">
EAPMFormName = 'EditView';
EAPMOAuthNotice = '{$MOD.LBL_OAUTH_SAVE_NOTICE}';
EAPMBAsicAuthNotice = '{$MOD.LBL_BASIC_SAVE_NOTICE}';
YAHOO.util.Event.onDOMReady(function() {ldelim}
EAPMEditStart(
{if is_admin($current_user) } true {else} false {/if}
);
{rdelim});
</script>