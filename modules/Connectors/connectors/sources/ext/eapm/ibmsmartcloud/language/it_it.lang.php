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
  
  'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Ottieni la Key e Secret da SmartCloud© di IBM registrando la tua istanza Sugar come nuova applicazione.<br>
&nbsp;<br>
Steps per registrare la tua istanza: <br>
&nbsp;<br>
<ol>
<li>Accedi al tuo account SmartCloud di IBM (devi essere un amministrazione)</li>
<li>Vai nel pannello di Amministrazione -> Gestione Organizzazione</li>
<li>Vai sul link "Apps di terze parti integrate" sulla barra laterale e attivare SugarCRM per tutti gli utenti.</li>
<li>Vai su "Apps Interne" sulla barra laterale e "Registra App"</li>
<li>Nomina questa app come desideri (ad esempio "Produzione SugarCRM"), e assicurati _NOT_ di controllare la casella di controllo OAuth 2.x nella parte inferiore della finestra pop-up.</li>
<li>Dopo che la app è stata creata, clicca sul triangolino alla destra del nome della app e seleziona "Mostra Credenziali" dal menu dropdown.</li>
<li>Copia le credenziali di seguito</li>
</ol>
</td></tr></table>',
    'oauth_consumer_key' => 'OAuth Consumer Key',
    'oauth_consumer_secret' => 'OAuth Consumer Secret',
);
  
