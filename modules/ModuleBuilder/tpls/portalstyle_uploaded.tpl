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
{literal}
<script language='javascript'>
iframe = parent.document.getElementById('style_preview');
if(iframe) {
    tail='&r='+Math.round(Math.random*10000);
	iframe.src = 'index.php?module=ModuleBuilder&action=portalpreview&to_pdf=1' + tail;
}
{/literal}
parent.document.getElementById('uploadLabel').innerHTML = '{$mod.LBL_SP_UPLOADED}';
</script>
