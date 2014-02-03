{*
/*********************************************************************************
 * Obsah tohto súboru je predmetom obchodnej dohody 
 * SugarCRM Enterprise Subscription Agreement ("Licencie"), 
 * ktorá je k dispozícii na adrese:
 * http://www.sugarcrm.com/crm/products/sugar-enterprise-eula.html
 * Pri inštalácii alebo pri používaní tohto súboru musíte bezpodmienečne súhlasiť
 * s podmienkami Licencie a nesmiete použiť tento súbor inak, než je uvedené  
 * v Licenčných podmienkach.  Podľa podmienok licencie nesmiete, okrem iného: 
 * 1) poskytovať sublicencie, predávať, prenajímať ďalej rozširovať, priradiť
 * alebo inak previesť Vaše práva k softvéru a 
 * 2) použiť softvér na zdieľanie alebo účely služby, kancelárie, ako je hosťovanie 
 * Softvéru pre komerčný zisk a / alebo v prospech tretej osoby. Používanie softvéru
 * môže byť predmetom príslušných poplatkov a používanie softvéru bez zaplatenia 
 * príslušných poplatkov je striktne zakázané. Nemáte právo 
 * odstrániť autorské práva SugarCRM - copyrights zo zdrojového kódu 
 * alebo užívateľského rozhrania.
 *
 * Všetky kópie chráneného kódu musia obsahovať na každej obrazovke užívateľského rozhrania: 
 *  (i) logo s titulkom "Powered by SugarCRM" 
 *  (ii) a autorské práva SugarCRM copyright
 * v rovnakej forme, aká je použitá v distribúcii. Viac informácií k splneniu požiadaviek
 * nájdete v plnej Licencii.
 *
 * Vaše záruky, obmedzenia zodpovednosti a odškodnenia sú výslovne uvedené v licencii. 
 * Pozrite sa licenciu vo svojom jazyku, hlavne tieto práva a obmedzenia v rámci licencie. 
 * Časti vytvoril SugarCRM sú Copyright (C) 2004-2011 SugarCRM, Inc 
 * Všetky práva vyhradené. 
 * Preklad do slovenčiny Slavomír Piar (C) 2011, slapia@mvplus.info
 ********************************************************************************/
 *}
<script type="text/javascript" src='{sugar_getjspath file="include/SugarFields/Fields/Address/SugarFieldAddress.js"}'></script>
{{assign var="key" value=$displayParams.key|upper}}
{{assign var="street" value=$displayParams.key|cat:'_address_street'}}
{{assign var="city" value=$displayParams.key|cat:'_address_city'}}
{{assign var="state" value=$displayParams.key|cat:'_address_state'}}
{{assign var="country" value=$displayParams.key|cat:'_address_country'}}
{{assign var="postalcode" value=$displayParams.key|cat:'_address_postalcode'}}
<fieldset id='{{$key}}_address_fieldset'>
<legend>{sugar_translate label='LBL_{{$key}}_ADDRESS' module='{{$module}}'}</legend>
<table border="0" cellspacing="1" cellpadding="0" class="edit" width="100%">
<tr>
<td valign="top" id="{{$street}}_label" width='25%' scope='row' >
{sugar_translate label='LBL_STREET' module='{{$module}}'}:
{if $fields.{{$street}}.required || {{if $street|lower|in_array:$displayParams.required}}true{{else}}false{{/if}}}
<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
{/if}
</td>
<td width="*">
{{if $displayParams.maxlength}}
<textarea id="{{$street}}" name="{{$street}}" maxlength="{{$displayParams.maxlength}}" rows="{{$displayParams.rows|default:4}}" cols="{{$displayParams.cols|default:60}}" tabindex="{{$tabindex}}">{$fields.{{$street}}.value}
