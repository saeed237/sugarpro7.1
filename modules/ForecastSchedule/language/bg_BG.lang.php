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
  'LBL_EDIT_LAYOUT' => 'Редактиране на подредби',
  'LBL_FORECAST_ID' => 'ID',
  'LBL_QC_COMMIT_VALUE' => 'Commit Amount:',
  'LBL_QC_ROLL_COMMIT_VALUE' => 'Rollup Commit Amount:',
  'LBL_QC_LAST_COMMIT_VALUE' => 'Last Commit Amount:',
  'LBL_OW_MODULE_TITLE' => 'Opportunity Worksheet',
  'LBL_SVFS_HEADER' => 'Forecast Schedule:',
  'LB_FS_KEY' => 'ID',
  'LBL_FS_CASCADE' => 'Cascade?',
  'LBL_COMMIT_HEADER' => 'Forecast Commit',
  'LBL_DV_LAST_COMMIT_AMOUNT' => 'Last Commit Amounts:',
  'LBL_DV_FORECAST_ROLLUP' => 'Forecast Rollup',
  'LBL_DV_TIMPERIOD_DATES' => 'Date Range:',
  'LBL_QC_LAST_BEST_CASE' => 'Last Commit Amount (Best Case):',
  'LBL_QC_LAST_LIKELY_CASE' => 'Last Commit Amount (Likely Case):',
  'LBL_QC_LAST_WORST_CASE' => 'Last Commit Amount (Worst Case):',
  'LBL_QC_ROLL_BEST_VALUE' => 'Rollup Commit Amount (Best Case):',
  'LBL_QC_ROLL_LIKELY_VALUE' => 'Rollup Commit Amount (Likely Case):',
  'LBL_QC_ROLL_WORST_VALUE' => 'Rollup Commit Amount (Worst Case):',
  'LBL_QC_COMMIT_BEST_CASE' => 'Commit Amount (Best Case):',
  'LBL_QC_COMMIT_LIKELY_CASE' => 'Commit Amount (Likely Case):',
  'LBL_QC_COMMIT_WORST_CASE' => 'Commit Amount (Worst Case):',
  'LBL_MODULE_NAME' => 'Планиране',
  'LNK_NEW_OPPORTUNITY' => 'Създаване на възможност',
  'LBL_MODULE_TITLE' => 'Планиране',
  'LBL_LIST_FORM_TITLE' => 'Прогнози',
  'LNK_UPD_FORECAST' => 'Планиране',
  'LNK_QUOTA' => 'Цели',
  'LNK_FORECAST_LIST' => 'Направени прогнози',
  'LBL_FORECAST_HISTORY' => 'Направени прогнози',
  'LBL_FORECAST_HISTORY_TITLE' => 'Направени прогнози',
  'LBL_TIMEPERIOD_NAME' => 'Период',
  'LBL_USER_NAME' => 'Потребител',
  'LBL_REPORTS_TO_USER_NAME' => 'Докладва на',
  'LBL_FORECAST_TIME_ID' => 'Период',
  'LBL_FORECAST_TYPE' => 'Тип',
  'LBL_FORECAST_OPP_COUNT' => 'Възможности',
  'LBL_FORECAST_OPP_WEIGH' => 'Претеглена сума',
  'LBL_FORECAST_OPP_COMMIT' => 'Вероятен сценарий',
  'LBL_FORECAST_OPP_BEST_CASE' => 'Оптимистичен сценарий',
  'LBL_FORECAST_OPP_WORST' => 'Песимистичен сценарий',
  'LBL_FORECAST_USER' => 'Потребител',
  'LBL_DATE_COMMITTED' => 'Направена на',
  'LBL_DATE_ENTERED' => 'Въведено на',
  'LBL_DATE_MODIFIED' => 'Модифицирано на',
  'LBL_CREATED_BY' => 'Създадено от',
  'LBL_DELETED' => 'Изтрити',
  'LBL_QC_TIME_PERIOD' => 'Период:',
  'LBL_QC_OPPORTUNITY_COUNT' => 'Брой възможности:',
  'LBL_QC_WEIGHT_VALUE' => 'Претеглена сума:',
  'LBL_QC_COMMIT_BUTTON' => 'Потвърди',
  'LBL_QC_WORKSHEET_BUTTON' => 'План',
  'LBL_QC_DIRECT_FORECAST' => 'Моите директни прогнози:',
  'LBL_QC_ROLLUP_FORECAST' => 'Моите групови прогнози:',
  'LBL_QC_UPCOMING_FORECASTS' => 'Моите прогнози',
  'LBL_QC_LAST_DATE_COMMITTED' => 'Потвърдена на:',
  'LBL_QC_HEADER_DELIM' => 'До',
  'LBL_OW_OPPORTUNITIES' => 'Свързан с възможност:',
  'LBL_OW_ACCOUNTNAME' => 'Организация',
  'LBL_OW_REVENUE' => 'Сума',
  'LBL_OW_WEIGHTED' => 'Претеглена сума',
  'LBL_OW_PROBABILITY' => 'Вероятност',
  'LBL_OW_NEXT_STEP' => 'Следваща стъпка',
  'LBL_OW_DESCRIPTION' => 'Описание',
  'LBL_OW_TYPE' => 'Тип',
  'LNK_NEW_TIMEPERIOD' => 'Създаване на период',
  'LNK_TIMEPERIOD_LIST' => 'Периоди',
  'LBL_SVFS_FORECASTDATE' => 'Начална дата',
  'LBL_SVFS_STATUS' => 'Статус',
  'LBL_SVFS_USER' => 'За',
  'LBL_SVFS_CASCADE' => 'Обвържи с модул "Справки"?',
  'LBL_FS_TIMEPERIOD_ID' => 'Период',
  'LBL_FS_USER_ID' => 'Потребител',
  'LBL_FS_TIMEPERIOD' => 'Период',
  'LBL_FS_START_DATE' => 'Начална дата',
  'LBL_FS_END_DATE' => 'Крайна дата',
  'LBL_FS_FORECAST_START_DATE' => 'Начална дата',
  'LBL_FS_STATUS' => 'Статус',
  'LBL_FS_FORECAST_FOR' => 'Планиране за:',
  'LBL_FS_MODULE_NAME' => 'Планиране',
  'LBL_FS_CREATED_BY' => 'Създадено от',
  'LBL_FS_DATE_ENTERED' => 'Въведено на',
  'LBL_FS_DATE_MODIFIED' => 'Модифицирано на',
  'LBL_FS_DELETED' => 'Изтрити',
  'LBL_FDR_USER_NAME' => 'Потребител',
  'LBL_FDR_OPPORTUNITIES' => 'Прогнозирани възможности:',
  'LBL_FDR_WEIGH' => 'Претеглена стойност на възможностите:',
  'LBL_FDR_COMMIT' => 'Прогнозирани суми',
  'LBL_FDR_DATE_COMMIT' => 'Дата',
  'LBL_DV_HEADER' => 'Планиране',
  'LBL_DV_MY_FORECASTS' => 'Моите прогнози',
  'LBL_DV_MY_TEAM' => 'Прогнози на моят екип',
  'LBL_DV_TIMEPERIODS' => 'Периоди:',
  'LBL_DV_FORECAST_PERIOD' => 'Период',
  'LBL_DV_FORECAST_OPPORTUNITY' => 'Прогнозирани възможности',
  'LBL_SEARCH' => 'Избери',
  'LBL_SEARCH_LABEL' => 'Избери',
  'LBL_DV_LAST_COMMIT_DATE' => 'Потвърдена на:',
  'LBL_DV_TIMEPERIOD' => 'Период:',
  'LBL_LV_TIMPERIOD' => 'Период',
  'LBL_LV_TIMPERIOD_START_DATE' => 'Начална дата',
  'LBL_LV_TIMPERIOD_END_DATE' => 'Крайна дата',
  'LBL_LV_TYPE' => 'Тип',
  'LBL_LV_COMMIT_DATE' => 'Направена на',
  'LBL_LV_OPPORTUNITIES' => 'Възможности',
  'LBL_LV_WEIGH' => 'Претеглена сума',
  'LBL_LV_COMMIT' => 'Прогнозирани суми',
  'LBL_COMMIT_NOTE' => 'Въведете суми, които да зададете като прогноза за избран период:',
  'LBL_COMMIT_MESSAGE' => 'Искате ли да потвърдите тези суми?',
  'ERR_FORECAST_AMOUNT' => 'При потвърждение сумата е задължителна и следва да е число.',
  'LBL_FC_START_DATE' => 'Начална дата',
  'LBL_FC_USER' => 'Планиране за',
  'LBL_NO_ACTIVE_TIMEPERIOD' => 'Не са намерени активни периоди за модул прогнози.',
  'LBL_FDR_ADJ_AMOUNT' => 'Коригирана сума',
  'LBL_SAVE_WOKSHEET' => 'Запази плана',
  'LBL_RESET_WOKSHEET' => 'Изтрий плана',
  'LBL_RESET_CHECK' => 'Всички данни за избрания период на текущия потребител ще бъдат изтрити. Желаете ли да продължите?',
  'LB_FS_LIKELY_CASE' => 'Вероятен сценарий',
  'LB_FS_WORST_CASE' => 'Песимистичен сценарий',
  'LB_FS_BEST_CASE' => 'Оптимистичен сценарий',
  'LBL_FDR_WK_LIKELY_CASE' => 'Вероятен сценарий (∑)',
  'LBL_FDR_WK_BEST_CASE' => 'Оптимистичен сценарий (∑)',
  'LBL_FDR_WK_WORST_CASE' => 'Песимистичен сценарий (∑)',
  'LBL_BEST_CASE' => 'Оптимистичен сценарий:',
  'LBL_LIKELY_CASE' => 'Вероятен сценарий:',
  'LBL_WORST_CASE' => 'Песимистичен сценарий:',
  'LBL_FDR_C_BEST_CASE' => 'Оптимистичен сценарий',
  'LBL_FDR_C_WORST_CASE' => 'Песимистичен сценарий',
  'LBL_FDR_C_LIKELY_CASE' => 'Вероятен сценарий',
);

