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
  'LBL_ADDRESS_BCC' => 'bcc:',
  'LBL_ADDRESS_CC' => 'cc:',
  'LBL_ADDRESS_TO' => 'till:',
  'LBL_ADDRESS_TYPE' => 'använder adress',
  'LBL_ADDRESS_TYPE_TARGET' => 'typ',
  'LBL_ALERT_CURRENT_USER' => 'En användare associerad med målet:',
  'LBL_ALERT_CURRENT_USER_TITLE' => 'En användare associerad till målmodulen',
  'LBL_ALERT_LOGIN_USER_TITLE' => 'Inloggad användare vid exekveringstiden',
  'LBL_ALERT_REL1' => 'Relaterad modul',
  'LBL_ALERT_REL2' => 'Relaterad relaterad modul:',
  'LBL_ALERT_REL_USER' => 'En användare associerad till en relaterad',
  'LBL_ALERT_REL_USER_CUSTOM' => 'Mottagare associerad till en relaterad',
  'LBL_ALERT_REL_USER_CUSTOM_TITLE' => 'Mottagare associerad till relaterad modul',
  'LBL_ALERT_REL_USER_TITLE' => 'En användare associerade till relaterad modul',
  'LBL_ALERT_SPECIFIC_ROLE' => 'Alla användare i en specifik',
  'LBL_ALERT_SPECIFIC_ROLE_TITLE' => 'Alla användare med en speciell roll',
  'LBL_ALERT_SPECIFIC_TEAM' => 'Alla användare i en specifik',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET' => 'Alla användare som tillhör teamet associerat med målmodulen',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET_TITLE' => 'Teammedlemmar associerade med målmodulen',
  'LBL_ALERT_SPECIFIC_TEAM_TITLE' => 'Alla användare i ett specifikt team',
  'LBL_ALERT_SPECIFIC_USER' => 'En specifik',
  'LBL_ALERT_SPECIFIC_USER_TITLE' => 'En specifik användare',
  'LBL_ALERT_TRIG_USER_CUSTOM' => 'Mottagare associerad till målmodulen',
  'LBL_ALERT_TRIG_USER_CUSTOM_TITLE' => 'Mottagare associerad till målmodulen',
  'LBL_AND' => 'och namnfält:',
  'LBL_ARRAY_TYPE' => 'Typ av åtgärd:',
  'LBL_BLANK' => '',
  'LBL_CUSTOM_USER' => 'Anpassad användare:',
  'LBL_EDITLAYOUT' => 'Redigera layout',
  'LBL_FIELD' => 'Fält',
  'LBL_FIELD_VALUE' => 'Vald användare:',
  'LBL_FILTER_BY' => '(Ytterligare filter) Filtrera relaterad modul efter',
  'LBL_FILTER_CUSTOM' => '(Ytterligare filter) Filtrera relaterad modul efter specifik',
  'LBL_LIST_ADDRESS_TYPE' => 'Adresstyp',
  'LBL_LIST_ARRAY_TYPE' => 'Typ av åtgärd',
  'LBL_LIST_FIELD_VALUE' => 'Användare',
  'LBL_LIST_FORM_TITLE' => 'Lista mottagare',
  'LBL_LIST_RELATE_TYPE' => 'Typ av relaterad',
  'LBL_LIST_REL_MODULE1' => 'Relaterad modul',
  'LBL_LIST_REL_MODULE2' => 'Relaterad relaterad modul',
  'LBL_LIST_STATEMENT' => 'Meddela mottagarna:',
  'LBL_LIST_STATEMENT_CONTENT' => 'Skicka meddelande till följande mottagare:',
  'LBL_LIST_STATEMENT_INVITE' => 'Mötes/telefonsamtals inbjudna',
  'LBL_LIST_USER_TYPE' => 'Användartyp',
  'LBL_LIST_WHERE_FILTER' => 'Status',
  'LBL_MODULE_NAME' => 'Meddela mottagarlistan',
  'LBL_MODULE_NAME_INVITE' => 'Lista över inbjudna',
  'LBL_MODULE_TITLE' => 'Mottagare: Hem',
  'LBL_NEW_FORM_TITLE' => 'Skapa Arbetsflödesmottagare',
  'LBL_NEXT_BUTTON' => 'Nästa',
  'LBL_PLEASE_SELECT' => 'Var god välj',
  'LBL_PREVIOUS_BUTTON' => 'Föregående',
  'LBL_RECORD' => 'Modul',
  'LBL_RELATE_TYPE' => 'Typ av relation:',
  'LBL_REL_CUSTOM' => 'välj anpassat epostfält:',
  'LBL_REL_CUSTOM2' => 'Fält',
  'LBL_REL_CUSTOM3' => 'Fält',
  'LBL_REL_CUSTOM_STRING' => 'Välj anpassade epost och namnfält',
  'LBL_REL_MODULE1' => 'Relaterad modul:',
  'LBL_REL_MODULE2' => 'Relaterad relaterad modul:',
  'LBL_ROLE' => 'roll',
  'LBL_SEARCH_FORM_TITLE' => 'Sök Arbetsflödesmottagare',
  'LBL_SELECT_EMAIL' => 'Du måste välja ett special epost fält',
  'LBL_SELECT_FILTER' => 'Du måste välja ett fält att filtrera via',
  'LBL_SELECT_NAME' => 'Du måste välja ett special namnfält',
  'LBL_SELECT_NAME_EMAIL' => 'Du måst välja namn och epost fälten',
  'LBL_SELECT_VALUE' => 'Välj ett giltigt värde.',
  'LBL_SEND_EMAIL' => 'Skicka epost till:',
  'LBL_SPECIFIC_FIELD' => 'fält',
  'LBL_TEAM' => 'Team',
  'LBL_USER' => 'Användare',
  'LBL_USER1' => 'som skapade posten',
  'LBL_USER2' => 'som senast redigerade posten',
  'LBL_USER3' => 'Aktuell',
  'LBL_USER3b' => 'av systemet.',
  'LBL_USER4' => 'som är tilldelad till posten',
  'LBL_USER5' => 'som var tilldelad till posten',
  'LBL_USER_MANAGER' => 'användarens chef',
  'LBL_USER_TYPE' => 'Användartyp:',
  'LBL_WHERE_FILTER' => 'Status:',
  'LNK_NEW_WORKFLOW' => 'Skapa Arbetsflöde',
  'LNK_WORKFLOW' => 'Arbetsflöde objekt',
  'NTC_REMOVE_ALERT_USER' => 'Är du säker på att du vill radera mottagaren?',
);

