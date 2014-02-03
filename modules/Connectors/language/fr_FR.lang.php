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
  'ERROR_EMPTY_RECORD_ID' => 'Erreur : Id de l&#39;enregistrement non spécifié ou vide.',
  'ERROR_EMPTY_SOURCE_ID' => 'Erreur : Id de la source non spécifié ou vide.',
  'ERROR_EMPTY_WRAPPER' => 'Erreur : Impossible de récupérer les champs disponibles pour la source [{$source_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Erreur : Aucun détail supplémentaire n&#39;a été retrouvé pour l&#39;enregistrement.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Erreur : Il n&#39;y a pas de correspondance défini avec un quelconque Connecteur pour ce module.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Erreur : Il n&#39;y a pas de champ de module défini pour afficher les résultats. Veuillez contacter votre administrateur système.',
  'ERROR_NO_FIELDS_MAPPED' => 'Erreur : Vous devez effectuer au moins une correspondance entre un champ du Connecteur et un champ du module pour chacun des modules.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Aucun module n&#39;a été activé pour ce connecteur. Sélectionnez un module pour ce connecteur dans la page des Connecteurs actifs.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Erreur: Il n&#39;y a pas de connecteur activé qui possède des champs de recherche définis.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Erreur : Il n&#39;y a pas de champ de recherche défini pour ce module et ce connecteur. Veuillez contacter votre administrateur système.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Erreur : Aucun fichier sourcedefs.php n&#39;a été trouvé.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Erreur : Aucune source n&#39;a été définie pour récupérer les données.',
  'ERROR_RECORD_NOT_SELECTED' => 'Erreur : Veuillez sélectionner un enregistrement dans la liste avant de continuer.',
  'LBL_ADDRCITY' => 'Ville',
  'LBL_ADDRCOUNTRY' => 'Pays',
  'LBL_ADDRCOUNTRY_ID' => 'Pays Id',
  'LBL_ADDRSTATEPROV' => 'Etat',
  'LBL_ADD_MODULE' => 'Ajouter',
  'LBL_ADMINISTRATION' => 'Administration du Connecteur',
  'LBL_ADMINISTRATION_MAIN' => 'Paramètres du Connecteur',
  'LBL_AVAILABLE' => 'Disponible',
  'LBL_BACK' => '< Retour',
  'LBL_CLOSE' => 'Fermer',
  'LBL_COMPANY_ID' => 'Société (ID)',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Un ou des champs obligatoires ont été laissé vide.  Réalisez les changements ?',
  'LBL_CONNECTOR' => 'Connecteur',
  'LBL_CONNECTOR_FIELDS' => 'Champs du Connecteur',
  'LBL_DATA' => 'Donnée',
  'LBL_DEFAULT' => 'Défaut',
  'LBL_DELETE_MAPPING_ENTRY' => 'Etes-vous sûr(e) de vouloir supprimer cette entrée?',
  'LBL_DISABLED' => 'Désactivé',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Auncune correspondance trouvé pour vos critères de recherche.',
  'LBL_ENABLED' => 'Activé',
  'LBL_EXTERNAL' => 'Autoriser les utilisateurs à créer des liens externes pour ce connecteur. Pour utiliser ce connecteur, les propriétés devraient aussi être définies dans la rubrique de définition des propriétés du connecteur',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Afin de pouvoir utiliser ce connecteur, vous devez positionner les paramètres dans la page appropriée.',
  'LBL_FINSALES' => 'Finsales',
  'LBL_INFO_INLINE' => 'Info',
  'LBL_MARKET_CAP' => 'Market Cap',
  'LBL_MERGE' => 'Fusionner',
  'LBL_MODIFY_DISPLAY_DESC' => 'Sélectionner les modules disponibles pour chaque connecteur.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Paramètres des Connecteurs : Activer les Connecteurs',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Activer les connecteurs',
  'LBL_MODIFY_MAPPING_DESC' => 'Correspondance des champs du Connecteur avec les champs du module afin de déterminer quelles données du Connecteur peuvent être visualisées et fusionnées avec les données du module.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Paramètres du Connecteur : Correspondance des champs',
  'LBL_MODIFY_MAPPING_TITLE' => 'Correspondance des champs pour le Connecteur',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Configurer les Propriétés pour chacun des Connecteurs, incluant les URLs et les clés des APIs.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Paramètres du Connecteur :  Paramètres du Connecteur',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Positionner les Paramètres du Connecteur',
  'LBL_MODIFY_SEARCH' => 'Recherche',
  'LBL_MODIFY_SEARCH_DESC' => 'Sélectionner les champs du connecteur a utilisé pour la recherche des données pour chacun des modules.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Paramètres du Connecteur : Gestion des paramètres de recherche',
  'LBL_MODIFY_SEARCH_TITLE' => 'Gérer la recherche du Connecteur',
  'LBL_MODULE_FIELDS' => 'Champs du module',
  'LBL_MODULE_NAME' => 'Connecteurs',
  'LBL_MODULE_NAME_SINGULAR' => 'Connecteur',
  'LBL_NO_PROPERTIES' => 'Il n&#39;y a pas de paramètres de configuration pour ce conencteur.',
  'LBL_PARENT_DUNS' => 'DUNS Parent',
  'LBL_PREVIOUS' => '< Retour',
  'LBL_QUOTE' => 'Devis',
  'LBL_RECNAME' => 'Nom de la Société',
  'LBL_RESET_BUTTON_TITLE' => 'Réinitialiser [Alt+R]',
  'LBL_RESET_TO_DEFAULT' => 'Réinitialisation à la valeur par défaut',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Etes-vous sûr(e) de vouloir réinitialiser avec la configuration par défaut ?',
  'LBL_RESULT_LIST' => 'Liste des données',
  'LBL_RUN_WIZARD' => 'Lancer l&#39;assistant',
  'LBL_SAVE' => 'Sauvegarder',
  'LBL_SEARCHING_BUTTON_LABEL' => 'Recherche...',
  'LBL_SHOW_IN_LISTVIEW' => 'Voir la liste de fusion',
  'LBL_SMART_COPY' => 'Copie intelligente',
  'LBL_STEP1' => 'Rechercher et voir les données',
  'LBL_STEP2' => 'Fusionner les enregistrements avec',
  'LBL_SUMMARY' => 'Résumé',
  'LBL_TEST_SOURCE' => 'Tester le  Connecteur',
  'LBL_TEST_SOURCE_FAILED' => 'Test échoué',
  'LBL_TEST_SOURCE_RUNNING' => 'Test en cours...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Test réussi',
  'LBL_TITLE' => 'Fusion des données',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Parent DUNS Ultime',
);

