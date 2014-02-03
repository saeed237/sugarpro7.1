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
  'ERROR_EMPTY_RECORD_ID' => 'Erro: Id do Registo não especificado ou vazio.',
  'ERROR_EMPTY_SOURCE_ID' => 'Erro: Id da Fonte não especificado ou vazio.',
  'ERROR_EMPTY_WRAPPER' => 'Erro: Incapaz de recuperar instância wrapper para a fonte [{$source_id}]',
  'ERROR_NO_ADDITIONAL_DETAIL' => 'Erro: Não foram encontrados detalhes adicionais para o registo.',
  'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Erro: Não existem conectores mapeados para este módulo.',
  'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Erro: Não existem campos de módulo que tenham sido mapeados para exibição nos resultados. Por favor contacte o administrador do sistema.',
  'ERROR_NO_FIELDS_MAPPED' => 'Erro: Deverá mapear pelo menos um campo de Conector a um campo de módulo para cada entrada de módulo.',
  'ERROR_NO_SEARCHDEFS_DEFINED' => 'Nenhuns módulos foram activados para este conector. Seleccione um módulo para este conector na página Activar Conectores.',
  'ERROR_NO_SEARCHDEFS_MAPPED' => 'Erro: Nenhum conector activo tem campos de pesquisa definidos.',
  'ERROR_NO_SEARCHDEFS_MAPPING' => 'Erro: Não existem campos de pesquisa definidos para o módulo e o conector. Por favor contacte o administrador do sistema.',
  'ERROR_NO_SOURCEDEFS_FILE' => 'Erro: Não foi encontrado o ficheiro sourcedefs.php.',
  'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Erro: Não foram especificadas as fontes para as quais se recuperam os dados.',
  'ERROR_RECORD_NOT_SELECTED' => 'Erro: Por favor seleccione um registo da lista antes de prosseguir.',
  'LBL_ADDRCITY' => 'Cidade',
  'LBL_ADDRCOUNTRY' => 'País',
  'LBL_ADDRCOUNTRY_ID' => 'Id País',
  'LBL_ADDRSTATEPROV' => 'Estado',
  'LBL_ADD_MODULE' => 'Adicionar',
  'LBL_ADMINISTRATION' => 'Administração do Conector',
  'LBL_ADMINISTRATION_MAIN' => 'Definições do Conector',
  'LBL_AVAILABLE' => 'Disponível',
  'LBL_BACK' => '< Voltar',
  'LBL_CLOSE' => 'Fechar',
  'LBL_COMPANY_ID' => 'Id Empresa',
  'LBL_CONFIRM_CONTINUE_SAVE' => 'Alguns campos obrigatórios foram deixados em branco. Prosseguir com a gravação das alterações?',
  'LBL_CONNECTOR' => 'Conector',
  'LBL_CONNECTOR_FIELDS' => 'Campos do Conector',
  'LBL_DATA' => 'Dados',
  'LBL_DEFAULT' => 'Padrão',
  'LBL_DELETE_MAPPING_ENTRY' => 'Tem a certeza que pretende eliminar esta entrada?',
  'LBL_DISABLED' => 'Desactivado',
  'LBL_DUNS' => 'DUNS',
  'LBL_EMPTY_BEANS' => 'Não foram encontrados resultados com os seus critérios de pesquisa.',
  'LBL_ENABLED' => 'Activado',
  'LBL_EXTERNAL' => 'Este conector permite aos utilizadores criar registos de uma conta externa. Para utilizar este conector, as suas propriedades deverão estar definidas na página &#39;Definir Propriedades do Conector&#39;.',
  'LBL_EXTERNAL_SET_PROPERTIES' => 'Para usar este conector, as propriedades também devem ser definidas na página de configurações Definir Propriedades do Conector.',
  'LBL_FINSALES' => 'Finsales',
  'LBL_INFO_INLINE' => 'Info',
  'LBL_MARKET_CAP' => 'Mercado de Capitalização',
  'LBL_MERGE' => 'Fusão',
  'LBL_MODIFY_DISPLAY_DESC' => 'Seleccionar os módulos que são activados para cada conector.',
  'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Definições do Conector: Activar Conectores',
  'LBL_MODIFY_DISPLAY_TITLE' => 'Activar Conectores',
  'LBL_MODIFY_MAPPING_DESC' => 'Mapear campos de conector de modo a determinar que dados do conector possam ser visualizados e integrados nos registos do módulo.',
  'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Definições do Conector: Mapear Campos do Conector',
  'LBL_MODIFY_MAPPING_TITLE' => 'Mapear Campos do Conector',
  'LBL_MODIFY_PROPERTIES_DESC' => 'Configurar as propriedades para cada conector, incluindo URLs e chaves API.',
  'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Definições do Conector: Definir Propriedades do Conector',
  'LBL_MODIFY_PROPERTIES_TITLE' => 'Definir Propriedades do Conector',
  'LBL_MODIFY_SEARCH' => 'Pesquisar',
  'LBL_MODIFY_SEARCH_DESC' => 'Seleccionar os campos do conector a utilizar na pesquisa por dados para cada módulo.',
  'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Definições do Conector: Gerir Pesquisa de Conector',
  'LBL_MODIFY_SEARCH_TITLE' => 'Gerir Pesquisa do Conector',
  'LBL_MODULE_FIELDS' => 'Campos do Módulo',
  'LBL_MODULE_NAME' => 'Conectores',
  'LBL_MODULE_NAME_SINGULAR' => 'Conector',
  'LBL_NO_PROPERTIES' => 'Não há propriedades configuráveis para este conector.',
  'LBL_PARENT_DUNS' => 'DUNS de Origem',
  'LBL_PREVIOUS' => '< Voltar',
  'LBL_QUOTE' => 'Cotação',
  'LBL_RECNAME' => 'Nome de Empresa',
  'LBL_RESET_BUTTON_TITLE' => 'Reiniciar [Alt+R]',
  'LBL_RESET_TO_DEFAULT' => 'Reiniciar para Padrão',
  'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Tem a certeza que pretende reiniciar para a configuração padrão?',
  'LBL_RESULT_LIST' => 'Lista de Dados',
  'LBL_RUN_WIZARD' => 'Executar Assistente',
  'LBL_SAVE' => 'Gravar',
  'LBL_SEARCHING_BUTTON_LABEL' => 'A pesquisar...',
  'LBL_SHOW_IN_LISTVIEW' => 'Mostrar em Vista de Lista de Fusão',
  'LBL_SMART_COPY' => 'Cópia Inteligente',
  'LBL_STEP1' => 'Pesquisar e Visualizar Dados',
  'LBL_STEP2' => 'Fundir Registos com',
  'LBL_SUMMARY' => 'Resumo',
  'LBL_TEST_SOURCE' => 'Testar Conector',
  'LBL_TEST_SOURCE_FAILED' => 'Teste Falhou',
  'LBL_TEST_SOURCE_RUNNING' => 'A executar Teste...',
  'LBL_TEST_SOURCE_SUCCESS' => 'Teste Bem Sucedido',
  'LBL_TITLE' => 'Fusão de Dados',
  'LBL_ULTIMATE_PARENT_DUNS' => 'Ultimate Parent DUNS',
);

