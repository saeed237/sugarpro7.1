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
  'LBL_ALERT_TEMPLATES' => 'Waarschuwing sjablonen',
  'LBL_APOSTROPHE_S' => '&#39;s',
  'LBL_COMPARE_ANY_TIME_PART2' => 'verandert niet voor',
  'LBL_COMPARE_ANY_TIME_PART3' => 'in een bepaalde hoeveelheid tijd',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'Veld is niet gewijzigd in een bepaalde hoeveelheid tijd',
  'LBL_COMPARE_CHANGE_PART' => 'wijzigingen',
  'LBL_COMPARE_CHANGE_TITLE' => 'Als een veld in de doelmodule wijzigt',
  'LBL_COMPARE_COUNT_TITLE' => 'Trigger op een gespecificeerde telling',
  'LBL_COMPARE_SPECIFIC_PART' => 'wijzigt van of naar bepaalde waarde',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => ' ',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'Als een veld in de doelmodule wijzigt van of naar een aangegeven waarde',
  'LBL_COUNT_TRIGGER1' => 'Totaal',
  'LBL_COUNT_TRIGGER1_2' => 'vergeleken met dit bedrag',
  'LBL_COUNT_TRIGGER2' => 'filter de gerelateerde',
  'LBL_COUNT_TRIGGER2_2' => 'alleen',
  'LBL_COUNT_TRIGGER3' => 'filter specifiek op',
  'LBL_COUNT_TRIGGER4' => 'filter op een tweede',
  'LBL_EVAL' => 'Trigger Evaluatie:',
  'LBL_FIELD' => 'veld',
  'LBL_FILTER_FIELD_PART1' => 'Filter op',
  'LBL_FILTER_FIELD_TITLE' => 'Wanneer het veld in de doelmodule een bepaalde waarde bevat',
  'LBL_FILTER_FORM_TITLE' => 'Definieer een Workflowvoorwaarde',
  'LBL_FILTER_LIST_STATEMEMT' => 'Filter objecten gebaseerd op het volgende:',
  'LBL_FILTER_REL_FIELD_PART1' => 'Bepaal gerelateerd',
  'LBL_FILTER_REL_FIELD_TITLE' => 'Als de doelmodule wijzigt en een veld in een gerelateerde module een bepaalde waarde bevat',
  'LBL_FUTURE_TRIGGER' => 'Specificeer nieuwe',
  'LBL_LIST_EVAL' => 'Eval:',
  'LBL_LIST_FIELD' => 'Veld:',
  'LBL_LIST_FORM_TITLE' => 'Trigger Lijst',
  'LBL_LIST_FRAME_PRI' => 'Trigger:',
  'LBL_LIST_FRAME_SEC' => 'Filter:',
  'LBL_LIST_NAME' => 'Omschrijving:',
  'LBL_LIST_STATEMEMT' => 'Trigger een gebeurtenis gebaseerd op het volgende:',
  'LBL_LIST_TYPE' => 'Type:',
  'LBL_LIST_VALUE' => 'Waarde:',
  'LBL_MODULE' => 'module',
  'LBL_MODULE_NAME' => 'Voorwaarden',
  'LBL_MODULE_NAME_SINGULAR' => 'Voorwaarde',
  'LBL_MODULE_SECTION_TITLE' => 'Wanneer aan deze voorwaarden is voldaan',
  'LBL_MODULE_TITLE' => 'Workflow Triggers: Home',
  'LBL_MUST_SELECT_VALUE' => 'U moet een waarde kiezen voor dit veld',
  'LBL_NAME' => 'Trigger Naam:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'Nieuw Filter',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'Nieuw Filter',
  'LBL_NEW_FORM_TITLE' => 'Nieuwe Trigger',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'Nieuwe Trigger',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'NieuweTrigger',
  'LBL_PAST_TRIGGER' => 'Specificeer oude',
  'LBL_RECORD' => 'modules',
  'LBL_SEARCH_FORM_TITLE' => 'Workflow Trigger Zoeken',
  'LBL_SELECT_1ST_FILTER' => 'U moet een geldig veld kiezen als 1e filter',
  'LBL_SELECT_2ND_FILTER' => 'U moet een geldig veld kiezen als 2e filter',
  'LBL_SELECT_AMOUNT' => 'U moet een bedrag kiezen',
  'LBL_SELECT_OPTION' => 'Kies alstublieft een optie',
  'LBL_SELECT_TARGET_FIELD' => 'Kies het doel-veld',
  'LBL_SELECT_TARGET_MOD' => 'Kies een doel-gerelateerde-module',
  'LBL_SHOW' => 'Tonen',
  'LBL_SHOW_PAST' => 'Wijzig Vorige Waarde:',
  'LBL_SPECIFIC_FIELD' => 'een bepaald veld',
  'LBL_SPECIFIC_FIELD_LNK' => 'specifiek veld',
  'LBL_TRIGGER' => 'Als',
  'LBL_TRIGGER_FILTER_TITLE' => 'Trigger Filters',
  'LBL_TRIGGER_FORM_TITLE' => 'Definieer voorwaarde voor de Workflowuitvoering',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'Als de doelmodule wijzigt',
  'LBL_TYPE' => 'Type:',
  'LBL_VALUE' => 'waarde',
  'LBL_WHEN_VALUE1' => 'Als de waarde van het veld is',
  'LBL_WHEN_VALUE2' => 'Wanneer de waarde van',
  'LNK_NEW_TRIGGER' => 'Nieuwe Trigger',
  'LNK_NEW_WORKFLOW' => 'Nieuwe Workflow',
  'LNK_TRIGGER' => 'Workflow Triggers',
  'LNK_WORKFLOW' => 'Workflow Objecten',
  'NTC_REMOVE_TRIGGER' => 'Weet u zeker dat u deze trigger wil verwijderen?',
);

