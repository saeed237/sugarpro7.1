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
  'company_url' => 'URL',
  'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Nabavite potrošački ljuč i tajnu sa Twitter&#169; registrovanjem vaše Sugar instance kao nove aplikacije.<br/><br>Koraci za registraciju Vaše instance:<br/><br/><ol><li>Idite na Twitter&#169; razvojni sajt: <a href="http://dev.twitter.com/apps/new" target="_blank">http://dev.twitter.com/apps/new</a>.</li><li>Prijavite se koristeći Twitter nalog sa kojim želite da registrujete aplikaciju.</li><li>U formi za registraciju, unesite naziv za aplikaciju. Ovo je naziv koji će korisnici videti kada potvrde svoje Twitter naloge u Sugar-u.</li><li>Unesite opis</li><li>Unesite web sajt URL aplikacije (može biti bilo šta).</li><li>Odaberite "Browser" za tip aplikacije.</li><li>Nakon selektovanja "Browser" za tip aplikacije, unesite Callback URL (može biti bilo šta jer Sugar zaobilazi ovo pri autentifikaciji. Na primer: Unesite svoju URL adresu Sugar-a).</li><li>Unesite sigurnosne reči.</li><li>Klinite na "Register application".</li><li>Prihvatite Twitter API Terms of Service.</li><li>u okviru strane aplikacije pronađite potrošački ključ i tajnu. Unesite ključ i tajnu ispod.</li></ol></td></tr></table>',
  'LBL_NAME' => 'Twitter korisničko ime',
  'LBL_ID' => 'Twitter korisničko ime',
  'oauth_consumer_key' => 'Potrošački ključ',
  'oauth_consumer_secret' => 'Potrošačka tajna',
);

