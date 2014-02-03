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
  'ERR_NO_OPPS' => 'Hozzon létre néhány lehetőséget a lehetőség-diagram megtekintéséhez!',
  'LBL_ALL_OPPORTUNITIES' => 'Az összes lehetőség összege',
  'LBL_CAMPAIGN_ROI_TITLE_DESC' => 'Megmutatja a kampány eredményét a beruházás megtérülése alapján.',
  'LBL_CHART_ACTION' => 'Művelet',
  'LBL_CHART_DCE_ACTIONS_MONTH' => 'Elosztott feladatok típusonként (aktuális hónap)',
  'LBL_CHART_LEAD_SOURCE_BY_OUTCOME' => 'Lead forrása végkimenet alapján',
  'LBL_CHART_MODULES_USED_DIRECT_REPORTS_30_DAYS' => 'Közvetlen jelentéseimben használt modulok (utolsó 30 nap)',
  'LBL_CHART_MY_MODULES_USED_30_DAYS' => 'Használt modulok (utolsó 30 nap)',
  'LBL_CHART_MY_PIPELINE_BY_SALES_STAGE' => 'Saját pipeline az értékesítés szakaszai alapján',
  'LBL_CHART_OPPORTUNITIES_THIS_QUARTER' => 'Lehetőségek a negyedévben',
  'LBL_CHART_OUTCOME_BY_MONTH' => 'Havi eredmények',
  'LBL_CHART_PIPELINE_BY_LEAD_SOURCE' => 'Pipeline a leadek forrása alapján',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE' => 'Pipeline az értékesítés szakaszai alapján',
  'LBL_CHART_PIPELINE_BY_SALES_STAGE_FUNNEL' => 'Pipeline az értékesítési tölcsér alapján',
  'LBL_CHART_TYPE' => 'Diagramtípus:',
  'LBL_CLOSE_DATE_END' => 'Várható lezárás dátuma -ig:',
  'LBL_CLOSE_DATE_START' => 'Várható befejezés dátuma a köv. időponttól:',
  'LBL_CREATED_ON' => 'Utoljára futtatott',
  'LBL_DATE_END' => 'Befejezés dátuma:',
  'LBL_DATE_RANGE' => 'Dátumtartomány',
  'LBL_DATE_RANGE_TO' => 'eddig',
  'LBL_DATE_START' => 'Kezdés dátuma:',
  'LBL_EDIT' => 'Szerkeszt',
  'LBL_LEAD_SOURCES' => 'Ajánlás forrásai:',
  'LBL_LEAD_SOURCE_BY_OUTCOME' => 'Összes lehetőség az ajánlás forrása és eredménye alapján',
  'LBL_LEAD_SOURCE_BY_OUTCOME_DESC' => 'Megmutatja a lehetőségek halmozott összegét az ajánlás forrása alapján a kiválasztott felhasználóknak. Eredménye azon alapul, hogy az értékesítési szakasz lezárt és eredményes, lezárt és sikertelen, vagy egyéb állapotú.',
  'LBL_LEAD_SOURCE_FORM_DESC' => 'Megmutatja a lehetőségek halmozott összegét az ajánlás forrása alapján a kiválasztott felhasználóknak.',
  'LBL_LEAD_SOURCE_FORM_TITLE' => 'Minden lehetőség a kiválasztott ajánlás forrása alapján',
  'LBL_LEAD_SOURCE_OTHER' => 'Egyéb',
  'LBL_MODULE_NAME' => 'Műszerfal',
  'LBL_MODULE_NAME_SINGULAR' => 'Műszerfal',
  'LBL_MODULE_TITLE' => 'Műszerfal: Főoldal',
  'LBL_MONTH_BY_OUTCOME_DESC' => 'Megmutatja lehetőségek halmozott összegét a havi eredmény alapján a kiválasztott felhasználóknak, ahol a várható lezárási időpont a megadott dátumtartományon belül van. Eredménye azon alapul, hogy az értékesítési szakasz lezárt és megnyert, lezárt és elvesztett, vagy egyéb állapotú.',
  'LBL_MY_MODULES_USED_SIZE' => 'Hozzáférések száma',
  'LBL_NUMBER_OF_OPPS' => 'Lehetőségek száma',
  'LBL_OPPS_IN_LEAD_SOURCE' => 'lehetőségek, ahol az ajánlás forrása a(z)',
  'LBL_OPPS_IN_STAGE' => 'mikor az értékesítési szint',
  'LBL_OPPS_OUTCOME' => 'ahol a végeredmény',
  'LBL_OPPS_WORTH' => 'lehetőségek értéke',
  'LBL_OPP_SIZE' => 'Lehetőség mérete',
  'LBL_OPP_THOUSANDS' => 'K',
  'LBL_PIPELINE_FORM_TITLE_DESC' => 'Megmutatja a lehetőségek halmozott összegét a kiválasztott értékesítési szakaszok alapján, ahol a várható lezárási időpont a megadott dátumtartományban van.',
  'LBL_REFRESH' => 'Frissítés',
  'LBL_ROLLOVER_DETAILS' => 'Mozgassa a csúszkát a részletek megtekintéséhez!',
  'LBL_ROLLOVER_WEDGE_DETAILS' => 'Mozgassa a sarkot a részletek megjelenítéséhez!',
  'LBL_SALES_STAGES' => 'Eladási szintek:',
  'LBL_SALES_STAGE_FORM_DESC' => 'Megmutatja a lehetőségek halmozott összegét a kiválasztott értékesítési szakaszban, a kiválasztott felhasználókra, ahol a várható lezárási időpont a megadott dátumtartományon belül van.',
  'LBL_SALES_STAGE_FORM_TITLE' => 'Adatcsatorna az eladási szint alapján',
  'LBL_TITLE' => 'Besorolás:',
  'LBL_TOTAL_PIPELINE' => 'Adatcsatorna végösszege',
  'LBL_USERS' => 'Felhasználók:',
  'LBL_YEAR' => 'Év:',
  'LBL_YEAR_BY_OUTCOME' => 'Adatcsatorna a havi eredményesség szerint',
  'LNK_NEW_ACCOUNT' => 'Kliens létrehozása',
  'LNK_NEW_CALL' => 'Hívás naplózása',
  'LNK_NEW_CASE' => 'Eset létrehozása',
  'LNK_NEW_CONTACT' => 'Kapcsolat létrehozása',
  'LNK_NEW_ISSUE' => 'Hiba jelentése',
  'LNK_NEW_LEAD' => 'Ajánlás létrehozása',
  'LNK_NEW_MEETING' => 'Találkozó ütemezése',
  'LNK_NEW_NOTE' => 'Feljegyzés vagy csatolmány létrehozása',
  'LNK_NEW_OPPORTUNITY' => 'Lehetőség létrehozása',
  'LNK_NEW_QUOTE' => 'Árajánlat létrehozása',
  'LNK_NEW_TASK' => 'Feladat létrehozása',
  'NTC_NO_LEGENDS' => 'Nincs',
);

