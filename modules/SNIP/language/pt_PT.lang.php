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
  'LBL_SNIP_KEY_DESC' => 'Email de Arquivo da chave OAuth. Usado para aceder a esta instância para fins de importação de emails.',
  'LBL_SNIP_SUMMARY' => 'Sugar EASe é um serviço automático de importação de emails que permite aos utilizadores importar emails para o Sugar enviando-os de qualquer cliente ou serviço de mail para um endereço de email fornecido pelo Sugar. Casa instância do Sugar tem uma caixa de correio Sugar EASe única. Para importar emails, um utilizador envia para o endereço de email do Sugar EASe utilizando os campos Para, CC ou BCC. O serviço Sugar EASe irá importar o email para a instância do Sugar. O serviço importa o email, juntamente com qualquer anexos, imagens e eventos de Calendário, e cria registos dentro da aplicação que estão associados com registos já existentes, baseando-se em endereços de email correspondentes.<br />    <br><br>Exemplo: Como um utilizador, quando vejo uma Conta, poderei ver todos os emails que estão associados com a Conta, baseando-se no endereço de email do registo da Conta. Poderei também ver emails que estão associados com Contactos relacionados com a Conta.<br />    <br><br>Aceite os termos em baixo e carregue Habilitar para começar a usar o serviço. Poderá desabilitar o serviço a qualquer altura. Quando o serviço estiver habilitar, será mostrado o endereço de email a usar com o serviço.<br />    <br><br>',
  'LBL_REGISTER_SNIP_FAIL' => 'Falha ao contactar o serviço Sugar EASe: %s!',
  'LBL_CONFIGURE_SNIP' => 'Sugar EASe',
  'LBL_DISABLE_SNIP' => 'Desactivar',
  'LBL_SNIP_APPLICATION_UNIQUE_KEY' => 'Chave Única da Aplicação',
  'LBL_SNIP_USER' => 'Utilizador do Sugar EASe',
  'LBL_SNIP_PWD' => 'Palavra-chave do Sugar EASe',
  'LBL_SNIP_SUGAR_URL' => 'O URL desta instância Sugar',
  'LBL_SNIP_CALLBACK_URL' => 'URL do serviço Sugar EASe',
  'LBL_SNIP_USER_DESC' => 'Utilizador de arquivamento Sugar EASe',
  'LBL_SNIP_STATUS_OK' => 'Activo',
  'LBL_SNIP_STATUS_OK_SUMMARY' => 'Esta instância do Sugar foi ligada com sucesso ao servidor Sugar EASe.',
  'LBL_SNIP_STATUS_ERROR' => 'Erro',
  'LBL_SNIP_STATUS_ERROR_SUMMARY' => 'Esta instância tem uma licença válida do Sugar EASe, mas o servidor devolveu a seguinte mensagem de erro:',
  'LBL_SNIP_STATUS_FAIL' => 'Não é possível registar no servidor Sugar EASe',
  'LBL_SNIP_STATUS_FAIL_SUMMARY' => 'O Serviço Sugar EASe está actualmente indisponível. Ou o serviço está em baixo ou a ligação para esta instância de Sugar falhou.',
  'LBL_SNIP_GENERIC_ERROR' => 'O Serviço Sugar EASe está actualmente indisponível. Ou o serviço está em baixo ou a ligação para esta instância de Sugar falhou.',
  'LBL_SNIP_STATUS_RESET' => 'Ainda não correu',
  'LBL_SNIP_STATUS_PROBLEM' => 'Problema: %s',
  'LBL_SNIP_NEVER' => 'Nunca',
  'LBL_SNIP_STATUS_SUMMARY' => 'Estado de arquivamento Sugar EASe',
  'LBL_SNIP_ACCOUNT' => 'Conta',
  'LBL_SNIP_STATUS' => 'Estado',
  'LBL_SNIP_LAST_SUCCESS' => 'Ultima operação com sucesso',
  'LBL_SNIP_DESCRIPTION' => 'O Sugar EASe é um sistema de arquivamento de emails automático',
  'LBL_SNIP_DESCRIPTION_SUMMARY' => 'Permite-lhe ver emails que foram enviados de ou para os seus contactos dentro do SugarCRM, sem ter que importar manualmente e ligar os emails',
  'LBL_SNIP_PURCHASE_SUMMARY' => 'De forma a usar o Sugar EASe, terá que comprar a licença para a sua instância SugarCRM',
  'LBL_SNIP_PURCHASE' => 'Carregue aqui para comprar',
  'LBL_SNIP_EMAIL' => 'Email do Sugar EASe',
  'LBL_SNIP_AGREE' => 'Concordo com os termos acima e o <a href="http://www.sugarcrm.com/crm/TRUSTe/privacy.html" target="_blank">acordo de privacidade</a>.',
  'LBL_SNIP_PRIVACY' => 'acordo de privacidade',
  'LBL_SNIP_STATUS_PINGBACK_FAIL' => 'Falhou o pingback',
  'LBL_SNIP_STATUS_PINGBACK_FAIL_SUMMARY' => 'O servidor Sugar EASe é incapaz de estabelecer a ligação com a sua instância Sugar. Por favor tentar de novo ou <a href="http://www.sugarcrm.com/crm/case-tracker/submit.html?lsd=supportportal&tmpl=" target="_blank">contacte com o suporte ao cliente</a>.',
  'LBL_SNIP_BUTTON_ENABLE' => 'Habilitar o Sugar EASe',
  'LBL_SNIP_BUTTON_DISABLE' => 'Desabilitar o Sugar EASe',
  'LBL_SNIP_BUTTON_RETRY' => 'Tentar a Ligação Novamente',
  'LBL_SNIP_ERROR_DISABLING' => 'Erro - O Servidor Sugar EASe não pode ser contactado, portanto o serviço não foi desabilitado',
  'LBL_SNIP_ERROR_ENABLING' => 'Erro - O Servidor Sugar EASe não pode ser contactado, portanto o serviço não foi habilitado',
  'LBL_CONTACT_SUPPORT' => 'Por favor tente novamente ou contacte o suporte ao cliente',
  'LBL_SNIP_SUPPORT' => 'Contacte o Suporte para assistência.',
  'ERROR_BAD_RESULT' => 'Mão resultado devolvido pelo serviço',
  'ERROR_NO_CURL' => 'A extensão cURL é necessária',
  'ERROR_REQUEST_FAILED' => 'Não foi possível contactar o servidor',
  'LBL_CANCEL_BUTTON_TITLE' => 'Cancelar',
  'LBL_SNIP_MOUSEOVER_STATUS' => 'Este é o estado do serviço Sugar EASe na sua instância. O estado reflecte se a comunicação entre o Servidor Sugar EASe e a sua instância Sugar é bem sucedida.',
  'LBL_SNIP_MOUSEOVER_EMAIL' => 'Este é o endereço de email do Sugar EASe a enviar para, de modo a importar emails para o Sugar.',
  'LBL_SNIP_MOUSEOVER_SERVICE_URL' => 'Este é o URL do Servidor Sugar EASe. Todos os pedidos, como habilitar e desabilitar o serviço Sugar EASe, serão enviados através deste URL.',
  'LBL_SNIP_MOUSEOVER_INSTANCE_URL' => 'Este é o URL de webservices da sua instância Sugar. O Servidor Sugar EASe irá ligar-se ao seu servidor através deste URL.',
);

