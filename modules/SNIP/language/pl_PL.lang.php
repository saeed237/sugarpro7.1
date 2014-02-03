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


/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$mod_strings = array(
    'LBL_SNIP_SUMMARY' => "Archiwizacja wiadomości e-mail jest automatyczną usługą pozwalającą użytkownikom na import wiadomości do SugarCRM z dowolnego zewnętrznego klienta poczty. Każda instancja Sugar posiada unikalny adres e-mail. Aby importować wiadomości użytkownik podczas wysłania wiadomość e-mail, dołącza ten adres (poprzez DO, DW lub UDW) na podany adres. Usługa Archiwizacji zaimportuje automatycznie wiadomość do systemu wraz z załącznikami, obrazami i wydarzeniami kalendarza oraz powiąże ją z odpowiednimi rekordami w aplikacji na podstawie adresu e-mail odbiorcy. 
    <br><br>Przykład: Funkcjonalność ta pozwala Użytkownikowi na szybki podgląd wszystkich wiadomości wysłanych do Kontrahenta, Namiaru lub Kontaktu z poziomu widoku szczegółowego.
    <br><br>Zaakceptuj warunki powyższej umowy i kliknij Uaktywnij, aby rozpocząć korzystanie z usługi. Usługę można dezaktywować w dowolnym momencie. Po aktywacji zostanie wyświetlony adres e-mail, który umożliwi korzystanie z usługi.
    <br><br>",
	'LBL_REGISTER_SNIP_FAIL' => 'Nie udało się połączyć z usługą archiwizacji: %s!<br>',
	'LBL_CONFIGURE_SNIP' => 'Archiwizacja wiadomości e-mail',
    'LBL_DISABLE_SNIP' => 'Dezaktywuj',
    'LBL_SNIP_APPLICATION_UNIQUE_KEY' => 'Unikalny klucz aplikacji',
    'LBL_SNIP_USER' => 'Użytkownik Archiwizacji wiadomości e-mail',
    'LBL_SNIP_PWD' => 'Hasło Archiwizacji wiadomości e-mail',
    'LBL_SNIP_SUGAR_URL' => 'Adres URL tej instancji Sugar',
	'LBL_SNIP_CALLBACK_URL' => 'Adres URL usługi Archiwizacji wiadomości e-mail',
    'LBL_SNIP_USER_DESC' => 'Użytkownik Archiwizacji wiadomości e-mail',
	'LBL_SNIP_KEY_DESC' => 'Klucz OAuth Archiwizacji wiadomości e-mail. Używany podczas dostępu do tej instancji w celu importowania wiadomości e-mail.',
    'LBL_SNIP_STATUS_OK' => 'Aktywowano',
    'LBL_SNIP_STATUS_OK_SUMMARY' => 'Ta instancja Sugar została pomyślnie połączona z serwerem Archiwizacji wiadomości e-mail.',
    'LBL_SNIP_STATUS_ERROR' => 'Błąd',
    'LBL_SNIP_STATUS_ERROR_SUMMARY' => 'Ta instancja posiada ważną licencję serwera Archiwizacji wiadomości e-mail, jednakże serwer zwrócił następującą wiadomość błędu: ',
    'LBL_SNIP_STATUS_FAIL' => 'Nie można zarejestrować się na serwerze Archiwizacji wiadomości e-mail',
    'LBL_SNIP_STATUS_FAIL_SUMMARY' => 'Usługa Archiwizacji wiadomości e-mail jest obecnie niedostępna. Albo są problem z usługą  albo nie udało się połączyć z tą instancją Sugar.',
    'LBL_SNIP_GENERIC_ERROR' => 'Usługa Archiwizacji wiadomości e-mail jest obecnie niedostępna. Albo są problem z usługą  albo nie udało się połączyć z tą instancją Sugar.',

	'LBL_SNIP_STATUS_RESET' => 'Jeszcze nie wykonano',
	'LBL_SNIP_STATUS_PROBLEM' => 'Problem: %s',
    'LBL_SNIP_NEVER' => "Nigdy",
    'LBL_SNIP_STATUS_SUMMARY' => "Status usługi Archiwizacji wiadomości e-mail:",
    'LBL_SNIP_ACCOUNT' => "Kontrahent",
    'LBL_SNIP_STATUS' => "Status",
    'LBL_SNIP_LAST_SUCCESS' => "Ostatnie pomyślne wykonanie",
    'LBL_SNIP_DESCRIPTION' => "Usługa Archiwizacji wiadomości e-mail jest systemem automatycznej archiwizacji e-maili",
    'LBL_SNIP_DESCRIPTION_SUMMARY' => "Pozwala ona na przeglądanie wiadomości, które zostały wysłane do lub otrzymane od Twojego Kontaktu w SugarCRM, bez potrzeby ręcznej archiwizacji i łączenia e-maili",
    'LBL_SNIP_PURCHASE_SUMMARY' => "Aby korzystać z Archiwizacji wiadomości e-mail, musisz wykupić licencję dla Twojej instancji SugarCRM",
    'LBL_SNIP_PURCHASE' => "Kliknij tutaj, aby dokonać zakupu",
    'LBL_SNIP_EMAIL' => 'Adres Archiwizacji wiadomości e-mail ',
    'LBL_SNIP_AGREE' => "Akceptuję powyższe warunki i <a href='http://www.sugarcrm.com/crm/TRUSTe/privacy.html' target='_blank'>politykę prywatności</a>.",
    'LBL_SNIP_PRIVACY' => ' politykę prywatności ',

    'LBL_SNIP_STATUS_PINGBACK_FAIL' => 'Błąd podczas pingowania',
    'LBL_SNIP_STATUS_PINGBACK_FAIL_SUMMARY' => 'Serwer Archiwizacji wiadomości e-mail  nie może ustanowić połączenia z Twoją instancją Sugar. Spróbuj ponownie lub <a href="http://www.sugarcrm.com/crm/case-tracker/submit.html?lsd=supportportal&tmpl=" target="_blank">skontaktuj się ze wsparciem klienta </a>.',

    'LBL_SNIP_BUTTON_ENABLE' => 'Aktywuj Archiwizację wiadomości e-mail ',
    'LBL_SNIP_BUTTON_DISABLE' => 'Dezaktywuj Archiwizację wiadomości e-mail',
    'LBL_SNIP_BUTTON_RETRY' => 'Spróbuj ponownie się połączyć',
    'LBL_SNIP_ERROR_DISABLING' => 'Wystąpił błąd podczas komunikacji z serwerem Archiwizacji wiadomości e-mail. Usługa nie została dezaktywowana ',
    'LBL_SNIP_ERROR_ENABLING' => 'Wystąpił błąd podczas komunikacji z serwerem Archiwizacji wiadomości e-mail. Usługa nie została dezaktywowana ',
    'LBL_CONTACT_SUPPORT' => 'Spróbuj ponownie lub skontaktuj się ze wsparciem SugarCRM.',
    'LBL_SNIP_SUPPORT' => ' Skontaktuj się ze wsparciem SugarCRM',
    'ERROR_BAD_RESULT' => 'Zwrócono złe wyniki z usługi',
	'ERROR_NO_CURL' => 'Wymagane są rozszerzenia cURL, ale nie zostały aktywowane',
	'ERROR_REQUEST_FAILED' => 'Nie można połączyć się z serwerem',

    'LBL_CANCEL_BUTTON_TITLE' => 'Anuluj',

    'LBL_SNIP_MOUSEOVER_STATUS' => ' To jest status usługi Archiwizacji wiadomości e-mail Twojej instancji. Status odzwierciedla stan połączenia z serwera archiwizacji z Twoją instancją.',
    'LBL_SNIP_MOUSEOVER_EMAIL' => 'To jest adres e-mail służący do importowania wiadomości do Sugar.',
    'LBL_SNIP_MOUSEOVER_SERVICE_URL' => 'To jest adres URL  serwera archiwizacji. Wszystkie żądania, takie jak aktywacja i dezaktywacja, będą przekierowywane przez ten URL.',
    'LBL_SNIP_MOUSEOVER_INSTANCE_URL' => 'To jest link webservices Twojej instancji Sugar. Serwer Archiwizacji e-mail połączy się z Twoim serwerem poprzez ten URL.',
);
