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

/**
 * Update connectors & refresh connector metadata files
 */
class SugarUpgradeConnectors extends UpgradeScript
{
    public $order = 7000;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        require_once('include/connectors/utils/ConnectorUtils.php');
        if(!ConnectorUtils::updateMetaDataFiles()) {
            $this->log('Cannot update metadata files for connectors');
        }

        //Delete the custom connectors.php file if it exists so that it may be properly rebuilt
        if(file_exists('custom/modules/Connectors/metadata/connectors.php'))
        {
            unlink('custom/modules/Connectors/metadata/connectors.php');
        }
    }
}
