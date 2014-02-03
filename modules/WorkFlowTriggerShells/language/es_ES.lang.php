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
  'LBL_ALERT_TEMPLATES' => 'Plantillas de Alerta',
  'LBL_APOSTROPHE_S' => '&#39;s',
  'LBL_COMPARE_ANY_TIME_PART2' => 'no cambia durante',
  'LBL_COMPARE_ANY_TIME_PART3' => 'período especificado de tiempo',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'El campo no cambia durante un período determinado de tiempo',
  'LBL_COMPARE_CHANGE_PART' => 'cambia',
  'LBL_COMPARE_CHANGE_TITLE' => 'Cuando un campo en el módulo objetivo cambia',
  'LBL_COMPARE_COUNT_TITLE' => 'Disparar al alcanzar una cuenta específica',
  'LBL_COMPARE_SPECIFIC_PART' => 'cambia a o de un valor especificado',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => ' ',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'Cuando un campo en el módulo objetivo cambia a o de un valor especificado',
  'LBL_COUNT_TRIGGER1' => 'Total',
  'LBL_COUNT_TRIGGER1_2' => 'se compara a esta cantidad',
  'LBL_COUNT_TRIGGER2' => 'filtrar por relacionado',
  'LBL_COUNT_TRIGGER2_2' => 'sólo',
  'LBL_COUNT_TRIGGER3' => 'filtrar específicamente por',
  'LBL_COUNT_TRIGGER4' => 'filtrar por un segundo',
  'LBL_EVAL' => 'Evaluación del Disparador:',
  'LBL_FIELD' => 'campo',
  'LBL_FILTER_FIELD_PART1' => 'Filtrar por',
  'LBL_FILTER_FIELD_TITLE' => 'Cuando un campo en el módulo objetivo contiene un valor especificado',
  'LBL_FILTER_FORM_TITLE' => 'Definir una condición del workflow',
  'LBL_FILTER_LIST_STATEMEMT' => 'Filtar objetos basándose en lo siguiente:',
  'LBL_FILTER_REL_FIELD_PART1' => 'Especificar relacionado',
  'LBL_FILTER_REL_FIELD_TITLE' => 'Cuando el módulo objetivo cambia y un campo en el módulo relacionado contiene un valor específico',
  'LBL_FUTURE_TRIGGER' => 'Especificar nuevo',
  'LBL_LIST_EVAL' => 'Eval:',
  'LBL_LIST_FIELD' => 'Campo:',
  'LBL_LIST_FORM_TITLE' => 'Lista de Disparadores',
  'LBL_LIST_FRAME_PRI' => 'Disparador:',
  'LBL_LIST_FRAME_SEC' => 'Filtro:',
  'LBL_LIST_NAME' => 'Descripción:',
  'LBL_LIST_STATEMEMT' => 'Disparar un evento basándose en lo siguiente:',
  'LBL_LIST_TYPE' => 'Tipo:',
  'LBL_LIST_VALUE' => 'Valor:',
  'LBL_MODULE' => 'módulo',
  'LBL_MODULE_NAME' => 'Condiciones',
  'LBL_MODULE_NAME_SINGULAR' => 'Condición',
  'LBL_MODULE_SECTION_TITLE' => 'Cuando se cumplan estas condiciones',
  'LBL_MODULE_TITLE' => 'Disparadores de Workflow: Inicio',
  'LBL_MUST_SELECT_VALUE' => 'Debe seleccionar un valor para este campo',
  'LBL_NAME' => 'Nombre del Disparador:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'Crear Filtro',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'Crear Filtro [Alt+F]',
  'LBL_NEW_FORM_TITLE' => 'Nuevo Disparador',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'Crear Disparador',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'Crear Disparador [Alt+T]',
  'LBL_PAST_TRIGGER' => 'Especificar viejo',
  'LBL_RECORD' => 'del módulo',
  'LBL_SEARCH_FORM_TITLE' => 'Lista de Disparadores de Workflow',
  'LBL_SELECT_1ST_FILTER' => 'Debe seleccionar un campo válido como 1er filtro',
  'LBL_SELECT_2ND_FILTER' => 'Debe seleccionar un campo válido como 2º filtro',
  'LBL_SELECT_AMOUNT' => 'Debe seleccionar la cantidad',
  'LBL_SELECT_OPTION' => 'Por favor, seleccione una opción.',
  'LBL_SELECT_TARGET_FIELD' => 'Por favor, seleccione un campo de destino.',
  'LBL_SELECT_TARGET_MOD' => 'Por favor, seleccione un módulo relacionado de destino.',
  'LBL_SHOW' => 'Mostrar',
  'LBL_SHOW_PAST' => 'Modificar Valor Anterior:',
  'LBL_SPECIFIC_FIELD' => '&#39;s campo específico',
  'LBL_SPECIFIC_FIELD_LNK' => 'campo especificado',
  'LBL_TRIGGER' => 'Cuando',
  'LBL_TRIGGER_FILTER_TITLE' => 'Filtros de Disparador',
  'LBL_TRIGGER_FORM_TITLE' => 'Definir una condición para la ejecución del workflow',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'Cuando el módulo objetivo cambia',
  'LBL_TYPE' => 'Tipo:',
  'LBL_VALUE' => 'valor',
  'LBL_WHEN_VALUE1' => 'Cuando el valor del campo es',
  'LBL_WHEN_VALUE2' => 'Cuando el valor de',
  'LNK_NEW_TRIGGER' => 'Crear Disparador',
  'LNK_NEW_WORKFLOW' => 'Crear Workflow',
  'LNK_TRIGGER' => 'Disparadores de Workflow',
  'LNK_WORKFLOW' => 'Objetos de Workflow',
  'NTC_REMOVE_TRIGGER' => '¿Está seguro de que desea quitar este trigger?',
);

