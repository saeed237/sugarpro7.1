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
  'ERR_DELETE_RECORD' => 'Adjon meg egy azonosítót az eladás rekordjának törléséhez!',
  'LBL_ACCOUNT_ID' => 'Kliens azonosító',
  'LBL_ACCOUNT_NAME' => 'Kliens neve:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Tevékenységek',
  'LBL_AMOUNT' => 'Összeg:',
  'LBL_AMOUNT_USDOLLAR' => 'Összeg USD:',
  'LBL_ASSIGNED_TO_ID' => 'Felelős azonosítója',
  'LBL_ASSIGNED_TO_NAME' => 'Felhasználó:',
  'LBL_CAMPAIGN' => 'Kampány:',
  'LBL_CLOSED_WON_SALES' => 'Lezárt, megnyert eladások',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Kapcsolatok',
  'LBL_CREATED_ID' => 'Létrehozó azonosítója',
  'LBL_CURRENCY' => 'Pénznem:',
  'LBL_CURRENCY_ID' => 'Pénznem azonosító',
  'LBL_CURRENCY_NAME' => 'Pénznem',
  'LBL_CURRENCY_SYMBOL' => 'Pénznem szimbóluma',
  'LBL_DATE_CLOSED' => 'Lezárás várható dátuma:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Eladás',
  'LBL_DESCRIPTION' => 'Leírás:',
  'LBL_DUPLICATE' => 'Elképzelhető, hogy többszörösen előforduló eladás',
  'LBL_EDIT_BUTTON' => 'Szerkesztés',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Előzmények',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Ajánlások',
  'LBL_LEAD_SOURCE' => 'Ajánlás forrása:',
  'LBL_LIST_ACCOUNT_NAME' => 'Kliens neve',
  'LBL_LIST_AMOUNT' => 'Összeg',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Felelős felhasználó',
  'LBL_LIST_DATE_CLOSED' => 'Zárás',
  'LBL_LIST_FORM_TITLE' => 'Eladás lista',
  'LBL_LIST_SALE_NAME' => 'Név',
  'LBL_LIST_SALE_STAGE' => 'Eladási szint',
  'LBL_MODIFIED_ID' => 'Módosító azonosítója',
  'LBL_MODIFIED_NAME' => 'Módosító felhasználó neve',
  'LBL_MODULE_NAME' => 'Eladás',
  'LBL_MODULE_TITLE' => 'Eladás: Főoldal',
  'LBL_MY_CLOSED_SALES' => 'Lezárt eladásaim',
  'LBL_NAME' => 'Eladás neve',
  'LBL_NEW_FORM_TITLE' => 'Új eladás',
  'LBL_NEXT_STEP' => 'Következő lépés:',
  'LBL_PROBABILITY' => 'Valószínűség (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projektek',
  'LBL_RAW_AMOUNT' => 'Nyers összeg',
  'LBL_REMOVE' => 'Eltávolítás',
  'LBL_SALE' => 'Eladás:',
  'LBL_SALES_STAGE' => 'Eladási szint:',
  'LBL_SALE_INFORMATION' => 'Eladás információ',
  'LBL_SALE_NAME' => 'Eladás neve:',
  'LBL_SEARCH_FORM_TITLE' => 'Keresés az eladásban',
  'LBL_TEAM_ID' => 'Csoport azonosító',
  'LBL_TOP_SALES' => 'Nyitott, Top eladásaim',
  'LBL_TOTAL_SALES' => 'Összes eladás',
  'LBL_TYPE' => 'Típus:',
  'LBL_VIEW_FORM_TITLE' => 'Eladás nézet',
  'LNK_NEW_SALE' => 'Új eladás',
  'LNK_SALE_LIST' => 'Eladás',
  'MSG_DUPLICATE' => 'Az Eladási rekord, amelyet épp létrehozni készül, elképzelhető, hogy már szerepel a rendszerben. A hasonló nevű rekordok listáját alább találja. Kattintson a Mentés gombra az új eladás véglegesítéséhez vagy a Mégsem gomb megnyomásával térjen vissza a modulba, eladás létrehozása nélkül.',
  'NTC_REMOVE_OPP_CONFIRMATION' => 'Biztosan törölni kívánja ezt a kapcsolatot ebből az eladásból?',
  'SALE_REMOVE_PROJECT_CONFIRM' => 'Biztosan törölni kívánja ezt az eladást a projektből?',
  'UPDATE' => 'Eladás - Pénznem frissítése',
  'UPDATE_BUGFOUND_COUNT' => 'Megtalált hibák:',
  'UPDATE_BUG_COUNT' => 'Hibák, amelyeket a rendszer megkísérelt kijavítnai:',
  'UPDATE_COUNT' => 'Frissített rekordok:',
  'UPDATE_CREATE_CURRENCY' => 'Új pénznem létrehozása:',
  'UPDATE_DOLLARAMOUNTS' => 'USA dollár összegek frissítése',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Frissíti az USA dollár összegeket a beállított napi árfolyamok alapján. Ezen érték felhasználható a Grafikonok és a Lista Nézet Pénznem Értékek menüpontban.',
  'UPDATE_DONE' => 'Kész',
  'UPDATE_FAIL' => 'Nem sikerült frissíteni -',
  'UPDATE_FIX' => 'Összegek javítása',
  'UPDATE_FIX_TXT' => 'Megkísérli kijavítani az érvénytelen értékeket valós decimális értékekre. Minden módosított érték biztonsági mentés adatbázisban tárolódik. Ha futás közben hibát észlel, ne futtassa újra helyreállítás nélkül a biztonsági mentést, mert a régit felül fogja írni az új érvénytelen adattal.',
  'UPDATE_INCLUDE_CLOSE' => 'Zárt rekordokkal együtt',
  'UPDATE_MERGE' => 'Pénznemek egyesítése',
  'UPDATE_MERGE_TXT' => 'Több pénzem egyesítése eggyé. Ha több pénzem rekord található egy pénznemhez, a rendszer egyesíti őket. Az egyesítés az összes modulra nézve érvényes lesz.',
  'UPDATE_NULL_VALUE' => 'NULL összeg átállítása 0-ra',
  'UPDATE_RESTORE' => 'Összegek helyreállítása',
  'UPDATE_RESTORE_COUNT' => 'Helyreállított rekord összegek:',
  'UPDATE_RESTORE_TXT' => 'Az összeg értékeinek helyreállítása biztonsági mentés alapján',
  'UPDATE_VERIFY' => 'Összegek ellenőrzése',
  'UPDATE_VERIFY_CURAMOUNT' => 'Jelenlegi összeg:',
  'UPDATE_VERIFY_FAIL' => 'Rekord ellenőrzése sikertelen:',
  'UPDATE_VERIFY_FIX' => 'Az aktualizálás végrehajtása',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Új összeg:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Új pénznem:',
  'UPDATE_VERIFY_TXT' => 'Ellenőrzi, hogy az összegek érvényes decimális(.) vagy numerikus(0-9) karakterek-e.',
);

