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
  'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Les "OAuth Consumer Key" et "OAuth Consumer Secret" sont les paramètres que vous obtenez depuis IBM SmartCloud&copy; lorsque vous créez une nouvelle application.<br><br />&nbsp;<br><br />Voici les étapes pour enregistrer votre instance:<br><br />&nbsp;<br><br /><ol><br /><li>Identifiez vous sur votre compte IBM SmartCloud (vous devez être administrateur)</li><br /><li>Allez sur la section Administration -> Manage Organization</li><br /><li>Cliquez sur le lien "Integrated Third-Party Apps" sur le menu de côté et activez SugarCRM pour tous les utilisateurs.</li><br /><li>Allez sur "Internal Apps" sur le menu de côté puis "Register App"</li><br /><li>Donnez un nom à cette application (ex: "SugarCRM"), et soyez s^^ure de ne pas cocher la case "OAuth 2.x" en bas de la popup.</li><br /><li>Après que l&#39;app ait été créée, cliquez sur le petit triangle à droite du nom de l&#39;app et choisissez "Show Credentials" dans le menu déroulant.</li><br /><li>Copiez les identifiants ci-dessous.</li><br /></ol><br /></td></tr></table>',
  'oauth_consumer_key' => 'OAuth Consumer Key',
  'oauth_consumer_secret' => 'OAuth Consumer Secret',
);

