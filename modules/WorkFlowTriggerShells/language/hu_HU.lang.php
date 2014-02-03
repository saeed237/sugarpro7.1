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
  'LBL_ALERT_TEMPLATES' => 'Riasztási sablonok',
  'LBL_APOSTROPHE_S' => ' ',
  'LBL_COMPARE_ANY_TIME_PART2' => 'nem változik',
  'LBL_COMPARE_ANY_TIME_PART3' => 'meghatározott ideig',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'A mező nem változik egy meghatározott ideig',
  'LBL_COMPARE_CHANGE_PART' => 'változik',
  'LBL_COMPARE_CHANGE_TITLE' => 'Amikor egy mező a célmodulon megváltozik',
  'LBL_COMPARE_COUNT_TITLE' => 'Indítás a meghatározott számlálónál',
  'LBL_COMPARE_SPECIFIC_PART' => 'átvált egy meghatározott értékről vagy egy meghatározott értékre',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => ' ',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'Amikor egy mező a célmodulban átvált egy meghatározott értékről vagy egy meghatározott értékre',
  'LBL_COUNT_TRIGGER1' => 'Összesen',
  'LBL_COUNT_TRIGGER1_2' => 'összehasonlítva ezzel az összeggel',
  'LBL_COUNT_TRIGGER2' => 'Szűrés kapcsolódás alapján',
  'LBL_COUNT_TRIGGER2_2' => 'csak',
  'LBL_COUNT_TRIGGER3' => 'szűrés kimondottan a következő szerint',
  'LBL_COUNT_TRIGGER4' => 'másodlagos szűrés',
  'LBL_EVAL' => 'Indítás értékelés:',
  'LBL_FIELD' => 'Mező',
  'LBL_FILTER_FIELD_PART1' => 'Szűrés ... szerint:',
  'LBL_FILTER_FIELD_TITLE' => 'Amikor a célmodul tartalmaz egy meghatározott értéket',
  'LBL_FILTER_FORM_TITLE' => 'Adjon meg egy munkafolyamat feltételt',
  'LBL_FILTER_LIST_STATEMEMT' => 'Szűrés a követkő feltételek alapján:',
  'LBL_FILTER_REL_FIELD_PART1' => 'Adja meg a kapcsolódó',
  'LBL_FILTER_REL_FIELD_TITLE' => 'Amikor a cél modul megváltozik és egy mező egy kapcsolódó modulban tartalmaz egy meghatározott értéket',
  'LBL_FUTURE_TRIGGER' => 'Adja meg az új',
  'LBL_LIST_EVAL' => 'Értékelés:',
  'LBL_LIST_FIELD' => 'Mező:',
  'LBL_LIST_FORM_TITLE' => 'Indításlista',
  'LBL_LIST_FRAME_PRI' => 'Indítás:',
  'LBL_LIST_FRAME_SEC' => 'Szűrő:',
  'LBL_LIST_NAME' => 'Leírás:',
  'LBL_LIST_STATEMEMT' => 'Indítás a következő esemény alapján:',
  'LBL_LIST_TYPE' => 'Típus:',
  'LBL_LIST_VALUE' => 'Érték:',
  'LBL_MODULE' => 'modul',
  'LBL_MODULE_NAME' => 'Feltételek',
  'LBL_MODULE_NAME_SINGULAR' => 'Kondíció',
  'LBL_MODULE_SECTION_TITLE' => 'Amikor ezek a feltételek teljesülnek',
  'LBL_MODULE_TITLE' => 'Munkafolyamat indító: Főoldal',
  'LBL_MUST_SELECT_VALUE' => 'Válasszon értéket ennek a mezőnek',
  'LBL_NAME' => 'Indító neve:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'Új szűrő létrehozása',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'Új szűrő létrehozása',
  'LBL_NEW_FORM_TITLE' => 'Új indító létrehozása',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'Új indító létrehozása',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'Új indító létrehozása',
  'LBL_PAST_TRIGGER' => 'Adja meg a régi',
  'LBL_RECORD' => 'modulé',
  'LBL_SEARCH_FORM_TITLE' => 'Munkafolyamat indító kereső',
  'LBL_SELECT_1ST_FILTER' => 'Válasszon ki egy érvényes elsődleges szűrőmezőt',
  'LBL_SELECT_2ND_FILTER' => 'Válasszon ki egy érvényes másodlagos szűrőmezőt',
  'LBL_SELECT_AMOUNT' => 'Válassza ki az összeget',
  'LBL_SELECT_OPTION' => 'Kérem, válasszon ki egy lehetőséget!',
  'LBL_SELECT_TARGET_FIELD' => 'Kérem, válasszon egy célterületet!',
  'LBL_SELECT_TARGET_MOD' => 'Kérem, válasszon egy célmodulhoz kapcsolódó modult!',
  'LBL_SHOW' => 'Mutat',
  'LBL_SHOW_PAST' => 'Korábbi érték módosítása:',
  'LBL_SPECIFIC_FIELD' => 'által meghatározott mező',
  'LBL_SPECIFIC_FIELD_LNK' => 'speciális mező',
  'LBL_TRIGGER' => 'Amikor',
  'LBL_TRIGGER_FILTER_TITLE' => 'Indító szűrők',
  'LBL_TRIGGER_FORM_TITLE' => 'Adjon meg egy feltételt a munkafolyamat végrehajtásához',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'Amikor a célmodul változik',
  'LBL_TYPE' => 'Típus:',
  'LBL_VALUE' => 'érték',
  'LBL_WHEN_VALUE1' => 'Ha a mező értéke',
  'LBL_WHEN_VALUE2' => 'Ha az értéke',
  'LNK_NEW_TRIGGER' => 'Új indító létrehozása',
  'LNK_NEW_WORKFLOW' => 'Munkafolyamat létrehozása',
  'LNK_TRIGGER' => 'Munkafolyamat indítók',
  'LNK_WORKFLOW' => 'Munkafolyamat tárgyai',
  'NTC_REMOVE_TRIGGER' => 'Biztosan el akarja távolítani ezt az indítót?',
);

