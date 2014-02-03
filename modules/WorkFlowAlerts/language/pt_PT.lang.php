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
  'LBL_ADDRESS_BCC' => 'bcc:',
  'LBL_ADDRESS_CC' => 'cc:',
  'LBL_ADDRESS_TO' => 'para:',
  'LBL_ADDRESS_TYPE' => 'a utilizar o endereço',
  'LBL_ADDRESS_TYPE_TARGET' => 'tipo',
  'LBL_ALERT_CURRENT_USER' => 'Um Utilizador associado com o destino',
  'LBL_ALERT_CURRENT_USER_TITLE' => 'Um Utilizador associado com o módulo de destino',
  'LBL_ALERT_LOGIN_USER_TITLE' => 'Utilizador autenticado no momento da execução',
  'LBL_ALERT_REL1' => 'Módulo Relacionado:',
  'LBL_ALERT_REL2' => 'Módulo Relacionado Relacionado:',
  'LBL_ALERT_REL_USER' => 'Um Utilizador associado com um relacionado',
  'LBL_ALERT_REL_USER_CUSTOM' => 'Destinatário associado com um relacionado',
  'LBL_ALERT_REL_USER_CUSTOM_TITLE' => 'Destinatário associado com um módulo relacionado',
  'LBL_ALERT_REL_USER_TITLE' => 'Um Utilizador associado com um módulo relacionado',
  'LBL_ALERT_SPECIFIC_ROLE' => 'Todos os Utilizadores numa especificada',
  'LBL_ALERT_SPECIFIC_ROLE_TITLE' => 'Todos os Utilizadores numa função especificada',
  'LBL_ALERT_SPECIFIC_TEAM' => 'Todos os Utilizadores numa especificada',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET' => 'Todos os utilizadores que pertencem às equipas associadas com o módulo de destino',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET_TITLE' => 'Membros da equipa associada com o módulo de destino',
  'LBL_ALERT_SPECIFIC_TEAM_TITLE' => 'Todos os Utilizadores numa equipa especificada',
  'LBL_ALERT_SPECIFIC_USER' => 'Um especificado',
  'LBL_ALERT_SPECIFIC_USER_TITLE' => 'Um Utilizador especificado',
  'LBL_ALERT_TRIG_USER_CUSTOM' => 'Destinatário associado com o módulo de destino',
  'LBL_ALERT_TRIG_USER_CUSTOM_TITLE' => 'Destinatário associado com o módulo de destino',
  'LBL_AND' => 'e Nome de Campo:',
  'LBL_ARRAY_TYPE' => 'Tipo de Acção:',
  'LBL_BLANK' => '',
  'LBL_CUSTOM_USER' => 'Utilizador à Medida:',
  'LBL_EDITLAYOUT' => 'Editar Layout',
  'LBL_FIELD' => 'Campo',
  'LBL_FIELD_VALUE' => 'Utilizador Seleccionado:',
  'LBL_FILTER_BY' => '(Filtro Adicional) Filtrar módulo relacionado por',
  'LBL_FILTER_CUSTOM' => '(Filtro Adicional) Filtrar módulo relacionado por específico',
  'LBL_LIST_ADDRESS_TYPE' => 'Tipo de Endereço',
  'LBL_LIST_ARRAY_TYPE' => 'Tipo de Acção',
  'LBL_LIST_FIELD_VALUE' => 'Utilizador',
  'LBL_LIST_FORM_TITLE' => 'Lista de Destinatários',
  'LBL_LIST_RELATE_TYPE' => 'Tipo de Relação',
  'LBL_LIST_REL_MODULE1' => 'Módulo Relacionado',
  'LBL_LIST_REL_MODULE2' => 'Módulo Relacionado Relacionado',
  'LBL_LIST_STATEMENT' => 'Destinatários de Alerta:',
  'LBL_LIST_STATEMENT_CONTENT' => 'Enviar Alertas para o seguintes Destinatários',
  'LBL_LIST_STATEMENT_INVITE' => 'Convidados de Reuniões/ Chamadas Telefónicas',
  'LBL_LIST_USER_TYPE' => 'Tipo de Utilizador',
  'LBL_LIST_WHERE_FILTER' => 'Estado',
  'LBL_MODULE_NAME' => 'Lista de Destinatários dos Alertas',
  'LBL_MODULE_NAME_INVITE' => 'Lista de Convidados',
  'LBL_MODULE_NAME_SINGULAR' => 'Lista de Destinatários dos Alertas',
  'LBL_MODULE_NAME_SINGULAR_INVITE' => 'Lista de Convidados',
  'LBL_MODULE_TITLE' => 'Destinatários: Ecrã Principal',
  'LBL_NEW_FORM_TITLE' => 'Criar Destinatários de Workflow',
  'LBL_NEXT_BUTTON' => 'Próximo',
  'LBL_PLEASE_SELECT' => 'Por favor seleccione',
  'LBL_PREVIOUS_BUTTON' => 'Anterior',
  'LBL_RECORD' => 'Módulo',
  'LBL_RELATE_TYPE' => 'Tipo de Relacionamento:',
  'LBL_REL_CUSTOM' => 'Seleccionar Campos  de E-mail à Medida',
  'LBL_REL_CUSTOM2' => 'Campo',
  'LBL_REL_CUSTOM3' => 'Campo',
  'LBL_REL_CUSTOM_STRING' => 'Seleccionar e-mails à medida e nomes de campos',
  'LBL_REL_MODULE1' => 'Módulo Relacionado:',
  'LBL_REL_MODULE2' => 'Módulo Relacionado Relacionado:',
  'LBL_ROLE' => 'função',
  'LBL_SEARCH_FORM_TITLE' => 'Pesquisa de Destinatários de Workflow',
  'LBL_SELECT_EMAIL' => 'Deve seleccionar um campo de e-mail personalizado.',
  'LBL_SELECT_FILTER' => 'Deve seleccionar um campo para filtrar',
  'LBL_SELECT_NAME' => 'Deve seleccionar um campo de nome personalizado.',
  'LBL_SELECT_NAME_EMAIL' => 'Deve seleccionar os campos de nome e e-mail',
  'LBL_SELECT_VALUE' => 'Deve seleccionar um valor válido.',
  'LBL_SEND_EMAIL' => 'Enviar um e-mail a:',
  'LBL_SPECIFIC_FIELD' => 'campo',
  'LBL_TEAM' => 'Equipa',
  'LBL_USER' => 'Utilizador',
  'LBL_USER1' => 'quem criou o registo',
  'LBL_USER2' => 'quem modificou pela última vez o registo',
  'LBL_USER3' => 'Actual',
  'LBL_USER3b' => 'do sistema',
  'LBL_USER4' => 'a quem é associado o registo',
  'LBL_USER5' => 'a quem foi associado o registo',
  'LBL_USER_MANAGER' => 'Responsável do Utilizador',
  'LBL_USER_TYPE' => 'Tipo de Utilizador:',
  'LBL_WHERE_FILTER' => 'Estado:',
  'LNK_NEW_WORKFLOW' => 'Criar Workflow',
  'LNK_WORKFLOW' => 'Objectos de Workflow',
  'NTC_REMOVE_ALERT_USER' => 'Tem a certeza de que pretende eliminar o destinatário deste alerta?',
);

