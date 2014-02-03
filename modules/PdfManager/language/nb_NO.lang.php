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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktiviteter',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'ADVARSEL: Hvis du endrer den primære modulen, så må alle feltene som allerede er lagt til malen fjernes.',
  'LBL_ASSIGNED_TO_ID' => 'Tildelt Bruker-ID',
  'LBL_ASSIGNED_TO_NAME' => 'Tildelt',
  'LBL_AUTHOR' => 'Forfatter',
  'LBL_BASE_MODULE' => 'Modul',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Velg en modul som denne malen skal være tilgjengelig for.',
  'LBL_BODY_HTML' => 'Mal',
  'LBL_BODY_HTML_POPUP_HELP' => 'Lag malen ved hjelp av HTML-editoren. Når du har lagret malen, vil du være i stand til å se en forhåndsvisning av PDF-versjonen av malen.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Lag malen ved hjelp av HTML-editoren. Når du har lagret malen, vil du være i stand til å se en forhåndsvisning av PDF-versjonen av malen. <br /> <br /> For å redigere loop&#39;en som brukes til å lage Produktlinje-elementene, klikker du på "HTML"-knappen i editoren for å få tilgang til koden. Koden er inkludert i <-! START_BUNDLE_LOOP -> <-! START_PRODUCT_LOOP -> <-! END_PRODUCT_LOOP -> og <- END_BUNDLE_LOOP ->.',
  'LBL_BTN_INSERT' => 'Sett inn',
  'LBL_CREATED' => 'Opprettet Av',
  'LBL_CREATED_ID' => 'Opprettet av ID',
  'LBL_CREATED_USER' => 'Opprettet av Bruker',
  'LBL_DATE_ENTERED' => 'Opprettet dato',
  'LBL_DATE_MODIFIED' => 'Endret Dato',
  'LBL_DELETED' => 'Slettet',
  'LBL_DESCRIPTION' => 'Beskrivelse',
  'LBL_EDITVIEW_PANEL1' => 'PDF-dokument-egenskaper',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Her er filen du etterspurte (Du kan endre denne teksten)',
  'LBL_FIELD' => 'Felt',
  'LBL_FIELDS_LIST' => 'Felt',
  'LBL_FIELD_POPUP_HELP' => 'Velg et felt for å sette inn variabelen for feltverdien. For å velge felt fra en overordnet modul, velg først modulen i Koblinger nederst på Felt-listen i den første nedtrekksmenyen, deretter feltet i den andre nedtrekksmenyen.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Se på historikk',
  'LBL_HOMEPAGE_TITLE' => 'Mine PDF-maler',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Nøkkelord',
  'LBL_KEYWORDS_POPUP_HELP' => 'Knytt Søkeord til dokumentet, vanligvis i form av "nøkkelord1 nøkkelord2 ..."',
  'LBL_LINK_LIST' => 'Koblinger',
  'LBL_LIST_FORM_TITLE' => 'PDF mal-liste',
  'LBL_LIST_NAME' => 'Navn',
  'LBL_MODIFIED' => 'Endret Av',
  'LBL_MODIFIED_ID' => 'Endret av ID',
  'LBL_MODIFIED_NAME' => 'Endret av Navn',
  'LBL_MODIFIED_USER' => 'Endret av Bruker',
  'LBL_MODULE_NAME' => 'PdfManager',
  'LBL_MODULE_TITLE' => 'PdfManager',
  'LBL_NAME' => 'Navn',
  'LBL_NEW_FORM_TITLE' => 'Ny PDF-mal',
  'LBL_PAYMENT_TERMS' => 'Betalingsbetingelser::',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PdfManager',
  'LBL_PREVIEW' => 'Forhåndsvisning',
  'LBL_PUBLISHED' => 'Publisert',
  'LBL_PUBLISHED_POPUP_HELP' => 'Publisér en mail for å gjøre den tilgjengelig for brukere.',
  'LBL_PURCHASE_ORDER_NUM' => 'Innkjøpsordrenr:',
  'LBL_SEARCH_FORM_TITLE' => 'Søk i PDF-maler',
  'LBL_SUBJECT' => 'Emne',
  'LBL_TEAM' => 'Grupper',
  'LBL_TEAMS' => 'Grupper',
  'LBL_TEAM_ID' => 'Gruppe-ID',
  'LBL_TITLE' => 'Tittel',
  'LBL_TPL_BILL_TO' => 'Fakturér',
  'LBL_TPL_CURRENCY' => 'Valuta:',
  'LBL_TPL_DISCOUNT' => 'Rabatt:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Rabattert Subtotal:',
  'LBL_TPL_EXT_PRICE' => 'Ekst. pris',
  'LBL_TPL_GRAND_TOTAL' => 'Totalsum',
  'LBL_TPL_INVOICE' => 'Faktura',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Denne malen brukes til å skrive ut Faktura som PDF.',
  'LBL_TPL_INVOICE_NAME' => 'Faktura',
  'LBL_TPL_INVOICE_NUMBER' => 'Fakturanummer:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'faktura',
  'LBL_TPL_LIST_PRICE' => 'Listepris',
  'LBL_TPL_PART_NUMBER' => 'Delenummer',
  'LBL_TPL_PRODUCT' => 'Produkt',
  'LBL_TPL_QUANTITY' => 'Antall',
  'LBL_TPL_QUOTE' => 'Tilbud',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Denne malen brukes til å skrive ut Tilbud som PDF.',
  'LBL_TPL_QUOTE_NAME' => 'Tilbud',
  'LBL_TPL_QUOTE_NUMBER' => 'Tilbudsnummer:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'tilbud',
  'LBL_TPL_SALES_PERSON' => 'Selger:',
  'LBL_TPL_SHIPPING' => 'Frakt:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Befrakter:',
  'LBL_TPL_SHIP_TO' => 'Send til',
  'LBL_TPL_SUBTOTAL' => 'Subtotal:',
  'LBL_TPL_TAX' => 'Skatt:',
  'LBL_TPL_TAX_RATE' => 'Skatteprosent:',
  'LBL_TPL_TOTAL' => 'Total',
  'LBL_TPL_UNIT_PRICE' => 'Enhetspris',
  'LBL_TPL_VALID_UNTIL' => 'Gyldig til:',
  'LNK_IMPORT_PDFMANAGER' => 'Importér PDF-maler',
  'LNK_LIST' => 'Vis PDF-maler',
  'LNK_NEW_RECORD' => 'Opprett PDF-mal',
  'LNK_REPORT_CONFIG' => 'Rapportér PDF-mal',
);

