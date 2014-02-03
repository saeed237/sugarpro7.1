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
  'ERR_NO_OPPS' => 'Veuillez créer des Affaires avant de visualiser le graphique des Affaires.',
  'LBL_ALL_OPPORTUNITIES' => 'Total du portefeuille',
  'LBL_CAMPAIGN_ROI_TITLE_DESC' => 'Voir le retour de campagne par Retour sur Investissement.',
  'LBL_CHART_ACTION' => 'Action',
  'LBL_CHART_DCE_ACTIONS_MONTH' => 'Actions DCE par type (Moi en cours)',
  'LBL_CHART_LEAD_SOURCE_BY_OUTCOME' => 'Lead par origine principale',
  'LBL_CHART_MODULES_USED_DIRECT_REPORTS_30_DAYS' => 'Modules utilisés par mes subordonnées (30 derniers Jours)',
  'LBL_CHART_MY_MODULES_USED_30_DAYS' => 'Mes modules utilisés (30 derniers jours)',
  'LBL_CHART_MY_PIPELINE_BY_SALES_STAGE' => 'Mon portefeuille par phase de vente',
  'LBL_CHART_OPPORTUNITIES_THIS_QUARTER' => 'Affaires du trimestre en cours',
  'LBL_CHART_OUTCOME_BY_MONTH' => 'Affaires par Mois',
  'LBL_CHART_PIPELINE_BY_LEAD_SOURCE' => 'Portefeuille par source de Lead',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE' => 'Portefeuille par phase de vente',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE_FUNNEL' => 'Portefeuille par phase de vente (entonnoir)',
  'LBL_CHART_TYPE' => 'Type de Graphique:',
  'LBL_CLOSE_DATE_END' => 'Date de clôture attendue - Au:',
  'LBL_CLOSE_DATE_START' => 'Date de clôture attendue - Du:',
  'LBL_CREATED_ON' => 'Dernière excécution',
  'LBL_DATE_END' => 'Date de fin:',
  'LBL_DATE_RANGE' => 'Plage de Date:',
  'LBL_DATE_RANGE_TO' => 'de',
  'LBL_DATE_START' => 'Date de début:',
  'LBL_EDIT' => 'Editer',
  'LBL_LEAD_SOURCES' => 'Origine Principale:',
  'LBL_LEAD_SOURCE_BY_OUTCOME' => 'Toutes les Affaires par Résultat',
  'LBL_LEAD_SOURCE_BY_OUTCOME_DESC' => 'Affiche le montant cumulé des Affaires filtré par Origine Principale et par Utilisaeur, et selon le résultat actuel de l&#39;Affaire. Le résultat est basé sur les différentes Phases de Vente: Gagné, Perdu ou toute autre Phase.',
  'LBL_LEAD_SOURCE_FORM_DESC' => 'Affiche le montant cumulé des Affaires filtré par Origine Principale et par Utilisateur.',
  'LBL_LEAD_SOURCE_FORM_TITLE' => 'Toutes les Affaires par Origine Principale',
  'LBL_LEAD_SOURCE_OTHER' => 'Autre',
  'LBL_MODULE_NAME' => 'Tableaux de bord',
  'LBL_MODULE_NAME_SINGULAR' => 'Tableau de bord',
  'LBL_MODULE_TITLE' => 'Tableaux de Bord',
  'LBL_MONTH_BY_OUTCOME_DESC' => 'Affiche le montant cumulé des Affaires filtré par Utilisateur dont la date de clôture prévue est comprise dans l&#39;année spécifiée. Le résultat est basé sur les différentes Phases de Vente: Gagné, Perdu ou toute autre Phase.',
  'LBL_MY_MODULES_USED_SIZE' => 'Nombre d&#39;accés',
  'LBL_NUMBER_OF_OPPS' => 'Nombre d&#39;Affaires',
  'LBL_OPPS_IN_LEAD_SOURCE' => 'Affaires dont l&#39;Origine Principale est',
  'LBL_OPPS_IN_STAGE' => 'où la Phase de Vente est',
  'LBL_OPPS_OUTCOME' => 'où le Résultat est',
  'LBL_OPPS_WORTH' => 'Affaires pour un total de',
  'LBL_OPP_SIZE' => 'Echelle de l&#39;Affaire:',
  'LBL_OPP_THOUSANDS' => 'K',
  'LBL_PIPELINE_FORM_TITLE_DESC' => 'Affiche le montant cumulé de VOS Affaires par Phase de Vente dont la date de clôture prévue est comprise dans la plage de dates spécifiées.',
  'LBL_REFRESH' => 'Rafraîchir',
  'LBL_ROLLOVER_DETAILS' => 'Survoler avec la souris un élément du graphique pour obtenir des informations supplémentaires.',
  'LBL_ROLLOVER_WEDGE_DETAILS' => 'Survoler avec la souris un secteur pour obtenir des informations supplémentaires.',
  'LBL_SALES_STAGES' => 'Phase de Vente:',
  'LBL_SALES_STAGE_FORM_DESC' => 'Affiche le montant cumulé des Affaires par Phase de Vente filtré par utilisateur et dont la date de clôture prévue est comprise dans la plage de dates spécifiées.',
  'LBL_SALES_STAGE_FORM_TITLE' => 'Portefeuille par Phase de Vente',
  'LBL_TITLE' => 'Titre:',
  'LBL_TOTAL_PIPELINE' => 'Total du portefeuille',
  'LBL_USERS' => 'Utilisateur:',
  'LBL_YEAR' => 'Année:',
  'LBL_YEAR_BY_OUTCOME' => 'Portefeuille par Mois par Résultat',
  'LNK_NEW_ACCOUNT' => 'Créer Compte',
  'LNK_NEW_CALL' => 'Planifier Appel',
  'LNK_NEW_CASE' => 'Créer Ticket',
  'LNK_NEW_CONTACT' => 'Créer Contact',
  'LNK_NEW_ISSUE' => 'Signaler Bug',
  'LNK_NEW_LEAD' => 'Créer Lead',
  'LNK_NEW_MEETING' => 'Planifier Réunion',
  'LNK_NEW_NOTE' => 'Créer Note',
  'LNK_NEW_OPPORTUNITY' => 'Créer Affaire',
  'LNK_NEW_QUOTE' => 'Créer Devis',
  'LNK_NEW_TASK' => 'Créer Tâche',
  'NTC_NO_LEGENDS' => 'Indéfini',
);

