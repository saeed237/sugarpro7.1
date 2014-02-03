<?php

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





if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


	
$mod_strings = array (
  'LBL_COMPARE_SPECIFIC_PART_TIME' => 'Jämför deltid',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_MODULE_NAME' => 'Villkor',
  'LBL_MODULE_TITLE' => 'Arbetsflöde Triggers: Home',
  'LBL_MODULE_SECTION_TITLE' => 'När följande villkor är uppfyllda',
  'LBL_SEARCH_FORM_TITLE' => 'Arbetsflöden Trigger Sök',
  'LBL_LIST_FORM_TITLE' => 'Lista Triggers',
  'LBL_NEW_FORM_TITLE' => 'Skapa Trigger',
  'LBL_LIST_NAME' => 'Beskrivning:',
  'LBL_LIST_VALUE' => 'Värde:',
  'LBL_LIST_TYPE' => 'Typ:',
  'LBL_LIST_EVAL' => 'Ut v:',
  'LBL_LIST_FIELD' => 'Fält:',
  'LBL_NAME' => 'Trigger Namn:',
  'LBL_TYPE' => 'Typ:',
  'LBL_EVAL' => 'Trigger Utvärdering:',
  'LBL_SHOW_PAST' => 'Redigera senaste värde:',
  'LBL_SHOW' => 'Visa',
  'LNK_NEW_TRIGGER' => 'Skapa Trigger',
  'LNK_TRIGGER' => 'Arbetsflöden Triggers',
  'LBL_LIST_STATEMEMT' => 'Trigga en händelse basserat på följande:',
  'LBL_FILTER_LIST_STATEMEMT' => 'Filtrera objekt basserat på följande:',
  'NTC_REMOVE_TRIGGER' => 'Är du säker på att du vill ta bort den här Triggern?',
  'LNK_NEW_WORKFLOW' => 'Skapa Arbetsflöde',
  'LNK_WORKFLOW' => 'Arbetsflödesobjekt',
  'LBL_ALERT_TEMPLATES' => 'Meddelandemallar',
  'LBL_TRIGGER' => 'När',
  'LBL_FIELD' => 'fält',
  'LBL_VALUE' => 'värde',
  'LBL_RECORD' => 'moduler',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'När ett fält i målmodulen ändras till eller från ett specifikt värde',
  'LBL_COMPARE_SPECIFIC_PART' => 'ändras till eller från specifikt värde',
  'LBL_COMPARE_CHANGE_TITLE' => 'När ett fält i målmodulen ändras',
  'LBL_COMPARE_CHANGE_PART' => 'ändras',
  'LBL_COMPARE_COUNT_TITLE' => 'Trigga enligt specifikt nummer:',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'Fält ändras inte under specificerad tidsperiod',
  'LBL_COMPARE_ANY_TIME_PART2' => 'ändras inte för',
  'LBL_COMPARE_ANY_TIME_PART3' => 'specifierad tid',
  'LBL_FILTER_FIELD_TITLE' => 'När ett fält i målmodulen innehåller ett specificerat värde',
  'LBL_FILTER_FIELD_PART1' => 'Filtrera efter',
  'LBL_FILTER_REL_FIELD_TITLE' => 'När målmodulen ändras och ett fält i en relaterad modul innehåller ett specificerat värde',
  'LBL_FILTER_REL_FIELD_PART1' => 'Specificera relaterad',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'När målmodulen ändras',
  'LBL_FUTURE_TRIGGER' => 'Specificera ny',
  'LBL_PAST_TRIGGER' => 'Specificera gammal',
  'LBL_COUNT_TRIGGER1' => 'Totalt',
  'LBL_COUNT_TRIGGER1_2' => 'jämför mot denna summa',
  'LBL_MODULE' => 'modul',
  'LBL_COUNT_TRIGGER2' => 'filtrera efter relaterad',
  'LBL_COUNT_TRIGGER2_2' => 'endast',
  'LBL_COUNT_TRIGGER3' => 'filtrera specifikt efter',
  'LBL_COUNT_TRIGGER4' => 'filtrera efter en sekund',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'Skapa filter [Alt+F]',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'Skapa filter',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'Skapa Trigger [Alt + T]',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'Skapa Trigger',
  'LBL_LIST_FRAME_SEC' => 'Filter:',
  'LBL_LIST_FRAME_PRI' => 'Trigger:',
  'LBL_TRIGGER_FILTER_TITLE' => 'Trigga Filter',
  'LBL_TRIGGER_FORM_TITLE' => 'Definiera Omständigheter för Arbetsflödesexekvering',
  'LBL_FILTER_FORM_TITLE' => 'Definiera ett krav för Arbetsflöde',
  'LBL_SPECIFIC_FIELD' => 's specificerat fält',
  'LBL_APOSTROPHE_S' => 's',
  'LBL_WHEN_VALUE1' => 'När fältets värde är',
  'LBL_WHEN_VALUE2' => 'När värdet av',
  'LBL_SELECT_OPTION' => 'Vänligen välj ett alternativ.',
  'LBL_SELECT_TARGET_FIELD' => 'Vänligen välj ett  målfält.',
  'LBL_SELECT_TARGET_MOD' => 'Vänligen välj en målrelaterad modul.',
  'LBL_SPECIFIC_FIELD_LNK' => 'specifikt fält',
  'LBL_MUST_SELECT_VALUE' => 'Du måste välja ett värde för det här fältet',
  'LBL_SELECT_AMOUNT' => 'Du måste välja belopp',
  'LBL_SELECT_1ST_FILTER' => 'Du måste välja ett giltigt första filtrerings fält',
  'LBL_SELECT_2ND_FILTER' => 'Du måste välja ett giltigt andra filter fält',
);

