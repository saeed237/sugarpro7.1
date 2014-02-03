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
  'ERR_DELETE_RECORD' => 'Číslo záznamu musí být uvedeno pro odstranění prodeje.',
  'LBL_ACCOUNT_ID' => 'ID společnosti',
  'LBL_ACCOUNT_NAME' => 'Jméno společnosti:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktivity',
  'LBL_AMOUNT' => 'Částka:',
  'LBL_AMOUNT_USDOLLAR' => 'Částka USD:',
  'LBL_ASSIGNED_TO_ID' => 'Přiděleno ID',
  'LBL_ASSIGNED_TO_NAME' => 'Uživatel:',
  'LBL_CAMPAIGN' => 'Kampaň:',
  'LBL_CLOSED_WON_SALES' => 'Úspěšný prodej uzavřený',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakty',
  'LBL_CREATED_ID' => 'Vytvořeno podle ID',
  'LBL_CURRENCY' => 'Měna:',
  'LBL_CURRENCY_ID' => 'ID měny',
  'LBL_CURRENCY_NAME' => 'Jméno měny',
  'LBL_CURRENCY_SYMBOL' => 'Symbol měny',
  'LBL_DATE_CLOSED' => 'Očekávané datum uzavření:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Prodej',
  'LBL_DESCRIPTION' => 'Popis:',
  'LBL_DUPLICATE' => 'Možné duplicitní prodeje',
  'LBL_EDIT_BUTTON' => 'Upravit',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historie',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Příležiosti',
  'LBL_LEAD_SOURCE' => 'Zdroj:',
  'LBL_LIST_ACCOUNT_NAME' => 'Jméno společnosti',
  'LBL_LIST_AMOUNT' => 'Částka',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Přidělený uživatel',
  'LBL_LIST_DATE_CLOSED' => 'Zavřít',
  'LBL_LIST_FORM_TITLE' => 'Seznam prodeje',
  'LBL_LIST_SALE_NAME' => 'Jméno',
  'LBL_LIST_SALE_STAGE' => 'Prodejní fáze',
  'LBL_MODIFIED_ID' => 'Změněno podle ID',
  'LBL_MODIFIED_NAME' => 'Změněno podle už. jména',
  'LBL_MODULE_NAME' => 'Prodej',
  'LBL_MODULE_TITLE' => 'Prodej: Hlavní stránka',
  'LBL_MY_CLOSED_SALES' => 'Moje uzavřené prodeje',
  'LBL_NAME' => 'Jméno prodeje',
  'LBL_NEW_FORM_TITLE' => 'Vytvořit prodej',
  'LBL_NEXT_STEP' => 'Další krok:',
  'LBL_PROBABILITY' => 'Pravděpodobnost (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projeky',
  'LBL_RAW_AMOUNT' => 'Hrubá částka',
  'LBL_REMOVE' => 'Odstranit',
  'LBL_SALE' => 'Prodej:',
  'LBL_SALES_STAGE' => 'Fáze prodeje:',
  'LBL_SALE_INFORMATION' => 'Obchodní informace',
  'LBL_SALE_NAME' => 'Jméno prodeje:',
  'LBL_SEARCH_FORM_TITLE' => 'Vyhledat prodej',
  'LBL_TEAM_ID' => 'ID týmu',
  'LBL_TOP_SALES' => 'Mé otevřené prodeje',
  'LBL_TOTAL_SALES' => 'Celkové prodeje',
  'LBL_TYPE' => 'Typ:',
  'LBL_VIEW_FORM_TITLE' => 'Zobrazit prodej',
  'LNK_NEW_SALE' => 'Vytvořit prodej',
  'LNK_SALE_LIST' => 'Prodej',
  'MSG_DUPLICATE' => 'Vytvořením tohoto Prodeje můžete potencionálně vytvořit duplicitní položku Prodeje. Můžete buď vybrat Prodej ze seznamu nebo můžete kliknout na Přidat nový Prodej pro vytvoření nového obchodu s předchozími údaji.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Jste si jisti, že chcete odstranit tento kontakt z prodeje?',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Jste si jisti, že chcete odstranit tuto prodeji od projektu?',
  'UPDATE' => 'Prodej - aktualizace měny',
  'UPDATE_BUGFOUND_COUNT' => 'Nalezené chyby:',
  'UPDATE_BUG_COUNT' => 'Byly nalezeny chyby a proběhla snaha je opravit:',
  'UPDATE_COUNT' => 'Aktualizované záznamy:',
  'UPDATE_CREATE_CURRENCY' => 'Vytvářím novou měnu:',
  'UPDATE_DOLLARAMOUNTS' => 'Aktualizace US Dollar částek',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Aktualizovat částky CZK na základě současných kurzů měn. Tato částka je použitá pro výpočet grafů a v seznamu Zobrazit částky v cizí měně.',
  'UPDATE_DONE' => 'Hotovo',
  'UPDATE_FAIL' => 'Nelze aktualizovat -',
  'UPDATE_FIX' => 'Opravit částky',
  'UPDATE_FIX_TXT' => 'Pokus o opravu neplatné částky vytvořením platného čísla ze zadaných částek. Pro modifikované částky bude vytvořena záloha v databázovém poli amount_backup. Pokud zjistíte, že je tato procedura chybná, nespouštějte ji znovu bez předchozího obnovení částek ze zálohy, jinak byste mohli přepsat zazálohované částky neplatnými údaji.',
  'UPDATE_INCLUDE_CLOSE' => 'Včetně uzavřených záznamů',
  'UPDATE_MERGE' => 'Sloučit měny',
  'UPDATE_MERGE_TXT' => 'Sloučit různé měny do jedné. Pokud zjistíte, že existují pro stejnou měnu různé záznamy, můžete je sloučit dohromady. Měny budou sloučeny také ve všech ostatních modulech.',
  'UPDATE_NULL_VALUE' => 'Částka je NULL nastavuji na 0 -',
  'UPDATE_RESTORE' => 'Obnovit částky',
  'UPDATE_RESTORE_COUNT' => 'Obnoveno záznamů:',
  'UPDATE_RESTORE_TXT' => 'Obnovit hodnoty částek ze zálohy vytvořené během opravy.',
  'UPDATE_VERIFY' => 'Ověření částek',
  'UPDATE_VERIFY_CURAMOUNT' => 'Aktuální částka',
  'UPDATE_VERIFY_FAIL' => 'Ověření záznamu selhalo:',
  'UPDATE_VERIFY_FIX' => 'Běžící oprava by',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Nová společnost:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nová měna:',
  'UPDATE_VERIFY_TXT' => 'Ověřuje, že částka hodnoty v prodeji jsou platná desetinná čísla s pouze číselnými znaky (0-9) a desetinnými místy (.)',
);

