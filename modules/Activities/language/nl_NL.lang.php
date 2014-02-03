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
  'ERR_DELETE_RECORD' => 'Specificeer een recordnummer om dit bedrijf te verwijderen.',
  'LBL_ACCEPT' => 'Accepteer',
  'LBL_ACCEPT_THIS' => 'Accepteren?',
  'LBL_COLON' => ':',
  'LBL_CONTACT_NAME' => 'Naam Persoon:',
  'LBL_DATE' => 'Begindatum:',
  'LBL_DATE_TIME' => 'Begindatum & tijd:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Openstaande activiteiten',
  'LBL_DELETE_ACTIVITY' => 'Weet u zeker dat u deze activiteit wilt verwijderen?',
  'LBL_DESCRIPTION' => 'Beschrijving:',
  'LBL_DESCRIPTION_INFORMATION' => 'Beschrijving',
  'LBL_DIRECTION' => 'Richting',
  'LBL_DURATION' => 'Gespreksduur:',
  'LBL_DURATION_MINUTES' => 'Duur (minuten):',
  'LBL_HISTORY' => 'Historie',
  'LBL_HOURS_MINS' => '(uren/minuten)',
  'LBL_INVITEE' => 'Genodigden',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Toegewezen aan gebruiker',
  'LBL_LIST_CLOSE' => 'Sluit',
  'LBL_LIST_CONTACT' => 'Persoon',
  'LBL_LIST_DATE' => 'Datum',
  'LBL_LIST_DIRECTION' => 'Richting',
  'LBL_LIST_DUE_DATE' => 'Vervaldatum',
  'LBL_LIST_FORM_TITLE' => 'Activiteiten',
  'LBL_LIST_LAST_MODIFIED' => 'Laatste wijziging',
  'LBL_LIST_RELATED_TO' => 'Gerelateerd aan',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_SUBJECT' => 'Onderwerp',
  'LBL_LIST_TIME' => 'Aanvangstijd',
  'LBL_LOCATION' => 'Locatie:',
  'LBL_MEETING' => 'Afspraak:',
  'LBL_MODULE_NAME' => 'Activiteiten',
  'LBL_MODULE_NAME_SINGULAR' => 'Activiteit',
  'LBL_MODULE_TITLE' => 'Activiteiten: Start',
  'LBL_NEW_NOTE_BUTTON_KEY' => 'T',
  'LBL_NEW_NOTE_BUTTON_LABEL' => 'Nieuwe Notitie of Bijlage',
  'LBL_NEW_NOTE_BUTTON_TITLE' => 'Nieuwe Notitie of Bijlage [Alt+T]',
  'LBL_NEW_TASK_BUTTON_KEY' => 'N',
  'LBL_NEW_TASK_BUTTON_LABEL' => 'Nieuwe Taak',
  'LBL_NEW_TASK_BUTTON_TITLE' => 'Nieuwe Taak [Alt+N]',
  'LBL_OPEN_ACTIVITIES' => 'Openstaande Activiteiten',
  'LBL_SCHEDULE_CALL_BUTTON_KEY' => 'C',
  'LBL_SCHEDULE_CALL_BUTTON_LABEL' => 'Nieuw Telefoongesprek',
  'LBL_SCHEDULE_CALL_BUTTON_TITLE' => 'Plan een telefoongesprek [Alt+C]',
  'LBL_SCHEDULE_MEETING_BUTTON_KEY' => 'M',
  'LBL_SCHEDULE_MEETING_BUTTON_LABEL' => 'Nieuwe Afspraak',
  'LBL_SCHEDULE_MEETING_BUTTON_TITLE' => 'Plan een afspraak [Alt+M]',
  'LBL_SEARCH_FORM_TITLE' => 'Activiteiten zoeken',
  'LBL_STATUS' => 'Status:',
  'LBL_SUBJECT' => 'Onderwerp:',
  'LBL_TIME' => 'Aanvangstijd:',
  'LBL_TODAY' => 'tot',
  'LBL_TRACK_EMAIL_BUTTON_KEY' => 'K',
  'LBL_TRACK_EMAIL_BUTTON_LABEL' => 'E-mail archiveren',
  'LBL_TRACK_EMAIL_BUTTON_TITLE' => 'E-mail archiveren [Alt+K]',
  'LBL_UPCOMING' => 'Mijn toekomstige activiteiten',
  'LNK_CALL_LIST' => 'Bekijk Telefoongesprekken',
  'LNK_EMAIL_LIST' => 'Bekijk E-mails',
  'LNK_IMPORT_CALLS' => 'Importeer Gesprekken',
  'LNK_IMPORT_MEETINGS' => 'Importeer Afspraken',
  'LNK_IMPORT_NOTES' => 'Importeer Notities',
  'LNK_IMPORT_TASKS' => 'Importeer Taken',
  'LNK_MEETING_LIST' => 'Bekijk Afspraken',
  'LNK_NEW_APPOINTMENT' => 'Nieuwe Afspraak',
  'LNK_NEW_CALL' => 'Nieuw Telefoongesprek',
  'LNK_NEW_EMAIL' => 'Nieuwe gearchiveerde e-mail',
  'LNK_NEW_MEETING' => 'Nieuwe Afspraak',
  'LNK_NEW_NOTE' => 'Nieuwe Notitie of Bijlage',
  'LNK_NEW_TASK' => 'Nieuwe Taak',
  'LNK_NOTE_LIST' => 'Bekijk Notities',
  'LNK_TASK_LIST' => 'Bekijk Taken',
  'LNK_VIEW_CALENDAR' => 'Bekijk Agenda',
  'NTC_NONE' => 'geen',
  'NTC_NONE_SCHEDULED' => 'Er zijn geen activiteiten gepland.',
  'NTC_REMOVE_INVITEE' => 'Weet u zeker dat u deze genodigde voor deze afspraak wilt verwijderen?',
  'appointment_filter_dom' => 
  array (
    'last next_month' => 'volgende maand',
    'last this_month' => 'deze maand',
    'next Saturday' => 'volgende week',
    'this Saturday' => 'deze week',
    'today' => 'vandaag',
    'tomorrow' => 'morgen',
  ),
);

