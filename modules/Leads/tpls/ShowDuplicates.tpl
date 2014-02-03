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
{$TITLE}
<p>
<form action='index.php' method='post' name='Save'>
<input type="hidden" name="module" value="Leads">
<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
<input type="hidden" name="return_action" value="{$RETURN_ACTION}">
<input type="hidden" name="return_id" value="{$RETURN_ID}">
<input type="hidden" name="inbound_email_id" value="{$INBOUND_EMAIL_ID}">
<input type="hidden" name="start" value="{$START}">
<input type="hidden" name="dup_checked" value="true">
<input type="hidden" name="action" value="">
{$INPUT_FIELDS}
<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr>
<td  valign='top' align='left'>{$FORMBODY}{$FORMFOOTER}{$POSTFORM}</td>
</tr>
</table>
</td>
</tr>
</table>
<p>
