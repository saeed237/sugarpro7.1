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
* Description:
* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
* Reserved. Contributor(s): contact@synolia.com - www.synolia.com
* *******************************************************************************/


$connector_strings = array (
    'LBL_LICENSING_INFO' => '<table border="0" cellspacing="1"><tr><td valign="top" width="35%" class="dataLabel">Zdobądź Poufny klucz klienta z Twitter&#169; poprzez zarejestrowanie swojej instancji Sugar jako nowej aplikacji.<br/><br>Aby zarejestrować swoją instancję:<br/><br/><ol><li>Przejdź do strony programistów Twitter&#169;: <a href=\'http://dev.twitter.com/apps/new\' target=\'_blank\'>http://dev.twitter.com/apps/new</a>.</li><li>Zaloguj się na konto Twitter, pod którym chcesz zarejestrować aplikację.</li><li>W formularzy rejestracji wprowadź nazwę dla aplikacji. Nazwa ta będzie widoczna dla użytkowników podczas autoryzacji kont Twitter z poziomu SugarCRM.</li><li>Wprowadź opis.</li><li>Wprowadź adres strony internetowej aplikacji (może być jakikolwiek).</li><li>/Jako typ aplikacji wybierz “Przeglądarka”.</li><li> wprowadź  URL wywołania (może być dowolny, ponieważ kontrola odbywa się na poziomie uwierzytelnienia. Przykład: Wprowadź URL katalogu głównego Sugar).</li><li>Wprowadź słowa zabezpieczające.</li><li>Kliknij “Zarejestruj aplikację”.</li><li>Zaakceptuj Warunki usług Twitter API.</li><li>Na stronie aplikacji znajdź Unikalny klucz licencyjny i  Poufny klucz klienta. Wprowadź je poniżej.</li></ol></td></tr></table>',
	'LBL_NAME' => 'Nazwa użytkownika Twitter',
	'LBL_ID' => 'Nazwa użytkownika Twitter',
	'company_url' => 'Adres URL',
    'oauth_consumer_key' => 'Unikalny klucz licencyjny',
    'oauth_consumer_secret' => 'Poufny klucz klienta',
);

?>
