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

require_once 'modules/UpgradeWizard/UpgradeDriver.php';

/**
 * Test upgrader class
 *
 * Used for unit tests on upgrader
 */
class TestUpgrader extends UpgradeDriver
{
    /**
     * List of upgrade scripts
     * @var string
     */
    protected $scripts = array();

    public function __construct($admin)
    {
        $context = array(
            "admin" => $admin->user_name,
            "log" => "cache/upgrade.log",
            "source_dir" => realpath(dirname(__FILE__)."/../../"),
        );
        parent::__construct($context);
    }

    public function cleanState()
    {
        $statefile = $this->cacheDir('upgrades/').self::STATE_FILE;
        if(file_exists($statefile)) {
            unlink($statefile);
        }
    }

    public function runStage($stage)
    {
        return $this->run($stage);
    }

    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * Get script object for certain script
     * @param string $stage
     * @param string $script
     * @return UpgradeScript
     */
    public function getScript($stage, $script)
    {
        if(empty($this->scripts[$stage])) {
            $this->scripts[$stage] = $this->getScripts(dirname($script), $stage);
        }
        return $this->scripts[$stage][$script];
    }

    public function getTempDir()
    {
        if (empty($this->context['temp_dir'])) {
            $this->context['temp_dir'] = '';
        }
        return $this->context['temp_dir'];
    }

    public function setVersions($from, $flav_from, $to, $flav_to)
    {
        $this->from_version = $from;
        $this->from_flavor = $flav_from;
        $this->to_version = $to;
        $this->to_flavor = $flav_to;
    }
}
