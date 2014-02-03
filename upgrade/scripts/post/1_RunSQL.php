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
 * Run SQL scripts from $temp_dir/scripts/ relevant to current conversion, e.g.
 * scripts/65x_to_67x_mysql.sql
 */
class SugarUpgradeRunSQL extends UpgradeScript
{
    public $order = 1000;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        $vfrom = $this->implodeVersion($this->from_version, 2);
        $vto = $this->implodeVersion($this->to_version, 2);
        $this->log("Looking for SQL scripts from $vfrom/{$this->from_flavor} to $vto/{$this->to_flavor}");
        if ($vfrom == $vto) {
            if ($this->from_flavor == $this->to_flavor) {
                // minor upgrade, no schema changes
                return;
            } else {
                $script = "{$vfrom}_{$this->from_flavor}_to_{$this->to_flavor}";
            }
        } else {
            $script = "{$vfrom}_to_{$vto}";
        }
        $script .= "_" . $this->db->getScriptName() . ".sql";
        $filename = $this->context['temp_dir'] . "/scripts/$script";
        $this->log("Script name: $script ($filename)");
        if (file_exists($filename)) {
            $this->parseAndExecuteSqlFile($filename);
        }
    }

    protected function parseAndExecuteSqlFile($sqlScript)
    {
        // TODO: resume support?
        $contents = file($sqlScript);
        $anyScriptChanges = $contents;
        $resumeAfterFound = false;
        foreach($contents as $line) {
            if (strpos($line, '--') === false) {
               $completeLine .= " " . trim($line);
               if (strpos($line, ';') !== false) {
                   $query = str_replace(';', '', $completeLine);
                   if ($query != null) {
                       $this->db->query($query);
                   }
                   $completeLine = '';
                }
            }
        } // foreach
    }
}
