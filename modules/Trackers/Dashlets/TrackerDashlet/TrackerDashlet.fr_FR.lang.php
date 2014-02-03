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



$dashletStrings['TrackerDashlet'] = array('LBL_TITLE'            => 'Rapport de Suivi',
                                          'LBL_DESCRIPTION'      => 'Dashlet pour passer des requêtes sur les données de Suivi',
                                          'LBL_SAVING'           => 'Requête en exécution...',
                                          'LBL_SAVED'            => 'Requête exécutée',
                                          'LBL_CLEAR'            => 'Vider',
                                          'LBL_CLEAR_TOOLTIP'    => 'Vider la valeur du champ date',
                                          'LBL_CONFIGURE_TITLE'  => 'Titre',
                                          'LBL_CONFIGURE_HEIGHT' => 'Hauteur (1 - 300)',
										  'LBL_SELECT_QUERY'     => 'Sélectionner une requête...',
										  'LBL_FILTER'              => 'Filtrer',
										  'LBL_FILTER_TOOLTIP'      => 'Filtrer par une valeur dans le champ date',
										  'LBL_SINCE'            => 'Depuis : ',
										  'LBL_CHOOSE_DATE_TOOLTIP' => 'En sélectionnant un rapport, vous pouvez fournir une date pour filtrer les données.' .
										                               '  La valeur de la date saisie remplacera la valeur de la date par défaut pour ce rapport.' .
										                               '  Par exemple, dans le rapport "Mon activité (Cette semaine)", la' .
										                               ' valeur saisie sera utilisée pour afficher tous les enregistrement créés après cette date' .
										                               ' à la place de la période initialement définie de une semaine.',
);
