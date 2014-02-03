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
<input type="hidden" name="{$moduleDir}_email_widget_id" value="{$email_widget_id}">
<input type="hidden" name="emailAddressWidget" value="{$emailAddressWidget}">
{counter assign="count" start=-1 print=false}
{foreach from=$emails item=email}
<input type="hidden" name="{$moduleDir}{$email_widget_id}emailAddress{counter print=true}" value="{$email}">
{/foreach}
{counter assign="count" start=-1 print=false}
{foreach from=$verified item=email}
<input type="hidden" name="{$moduleDir}{$email_widget_id}emailAddressVerifiedValue{counter print=true}" value="{$email}">
{/foreach}
{if isset($primary)}
<input type="hidden" name="{$moduleDir}{$email_widget_id}emailAddressPrimaryFlag" value="{$primary}">
{/if}
{foreach from=$optOut item=email}
<input type="hidden" name="{$moduleDir}{$email_widget_id}emailAddressOptOutFlag[]" value="{$email}">
{/foreach}
{foreach from=$invalid item=email}
<input type="hidden" name="{$moduleDir}{$email_widget_id}emailAddressInvalidFlag[]" value="{$email}">
{/foreach}
{foreach from=$replyTo item=email}
<input type="hidden" name="{$moduleDir}{$email_widget_id}emailAddressReplyToFlag[]" value="{$email}">
{/foreach}
{foreach from=$delete item=email}
<input type="hidden" name="{$moduleDir}{$email_widget_id}emailAddressDeleteFlag[]" value="{$email}">
{/foreach}
<input type="hidden" name="useEmailWidget" value="true">
