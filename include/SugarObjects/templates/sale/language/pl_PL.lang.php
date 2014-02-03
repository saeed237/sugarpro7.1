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
  'ERR_DELETE_RECORD' => 'Musisz podać numer rekordu, aby usunąć tę sprzedaż.',
  'LBL_ACCOUNT_ID' => 'ID kontrahenta',
  'LBL_ACCOUNT_NAME' => 'Nazwa kontrahenta:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Wydarzenia',
  'LBL_AMOUNT' => 'Kwota:',
  'LBL_AMOUNT_USDOLLAR' => 'Kwota w PLN:',
  'LBL_ASSIGNED_TO_ID' => 'Przydzielono do',
  'LBL_ASSIGNED_TO_NAME' => 'Użytkownik:',
  'LBL_CAMPAIGN' => 'Kampania:',
  'LBL_CLOSED_WON_SALES' => 'Wygrane szanse sprzedaży',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kontakty',
  'LBL_CREATED_ID' => 'Utworzone przez',
  'LBL_CURRENCY' => 'Waluta:',
  'LBL_CURRENCY_ID' => 'ID waluty',
  'LBL_CURRENCY_NAME' => 'Nazwa waluty',
  'LBL_CURRENCY_SYMBOL' => 'Symbol waluty',
  'LBL_DATE_CLOSED' => 'Oczekiwana data zakończenia:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Sprzedaż',
  'LBL_DESCRIPTION' => 'Opis:',
  'LBL_DUPLICATE' => 'Możliwa duplikacja sprzedaży',
  'LBL_EDIT_BUTTON' => 'Edytuj',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historia',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Namiary',
  'LBL_LEAD_SOURCE' => 'Źródło:',
  'LBL_LIST_ACCOUNT_NAME' => 'Nazwa kontrahenta',
  'LBL_LIST_AMOUNT' => 'Kwota',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Przydzielono do',
  'LBL_LIST_DATE_CLOSED' => 'Zamknięty',
  'LBL_LIST_FORM_TITLE' => 'Lista sprzedaży',
  'LBL_LIST_SALE_NAME' => 'Nazwa',
  'LBL_LIST_SALE_STAGE' => 'Etap sprzedaży',
  'LBL_MODIFIED_ID' => 'Zmodyfikowane przez',
  'LBL_MODIFIED_NAME' => 'Nazwa użytkownika modyfikującego',
  'LBL_MODULE_NAME' => 'Sprzedaż',
  'LBL_MODULE_TITLE' => 'Sprzedaż: Strona główna',
  'LBL_MY_CLOSED_SALES' => 'Moje zamknięte sprzedaże',
  'LBL_NAME' => 'Nazwa sprzedaży',
  'LBL_NEW_FORM_TITLE' => 'Utwórz nową sprzedaż',
  'LBL_NEXT_STEP' => 'Następny krok:',
  'LBL_PROBABILITY' => 'Szansa (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projekty',
  'LBL_RAW_AMOUNT' => 'Wstępna kwota',
  'LBL_REMOVE' => 'Usuń',
  'LBL_SALE' => 'Sprzedaż:',
  'LBL_SALES_STAGE' => 'Etap sprzedaży:',
  'LBL_SALE_INFORMATION' => 'Informacje o sprzedaży',
  'LBL_SALE_NAME' => 'Nazwa sprzedaży:',
  'LBL_SEARCH_FORM_TITLE' => 'Wyszukiwanie w sprzedaży',
  'LBL_TEAM_ID' => 'ID zespołu',
  'LBL_TOP_SALES' => 'Moje najlepsze otwarte sprzedaże',
  'LBL_TOTAL_SALES' => 'Wszystkie sprzedaże',
  'LBL_TYPE' => 'Typ:',
  'LBL_VIEW_FORM_TITLE' => 'Widok sprzedaży',
  'LNK_NEW_SALE' => 'Utwórz sprzedaż',
  'LNK_SALE_LIST' => 'Sprzedaż',
  'MSG_DUPLICATE' => 'Rekord sprzedaży, który zamierzasz utworzyć może spowodować zduplikowanie rekordu sprzedaży, który już istnieje. Rekordy sprzedaży zawierające podobne nazwy są wymienione poniżej.<br>kliknij Zapisz, aby kontynuować tworzenie tej sprzedaży lub klinij Anuluj, aby powrócić do modułu bez utworzenia sprzedaży.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Czy na pewno chcesz usunąć ten kontakt ze sprzedaży?',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Czy na pewno chcesz usunąć tę sprzedaż z projektu?',
  'UPDATE' => 'Sprzedaż - aktualizacja waluty',
  'UPDATE_BUGFOUND_COUNT' => 'Znaleziono błąd:',
  'UPDATE_BUG_COUNT' => 'Znaleziono błąd i podjęto próbę naprawy:',
  'UPDATE_COUNT' => 'Zaktualizowane rekordy:',
  'UPDATE_CREATE_CURRENCY' => 'Tworzenie nowej waluty:',
  'UPDATE_DOLLARAMOUNTS' => 'Aktualizuj kwoty w złotówkach',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Uaktualnia kwoty w złotówkach dla sprzedaży na podstawie ustawionych obecnie kursów waluty. Ta wartość jest używana do tworzenia wykresow i Widoku listy kwot waluty.',
  'UPDATE_DONE' => 'Wykonano',
  'UPDATE_FAIL' => 'Nie można zaktualizować -',
  'UPDATE_FIX' => 'Popraw kwotowania',
  'UPDATE_FIX_TXT' => 'Przeprowadza próbę naprawy niewłaściwych kwot przez utworzenie prawidłowych wyrażeń dziesiętnych. Każda modyfikacja kwoty jest zachowana w bazie danych, w polu amount_backup. Jeśli wykonasz tę operację i pojawi się błąd, nie uruchamiaj jej ponownie, zanim nie zostaną przywrócone poprzednie wartości, inaczej można spowodować nadpisanie danych błędnymi wartościami.',
  'UPDATE_INCLUDE_CLOSE' => 'Weź pod uwagę zamknięte rekordy',
  'UPDATE_MERGE' => 'Scal waluty',
  'UPDATE_MERGE_TXT' => 'Scal różne waluty w jedną. Jeśli istnieją różne rekordy dla tej samej waluty, możesz scalić je razem. To spowoduje scalenie tych walut również w innych modułach.',
  'UPDATE_NULL_VALUE' => 'Jeśli kwota ma równać się 0, ustaw  NULL -',
  'UPDATE_RESTORE' => 'Przywróć kwoty',
  'UPDATE_RESTORE_COUNT' => 'Przywrócono kwoty rekordów:',
  'UPDATE_RESTORE_TXT' => 'Przywraca wartości kwot z kopii zapasowej podczas naprawy.',
  'UPDATE_VERIFY' => 'Zweryfikuj kwoty',
  'UPDATE_VERIFY_CURAMOUNT' => 'Bieżąca kwota:',
  'UPDATE_VERIFY_FAIL' => 'Weryfikacja rekordu nie powiodła się:',
  'UPDATE_VERIFY_FIX' => 'Wykonanie naprawy powinno dać',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Nowa kwota:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nowa waluta:',
  'UPDATE_VERIFY_TXT' => 'Sprawdza, czy wartości kwot w module sprzedaży są wyrażeniami dziesiętnymi, złożonymi wyłącznie ze znaków numerycznych (0-9) i dziesiętnych(.)',
);

