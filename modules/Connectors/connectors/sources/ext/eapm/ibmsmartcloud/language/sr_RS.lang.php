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
  'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel"><br />Preuzmite ključ i tajni ključ sa IBM SmartCloud&copy; tako što ćete registrovati svoju Sugar instancu kao novu aplikaciju.<br><br />&nbsp;<br><br />Koraci za registraciju sopstvene instance:<br><br />&nbsp;<br><br /><ol><br /><li>Prijavite se na svoj IBM SmartCloud nalog (morate biti administrator)</li><br /><li>Idite na to Administration -> Manage Organization</li><br /><li>Idite na "Integrated Third-Party Apps" link sa strane i omogućite SugarCRM za sve korisnike.</li><br /><li>Idite na "Internal Apps" sa strane i kliknite na "Register App"</li><br /><li>Nazovite aplikaciju kako želite (recimo "SugarCRM Produkcija"), i osigurajte da NISTE odabrali OAuth 2.x na dnu iskačućeg prozora.</li><br /><li>Nakon što je aplikacija kreirana, kliknite na mali trougao sa desne strane imena aplikacije i odaberite "Show Credentials" iz padajućeg menija.</li><br /><li>Kopirajte kredencijale ispod.</li><br /></ol><br /></td></tr></table>',
  'oauth_consumer_key' => 'OAuth Potrošački ključ',
  'oauth_consumer_secret' => 'OAuth Potrošačka tajna',
);

