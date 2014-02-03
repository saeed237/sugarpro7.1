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
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td width='99%' class="dataField">
{$fields.{{$displayParams.key}}_address_street.value|nl2br}<br>
{$fields.{{$displayParams.key}}_address_postalcode.value}&nbsp;{$fields.{{$displayParams.key}}_address_city.value}<br>
{$fields.{{$displayParams.key}}_address_country.value}
</td>
<td class='dataField' width='1%'>
{{* 
This is custom code that you may set to show on the second column of the address
table.  An example would be the "Copy" button present from the Accounts detailview.
See modules/Accounts/views/view.detail.php to see the value being set 
*}}
{$custom_code_{{$displayParams.key}}}
</td>
</tr>
</table>
