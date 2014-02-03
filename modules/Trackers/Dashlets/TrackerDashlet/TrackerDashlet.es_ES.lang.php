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



$dashletStrings['TrackerDashlet'] = array('LBL_TITLE'            => 'Informes de Monitorización',
                                          'LBL_DESCRIPTION'      => 'Un dashlet para ejecutar consultas sobre datos de Monitorización',
                                          'LBL_SAVING'           => 'Ejecutando Consulta ...',
                                          'LBL_SAVED'            => 'Consulta Completada',
                                          'LBL_CLEAR'            => 'Limpiar',
                                          'LBL_CLEAR_TOOLTIP'    => 'Limpia el valor del campo de fecha',
                                          'LBL_CONFIGURE_TITLE'  => 'Título',
                                          'LBL_CONFIGURE_HEIGHT' => 'Altura (1 - 300)',
										  'LBL_SELECT_QUERY'     => 'Seleccionar Consulta...',
										  'LBL_FILTER'              => 'Filtro',
										  'LBL_FILTER_TOOLTIP'      => 'Filtra por el valor del campo de fecha',
										  'LBL_SINCE'            => 'Desde: ',
										  'LBL_CHOOSE_DATE_TOOLTIP' => 'Para informes de selección, puede proporcionar un filtro de datos.' .
										                               '  El valor de fecha introducido reemplazará la fecha por defecto del informe.' .
										                               '  Por ejemplo, en el informe "Mi Actividad (Esta Semana)", el' .
										                               ' valor será usado para mostrar todos los registros tras la fecha de filtrado' .
										                               ' en lugar del período por defecto de una semana.',
);
