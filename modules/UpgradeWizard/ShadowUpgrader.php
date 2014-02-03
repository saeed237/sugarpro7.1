<?php
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
require_once 'CliUpgrader.php';

class ShadowUpgrader extends CliUpgrader
{
    protected $options = array(
            // required, short, long
            'pre_template' => array(true, 'f', 'from'),
            'post_template' => array(true, 't', 'to'),
            "source_dir" => array(true, 's', 'source'),
            "zip" => array(true, 'z', 'zip'),
            "log" => array(true, 'l', 'log'),
            "admin" => array(true, 'u', 'user'),
            "backup" => array(false, 'b', 'backup'),
            "script_mask" => array(false, 'm', 'mask'),
            "stage" => array(false, 'S', 'stage'),
    );

    protected function commit()
    {
        // commit doesn't do anything
        return true;
    }

    protected static function usage()
    {
		list($version, $build) = static::getVersion();
    	$usage =<<<eoq2
Shadow Upgrader v.$version (build $build)
php ShadowUpgrader.php -f oldTemplate -t newTemplate -s pathToSugarInstance -z zip -l logFile -u admin-user

Example:
    php ShadowUpgrader.php -f /sugar/templates/7.0.0 -t /sugar/templates/7.1.0 path-to-sugar-instance/ \
    	    -z SugarEnt-Upgrade-7.0.x-to-7.1.0.zip -l silentupgrade.log -u admin

Arguments:
    -f/--from oldTemplate                : Pre-upgrade template
    -t/--to newTemplate                  : Target template
    -s/--source pathToSugarInstance      : Sugar instance being upgraded.
    -z/--zip upgrade.zip                 : Upgrade package file.
    -l/--log logFile                     : Upgarde log file (by default relative to instance dir)
    -u/--user admin-user                 : admin user performing the upgrade
Optional arguments:
    -m/--mask scriptMask                 : Script mask - which types of scripts to run.
                                           Supported types: db, custom, none. Default is db,custom.
    -b/--backup 0/1                      : Create backup of deleted files? 0 means no backup, default is 1.
    -S/--stage stage                     : Run specific stage of the upgrader. 'continue' means start where it stopped last time.

eoq2;
    	echo $usage;
    }

    protected function verifyArguments()
    {
        if(!function_exists("shadow")) {
            $this->argError("Shadow module should be installed to run this script.");
        }

        if(empty($this->context['source_dir']) || !is_dir($this->context['source_dir'])) {
            $this->argError("Source dir parameter must be a valid directory.");
        }

        if(empty($this->context['pre_template']) || empty($this->context['post_template'])) {
            $this->argError("Templates should be specified");
        }

        if(!is_file("{$this->context['pre_template']}/include/entryPoint.php")) {
            $this->argError("{$this->context['pre_template']} is not a SugarCRM template.");
        }

        if(!is_file("{$this->context['post_template']}/include/entryPoint.php")) {
            $this->argError("{$his->context['post_template']} is not a SugarCRM template.");
        }

        if(!is_file("{$this->context['source_dir']}/config.php")) {
            $this->argError("{$this->context['source_dir']} is not a SugarCRM directory.");
        }

    	return true;
    }

    /**
     * Fix values in the context
     * @param array $context
     * @return array
     */
    public function fixupContext($context)
    {
        $context = parent::fixupContext($context);
        $context['pre_template'] = realpath($context['pre_template']);
        $context['post_template'] = realpath($context['post_template']);
        // only use custom and DB scripts
        if(isset($context['script_mask'])) {
            $context['script_mask'] &= UpgradeScript::UPGRADE_CUSTOM|UpgradeScript::UPGRADE_DB;
        } else {
            $context['script_mask'] = UpgradeScript::UPGRADE_CUSTOM|UpgradeScript::UPGRADE_DB;
        }
        return $context;
    }

    protected function initSugar()
    {
        if($this->context['stage'] == 'pre' || $this->context['stage'] == 'unpack') {
            $templ_dir = $this->context['pre_template'];
        } else {
            $templ_dir = $this->context['post_template'];
        }
        chdir($templ_dir);
        $this->log("Shadow configuration: $templ_dir -> {$this->context['source_dir']}");
        shadow($templ_dir, $this->context['source_dir'], array("cache", "upload", "config.php"));
        $this->context['source_dir'] = $templ_dir;
        return parent::initSugar();
    }
}

if(empty($argv[0]) || basename($argv[0]) != basename(__FILE__)) return;

$sapi_type = php_sapi_name();
if (substr($sapi_type, 0, 3) != 'cli') {
    die("This is command-line only script");
}
ShadowUpgrader::start();


