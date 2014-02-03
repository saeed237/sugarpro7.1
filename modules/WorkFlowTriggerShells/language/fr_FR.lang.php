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
  'LBL_ALERT_TEMPLATES' => 'Modèles d&#39;Alerte',
  'LBL_APOSTROPHE_S' => 's',
  'LBL_COMPARE_ANY_TIME_PART2' => 'ne change pas pour',
  'LBL_COMPARE_ANY_TIME_PART3' => 'une durée spécifiée',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'Le champ n&#39;est pas modifié pour une durée spécifiée',
  'LBL_COMPARE_CHANGE_PART' => 'est modifié',
  'LBL_COMPARE_CHANGE_TITLE' => 'Quand un champ du module cible est modifié',
  'LBL_COMPARE_COUNT_TITLE' => 'Déclencheur sur calcul sécifique',
  'LBL_COMPARE_SPECIFIC_PART' => 'est modifié pour ou vers une valeur spécifiée',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => ' ',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'Quand un champ du module cible est modifié pour ou vers une valeur spécifiée',
  'LBL_COUNT_TRIGGER1' => 'Total',
  'LBL_COUNT_TRIGGER1_2' => 'Comparé à cette valeur',
  'LBL_COUNT_TRIGGER2' => 'filtrer par (related)',
  'LBL_COUNT_TRIGGER2_2' => 'seulement',
  'LBL_COUNT_TRIGGER3' => 'filtrer spécifiquement par',
  'LBL_COUNT_TRIGGER4' => 'filtrer par un autre',
  'LBL_EVAL' => 'Evaluation du Déclencheur:',
  'LBL_FIELD' => 'champ',
  'LBL_FILTER_FIELD_PART1' => 'Filtré par',
  'LBL_FILTER_FIELD_TITLE' => 'Quand un champ du module cible contient une valeur spécifiée',
  'LBL_FILTER_FORM_TITLE' => 'Définir une condition de Workflow',
  'LBL_FILTER_LIST_STATEMEMT' => 'Filtrer les objets basés sur:',
  'LBL_FILTER_REL_FIELD_PART1' => 'valeur pour le champ du module',
  'LBL_FILTER_REL_FIELD_TITLE' => 'Quand le module spécifié change et un champ du module associé contient une valeur spécifiée',
  'LBL_FUTURE_TRIGGER' => 'Spécifier la nouvelle valeur de',
  'LBL_LIST_EVAL' => 'Eval:',
  'LBL_LIST_FIELD' => 'Champ:',
  'LBL_LIST_FORM_TITLE' => 'Liste des Déclencheurs',
  'LBL_LIST_FRAME_PRI' => 'Déclencheur:',
  'LBL_LIST_FRAME_SEC' => 'Filtre:',
  'LBL_LIST_NAME' => 'Description:',
  'LBL_LIST_STATEMEMT' => 'Déclencher un évenement basé sur:',
  'LBL_LIST_TYPE' => 'Type:',
  'LBL_LIST_VALUE' => 'Valeur:',
  'LBL_MODULE' => 'module',
  'LBL_MODULE_NAME' => 'Conditions',
  'LBL_MODULE_NAME_SINGULAR' => 'Condition',
  'LBL_MODULE_SECTION_TITLE' => 'Quand ces conditions sont rencontrées',
  'LBL_MODULE_TITLE' => 'Déclencheurs de Workflow',
  'LBL_MUST_SELECT_VALUE' => 'Vous devez choisir une valeur pour ce champ',
  'LBL_NAME' => 'Nom du Déclencheur:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'Créer un filtre',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'Créer un filtre [Alt+F]',
  'LBL_NEW_FORM_TITLE' => 'Créer un Déclencheur',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'Créer un Déclencheur',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'Créer un Trigger [Alt+T]',
  'LBL_PAST_TRIGGER' => 'Spécifier l&#39;ancienne valeur de',
  'LBL_RECORD' => 'choix du module',
  'LBL_SEARCH_FORM_TITLE' => 'Rechercher',
  'LBL_SELECT_1ST_FILTER' => 'Le champ du premier filtre doit être valide',
  'LBL_SELECT_2ND_FILTER' => 'Le champ du deuxieme filtre doit être valide',
  'LBL_SELECT_AMOUNT' => 'Vous devez choisir le montant',
  'LBL_SELECT_OPTION' => 'Merci de choisir une option.',
  'LBL_SELECT_TARGET_FIELD' => 'Merci de sélectionner un champ cible.',
  'LBL_SELECT_TARGET_MOD' => 'Merci de sélectionner un module lié cible.',
  'LBL_SHOW' => 'Voir',
  'LBL_SHOW_PAST' => 'Modifier Ancienne Valeur:',
  'LBL_SPECIFIC_FIELD' => 'champ spécifique',
  'LBL_SPECIFIC_FIELD_LNK' => 'Champ spécifique',
  'LBL_TRIGGER' => 'Quand',
  'LBL_TRIGGER_FILTER_TITLE' => 'Filtres Déclencheurs',
  'LBL_TRIGGER_FORM_TITLE' => 'Définir la condition pour l&#39;exécution du Workflow',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'Quand le module cible change',
  'LBL_TYPE' => 'Type:',
  'LBL_VALUE' => 'valeur',
  'LBL_WHEN_VALUE1' => 'Lorsque la valeur du champ est',
  'LBL_WHEN_VALUE2' => 'Lorsque la valeur est',
  'LNK_NEW_TRIGGER' => 'Créer un Déclencheur',
  'LNK_NEW_WORKFLOW' => 'Créer un Workflow',
  'LNK_TRIGGER' => 'Déclencheurs de Workflow',
  'LNK_WORKFLOW' => 'Objets du Workflow',
  'NTC_REMOVE_TRIGGER' => 'Etes vous sûr de vouloir supprimer ce déclencheur?',
);

