<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


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

	

$mod_strings = array (
  'ERR_IMPORT_SYSTEM_ADMININSTRATOR' => 'Sistēmas administratora lietotāju nevar ieimportēt',
  'ERR_MISSING_MAP_NAME' => 'Nav norādīts pielāgotās kartēšanas nosaukums',
  'ERR_MISSING_REQUIRED_FIELDS' => 'Iztrūkst obligātie lauki:',
  'ERR_MULTIPLE' => 'Vairāku kolonnu lauku nosaukumi ir vienādi.',
  'ERR_MULTIPLE_PARENTS' => 'Var nodefinēt tikai vienu Priekšteča ID',
  'ERR_SELECT_FILE' => 'Izvēlieties failu augšupielādei.',
  'ERR_SELECT_FULL_NAME' => 'Jūs nevarat izvēlēties pilnu vārdu, kad izvēlēts Vārds un Uzvārds.',
  'LBL_' => '',
  'LBL_ACCOUNTS_NOTE_1' => 'Saglabājot datubāzē, lauki Adrese - iela 2 un Adrese - iela 3 ir savienoti kopā laukā Adrese iela.',
  'LBL_ACT' => 'Act!',
  'LBL_ACT_NUM_1' => 'Palaist <b>ACT!</b>',
  'LBL_ACT_NUM_10' => 'Atzīmējiet <b>Visi ieraksti</b> un klikšķiniet <b>Pabeigt</b>',
  'LBL_ACT_NUM_2' => 'Izvēlieties <b>Faila</b> izvēlnē <b>Datu Apmaiņas</b> iespēju, tad iepēju  <b>Eksportēt...</b>',
  'LBL_ACT_NUM_3' => 'Izvēlieties faila tipu <b>Text-Delimited</b>',
  'LBL_ACT_NUM_4' => 'Izvēlies faila nosaukumu un eksportēto datu atrašanās vietu un klikšķini <b>Tālāk</b>',
  'LBL_ACT_NUM_5' => 'Atzīmē <b>Tikai kontaktu ierakstus</b>',
  'LBL_ACT_NUM_6' => 'Klikšķini pogu <b>Iespējas...</b>',
  'LBL_ACT_NUM_7' => 'Atzīmē <b>Komats</b> kā lauku atdalīšanas simbolu',
  'LBL_ACT_NUM_8' => 'Atzīmē <b>Jā, eksportēt lauku nosaukumus</b>, izvēles rūtiņu un klikšķini <b>Labi</b>',
  'LBL_ACT_NUM_9' => 'Klikšķini <b>Tālāk</b>',
  'LBL_ADD_FIELD_HELP' => 'Izmanto šo izvēli, lai pievienotu vērtību visiem izveidotajiem un/vai atjauninātajiem laukiem. Atlasi lauku un tad ievadi, vai atlasi vērtību šim laukam, kolonnā Noklusētā vērtība.',
  'LBL_ADD_ROW' => 'Pievienot lauku',
  'LBL_ARE_YOU_SURE' => 'Vai esat pārliecināts? Tiks izdzēsti viesi dati šajā modulī.',
  'LBL_ASSIGNED_USER' => 'Ja lietotājs neeksistē, tad izmanto pašreizējo lietotāju',
  'LBL_AUTO_DETECT_ERROR' => 'Lauku atdalītājs un noteicējs importa failā netika atrasts. Lūdzu pārbaudi iestatījumus Importa faila īpašībās.',
  'LBL_BACK' => '< Atpakaļ',
  'LBL_CANCEL' => 'Atcelt',
  'LBL_CANNOT_OPEN' => 'Importēto failu nevar atvērt nolasīšanai.',
  'LBL_CHARSET' => 'Faila kodējums:',
  'LBL_CONFIRM_EXT_TITLE' => 'Solis{0}: Apstiprināt ārējā datu avota īpašības',
  'LBL_CONFIRM_IMPORT' => 'Jūs esat izvēlējies atjaunināt ierakstus importēšanas procesā. Atjauninājumus esošajiem ierakstiem nevar atcelt. Ierakstus, kuri ir izveidoti importēšanas procesā var izdzēst, ja nepieciešams. Klikšķini Atcelt, lai veidotu tikai jaunus ierakstus, vai klikšķini OK, lai turpinātu.',
  'LBL_CONFIRM_MAP_OVERRIDE' => 'Brīdinājums: Jūs jau esat izvēlējies pielāgoto kartēšanu šim importam, vai vēlies turpināt?',
  'LBL_CONFIRM_TITLE' => 'Solis{0}: Apstiprināt importa faila īpašības',
  'LBL_CONTACTS_NOTE_1' => 'Jābūt kartēšanai uz Vārda vai uzvārda laukiem.',
  'LBL_CONTACTS_NOTE_2' => 'Ja ir kartēšana uz lauku Pilns Vārds, tad lauki Vārds un Uzvārds tiek ignorēti.',
  'LBL_CONTACTS_NOTE_3' => 'Ja ir kartēšana uz lauku Pilns Vārds, tad ievadot datubāzē dati laukā Pilns Vārds tiek sadalīti uz laukiem Vārds un Uzvārds.',
  'LBL_CONTACTS_NOTE_4' => 'Kad ievadīts datubāzē, Lauki Adrese - iela 2 un Adrese - iela 3 ir savienoti kopā laukā Adrese iela.',
  'LBL_CREATED_TAB' => 'Izveidotie ieraksti',
  'LBL_CREATE_BUTTON_HELP' => 'Lietojiet šo iespēju lai veidotu jaunus ierakstus. Piezīme: Ieraksti importa, failā kuri satur vērtības, kuras sakrīt ar esošo ierakstu ID, netiks importēti ja šīs vērtības ir kartētas uz ID lauku.',
  'LBL_CSV' => 'fails manā datorā',
  'LBL_CURRENCY' => 'Valūta:',
  'LBL_CURRENCY_SIG_DIGITS' => 'Valūtas nozīmīgie cipari',
  'LBL_CUSTOM' => 'Pielāgots',
  'LBL_CUSTOM_CSV' => 'Pielāgots ar komatu atdalīts fails',
  'LBL_CUSTOM_DELIMITED' => 'Pielāgots atdalītais fails',
  'LBL_CUSTOM_DELIMITER' => 'Lauki atdalīti ar:',
  'LBL_CUSTOM_ENCLOSURE' => 'Lauki ierobežoti ar:',
  'LBL_CUSTOM_NUM_1' => 'Sāciet lietojumprogrammas darbību un atverat datu failu',
  'LBL_CUSTOM_NUM_2' => 'Izvēlieties <b>"Saglabāt kā..."</b> vai <b> "Eksportēt..."</b> izvēlnes opciju',
  'LBL_CUSTOM_NUM_3' => 'Saglabājiet failu <b>CSV</b> vai <b>ar komatu atdalītas vērtības</b> formātā',
  'LBL_CUSTOM_TAB' => 'Pielāgots ar cilni ierobežots fails',
  'LBL_DATABASE_FIELD' => 'Moduļa lauks',
  'LBL_DATABASE_FIELD_HELP' => 'Šī kolonna attēlo visus moduļa laukus. Atlasi laukus uz kuriem kartēt importa faila ierakstus.',
  'LBL_DATE_FORMAT' => 'Datuma formāts:',
  'LBL_DEBUG_MODE' => 'Aktivizēt atkļūdošanas režīmu',
  'LBL_DECIMAL_SEP' => 'Decimālais simbols:',
  'LBL_DEFAULT_VALUE' => 'Noklusētā vērtība',
  'LBL_DEFAULT_VALUE_HELP' => 'Norādi vērtību, kuru izmantot, ja izveidotajam vai atjauninātajam ierakstam importa failā nav datu.',
  'LBL_DELETE' => 'Dzēst',
  'LBL_DELETE_MAP_CONFIRMATION' => 'Vai tiešām vēlaties dzēst šos saglabātos importa uzstādījumus?',
  'LBL_DELIMITER_COMMA_HELP' => 'Izmanto šo iespēju, lai atlasītu un augšupielādētu izklājlapu failu, kurš satur datus, ar importējamajiem datiem.<br />Piemēri: ar komatu atdalīts .csv fails vai eksportēts fails no Microsoft Outlook.',
  'LBL_DELIMITER_CUSTOM_HELP' => 'Atzīmē šo iespēju ja rakstuzīme, kura atdala laukus importa failā nav komats vai TAB un ievadi šo rakstuzīmi blakus laukā.',
  'LBL_DELIMITER_TAB_HELP' => 'Atzīmē šo izvēli, ja simbols, kurš atdala laukus importa failā ir <b>TAB</b>, un faila paplašinājums ir .txt.',
  'LBL_DESELECT' => 'neatlasīt',
  'LBL_DONT_MAP' => '-- Nekartējiet šo lauku --',
  'LBL_DUPLICATES' => 'Atrasti dublikāti',
  'LBL_DUPLICATE_TAB' => 'Dublikāti',
  'LBL_DUP_HELP' => 'Šeit ir ieraksti importa failā kuri netika importēti, jo satur datus, kuri sakrīt ar esošiem ierakstiem, balstoties uz dublikātu pārbaudi. Dati, kuri sakrīt ir iezīmēti. Lai atkārtoti importētu šos ierakstus, lejupielādē sarakstu, veic izmaiņas un klikšķini <b>Importēt atkārtoti</b>.',
  'LBL_ENCLOSURE_HELP' => '<p><b>Ierobežotāja rakstu zīme</b> tiek lietota, lai ierobežotu paredzētā lauka saturu, ieskaitot simbolus, kuri lietoti, kā atdalītāji.<br><br>Piemērs:Ja atdalītājs ir komats (,), un Ierobežotāja rakstu zīme ir pēdiņas ("),<br><b>"Cupertino, California"</b> ir importēts vienā laukā lietojumprogrammā un parādās kā <b>Cupertino, California</b>.<br>Ja nav Ierobežotāja rakstu zīmes, vai Ierobežotāja rakstu zīme ir cits simbols,<br><b>"Cupertino, California"</b> ir importēts divos blakus laukos kā <b>"Cupertino</b> un <b>"California"</b>.<br><br>Piezīme: Importa fails var arī nesaturēt Ierobežotāja rakstu zīmes.<br>Noklusētā Ierobežotāja rakstu zīme ar komatu un tab atdalītajiem failiem, kuri izveidoti Excel ir pēdiņas </p>',
  'LBL_ERROR' => 'Kļūda:',
  'LBL_ERROR_DELETING_RECORD' => 'Kļūda dzēšot ierakstu:',
  'LBL_ERROR_HELP' => 'Šeit norādīti ieraksti importa failā, kuri netika importēti kļūdas dēļ. Lai atkārtoti importētu šos ierakstus, lejupielādē sarakstu, veic izmaiņas un klikšķini <b>Importēt atkārtoti</b>',
  'LBL_ERROR_IMPORTS_NOT_SET_UP' => 'Šim moduļa tipam, Importēšanas iespēja nav uzstādīta',
  'LBL_ERROR_IMPORT_CACHE_NOT_WRITABLE' => 'Importa keša direktorija nav pieejama rakstīšanai.',
  'LBL_ERROR_INVALID_ACCOUNT' => 'Nederīgs uzņēmuma nosaukums vai ID',
  'LBL_ERROR_INVALID_BOOL' => 'Nederīga vērtība (jābūt 1 vai 0)',
  'LBL_ERROR_INVALID_CURRENCY' => 'Nederīga valūtas vērtība',
  'LBL_ERROR_INVALID_DATE' => 'Nederīga datuma vērtība',
  'LBL_ERROR_INVALID_DATETIME' => 'Nederīga datuma laika vērtība',
  'LBL_ERROR_INVALID_DATETIMECOMBO' => 'Nederīga datuma laika vērtība',
  'LBL_ERROR_INVALID_EMAIL' => 'Nederīga e-pasta adrese',
  'LBL_ERROR_INVALID_FLOAT' => 'Nederīgs peldoša punkta(floating point) skaitlis',
  'LBL_ERROR_INVALID_ID' => 'Norādītais ID ir par garu, lai to ievadītu laukā (maksimālais garums ir 36 simboli)',
  'LBL_ERROR_INVALID_INT' => 'Nederīgs integer vērtība',
  'LBL_ERROR_INVALID_NAME' => 'Teksts par garu, lai to ievadītu laukā',
  'LBL_ERROR_INVALID_NUM' => 'Nederīgs numurs',
  'LBL_ERROR_INVALID_PHONE' => 'Nederīgs tālruņa numurs',
  'LBL_ERROR_INVALID_RELATE' => 'Nederīgs relācijas lauks',
  'LBL_ERROR_INVALID_TEAM' => 'Nederīgs darba grupas nosaukums vai ID',
  'LBL_ERROR_INVALID_TIME' => 'Nederīga laika vērtība',
  'LBL_ERROR_INVALID_USER' => 'Nederīgs lietotāja vārds vai ID',
  'LBL_ERROR_INVALID_VARCHAR' => 'Teksts par garu, lai to ievadītu norādītajā laukā',
  'LBL_ERROR_NOT_IN_ENUM' => 'Vērtība nav nolaižamajā sarakstā. Atļautas sekojošas vērtības:',
  'LBL_ERROR_SELECTING_RECORD' => 'Kļūda izvēloties ierakstu:',
  'LBL_ERROR_SYNC_USERS' => 'Nederīga vērtība, lai sinhronizētos ar Outlook:',
  'LBL_ERROR_TAB' => 'Kļūdas',
  'LBL_ERROR_UNABLE_TO_PUBLISH' => 'Nevar nopublicēt. Ir jau publicēts importējamo datu kartējums ar tādu pašu nosaukumu.',
  'LBL_ERROR_UNABLE_TO_UNPUBLISH' => 'Nevar atsaukt datu kartējumu, kurš pieder citam lietotājam. Jums ir datu kartējums ar tādu pašu nosaukumu.',
  'LBL_EXAMPLE_FILE' => 'Lejupielādēt importa faila veidni',
  'LBL_EXTERNAL_ASSIGNED_TOOLTIP' => 'Lai piešķirtu jaunos ierakstus citam lietotājam, izmanto Noklusētās vērtības kolonnu ,lai norādītu citu lietotāju.',
  'LBL_EXTERNAL_DEFAULT_TOOPLTIP' => 'Nosaka vērtību, kuru izmantot izveidotajam ierakstam, ja ārējais avots nesatur datus.',
  'LBL_EXTERNAL_ERROR_FEED_CORRUPTED' => 'Nevar piekļūt ārējai barotnei, mēģiniet vēlreiz vēlāk.',
  'LBL_EXTERNAL_ERROR_NO_SOURCE' => 'Nevar piekļūt datu avota adapterim, mēģiniet vēlreiz vēlāk.',
  'LBL_EXTERNAL_FIELD' => 'Ārējais lauks',
  'LBL_EXTERNAL_FIELD_TOOLTIP' => 'Šī kolonna attēlo laukus ārējajā avotā, kuri satur datus, kuri tiks izmantoti, lai izveidotu jaunus ierakstus.',
  'LBL_EXTERNAL_MAP_HELP' => 'Zemāk esošā tabula satur laukus ārējā avotā un moduļu laukus uz kuriem tie tiks kartēti. Pārbaudi kartējumu, lai pārliecinātos ka tie ir pareizi un ja nepieciešams veic izmaiņas. Pārliecinies, ka ir veiktas kartēšanas uz visiem obligāti aizpildāmajiem laukiem(atzīmēti ar zvaigznīti)',
  'LBL_EXTERNAL_MAP_NOTE' => 'Importēšana tiks veikta kontaktiem caur visām Google Contacts grupām.',
  'LBL_EXTERNAL_MAP_NOTE_SUB' => 'Pēc noklusējuma Lietotājvārdi jaunizveidotajiem lietotājiem, būs Google Contacts Pilnie vārdi. Lietotājvārdus pēc izveidošanas var nomainīt.',
  'LBL_EXTERNAL_MAP_SUB_HELP' => 'Klikšķini<b>Importēt tagad</b> lai sāktu importēšanu. Ieraksti tiks izveidoti tikai tiem ierakstiem, kuri satur uzvārdu. Ieraksti netiks izveidoti datiem, kuri tiks identificēti kā dublikāti balstoties uz vārdiem un/vai e-pasta adresēm esošajos ierakstos.',
  'LBL_EXTERNAL_SOURCE' => 'ārējā programma vai serviss',
  'LBL_EXTERNAL_SOURCE_HELP' => 'Izmanto šo izvēli, lai importētu datus tieši no ārējās lietojumprogrammas vai servisa, piemēram, Gmail.',
  'LBL_EXTERNAL_TEAM_TOOLTIP' => 'Lai piešķirtu jaunos ierakstus citām darba grupām, nevis savai darba grupai, izmanto kolonnu Noklusētā vērtība, lai atlasītu citas darba grupas.',
  'LBL_EXT_SOURCE_SIGN_IN' => 'Pieteikties',
  'LBL_FAIL' => 'Neizdevās:',
  'LBL_FAILURE' => 'Imports neizdevās:',
  'LBL_FIELD_DELIMETED_HELP' => 'Lauka atdalītājs nosaka, kādu simbolu izmantot, lai atdalītu lauku kolonnas.',
  'LBL_FIELD_NAME' => 'Lauka nosaukums',
  'LBL_FILE_ALREADY_BEEN_OR' => 'Importēšanas fails ir jau apstrādāts vai neeksistē.',
  'LBL_FILE_OPTIONS' => 'Faila iespējas',
  'LBL_FILE_UPLOAD_WIDGET_HELP' => 'Atlasi failu kurš satur datus kuros ieraksti ir atdalīti ar atdalītāju, piemēram komats vai tab. Ieteicamais faila formāts ir .csv.',
  'LBL_FINISHED' => 'Pabeigts',
  'LBL_GOOD_FILE' => 'Importa fails nolasīts veiksmīgi',
  'LBL_HAS_HEADER' => 'Galvenes ieraksts:',
  'LBL_HEADER_ROW' => 'Galvenes ieraksts',
  'LBL_HEADER_ROW_HELP' => 'Šī kolonna attēlo etiķetes importa faila galvenes ierakstā.',
  'LBL_HEADER_ROW_OPTION_HELP' => 'Norādīt vai importējamā faila pirmā rinda ir galvenes ieraksts, kurš satur lauku etiķetes.',
  'LBL_HIDE_ADVANCED_OPTIONS' => 'Slēpt importa faila īpašības',
  'LBL_HIDE_NOTES' => 'Slēpt piezīmes',
  'LBL_HIDE_PREVIEW_COLUMNS' => 'Slēpt priekšapskates kolonnas',
  'LBL_IDS_EXISTED_OR_LONGER' => 'Ieraksti izlaisti, jo identifikatori jau eksistē vai arī bija garāki par 36 simboliem',
  'LBL_ID_EXISTS_ALREADY' => 'Šajā tabulā tāds ID jau eksistē',
  'LBL_IMPORT_ACT_TITLE' => 'Act! var eksportēt datus  <b>ar komatu atdalītas vērtības</b> formātā, kurus var izmantot datu importam sistēmā. Lai eksportētu datus no Act!, veiciet sekojošus soļus:',
  'LBL_IMPORT_BUTTON' => 'Tikai izveidot jaunus ierakstus',
  'LBL_IMPORT_COMPLETE' => 'Iziet',
  'LBL_IMPORT_COMPLETED' => 'Importēšana pabeigta',
  'LBL_IMPORT_CUSTOM_TITLE' => 'Daudzas lietojumprogrammas ļauj eksportēt datus <b> ar komatu ierobežotā teksta failā (.csv)</b>, veicot šādus soļus:',
  'LBL_IMPORT_ERROR' => 'Importējot radās kļūdas',
  'LBL_IMPORT_ERROR_MAX_REC_LIMIT_REACHED' => 'Importējamajā failā ir {0} rindas. Optimālais rindu skaits ir {1}. Lielāks rindu skaits var palēnināt importa procesu. Spiediet Labi lai turpinātu importu. Spiediet Atcelt, lai pārskatītu importējamo failu un atkārtoti ielādējiet importējamo failu.',
  'LBL_IMPORT_FIELDDEF_ASSIGNED_USER_NAME' => 'Lietotājvārds vai ID',
  'LBL_IMPORT_FIELDDEF_BOOL' => '&#39;0&#39; vai &#39;1&#39;',
  'LBL_IMPORT_FIELDDEF_CURRENCY' => 'Skaitlis (var būt ar decimāldaļām)',
  'LBL_IMPORT_FIELDDEF_DATE' => 'Datums',
  'LBL_IMPORT_FIELDDEF_DATETIME' => 'Datums un laiks',
  'LBL_IMPORT_FIELDDEF_DOUBLE' => 'Skaitlis (bez decimāldaļām)',
  'LBL_IMPORT_FIELDDEF_EMAIL' => 'E-pasta adrese',
  'LBL_IMPORT_FIELDDEF_ENUM' => 'Saraksts',
  'LBL_IMPORT_FIELDDEF_FLOAT' => 'Skaitlis (var būt ar decimāldaļām)',
  'LBL_IMPORT_FIELDDEF_ID' => 'Unikāls ID numurs',
  'LBL_IMPORT_FIELDDEF_INT' => 'Skaitlis (bez decimāldaļām)',
  'LBL_IMPORT_FIELDDEF_NAME' => 'Jebkurš teksts',
  'LBL_IMPORT_FIELDDEF_NUM' => 'Skaitlis (bez decimāldaļām)',
  'LBL_IMPORT_FIELDDEF_PHONE' => 'Tālruņa numurs',
  'LBL_IMPORT_FIELDDEF_RELATE' => 'Nosaukums vai ID',
  'LBL_IMPORT_FIELDDEF_TEAM_LIST' => 'Darba grupas nosaukums vai ID',
  'LBL_IMPORT_FIELDDEF_TEXT' => 'Jebkurš teksts',
  'LBL_IMPORT_FIELDDEF_TIME' => 'Laiks',
  'LBL_IMPORT_FIELDDEF_VARCHAR' => 'Jebkurš teksts',
  'LBL_IMPORT_FILE_SETTINGS' => 'Importa faila uzstādījumi',
  'LBL_IMPORT_FILE_SETTINGS_HELP' => 'Importa faila augšupielādes laikā, dažas faila īpašības tika noteiktas automātiski. Aplūko un izmaini šīs īpašības ja <br> nepieciešams. Piezīme: Šie iestatījumi attiecas tikai uz šo importēšanas operāciju un neizmainīs vispārīgos Lietotāja iestatījumus.',
  'LBL_IMPORT_MODULE_ERROR_LARGE_FILE' => 'Fails ir pārāk liels. Maksimālais:',
  'LBL_IMPORT_MODULE_ERROR_LARGE_FILE_END' => 'Baiti. Mainīt $sugar_config[&#39;upload_maxsize&#39;] failā config.php',
  'LBL_IMPORT_MODULE_ERROR_NO_MOVE' => 'Fails nav veiksmīgi augšupielādēts.  "Sugar" instalācijas kešdirektorijā pārbaudiet faila atļaujas.',
  'LBL_IMPORT_MODULE_ERROR_NO_UPLOAD' => 'Fails nav veiksmīgi augšupielādēts. Iespējams, ka &#39;upload_max_filesize&#39; iestatījums Jūsu php.ini failā ir iestatīts uz pārāk mazu vērtību.',
  'LBL_IMPORT_MODULE_MAP_ERROR' => 'Nevar nopublicēt. Ir jau publicēts importējamo datu kartējums ar tādu pašu nosaukumu',
  'LBL_IMPORT_MODULE_MAP_ERROR2' => 'Nevar atsaukt datu kartējumu, kas pieder citam lietotājam. Jums ir datu kartējums ar tādu pašu nosaukumu.',
  'LBL_IMPORT_MODULE_NO_DIRECTORY' => 'Direktorija',
  'LBL_IMPORT_MODULE_NO_DIRECTORY_END' => 'nav vai tajā nevar ierakstīt',
  'LBL_IMPORT_MODULE_NO_TYPE' => 'Šim moduļu veidam importēšanas iespēja nav uzstādīta',
  'LBL_IMPORT_MODULE_NO_USERS' => 'UZMANĪBU: Sistēmā nav nodefinēti lietotāji. Ja importēsiet  neievadot lietotājus visi ieraksti tiks piešķirti sistēmas administratoram.',
  'LBL_IMPORT_MORE' => 'Importēt vēlreiz',
  'LBL_IMPORT_NOW' => 'Importēt tagad',
  'LBL_IMPORT_OUTLOOK_TITLE' => '"Microsoft Outlook 98" un 2000 var eksportēt datus <b> ar komatu atdalītas vērtības</b> formātā, kuru var izmantot, lai importētu datus sistēmā. Lai eksportētu "Outlook" programmas datus, veiciet sekojošus soļus:',
  'LBL_IMPORT_RECORDS' => 'Importē ierakstus',
  'LBL_IMPORT_RECORDS_OF' => 'no',
  'LBL_IMPORT_RECORDS_TO' => 'līdz',
  'LBL_IMPORT_SF_TITLE' => 'Salesforce.com var eksportēt datus <b>Ar komatu atdalītas vērtības</b> formātā, kuru var izmantot, lai importētu datus sistēmā. Lai eksportētu Salesforce. com datus, veiciet sekojošus soļusi:',
  'LBL_IMPORT_STARTED' => 'Imports uzsākts:',
  'LBL_IMPORT_TAB_TITLE' => 'Daudzas lietojumprogrammas sniedz iespēju eksportēt datus <b>Ar zīmotni ierobežotā teksta failā (.tsv vai .tab)</b>, veicot sekojošus soļus:',
  'LBL_IMPORT_TYPE' => 'Ko vēlaties darīt ar importētiem datiem?',
  'LBL_INDEX_NOT_USED' => 'Pieejamie lauki:',
  'LBL_INDEX_USED' => 'Lauki, kurus pārbaudīt:',
  'LBL_LAST_IMPORTED' => 'Izveidots',
  'LBL_LAST_IMPORT_UNDONE' => 'Importēšana ir atcelta',
  'LBL_LOCALE_DEFAULT_NAME_FORMAT' => 'Vārda attēlošanas formāts',
  'LBL_LOCALE_EXAMPLE_NAME_FORMAT' => 'Piemērs',
  'LBL_LOCALE_NAME_FORMAT_DESC' => '<i>"s" Uzruna, "f" Vārds, "l" Uzvārds</i>',
  'LBL_MICROSOFT_OUTLOOK' => '"Microsoft Outlook"',
  'LBL_MICROSOFT_OUTLOOK_HELP' => 'Microsoft Outlook pielāgotie kartējumi paļaujas ka importa fails ir ar komatu atdalīts fails(.csv). Ja jūsu importa fails ir ar tab atdalīts, kartējumi netiks piemēroti kā ieplānots.',
  'LBL_MIME_TYPE_ERROR_1' => 'Atlasītais fails nesatur atdalītu sarakstu. Lūdzu pārbaudi faila tipu. Rekomendētais faila tips ir ar komatu atdalīts fails(.csv).',
  'LBL_MIME_TYPE_ERROR_2' => 'Lai veiktu importēšanu klikšķini, Labi. Lai augšupielādētu jaunu failu, klikšķini Mēģināt vēlreiz.',
  'LBL_MISSING_HEADER_ROW' => 'Nav atrasts galvenes ieraksts',
  'LBL_MODULE_NAME' => 'Importēšana',
  'LBL_MODULE_NAME_SINGULAR' => 'Imports',
  'LBL_MY_PUBLISHED_HELP' => 'Izmanto šo iespēju, lai piemērotu iepriekš uzstādītus importēšanas iestatījumus, tādus kā īpašības, kartēšanas un dublikātu pārbaudi.',
  'LBL_MY_SAVED' => 'Saglabātie avoti:',
  'LBL_MY_SAVED_ADMIN_HELP' => 'Izmanto šo iespēju, lai piemērotu iepriekš uzstādītus importēšanas iestatījumus, tādus kā īpašības, kartēšanas un dublikātu pārbaudi.<br><br>Klikšķini <b>Publicēt</b>, lai kartēšanas būtu pieejamas citiem lietotājiem.<br>Klikšķini <b>Nepublicēt</b>, lai šīs kartēšanas nebūtu pieejams citiem lietotājiem.<br>Klikšķini<b>Dzēst</b>lai dzēstu kartējumus visiem lietotājiem.',
  'LBL_MY_SAVED_HELP' => 'Izmanto šo iespēju, lai piemērotu iepriekš uzstādītus importēšanas iestatījumus, tādus kā īpašības, kartējumus un dublikātu pārbaudi. <br><br>Klikšķini, <b>Dzēst</b>, lai dzēstu kartējumu visiem lietotājiem.',
  'LBL_NEXT' => 'Tālāk >',
  'LBL_NOLOCALE_NEEDED' => 'Nav nepieciešama lokalizācijas konvertācija',
  'LBL_NONE' => 'Neviens',
  'LBL_NOTES' => 'Piezīmes:',
  'LBL_NOT_MULTIENUM' => 'Nav MultiEnum',
  'LBL_NOT_SAME_NUMBER' => 'Jūsu failā visās rindās nav vienāds ierakstu skaits',
  'LBL_NOT_SET_UP' => 'Šim moduļa tipam nav uzstādīta importēšanas iespēja',
  'LBL_NOT_SET_UP_FOR_IMPORTS' => 'Šim moduļa tipam nav uzstādīta importēšanas iespēja',
  'LBL_NOW_CHOOSE' => 'Tagad izvēlieties to failu, kuru importēt:',
  'LBL_NO_DATECHECK' => 'Izlaist datuma pārbaudi (darbosies ātrāk, bet neizdosies, ja kāds datums būs nepareizs)',
  'LBL_NO_EMAILS' => 'Nesūtīt e-pasta paziņojumus šīs importēšanas laikā',
  'LBL_NO_ID' => 'ID ir obligāts',
  'LBL_NO_IMPORT_TO_UNDO' => 'Nav importēšanas procesa, kuru atcelt.',
  'LBL_NO_LINES' => 'Importēšanas failā nebija rindu. Pārbaudi vai failā nav tukšu rindu, un mēģini vēl.',
  'LBL_NO_PRECHECK' => 'Dabiskā formāta režīms',
  'LBL_NO_RECORD' => 'Ar šādu ID nav ierakstu ko atjaunināt',
  'LBL_NO_WORKFLOW' => 'Neizpildīt darbplūsmas šī importa laikā',
  'LBL_NUMBER_GROUPING_SEP' => 'Tūkstošu atdalītājs:',
  'LBL_NUM_1' => '1.',
  'LBL_NUM_10' => '10.',
  'LBL_NUM_11' => '11.',
  'LBL_NUM_12' => '12.',
  'LBL_NUM_2' => '2.',
  'LBL_NUM_3' => '3.',
  'LBL_NUM_4' => '4.',
  'LBL_NUM_5' => '5.',
  'LBL_NUM_6' => '6.',
  'LBL_NUM_7' => '7.',
  'LBL_NUM_8' => '8.',
  'LBL_NUM_9' => '9.',
  'LBL_OK' => 'Labi',
  'LBL_OPTION_ENCLOSURE_DOUBLEQUOTE' => 'Dubultas pēdiņas (")',
  'LBL_OPTION_ENCLOSURE_NONE' => 'Neviens',
  'LBL_OPTION_ENCLOSURE_OTHER' => 'Cits:',
  'LBL_OPTION_ENCLOSURE_QUOTE' => 'Parastas pēdiņas ($#39;)',
  'LBL_OUTLOOK_NUM_1' => 'Atveriet <b>"Outlook"</b>',
  'LBL_OUTLOOK_NUM_2' => 'Izvēlieties <b>Faila</b> izvēlni, pēc tam <b>Importēt un eksportēt ...</b> izvēlnes opciju',
  'LBL_OUTLOOK_NUM_3' => 'Izvēlieties <b>Eksportēt uz failu</b> un klikšķiniet "Nākamais"',
  'LBL_OUTLOOK_NUM_4' => 'Izvēlieties <b>Ar komatu atdalītas vērtības (Windows)</b> un klikšķiniet <b>"Nākamais" </b>.</br>.  Piezīme: Iespējams, ka Jums pieprasīs uzstādīt eksportēšanas komponentus',
  'LBL_OUTLOOK_NUM_5' => 'Izvēlieties <b>Kontaktu</b> katalogu un klikšķiniet <b> "Nākamais" </b>. Varat izvēlēties dažādus kontaktu katalogus, ja Jūsu kontakti ir saglabāti dažādos katalogos',
  'LBL_OUTLOOK_NUM_6' => 'Izvēlieties faila nosaukumu un klikšķiniet <b>"Nākamais" </b>',
  'LBL_OUTLOOK_NUM_7' => 'Klikšķiniet <b> "Beigt" </b>',
  'LBL_PRE_CHECK_SKIPPED' => 'Sākotnējā pārbaude ir izlaista',
  'LBL_PUBLISH' => 'publicēt',
  'LBL_PUBLISHED_SOURCES' => 'Lai izmantotu iepriekš uzstādītos importa iestatījumus, izvēlies no sekojošajiem:',
  'LBL_RECORDS_SKIPPED' => 'Ieraksti izlaisti, jo tajos trūkst viens vai vairāki obligātie lauki',
  'LBL_RECORDS_SKIPPED_DUE_TO_ERROR' => 'ieraksti nav importēti kļūdu dēl',
  'LBL_RECORD_CANNOT_BE_UPDATED' => 'Ierakstu nevar atjaunināt, jo ir nepietiekamas pieejas tiesības',
  'LBL_RELATED_ACCOUNTS' => 'Neveidot saistītos uzņēmumus',
  'LBL_REMOVE_ROW' => 'Noņemt lauku',
  'LBL_REQUIRED_NOTE' => 'Obligātais(ie) lauks(i):',
  'LBL_REQUIRED_VALUE' => 'Nepieciešama obligātā vērtība',
  'LBL_RESULTS' => 'Rezultāti',
  'LBL_ROW' => 'Ieraksts',
  'LBL_ROW_HELP' => 'Šī kolonna attēlo pirmā ieraksta, kurš nav galvenes ieraksts datus. Ja galvenes ieraksta iezīmes parādās šajā kolonnā, klikšķini Atpakaļ, lai norādītu galvenes ierakstu Importa faila īpašībās.',
  'LBL_ROW_NUMBER' => 'Rindas numurs',
  'LBL_SALESFORCE' => 'Salesforce.com',
  'LBL_SAMPLE_URL_HELP' => 'Lejupielādē importa faila paraugu, kurš satur moduļa lauku galvenes ierakstu. Šo failu var izmantot kā veidni importa faila veidošanai.',
  'LBL_SAVE_AS_CUSTOM' => 'Saglabāt kā pielāgotu kartēšanu:',
  'LBL_SAVE_AS_CUSTOM_NAME' => 'Pielāgotā kartējuma nosaukums:',
  'LBL_SAVE_MAPPING_AS' => 'Lai saglabātu importa uzstādījumus, ievadiet nosaukumu:',
  'LBL_SAVE_MAPPING_HELP' => 'Ievadi nosaukumu, lai saglabātu importēšanas iestatījumus, tādus kā lauku kartēšana un indeksus dublikātu pārbaudi. Saglabātie importēšanas iestatījumi var tikt izmantoti turpmāk veicot importēšanu.',
  'LBL_SELECT_DS_INSTRUCTION' => 'Gatavs sākt importēšanu? Izvēlies datu avotu, no kura vēlies importēt.',
  'LBL_SELECT_DUPLICATE_INSTRUCTION' => 'Lai izvairītos no ierakstu dublikātiem, atlasi, kuri lauki importēšanas laikā tiks izmantoti dublikātu pārbaudei. Importēšanas faila ieraksti tiks salīdzināti ar esošajiem ierakstiem izmantojot atlasītos laukus. Ja ierakstu dublikāti tiks atrasti, tie tiks attēloti kopā ar importēšanas rezultātiem (nākamajā lapā). Tad tu varēsi izvēlēties kurus no šiem ierakstiem turpināt importēt.',
  'LBL_SELECT_FIELDS_TO_MAP' => 'Zemāk redzamajā sarakstā izvēlieties laukus  importēšanas failam, kuri jāimportē katrā sistēmas laukā. Kad esi pabeidzis, klikšķini <b>"Tālāk"</b>:',
  'LBL_SELECT_FILE' => 'Izvēlieties failu:',
  'LBL_SELECT_MAPPING_INSTRUCTION' => 'Zemāk esošā tabula satur visus moduļa laukus uz kuriem var kartēt datus no importēšanas faila. Ja fails satur galvenes ierakstu, kolonnas failā ir kartētas uz atbilstošiem laukiem. Pārliecinies vai kartējumi ir pareizi un ja nepieciešams veic izmaiņas. Lai palīdzētu pārbaudīt kartējumus, Pirmā rinda attēlo datus no faila. Pārliecinies, ka ir veikti kartējumi uz visiem obligātajiem laukiem (atzīmēti ar zvaigznīti).',
  'LBL_SELECT_PROPERTY_INSTRUCTION' => 'Šeit attēlots, kā pirmie ieraksti importēšanas failā tiek attēloti ar atrastajām faila īpašībām. Ja galvenes ieraksts ir atrasts, tas ir parādīts tabulas pirmajā rindā. Aplūko importēšanas faila īpašības un ja nepieciešams veic izmaiņas un izveido papildus īpašības.Šo iestatījumu atjaunināšana, atjauninās datus, kuri parādās tabulā.',
  'LBL_SELECT_UPLOAD_INSTRUCTION' => 'Atlasi failu Jūsu datorā, kurš satur datus kurus vēlies importēt, vai lejupielādē veidni, lai sāktu veidot importa failu.',
  'LBL_SF_NUM_1' => 'Atveriet pārlūkprogrammu, ieejiet http://www.salesforce.com un piesakieties, izmantojot savu e-pasta adresi un paroli',
  'LBL_SF_NUM_10' => 'Uz <b>Eksportēt atskaiti:</b>, lai <b>Eksportēt faila formātu:</b>, izvēlieties <b>Ar komatu ierobežots .csv</b>. Klikšķiniet <b> "Eksportēt" </b>.',
  'LBL_SF_NUM_11' => 'Uznirst dialoglodziņš, lai datorā varētu saglabāt ekspotēšanas failu.',
  'LBL_SF_NUM_2' => 'Klikšķiniet <b> "Atskaites" </b> cilni augšējā izvēlnē',
  'LBL_SF_NUM_3' => '<b>Lai eksportētu uzņēmumus:</b> klikšķiniet uz <b> "Aktīvie uzņēmumi"</b> saiti</br><b>.Lai eksportētu kontaktpersonas:</b>, klikšķiniet uz <b>"Adresātu saraksts"</b> saiti.',
  'LBL_SF_NUM_4' => '<b>1. solī: Izvēlieties savas atskaites veidu </b>, izvēlieties <b> "Tabulveida atskaiti" </b> un klikšķiniet <b> "Nākamais"</b>.',
  'LBL_SF_NUM_5' => '<b>2. solī: Izvēlieties atskaites kolonnas</b>, izvēlieties kolonnas, kuras vēlaties eksportēt, un klikšķiniet <b> "Nākamais"</b>.',
  'LBL_SF_NUM_6' => '<b>3. solī: Izvēlieties informāciju, ko vēlaties apkopot</b>, pēc tam klikšķiniet <b> "Nākamais" </b>.',
  'LBL_SF_NUM_7' => '<b>4. solī: Sakārtojiet atskaites kolonnas</b>, pēc tam klikšķiniet <b> "Nākamais" </b>.',
  'LBL_SF_NUM_8' => '<b>5. solī: Izvēlieties atskaites kritēriju</b>, <b>"Sākuma datumā"</b>  izvēlieties senu datumu, lai iekļautu visus Jūsu kontus. Izmantojot uzlabotu kritēriju, varat eksportēt arī Uzņēmumu apakškopas. Kad esat beiguši, klikšķiniet <b> "Izpildīt atskaiti" </b>.',
  'LBL_SF_NUM_9' => 'Atskaite tiek izveidota, un parādās <b>Atskaites izveidošanas statuss: Pabeigta.</b> Tagad klikšķiniet <b> "Eksportēt uz Excel" </b>.',
  'LBL_SHOW_ADVANCED_OPTIONS' => 'Aplūkot importa faila īpašības',
  'LBL_SHOW_HIDDEN' => 'Parādīt laukus, kuri nav normāli importējami',
  'LBL_SHOW_NOTES' => 'Aplūkot piezīmes',
  'LBL_SHOW_PREVIEW_COLUMNS' => 'Aplūkot priekšapskates kolonnas',
  'LBL_SIGN_IN_HELP' => 'Lai aktivizētu šo servisu, lūdzu pieraksties Ārējo kontu cilnē , Lietotāju iestatījumu lapā.',
  'LBL_START_OVER' => 'Sākt no jauna',
  'LBL_STEP_1_TITLE' => '1. solis: Izvēlieties datu avotu',
  'LBL_STEP_2_TITLE' => '{0} solis: Augšupielādē importa failu',
  'LBL_STEP_3_TITLE' => '{0} solis: Apstiprini lauku kartēšanu',
  'LBL_STEP_4_TITLE' => '{0} solis: Importē failu',
  'LBL_STEP_5_TITLE' => '{0} solis: Aplūko importēšanas rezultātus',
  'LBL_STEP_DUP_TITLE' => '{0} solis: Pārbaudi iespējamos dublikātus',
  'LBL_STEP_MODULE' => 'Kurā modulī vēlaties importēt datus?',
  'LBL_STRICT_CHECKS' => 'Lietot stingro likumu kopu(pārbaudīt arī e-pasta adreses un tālruņu numurus)',
  'LBL_SUCCESS' => 'Paveikts:',
  'LBL_SUCCESSFULLY' => 'Veiksmīgi importēts',
  'LBL_SUCCESSFULLY_IMPORTED' => 'ieraksti izveidoti',
  'LBL_SUMMARY' => 'Kopsavilkums',
  'LBL_TAB' => 'Ar cilni ierobežots fails',
  'LBL_TAB_NUM_1' => 'Sāciet lietojumprogrammas darbību un atveriet datu failu',
  'LBL_TAB_NUM_2' => 'Izvēlieties <b> "Saglabāt kā..."</b> vai <b> "Eksportēt..." </b> izvēlnes iespēju.',
  'LBL_TAB_NUM_3' => 'Saglabājiet failu <b>TSV</b> vai <b>Ar cilni atdalītas vērtības</b> formātā.',
  'LBL_TEST' => 'Testēt importu (nesaglabāt un nemainīt datus)',
  'LBL_THIRD_PARTY_CSV_SOURCES' => 'Ja importa fails ir eksportēts no kāda no sekojošiem avotiem, norādiet šo avotu.',
  'LBL_THIRD_PARTY_CSV_SOURCES_HELP' => 'Atzīmē avotu, lai automātiski piemērotu pielāgotos kartējumus, tādējādi vienkāršojot kartēšanas procesu (nākamais solis)',
  'LBL_TIMEZONE' => 'Laika zona:',
  'LBL_TIME_FORMAT' => 'Laika formāts:',
  'LBL_TRUNCATE_TABLE' => 'Iztukšot tabulu pirms importa (dzēst visus ierakstus)',
  'LBL_TRY_AGAIN' => 'Mēģiniet vēlreiz',
  'LBL_UNDO_LAST_IMPORT' => 'Atcelt Importēšanu',
  'LBL_UNIQUE_INDEX' => 'Izvēlieties indeksu dublikātu salīdzināšanai',
  'LBL_UNPUBLISH' => 'Nepublicēt',
  'LBL_UPDATE_BUTTON' => 'Izveidot jaunus un atjaunināt esošos ierakstus',
  'LBL_UPDATE_BUTTON_HELP' => 'Šo iespēju lietojiet, lai atjauninātu esošos ierakstus. Dati no importa faila tiks salīdzināti ar esošiem datiem pēc ID lauka vērtības importa failā.',
  'LBL_UPDATE_RECORDS' => 'Atjaunināt esošos ierakstus nevis importēt (nav atceļams)',
  'LBL_UPDATE_SUCCESSFULLY' => 'ieraksti veiksmīgi atjaunināti',
  'LBL_VALUE' => 'Vērtība',
  'LBL_VERIFY_DUPLCATES_HELP' => 'Meklē sistēmā esošus ierakstus kurus var uzskatīt par importēto ierakstu dublikātiem, veicot dublikātu pārbaudi sakrītošajiem datiem. Lauki, kuri ir nomesti kolonnā "Pārbaudīt datus" tiks izmantoti dublikātu pārbaudei. Importa faila ieraksti, kuri satur sakrītošus datus tiks izvadīti nākamajā lapā, un jūs varēsiet izvēlēties kurus ierakstus importēt.',
  'LBL_VERIFY_DUPS' => 'Lai pārbaudītu ar esošajiem ierakstiem sakrītošus datus importa failā, atlasiet laukus, kurus pārbaudīt:',
  'LBL_WHAT_IS' => 'Mani dati ir:',
  'LNK_DUPLICATE_LIST' => 'Lejuplādēt dublikātu sarakstu',
  'LNK_ERROR_LIST' => 'Lejuplādēt kļūdu sarakstu',
  'LNK_RECORDS_SKIPPED_DUE_TO_ERROR' => 'Lejuplādēt sarakstu ar ierakstiem, kuri netika importēti',
);
