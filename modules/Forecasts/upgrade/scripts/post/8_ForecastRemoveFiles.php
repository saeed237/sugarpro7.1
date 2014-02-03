<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */
/**
 * Removes files that are no longer valid in 7.0 fore the forecast module.
 */
class SugarUpgradeForecastRemoveFiles extends UpgradeScript
{
    public $order = 8501;
    public $type = self::UPGRADE_CORE;

    public function run()
    {

        // we only need to remove these files if the from_version is less than 7.0.0 but greater or equal than 6.7.0
        if (version_compare($this->from_version, '7.0', '<')
            && version_compare($this->from_version, '6.7', '>=')
        ) {
            // files to delete
            $files = array(
                'modules/Forecasts/clients/base/fields/bool/forecastSchedule.hbt',
                'modules/Forecasts/clients/base/fields/bool/forecastsWorksheet.hbt',
                'modules/Forecasts/clients/base/fields/commitStage/bool.hbt',
                'modules/Forecasts/clients/base/fields/commitStage/commitStage.js',
                'modules/Forecasts/clients/base/fields/commitStage/default.hbt',
                'modules/Forecasts/clients/base/fields/commitStage/enum.hbt',
                'modules/Forecasts/clients/base/fields/editableCurrency/detail.hbt',
                'modules/Forecasts/clients/base/fields/editableCurrency/edit.hbt',
                'modules/Forecasts/clients/base/fields/editableCurrency/editableCurrency.js',
                'modules/Forecasts/clients/base/fields/editableDate/default.hbt',
                'modules/Forecasts/clients/base/fields/editableDate/detail.hbt',
                'modules/Forecasts/clients/base/fields/editableDate/edit.hbt',
                'modules/Forecasts/clients/base/fields/editableDate/editableDate.js',
                'modules/Forecasts/clients/base/fields/editableEnum/detail.hbt',
                'modules/Forecasts/clients/base/fields/editableEnum/edit.hbt',
                'modules/Forecasts/clients/base/fields/editableEnum/editableEnum.js',
                'modules/Forecasts/clients/base/fields/editableInt/detail.hbt',
                'modules/Forecasts/clients/base/fields/editableInt/edit.hbt',
                'modules/Forecasts/clients/base/fields/editableInt/editableInt.js',
                'modules/Forecasts/clients/base/fields/enum/forecastSchedule.hbt',
                'modules/Forecasts/clients/base/fields/enum/forecastsChartOptions.hbt',
                'modules/Forecasts/clients/base/fields/enum/forecastsWorksheet.hbt',
                'modules/Forecasts/clients/base/fields/historyLog/detail.hbt',
                'modules/Forecasts/clients/base/fields/historyLog/historyLog.js',
                'modules/Forecasts/clients/base/fields/inspector/detail.hbt',
                'modules/Forecasts/clients/base/fields/inspector/inspector.js',
                'modules/Forecasts/clients/base/fields/recordLink/recordLink.hbt',
                'modules/Forecasts/clients/base/fields/recordLink/recordLink.js',
                'modules/Forecasts/clients/base/fields/userLink/detail.hbt',
                'modules/Forecasts/clients/base/fields/userLink/userLink.js',
                'modules/Forecasts/clients/base/layouts/info/info.hbt',
                'modules/Forecasts/clients/base/layouts/info/info.js',
                'modules/Forecasts/clients/base/layouts/info/info.php',
                'modules/Forecasts/clients/base/layouts/inspector/inspector.js',
                'modules/Forecasts/clients/base/layouts/records/records_old.hbt',
                'modules/Forecasts/clients/base/layouts/records/records_old.js',
                'modules/Forecasts/clients/base/views/forecastsCommitButtons/forecastsCommitButtons.hbt',
                'modules/Forecasts/clients/base/views/forecastsCommitButtons/forecastsCommitButtons.js',
                'modules/Forecasts/clients/base/views/forecastsCommitButtons/forecastsCommitButtons.php',
                'modules/Forecasts/clients/base/views/forecastsCommitLog/forecastsCommitLog.hbt',
                'modules/Forecasts/clients/base/views/forecastsCommitLog/forecastsCommitLog.js',
                'modules/Forecasts/clients/base/views/forecastsCommitLog/forecastsCommitLog.php',
                'modules/Forecasts/clients/base/views/forecastsCommitted/forecastsCommitted.hbt',
                'modules/Forecasts/clients/base/views/forecastsCommitted/forecastsCommitted.js',
                'modules/Forecasts/clients/base/views/forecastsCommitted/forecastsCommitted.php',
                'modules/Forecasts/clients/base/views/forecastsProgress/forecastsProgress.hbt',
                'modules/Forecasts/clients/base/views/forecastsProgress/forecastsProgress.js',
                'modules/Forecasts/clients/base/views/forecastsProgress/forecastsProgress.php',
                'modules/Forecasts/clients/base/views/forecastsTimeperiod/forecastsTimeperiod.hbt',
                'modules/Forecasts/clients/base/views/forecastsTimeperiod/forecastsTimeperiod.js',
                'modules/Forecasts/clients/base/views/forecastsTimeperiod/forecastsTimeperiod.php',
                'modules/Forecasts/clients/base/views/forecastsFilter/forecastsFilter.hbt',
                'modules/Forecasts/clients/base/views/forecastsFilter/forecastsFilter.js',
                'modules/Forecasts/clients/base/views/forecastsFilter/forecastsFilter.php',
                'modules/Forecasts/clients/base/views/forecastsTitle/forecastsTitle.hbt',
                'modules/Forecasts/clients/base/views/forecastsTitle/forecastsTitle.js',
                'modules/Forecasts/clients/base/views/forecastsTree/forecastsTree.hbt',
                'modules/Forecasts/clients/base/views/forecastsTree/forecastsTree.js',
                'modules/Forecasts/clients/base/views/forecastsTree/forecastsTree.php',
                'modules/Forecasts/clients/base/views/forecastsWorksheet/forecastsWorksheet.hbt',
                'modules/Forecasts/clients/base/views/forecastsWorksheet/forecastsWorksheet.js',
                'modules/Forecasts/clients/base/views/forecastsWorksheet/forecastsWorksheet.php',
                'modules/Forecasts/clients/base/views/forecastsWorksheetManager/forecastsWorksheetManager.hbt',
                'modules/Forecasts/clients/base/views/forecastsWorksheetManager/forecastsWorksheetManager.js',
                'modules/Forecasts/clients/base/views/forecastsWorksheetManager/forecastsWorksheetManager.php',
                'modules/Forecasts/clients/base/views/forecastsWorksheetManagerTotals/forecastsWorksheetManagerTotals.hbt',
                'modules/Forecasts/clients/base/views/forecastsWorksheetManagerTotals/forecastsWorksheetManagerTotals.js',
                'modules/Forecasts/clients/base/views/forecastsWorksheetManagerTotals/forecastsWorksheetManagerTotals.php',
                'modules/Forecasts/clients/base/views/forecastsWorksheetTotals/forecastsWorksheetTotals.hbt',
                'modules/Forecasts/clients/base/views/forecastsWorksheetTotals/forecastsWorksheetTotals.js',
                'modules/Forecasts/clients/base/views/forecastsWorksheetTotals/forecastsWorksheetTotals.php',
                'clients/base/layouts/inspector',
                'clients/base/views/inspector-header'
            );

            $this->fileToDelete($files);
        }
    }
}
