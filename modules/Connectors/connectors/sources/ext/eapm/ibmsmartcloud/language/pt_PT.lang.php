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

	

$connector_strings = array (
  'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Obter a Chave e o Segredo da  IBM SmartCloud&copy; registando a sua instância Sugar como uma nova aplicação.<br><br />&nbsp;<br><br />Passos para registar a sua instância:<br><br />&nbsp;<br><br /><ol><br /><li>Autenticar-se na sua conta IBM SmartCloud (terá que ser um administrador)</li><br /><li>Ir a Administration -> Manage Organization</li><br /><li>Ir ao link "Integrated Third-Party Apps" na barra lateral e disponibilizar o SugarCRM para todos os utilizadores.</li><br /><li>Ir a "Internal Apps" na barra lateral e "Register App"</li><br /><li>Dê o nome desta aplicação como quiser (por exemplo "SugarCRM – Produção"), e tenha a certeza de NÃO escolher a opção de OAuth 2.x no fim da janela.</li><br /><li>Depois da aplicação estar criada, carregar no pequeno triângulo à direita do nome da aplicação e seleccione "Show Credentials" do menu de selecção.</li><br /><li>Copiar as credenciais abaixo.</li><br /></ol><br /></td></tr></table>',
  'oauth_consumer_key' => 'Chave do Consumidor OAuth',
  'oauth_consumer_secret' => 'Segredo do Consumidor OAuth',
);

