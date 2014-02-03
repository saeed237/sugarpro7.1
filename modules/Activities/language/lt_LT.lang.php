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
  'ERR_DELETE_RECORD' => 'Turite nurodyti įrašą, kad ištrintumėte klientą',
  'LBL_ACCEPT' => 'Pavirtinti',
  'LBL_ACCEPT_THIS' => 'patvirtinti?',
  'LBL_COLON' => ':',
  'LBL_CONTACT_NAME' => 'Kontakto vardas:',
  'LBL_DATE' => 'Pradžios data:',
  'LBL_DATE_TIME' => 'Pradžios data ir laikas:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Atidaryti priminimus',
  'LBL_DESCRIPTION' => 'Aprašymas:',
  'LBL_DESCRIPTION_INFORMATION' => 'Aprašymas',
  'LBL_DIRECTION' => 'Kryptis',
  'LBL_DURATION' => 'Trukmė',
  'LBL_DURATION_MINUTES' => 'Trukmė minutėmis:',
  'LBL_HISTORY' => 'Istorija',
  'LBL_HOURS_MINS' => '(valandos/minutės)',
  'LBL_INVITEE' => 'Dalyviai',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Atsakingas',
  'LBL_LIST_CLOSE' => 'Užbaigti',
  'LBL_LIST_CONTACT' => 'Kontaktas',
  'LBL_LIST_DATE' => 'Data',
  'LBL_LIST_DIRECTION' => 'Kryptis',
  'LBL_LIST_DUE_DATE' => 'Atlikimo data',
  'LBL_LIST_FORM_TITLE' => 'Priminimų sąrašas',
  'LBL_LIST_LAST_MODIFIED' => 'Redaguota',
  'LBL_LIST_RELATED_TO' => 'Susijęs su',
  'LBL_LIST_STATUS' => 'Statusas',
  'LBL_LIST_SUBJECT' => 'Tema',
  'LBL_LIST_TIME' => 'Pradžios laikas',
  'LBL_LOCATION' => 'Vieta:',
  'LBL_MEETING' => 'Susitikimas:',
  'LBL_MODULE_NAME' => 'Priminimai',
  'LBL_MODULE_NAME_SINGULAR' => 'Priminimas',
  'LBL_MODULE_TITLE' => 'Priminimai: Pradžia',
  'LBL_NEW_NOTE_BUTTON_KEY' => 'T',
  'LBL_NEW_NOTE_BUTTON_LABEL' => 'Sukurti užrašą',
  'LBL_NEW_NOTE_BUTTON_TITLE' => 'Sukurti užduotį [Alt+T]',
  'LBL_NEW_TASK_BUTTON_KEY' => 'N',
  'LBL_NEW_TASK_BUTTON_LABEL' => 'Sukurti užduotį',
  'LBL_NEW_TASK_BUTTON_TITLE' => 'Sukurti užduotį [Alt+N]',
  'LBL_OPEN_ACTIVITIES' => 'Atidaryti priminimus',
  'LBL_SCHEDULE_CALL_BUTTON_KEY' => 'C',
  'LBL_SCHEDULE_CALL_BUTTON_LABEL' => 'Suplanuoti skambutį',
  'LBL_SCHEDULE_CALL_BUTTON_TITLE' => 'Suplanuoti skambutį [Alt+C]',
  'LBL_SCHEDULE_MEETING_BUTTON_KEY' => 'M',
  'LBL_SCHEDULE_MEETING_BUTTON_LABEL' => 'Suplanuoti susitikimą',
  'LBL_SCHEDULE_MEETING_BUTTON_TITLE' => 'Suplanuoti susitikimą [Alt+M]',
  'LBL_SEARCH_FORM_TITLE' => 'Priminimų paieška',
  'LBL_STATUS' => 'Statusas:',
  'LBL_SUBJECT' => 'Tema:',
  'LBL_TIME' => 'Pradžios laikas:',
  'LBL_TODAY' => 'per',
  'LBL_TRACK_EMAIL_BUTTON_KEY' => 'K',
  'LBL_TRACK_EMAIL_BUTTON_LABEL' => 'Archyvuoti laišką',
  'LBL_TRACK_EMAIL_BUTTON_TITLE' => 'Archyvuoti laišką [Alt+K]',
  'LBL_UPCOMING' => 'Mano artimiausi susitikimai',
  'LNK_CALL_LIST' => 'Skambučiai',
  'LNK_EMAIL_LIST' => 'El. paštas',
  'LNK_IMPORT_CALLS' => 'Importuoti skambučius',
  'LNK_IMPORT_MEETINGS' => 'Importuoti susitikimus',
  'LNK_IMPORT_NOTES' => 'Importuoti užrašus',
  'LNK_IMPORT_TASKS' => 'Importuoti užduotis',
  'LNK_MEETING_LIST' => 'Susitikimai',
  'LNK_NEW_APPOINTMENT' => 'Naujas susitikimas',
  'LNK_NEW_CALL' => 'Suplanuoti skambutį',
  'LNK_NEW_EMAIL' => 'Archyvuoti laišką',
  'LNK_NEW_MEETING' => 'Suplanuoti susitikimą',
  'LNK_NEW_NOTE' => 'Sukurti užrašą',
  'LNK_NEW_TASK' => 'Sukurti užduotį',
  'LNK_NOTE_LIST' => 'Užrašai',
  'LNK_TASK_LIST' => 'Užduotys',
  'LNK_VIEW_CALENDAR' => 'Kalendorius',
  'NTC_NONE' => 'Joks',
  'NTC_NONE_SCHEDULED' => 'Nėra suplanuota.',
  'NTC_REMOVE_INVITEE' => 'Ar norite pašalinti šį dalyvį iš susitikimo?',
  'appointment_filter_dom' => 
  array (
    'last next_month' => 'Kitą mėnesį',
    'last this_month' => 'Šį mėnesį',
    'next Saturday' => 'Kitą savaitę',
    'this Saturday' => 'Šią savaitę',
    'today' => 'Šiandien',
    'tomorrow' => 'Rytoj',
  ),
);

