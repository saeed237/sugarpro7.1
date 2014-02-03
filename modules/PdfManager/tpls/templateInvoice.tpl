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
<table border="0" cellspacing="2">
<tbody>
<tr>
<td rowspan="6" width="180%"><img src="{$logoUrl}" alt="" /></td>
<td width="60%"><strong>{$MOD.LBL_TPL_INVOICE}</strong></td>
<td width="60%">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#DCDCDC" width="75%">{$MOD.LBL_TPL_INVOICE_NUMBER}</td>
<td width="75%">{literal}{$fields.quote_num}{/literal}</td>
</tr>
<tr>
<td bgcolor="#DCDCDC" width="75%">{$MOD.LBL_TPL_SALES_PERSON}</td>
<td width="75%">{literal}{$fields.assigned_user_link.name}{/literal}</td>
</tr>
<tr>
<td bgcolor="#DCDCDC" width="75%">{$MOD.LBL_TPL_VALID_UNTIL}</td>
<td width="75%">{literal}{$fields.date_quote_expected_closed}{/literal}</td>
</tr>
<tr>
<td bgcolor="#DCDCDC" width="75%">{$MOD.LBL_PURCHASE_ORDER_NUM}</td>
<td width="75%">{literal}{$fields.purchase_order_num}{/literal}</td>
</tr>
<tr>
<td bgcolor="#DCDCDC" width="75%">{$MOD.LBL_PAYMENT_TERMS}</td>
<td width="75%">{literal}{$fields.payment_terms}{/literal}</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<table style="width: 50%;" border="0" cellspacing="2">
<tbody>
<tr style="color: #ffffff;" bgcolor="#4B4B4B">
<td>{$MOD.LBL_TPL_BILL_TO}</td>
<td>{$MOD.LBL_TPL_SHIP_TO}</td>
</tr>
<tr>
<td>{literal}{$fields.billing_contact_name}{/literal}</td>
<td>{literal}{$fields.shipping_contact_name}{/literal}</td>
</tr>
<tr>
<td>{literal}{$fields.billing_account_name}{/literal}</td>
<td>{literal}{$fields.shipping_account_name}{/literal}</td>
</tr>
<tr>
<td>{literal}{$fields.billing_address_street}{/literal}</td>
<td>{literal}{$fields.shipping_address_street}{/literal}</td>
</tr>
<tr>
<td>{literal}{if $fields.billing_address_city!=""}{$fields.billing_address_city},{/if} {if $fields.billing_address_state!=""}{$fields.billing_address_state},{/if} {$fields.billing_address_postalcode}{/literal}</td>
<td>{literal}{if $fields.shipping_address_city!=""}{$fields.shipping_address_city},{/if} {if $fields.shipping_address_state!=""}{$fields.shipping_address_state},{/if} {$fields.shipping_address_postalcode}{/literal}</td>
</tr>
<tr>
<td>{literal}{$fields.billing_address_country}{/literal}</td>
<td>{literal}{$fields.shipping_address_country}{/literal}</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
{literal}{foreach from=$product_bundles item="bundle"}{/literal}
<p>&nbsp;</p>
<h3>{literal}{$bundle.name}{/literal}</h3>
<table style="width: 100%;" border="0">
<tbody>
<tr style="color: #ffffff;" bgcolor="#4B4B4B">
<td width="70%">{$MOD.LBL_TPL_QUANTITY}</td>
<td width="175%">{$MOD.LBL_TPL_PART_NUMBER}</td>
<td width="175%">{$MOD.LBL_TPL_PRODUCT}</td>
<td width="70%">{$MOD.LBL_TPL_LIST_PRICE}</td>
<td width="70%">{$MOD.LBL_TPL_UNIT_PRICE}</td>
<td width="70%">{$MOD.LBL_TPL_EXT_PRICE}</td>
<td width="70%">{$MOD.LBL_TPL_DISCOUNT}</td>
</tr>
<!--START_PRODUCT_LOOP-->
<tr>
<td width="70%">{literal}{$product.quantity}{/literal}</td>
<td width="175%">{literal}{$product.mft_part_num}{/literal}</td>
<td width="175%">{literal}{$product.name}{if isset($product.list_price)}<br></br>{$product.description}{/if}{/literal}</td>
<td align="right" width="70%">{literal}{$product.list_price}{/literal}</td>
<td align="right" width="70%">{literal}{$product.discount_price}{/literal}</td>
<td align="right" width="70%">{literal}{$product.ext_price}{/literal}</td>
<td align="right" width="70%">{literal}{$product.discount_amount}{/literal}</td>
</tr>
<!--END_PRODUCT_LOOP--></tbody>
</table>
<table>
<tbody>
<tr>
<td><hr /></td>
</tr>
</tbody>
</table>
<table style="width: 100%; margin: auto;" border="0">
<tbody>
<tr>
<td width="210%">&nbsp;</td>
<td width="45%">{$MOD.LBL_TPL_SUBTOTAL}</td>
<td align="right" width="45%">{literal}{$bundle.subtotal}{/literal}</td>
</tr>
<tr>
<td width="210%">&nbsp;</td>
<td width="45%">{$MOD.LBL_TPL_DISCOUNT}</td>
<td align="right" width="45%">{literal}{$bundle.deal_tot}{/literal}</td>
</tr>
<tr>
<td width="210%">&nbsp;</td>
<td width="45%">{$MOD.LBL_TPL_DISCOUNTED_SUBTOTAL}</td>
<td align="right" width="45%">{literal}{$bundle.new_sub}{/literal}</td>
</tr>
<tr>
<td width="210%">&nbsp;</td>
<td width="45%">{$MOD.LBL_TPL_TAX}</td>
<td align="right" width="45%">{literal}{$bundle.tax}{/literal}</td>
</tr>
<tr>
<td width="210%">&nbsp;</td>
<td width="45%">{$MOD.LBL_TPL_SHIPPING}</td>
<td align="right" width="45%">{literal}{$bundle.shipping}{/literal}</td>
</tr>
<tr>
<td width="210%">&nbsp;</td>
<td width="45%">{$MOD.LBL_TPL_TOTAL}</td>
<td align="right" width="45%">{literal}{$bundle.total}{/literal}</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
{literal}{/foreach}{/literal}
<p>&nbsp;</p>
<p>&nbsp;</p>
<table>
<tbody>
<tr>
<td><hr /></td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<table style="width: 100%; margin: auto;" border="0">
<tbody>
<tr>
<td width="200%">&nbsp;</td>
<td style="font-weight: bold;" colspan="2" align="center" width="150%"><b>{$MOD.LBL_TPL_GRAND_TOTAL}</b></td>
<td width="75%">&nbsp;</td>
<td align="right" width="75%">&nbsp;</td>
</tr>
<tr>
<td width="200%">&nbsp;</td>
<td width="75%">{$MOD.LBL_TPL_CURRENCY}</td>
<td width="75%">{literal}{$fields.currency_iso}{/literal}</td>
<td width="75%">{$MOD.LBL_TPL_SUBTOTAL}</td>
<td align="right" width="75%">{literal}{$fields.subtotal}{/literal}</td>
</tr>
<tr>
<td width="200%">&nbsp;</td>
<td width="75%">&nbsp;</td>
<td align="right" width="75%">&nbsp;</td>
<td width="75%">{$MOD.LBL_TPL_DISCOUNT}</td>
<td align="right" width="75%">{literal}{$fields.deal_tot}{/literal}</td>
</tr>
<tr>
<td width="200%">&nbsp;</td>
<td width="75%">&nbsp;</td>
<td width="75%">&nbsp;</td>
<td width="75%">{$MOD.LBL_TPL_DISCOUNTED_SUBTOTAL}</td>
<td align="right" width="75%">{literal}{$fields.new_sub}{/literal}</td>
</tr>
<tr>
<td width="200%">&nbsp;</td>
<td width="75%">{$MOD.LBL_TPL_TAX_RATE}</td>
<td width="75%">{literal}{$fields.taxrate_value}{/literal}</td>
<td width="75%">{$MOD.LBL_TPL_TAX}</td>
<td align="right" width="75%">{literal}{$fields.tax}{/literal}</td>
</tr>
<tr>
<td width="200%">&nbsp;</td>
<td width="75%">{$MOD.LBL_TPL_SHIPPING_PROVIDER}</td>
<td width="75%">{literal}{$fields.shipper_name}{/literal}</td>
<td width="75%">{$MOD.LBL_TPL_SHIPPING}</td>
<td align="right" width="75%">{literal}{$fields.shipping}{/literal}</td>
</tr>
<tr>
<td width="200%">&nbsp;</td>
<td width="75%">&nbsp;</td>
<td width="75%">&nbsp;</td>
<td width="75%">{$MOD.LBL_TPL_TOTAL}</td>
<td align="right" width="75%">{literal}{$fields.total}{/literal}</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<table>
<tbody>
<tr>
<td><hr /></td>
</tr>
</tbody>
</table>
