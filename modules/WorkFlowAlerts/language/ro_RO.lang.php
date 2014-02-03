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
  'LBL_ADDRESS_TO' => 'catre:',
  'LBL_ADDRESS_TYPE' => 'folosind adresa',
  'LBL_ADDRESS_TYPE_TARGET' => 'tip',
  'LBL_ALERT_CURRENT_USER' => 'Un utilizator asociat cu tinta',
  'LBL_ALERT_CURRENT_USER_TITLE' => 'Un utilizator asociat cu modulul tinta',
  'LBL_ALERT_LOGIN_USER_TITLE' => 'Utilizatorul logat in momentul executiei',
  'LBL_ALERT_REL1' => 'Modul Inrudit:',
  'LBL_ALERT_REL2' => 'Modul Relationat:',
  'LBL_ALERT_REL_USER' => 'Un utilizator asociat cu',
  'LBL_ALERT_REL_USER_CUSTOM' => 'Recipient asociat cu',
  'LBL_ALERT_REL_USER_CUSTOM_TITLE' => 'Recipient asociat cu un modul inrudit',
  'LBL_ALERT_REL_USER_TITLE' => 'Un utilizator asociat cu un modul inrudit',
  'LBL_ALERT_SPECIFIC_ROLE' => 'Toti utilizatorii',
  'LBL_ALERT_SPECIFIC_ROLE_TITLE' => 'Toti utilizatorii dintr-un rol specificat',
  'LBL_ALERT_SPECIFIC_TEAM' => 'Toti utilizatorii',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET' => 'Toti utilizatorii care apartin de echipa(le) asociate cu modulul tinta',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET_TITLE' => 'Membrii unei echipe asociate cu modulul tinta',
  'LBL_ALERT_SPECIFIC_TEAM_TITLE' => 'Toti utilizatorii dintr-o echipa specificata',
  'LBL_ALERT_SPECIFIC_USER' => 'Specificat',
  'LBL_ALERT_SPECIFIC_USER_TITLE' => 'Un utilizator specificat',
  'LBL_ALERT_TRIG_USER_CUSTOM' => 'Recipient asociat cu modulul tinta',
  'LBL_ALERT_TRIG_USER_CUSTOM_TITLE' => 'Recipient asociat cu modulul tinta',
  'LBL_AND' => 'si nume camp',
  'LBL_ARRAY_TYPE' => 'Tipul Actiunii:',
  'LBL_BLANK' => 'alb-',
  'LBL_CUSTOM_USER' => 'Utilizator Personalizat:',
  'LBL_EDITLAYOUT' => 'Editeaza Plan General',
  'LBL_FIELD' => 'Camp:',
  'LBL_FIELD_VALUE' => 'Utilizator Selectat:',
  'LBL_FILTER_BY' => '(Filtru Aditional) Filtreaza modulul inrudit dupa',
  'LBL_FILTER_CUSTOM' => '(Filtru Aditional) Filtreaza modulul inrudit dupa specificarea',
  'LBL_LIST_ADDRESS_TYPE' => 'Tipul Adresei',
  'LBL_LIST_ARRAY_TYPE' => 'Tipul Actiunii',
  'LBL_LIST_FIELD_VALUE' => 'Utilizator',
  'LBL_LIST_FORM_TITLE' => 'Lista Recipiente',
  'LBL_LIST_RELATE_TYPE' => 'Tipul Relatiei',
  'LBL_LIST_REL_MODULE1' => 'Modul inrudit',
  'LBL_LIST_REL_MODULE2' => 'Modul Relationat',
  'LBL_LIST_STATEMENT' => 'Alerta Destinatar:',
  'LBL_LIST_STATEMENT_CONTENT' => 'Trimite alerta urmatorului recipient:',
  'LBL_LIST_STATEMENT_INVITE' => 'Intalnire/Sunat Invitati:',
  'LBL_LIST_USER_TYPE' => 'Tipul Utilizatorului',
  'LBL_LIST_WHERE_FILTER' => 'Statut',
  'LBL_MODULE_NAME' => 'Alerta Lista Destinatari',
  'LBL_MODULE_NAME_INVITE' => 'Lista Invitatilor',
  'LBL_MODULE_NAME_SINGULAR' => 'Alerta Lista Destinatari',
  'LBL_MODULE_NAME_SINGULAR_INVITE' => 'Lista Invitatilor',
  'LBL_MODULE_TITLE' => 'Destinatari: Acasa',
  'LBL_NEW_FORM_TITLE' => 'Creaza Flux de Lucru Destinatar',
  'LBL_NEXT_BUTTON' => 'Urmatorul>',
  'LBL_PLEASE_SELECT' => 'selectati va rog',
  'LBL_PREVIOUS_BUTTON' => 'anterior',
  'LBL_RECORD' => 'Modul',
  'LBL_RELATE_TYPE' => 'Tipul Relatiei:',
  'LBL_REL_CUSTOM' => 'Alege Camp Email Personalizat',
  'LBL_REL_CUSTOM2' => 'Camp',
  'LBL_REL_CUSTOM3' => 'Camp:',
  'LBL_REL_CUSTOM_STRING' => 'Alege email personalizat si campuri de nume.',
  'LBL_REL_MODULE1' => 'Modul Inrudit:',
  'LBL_REL_MODULE2' => 'Modul Relationat:',
  'LBL_ROLE' => 'Rol',
  'LBL_SEARCH_FORM_TITLE' => 'Flux de Lucru Cautare Destinatar',
  'LBL_SELECT_EMAIL' => 'Trebuie sa alegeti un camp pentru e-mail personalizat',
  'LBL_SELECT_FILTER' => 'Trebuie sa alegeti un camp dupa care sa se faca filtrarea',
  'LBL_SELECT_NAME' => 'Trebuie sa alegeti un camp pentru numele personalizat',
  'LBL_SELECT_NAME_EMAIL' => 'Trebuie sa alegeti campurile de nume si e-mail',
  'LBL_SELECT_VALUE' => 'Trebuie selectata o valuare valida',
  'LBL_SEND_EMAIL' => 'Trimite un email catre:',
  'LBL_SPECIFIC_FIELD' => 'Camp:',
  'LBL_TEAM' => 'Echipa:',
  'LBL_USER' => 'Utilizator',
  'LBL_USER1' => 'cine a creat inregistrarea',
  'LBL_USER2' => 'cine a modificat ultima oara inregistrarea',
  'LBL_USER3' => 'Curent',
  'LBL_USER3b' => 'al sistemului.',
  'LBL_USER4' => 'cui ii este insarcinata inregistrarea',
  'LBL_USER5' => 'cui a fost insarcinata inregistrarea',
  'LBL_USER_MANAGER' => 'manager utilizatori',
  'LBL_USER_TYPE' => 'Tipul Utilizatorului:',
  'LBL_WHERE_FILTER' => 'Statut:',
  'LNK_NEW_WORKFLOW' => 'Creeaza  Debit de Munca',
  'LNK_WORKFLOW' => 'Obiectele Debitului de Munca',
  'NTC_REMOVE_ALERT_USER' => 'Sunteti sigur ca vreti sa inlaturati acest recipient alerta?',
);

