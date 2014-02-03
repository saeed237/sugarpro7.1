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
  'LBL_ADDRESS_BCC' => 'CCO:',
  'LBL_ADDRESS_CC' => 'CC:',
  'LBL_ADDRESS_TO' => 'Per a:',
  'LBL_ADDRESS_TYPE' => 'fent servir la direcció',
  'LBL_ADDRESS_TYPE_TARGET' => 'tipus',
  'LBL_ALERT_CURRENT_USER' => 'Un usuari associat a l´objectiu',
  'LBL_ALERT_CURRENT_USER_TITLE' => 'Un usuari associat amb el mòdulo objectiu',
  'LBL_ALERT_LOGIN_USER_TITLE' => 'Usuari amb la sessió iniciada en el moment d´execució',
  'LBL_ALERT_REL1' => 'Mòdul Relacionat:',
  'LBL_ALERT_REL2' => 'Mòdul Relacionat amb el Relacionat:',
  'LBL_ALERT_REL_USER' => 'Un usuari associat amb el relacionat',
  'LBL_ALERT_REL_USER_CUSTOM' => 'El destinatari associat amb un relacionat',
  'LBL_ALERT_REL_USER_CUSTOM_TITLE' => 'El destinatari associat amb un mòdul relacionat',
  'LBL_ALERT_REL_USER_TITLE' => 'Un usuari associat amb un mòdul relacionat',
  'LBL_ALERT_SPECIFIC_ROLE' => 'Tots els usuaris en un especificat',
  'LBL_ALERT_SPECIFIC_ROLE_TITLE' => 'Tots els usuaris en un especificat rol',
  'LBL_ALERT_SPECIFIC_TEAM' => 'Tots els usuaris en un especificat',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET' => 'Tots els usuaris que pertanyen a l&#39;equip(s) associat amb el mòdul de destinació',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET_TITLE' => 'Els membres de l&#39;equip associat amb mòdul de destinació',
  'LBL_ALERT_SPECIFIC_TEAM_TITLE' => 'Tots els usuaris en un equip especificat',
  'LBL_ALERT_SPECIFIC_USER' => 'Un especificat',
  'LBL_ALERT_SPECIFIC_USER_TITLE' => 'Un usuari especificat',
  'LBL_ALERT_TRIG_USER_CUSTOM' => 'El destinatari associat amb el mòdul objectiu',
  'LBL_ALERT_TRIG_USER_CUSTOM_TITLE' => 'El destinatari associat amb el mòdul objectiu',
  'LBL_AND' => 'i Camp per el Nom:',
  'LBL_ARRAY_TYPE' => 'Tipus d´Acció:',
  'LBL_BLANK' => '',
  'LBL_CUSTOM_USER' => 'Usuari Personalizat:',
  'LBL_EDITLAYOUT' => 'Editar disseny',
  'LBL_FIELD' => 'Camp',
  'LBL_FIELD_VALUE' => 'Usuari Seleccionat:',
  'LBL_FILTER_BY' => '(Filtre Adicional) Filtrar mòdul relacionat per',
  'LBL_FILTER_CUSTOM' => '(Filtre Adicional) Filtrar mòdul relacionat per específic',
  'LBL_LIST_ADDRESS_TYPE' => 'Tipus de Direcció',
  'LBL_LIST_ARRAY_TYPE' => 'Tipus d´Acció',
  'LBL_LIST_FIELD_VALUE' => 'Usuari',
  'LBL_LIST_FORM_TITLE' => 'Llista de Destinataris',
  'LBL_LIST_RELATE_TYPE' => 'Tipus Relacionat',
  'LBL_LIST_REL_MODULE1' => 'Mòdul Relacionat',
  'LBL_LIST_REL_MODULE2' => 'Mòdul Relacionat amb el Relacionat',
  'LBL_LIST_STATEMENT' => 'Destinataris de l´Alerta:',
  'LBL_LIST_STATEMENT_CONTENT' => 'Enviar l´alerta al següent destinatari:',
  'LBL_LIST_STATEMENT_INVITE' => 'Convidats a Reunió/Trucada:',
  'LBL_LIST_USER_TYPE' => 'Tipus d´Usuari',
  'LBL_LIST_WHERE_FILTER' => 'Estat',
  'LBL_MODULE_NAME' => 'Llista de Destinataris d´Alertes',
  'LBL_MODULE_NAME_INVITE' => 'Llista de Convidats',
  'LBL_MODULE_NAME_SINGULAR' => 'Llista de Destinataris d´Alertes',
  'LBL_MODULE_NAME_SINGULAR_INVITE' => 'Llista de Convidats',
  'LBL_MODULE_TITLE' => 'Destinataris: Inici',
  'LBL_NEW_FORM_TITLE' => 'Crear Destinatari de Workflow',
  'LBL_NEXT_BUTTON' => 'Següent',
  'LBL_PLEASE_SELECT' => 'Si us plau, faci la selecció',
  'LBL_PREVIOUS_BUTTON' => 'Anterior',
  'LBL_RECORD' => 'Mòdul',
  'LBL_RELATE_TYPE' => 'Tipus de Relació:',
  'LBL_REL_CUSTOM' => 'Seleccioni camp personalitzat de correu:',
  'LBL_REL_CUSTOM2' => 'Camp',
  'LBL_REL_CUSTOM3' => 'Camp',
  'LBL_REL_CUSTOM_STRING' => 'Seleccioni camps personalitzats de correu i nom',
  'LBL_REL_MODULE1' => 'Mòdul Relacionat:',
  'LBL_REL_MODULE2' => 'Mòdul Relacionat amb el Relacionat:',
  'LBL_ROLE' => 'rol',
  'LBL_SEARCH_FORM_TITLE' => 'Recerca de Destinataris de Workflow',
  'LBL_SELECT_EMAIL' => 'Ha de seleccionar un camp personalitzat per al correu',
  'LBL_SELECT_FILTER' => 'Ha de seleccionar un camp per filtrar pel seu valor',
  'LBL_SELECT_NAME' => 'Ha de seleccionar un camp personalitzat per al nom',
  'LBL_SELECT_NAME_EMAIL' => 'Ha de seleccionar els camps de nom i de correu',
  'LBL_SELECT_VALUE' => 'Te que seleccionar un valor vàlid.',
  'LBL_SEND_EMAIL' => 'Enviar un correo a:',
  'LBL_SPECIFIC_FIELD' => 'camp',
  'LBL_TEAM' => 'Equip',
  'LBL_USER' => 'Usuari',
  'LBL_USER1' => 'que va crear el registre',
  'LBL_USER2' => 'que va modificar per últim cop el registre',
  'LBL_USER3' => 'Actual',
  'LBL_USER3b' => 'del sistema.',
  'LBL_USER4' => 'que te el registre assignat',
  'LBL_USER5' => 'a quien fou assignat el registre',
  'LBL_USER_MANAGER' => 'responsable del usuari',
  'LBL_USER_TYPE' => 'Tipus d´Usuari:',
  'LBL_WHERE_FILTER' => 'Estat:',
  'LNK_NEW_WORKFLOW' => 'Crear Workflow',
  'LNK_WORKFLOW' => 'Objetes del Workflow',
  'NTC_REMOVE_ALERT_USER' => 'Està segur de que vol eliminar aquest destinatari de l´alerta?',
);

