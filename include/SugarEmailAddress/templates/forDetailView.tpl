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

			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				{foreach from=$emailAddresses item=address}
				<tr>
					<td style="border:none;">
						{if $address.key === 'opt_out' || $address.key === 'invalid' || $address.key === 'opt_out_invalid'}
							<span style="text-decoration: line-through;">
						{elseif $address.key === 'primary'}
							<b>
						{elseif $address.key === 'reply_to' && $item.key != 0}
							<i>
						{/if}

						{$address.address}

						{if $address.key === 'primary'}
							</b>&nbsp;<i>&#x28;{$app_strings.LBL_EMAIL_PRIMARY}&#x29;&#x200E;</i>
						{elseif $address.key === 'reply_to'}
							&nbsp;<i>&#x28;{$app_strings.LBL_EMAIL_REPLY_TO}&#x29;&#x200E;</i>
						{elseif $address.key === 'opt_out'}
							</span>&nbsp;<i class='error'>&#x28;{$app_strings.LBL_EMAIL_OPT_OUT}&#x29;&#x200E;</i>
						{elseif $address.key === 'invalid'}
							</span>&nbsp;<i>({$app_strings.LBL_EMAIL_INVALID}&#x29;&#x200E;</i>
						{elseif $address.key === 'opt_out_invalid'}
						    </span>&nbsp;<i class='error'>&#x28;{$app_strings.LBL_EMAIL_OPT_OUT_AND_INVALID}&#x29;&#x200E;</i>
						{/if}
					</td>
				</tr>
				{foreachelse}
				<tr>
					<td>
						<i>{$app_strings.LBL_NONE}</i>
					</td>
				</tr>
				{/foreach}
			</table>
