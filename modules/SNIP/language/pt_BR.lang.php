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
  'LBL_SNIP_KEY_DESC' => 'OAuth Key arquivamento de e-mail. Usado para acessar ainstância com o propósito de importação de e-mails.',
  'LBL_SNIP_STATUS' => 'Status',
  'LBL_SNIP_STATUS_PINGBACK_FAIL' => 'Pingback failed',
  'LBL_SNIP_SUMMARY' => 'Email Archiving é um serviço de importação automática que permite aos usuários importar e-mails no SugarCRM, enviando-os a partir de qualquer cliente de email ou serviço de endereço de email. Cada instância do SugarCRM tem seu próprio e-mail exclusivo. Para importar e-mails, o usuário envia para o endereço de email fornecido usando o TO, CC, campos de BCC. O serviço Email Archiving  importa o e-mail para a instância do SugarCRM. Os serviços  importam e-mail, anexos, imagens e eventos de calendário, e cria registros dentro do aplicativo que estão associados com os registros existentes com base nos endereços de e-mail das correspondências<br /><br />Exemplo: Como um usuário, quando vejo uma conta, vou ser capaz de ver todos os e-mails que estão associados com a conta com base no endereço de e-mail no registro da conta. Eu também serei capaz de ver e-mails que estão associados a contatos relacionados com a conta.<br /><br />Aceite os termos abaixo e clique em Ativar para começar a usar o serviço. Você será capaz de desabilitar o serviço a qualquer momento. Quando o serviço estiver ativado, o endereço de email para usar o serviço será exibido.',
  'LBL_REGISTER_SNIP_FAIL' => 'falha ao conectar com serviço de arquivamento',
  'LBL_CONFIGURE_SNIP' => 'Arquivamento de Email',
  'LBL_DISABLE_SNIP' => 'Desativar',
  'LBL_SNIP_APPLICATION_UNIQUE_KEY' => 'Aplicar Chave única',
  'LBL_SNIP_USER' => 'Usuário Arquivamento de email',
  'LBL_SNIP_PWD' => 'Senha Arquivamento de email',
  'LBL_SNIP_SUGAR_URL' => 'URL desta Instância SugarCRM',
  'LBL_SNIP_CALLBACK_URL' => 'URL Serviço Arquivamento de Email',
  'LBL_SNIP_USER_DESC' => 'Usuário Arquivamento de email',
  'LBL_SNIP_STATUS_OK' => 'Ativado',
  'LBL_SNIP_STATUS_OK_SUMMARY' => 'Essa instância SugarCRM está conectada com êxito ao servidor de e-mail Archiving.',
  'LBL_SNIP_STATUS_ERROR' => 'Erro:',
  'LBL_SNIP_STATUS_ERROR_SUMMARY' => 'Essa instância tem um válida licença de servidor do e-mail Arquivamento , mas o servidor retornou a seguinte mensagem:',
  'LBL_SNIP_STATUS_FAIL' => 'Impossibilitado de registrar Email Archiving server',
  'LBL_SNIP_STATUS_FAIL_SUMMARY' => 'O serviço de Email Archiving  está indisponível no momento. Ou o serviço é baixo ou a ligação a essa instância Sugar falhou.',
  'LBL_SNIP_GENERIC_ERROR' => 'O serviço de Email Archiving  está indisponível no momento. Ou o serviço é baixo ou a ligação a essa instância Sugar falhou.',
  'LBL_SNIP_STATUS_RESET' => 'Fora do ar ainda',
  'LBL_SNIP_STATUS_PROBLEM' => 'Problema: %s',
  'LBL_SNIP_NEVER' => 'Nunca',
  'LBL_SNIP_STATUS_SUMMARY' => 'Status do Serviço de Email Archiving',
  'LBL_SNIP_ACCOUNT' => 'Conta',
  'LBL_SNIP_LAST_SUCCESS' => 'Último Registro',
  'LBL_SNIP_DESCRIPTION' => 'Serviço de e-mail Archiving é um sistema de arquivamento automático de e-mail',
  'LBL_SNIP_DESCRIPTION_SUMMARY' => 'Ele permite que você veja e-mails que foram enviados para ou a partir de seus contatos dentro SugarCRM, sem você ter que importar manualmente os e-mails',
  'LBL_SNIP_PURCHASE_SUMMARY' => 'Para usar Email Archiving, você deve adquirir uma licença para sua instância SugarCRM',
  'LBL_SNIP_PURCHASE' => 'Clique aqui para comprar',
  'LBL_SNIP_EMAIL' => 'Email Archiving: Endereço',
  'LBL_SNIP_AGREE' => 'Eu concordo com os termos acima e o contrato de privacidade.',
  'LBL_SNIP_PRIVACY' => 'contrato de privacidade.',
  'LBL_SNIP_STATUS_PINGBACK_FAIL_SUMMARY' => 'O Servidor do Email Archiving está impossibilitado de estabelecer uma conexão com a instância SugarCRM. Por favor, tente novamente ou contate o suporte ao cliente.',
  'LBL_SNIP_BUTTON_ENABLE' => 'Habilitar Email Archiving',
  'LBL_SNIP_BUTTON_DISABLE' => 'Desativar Email Archiving',
  'LBL_SNIP_BUTTON_RETRY' => 'Tente conectar outra vez',
  'LBL_SNIP_ERROR_DISABLING' => 'Ocorreu um erro durante a tentativa de comunicar com o servidor de E-mail Archiving, e o serviço não pode ser desativado',
  'LBL_SNIP_ERROR_ENABLING' => 'Ocorreu um erro durante a tentativa de comunicar com o servidor de E-mail Archiving, e o serviço não poderia ser ativado',
  'LBL_CONTACT_SUPPORT' => 'Favor tentar novamente ou contate o Suporte SugarCRM',
  'LBL_SNIP_SUPPORT' => 'Favor contatar Suporte SugarCRM para assistência',
  'ERROR_BAD_RESULT' => 'resultado ruim retornado do serviço',
  'ERROR_NO_CURL' => 'Extensão URL é requerida, mas não estão habilitadas',
  'ERROR_REQUEST_FAILED' => 'Não foi possível contatar o servidor',
  'LBL_CANCEL_BUTTON_TITLE' => 'Cancelar',
  'LBL_SNIP_MOUSEOVER_STATUS' => 'Este é o status do serviço Email Archiving na sua instância. O status reflete se a conexão entre o servidor de Email Archiving e sua instância do SugarCRM está bem sucedida.',
  'LBL_SNIP_MOUSEOVER_EMAIL' => 'Este é o endereço de email Email Archiving para enviar ao fim de importação de e-mails no SugarCRM',
  'LBL_SNIP_MOUSEOVER_SERVICE_URL' => 'Esta é a URL do servidor de e-mail Archiving. Todos os pedidos, como habilitar e desabilitar o serviço Email Archiving, será retransmitida através desta URL',
  'LBL_SNIP_MOUSEOVER_INSTANCE_URL' => 'Estes são os webservices URL da sua instância SugarCRM. O servidor do Email Archiving  irá se conectar ao seu servidor através desta URL',
);

