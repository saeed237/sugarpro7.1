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
  'ERROR_BAD_RESULT' => 'Serviss atgrieza kļūdainu rezultātu',
  'ERROR_NO_CURL' => 'Ir nepieciešami cURL paplašinājumi, bet tie nav aktivizēti',
  'ERROR_REQUEST_FAILED' => 'Nevar sazināties ar serveri',
  'LBL_CANCEL_BUTTON_TITLE' => 'Atcelt',
  'LBL_CONFIGURE_SNIP' => 'E-pasta arhivēšana',
  'LBL_CONTACT_SUPPORT' => 'Lūdzu mēģiniet vēl, vai sazinies ar SugarCRM atbalstu.',
  'LBL_DISABLE_SNIP' => 'Deaktivizēt',
  'LBL_REGISTER_SNIP_FAIL' => 'Neizdevās sazināties ar e-pasta arhivēšanas servisu: %s!<br>',
  'LBL_SNIP_ACCOUNT' => 'Uzņēmums',
  'LBL_SNIP_AGREE' => 'Es piekrītu iepriekš minētajiem noteikumiem un   <a href="http://www.sugarcrm.com/crm/TRUSTe/privacy.html" target="_blank">privātuma līgumam</a>.',
  'LBL_SNIP_APPLICATION_UNIQUE_KEY' => 'Lietojumprogrammas unikālā atslēga',
  'LBL_SNIP_BUTTON_DISABLE' => 'Deaktivizēt e-pasta arhivēšanu',
  'LBL_SNIP_BUTTON_ENABLE' => 'Aktivizēt e-pasta arhivēšanu',
  'LBL_SNIP_BUTTON_RETRY' => 'Mēģiniet savienoties atkārtoti',
  'LBL_SNIP_CALLBACK_URL' => 'E-pasta arhivēšanas servisa URL',
  'LBL_SNIP_DESCRIPTION' => 'E-pasta arhivēšanas serviss ir automātiska e-pasta arhivēšanas sistēma',
  'LBL_SNIP_DESCRIPTION_SUMMARY' => 'Tas ļauj aplūkot e-pastus, kuri ir nosūtīti vai saņemti no SugarCRM kontaktiem, bez nepieciešamības  manuāli importēt un sasaistīt e-pastus',
  'LBL_SNIP_EMAIL' => 'E-pasta arhivēšanas adrese',
  'LBL_SNIP_ERROR_DISABLING' => 'Mēģinot komunicēt ar e-pasta arhivēšanas serveri, notika kļūda un servisu nevar deaktivizēt.',
  'LBL_SNIP_ERROR_ENABLING' => 'Mēģinot komunicēt ar e-pasta arhivēšanas serveri, notika kļūda un servisu nevar deaktivizēt..',
  'LBL_SNIP_GENERIC_ERROR' => 'E-pasta arhivēšanas serviss pašreiz nav pieejams. Serviss nestrādā vai nav savienojuma ar šo Sugar instanci.',
  'LBL_SNIP_KEY_DESC' => 'E-pasta arhivēšanas OAuth atslēga. Šo atslēgu izmanto, lai piekļūtu šai instancei nolūkā importēt e-pastus.',
  'LBL_SNIP_LAST_SUCCESS' => 'Pēdējā veiksmīgā izpilde',
  'LBL_SNIP_MOUSEOVER_EMAIL' => 'Šī ir e-pasta arhivatora e-pasta adrese, ko izmanto e-pastu importēšanai Sugar lietojumā.',
  'LBL_SNIP_MOUSEOVER_INSTANCE_URL' => 'Šis ir Jūsu Sugar instances web servisu URL. E-pasta arhivēšanas serveris pieslēgsies Jūsu serverim, izmantojot šo URL.',
  'LBL_SNIP_MOUSEOVER_SERVICE_URL' => 'Šis ir e-pasta arhivēšanas servera URL. Visi pieprasījumi, tādi kā e-pasta arhivēšanas servisa aktivizēšana un deaktivizēšana, tiks pārraidīti, izmantojot šo URL.',
  'LBL_SNIP_MOUSEOVER_STATUS' => 'Šis ir jūsu instances e-pasta arhivēšanas servisa statuss. Statuss atspoguļo, vai savienojums starp e-pasta arhivēšanas servisu un Jūsu Sugar instanci ir veiksmīgs.',
  'LBL_SNIP_NEVER' => 'Nekad',
  'LBL_SNIP_PRIVACY' => 'privātuma līgums',
  'LBL_SNIP_PURCHASE' => 'Klikšķini šeit, lai iegādātos',
  'LBL_SNIP_PURCHASE_SUMMARY' => 'Lai lietotu E-pasta arhivatoru, jāiegādājas licence Jūsu SugarCRM instancei.',
  'LBL_SNIP_PWD' => 'E-pasta arhivēšanas parole',
  'LBL_SNIP_STATUS' => 'Statuss',
  'LBL_SNIP_STATUS_ERROR' => 'Kļūda',
  'LBL_SNIP_STATUS_ERROR_SUMMARY' => 'Šai instancei ir derīga e-pasta arhivēšanas servera licence, bet serveris atgrieza sekojošu kļūdas paziņojumu:',
  'LBL_SNIP_STATUS_FAIL' => 'Nav iespējams reģistrēties e-pasta arhivēšanas serverī',
  'LBL_SNIP_STATUS_FAIL_SUMMARY' => 'E-pasta arhivēšanas serviss pašreiz nav pieejams. Serviss nestrādā, vai savienojums ar šo Sugar instanci ir neveiksmīgs.',
  'LBL_SNIP_STATUS_OK' => 'Aktivizēts',
  'LBL_SNIP_STATUS_OK_SUMMARY' => 'Šī Sugar instance ir veiksmīgi savienota ar E-pasta arhivēšanas serveri.',
  'LBL_SNIP_STATUS_PINGBACK_FAIL' => 'Atpakaļ pingošana neizdevās',
  'LBL_SNIP_STATUS_PINGBACK_FAIL_SUMMARY' => 'E-pasta arhivēšanas serveris nevar izveidot savienojumu ar jūsu Sugar instanci. Lūdzu mēģiniet vēl, vai <a href="http://www.sugarcrm.com/crm/case-tracker/submit.html?lsd=supportportal&tmpl=" target="_blank">sazinieties ar klientu palīdzības dienestu</a>.',
  'LBL_SNIP_STATUS_PROBLEM' => 'Problēma: %s',
  'LBL_SNIP_STATUS_RESET' => 'Vēl nav darbināts',
  'LBL_SNIP_STATUS_SUMMARY' => 'E-pasta arhivēšanas servisa statuss:',
  'LBL_SNIP_SUGAR_URL' => 'Šīs Sugar instances URL',
  'LBL_SNIP_SUMMARY' => 'E-pasta arhivēšana ir automātisks importēšanas serviss, kurš ļauj lietotājiem importēt e-pastus Sugar lietojumā, nosūtot tos no jebkura e-pasta klienta vai servisa uz Sugar paredzēto e-pasta adresi. Katrai Sugar instancei ir sava unikāla e-pasta adrese. Lai importētu e-pastus, lietotājs tos nosūta uz paredzēto e-pasta adresi, lietojot laukus - Kam, CC,BCC. E-pasta arhivēšanas serviss importēs e-pastus Sugar instancē. Serviss importēs e-pastu kopā ar jebkādiem pielikumiem, attēliem un kalendāra notikumiem un izveidos ierakstus lietojumprogrammā, kuri ir saistīti ar esošajiem ierakstiem, balstoties uz sakrītošām e-pasta adresēm. <br />    <br><br>Piemērs: Aplūkojot uzņēmumu,  lietotājs var redzēt e-pastus, kuri ir saistīti    ar uzņēmumu, balstoties uz e-pasta adresi Uzņēmuma ierakstā.<br />    <br><br>Akceptējiet zemāk esošos nosacījumus un klikšķiniet Aktivizēt, lai sāktu lietot šo servisu. Jūs varēsiet deaktivizēt šo servisu jebkurā laikā. Pēc aktivizēšanas tiks parādīta e-pasta adrese, kuru izmantot šim servisam.<br />    <br><br>',
  'LBL_SNIP_SUPPORT' => 'Palīdzības saņemšanai lūdzu sazinieties ar SugarCRM palīdzības dienestu.',
  'LBL_SNIP_USER' => 'E-pasta arhivēšanas lietotājs',
  'LBL_SNIP_USER_DESC' => 'E-pasta arhivēšanas lietotājs',
);

