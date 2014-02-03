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
  'LBL_ALERT_TEMPLATES' => 'Modelos de Alertas',
  'LBL_APOSTROPHE_S' => 's',
  'LBL_COMPARE_ANY_TIME_PART2' => 'não altera desde',
  'LBL_COMPARE_ANY_TIME_PART3' => 'tempo determinado',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'Campo não sofre alterações para um período especificado de tempo',
  'LBL_COMPARE_CHANGE_PART' => 'alterações',
  'LBL_COMPARE_CHANGE_TITLE' => 'Quando um campo no módulo de destino altera',
  'LBL_COMPARE_COUNT_TITLE' => 'Iniciar após um determinado número de vezes',
  'LBL_COMPARE_SPECIFIC_PART' => 'altera para ou de um valor específico',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => 'LBL_COMPARE_SPECIFIC_PART_TIME',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'Quando um campo no módulo de destino altera para ou de um valor específico',
  'LBL_COUNT_TRIGGER1' => 'Total',
  'LBL_COUNT_TRIGGER1_2' => 'em comparação com este valor',
  'LBL_COUNT_TRIGGER2' => 'filtrar por relacionado',
  'LBL_COUNT_TRIGGER2_2' => 'apenas',
  'LBL_COUNT_TRIGGER3' => 'filtrar especificamente por',
  'LBL_COUNT_TRIGGER4' => 'filtrar por um segundo',
  'LBL_EVAL' => 'Avaliação do Trigger:',
  'LBL_FIELD' => 'campo',
  'LBL_FILTER_FIELD_PART1' => 'Filtrar por',
  'LBL_FILTER_FIELD_TITLE' => 'Quando um campo no módulo de destino contém um valor específico',
  'LBL_FILTER_FORM_TITLE' => 'Definir condições de Workflow',
  'LBL_FILTER_LIST_STATEMEMT' => 'Filtrar objectos baseado no seguinte:',
  'LBL_FILTER_REL_FIELD_PART1' => 'Especificar relacionado',
  'LBL_FILTER_REL_FIELD_TITLE' => 'Quando o módulo de destino altera e um campo num módulo relacionado contém um valor específico',
  'LBL_FUTURE_TRIGGER' => 'Especificar novo',
  'LBL_LIST_EVAL' => 'Aval:',
  'LBL_LIST_FIELD' => 'Campo:',
  'LBL_LIST_FORM_TITLE' => 'Lista de Triggers',
  'LBL_LIST_FRAME_PRI' => 'Trigger:',
  'LBL_LIST_FRAME_SEC' => 'Filtro:',
  'LBL_LIST_NAME' => 'Descrição:',
  'LBL_LIST_STATEMEMT' => 'Iniciar um evento  baseado no seguinte:',
  'LBL_LIST_TYPE' => 'Tipo:',
  'LBL_LIST_VALUE' => 'Valor:',
  'LBL_MODULE' => 'módulo',
  'LBL_MODULE_NAME' => 'Condições',
  'LBL_MODULE_NAME_SINGULAR' => 'Condição',
  'LBL_MODULE_SECTION_TITLE' => 'Quando estas condições são verificadas',
  'LBL_MODULE_TITLE' => 'Triggers de Workflow: Tela Principal',
  'LBL_MUST_SELECT_VALUE' => 'Deve selecionar um valor para este campo',
  'LBL_NAME' => 'Nome do Trigger:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'Criar Filtro',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'Criar Filtro [Alt+F]',
  'LBL_NEW_FORM_TITLE' => 'Criar Triggers',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'Criar Trigger',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'Criar Trigger [Alt+T]',
  'LBL_PAST_TRIGGER' => 'Especificar antigo',
  'LBL_RECORD' => 'módulos',
  'LBL_SEARCH_FORM_TITLE' => 'Pesquisa de Triggers de Workflow',
  'LBL_SELECT_1ST_FILTER' => 'Deve selecionar um campo de primeiro filtro válido',
  'LBL_SELECT_2ND_FILTER' => 'Deve selecionar um campo de segundo filtro',
  'LBL_SELECT_AMOUNT' => 'Deve selecionar o montante',
  'LBL_SELECT_OPTION' => 'Por favor selecione uma opção.',
  'LBL_SELECT_TARGET_FIELD' => 'Por favor selecione um campo de destino.',
  'LBL_SELECT_TARGET_MOD' => 'Por favor selecione um módulo relacionado com o destino.',
  'LBL_SHOW' => 'Mostrar',
  'LBL_SHOW_PAST' => 'Modificar o valor antigo:',
  'LBL_SPECIFIC_FIELD' => 'campo específico',
  'LBL_SPECIFIC_FIELD_LNK' => 'campo específico',
  'LBL_TRIGGER' => 'Quando',
  'LBL_TRIGGER_FILTER_TITLE' => 'Filtrar Triggers:',
  'LBL_TRIGGER_FORM_TITLE' => 'Definir condições para a execução do Workflow',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'Quando o módulo de destino altera',
  'LBL_TYPE' => 'Tipo:',
  'LBL_VALUE' => 'valor',
  'LBL_WHEN_VALUE1' => 'Quando o valor do campo é',
  'LBL_WHEN_VALUE2' => 'Quando o valor de',
  'LNK_NEW_TRIGGER' => 'Criar Trigger:',
  'LNK_NEW_WORKFLOW' => 'Criar Workflow',
  'LNK_TRIGGER' => 'Triggers de Workflow',
  'LNK_WORKFLOW' => 'Objetos de Workflow',
  'NTC_REMOVE_TRIGGER' => 'Tem a certeza de que pretende eliminar este trigger',
);

