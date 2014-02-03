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
  'ERR_DELETE_RECORD' => 'Morate navesti odgovarajući broj zapisa da bi obrisali prodaju.',
  'LBL_ACCOUNT_ID' => 'ID broj kompanije',
  'LBL_ACCOUNT_NAME' => 'Naziv kompanije:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivnosti',
  'LBL_AMOUNT' => 'Iznos:',
  'LBL_AMOUNT_USDOLLAR' => 'Iznos Američki dolar:',
  'LBL_ASSIGNED_TO_ID' => 'ID dodeljenog korisnika',
  'LBL_ASSIGNED_TO_NAME' => 'Korisnik:',
  'LBL_CAMPAIGN' => 'Kampanja:',
  'LBL_CLOSED_WON_SALES' => 'Prodaje završene dobitkom',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakti',
  'LBL_CREATED_ID' => 'ID broj autora',
  'LBL_CURRENCY' => 'Valuta:',
  'LBL_CURRENCY_ID' => 'ID broj valute',
  'LBL_CURRENCY_NAME' => 'Ime valute',
  'LBL_CURRENCY_SYMBOL' => 'Simbol valute',
  'LBL_DATE_CLOSED' => 'Očekivani datum zatvaranja:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Prodaja',
  'LBL_DESCRIPTION' => 'Opis:',
  'LBL_DUPLICATE' => 'Mogući dupla prodaja',
  'LBL_EDIT_BUTTON' => 'Izmeni',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Istorija',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Potencijalni klijenti',
  'LBL_LEAD_SOURCE' => 'Izvor potencijalnog klijenta:',
  'LBL_LIST_ACCOUNT_NAME' => 'Naziv kompanije',
  'LBL_LIST_AMOUNT' => 'Iznos',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Dodeljeni korisnik:',
  'LBL_LIST_DATE_CLOSED' => 'Zatvori',
  'LBL_LIST_FORM_TITLE' => 'Lista prodaje',
  'LBL_LIST_SALE_NAME' => 'Naziv',
  'LBL_LIST_SALE_STAGE' => 'Faza prodaje',
  'LBL_MODIFIED_ID' => 'ID broj korisnika koji je promenio',
  'LBL_MODIFIED_NAME' => 'Ime korisnika koji je promenio',
  'LBL_MODULE_NAME' => 'Prodaja',
  'LBL_MODULE_TITLE' => 'Prodaja: Početna strana',
  'LBL_MY_CLOSED_SALES' => 'Moje završene prodaje',
  'LBL_NAME' => 'Naziv prodaje:',
  'LBL_NEW_FORM_TITLE' => 'Kreiraj prodaju',
  'LBL_NEXT_STEP' => 'Sledeći korak:',
  'LBL_PROBABILITY' => 'Verovatnoća (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekti',
  'LBL_RAW_AMOUNT' => 'Neobrađen iznos',
  'LBL_REMOVE' => 'Ukloni',
  'LBL_SALE' => 'Prodaja:',
  'LBL_SALES_STAGE' => 'Faza prodaje:',
  'LBL_SALE_INFORMATION' => 'Informacije o prodaji',
  'LBL_SALE_NAME' => 'Naziv prodaje:',
  'LBL_SEARCH_FORM_TITLE' => 'Pretraga prodaje',
  'LBL_TEAM_ID' => 'ID broj tima',
  'LBL_TOP_SALES' => 'Moje najbolje započete prodaje',
  'LBL_TOTAL_SALES' => 'Ukupna prodaja',
  'LBL_TYPE' => 'Tip:',
  'LBL_VIEW_FORM_TITLE' => 'Pregled prodaje',
  'LNK_NEW_SALE' => 'Kreiraj prodaju',
  'LNK_SALE_LIST' => 'Prodaja',
  'MSG_DUPLICATE' => 'Prodaja koju želite da kreirate možda je duplikat prodaje koja već postoji. Prodaje koje sadrže slična imena izlistane su ispod.<br>Kliknite Sačuvaj da bi nastavili sa kreiranjem ove nove prodaje, ili kliknite Otkaži da bi se vratili u modul bez kreiranje prodaje.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'a li ste sigurni da želite da uklonite ovaj kontakt iz prodaje?',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Da li ste sigurni da želite da uklonite ovu prodaju iz projekta?',
  'UPDATE' => 'Prodaja - Ažuriranje valute',
  'UPDATE_BUGFOUND_COUNT' => 'Nađeni defekti:',
  'UPDATE_BUG_COUNT' => 'Defekti koji su pronađeni i za koje će se tražiti rešenje:',
  'UPDATE_COUNT' => 'Ažurirani zapisi:',
  'UPDATE_CREATE_CURRENCY' => 'Kreiranje nove valute:',
  'UPDATE_DOLLARAMOUNTS' => 'Ažuriraj iznose Američkih dolara',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Ažuriraj iznos Američkih dolara za prodajne prilike koje su zasnovane na tekućem kursu valute. Ova vrednost se koristi za proračunavanje grafika i pregleda kursne liste.',
  'UPDATE_DONE' => 'Završeno',
  'UPDATE_FAIL' => 'Ne mogu da ažuriram -',
  'UPDATE_FIX' => 'Ispravi iznose',
  'UPDATE_FIX_TXT' => 'Pokušava da ispravi pogrešne iznose, kreirajući ispravan decimalni broj od unesene količine. Svaki izmenjeni broj je sačuvan u bazi amount_backup. Ako se prilikom ove funkcije dogodi greška, ne pokušavajte ponovo da pokrenete bez povraćaja podataka iz rezervne pošto bi mogli da napravite novu rezervnu kopiju u koju bi se upisali novi nevažeći podaci.',
  'UPDATE_INCLUDE_CLOSE' => 'Uključujući zatvorene zapise',
  'UPDATE_MERGE' => 'Spajanje valuta',
  'UPDATE_MERGE_TXT' => 'Svedi više valuta na jednu valutu. Ako postoji više zapisa valute za istu valutu, spoji zapise u jedan. Ovo će takođe svesti valute za sve ostale module.',
  'UPDATE_NULL_VALUE' => 'Vrednost je NULL i biće postavljena na 0 -',
  'UPDATE_RESTORE' => 'Obnovi iznose',
  'UPDATE_RESTORE_COUNT' => 'Obnovljeni iznosi zapisa:',
  'UPDATE_RESTORE_TXT' => 'Rekonstruše vrednost iz rezervne kopije koja je kreirana tokom popravke.',
  'UPDATE_VERIFY' => 'Proveri iznose',
  'UPDATE_VERIFY_CURAMOUNT' => 'Trenutni iznos:',
  'UPDATE_VERIFY_FAIL' => 'Neuspela verifikacija zapisa:',
  'UPDATE_VERIFY_FIX' => 'Pokretanje popravke daće',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Novi iznos:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nova valuta:',
  'UPDATE_VERIFY_TXT' => 'Proverava da li je vrednost prodajne prilike ispravan decimalni broj koji sadrži samo numeričke karaktere (0-9) i decimale (.)',
);

