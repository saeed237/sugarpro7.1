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
  'ERROR_BAD_RESULT' => '"Noe galt har skjedd", melder tjenesten...',
  'ERROR_NO_CURL' => 'cURL -utvidelser er nødvendige, men har ikke blitt aktivert',
  'ERROR_REQUEST_FAILED' => 'Fikk ikke kontakt med tjeneren',
  'LBL_CANCEL_BUTTON_TITLE' => 'Avbryt',
  'LBL_CONFIGURE_SNIP' => 'Epost-arkivering',
  'LBL_CONTACT_SUPPORT' => 'Vennligst forsøk på nytt eller kontakt SugarCRM Support.',
  'LBL_DISABLE_SNIP' => 'Avslutt',
  'LBL_REGISTER_SNIP_FAIL' => 'Mislyktes med å kontakte Epost-arkiveringstjenesten: %s!',
  'LBL_SNIP_ACCOUNT' => 'Konto',
  'LBL_SNIP_AGREE' => 'Jeg samtykker til vilkårene over og personvernavtalen.',
  'LBL_SNIP_APPLICATION_UNIQUE_KEY' => 'Unik Nøkkel for Applikasjonen',
  'LBL_SNIP_BUTTON_DISABLE' => 'Deaktivér Epost-Arkivering',
  'LBL_SNIP_BUTTON_ENABLE' => 'Aktivér Epost-Arkivering',
  'LBL_SNIP_BUTTON_RETRY' => 'Forsøk å koble til på nytt',
  'LBL_SNIP_CALLBACK_URL' => 'Epost-arkiveringstjenestens URL',
  'LBL_SNIP_DESCRIPTION' => 'Epost-arkiveringstjenesten er et automatisk epostarkiveringssystem',
  'LBL_SNIP_DESCRIPTION_SUMMARY' => 'Det lar deg se eposter som har blitt sendt til eller fra dine kontakter, i SugarCRM, uten at du behøver å manuelt importere og assosiere epostene.',
  'LBL_SNIP_EMAIL' => 'Epost-arkiveringsadresse',
  'LBL_SNIP_ERROR_DISABLING' => 'En feil oppstod under kommunikasjonen med Epost-Arkiveringstjeneren, og denne tjenesten kunne ikke deaktiveres.',
  'LBL_SNIP_ERROR_ENABLING' => 'En feil oppstod under kommunikasjonen med Epost-Arkiveringstjeneren, og denne tjenesten kunne ikke aktiveres.',
  'LBL_SNIP_GENERIC_ERROR' => 'Epost-arkiveringstjenesten er for øyeblikket utilgjengelig. Enten er tjenesten nede eller koblingen til denne Sugar-instansen feilet.',
  'LBL_SNIP_KEY_DESC' => 'Epost-arkivering oAuth-nøkkel. Brukes for å aksessere denne instansen for å importere epost.',
  'LBL_SNIP_LAST_SUCCESS' => 'Siste vellykkede kjøring',
  'LBL_SNIP_MOUSEOVER_EMAIL' => 'Dette er Epost-Arkiveringsepostadressen du må benytte for å importere eposter inn i Sugar.',
  'LBL_SNIP_MOUSEOVER_INSTANCE_URL' => 'Dette er webservices-URL&#39;-en for din Sugar-installasjon. Epost-Arkiveringstjeneren vil koble seg mot din tjener via denne URL-en.',
  'LBL_SNIP_MOUSEOVER_SERVICE_URL' => 'Dette er URL-adressen til Epost-Arkiveringstjeneren. Alle henvendelser, så som aktivering og deaktivering av Epost-Arkiveringstjenesten, må rutes gjennom denne URL-en.',
  'LBL_SNIP_MOUSEOVER_STATUS' => 'Dette er statusen for Epost-Arkiveringstjenesten på din installasjon. Statusen viser hvorvidt koblingen mellom Epost-Arkivering og din Sugar-installasjon er vellykket.',
  'LBL_SNIP_NEVER' => 'Aldri',
  'LBL_SNIP_PRIVACY' => 'personvernavtale',
  'LBL_SNIP_PURCHASE' => 'Klikk her for å kjøpe',
  'LBL_SNIP_PURCHASE_SUMMARY' => 'For å kunne benytte Epost-arkivering må du kjøpe en lisens for din SugarCRM-instans',
  'LBL_SNIP_PWD' => 'Epost-arkiveringspassord',
  'LBL_SNIP_STATUS' => 'Status',
  'LBL_SNIP_STATUS_ERROR' => 'Feil',
  'LBL_SNIP_STATUS_ERROR_SUMMARY' => 'Denne instansen har en gyldig Epost-arkiveringstjenerlisens, men tjeneren ga følgende feilmelding:',
  'LBL_SNIP_STATUS_FAIL' => 'Kan ikke registrere mot Epost-arkiveringsserveren',
  'LBL_SNIP_STATUS_FAIL_SUMMARY' => 'Epost-arkiveringstjenesten er for øyeblikket utilgjengelig. Enten er tjenesten nede eller koblingen til denne Sugar-instansen feilet.',
  'LBL_SNIP_STATUS_OK' => 'Aktivert',
  'LBL_SNIP_STATUS_OK_SUMMARY' => 'Denne Sugar-instansen er nå koblet til Epost-arkiveringstjeneren.',
  'LBL_SNIP_STATUS_PINGBACK_FAIL' => 'Pingback feilet',
  'LBL_SNIP_STATUS_PINGBACK_FAIL_SUMMARY' => 'Epost-Arkiveringstjeneren mislyktes i å etablere kontakt med din Sugar-installasjon. Vennligst forsøk på nytt eller <a href="http://www.sugarcrm.com/crm/case-tracker/submit.html?lsd=supportportal&tmpl=" target="_blank">kontakt Kundeservice</a>.',
  'LBL_SNIP_STATUS_PROBLEM' => 'Problem: %s',
  'LBL_SNIP_STATUS_RESET' => 'Ikke kjørt ennå',
  'LBL_SNIP_STATUS_SUMMARY' => 'Epost-arkiveringstjeneste status:',
  'LBL_SNIP_SUGAR_URL' => 'Denne Sugar-installasjonens URL',
  'LBL_SNIP_SUMMARY' => 'Epost-arkivering er en automatisk import-tjeneste som åpner for at brukere kan importere epost inn i Sugar ved å sende disse fra hvilken som helst epost-klient eller -tjeneste til en Sugar-opprettet epostadresse. Hver Sugar-instanse har sin egen unike epostadresse. For å importere epost, så sender brukeren eposten til den unike adressen ved å bruke Til:, CC: eller BCC:-feltet. Epost-arkiveringsfunksjonen vil da importere eposten inn i Sugar. Tjenesten importerer eposten, sammen med eventuelle vedlegg, bilder eller kalenderhendelser, og skaper oppføringer i applikasjonen som er assosiert med eksisterende data basert på matchende epostadresser.<br /><br />Eksempel: Jeg som bruker, når jeg ser på en Konto, vil kunne se alle eposter som er assosiert med Kontoen basert på den tilhørende epostkontoen. Jeg vil også kunne se eposter assosiert med Kontakter relatert til Kontoen.<br /><br />Akseptér vilkårene under og klikk Aktivér for å begynne å bruke tjenesten. Du kan avslutte tjenesten når som helst. Straks tjenesten har startet, vil epostadressen for bruk av tjenesten vises.',
  'LBL_SNIP_SUPPORT' => 'Vennligst be om assistanse fra SugarCRM Support.',
  'LBL_SNIP_USER' => 'Epost-arkiveringsbruker',
  'LBL_SNIP_USER_DESC' => 'Epost-arkiveringsbruker',
);

