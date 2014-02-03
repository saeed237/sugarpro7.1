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
  'LBL_ACTION_ERROR' => 'Ez a művelet nem hajtható végre. Javítsa úgy, hogy a mezők és értékeik egyaránt érvényesek legyenek!',
  'LBL_ACTION_ERRORS' => 'Figyelem: egy vagy több alább listázott folyamat hibát tartalmaz.',
  'LBL_ALERT_ERROR' => 'Ezt a figyelmeztetést nem lehet végrehajtani. Javítsa úgy, hogy az összes beállítás megfelelő legyen!',
  'LBL_ALERT_ERRORS' => 'Figyelem: egy vagy több alább listázott folyamat hibát tartalmaz.',
  'LBL_ALERT_SUBJECT' => 'Munkafolyamat riasztás',
  'LBL_ALERT_TEMPLATES' => 'Riasztási sablonok',
  'LBL_ANY_FIELD' => 'bármelyik mező',
  'LBL_AS' => 'mint',
  'LBL_BASE_MODULE' => 'Cél modul:',
  'LBL_BODY' => 'Szövegtörzs:',
  'LBL_CREATE_ALERT_TEMPLATE' => 'Figyelmeztető sablon létrehozása:',
  'LBL_DESCRIPTION' => 'Leírás:',
  'LBL_DOWN' => 'Le',
  'LBL_EDITLAYOUT' => 'Elrendezés szerkesztése',
  'LBL_EDIT_ALT_TEXT' => 'Leíró szöveg',
  'LBL_EMAILTEMPLATES_TYPE' => 'Típus',
  'LBL_EMAILTEMPLATES_TYPE_LIST_WORKFLOW' => 
  array (
    'workflow' => 'Munkafolyamat',
  ),
  'LBL_FIRE_ORDER' => 'Végrehajtási sorrend:',
  'LBL_FROM_ADDRESS' => 'Feladó címe:',
  'LBL_FROM_NAME' => 'Feladó neve:',
  'LBL_HIDE' => 'Elrejt',
  'LBL_INSERT' => 'Beszúrás',
  'LBL_INVITEES' => 'Meghívottak',
  'LBL_INVITEE_NOTICE' => 'Figyelem, a létrehozáshoz ki kell választania legalább egy meghívottat.',
  'LBL_INVITE_LINK' => 'Találkozó / hívás meghívó link',
  'LBL_LACK_OF_NOTIFICATIONS_ON' => 'Figyelem: a figyelmeztetések küldéséhez az admin felületen meg kell adni az SMTP szerver adatait, így: Admin  > Email beállítások.',
  'LBL_LACK_OF_TRIGGER_ALERT' => 'Figyelem: létre kell hozni egy indítót a munkafolyamat futtatásához',
  'LBL_LINK_RECORD' => 'Kapcsolás a rekordhoz',
  'LBL_LIST_BASE_MODULE' => 'Cél modul:',
  'LBL_LIST_DN' => 'le',
  'LBL_LIST_FORM_TITLE' => 'Munkafolyamat lista',
  'LBL_LIST_NAME' => 'Név',
  'LBL_LIST_ORDER' => 'Végrehajtás sorrendje:',
  'LBL_LIST_STATUS' => 'Állapot',
  'LBL_LIST_TYPE' => 'Végrehajtási előfordulás:',
  'LBL_LIST_UP' => 'fel',
  'LBL_MODULE_ID' => 'Munkafolyamat',
  'LBL_MODULE_NAME' => 'Munkafolyamat meghatározások',
  'LBL_MODULE_NAME_SINGULAR' => 'Munkafolyamat meghatározása',
  'LBL_MODULE_TITLE' => 'Munkafolyamatok: Főoldal',
  'LBL_NAME' => 'Név:',
  'LBL_NEW_FORM_TITLE' => 'Munkafolyamat szabály létrehozása',
  'LBL_PLEASE_SELECT' => 'Kérem, válasszon',
  'LBL_PROCESS_LIST' => 'Munkafolyamat végrehajtási sorrendje',
  'LBL_PROCESS_SELECT' => 'Kérjem, válasszon egy modult:',
  'LBL_RECIPIENTS' => 'Címzettek',
  'LBL_RECORD_TYPE' => 'Alkalmazható:',
  'LBL_RELATED_MODULE' => 'Kapcsolódó modulok:',
  'LBL_SEARCH_FORM_TITLE' => 'Munkafolyamat keresés',
  'LBL_SELECT_FILTER' => 'Ki kell választania egy mezőt a kapcsolódó modul szűréséhez.',
  'LBL_SELECT_MODULE' => 'Kérem, válasszon egy kapcsolódó modult!',
  'LBL_SELECT_OPTION' => 'Kérem, válasszon ki egy lehetőséget!',
  'LBL_SELECT_VALUE' => 'Ki kell választania egy értéket!',
  'LBL_SET' => 'Beállítás',
  'LBL_SHOW' => 'Mutat',
  'LBL_SPECIFIC_FIELD' => 'meghatározott mező',
  'LBL_STATUS' => 'Állapot:',
  'LBL_SUBJECT' => 'Tárgy:',
  'LBL_TRIGGER_ERROR' => 'Figyelem: az indító érvénytelen értékeket tartalmaz, így nem futtatható.',
  'LBL_TRIGGER_ERRORS' => 'Figyelem: egy vagy több alább listázott indító hibát tartalmaz.',
  'LBL_TYPE' => 'Végrehajtás itt:',
  'LBL_UP' => 'Fel',
  'LBL__S' => ' ',
  'LNK_ALERT_TEMPLATES' => 'Figyelmeztető email sablonok',
  'LNK_NEW_WORKFLOW' => 'Munkafolyamat szabály létrehozása',
  'LNK_PROCESS_VIEW' => 'Munkafolyamat végrehajtási sorrendje',
  'LNK_WORKFLOW' => 'Munkafolyamat szabályok listája',
  'NTC_REMOVE_ALERT' => 'Biztosan el akarja távolítani ezt a munkafolyamatot?',
);

