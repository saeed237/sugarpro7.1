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
<input type=hidden name='emailAddressWidget' value=1>
<table cellpadding="0" cellspacing="0" border="0" >
	<tr>
		<td  valign="top" NOWRAP>
			<table cellpadding="0" cellspacing="0" border="0" id="{$module}emailAddressesTable0">
			    <tr>
			        <td>
			            <input type="hidden" value="0" name="{$module}_email_widget_id" id="{$module}_email_widget_id" />
			            <input type="hidden" value="1" name="emailAddressWidget" id="emailAddressWidget" />
                    </td>
                </tr>
				{foreach from=$prefillData item="record" name="recordlist"}
                <tr id="{$module}0emailAddressRow{$smarty.foreach.recordlist.index}">
                    <td classname="dataLabel" class="tabEditViewDF" nowrap="NOWRAP">
                        <input value="{$record.email_address}" size="20" 
                            id="{$module}0emailAddress{$smarty.foreach.recordlist.index}" name="{$module}0emailAddress{$smarty.foreach.recordlist.index}" type="text"><br>
                        <input enabled="true" {if $record.primary_address == '1'}checked="true"{/if} enabled="{if $record.primary_address == '1'}true{else}false{/if}" value="{$module}0emailAddress{$smarty.foreach.recordlist.index}" 
                            id="{$module}0emailAddressPrimaryFlag{$smarty.foreach.recordlist.index}" name="{$module}0emailAddressPrimaryFlag" type="radio">{$app_strings.LBL_EMAIL_PRIMARY}<br>
                        <input enabled="true" {if $record.opt_out == '1'}checked="true"{/if} value="{$module}0emailAddress{$smarty.foreach.recordlist.index}" 
                            id="{$module}0emailAddressOptOutFlag{$smarty.foreach.recordlist.index}" name="{$module}0emailAddressOptOutFlag[]" type="checkbox">{$app_strings.LBL_EMAIL_OPT_OUT}<br>
                        <input enabled="true" {if $record.invalid_email == '1'}checked="true"{/if} value="{$module}0emailAddress{$smarty.foreach.recordlist.index}" 
                            id="{$module}0emailAddressInvalidFlag{$smarty.foreach.recordlist.index}" name="{$module}0emailAddressInvalidFlag[]" type="checkbox">{$app_strings.LBL_EMAIL_INVALID}<br>
                        <input enabled="true" value="{$module}0emailAddress{$smarty.foreach.recordlist.index}" 
                            id="{$module}0emailAddressDeleteFlag{$smarty.foreach.recordlist.index}" name="{$module}0emailAddressDeleteFlag[]" type="checkbox">{$app_strings.LBL_EMAIL_DELETE}<br>
                    </td>
                </tr>
                {/foreach}
                <tr id="{$module}0emailAddressRow{$smarty.foreach.recordlist.total}">
                    <td classname="dataLabel" class="tabEditViewDF" nowrap="NOWRAP">
                        <b>{$app_strings.LBL_EMAIL_ADD}</b><br />
                        <input value="" size="20" 
                            id="{$module}0emailAddress{$smarty.foreach.recordlist.total}" name="{$module}0emailAddress{$smarty.foreach.recordlist.total}" type="text"><br>
                        <input enabled="true" value="{$module}0emailAddress{$smarty.foreach.recordlist.total}" 
                            id="{$module}0emailAddressPrimaryFlag{$smarty.foreach.recordlist.total}" name="{$module}0emailAddressPrimaryFlag" type="radio"{if $noemail} checked="true"{/if}>{$app_strings.LBL_EMAIL_PRIMARY}<br>
                        <input enabled="true" value="{$module}0emailAddress{$smarty.foreach.recordlist.total}" 
                            id="{$module}0emailAddressOptOutFlag{$smarty.foreach.recordlist.total}" name="{$module}0emailAddressOptOutFlag[]" type="checkbox">{$app_strings.LBL_EMAIL_OPT_OUT}<br>
                        <input enabled="true" value="{$module}0emailAddress{$smarty.foreach.recordlist.total}" 
                            id="{$module}0emailAddressInvalidFlag{$smarty.foreach.recordlist.total}" name="{$module}0emailAddressInvalidFlag[]" type="checkbox">{$app_strings.LBL_EMAIL_INVALID}<br>
                    </td>
                </tr>
			</table>
		</td>
	</tr>
</table>
<input type="hidden" name="useEmailWidget" value="true">
