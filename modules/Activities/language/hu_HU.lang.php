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
  'ERR_DELETE_RECORD' => 'Adjon meg egy azonosítót a kliens törléséhez!',
  'LBL_ACCEPT' => 'Elfogad',
  'LBL_ACCEPT_THIS' => 'Elfogadja?',
  'LBL_COLON' => ':',
  'LBL_CONTACT_NAME' => 'Kapcsolat neve:',
  'LBL_DATE' => 'Kezdés dátuma:',
  'LBL_DATE_TIME' => 'Kezdő dátum és idő:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Nyitott tevékenységek',
  'LBL_DELETE_ACTIVITY' => 'Biztos benne, hogy törölni kívánja a tevékenységet?',
  'LBL_DESCRIPTION' => 'Leírás:',
  'LBL_DESCRIPTION_INFORMATION' => 'Részletes leírás',
  'LBL_DIRECTION' => 'Irány',
  'LBL_DURATION' => 'Időtartam:',
  'LBL_DURATION_MINUTES' => 'Időtartam perc:',
  'LBL_HISTORY' => 'Előzmények',
  'LBL_HOURS_MINS' => '(Óra / perc)',
  'LBL_INVITEE' => 'Meghívottak',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Felelős',
  'LBL_LIST_CLOSE' => 'Zárás',
  'LBL_LIST_CONTACT' => 'Kapcsolat',
  'LBL_LIST_DATE' => 'Dátum',
  'LBL_LIST_DIRECTION' => 'Irány',
  'LBL_LIST_DUE_DATE' => 'Esedékesség dátuma',
  'LBL_LIST_FORM_TITLE' => 'Tevékenységek lista',
  'LBL_LIST_LAST_MODIFIED' => 'Utolsó módosítás',
  'LBL_LIST_RELATED_TO' => 'Kapcsolódó kliens',
  'LBL_LIST_STATUS' => 'Állapot',
  'LBL_LIST_SUBJECT' => 'Tárgy',
  'LBL_LIST_TIME' => 'Kezdés időpontja',
  'LBL_LOCATION' => 'Helyszín:',
  'LBL_MEETING' => 'Találkozó:',
  'LBL_MODULE_NAME' => 'Tevékenységek',
  'LBL_MODULE_NAME_SINGULAR' => 'Tevékenység',
  'LBL_MODULE_TITLE' => 'Tevékenységek: Főoldal',
  'LBL_NEW_NOTE_BUTTON_KEY' => 'T',
  'LBL_NEW_NOTE_BUTTON_LABEL' => 'Feljegyzés vagy melléklet létrehozása',
  'LBL_NEW_NOTE_BUTTON_TITLE' => 'Feljegyzés vagy melléklet létrehozása [Alt + T]',
  'LBL_NEW_TASK_BUTTON_KEY' => 'N',
  'LBL_NEW_TASK_BUTTON_LABEL' => 'Feladat létrehozása',
  'LBL_NEW_TASK_BUTTON_TITLE' => 'Feladat létrehozás [Alt + N]',
  'LBL_OPEN_ACTIVITIES' => 'Nyitott tevékenységek',
  'LBL_SCHEDULE_CALL_BUTTON_KEY' => 'C',
  'LBL_SCHEDULE_CALL_BUTTON_LABEL' => 'Hívás naplózása',
  'LBL_SCHEDULE_CALL_BUTTON_TITLE' => 'Hívás naplózása [Alt + C]',
  'LBL_SCHEDULE_MEETING_BUTTON_KEY' => 'M',
  'LBL_SCHEDULE_MEETING_BUTTON_LABEL' => 'Találkozó ütemezése',
  'LBL_SCHEDULE_MEETING_BUTTON_TITLE' => 'Találkozó ütemezése [Alt + M]',
  'LBL_SEARCH_FORM_TITLE' => 'Tevékenységek keresése',
  'LBL_STATUS' => 'Állapot:',
  'LBL_SUBJECT' => 'Tárgy:',
  'LBL_TIME' => 'Kezdés időpontja:',
  'LBL_TODAY' => 'keresztül',
  'LBL_TRACK_EMAIL_BUTTON_KEY' => 'K',
  'LBL_TRACK_EMAIL_BUTTON_LABEL' => 'Email archiválása',
  'LBL_TRACK_EMAIL_BUTTON_TITLE' => 'Email archiválása [Alt+K]',
  'LBL_UPCOMING' => 'Következő megbeszélésem',
  'LNK_CALL_LIST' => 'Hívások megtekintése',
  'LNK_EMAIL_LIST' => 'Emailek megtekintése',
  'LNK_IMPORT_CALLS' => 'Hívások importálása',
  'LNK_IMPORT_MEETINGS' => 'Találkozók importálása',
  'LNK_IMPORT_NOTES' => 'Feljegyzések importálása',
  'LNK_IMPORT_TASKS' => 'Feladatok importálása',
  'LNK_MEETING_LIST' => 'Találkozók megtekintése',
  'LNK_NEW_APPOINTMENT' => 'Új megbeszélés',
  'LNK_NEW_CALL' => 'Hívás naplózása',
  'LNK_NEW_EMAIL' => 'Email archiválása',
  'LNK_NEW_MEETING' => 'Találkozó ütemezése',
  'LNK_NEW_NOTE' => 'Feljegyzés létrehozása vagy melléklet csatolása',
  'LNK_NEW_TASK' => 'Feladat létrehozása',
  'LNK_NOTE_LIST' => 'Feljegyzések megtekintése',
  'LNK_TASK_LIST' => 'Feladatok megtekintése',
  'LNK_VIEW_CALENDAR' => 'Naptár megtekintés',
  'NTC_NONE' => 'Nincs',
  'NTC_NONE_SCHEDULED' => 'Nincs ütemezés.',
  'NTC_REMOVE_INVITEE' => 'Biztosan el akarja távolítani ezt a meghívottat a találkozóról?',
  'appointment_filter_dom' => 
  array (
    'last next_month' => 'következő hónap',
    'last this_month' => 'e hónap',
    'next Saturday' => 'következő hét',
    'this Saturday' => 'e héten',
    'today' => 'ma',
    'tomorrow' => 'holnap',
  ),
);

