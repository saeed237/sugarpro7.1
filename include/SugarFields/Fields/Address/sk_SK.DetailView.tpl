
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
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td width='99%' >
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
Toto je zákaznícky kód, ktorý umožňuje nastaviť zobrazenie v druhom stĺpci tabuľky adries. 
Príkladom by mohlo byť tlačítko "Kopírovať" button vyskytujúce sa v detailnom zobrazení Účtov.
Pozri súbor modules/Accounts/views/view.detail.php k zobrazeniu nastavených hodnôt
*}}
{$custom_code_{{$displayParams.key}}}
</td>
</tr>
</table>
