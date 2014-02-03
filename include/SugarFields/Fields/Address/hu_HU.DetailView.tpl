{*
/*********************************************************************************
 * A fájl telepítésével vagy használatával Ön elismeri, hogy a SugarCRM Inc.
 * szerződött partnereként cégét ("Cég") a SugarCRM Inc. Master Subscription 
 * Agreement ("MSA") köti, amely megtekinthető az alábbi címen:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * Amennyiben Céget nem köti jelenleg MSA, a fájl telepítésével elismeri, hogy
 * a jövőben ez a szerződés létrejön, továbbá hogy Önnek hatalmában áll Cég
 * ilyen fokú elkötelezése. 
 *
 * Copyright (C) 2004-2013 SugarCRM Inc.  Minden jog fenntartva.
 ********************************************************************************/

*}
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td width='99%'>
<input type="hidden" class="sugar_field" id="{{$displayParams.key}}_address_street" value="{$fields.{{$displayParams.key}}_address_street.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="{{$displayParams.key}}_address_city" value="{$fields.{{$displayParams.key}}_address_city.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="{{$displayParams.key}}_address_state" value="{$fields.{{$displayParams.key}}_address_state.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="{{$displayParams.key}}_address_country" value="{$fields.{{$displayParams.key}}_address_country.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="{{$displayParams.key}}_address_postalcode" value="{$fields.{{$displayParams.key}}_address_postalcode.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
{$fields.{{$displayParams.key}}_address_street.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}<br>
{$fields.{{$displayParams.key}}_address_city.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br} {$fields.{{$displayParams.key}}_address_state.value|escape:'htmlentitydecode'|strip_tags|url2html|nl2br}&nbsp;&nbsp;{$fields.{{$displayParams.key}}_address_postalcode.value|escape:'htmlentitydecode'|strip_tags|url2html|nl2br}<br>
{$fields.{{$displayParams.key}}_address_country.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}
</td>
{{if !empty($displayParams.enableConnectors)}}
<td class="dataField">
{{sugarvar_connector view='DetailView'}} 
</td>
{{/if}}
<td class='dataField' width='1%'>
{{* 
Ez olyan egyéni kód, amelyet a címtábla második oszlopában jeleníthet meg.
Példa erre a "Másolás" gomb a Kliensek részletes nézetében.
Tekintse meg élesben: modules/Accounts/views/view.detail.php 
*}}
{$custom_code_{{$displayParams.key}}}
</td>
</tr>
</table>