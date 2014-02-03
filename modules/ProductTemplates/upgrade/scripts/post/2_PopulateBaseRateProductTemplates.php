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

class SugarUpgradePopulateBaseRateProductTemplates extends UpgradeScript
{
    public $order = 2200;
    public $type = self::UPGRADE_DB;
    public $table = 'product_templates';

    /**
     * Run the Upgrade Task
     *
     * initialize the base_rate field
     */
    public function run()
    {
        // only run this when coming from a 6.x upgrade
        if (!version_compare($this->from_version, '7.0.0', "<")) {
            return;
        }

        $this->log('Populating base_rate value from conversion_rate.');

        // first set base currencies to 1.0
        $sql = "update {$this->table} set base_rate = 1.0 where currency_id = '-99'";
        $this->db->query($sql);

        $sql = "update {$this->table}
               set base_rate = (
               select currencies.conversion_rate
                 from currencies
                where currencies.id = {$this->table}.currency_id
              )
               where {$this->table}.base_rate IS NULL and exists (
               select *
                 from currencies
                where currencies.id = {$this->table}.currency_id
              )";
        $this->db->query($sql);

        $this->log('Done populating base_rate value from conversion_rate.');
    }
}
