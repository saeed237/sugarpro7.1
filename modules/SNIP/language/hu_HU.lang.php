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
  'ERROR_BAD_RESULT' => 'A szolgáltatás eredménytelen',
  'ERROR_NO_CURL' => 'cURL kiterjesztések szükségesek, de nincsenek engedélyezve',
  'ERROR_REQUEST_FAILED' => 'Nem sikerült kapcsolatot létesíteni a szerverrel',
  'LBL_CANCEL_BUTTON_TITLE' => 'Mégsem',
  'LBL_CONFIGURE_SNIP' => 'Email archiválás',
  'LBL_CONTACT_SUPPORT' => 'Kérem, próbálja újra vagy lépjen kapcsolatba a SugarCRM Support kollégáival!',
  'LBL_DISABLE_SNIP' => 'Letilt',
  'LBL_REGISTER_SNIP_FAIL' => 'Nem sikerült kapcsolatot létesíteni az email archiváló szolgáltatással: %s!',
  'LBL_SNIP_ACCOUNT' => 'Kliens',
  'LBL_SNIP_AGREE' => 'Elfogadom a fenti feltételeket és az adatvédelmi megállapodás tartalmát.',
  'LBL_SNIP_APPLICATION_UNIQUE_KEY' => 'Alkalmazáshoz kapcsolódó egyedi kulcs',
  'LBL_SNIP_BUTTON_DISABLE' => 'Email archiválás letiltása',
  'LBL_SNIP_BUTTON_ENABLE' => 'Email archiválás engedélyezése',
  'LBL_SNIP_BUTTON_RETRY' => 'Kíséreljen meg ismét csatlakozni',
  'LBL_SNIP_CALLBACK_URL' => 'Email archiváló szolgáltatás URL',
  'LBL_SNIP_DESCRIPTION' => 'Az email archiváló szolgáltatás automatikus archiváló rendszer',
  'LBL_SNIP_DESCRIPTION_SUMMARY' => 'Lehetővé teszi, hogy megtekintse a SugarCRM-en belül küldött vagy fogadott emailjeit azok importálása nélkül',
  'LBL_SNIP_EMAIL' => 'Email archiválási cím',
  'LBL_SNIP_ERROR_DISABLING' => 'Hiba lépett fel az email archiváló szerverrel folytatott kommunikáció során; a szolgáltatást nem lehetett letiltani',
  'LBL_SNIP_ERROR_ENABLING' => 'Hiba lépett fel az email archiváló szerverrel folytatott kommunikáció során; a szolgáltatást nem lehetett engedélyezni',
  'LBL_SNIP_GENERIC_ERROR' => 'Az email archiváló szolgáltatás jelenleg nem elérhető. Vagy karbantartási munkák folynak, vagy a kapcsolódás sikertelen.',
  'LBL_SNIP_KEY_DESC' => 'Email archiváló kulcs, amely a Sugar emailek importálásához szükséges.',
  'LBL_SNIP_LAST_SUCCESS' => 'Utolsó sikeres futtatás',
  'LBL_SNIP_MOUSEOVER_EMAIL' => 'Ez az email archiváláshoz megadott cím, amelyre a Sugar-be való importáláshoz kell továbbítani a kívánt állományokat.',
  'LBL_SNIP_MOUSEOVER_INSTANCE_URL' => 'Ez a Sugar webszervíz URL címe. Az email archiváló szerver ezen keresztül fog kapcsolódni az Ön szerveréhez.',
  'LBL_SNIP_MOUSEOVER_SERVICE_URL' => 'Ez az email archiváló szerver URL címe. Minden parancs, többek között az email archiváló szolgáltatás engedélyezése és letiltása, ezen a címen keresztül fog továbbítódni.',
  'LBL_SNIP_MOUSEOVER_STATUS' => 'Ez az Ön email archiváló szolgáltatásának állapota. Azt mutatja, hogy a Sugar és az email archiváló szerver kapcsolata problémamentes-e.',
  'LBL_SNIP_NEVER' => 'Soha',
  'LBL_SNIP_PRIVACY' => 'adatvédelmi nyilatkozat',
  'LBL_SNIP_PURCHASE' => 'Kattintson ide a vásárláshoz',
  'LBL_SNIP_PURCHASE_SUMMARY' => 'Az emailek archiválásához érvényes licenccel kell rendelkeznie SugarCRM alkalmazása számára',
  'LBL_SNIP_PWD' => 'Jelszó az emailek archiválásához',
  'LBL_SNIP_STATUS' => 'Állapot',
  'LBL_SNIP_STATUS_ERROR' => 'Hiba',
  'LBL_SNIP_STATUS_ERROR_SUMMARY' => 'Ön érvényes email archiválási licenccel rendelkezik, de a szerver az alábbi hibaüzenetet küldte vissza:',
  'LBL_SNIP_STATUS_FAIL' => 'Az email archiváló szerveren történő regisztrálás sikertelen',
  'LBL_SNIP_STATUS_FAIL_SUMMARY' => 'Az email archiváló szolgáltatás jelenleg nem elérhető. Vagy karbantartási munkák folynak, vagy a kapcsolódás sikertelen.',
  'LBL_SNIP_STATUS_OK' => 'Engedélyezve',
  'LBL_SNIP_STATUS_OK_SUMMARY' => 'Az Ön Sugar példánya sikeresen kapcsolódott az email archiváló szerverhez.',
  'LBL_SNIP_STATUS_PINGBACK_FAIL' => 'Sikertelen visszamenő ping',
  'LBL_SNIP_STATUS_PINGBACK_FAIL_SUMMARY' => 'Az email archiváló szerver nem tudja elérni az Ön Sugar példányát. Kérem, próbálja újra vagy lépjen kapcsolatba a SugarCRM Support kollégáival!',
  'LBL_SNIP_STATUS_PROBLEM' => 'Probléma: %s',
  'LBL_SNIP_STATUS_RESET' => 'Nem volt futtatva',
  'LBL_SNIP_STATUS_SUMMARY' => 'Email archiváló szerver állapota:',
  'LBL_SNIP_SUGAR_URL' => 'Ez a Sugar URL',
  'LBL_SNIP_SUMMARY' => 'Az email archiválás egy automatikus archiváló szolgáltatás, amely az állományokat az email kiszolgálókról egy konkrét címre továbbítva importálja a Sugar alkalmazásba. Minden Sugar példány egyedi email azonosítóval rendelkezik. Az emailek archiválásához a megadott email címet fel kell tüntetni a TO, CC vagy BCC mezőkben. Az email archiváló szolgáltatás a Sugar példányába importálja az emaileket. A szolgáltatás átveszi az emaileket, a csatolmányokat, a képeket és a naptári eseményeket, illetőleg bejegyzéseket társít a meglévő rekordokhoz, amennyiben egyező email címeket talál. <br /><br />Például: felhasználóként hozzáférhet minden emailhez, amely abban az email fiókban landol, amely az Ön Sugar példányával van regisztrálva. Olyan emailekhez is hozzáférhet, amely példánya regisztrált kapcsolatait érinti. <br /><br />A felhasználói feltételek elfogadásával engedélyezi a szolgáltatást. A letiltás a későbbiekben bármikor elképzelhető. A szolgáltatáshoz használandó email cím a szolgáltatás aktiválásnak pillanatában meg fog jelenni.',
  'LBL_SNIP_SUPPORT' => 'Kérem, lépjen kapcsolatba a SugarCRM Support kollégáival!',
  'LBL_SNIP_USER' => 'Email archiváló felhasználó',
  'LBL_SNIP_USER_DESC' => 'Email archiváló felhasználó',
);

