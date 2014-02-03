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
 * Removes files that are no longer valid in 7.0 for the Opportunities module.
 */
class SugarUpgradeOpportunityRemoveFiles extends UpgradeScript
{
    public $order = 8501;
    public $type = self::UPGRADE_CORE;

    public function run()
    {

        // we only need to remove these files if the from_version is less than 7.0.0 but greater or equal than 6.7.0
        if (version_compare($this->from_version, '7.0.0', '<')
            && version_compare($this->from_version, '6.7', '>=')
        ) {
            // files to delete
            $files = array(
                'modules/Opportunities/clients/base/views/forecastInspector/forecastInspector.hbt',
                'modules/Opportunities/clients/base/views/forecastInspector/forecastInspector.js',
                'modules/Opportunities/clients/base/views/forecastInspector/forecastInspector.php',
                'modules/Opportunities/Ext/LogicHooks/OpportunitySetCurrencyToBase.php',
            );

            $this->fileToDelete($files);

        }
    }
}
