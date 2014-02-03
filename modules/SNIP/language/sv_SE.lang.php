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
  'ERROR_BAD_RESULT' => 'Ogiltigt resultat togs emot från servicen',
  'ERROR_NO_CURL' => 'cURL extensions begärs, men har inte aktiverats',
  'ERROR_REQUEST_FAILED' => 'Kunde inte kontakta servern',
  'LBL_CANCEL_BUTTON_TITLE' => 'Avbryt',
  'LBL_CONFIGURE_SNIP' => 'Email Arkivering',
  'LBL_CONTACT_SUPPORT' => 'Vänligen försök igen eller kontakta SugarCRM Support',
  'LBL_DISABLE_SNIP' => 'Inaktivera',
  'LBL_REGISTER_SNIP_FAIL' => 'Misslyckades att ansluta Epost Arkiverings service: %s!',
  'LBL_SNIP_ACCOUNT' => 'Konto',
  'LBL_SNIP_AGREE' => 'Jag accepterar ovanstående villkor och the <a href=&#39;http://www.sugarcrm.com/crm/TRUSTe/privacy.html&#39; target=&#39;_blank&#39;>privacy agreement</a>.',
  'LBL_SNIP_APPLICATION_UNIQUE_KEY' => 'Applikation Unik Nyckel',
  'LBL_SNIP_BUTTON_DISABLE' => 'Avaktivera Epost Arkivering',
  'LBL_SNIP_BUTTON_ENABLE' => 'Aktivera Epost Arkivering',
  'LBL_SNIP_BUTTON_RETRY' => 'Försök Ansluta Igen',
  'LBL_SNIP_CALLBACK_URL' => 'Epost Arkiverings service URL',
  'LBL_SNIP_DESCRIPTION' => 'Epost Arkiverings service är ett automatiskt epost arkiverings system',
  'LBL_SNIP_DESCRIPTION_SUMMARY' => 'Det ger dig möjlighet att se epost som skickats till eller från dina kontakter inom SugarCRM, utan att du behöver manuellt importera eller länka epost',
  'LBL_SNIP_EMAIL' => 'Eposta Arkiverings Adress',
  'LBL_SNIP_ERROR_DISABLING' => 'Ett fel uppstod under försöket att kommunicera med Epost Arkivering server, och servicen kunde inte avaktiveras.',
  'LBL_SNIP_ERROR_ENABLING' => 'Ett fel uppstod under försöket att kommunicera med Epost Arkivering server, och servicen kunde inte aktiveras.',
  'LBL_SNIP_GENERIC_ERROR' => 'Epost Arkiverings servicEpost Arkivering service är för tillfället otillgänglig. Antingen är servicen nere eller så misslyckades anslutningen till Sugar instansen.',
  'LBL_SNIP_KEY_DESC' => 'Epost Arkivering OAuth nyckel. Används för åtkomst till den här instansen för att importera epist',
  'LBL_SNIP_LAST_SUCCESS' => 'Senaste lyckade körningen',
  'LBL_SNIP_MOUSEOVER_EMAIL' => 'Det här är Epost Arkiveringens epostadress att skicka till för att importera epost in till Sugar',
  'LBL_SNIP_MOUSEOVER_INSTANCE_URL' => 'Det här webservices URL för din Sugar instans. Epost Arkivering servern kommer ansluta till din server genom den här URLen.',
  'LBL_SNIP_MOUSEOVER_SERVICE_URL' => 'Det här är URL av Epost Arkivering servern. Alla begäran, som aktivering och avaktivering av Epost Arkivering servicen, kommer att förmedlas genom den här URLen.',
  'LBL_SNIP_MOUSEOVER_STATUS' => 'Det här är statusen av Epost Arkiverings servicen i din instans. Statusen reflekterar om anslutningen mellan Epost Arkiveringen och din Sugar instans lyckades.',
  'LBL_SNIP_NEVER' => 'Aldrig',
  'LBL_SNIP_PRIVACY' => 'privacy agreement',
  'LBL_SNIP_PURCHASE' => 'Klicka här för att köpa',
  'LBL_SNIP_PURCHASE_SUMMARY' => 'För att använda Epost, måste du köpa en licens för din SugarCRM instans',
  'LBL_SNIP_PWD' => 'Eposta Arkiverings Lösenord',
  'LBL_SNIP_STATUS' => 'Status',
  'LBL_SNIP_STATUS_ERROR' => 'Fel',
  'LBL_SNIP_STATUS_ERROR_SUMMARY' => 'Den här instansen har giltig Epost Arkivering service licens, men servern returnerar följande felmeddelande:',
  'LBL_SNIP_STATUS_FAIL' => 'Kan inte registrera med Epost Arkiverings Server',
  'LBL_SNIP_STATUS_FAIL_SUMMARY' => 'Epost Arkivering service är för tillfället otillgänglig. Antingen är servicen nere eller så misslyckades anslutningen till Sugar instansen.',
  'LBL_SNIP_STATUS_OK' => 'Aktivera',
  'LBL_SNIP_STATUS_OK_SUMMARY' => 'Den här Sugar instansen lyckades ansluta till Epost Arkiverings server.',
  'LBL_SNIP_STATUS_PINGBACK_FAIL' => 'Pingback failed',
  'LBL_SNIP_STATUS_PINGBACK_FAIL_SUMMARY' => 'Epost Arkiverings service kan inte skapa anslutning till din Sugar instans. Vänligen försök igen eller  <a href="http://www.sugarcrm.com/crm/case-tracker/submit.html?lsd=supportportal&tmpl=" target="_blank">kontakta användasupport</a>.',
  'LBL_SNIP_STATUS_PROBLEM' => 'Problem: %s',
  'LBL_SNIP_STATUS_RESET' => 'Inte körd än',
  'LBL_SNIP_STATUS_SUMMARY' => 'Epost Arkiverings service status:',
  'LBL_SNIP_SUGAR_URL' => 'Den här Sugarinstansens URL',
  'LBL_SNIP_SUMMARY' => 'E-postarkivering är en automatisk importerande tjänst som tillåter användare att importera e-post till Sugar genom att skicka dem från alla e-postklient eller tjänst till en Sugar-tillhandahållen e-postadress. Varje Sugar instans har sin egen unika e-postadress. Om du vill importera e-post, skickar en användare till den angivna e-postadressen med hjälp av Till, Kopia, BCC fält. Den e-postarkivering tjänsten kommer importera e-post till Sugar instans. Tjänsten importerar e-post, tillsammans med eventuella bilagor, bilder och kalenderhändelser och skapar register i applikationen som är associerade med befintliga poster baserade på matchande e-postadresser.<br /><br />Exempel: Som användare, när jag läser ett Konto, kommer jag att kunna se alla e-postmeddelanden som är associerade med kontot baserat på e-postadressen i Konto protkoll. Jag kommer också att kunna se e-postmeddelanden som är förknippade med kontakter i samband med kontot.<br /><br />Acceptera villkoren nedan och klicka på Aktivera för att börja använda tjänsten. Du kommer att kunna inaktivera tjänsten när som helst. När tjänsten är aktiverad, kommer e-postadressen som ska användas för tjänsten visas.',
  'LBL_SNIP_SUPPORT' => 'Vänligen kontakta SugarCRM Support för hjälp.',
  'LBL_SNIP_USER' => 'Eposta Arkiverings Användare',
  'LBL_SNIP_USER_DESC' => 'Epost Arkiverings användare',
);

