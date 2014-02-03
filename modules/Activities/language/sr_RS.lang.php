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
  'ERR_DELETE_RECORD' => 'Morate navesti broj zapisa da bi obrisali kompaniju.',
  'LBL_ACCEPT' => 'Prihvati',
  'LBL_ACCEPT_THIS' => 'Prihvati?',
  'LBL_COLON' => ':',
  'LBL_CONTACT_NAME' => 'Ime kontakta:',
  'LBL_DATE' => 'Datum početka:',
  'LBL_DATE_TIME' => 'Datum i vreme početka:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Aktuelne aktivnosti',
  'LBL_DELETE_ACTIVITY' => 'Da li ste sigurni da želite da obrišete ovu aktivnost?',
  'LBL_DESCRIPTION' => 'Opis',
  'LBL_DESCRIPTION_INFORMATION' => 'Opisne informacije',
  'LBL_DIRECTION' => 'Smer',
  'LBL_DURATION' => 'Trajanje:',
  'LBL_DURATION_MINUTES' => 'Trajanje u minutima:',
  'LBL_HISTORY' => 'Istorija',
  'LBL_HOURS_MINS' => '(sati/minuta)',
  'LBL_INVITEE' => 'Pozvani',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Dodeljeni korisnik',
  'LBL_LIST_CLOSE' => 'Zatvori',
  'LBL_LIST_CONTACT' => 'Kontakt',
  'LBL_LIST_DATE' => 'Datum',
  'LBL_LIST_DIRECTION' => 'Smer',
  'LBL_LIST_DUE_DATE' => 'Krajnji rok',
  'LBL_LIST_FORM_TITLE' => 'Lista aktivnosti',
  'LBL_LIST_LAST_MODIFIED' => 'Poslednja izmena',
  'LBL_LIST_RELATED_TO' => 'Povezano sa',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Naslov',
  'LBL_LIST_TIME' => 'Vreme početka',
  'LBL_LOCATION' => 'Lokacija:',
  'LBL_MEETING' => 'Sastanak:',
  'LBL_MODULE_NAME' => 'Aktivnosti',
  'LBL_MODULE_NAME_SINGULAR' => 'Aktivnost',
  'LBL_MODULE_TITLE' => 'Aktivnosti: Početna strana',
  'LBL_NEW_NOTE_BUTTON_KEY' => 'T',
  'LBL_NEW_NOTE_BUTTON_LABEL' => 'Kreiraj belešku ili prilog',
  'LBL_NEW_NOTE_BUTTON_TITLE' => 'Kreiraj belešku ili prilog [Alt+T]',
  'LBL_NEW_TASK_BUTTON_KEY' => 'N',
  'LBL_NEW_TASK_BUTTON_LABEL' => 'Kreiraj zadatak',
  'LBL_NEW_TASK_BUTTON_TITLE' => 'Kreiraj zadatak [Alt+N]',
  'LBL_OPEN_ACTIVITIES' => 'Aktuelne aktivnosti',
  'LBL_SCHEDULE_CALL_BUTTON_KEY' => 'C',
  'LBL_SCHEDULE_CALL_BUTTON_LABEL' => 'Evidentiraj poziv',
  'LBL_SCHEDULE_CALL_BUTTON_TITLE' => 'Evidentiraj poziv [Alt+C]',
  'LBL_SCHEDULE_MEETING_BUTTON_KEY' => 'M',
  'LBL_SCHEDULE_MEETING_BUTTON_LABEL' => 'Zakaži sastanak',
  'LBL_SCHEDULE_MEETING_BUTTON_TITLE' => 'Zakaži sastanak [Alt+M]',
  'LBL_SEARCH_FORM_TITLE' => 'Pretraživanje aktivnosti',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Naslov:',
  'LBL_TIME' => 'Vreme početka:',
  'LBL_TODAY' => 'kroz',
  'LBL_TRACK_EMAIL_BUTTON_KEY' => 'K',
  'LBL_TRACK_EMAIL_BUTTON_LABEL' => 'Arhiviraj Email',
  'LBL_TRACK_EMAIL_BUTTON_TITLE' => 'Arhiviraj Email [Alt+K]',
  'LBL_UPCOMING' => 'Moji nadolazeći sastanci',
  'LNK_CALL_LIST' => 'Pregledaj pozive',
  'LNK_EMAIL_LIST' => 'Pregledaj Email-ove',
  'LNK_IMPORT_CALLS' => 'Uvezi pozive',
  'LNK_IMPORT_MEETINGS' => 'Uvezi sastanke',
  'LNK_IMPORT_NOTES' => 'Uvezi beleške',
  'LNK_IMPORT_TASKS' => 'Uvezi zadatke',
  'LNK_MEETING_LIST' => 'Pregledaj sastanke',
  'LNK_NEW_APPOINTMENT' => 'Novi sastanak',
  'LNK_NEW_CALL' => 'Evidentiraj poziv',
  'LNK_NEW_EMAIL' => 'Kreiraj arhiviran Email',
  'LNK_NEW_MEETING' => 'Zakaži sastanak',
  'LNK_NEW_NOTE' => 'Kreiraj belešku ili dodaj prilog',
  'LNK_NEW_TASK' => 'Kreiraj zadatak',
  'LNK_NOTE_LIST' => 'Pregledaj beleške',
  'LNK_TASK_LIST' => 'Pregledaj zadatke',
  'LNK_VIEW_CALENDAR' => 'Pregledaj kalendar',
  'NTC_NONE' => 'Nijedna',
  'NTC_NONE_SCHEDULED' => 'Nema zakazanih.',
  'NTC_REMOVE_INVITEE' => 'Da li sigurno želite da uklonite ovog pozvanog sa sastanka?',
  'appointment_filter_dom' => 
  array (
    'last next_month' => 'sledećeg meseca',
    'last this_month' => 'ovog meseca',
    'next Saturday' => 'sledeće nedelje',
    'this Saturday' => 'ove nedelje',
    'today' => 'danas',
    'tomorrow' => 'sutra',
  ),
);

