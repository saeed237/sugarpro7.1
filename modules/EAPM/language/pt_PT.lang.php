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
  'LBL_ACTIVE' => 'Activo',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
  'LBL_API_CONSKEY' => 'Chave do Consumidor',
  'LBL_API_CONSSECRET' => 'Segredo do Consumidor',
  'LBL_API_DATA' => 'Dados da API',
  'LBL_API_OAUTHTOKEN' => 'Token OAuth',
  'LBL_API_TYPE' => 'Tipo de Autenticação',
  'LBL_APPLICATION' => 'Aplicação',
  'LBL_APPLICATION_FOUND_NOTICE' => 'Uma conta para esta aplicação já existe. Foi reintegrada a conta existente.',
  'LBL_ASSIGNED_TO_ID' => 'Id Utilizador Atribuído',
  'LBL_ASSIGNED_TO_NAME' => 'Utilizador do Sugar',
  'LBL_AUTH_ERROR' => 'Tentativa de autenticação com a conta externa falhou.',
  'LBL_AUTH_UNSUPPORTED' => 'Este método de autorização não é suportado pela aplicação',
  'LBL_BASIC_SAVE_NOTICE' => 'Carregar em Guardar para criar um registo de conta externa. O Sugar irá então validar as suas credenciais.',
  'LBL_CONNECTED' => 'Ligado',
  'LBL_CONNECT_BUTTON_TITLE' => 'Ligar',
  'LBL_CREATED' => 'Criado Por',
  'LBL_CREATED_ID' => 'Criado Por Id',
  'LBL_CREATED_USER' => 'Criado pelo Utilizador',
  'LBL_DATE_ENTERED' => 'Data de Criação',
  'LBL_DATE_MODIFIED' => 'Data de Modificação',
  'LBL_DELETED' => 'Eliminado',
  'LBL_DESCRIPTION' => 'Descrição',
  'LBL_DISCONNECTED' => 'Desligado',
  'LBL_DISPLAY_PROPERTIES' => 'Propriedades do Display',
  'LBL_ERR_FACEBOOK' => 'O Facebook retornou um erro e o feed não pode ser mostrado.',
  'LBL_ERR_FAILED_QUICKCHECK' => 'Não está autenticado actualmente na sua conta {0}. Carregar em OK para fazer nova autenticação na sua conta para activar o registo da conta externa.',
  'LBL_ERR_NO_AUTHINFO' => 'Não existe informação de autenticação para esta conta.',
  'LBL_ERR_NO_RESPONSE' => 'Um erro ocorreu quando foi tentado gravar para a conta externa.',
  'LBL_ERR_NO_TOKEN' => 'Não existe tokens válidos de autenticação para esta conta.',
  'LBL_ERR_OAUTH_FACEBOOK_1' => 'A sessão do Facebook expirou. Para obter o stream, por favor',
  'LBL_ERR_OAUTH_FACEBOOK_2' => 'faça login novamente no Facebook',
  'LBL_ERR_POPUPS_DISABLED' => 'Por favor active as janelas popup no seu navegador ou acrescente uma excepção para o website "{0}" na lista de excepções para se conseguir ligar.',
  'LBL_ERR_TWITTER' => 'O Twitter retornou um erro, e o feed não pode ser mostrado.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Ver Histórico',
  'LBL_HOMEPAGE_TITLE' => 'As Minhas Contas Externas',
  'LBL_ID' => 'ID',
  'LBL_LIST_FORM_TITLE' => 'Lista de Conta Externa',
  'LBL_LIST_NAME' => 'Nome',
  'LBL_MEET_NOW_BUTTON' => 'Reunir Agora',
  'LBL_MODIFIED' => 'Modificado Por',
  'LBL_MODIFIED_ID' => 'Modificado Por Id',
  'LBL_MODIFIED_NAME' => 'Modificado Por Nome',
  'LBL_MODIFIED_USER' => 'Modificado pelo Utilizador',
  'LBL_MODULE_NAME' => 'Conta Externa',
  'LBL_MODULE_NAME_SINGULAR' => 'Conta Externa',
  'LBL_MODULE_TITLE' => 'Contas Externas',
  'LBL_NAME' => 'Nome de Utilizador da App',
  'LBL_NEW_FORM_TITLE' => 'Nova Conta Externa',
  'LBL_NOTE' => 'Por favor repare que',
  'LBL_OAUTH_NAME' => '%s',
  'LBL_OAUTH_SAVE_NOTICE' => 'Carregar Gravar para criar um registo de conta externa. Será direccionado para uma página para inserir a informação da conta, para autorizar o acesso do Sugar. Depois de introduzida a informação da conta, irá ser direccionado de volta para o Sugar.',
  'LBL_OMIT_URL' => '(Omitir http:// ou https://)',
  'LBL_PASSWORD' => 'Palavra-passe da App',
  'LBL_REAUTHENTICATE_KEY' => 'a',
  'LBL_REAUTHENTICATE_LABEL' => 'Repetir autenticação',
  'LBL_SEARCH_FORM_TITLE' => 'Pesquisar em Fonte Externa',
  'LBL_SUCCESS' => 'SUCESSO',
  'LBL_SUGAR_EAPM_SUBPANEL_TITLE' => 'Contas Externas',
  'LBL_SUGAR_USER_NAME' => 'Utilizado Sugar',
  'LBL_TEAM' => 'Equipas',
  'LBL_TEAMS' => 'Equipas',
  'LBL_TEAM_ID' => 'ID da Equipa',
  'LBL_TITLE_LOTUS_LIVE_DOCUMENTS' => 'Documentos LotusLive&#153;',
  'LBL_TITLE_LOTUS_LIVE_MEETINGS' => 'Próximas Reuniões LotusLive&#153;',
  'LBL_URL' => 'URL',
  'LBL_USER_NAME' => 'Nome do Utilizador da App',
  'LBL_VALIDATED' => 'Acesso Validado',
  'LBL_VIEW_LOTUS_LIVE_DOCUMENTS' => 'Ver Documentos LotusLive&#153;',
  'LBL_VIEW_LOTUS_LIVE_MEETINGS' => 'Ver as Próximas Reuniões LotusLive&#153;',
  'LNK_IMPORT_SUGAR_EAPM' => 'Importar Contas Externas',
  'LNK_LIST' => 'Ver Contas Externas',
  'LNK_NEW_RECORD' => 'Criar Conta Externa',
);

